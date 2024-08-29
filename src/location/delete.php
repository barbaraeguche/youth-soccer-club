<?php require_once '../database.php';

$locationID = $_GET['locationID'];
$deleteQuery = "delete from $database.Location where locationID = $locationID";

// delete result
$deleteResult = $conn->query($deleteQuery);

//close the connection, stay at current page & exit
$conn->close();
header("Location: ./display.php");
exit();