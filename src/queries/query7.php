<?php require_once '../database.php';

$query = "
	select concat(loc.address, ', ', loc.postalCode, ', ', postal.city, ', ', postal.province) as 'address', loc.telNumber, loc.webAddress, loc.type, 
	    loc.capacity, concat(perso.firstName, ' ', perso.lastName) as 'manager', count(clubMem.clubID) AS 'totalClubMem'
	from Location as loc
	    join PostalAddress as postal on loc.postalCode = postal.postalCode
	   	join ClubLocation clubLoc on loc.locationID = clubLoc.locationID
	   	join ClubMember as clubMem on clubLoc.clubID = clubMem.clubID
	   	join PersonnelLocation as persoLoc on loc.locationID = persoLoc.locationID
	   	join Personnel as perso on persoLoc.personnelID = perso.personnelID
	where perso.role = 'administrator'
	group by clubLoc.locationID
	order by postal.province asc, postal.city asc;
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
    <title>YSC | QUERIES - QUERY 7</title>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
    <!-- navbar -->
    <?php include 'queries_nav.php'; ?>

    <main>
        <!-- page heading -->
        <h2 class="heading">Query 7</h2>

	    <!-- query -->
	    <div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
		    <p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
			    Get complete details for every location in the system. Details include address, city, province, postal-code, phone number, web address, type (Head, Branch),
			    capacity, general manager name, and the number of club members associated with that location. The results should be displayed sorted in ascending order by Province, then by city.
		    </p>
	    </div>

        <!-- display query -->
        <table>
            <thead>
	            <tr>
		            <td>Full Address</td>
	                <td>Telephone Number</td>
		            <td>Web Address</td>
		            <td>Type</td>
		            <td>Capacity</td>
		            <td>Gen. Manager</td>
	                <td>Total Club Members</td>
	            </tr>
            </thead>
            <tbody>
	            <?php while($row = $queryStatement->fetch_assoc()) { ?>
	                <tr>
	                    <td><?= $row['address'] ?></td>
	                    <td><?= $row['telNumber'] ?></td>
	                    <td><?= $row['webAddress'] ?></td>
	                    <td><?= $row['type'] ?></td>
	                    <td><?= $row['capacity'] ?></td>
		                <td><?= $row['manager'] ?></td>
	                    <td><?= $row['totalClubMem'] ?></td>
	                </tr>
	            <?php } ?>
            </tbody>
        </table>
    </main>

    <!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>