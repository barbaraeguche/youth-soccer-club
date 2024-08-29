<?php require_once '../database.php';

$secondaryID = $_GET['secondaryID'];
$deleteQuery = "delete from $database.SecondaryFamily where secondaryID = $secondaryID";

// delete result
$deleteResult = $conn->query($deleteQuery);

//close the connection, stay at current page & exit
$conn->close();
header("Location: ./display.php");
exit();