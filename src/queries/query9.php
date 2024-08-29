<?php require_once '../database.php';

$query = "
	SELECT TeamFormation.eventDate, TeamFormation.eventTime, Personnel.firstName AS 'HC FN', Personnel.lastName AS 'HC LN', TeamFormation.gameOrTraining, 
	    TeamFormation.teamName, TeamFormation.teamScore, ClubMember.firstName, ClubMember.lastName, MemberGame.position, TeamFormation.eventAddress
	FROM Personnel, TeamFormation, ClubMember, MemberGame
	WHERE
		Personnel.personnelID = TeamFormation.headcoachID AND
		TeamFormation.teamID = MemberGame.teamID AND
		MemberGame.clubID=ClubMember.clubID AND
		eventDate = '2024-08-10' AND eventAddress = '123 Main ST'
	ORDER BY TeamFormation.eventDate ASC, TeamFormation.eventTime;
";
$queryStatement = $conn->query($query);

// close the connection
$conn->close();
?>

<!-- HTML CODE -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YSC | QUERIES - QUERY 9</title>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
    <!-- navbar -->
    <?php include 'queries_nav.php'; ?>

    <main>
        <!-- page heading -->
        <h2 class="heading">Query 9</h2>

        <!-- query -->
        <div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
            <p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
                For a given location and day, get details of all the teams formations recorded in the system. Details include, head coach first name and last name,
                start time of the training or game session, address of the session, nature of the session (training or game), the teams name, the score (if the session is in the future, then score will be null),
                and the first name, last name and role (goalkeeper, defender, etc.) of every player in the team. Results should be displayed sorted in ascending order by the start time of the session.
            </p>

            <p style="margin-top: 1em; max-width: 1300px; color: var(--smTxtColor);">
                We will take eventDate = '2024-08-10' & eventAddress = '123 Main ST'
            </p>
        </div>

        <!-- display query -->
        <table>
            <thead>
                <tr>
                    <td>Coach Full Name</td>
                    <td>Event Time</td>
                    <td>Event Address</td>
                    <td>Session</td>
                    <td>Team Name</td>
                    <td>Team Score</td>
                    <td>Player Full Name</td>
                    <td>Player Role</td>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $queryStatement->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['HC FN'] . ' ' . $row['HC LN'] ?></td>
                        <td><?= $row['eventTime'] ?></td>
                        <td><?= $row['eventAddress'] ?></td>
                        <td><?= $row['gameOrTraining'] ?></td>
                        <td><?= $row['teamName'] ?></td>
                        <td><?= $row['teamScore'] ?? 'null' ?></td>
                        <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
                        <td><?= $row['position'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

    <!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>