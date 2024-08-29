<?php require_once '../database.php';

$query = "
	SELECT Personnel.firstName, Personnel.lastName, PersonnelLocation.startDate, PersonnelLocation.endDate
FROM Personnel, PersonnelLocation, Location
WHERE Personnel.personnelID = PersonnelLocation.personnelID AND
PersonnelLocation.locationID = Location.locationID AND 
Location.type = 'head' AND Personnel.role = 'administrator'
ORDER BY Personnel.firstName ASC, Personnel.lastName ASC;
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
    <title>YSC | QUERIES - QUERY 17</title>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'queries_nav.php'; ?>

	<main>
	    <!-- page heading -->
	    <h2 class="heading">Query 17</h2>

	    <!-- query -->
	    <div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
	        <p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
	            Get a report of all the personnels who were president of the club at least once or is currently president of the club. The
	            report should include the president’s first name, last name, start date as a president and last date as president. If last
	            date as president is null means that the personnel is the current president of the club. Results should be displayed sorted in
	            ascending order by first name then by last name then by start date as a president.
	        </p>
	    </div>

	    <!-- display query -->
	    <table>
	        <thead>
		        <tr>
		            <td>President Full Name</td>
		            <td>First Day in Office</td>
		            <td>Last Day in Office</td>
		        </tr>
	        </thead>
	        <tbody>
		        <?php while($row = $queryStatement->fetch_assoc()) { ?>
		            <tr>
		                <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
		                <td><?= $row['startDate'] ?></td>
		                <td><?= $row['endDate'] ?? 'null' ?></td>
		            </tr>
		        <?php } ?>
	        </tbody>
	    </table>
	</main>

	<!-- footer -->
	<?php include '../common/footer.php'; ?>
</body>
</html>