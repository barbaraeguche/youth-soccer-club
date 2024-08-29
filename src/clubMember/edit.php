<?php require_once '../database.php';

// get current location details
$gottenClubID = isset($_GET['clubID'])? strval($_GET['clubID']) : strval($_POST['clubID']);
$gottenQuery = "select * from $database.ClubMember where clubID = $gottenClubID";
$gottenResult = ($conn->query($gottenQuery))->fetch_assoc();

// get updating values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $SSN = $_POST['SSN'];
    $medicareNum = $_POST['medicareNum'];
    $telNumber = $_POST['telNumber'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $associatedFamilyMemberID = (int)$_POST['associatedFamilyMemberID'];

    // update query
    $updateQuery = "
		update $database.ClubMember 
        set 
            firstName = '$firstName',
            lastName = '$lastName',
            gender = '$gender',
            dateOfBirth = '$dateOfBirth',
            SSN = '$SSN',
            medicareNum = '$medicareNum',
            telNumber = '$telNumber',
            address = '$address',
            postalCode = '$postalCode',
            associatedFamilyMemberID = '$associatedFamilyMemberID'
        where clubID = $gottenClubID;
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
    <title>YSC | CLUB MEMBER - EDIT</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'club_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Edit Club Member</h2>

		<!-- edit club mem -->
		<div class="update">
			<form id="editForm" method="post" action="edit.php">
				<input type="hidden" name="clubID" value="<?= $gottenClubID ?>">

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

				<!-- gender, date of birth -->
				<div class="two">
					<div class="input">
						<label for="gender">Gender</label>
						<select id="gender" name="gender" required>
							<option value="" disabled>select</option>
							<option value="male" <?= $gottenResult['gender'] == 'male'? 'selected' : '' ?>>Male</option>
							<option value="female" <?= $gottenResult['gender'] == 'female'? 'selected' : '' ?>>Female</option>
						</select>
					</div>

					<div class="input">
						<label for="dateOfBirth">Date of Birth</label>
						<input type="date" id="dateOfBirth" name="dateOfBirth" value="<?= $gottenResult['dateOfBirth'] ?>" required>
					</div>
				</div>

				<!-- ssn and medicare -->
				<div class="two">
					<div class="input">
						<label for="SSN">SSN</label>
						<input type="tel" id="SSN" name="SSN" maxlength="9" pattern="\d{9}" placeholder="9 digits" value="<?= $gottenResult['SSN'] ?>" required>
					</div>

					<div class="input">
						<label for="medicareNum">Medicare Number</label>
						<input type="tel" id="medicareNum" name="medicareNum" maxlength="12" pattern="\d{12}" placeholder="12 digits" value="<?= $gottenResult['medicareNum'] ?>" required>
					</div>
				</div>

				<!-- tel -->
				<div class="input">
					<label for="telNumber">Telephone</label>
					<input type="tel" id="telNumber" name="telNumber" maxlength="10" pattern="\d{10}" placeholder="10 digits" value="<?= $gottenResult['telNumber'] ?>" required>
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

				<!-- assoc. fam. id -->
				<div class="input">
					<label for="associatedFamilyMemberID">Associated Family ID</label>
					<input type="number" id="associatedFamilyMemberID" name="associatedFamilyMemberID" min="1" max="32767" value="<?= $gottenResult['associatedFamilyMemberID'] ?>" required>
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