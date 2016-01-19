<nav>
	<ul>
		<?php
		if(!isset($_SESSION['username'])) {
		?>
			<li><a href="index">Log in</a></li>
			<li><a href="/index">Back</a></li>
		<?php
		} else {
		?>
			<li><a href="index">Home</a></li>
			<li><a href="pages">Pages</a></li>
			<li><a href="publis">Publications</a></li>
			<li><a href="logout">Log out</a></li>
		<?php
		}
		?>
	</ul>
</nav>
