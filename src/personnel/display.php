<?php require_once '../database.php';

$displayQuery = "select * from $database.Personnel";
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
    <title>YSC | PERSONNELS</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'person_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Personnels</h2>

		<!-- display, edit and delete personnels -->
		<table>
			<thead>
				<tr>
					<td>ID</td>
					<td>Full Name</td>
					<td>Date of Birth</td>
					<td>SSN</td>
					<td>Medicare Number</td>
					<td>Telephone Number</td>
					<td>Full Address</td>
					<td>Email</td>
					<td>Role</td>
					<td>Mandate</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
	            <?php while($row = $displayStatement->fetch_assoc()) { ?>
					<tr>
						<td><?= $row['personnelID'] ?></td>
						<td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
						<td><?= $row['dateOfBirth'] ?></td>
						<td><?= $row['SSN'] ?></td>
						<td><?= $row['medicareNum'] ?></td>
						<td><?= $row['telNumber'] ?></td>
						<td><?= $row['address'] . ', ' . $row['postalCode'] ?></td>
						<td><?= $row['email'] ?></td>
						<td><?= $row['role'] ?></td>
						<td><?= $row['mandate'] ?></td>

						<td>
							<a href="edit.php?personnelID=<?= $row['personnelID'] ?>">
								<button class="edit">Edit</button>
							</a>
							<a href="delete.php?personnelID=<?= $row['personnelID'] ?>">
								<button class="delete">Delete</button>
							</a>
						</td>
					</tr>
	            <?php } ?>
			</tbody>
		</table>

		<!-- create personnel button -->
		<a href="create.php">
			<button class="add">Add Personnel</button>
		</a>
	</main>

	<!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>