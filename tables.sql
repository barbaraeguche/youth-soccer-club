create database if not exists pnc353_1;
use pnc353_1;

-- create required tables
create table if not exists Location (
    locationID int primary key auto_increment,
    name tinytext not null,
    address tinytext not null,
    postalCode char(6) not null,
    telNumber char(10) not null,
    webAddress text not null,
    type enum('head', 'branch') not null,
    capacity smallint not null
);

create table if not exists Personnel (
    personnelID int primary key auto_increment,
    firstName tinytext not null,
    lastName tinytext not null,
    dateOfBirth date not null,
    SSN char(9) unique not null,
    medicareNum char(12) unique not null,
    telNumber char(10) not null,
    address tinytext not null,
    postalCode char(6) not null,
    email tinytext not null,
    role enum('administrator', 'trainer', 'other') not null,
    mandate enum('volunteer', 'salaried') not null
);
create table if not exists PersonnelLocation (
    personnelLocationID int primary key auto_increment,
    personnelID int not null,
    locationID int not null,
    startDate date not null,
    endDate date
);

create table if not exists FamilyMember (
    familyID int primary key auto_increment,
    firstName tinytext not null,
    lastName tinytext not null,
    dateOfBirth date not null,
    SSN char(9) unique not null,
    medicareNum char(12) unique not null,
    telNumber char(10) not null,
    address tinytext not null,
    postalCode char(6) not null,
    email tinytext not null,
    secondaryFamilyID int
);
create table if not exists FamilyLocation (
    familyLocationID int primary key auto_increment,
    familyID int not null,
    locationID int not null,
    startDate date not null,
    endDate date
);

create table if not exists SecondaryFamily (
    secondaryID int primary key auto_increment,
    primaryFamilyID int not null,
    firstName tinytext not null,
    lastName tinytext not null,
    telNumber char(10) not null
);
create table if not exists SecondaryFamilyAssociation (
    secondaryAssociationID int primary key auto_increment,
    clubID int not null,
    secondaryID int not null,
    relationship enum('father', 'mother', 'grandfather', 'grandmother', 'tutor', 'partner', 'friend', 'other') not null
);

create table if not exists ClubMember (
    clubID int primary key auto_increment,
    firstName tinytext not null,
    lastName tinytext not null,
    gender enum('male', 'female') not null,
    dateOfBirth date not null,
    SSN char(9) unique not null,
    medicareNum char(12) unique not null,
    telNumber char(10) not null,
    address tinytext not null,
    postalCode char(6) not null,
    associatedFamilyMemberID int not null
);
create table if not exists ClubLocation (
    clubLocationID int primary key auto_increment,
    clubID int not null,
    locationID int not null,
    startDate date not null,
    endDate date
);
create table if not exists FamilyAssociation (
    associationID int primary key auto_increment,
    clubID int not null,
    familyID int not null,
    relationship enum('father', 'mother', 'grandfather', 'grandmother', 'tutor', 'partner', 'friend', 'other') not null
);

create table if not exists TeamFormation (
    teamID int primary key auto_increment,
    gameOrTraining enum('game', 'training') not null,
    teamLocationID int not null,
    teamName tinytext not null,
    headCoachID int not null,
    numOfGoalKeepers enum('one', 'many' ) not null,
    numOfDefenders enum('zero' , 'one', 'many' ) not null,
    numOfMidfielders enum('one', 'many' ) not null,
    numOfForwards enum('zero' , 'one', 'many' ) not null,
    eventDate date not null,
    eventTime time not null,
    teamScore int,
    eventAddress tinytext not null,
    teamGender enum('male', 'female') not null,
    winFlag enum('win', 'lose'),
    opponentID int
);
create table if not exists MemberGame (
    memberGameID int primary key auto_increment,
    clubID int not null,
    teamID int not null,
    position enum('goalkeeper', 'defender', 'midfielder', 'forward') not null
);

