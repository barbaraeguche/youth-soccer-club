<?php require_once '../database.php';

$query = "
SELECT    Location.name, ClubMember.clubID, ClubMember.firstName, ClubMember.lastName, YEAR(CURDATE())-YEAR(ClubMember.dateOfBirth) AS Age, ClubMember.telNumber, FamilyMember.email
FROM ClubMember, FamilyMember, ClubLocation, Location
WHERE 
ClubMember.associatedFamilyMemberID = FamilyMember.familyID AND
ClubMember.clubID = ClubLocation.clubID AND
ClubLocation.locationID = Location.locationID AND
YEAR(CURDATE())-YEAR(ClubMember.dateOfBirth) >=4 AND YEAR(CURDATE())-YEAR(ClubMember.dateOfBirth)<=10 AND 
ClubMember.clubID IN (
SELECT clubID 
FROM MemberGame 
WHERE position = 'forward' )
AND
ClubMember.clubID IN (
SELECT clubID 
FROM MemberGame 
WHERE position = 'goalkeeper' ) AND
ClubMember.clubID IN (
SELECT clubID 
FROM MemberGame 
WHERE position = 'midfielder' ) AND
ClubMember.clubID IN (
SELECT clubID 
FROM MemberGame 
WHERE position = 'defender' )
GROUP BY ClubMember.clubID
ORDER BY  Location.name ASC, ClubMember.clubID ASC ;

";
$queryStatement = $conn->query($query);

// close the connection
$conn->close();
?>

<!-- HTML CODE -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YSC | QUERIES - QUERY 14</title>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'queries_nav.php'; ?>

	<main>
	    <!-- page heading -->
	    <h2 class="heading">Query 14</h2>

	    <!-- query -->
	    <div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
	        <p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
		        Get a report of all active club members who have only been assigned at least once to every role throughout all the formation team game sessions.
		        The club member must be assigned to at least one formation game session as a goalkeeper, one as a defender, one as a midfielder, and one as a forward. The list
		        should include the club member’s membership number, first name, last name, age, phone number, email and current location name. The results should be displayed sorted in
		        ascending order by location name then by club membership number.
	        </p>
	    </div>

	    <!-- display query -->
	    <table>
	        <thead>
		        <tr>
			        <td>Club Mem. ID</td>
			        <td>Club Mem. Full Name</td>
			        <td>Age</td>
			        <td>Telephone Number</td>
			        <td>Email</td>
			        <td>Current Location</td>
		        </tr>
	        </thead>
	        <tbody>
		        <?php while($row = $queryStatement->fetch_assoc()) { ?>
		            <tr>
			            <td><?= $row['clubID'] ?></td>
			            <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
			            <td><?= $row['Age'] ?></td>
			            <td><?= $row['telNumber'] ?></td>
			            <td><?= $row['email'] ?></td>
			            <td><?= $row['name'] ?></td>
		            </tr>
		        <?php } ?>
	        </tbody>
	    </table>
	</main>

	<!-- footer -->
	<?php include '../common/footer.php'; ?>
</body>
</html>