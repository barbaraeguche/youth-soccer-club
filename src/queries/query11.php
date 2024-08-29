<?php require_once '../database.php';

$query = "
	SELECT Location.locationID, Location.name,
	        (SELECT COUNT(TeamFormation.teamID)
	FROM TeamFormation
	WHERE TeamFormation.gameOrTraining = 'training' AND
	TeamFormation.teamLocationID = Location.locationID AND
	                TeamFormation.eventDate BETWEEN '2024-01-01' AND '2024-12-31'
	                ) AS numberOfTrainings,
	        (SELECT COUNT(MemberGame.memberGameID)
	        FROM MemberGame
	        WHERE MemberGame.teamID IN (SELECT TeamFormation.teamID
	FROM TeamFormation
	                                    WHERE TeamFormation.teamLocationID = Location.locationID AND
	TeamFormation.gameOrTraining = 'training'
	                                            AND
	TeamFormation.eventDate BETWEEN '2024-01-01' AND '2024-12-31'
	                                            ) ) as numberOfPlayerTraining,
	        (SELECT COUNT(TeamFormation.teamID)
	FROM TeamFormation
	WHERE TeamFormation.gameOrTraining = 'game' AND
	TeamFormation.teamLocationID = Location.locationID AND
	                TeamFormation.eventDate BETWEEN '2024-01-01' AND '2024-12-31'
	                
	                ) AS numberOfGames,
	         (SELECT COUNT(MemberGame.memberGameID)
	        FROM MemberGame
	        WHERE MemberGame.teamID IN (SELECT TeamFormation.teamID
	FROM TeamFormation
	                                    WHERE TeamFormation.teamLocationID = Location.locationID AND
	TeamFormation.gameOrTraining = 'game' AND
	                                            TeamFormation.eventDate BETWEEN '2024-01-01' AND '2024-12-31'
	                                            ) ) as numberOfPlayerGame
	FROM Location
	WHERE (SELECT COUNT(TeamFormation.teamID)
	FROM TeamFormation
	        WHERE TeamFormation.teamLocationID = Location.locationID 
	        AND
	TeamFormation.gameOrTraining = 'game' AND
	TeamFormation.eventDate BETWEEN '2024-01-01' AND '2024-12-31'
	) >= 3
	ORDER BY numberOfGames DESC;
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
	<title>YSC | QUERIES - QUERY 11</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'queries_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Query 11</h2>

		<!-- query -->
		<div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
			<p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
				For a given period of time, give a report of the teams’ formations for all the locations. For each location, the report should include the location name,
				the total number of training sessions, the total number of players in the training sessions, the total number of game sessions, the total number of players in the
				game sessions. Results should only include locations that have at least three game sessions. Results should be displayed sorted in descending order by the total number of
				game sessions. For example, the period of time could be from Jan 1st, 2024, to March 31st, 2024.
			</p>

			<p style="margin-top: 1em; max-width: 1300px; color: var(--smTxtColor);">
				We will take timePeriod = the whole year of 2024
			</p>
		</div>

		<!-- display query -->
		<table>
			<thead>
				<tr>
					<td>Location Name</td>
					<td>Tot. Train. Sess.</td>
					<td>Tot. Players in Train. Sess.</td>
					<td>Tot. Game Sess.</td>
					<td>Tot. Players in Game Sess.</td>
				</tr>
			</thead>
			<tbody>
		        <?php while($row = $queryStatement->fetch_assoc()) { ?>
					<tr>
						<td><?= $row['name'] ?></td>
						<td><?= $row['numberOfTrainings'] ?></td>
						<td><?= $row['numberOfPlayerTraining'] ?></td>
						<td><?= $row['numberOfGames'] ?></td>
						<td><?= $row['numberOfPlayerGame'] ?></td>
					</tr>
		        <?php } ?>
			</tbody>
		</table>
	</main>

	<!-- footer -->
	<?php include '../common/footer.php'; ?>
</body>
</html>