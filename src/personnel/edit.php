<?php require_once '../database.php';

// get current location details
$gottenPersonnelID = isset($_GET['personnelID'])? strval($_GET['personnelID']) : strval($_POST['personnelID']);
$gottenQuery = "select * from $database.Personnel where personnelID = $gottenPersonnelID";
$gottenResult = ($conn->query($gottenQuery))->fetch_assoc();

// get updating values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $SSN = $_POST['SSN'];
    $medicareNum = $_POST['medicareNum'];
    $telNumber = $_POST['telNumber'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $mandate = $_POST['mandate'];

    // update query
    $updateQuery = "
		update $database.Personnel 
        set 
            firstName = '$firstName',
            lastName = '$lastName',
            dateOfBirth = '$dateOfBirth',
            SSN = '$SSN',
            medicareNum = '$medicareNum',
            telNumber = '$telNumber',
            address = '$address',
            postalCode = '$postalCode',
            email = '$email',
            role = '$role',
            mandate = '$mandate'
        where personnelID = $gottenPersonnelID;
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
    <title>YSC | PERSONNEL - EDIT</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'person_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Edit Personnel</h2>

		<!-- edit personnel -->
		<div class="update">
			<form id="editForm" method="post" action="edit.php">
				<input type="hidden" name="personnelID" value="<?= $gottenPersonnelID ?>">

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

				<!-- date of birth -->
				<div class="input">
					<label for="dateOfBirth">Date of Birth</label>
					<input type="date" id="dateOfBirth" name="dateOfBirth" value="<?= $gottenResult['dateOfBirth'] ?>" required>
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

				<!-- tel and email -->
				<div class="two">
					<div class="input">
						<label for="telNumber">Telephone</label>
						<input type="tel" id="telNumber" name="telNumber" maxlength="10" pattern="\d{10}" placeholder="10 digits" value="<?= $gottenResult['telNumber'] ?>" required>
					</div>

					<div class="input">
						<label for="email">Email</label>
						<input type="email" id="email" name="email" maxlength="255" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?= $gottenResult['email'] ?>" required>
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

				<!-- role and mandate -->
				<div class="two">
					<div class="input">
						<label for="role">Role</label>
						<select id="role" name="role" required>
							<option value="administrator" <?= $gottenResult['role'] == 'administrator'? 'selected': '' ?>>Administrator</option>
							<option value="trainer" <?= $gottenResult['role'] == 'trainer'? 'selected': '' ?>>Trainer</option>
							<option value="other" <?= $gottenResult['role'] == 'other'? 'selected': '' ?>>Other</option>
						</select>
					</div>

					<div class="input">
						<label for="mandate">Mandate</label>
						<select id="mandate" name="mandate" required>
							<option value="volunteer" <?= $gottenResult['mandate'] == 'volunteer'? 'selected': '' ?>>Volunteer</option>
							<option value="salaried" <?= $gottenResult['mandate'] == 'salaried'? 'selected': '' ?>>Salaried</option>
						</select>
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