<?php require_once '../database.php';

// get current location details
$gottenSecondaryID = isset($_GET['secondaryID'])? strval($_GET['secondaryID']) : strval($_POST['secondaryID']);
$gottenQuery = "select * from $database.SecondaryFamily where secondaryID = $gottenSecondaryID";
$gottenResult = ($conn->query($gottenQuery))->fetch_assoc();

// get updating values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $primaryFamilyID = $_POST['primaryFamilyID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $telNumber = $_POST['telNumber'];

    // update query
    $updateQuery = "
		update $database.SecondaryFamily 
        set 
            primaryFamilyID = '$primaryFamilyID',
            firstName = '$firstName',
            lastName = '$lastName',
            telNumber = '$telNumber'
        where secondaryID = $gottenSecondaryID;
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
    <title>YSC | SEC. FAMILY MEMBER - EDIT</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'sec_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Edit Sec. Family Member</h2>

		<!-- edit sec. fam. mem -->
		<div class="update">
			<form id="editForm" method="post" action="edit.php">
				<input type="hidden" name="secondaryID" value="<?= $gottenSecondaryID ?>">

				<!-- prim. dam. id -->
				<div class="input">
					<label for="primaryFamilyID">Primary Family ID</label>
					<input type="number" id="primaryFamilyID" name="primaryFamilyID" min="1" max="32767" value="<?= $gottenResult['primaryFamilyID'] ?>" required>
				</div>

				<!-- full name -->
				<div class="two">
					<div class="input">
						<label for="firstName">First Name</label>
						<input type="text" id="firstName" name="firstName" maxlength="255" value="<?= $gottenResult['firstName'] ?>" required>
					</div>

					<div class="input">
						<label for="lastName">Last Name</label>
						<input type="text" id="lastName" name="lastName" maxlength="255" value="<?= $gottenResult['lastName'] ?>" required>
					</div>
				</div>

				<!-- tel -->
				<div class="input">
					<label for="telNumber">Telephone</label>
					<input type="tel" id="telNumber" name="telNumber" maxlength="10" pattern="\d{10}" placeholder="10 digits" value="<?= $gottenResult['telNumber'] ?>" required>
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