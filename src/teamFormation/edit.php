<?php require_once '../database.php';

// get current location details
$gottenTeamID = isset($_GET['teamID'])? strval($_GET['teamID']) : strval($_POST['teamID']);
$gottenQuery = "select * from $database.TeamFormation where teamID = $gottenTeamID";
$gottenResult = ($conn->query($gottenQuery))->fetch_assoc();

// get updating values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gameOrTraining = $_POST['gameOrTraining'];
    $teamLocationID = $_POST['teamLocationID'];
    $teamName = $_POST['teamName'];
    $headCoachID = $_POST['headCoachID'];
    $numOfGoalKeepers = $_POST['numOfGoalKeepers'];
    $numOfDefenders = $_POST['numOfDefenders'];
    $numOfMidfielders = $_POST['numOfMidfielders'];
    $numOfForwards = $_POST['numOfForwards'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $teamScore = $_POST['teamScore'] ?? null;
    $eventAddress = $_POST['eventAddress'];
    $teamGender = $_POST['teamGender'];
    $winFlag = $_POST['winFlag'] ?? null;
    $opponentID = $_POST['opponentID'] ?? null;

    // either all is provided, one are provided, or none is provided
    $allProvided = isset($teamScore, $winFlag, $opponentID);
    $oneProvided = ($teamScore == null && $winFlag == null) && isset($opponentID);
    $noneProvided = ($teamScore == null && $winFlag == null && $opponentID == null);

    // update query
    $updateQuery = '';
    if($allProvided) {
        $updateQuery = "
			update $database.TeamFormation
			set
				gameOrTraining = '$gameOrTraining', 
				teamLocationID = '$teamLocationID', 
				teamName = '$teamName',
				headCoachID = '$headCoachID',
				numOfGoalKeepers = '$numOfGoalKeepers',
				numOfDefenders = '$numOfDefenders',
				numOfMidfielders = '$numOfMidfielders',
				numOfForwards = '$numOfForwards',
				eventDate = '$eventDate',
				eventTime = '$eventTime',
				teamScore = '$teamScore',
				eventAddress = '$eventAddress',
				teamGender = '$teamGender',
				winFlag = '$winFlag',
				opponentID = '$opponentID'
	    	where teamID = $gottenTeamID;
		";
    }
    if($oneProvided) {
        $updateQuery = "
			update $database.TeamFormation
			set
				gameOrTraining = '$gameOrTraining', 
				teamLocationID = '$teamLocationID', 
				teamName = '$teamName',
				headCoachID = '$headCoachID',
				numOfGoalKeepers = '$numOfGoalKeepers',
				numOfDefenders = '$numOfDefenders',
				numOfMidfielders = '$numOfMidfielders',
				numOfForwards = '$numOfForwards',
				eventDate = '$eventDate',
				eventTime = '$eventTime',
				teamScore = null,
				eventAddress = '$eventAddress',
				teamGender = '$teamGender',
				winFlag = null,
				opponentID = '$opponentID'
	    	where teamID = $gottenTeamID;
		";
    }
    if($noneProvided) {
        $updateQuery = "
			update $database.TeamFormation
			set
				gameOrTraining = '$gameOrTraining', 
				teamLocationID = '$teamLocationID', 
				teamName = '$teamName',
				headCoachID = '$headCoachID',
				numOfGoalKeepers = '$numOfGoalKeepers',
				numOfDefenders = '$numOfDefenders',
				numOfMidfielders = '$numOfMidfielders',
				numOfForwards = '$numOfForwards',
				eventDate = '$eventDate',
				eventTime = '$eventTime',
				teamScore = null,
				eventAddress = '$eventAddress',
				teamGender = '$teamGender',
				winFlag = null,
				opponentID = null
	    	where teamID = $gottenTeamID;
		";
    }

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
    <title>YSC | TEAM FORMATION - EDIT</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'team_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Edit Team Formation</h2>

		<!-- edit team formation -->
		<div class="update">
			<form id="editForm" method="post" action="edit.php">
				<input type="hidden" name="teamID" value="<?= $gottenTeamID ?>">

				<!-- team name, game or training -->
				<div class="two">
					<div class="input">
						<label for="teamName">Team Name</label>
						<input type="text" id="teamName" name="teamName" maxlength="255" value="<?= $gottenResult['teamName'] ?>" required>
					</div>

					<div class="input">
						<label for="gameOrTraining">Session</label>
						<select id="gameOrTraining" name="gameOrTraining" required>
							<option value="" disabled>select</option>
							<option value="game" <?= $gottenResult['gameOrTraining'] == 'game'? 'selected': '' ?>>Game</option>
							<option value="training" <?= $gottenResult['gameOrTraining'] == 'training'? 'selected': '' ?>>Training</option>
						</select>
					</div>
				</div>

				<!-- location and coach -->
				<div class="two">
					<div class="input">
						<label for="teamLocationID">Team Location ID</label>
						<input type="number" id="teamLocationID" name="teamLocationID" min="1" max="32767" value="<?= $gottenResult['teamLocationID'] ?>" required>
					</div>

					<div class="input">
						<label for="headCoachID">Head Coach ID</label>
						<input type="number" id="headCoachID" name="headCoachID" min="1" max="32767" value="<?= $gottenResult['headCoachID'] ?>" required>
					</div>
				</div>

				<!-- keepers, defenders -->
				<div class="two">
					<div class="input">
						<label for="numOfGoalKeepers">Number of GoalKeepers</label>
						<select id="numOfGoalKeepers" name="numOfGoalKeepers" required>
							<option value="" disabled>select</option>
							<option value="one" <?= $gottenResult['numOfGoalKeepers'] == 'one'? 'selected': '' ?>>One</option>
							<option value="many" <?= $gottenResult['numOfGoalKeepers'] == 'many'? 'selected': '' ?>>Many</option>
						</select>
					</div>

					<div class="input">
						<label for="numOfDefenders">Number of Defenders</label>
						<select id="numOfDefenders" name="numOfDefenders" required>
							<option value="" disabled>select</option>
							<option value="zero" <?= $gottenResult['numOfDefenders'] == 'zero'? 'selected': '' ?>>Zero</option>
							<option value="one" <?= $gottenResult['numOfDefenders'] == 'one'? 'selected': '' ?>>One</option>
							<option value="many" <?= $gottenResult['numOfDefenders'] == 'many'? 'selected': '' ?>>Many</option>
						</select>
					</div>
				</div>

				<!-- midfield, forward -->
				<div class="two">
					<div class="input">
						<label for="numOfMidfielders">Number of Midfielders</label>
						<select id="numOfMidfielders" name="numOfMidfielders" required>
							<option value="" disabled>select</option>
							<option value="one" <?= $gottenResult['numOfMidfielders'] == 'one'? 'selected': '' ?>>One</option>
							<option value="many" <?= $gottenResult['numOfMidfielders'] == 'many'? 'selected': '' ?>>Many</option>
						</select>
					</div>

					<div class="input">
						<label for="numOfForwards">Number of Forwards</label>
						<select id="numOfForwards" name="numOfForwards" required>
							<option value="" disabled>select</option>
							<option value="zero" <?= $gottenResult['numOfForwards'] == 'zero'? 'selected': '' ?>>Zero</option>
							<option value="one" <?= $gottenResult['numOfForwards'] == 'one'? 'selected': '' ?>>One</option>
							<option value="many" <?= $gottenResult['numOfForwards'] == 'many'? 'selected': '' ?>>Many</option>
						</select>
					</div>
				</div>

				<!-- event address -->
				<div class="input">
					<label for="eventAddress">Event Address</label>
					<input type="text" id="eventAddress" name="eventAddress" maxlength="255" value="<?= $gottenResult['eventAddress'] ?>" required>
				</div>

				<!-- event date and time -->
				<div class="two">
					<div class="input">
						<label for="eventDate">Event Date</label>
						<input type="date" id="eventDate" name="eventDate" value="<?= $gottenResult['eventDate'] ?>" required>
					</div>

					<div class="input">
						<label for="eventTime">Event Time</label>
						<input type="time" id="eventTime" name="eventTime" value="<?= $gottenResult['eventTime'] ?>" required>
					</div>
				</div>

				<!-- win flag, team gender -->
				<div class="two">
					<div class="input">
						<label for="winFlag">Win Flag</label>
						<select id="winFlag" name="winFlag">
							<option value="">select</option>
							<option value="win" <?= $gottenResult['winFlag'] == 'win'? 'selected': '' ?>>Win</option>
							<option value="lose" <?= $gottenResult['winFlag'] == 'lose'? 'selected': '' ?>>Lose</option>
						</select>
					</div>

					<div class="input">
						<label for="teamGender">Team Gender</label>
						<select id="teamGender" name="teamGender" required>
							<option value="" disabled>select</option>
							<option value="male" <?= $gottenResult['teamGender'] == 'male'? 'selected': '' ?>>Male</option>
							<option value="female" <?= $gottenResult['teamGender'] == 'female'? 'selected': '' ?>>Female</option>
						</select>
					</div>
				</div>

				<!-- score, opponent -->
				<div class="two">
					<div class="input">
						<label for="teamScore">Team Score</label>
						<input type="number" id="teamScore" name="teamScore" min="1" max="32767" value="<?= $gottenResult['teamScore'] ?>">
					</div>

					<div class="input">
						<label for="opponentID">Opponent ID</label>
						<input type="number" id="opponentID" name="opponentID" min="1" max="32767" value="<?= $gottenResult['opponentID'] ?>">
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