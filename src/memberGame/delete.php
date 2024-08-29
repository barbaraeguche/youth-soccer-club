<?php require_once '../database.php';

$memberGameID = $_GET['memberGameID'];
$deleteQuery = "delete from $database.MemberGame where memberGameID = $memberGameID";

// delete result
$deleteResult = $conn->query($deleteQuery);

//close the connection, stay at current page & exit
$conn->close();
header("Location: ./display.php");
exit();