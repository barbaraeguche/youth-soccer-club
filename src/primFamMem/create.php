<?php require_once '../database.php';

// get new values
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
    $secondaryFamilyID = $_POST['secondaryFamilyID'] ?? null;

    $insertQuery = ($secondaryFamilyID == null)
		? "
			insert into FamilyMember(firstName, lastName, dateOfBirth, SSN, medicareNum, telNumber, address, postalCode, email) 
	        values ('$firstName', '$lastName', '$dateOfBirth', '$SSN', '$medicareNum', '$telNumber', '$address', '$postalCode', '$email');
		"
		: "
			insert into FamilyMember(firstName, lastName, dateOfBirth, SSN, medicareNum, telNumber, address, postalCode, email, secondaryFamilyID) 
	        values ('$firstName', '$lastName', '$dateOfBirth', '$SSN', '$medicareNum', '$telNumber', '$address', '$postalCode', '$email', '$secondaryFamilyID');
		"
	;

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
	<title>YSC | PRIM. FAMILY MEMBER - CREATE</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'fam_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Register Prim. Family Member</h2>

		<!-- add new prim. fam. mem. -->
		<div class="create">
			<form id="createForm" method="post" action="create.php">
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

				<!-- date of birth -->
				<div class="input">
					<label for="dateOfBirth">Date of Birth</label>
					<input type="date" id="dateOfBirth" name="dateOfBirth" required>
				</div>

				<!-- ssn and medicare -->
				<div class="two">
					<div class="input">
						<label for="SSN">SSN</label>
						<input type="text" id="SSN" name="SSN" maxlength="9" pattern="\d{9}" placeholder="9 digits" required>
					</div>

					<div class="input">
						<label for="medicareNum">Medicare Number</label>
						<input type="text" id="medicareNum" name="medicareNum" maxlength="12" pattern="\d{12}" placeholder="12 digits" required>
					</div>
				</div>

				<!-- tel and email -->
				<div class="two">
					<div class="input">
						<label for="telNumber">Telephone</label>
						<input type="tel" id="telNumber" name="telNumber" maxlength="10" pattern="\d{10}" placeholder="10 digits" required>
					</div>

					<div class="input">
						<label for="email">Email</label>
						<input type="email" id="email" name="email" maxlength="255" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
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

				<!-- sec. fam. id -->
				<div class="input">
					<label for="secondaryFamilyID">Secondary Family ID</label>
					<input type="number" id="secondaryFamilyID" name="secondaryFamilyID" min="1" max="32767" placeholder="optional">
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