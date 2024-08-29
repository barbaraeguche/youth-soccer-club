use pnc353_1;

-- trigger to ensure it's gender segregated
drop trigger if exists gender_mismatch;
delimiter //
    create trigger gender_mismatch
        before insert on MemberGame
        for each row
    begin
        select gender into @memberGender
        from ClubMember as clubMem
        where clubMem.clubID = new.clubID;

        select teamGender into @teamGender
        from TeamFormation as teamForm
        where teamForm.teamID = new.teamID;

        if @memberGender <> @teamGender then
            signal sqlstate '45000'
                set message_text = 'Gender mismatch: Club member\'s gender must match the team\'s gender.';
        end if;
    end//
delimiter ;


-- trigger to ensure no player can be assigned to two teams less than 3hrs apart
drop trigger if exists team_formation_time;
delimiter //
    create trigger team_formation_time
        before insert on MemberGame
        for each row
    begin
        select eventDate, eventTime into @EventDate, @EventTime
        from TeamFormation as teamForm
        where teamForm.teamID = new.teamID;
        if exists (
            select *
            from MemberGame as memGame
                join TeamFormation as teamForm on memGame.teamID = teamForm.teamID
            where memGame.clubID = new.clubID
                and teamForm.eventDate = @EventDate
                and abs(time_to_sec(timediff(teamForm.eventTime, @EventTime)) / 3600) < 3
        ) then
            signal sqlstate '45000'
                set message_text = 'A club member cannot be assigned to another team formation on the same day, less than three hours apart.';
        end if;
    end//
delimiter ;


-- trigger to ensure club members are between 4 and 10
drop trigger if exists age_at_time_of_registration;
delimiter //
    create trigger age_at_time_of_registration
        before insert on ClubMember
        for each row
    begin
        if floor(datediff(now(), new.dateOfBirth) / 365) < 4 OR floor(datediff(now(), new.dateOfBirth) / 365) > 10 then
            signal sqlstate '45000'
                set message_text = 'Club member must be between age 4 and 10 years at the time of registry';
        end if;
    end//
delimiter ;


-- event to send email every week
drop procedure if exists emailFunction;
delimiter //
    create procedure emailFunction()
    begin
        declare num_rows int;
        declare counter int default 0;

        create temporary table TempEmails as
        select
            memGame.clubID, memGame.teamID, memGame.position,
            clubMem.firstName as memberFirstName, clubMem.lastName as memberLastName,
            teamForm.gameOrTraining, teamForm.eventDate, teamForm.eventTime, teamForm.eventAddress, teamForm.teamName, teamForm.headCoachID,
            perso.firstName as coachFirstName, perso.lastName as coachLastName, perso.email as coachEmail, loc.name as locationName
        from MemberGame memGame
            join ClubMember as clubMem on memGame.clubID = clubMem.clubID
            join TeamFormation as teamForm on memGame.teamID = teamForm.teamID
            join Personnel as perso on teamForm.headCoachID = perso.personnelID
            join Location as loc on teamForm.teamLocationID = loc.locationID
        where teamForm.eventDate between current_date() and current_date() + interval 7 day;

        select count(*) into num_rows from TempEmails;

        while counter < num_rows do
            select clubID, teamID, position, memberFirstName, memberLastName,
                gameOrTraining, eventDate, eventTime, eventAddress, teamName, coachFirstName, coachLastName, coachEmail, locationName
            into @clubID, @teamID, @position, @memberFirstName, @memberLastName,
                @gameOrTraining, @dateOfEvent, @timeOfEvent, @addressOfEvent, @teamName, @coachFirstName, @coachLastName, @coachEmail, @locationName
            from TempEmails
            limit counter, 1;

            set @emailSubject = concat(@teamName, ' ', date_format(@dateOfEvent, '%W %d-%b-%Y'), ' ', time_format(@timeOfEvent, '%h:%i %p'), ' ', @gameOrTraining, ' session');
            set @emailBody = concat('Dear ', @memberFirstName, ' ', @memberLastName, ',\n\nYou have been assigned as a ', @position, ' in the upcoming ', @gameOrTraining, ' session.\n\nSession Details:\nDate: ', date_format(@dateOfEvent, '%W %d-%b-%Y'), '\nTime: ', time_format(@timeOfEvent, '%h:%i %p'), '\nAddress: ', @addressOfEvent, '\n\nHead Coach info:\nName: ', @coachFirstName, ' ', @coachLastName, '\nEmail: ', @coachEmail, '\n\nBest of luck!,\nThe YSC Club');
            insert into EmailLog(emailDate, senderName, receiverEmail, emailSubject, emailBodyPreview)
            values ('2024-08-04', @locationName, concat(@memberFirstName, ' ', @memberLastName), @emailSubject, left(@emailBody, 100));
            set counter = counter + 1;
        end while;

        drop temporary table TempEmails;
    end//
delimiter ;

drop event if exists weeklyEmailEvent;
create event weeklyEmailEvent
    on schedule every 1 week
        starts '2024-06-04 00:00:00'
    enable
    do
    call emailFunction();