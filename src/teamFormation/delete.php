<?php require_once '../database.php';

$teamID = $_GET['teamID'];
$deleteQuery = "delete from $database.TeamFormation where teamID = $teamID";

// delete result
$deleteResult = $conn->query($deleteQuery);

//close the connection, stay at current page & exit
$conn->close();
header("Location: ./display.php");
exit();