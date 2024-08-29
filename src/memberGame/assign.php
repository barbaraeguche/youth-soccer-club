<?php require_once '../database.php';

// get new values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clubID = $_POST['clubID'];
    $teamID = $_POST['teamID'];
    $position = $_POST['position'];

    $insertQuery = "
	    insert into MemberGame(clubID, teamID, position)
	    values('$clubID', '$teamID', '$position');
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
	<title>YSC | MEMBER GAME - ASSIGN</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'mem-game_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Assign Member To Game</h2>

		<!-- assign new member game -->
		<div class="create">
			<form id="createForm" method="post" action="assign.php">
				<!-- club and team id -->
				<div class="two">
					<div class="input">
						<label for="clubID">Club ID</label>
						<input type="number" id="clubID" name="clubID" min="1" max="32767" required>
					</div>

					<div class="input">
						<label for="teamID">Team ID</label>
						<input type="number" id="teamID" name="teamID" min="1" max="32767" required>
					</div>
				</div>

				<!-- position -->
				<div class="input">
					<label for="position">Position</label>
					<select id="position" name="position" required>
						<option value="" disabled>select</option>
						<option value="goalkeeper">Goalkeeper</option>
						<option value="defender">Defender</option>
						<option value="midfielder">Midfielder</option>
						<option value="forward">Forward</option>
					</select>
				</div>

				<!-- assign -->
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

                fetch('assign.php', {
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