<?php require_once '../database.php';

$displayQuery = "select * from $database.TeamFormation";
$displayStatement = $conn->query($displayQuery);

// close the connection
$conn->close();
?>

<!-- HTML CODE -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YSC | TEAM FORMATIONS</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'team_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Team Formations</h2>

		<!-- display, edit and delete team formations -->
		<table>
			<thead>
				<tr>
					<td>ID</td>
					<td>Session</td>
					<td>Location ID</td>
					<td>Team Name</td>
					<td>Coach ID</td>
					<td>GoalKeepers</td>
					<td>Defenders</td>
					<td>Midfielders</td>
					<td>Forwards</td>
					<td>Event Date</td>
					<td>Event Time</td>
					<td>Team Score</td>
					<td>Event Address</td>
					<td>Team Gender</td>
					<td>Win Flag</td>
					<td>Opponent ID</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
	            <?php while($row = $displayStatement->fetch_assoc()) { ?>
					<tr>
						<td><?= $row['teamID'] ?></td>
						<td><?= $row['gameOrTraining'] ?></td>
						<td><?= $row['teamLocationID'] ?></td>
						<td><?= $row['teamName'] ?></td>
						<td><?= $row['headCoachID'] ?></td>
						<td><?= $row['numOfGoalKeepers'] ?></td>
						<td><?= $row['numOfDefenders'] ?></td>
						<td><?= $row['numOfMidfielders'] ?></td>
						<td><?= $row['numOfForwards'] ?></td>
						<td><?= $row['eventDate'] ?></td>
						<td><?= $row['eventTime'] ?></td>
						<td><?= $row['teamScore'] ?></td>
						<td><?= $row['eventAddress'] ?></td>
						<td><?= $row['teamGender'] ?></td>
						<td><?= $row['winFlag'] ?></td>
						<td><?= $row['opponentID'] ?></td>

						<td>
							<a href="edit.php?teamID=<?= $row['teamID'] ?>">
								<button class="edit">Edit</button>
							</a>
							<a href="delete.php?teamID=<?= $row['teamID'] ?>">
								<button class="delete">Delete</button>
							</a>
						</td>
					</tr>
	            <?php } ?>
			</tbody>
		</table>

		<!-- create team formation button -->
		<a href="create.php">
			<button class="add">Add Team Formation</button>
		</a>
	</main>

	<!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>