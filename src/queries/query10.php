<?php require_once '../database.php';

$query = "
	SELECT ClubMember.clubID, ClubMember.firstName, ClubMember.lastName
	FROM ClubMember
	WHERE ClubMember.clubID IN (SELECT ClubLocation.clubID
	                                FROM ClubLocation
	                                GROUP BY ClubLocation.clubID
	                                HAVING COUNT(distinct ClubLocation.locationID) >= 4 AND MAX(ClubLocation.startDate) >= DATE_SUB(CURDATE(), INTERVAL 2 YEAR)
		) AND YEAR(CURDATE())-YEAR(ClubMember.dateOfBirth) >=4 AND YEAR(CURDATE())-YEAR(ClubMember.dateOfBirth)<=10
	ORDER BY ClubMember.clubID ASC;
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
    <title>YSC | QUERIES - QUERY 10</title>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
	<!-- navbar -->
	<?php include 'queries_nav.php'; ?>

	<main>
	    <!-- page heading -->
	    <h2 class="heading">Query 10</h2>

	    <!-- query -->
	    <div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
	        <p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
	            Get details of club members who are currently active and have been associated with at least four different locations and are members for at most two years.
	            Details include Club membership number, first name and last name. Results should be displayed sorted in ascending order by club membership number.
	        </p>
	    </div>

	    <!-- display query -->
	    <table>
	        <thead>
		        <tr>
		            <td>Club Mem. ID</td>
		            <td>Club Mem. Full Name</td>
		        </tr>
	        </thead>
	        <tbody>
		        <?php while($row = $queryStatement->fetch_assoc()) { ?>
		            <tr>
			            <td><?= $row['clubID'] ?></td>
		                <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
		            </tr>
		        <?php } ?>
	        </tbody>
	    </table>
	</main>

	<!-- footer -->
	<?php include '../common/footer.php'; ?>
</body>
</html>