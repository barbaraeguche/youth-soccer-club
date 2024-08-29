<?php require_once '../database.php';

$query = "
	SELECT ClubMember.clubID, FamilyAssociation.associationID, SecondaryFamily.firstName as secFirstName, SecondaryFamily.lastName as secLastName, SecondaryFamily.telNumber as secPhone,
        ClubMember.clubID, ClubMember.firstName, ClubMember.lastName, ClubMember.dateOfBirth, ClubMember.SSN, ClubMember.medicareNum, ClubMember.telNumber, ClubMember.address, 
        PostalAddress.city, PostalAddress.province, ClubMember.postalCode, SecondaryFamilyAssociation.relationship
    From FamilyMember, FamilyAssociation, SecondaryFamily, ClubMember, PostalAddress, SecondaryFamilyAssociation
    WHERE FamilyMember.familyID = FamilyAssociation.familyID AND
        FamilyAssociation.clubID = ClubMember.clubID AND
        SecondaryFamily.secondaryID = SecondaryFamilyAssociation.secondaryID AND
        SecondaryFamilyAssociation.clubID = ClubMember.clubID AND
        ClubMember.postalCode = PostalAddress.postalCode AND 
        FamilyMember.familyID = 9;
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
    <title>YSC | QUERIES - QUERY 8</title>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="../common/styles/display.css">
</head>
<body>
    <!-- navbar -->
    <?php include 'queries_nav.php'; ?>

    <main>
        <!-- page heading -->
        <h2 class="heading">Query 8</h2>

        <!-- query -->
        <div style="margin: 2em 3.5em; text-align: justify; display: flex; flex-direction:column; align-items: center;">
            <p style="max-width: 1300px; color: var(--smTxtColor); font-weight: lighter;">
	            For a given family member, get details of the secondary family member and all the associated club members with the primary family member.
	            Information includes first name, last name and phone number of the secondary family member, and for every associated club member, the club membership number,
	            first-name, last-name, date of birth, Social Security Number, Medicare card number, telephone-number, address, city, province, postal-code, and relationship with the secondary family member.
            </p>

            <p style="margin-top: 1em; max-width: 1300px; color: var(--smTxtColor);">
                We will take family ID 9
            </p>
        </div>

        <!-- display query -->
        <table>
            <thead>
                <tr>
                    <td>Sec. Full Name</td>
                    <td>Sec. Telephone</td>
                    <td>Club Mem. ID</td>
                    <td>Club Mem. Full Name</td>
                    <td>Date of Birth</td>
                    <td>SSN</td>
                    <td>Medicare Num.</td>
                    <td>Tel Number</td>
                    <td>Full Address</td>
                    <td>Sec. Relationship with Club Mem.</td>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $queryStatement->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['secFirstName'] . ' ' . $row['secLastName'] ?></td>
                        <td><?= $row['secPhone'] ?></td>
                        <td><?= $row['clubID'] ?></td>
                        <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
                        <td><?= $row['dateOfBirth'] ?></td>
                        <td><?= $row['SSN'] ?></td>
                        <td><?= $row['medicareNum'] ?></td>
	                    <td><?= $row['telNumber'] ?></td>
	                    <td><?= $row['address'] . ', ' . $row['postalCode'] . ', ' . $row['city'] . ', ' . $row['province'] ?></td>
	                    <td><?= $row['relationship'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

    <!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>