-- needed by not inserting
create table if not exists PostalAddress (
    postalCode char(6) not null,
    city tinytext not null,
    province enum('AB', 'BC', 'MB', 'NB', 'NL', 'NT', 'NS', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT') not null
);
create table if not exists EmailLog (
    logID int primary key auto_increment,
    emailDate datetime not null,
    senderName tinytext not null,
    receiverEmail tinytext not null,
    emailSubject tinytext not null,
    emailBodyPreview tinytext not null
);

-- ------------------------ adding foreign keys & checks ------------------------ --
alter table PersonnelLocation add constraint PersonnelLocation_ibfk_1 foreign key (personnelID) references Personnel(personnelID) on delete cascade;
alter table PersonnelLocation add constraint PersonnelLocation_ibfk_2 foreign key (locationID) references Location(locationID) on delete cascade;
alter table PersonnelLocation add constraint PersonnelLocation_chk_1 check (startDate < endDate or endDate is null);

alter table FamilyLocation add constraint FamilyLocation_ibfk_1 foreign key (familyID) references FamilyMember(familyID) on delete cascade;
alter table FamilyLocation add constraint FamilyLocation_ibfk_2 foreign key (locationID) references Location(locationID) on delete cascade;
alter table FamilyLocation add constraint FamilyLocation_chk_1 check (startDate < endDate or endDate is null);

alter table SecondaryFamily add constraint SecondaryFamily_ibfk_1 foreign key (primaryFamilyID) references FamilyMember(familyID) on delete cascade;
alter table SecondaryFamilyAssociation add constraint SecondaryFamilyAssociation_ibfk_1 foreign key (clubID) references ClubMember(clubID) on delete cascade;
alter table SecondaryFamilyAssociation add constraint SecondaryFamilyAssociation_ibfk_2 foreign key (secondaryID) references SecondaryFamily(secondaryID) on delete cascade;

alter table ClubMember add constraint ClubMember_ibfk_1 foreign key (associatedFamilyMemberID) references FamilyMember(familyID) on delete cascade;
alter table ClubLocation add constraint ClubLocation_ibfk_1 foreign key (clubID) references ClubMember(clubID) on delete cascade;
alter table ClubLocation add constraint ClubLocation_ibfk_2 foreign key (locationID) references Location(locationID) on delete cascade;
alter table ClubLocation add constraint ClubLocation_chk_1 check (startDate < endDate or endDate is null);
alter table FamilyAssociation add constraint FamilyAssociation_ibfk_1 foreign key (clubID) references ClubMember(clubID) on delete cascade;
alter table FamilyAssociation add constraint FamilyAssociation_ibfk_2 foreign key (familyID) references FamilyMember(familyID) on delete cascade;

alter table TeamFormation add constraint TeamFormation_ibfk_1 foreign key (headCoachID) references Personnel(personnelID) on delete cascade;
alter table TeamFormation add constraint TeamFormation_ibfk_2 foreign key (teamLocationID) references Location(locationID) on delete cascade;
alter table MemberGame add constraint MemberGame_ibfk_1 foreign key (clubID) references ClubMember(clubID) on delete cascade;
alter table MemberGame add constraint MemberGame_ibfk_2 foreign key (teamID) references TeamFormation(teamID) on delete cascade;

-- ------------------------ dropping foreign keys ------------------------ --
# alter table PersonnelLocation drop foreign key PersonnelLocation_ibfk_1;
# alter table PersonnelLocation drop foreign key PersonnelLocation_ibfk_2;
# alter table PersonnelLocation drop check PersonnelLocation_chk_1;
#
# alter table FamilyLocation drop foreign key FamilyLocation_ibfk_1;
# alter table FamilyLocation drop foreign key FamilyLocation_ibfk_2;
# alter table FamilyLocation drop check FamilyLocation_chk_1;
#
# alter table SecondaryFamily drop foreign key SecondaryFamily_ibfk_1;
# alter table SecondaryFamilyAssociation drop foreign key SecondaryFamilyAssociation_ibfk_1;
# alter table SecondaryFamilyAssociation drop foreign key SecondaryFamilyAssociation_ibfk_2;
#
# alter table ClubMember drop foreign key ClubMember_ibfk_1;
# alter table ClubLocation drop foreign key ClubLocation_ibfk_1;
# alter table ClubLocation drop foreign key ClubLocation_ibfk_2;
# alter table ClubLocation drop check ClubLocation_chk_1;
# alter table FamilyAssociation drop foreign key FamilyAssociation_ibfk_1;
# alter table FamilyAssociation drop foreign key FamilyAssociation_ibfk_2;
#
# alter table TeamFormation drop foreign key TeamFormation_ibfk_1;
# alter table TeamFormation drop foreign key TeamFormation_ibfk_2;
# alter table MemberGame drop foreign key MemberGame_ibfk_1;
# alter table MemberGame drop foreign key MemberGame_ibfk_2;

-- ------------------------ dropping tables ------------------------ --
# drop table if exists Location;
# drop table if exists Personnel;
# drop table if exists PersonnelLocation;
# drop table if exists FamilyMember;
# drop table if exists FamilyLocation;
# drop table if exists SecondaryFamily;
# drop table if exists SecondaryFamilyAssociation;
# drop table if exists ClubMember;
# drop table if exists ClubLocation;
# drop table if exists FamilyAssociation;
# drop table if exists TeamFormation;
# drop table if exists MemberGame;
# drop table if exists PostalAddress;
# drop table if exists EmailLog;