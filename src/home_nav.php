<link rel="stylesheet" href="common/styles/global.css">

<style>
	* {
		font-family: "Garamond", serif;
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	body {
		background-color: var(--bgColor);
	}

	header {
		width: 100%;
		padding: 1em;
		background-color: var(--headFoot);
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	h2 {
		font-size: 1.5em;
	}

	nav {
		display: flex;
		gap: 2em;
	}

	a {
		text-decoration: none;
		color: var(--bgTxtColor);
		font-size: 1em;
		transition: transform 0.1s linear;

		&:hover {
			transform: scale(1.1);
		}
	}
</style>

<header>
    <h2><a href="home.php">YSC</a></h2>
    <nav>
        <a href="location/display.php">Location</a>
        <a href="personnel/display.php">Personnel</a>
        <a href="primFamMem/display.php">Prim. Family Member</a>
        <a href="secFamMem/display.php">Sec. Family Member</a>
        <a href="clubMember/display.php">Club Member</a>
        <a href="teamFormation/display.php">Team Formation</a>
	    <a href="memberGame/display.php">Member Game</a>
	    <a href="queries/display.php">Queries</a>
    </nav>
</header>