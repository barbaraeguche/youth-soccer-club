<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>YOUTH SOCCER CLUB</title>
	<style                                 >
		main {
			padding: 2em;
			flex: 1;
		}
		html, body {
			height: 100%;
			display: flex;
			flex-direction: column;
		}

		.intro {
			display: flex;
			flex-direction: column;
			align-items: center;

			> h1 {
				margin: 20px 0 30px;
				color: var(--bgTxtColor);
				font-size: 3em;
			}

			> p {
				width: 70%;
				text-align: justify;
				color: var(--smTxtColor);
				max-width: 50em;
			}
		}

		.about {
			padding: 2em;
			display: flex;
			justify-content: center;
			margin: 0 auto;
			height: 20em;
			gap: 1em;
			max-width: 1100px;

			> article {
				border-radius: 15px;
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				border: 1px solid var(--bgTxtColor);
				flex: 1;
				transition: box-shadow 0.2s ease-in-out, transform 0.2s linear;

				> h3 {
					text-align: center;
					color: var(--bgTxtColor);
				}

				> p {
					margin-top: 1em;
					width: 70%;
					color: var(--smTxtColor);
					text-align: justify;
				}
			}
		}

		article:hover {
			box-shadow: 2px 2px 5px 0 var(--bgTxtColor);
			transform: translateY(-2px);
		}
	</style>
</head>
<body>
	<!-- navbar -->
    <?php include 'home_nav.php'; ?>

	<!-- body -->
	<main>
		<section class="intro">
			<h1>Welcome to Youth Soccer Club</h1>
			<p>
				YSC is a nonprofit organization that develops, promotes and enhances youth soccer
				in different areas. We provide our members with services adapted to the long-term
				development to become a professional soccer player. Our optimal soccer program
				is offered to members between the ages of 4 and 10 years old.
			</p>
		</section>

		<hr style="width: 80%; margin: 5em auto 3.5em">

		<section class="about">
			<article>
				<h3>Our Mission</h3>
				<p>
					To develop, promote and enhance youth soccer in different areas,
					providing our members with services adapted to the long-term development
					to become a professional soccer player.
				</p>
			</article>

			<article>
				<h3>Our Values</h3>
				<p>
					Teamwork, sportsmanship, respect, and a passion for the game.
				</p>
			</article>

			<article>
				<h3>Our History</h3>
				<p>
					YSC was established in 2010 and has been a pillar of the community for over
					a decade, providing a safe, inclusive, and enriching environment for youth
					to learn, grow, and excel in soccer.
				</p>
			</article>
		</section>
	</main>

	<!-- footer -->
	<?php include 'common/footer.php'; ?>
</body>
</html>