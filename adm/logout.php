<?php
include("header.php");
include("menu.php");
session_destroy();

// Config setters
$bdd = mysql_pdo_connect();
?>

<section>
	<article>
		<h1>Disconnected</h1>
		
		<p>Redirecting...</p>
		
		<meta http-equiv="refresh" content="1; URL=index">
	</article>
</section>

<?php
include("footer.php");
?>
