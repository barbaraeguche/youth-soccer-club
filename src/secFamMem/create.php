<?php require_once '../database.php';

// get new values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $primaryFamilyID = $_POST['primaryFamilyID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $telNumber = $_POST['telNumber'];

    $insertQuery = "
	    insert into SecondaryFamily(primaryFamilyID, firstName, lastName, telNumber)
	    values('$primaryFamilyID', '$firstName', '$lastName', '$telNumber');
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
	<title>YSC | SEC. FAMILY MEMBER - CREATE</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'sec_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Register Sec. Family Member</h2>

		<!-- add new sec. fam. mem. -->
		<div class="create">
			<form id="createForm" method="post" action="create.php">
				<!-- prim. dam. id -->
				<div class="input">
					<label for="primaryFamilyID">Primary Family ID</label>
					<input type="number" id="primaryFamilyID" name="primaryFamilyID" min="1" max="32767" required>
				</div>

				<!-- full name -->
				<div class="two">
					<div class="input">
						<label for="firstName">First Name</label>
						<input type="text" id="firstName" name="firstName" maxlength="255" required>
					</div>

					<div class="input">
						<label for="lastName">Last Name</label>
						<input type="text" id="lastName" name="lastName" maxlength="255" required>
					</div>
				</div>

				<!-- tel -->
				<div class="input">
					<label for="telNumber">Telephone</label>
					<input type="tel" id="telNumber" name="telNumber" maxlength="10" pattern="\d{10}" placeholder="10 digits" required>
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