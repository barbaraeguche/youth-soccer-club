<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>YSC | QUERIES</title>
	<link rel="stylesheet" href="../common/styles/global.css">
	<style>
		main {
			flex: 1;
		}
		html, body {
			height: 100%;
			display: flex;
			flex-direction: column;
		}

		.heading {
			margin: 1em 0 2em;
			text-align: center;
			color: var(--bgTxtColor);
			font-size: 2.5em;
		}

		main .links {
			display: flex;
			flex-direction: column;
			align-items: center;
			row-gap: 1.5em;

			a[href*='query'] {
				font-size: 1.1em;
				transition: transform 0.2s linear;

				&:hover {
					text-shadow: 1px 1px 10px var(--smTxtColor);
					transform: scale(1.1);
				}
			}
		}
	</style>
</head>
<body>
    <!-- navbar -->
    <?php include 'queries_nav.php'; ?>

    <main>
        <!-- page heading -->
        <h2 class="heading">Queries</h2>

        <!-- query links -->
	    <div class="links">
		    <a href="query7.php"><b>Query 7:</b> Location Details Report</a>
		    <a href="query8.php"><b>Query 8:</b> Family Member and Associated Members Report</a>
		    <a href="query9.php"><b>Query 9:</b> Team Formation Details by Location and Day</a>
		    <a href="query10.php"><b>Query 10:</b> Active Club Members with Multiple Locations Report</a>
		    <a href="query11.php"><b>Query 11:</b> Teams' Formation Summary Report by Period</a>
		    <a href="query12.php"><b>Query 12:</b> Active Club Members Never Assigned to Formation Team Sessions Report</a>
		    <a href="query13.php"><b>Query 13:</b> Active Club Members Exclusively Goalkeepers Report</a>
		    <a href="query14.php"><b>Query 14:</b> Active Club Members with All Roles in Game Sessions Report</a>
		    <a href="query15.php"><b>Query 15:</b> Head Coaches with Active Club Members Report</a>
		    <a href="query16.php"><b>Query 16:</b> Active Club Members with Undefeated Game Record Report</a>
		    <a href="query17.php"><b>Query 17:</b> Club Presidents Report</a>
		    <a href="query18.php"><b>Query 18:</b> Non-Family Volunteer Personnels Report</a>
	    </div>
    </main>

    <!-- footer -->
    <?php include '../common/footer.php'; ?>
</body>
</html>