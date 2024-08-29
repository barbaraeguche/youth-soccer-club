<?php require_once '../database.php';

$query = "
	SELECT PersonnelID, FamilyMember.familyID, FamilyMember.firstName, FamilyMember.lastName, FamilyMember.telNumber
FROM Personnel, FamilyMember, TeamFormation, ClubMember, FamilyAssociation
Where Personnel.SSN = FamilyMember.SSN AND
FamilyMember.familyID = FamilyAssociation.familyID AND
FamilyAssociation.clubID = ClubMember.clubID
AND personnelID = TeamFormation.headCoachID
AND TeamFormation.teamLocationID = 10
AND YEAR(CURDATE())-YEAR(ClubMember.dateOfBirth) >=4 AND YEAR(CURDATE())-YEAR(ClubMember.dateOfBirth)<=10 ;
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
    <title>YSC | QUERIES - QUERY 15</title>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'queries_nav.php'; ?>

	<main>
	    <!-- page heading -->
	    <h2 class="heading">Query 15</h2>

	    <!-- query -->
	    <div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
	        <p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
		        For a given location, get the list of all family members who have currently active club members associated with them and are also head coaches
		        for the same location. Information includes first name, last name, and phone number of the family member. A family member is considered to be a head coach
		        if she/he is assigned as a head coach to at least one team formation session in the same location.
	        </p>

	        <p style="margin-top: 1em; max-width: 1300px; color: var(--smTxtColor);">
	            We will take Location ID = 10
	        </p>
	    </div>

	    <!-- display query -->
	    <table>
	        <thead>
		        <tr>
		            <td>Coach Full Name</td>
		            <td>Telephone Number</td>
		        </tr>
	        </thead>
	        <tbody>
		        <?php while($row = $queryStatement->fetch_assoc()) { ?>
		            <tr>
		                <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
		                <td><?= $row['telNumber'] ?></td>
		            </tr>
		        <?php } ?>
	        </tbody>
	    </table>
	</main>

	<!-- footer -->
	<?php include '../common/footer.php'; ?>
</body>
</html>