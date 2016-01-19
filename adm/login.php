<?php
//session_start();
include("header.php");
include("menu.php");

// Config setters
$bdd = mysql_pdo_connect();
$config = mysql_get_website_config($bdd);

$lastmodif 	= $config[0]['val'];
$title 		= $config[1]['val'];
$subtitle 	= $config[2]['val'];
$username 	= $config[3]['val'];
$hashpasswd	= $config[4]['val'];
$email 		= $config[5]['val'];
$idimg		= $config[6]['val'];
$hometext 	= $config[7]['val'];
?>

<section>
	<article>
		<?php
		if(!empty(htmlspecialchars($_POST['username'])) && !empty(htmlspecialchars($_POST['password']))) {
			if(htmlspecialchars($_POST['username']) == $username && password_verify(htmlspecialchars($_POST['password']), $hashpasswd)) {
				$_SESSION['username'] = $_POST['username'];
				?>
					<meta http-equiv="refresh" content="0; URL=index">
					<h1><font color="blue">Connection successful.</font></h1><p>Redirecting...</p>
				<?php
			} else {
				?>
					<meta http-equiv="refresh" content="1; URL=index">
					<h1><font color="red">Wrong credentials.</font></h1><p>Redirecting...</p>
				<?php
			}
		} else {
		?>
			<meta http-equiv="refresh" content="1; URL=index">
			<h1><font color="red">Empty field detected.</font></h1><p>Redirecting...</p>
		<?php	
		}
		?>
	</article>
</section>

<?php
include("footer.php");
?>
