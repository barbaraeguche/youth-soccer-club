<?php require_once '../database.php';

$displayQuery = "select * from $database.ClubMember";
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
    <title>YSC | CLUB MEMBERS</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'club_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Club Members</h2>

		<!-- display, edit and delete club members -->
		<table>
			<thead>
				<tr>
					<td>ID</td>
					<td>Full Name</td>
					<td>Gender</td>
					<td>Date of Birth</td>
					<td>SSN</td>
					<td>Medicare Number</td>
					<td>Telephone Number</td>
					<td>Full Address</td>
					<td>Assoc. Family ID</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
	            <?php while($row = $displayStatement->fetch_assoc()) { ?>
					<tr>
						<td><?= $row['clubID'] ?></td>
						<td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
						<td><?= $row['gender'] ?></td>
						<td><?= $row['dateOfBirth'] ?></td>
						<td><?= $row['SSN'] ?></td>
						<td><?= $row['medicareNum'] ?></td>
						<td><?= $row['telNumber'] ?></td>
						<td><?= $row['address'] . ', ' . $row['postalCode'] ?></td>
						<td><?= $row['associatedFamilyMemberID'] ?></td>

						<td>
							<a href="edit.php?clubID=<?= $row['clubID'] ?>">
								<button class="edit">Edit</button>
							</a>
							<a href="delete.php?clubID=<?= $row['clubID'] ?>">
								<button class="delete">Delete</button>
							</a>
						</td>
					</tr>
	            <?php } ?>
			</tbody>
		</table>

		<!-- create club member button -->
		<a href="create.php">
			<button class="add">Add Club Member</button>
		</a>
	</main>

	<!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>