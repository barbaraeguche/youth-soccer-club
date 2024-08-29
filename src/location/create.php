<?php require_once '../database.php';

// get new values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $telNumber = $_POST['telNumber'];
    $webAddress = $_POST['webAddress'];
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];

    $insertQuery = "
		insert into Location(name, address, postalCode, telNumber, webAddress, type, capacity)
		values('$name', '$address', '$postalCode', '$telNumber', '$webAddress', '$type', '$capacity');
	";

    // insert into database
    try {
        $newResult = $conn->query($insertQuery);

        // close connection, redirect, exit
        $conn->close();
		echo json_encode(['status' => 'success', 'message' => '']);
        exit();
    } catch (mysqli_sql_exception $e) {
        // close connection, json, exit
        $conn->close();
        echo json_encode(['status' => 'error', 'message' => 'Insertion Failed: ' .$e->getMessage()]);
        exit();
    }
}
?>

<!-- HTML CODE -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YSC | LOCATIONS - CREATE</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'loc_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Register Location</h2>

		<!-- add new location -->
		<div class="create">
			<form id="createForm" method="post" action="create.php">
				<!-- name and type -->
				<div class="two">
					<div class="input">
						<label for="name">Name</label>
						<input type="text" id="name" name="name" maxlength="255" required>
					</div>

					<div class="input">
						<label for="type">Type</label>
						<select id="type" name="type" required>
							<option value="" disabled>select</option>
							<option value="head">Head</option>
							<option value="branch">Branch</option>
						</select>
					</div>
				</div>

				<!-- full address -->
				<div class="two">
					<div class="input">
						<label for="address">Address</label>
						<input type="text" id="address" name="address" maxlength="255" required>
					</div>

					<div class="input">
						<label for="postalCode">Postal Code</label>
						<input type="text" id="postalCode" name="postalCode" minlength="6" maxlength="6" placeholder="6 alphanumerical digits" required>
					</div>
				</div>

				<!-- web address -->
				<div class="input">
					<label for="webAddress">Web Address</label>
					<input type="text" id="webAddress" name="webAddress" maxlength="65535" required>
				</div>

				<!-- tel and capacity -->
				<div class="two">
					<div class="input">
						<label for="telNumber">Telephone</label>
						<input type="tel" id="telNumber" name="telNumber" maxlength="10" pattern="\d{10}" placeholder="10 digits" required>
					</div>

					<div class="input">
						<label for="capacity">Capacity</label>
						<input type="number" id="capacity" name="capacity" min="0" max="32767" required>
					</div>
				</div>

				<!-- register -->
				<input type="submit" value="Register">
			</form>
		</div>

		<!-- output error -->
		<p id="output" style="display: flex; justify-content: center; max-width: 800px; color: red; margin: 3em auto; "></p>
		<script>
            document.getElementById('createForm').addEventListener('submit', function(event) {
                event.preventDefault();

                let formData = new FormData(this);
                let outputDiv = document.getElementById('output');
                outputDiv.textContent = '';

                fetch('create.php', {
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