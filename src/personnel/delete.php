<?php require_once '../database.php';

$personnelID = $_GET['personnelID'];
$deleteQuery = "delete from $database.Personnel where personnelID = $personnelID";

// delete result
$deleteResult = $conn->query($deleteQuery);

//close the connection, stay at current page & exit
$conn->close();
header("Location: ./display.php");
exit();