<?php require_once '../database.php';

$familyID = $_GET['familyID'];
$deleteQuery = "delete from $database.FamilyMember where familyID = $familyID";

// delete result
$deleteResult = $conn->query($deleteQuery);

//close the connection, stay at current page & exit
$conn->close();
header("Location: ./display.php");
exit();