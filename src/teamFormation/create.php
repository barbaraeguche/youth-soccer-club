<?php require_once '../database.php';

// get new values
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
    $eventTime = $_POST['eventTime'] . ':00';
    $teamScore = $_POST['teamScore'] ?? null;
    $eventAddress = $_POST['eventAddress'];
    $teamGender = $_POST['teamGender'];
    $winFlag = $_POST['winFlag'] ?? null;
    $opponentID = $_POST['opponentID'] ?? null;

	// either all is provided, one are provided, or none is provided
    $allProvided = isset($teamScore, $winFlag, $opponentID);
    $oneProvided = ($teamScore == null && $winFlag == null) && isset($opponentID);
	$noneProvided = ($teamScore == null && $winFlag == null && $opponentID == null);

    $insertQuery = null;
	if($allProvided) {
        $insertQuery = "
			insert into TeamFormation(gameOrTraining, teamLocationID, teamName, headCoachID, numOfGoalKeepers, numOfDefenders, numOfMidfielders, numOfForwards, eventDate, eventTime, teamScore, eventAddress, teamGender, winFlag, opponentID)
	    	values('$gameOrTraining', '$teamLocationID', '$teamName', '$headCoachID', '$numOfGoalKeepers', '$numOfDefenders', '$numOfMidfielders', '$numOfForwards', '$eventDate', '$eventTime', '$teamScore', '$eventAddress', '$teamGender', '$winFlag', '$opponentID');
		";
	}
	if($oneProvided) {
        $insertQuery = "
		    insert into TeamFormation(gameOrTraining, teamLocationID, teamName, headCoachID, numOfGoalKeepers, numOfDefenders, numOfMidfielders, numOfForwards, eventDate, eventTime, eventAddress, teamGender, opponentID)
		    values('$gameOrTraining', '$teamLocationID', '$teamName', '$headCoachID', '$numOfGoalKeepers', '$numOfDefenders', '$numOfMidfielders', '$numOfForwards', '$eventDate', '$eventTime', '$eventAddress', '$teamGender', '$opponentID');
	    ";
	}
	if($noneProvided) {
        $insertQuery = "
			insert into TeamFormation(gameOrTraining, teamLocationID, teamName, headCoachID, numOfGoalKeepers, numOfDefenders, numOfMidfielders, numOfForwards, eventDate, eventTime, eventAddress, teamGender)
			values('$gameOrTraining', '$teamLocationID', '$teamName', '$headCoachID', '$numOfGoalKeepers', '$numOfDefenders', '$numOfMidfielders', '$numOfForwards', '$eventDate', '$eventTime', '$eventAddress', '$teamGender');
		";
	}

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
    <title>YSC | TEAM FORMATION - CREATE</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'team_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Register Team Formation</h2>

		<!-- add new team formation -->
		<div class="create">
			<form id="createForm" method="post" action="create.php">
				<!-- team name, game or training -->
				<div class="two">
					<div class="input">
						<label for="teamName">Team Name</label>
						<input type="text" id="teamName" name="teamName" maxlength="255" required>
					</div>

					<div class="input">
						<label for="gameOrTraining">Session</label>
						<select id="gameOrTraining" name="gameOrTraining" required>
							<option value="" disabled>select</option>
							<option value="game">Game</option>
							<option value="training">Training</option>
						</select>
					</div>
				</div>

				<!-- location and coach -->
				<div class="two">
					<div class="input">
						<label for="teamLocationID">Team Location ID</label>
						<input type="number" id="teamLocationID" name="teamLocationID" min="1" max="32767" required>
					</div>

					<div class="input">
						<label for="headCoachID">Head Coach ID</label>
						<input type="number" id="headCoachID" name="headCoachID" min="1" max="32767" required>
					</div>
				</div>

				<!-- keepers, defenders -->
				<div class="two">
					<div class="input">
						<label for="numOfGoalKeepers">Number of GoalKeepers</label>
						<select id="numOfGoalKeepers" name="numOfGoalKeepers" required>
							<option value="" disabled>select</option>
							<option value="one">One</option>
							<option value="many">Many</option>
						</select>
					</div>

					<div class="input">
						<label for="numOfDefenders">Number of Defenders</label>
						<select id="numOfDefenders" name="numOfDefenders" required>
							<option value="" disabled>select</option>
							<option value="zero">Zero</option>
							<option value="one">One</option>
							<option value="many">Many</option>
						</select>
					</div>
				</div>

				<!-- midfield, forward -->
				<div class="two">
					<div class="input">
						<label for="numOfMidfielders">Number of Midfielders</label>
						<select id="numOfMidfielders" name="numOfMidfielders" required>
							<option value="" disabled>select</option>
							<option value="one">One</option>
							<option value="many">Many</option>
						</select>
					</div>

					<div class="input">
						<label for="numOfForwards">Number of Forwards</label>
						<select id="numOfForwards" name="numOfForwards" required>
							<option value="" disabled>select</option>
							<option value="zero">Zero</option>
							<option value="one">One</option>
							<option value="many">Many</option>
						</select>
					</div>
				</div>

				<!-- event address -->
				<div class="input">
					<label for="eventAddress">Event Address</label>
					<input type="text" id="eventAddress" name="eventAddress" maxlength="255" required>
				</div>

				<!-- event date and time -->
				<div class="two">
					<div class="input">
						<label for="eventDate">Event Date</label>
						<input type="date" id="eventDate" name="eventDate" required>
					</div>

					<div class="input">
						<label for="eventTime">Event Time</label>
						<input type="time" id="eventTime" name="eventTime" required>
					</div>
				</div>

				<!-- win flag, team gender -->
				<div class="two">
					<div class="input">
						<label for="winFlag">Win Flag</label>
						<select id="winFlag" name="winFlag">
							<option value="">select</option>
							<option value="win">Win</option>
							<option value="lose">Lose</option>
						</select>
					</div>

					<div class="input">
						<label for="teamGender">Team Gender</label>
						<select id="teamGender" name="teamGender" required>
							<option value="" disabled>select</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
					</div>
				</div>

				<!-- score, opponent -->
				<div class="two">
					<div class="input">
						<label for="teamScore">Team Score</label>
						<input type="number" id="teamScore" name="teamScore" min="1" max="32767">
					</div>

					<div class="input">
						<label for="opponentID">Opponent ID</label>
						<input type="number" id="opponentID" name="opponentID" min="1" max="32767">
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
