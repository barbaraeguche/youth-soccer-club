<?php require_once '../database.php';

$displayQuery = "select * from $database.MemberGame";
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
    <title>YSC | MEMBER GAMES</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'mem-game_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Member Games</h2>

		<!-- display, edit and delete club member games -->
		<table>
			<thead>
				<tr>
					<td>ID</td>
					<td>Club ID</td>
					<td>Team ID</td>
					<td>Position</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
	            <?php while($row = $displayStatement->fetch_assoc()) { ?>
					<tr>
						<td><?= $row['memberGameID'] ?></td>
						<td><?= $row['clubID'] ?></td>
						<td><?= $row['teamID'] ?></td>
						<td><?= $row['position'] ?></td>

						<td>
							<a href="edit.php?memberGameID=<?= $row['memberGameID'] ?>">
								<button class="edit">Edit</button>
							</a>
							<a href="delete.php?memberGameID=<?= $row['memberGameID'] ?>">
								<button class="delete">Delete</button>
							</a>
						</td>
					</tr>
	            <?php } ?>
			</tbody>
		</table>

		<!-- assign club members to games button -->
		<a href="assign.php">
			<button class="add">Assign Members</button>
		</a>
	</main>

	<!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>