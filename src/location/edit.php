<?php require_once '../database.php';

// get current location details
$gottenLocationID = isset($_GET['locationID'])? intval($_GET['locationID']) : intval($_POST['locationID']);
$gottenQuery = "select * from $database.Location where locationID = $gottenLocationID";
$gottenResult = ($conn->query($gottenQuery))->fetch_assoc();

// get updating values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $telNumber = $_POST['telNumber'];
    $webAddress = $_POST['webAddress'];
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];

    // update query
    $updateQuery = "
		update $database.Location 
        set 
			name = '$name',
			address = '$address',
			postalCode = '$postalCode',
			telNumber = '$telNumber',
			webAddress = '$webAddress',
			type = '$type',
			capacity = $capacity
        where locationID = $gottenLocationID;
    ";

    // update database
    try {
        $newResult = $conn->query($updateQuery);

        // close connection, json, exit
        if($newResult === TRUE) {
            $conn->close();
            echo json_encode(['status' => 'success', 'message' => 'Insertion successful']);
            exit();
        } else {
            throw new mysqli_sql_exception("Update Failed: " . $conn->error);
        }
    } catch(mysqli_sql_exception $e) {
        $conn->close();
        echo json_encode(['status' => 'error', 'message' => 'Update Failed: ' . $e->getMessage()]);
        exit();
    }
}
?>

<!-- HTML CODE -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YSC | LOCATIONS - EDIT</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'loc_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Edit Location</h2>

		<!-- edit location -->
		<div class="update">
			<form id="editForm" method="post" action="edit.php">
				<input type="hidden" name="locationID" value="<?= $gottenLocationID ?>">

				<!-- name and type -->
				<div class="two">
					<div class="input">
						<label for="name">Name</label>
						<input type="text" id="name" name="name" maxlength="255" value="<?= $gottenResult['name'] ?>" required>
					</div>

					<div class="input">
						<label for="type">Type</label>
						<select id="type" name="type" required>
							<option value="head" <?= $gottenResult['type'] == 'head'? 'selected' : '' ?>>Head</option>
							<option value="branch" <?= $gottenResult['type'] == 'branch'? 'selected' : '' ?>>Branch</option>
						</select>
					</div>
				</div>

				<!-- full address -->
				<div class="two">
					<div class="input">
						<label for="address">Address</label>
						<input type="text" id="address" name="address" maxlength="255" value="<?= $gottenResult['address'] ?>" required>
					</div>

					<div class="input">
						<label for="postalCode">Postal Code</label>
						<input type="text" id="postalCode" name="postalCode" minlength="6" maxlength="6" placeholder="6 alphanumerical digits" value="<?= $gottenResult['postalCode'] ?>" required>
					</div>
				</div>

				<!-- web address -->
				<div class="input">
					<label for="webAddress">Web Address</label>
					<input type="text" id="webAddress" name="webAddress" maxlength="65535" value="<?= $gottenResult['webAddress'] ?>" required>
				</div>

				<!-- tel and capacity -->
				<div class="two">
					<div class="input">
						<label for="telNumber">Telephone</label>
						<input type="tel" id="telNumber" name="telNumber" maxlength="10" pattern="\d{10}" value="<?= $gottenResult['telNumber'] ?>" required>
					</div>

					<div class="input">
						<label for="capacity">Capacity</label>
						<input type="number" id="capacity" name="capacity" min="0" max="32767" value="<?= $gottenResult['capacity'] ?>" required>
					</div>
				</div>

				<!-- update -->
				<input type="submit" value="Update">
			</form>
		</div>

		<!-- output error -->
		<p id="output" style="display: flex; justify-content: center; max-width: 800px; color: red; margin: 3em auto; "></p>
		<script>
            document.getElementById('editForm').addEventListener('submit', function(event) {
                event.preventDefault();

                let formData = new FormData(this);
                let outputDiv = document.getElementById('output');
                outputDiv.textContent = '';

                fetch('edit.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            window.location.href = './display.php';
                        } else {
                            outputDiv.textContent = data.message;
                        }
                    })
                    .catch(error => outputDiv.textContent = `Error: ${error}`);
            });
		</script>
	</main>

	<!-- footer -->
	<?php include '../common/footer.php'; ?>
</body>