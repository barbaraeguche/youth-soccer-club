<?php require_once '../database.php';

$displayQuery = "select * from $database.SecondaryFamily";
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
    <title>YSC | SEC. FAMILY MEMBERS</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'sec_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Secondary Family Members</h2>

		<!-- display, edit and delete secondary family members -->
		<table>
			<thead>
				<tr>
					<td>ID</td>
					<td>Prim. Family ID</td>
					<td>Full Name</td>
					<td>Telephone Number</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
	            <?php while($row = $displayStatement->fetch_assoc()) { ?>
					<tr>
						<td><?= $row['secondaryID'] ?></td>
						<td><?= $row['primaryFamilyID'] ?></td>
						<td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
						<td><?= $row['telNumber'] ?></td>

						<td>
							<a href="edit.php?secondaryID=<?= $row['secondaryID'] ?>">
								<button class="edit">Edit</button>
							</a>
							<a href="delete.php?secondaryID=<?= $row['secondaryID'] ?>">
								<button class="delete">Delete</button>
							</a>
						</td>
					</tr>
	            <?php } ?>
			</tbody>
		</table>

		<!-- create secondary family member button -->
		<a href="create.php">
			<button class="add">Add Emergency Family</button>
		</a>
	</main>

	<!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>