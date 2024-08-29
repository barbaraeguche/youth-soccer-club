<?php require_once '../database.php';

// get current location details
$gottenMemberGameID = isset($_GET['memberGameID'])? strval($_GET['memberGameID']) : strval($_POST['memberGameID']);
$gottenQuery = "select * from $database.MemberGame where memberGameID = $gottenMemberGameID";
$gottenResult = ($conn->query($gottenQuery))->fetch_assoc();

// get updating values
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clubID = $_POST['clubID'];
    $teamID = $_POST['teamID'];
    $position = $_POST['position'];

    // update query
    $updateQuery = "
		update $database.MemberGame 
        set 
            clubID = '$clubID',
            teamID = '$teamID',
            position = '$position'
        where memberGameID = $gottenMemberGameID;
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
    <title>YSC | MEMBER GAME - EDIT</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<link rel="stylesheet" href="../common/styles/create-edit.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'mem-game_nav.php'; ?>

	<main>
		<!-- page heading -->
		<h2 class="heading">Edit Member In Game</h2>

		<!-- edit sec. fam. mem -->
		<div class="update">
			<form id="editForm" method="post" action="edit.php">
				<input type="hidden" name="memberGameID" value="<?= $gottenMemberGameID ?>">

				<!-- club and team id -->
				<div class="two">
					<div class="input">
						<label for="clubID">Club ID</label>
						<input type="number" id="clubID" name="clubID" min="1" max="32767" value="<?= $gottenResult['clubID'] ?>" required>
					</div>

					<div class="input">
						<label for="teamID">Team ID</label>
						<input type="number" id="teamID" name="teamID" min="1" max="32767" value="<?= $gottenResult['teamID'] ?>" required>
					</div>
				</div>

				<!-- position -->
				<div class="input">
					<label for="position">Position</label>
					<select id="position" name="position" required>
						<option value="" disabled>select</option>
						<option value="goalkeeper" <?= $gottenResult['position'] == 'goalkeeper'? 'selected' : '' ?>>Goalkeeper</option>
						<option value="defender" <?= $gottenResult['position'] == 'defender'? 'selected' : '' ?>>Defender</option>
						<option value="midfielder" <?= $gottenResult['position'] == 'midfielder'? 'selected' : '' ?>>Midfielder</option>
						<option value="forward" <?= $gottenResult['position'] == 'forward'? 'selected' : '' ?>>Forward</option>
					</select>
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