<?php require_once '../database.php';

$clubID = $_GET['clubID'];
$deleteQuery = "delete from $database.ClubMember where clubID = $clubID";

// delete result
$deleteResult = $conn->query($deleteQuery);

//close the connection, stay at current page & exit
$conn->close();
header("Location: ./display.php");
exit();