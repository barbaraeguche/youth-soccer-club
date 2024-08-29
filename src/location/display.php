<?php require_once '../database.php';

$displayQuery = "select * from $database.Location";
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
    <title>YSC | LOCATIONS</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
    <!-- navbar -->
    <?php include 'loc_nav.php'; ?>

    <main>
	    <!-- page heading -->
	    <h2 class="heading">Locations</h2>

	    <!-- display, edit and delete locations -->
	    <table>
		    <thead>
			    <tr>
				    <td>ID</td>
				    <td>Name</td>
				    <td>Full Address</td>
				    <td>Telephone Number</td>
				    <td>Website</td>
				    <td>Type</td>
				    <td>Capacity</td>
				    <td>Actions</td>
			    </tr>
		    </thead>
		    <tbody>
	            <?php while($row = $displayStatement->fetch_assoc()) { ?>
				    <tr>
					    <td><?= $row['locationID'] ?></td>
					    <td><?= $row['name'] ?></td>
					    <td><?= $row['address'] . ', ' . $row['postalCode'] ?></td>
					    <td><?= $row['telNumber'] ?></td>
					    <td><?= $row['webAddress'] ?></td>
					    <td><?= $row['type'] ?></td>
					    <td><?= $row['capacity'] ?></td>

					    <td>
						    <a href="edit.php?locationID=<?= $row['locationID'] ?>">
							    <button class="edit">Edit</button>
						    </a>
						    <a href="delete.php?locationID=<?= $row['locationID'] ?>">
							    <button class="delete">Delete</button>
						    </a>
					    </td>
				    </tr>
	            <?php } ?>
		    </tbody>
	    </table>

	    <!-- create location button -->
	    <a href="create.php">
		    <button class="add">Add Location</button>
	    </a>
    </main>

    <!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>