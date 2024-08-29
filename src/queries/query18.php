<?php require_once '../database.php';

$query = "
SELECT  Location.name AS name, Personnel.role, Personnel.firstName, Personnel.lastName, Personnel.telNumber, Personnel.email
FROM Personnel, PersonnelLocation, Location, FamilyMember
WHERE Personnel.personnelID = PersonnelLocation.personnelID AND
PersonnelLocation.locationID = Location.locationID AND
Personnel.mandate = 'volunteer' AND 
Personnel.SSN NOT IN (
    SELECT SSN
    FROM FamilyMember
    WHERE familyID NOT IN(
        SELECT familyID
        FROM FamilyAssociation)
    )
GROUP BY Personnel.personnelID
ORDER BY Location.name ASC, Personnel.role ASC, Personnel.firstName ASC, Personnel.lastName ASC;
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
    <title>YSC | QUERIES - QUERY 18</title>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'queries_nav.php'; ?>

	<main>
	    <!-- page heading -->
	    <h2 class="heading">Query 18</h2>

	    <!-- query -->
	    <div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
	        <p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
	            Get a report of all volunteer personnels who are not family members of any club member. Results should include the volunteer’s first
	            name, last name, telephone number, email address, current location name and current role. Results should be displayed sorted in
	            ascending order by location name, then by role, then by first name then by last name.
	        </p>
	    </div>

	    <!-- display query -->
	    <table>
	        <thead>
		        <tr>
			        <td>Volunteer Full Name</td>
			        <td>Telephone Number</td>
			        <td>Email</td>
			        <td>Current Location</td>
			        <td>Current Role</td>
		        </tr>
	        </thead>
	        <tbody>
		        <?php while($row = $queryStatement->fetch_assoc()) { ?>
		            <tr>
			            <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
			            <td><?= $row['telNumber'] ?></td>
			            <td><?= $row['email'] ?></td>
			            <td><?= $row['name'] ?></td>
			            <td><?= $row['role'] ?></td>
		            </tr>
		        <?php } ?>
	        </tbody>
	    </table>
	</main>

	<!-- footer -->
	<?php include '../common/footer.php'; ?>
</body>
</html>