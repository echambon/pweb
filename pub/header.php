<!DOCTYPE html>

<?php
$startScriptTime = microtime(TRUE);

// Headers
include("../inc/constants.php");
include("../inc/config.php");
include("../inc/functions.php");

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
$keywords	= $config[8]['val'];
?>

<html>
    <head>
		<link rel="stylesheet" href="../style.css">
		<link rel="icon" href="../inc/img/favicon.ico" />
		<script src="../inc/js/funcShowHide.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="cms-name" content="pweb">
		<meta name="cms-version" content="<?php echo CMS_VERSION; ?>">
		<meta name="keywords" content="<?php echo $keywords; ?>">
        <title>
			<?php echo $title; ?>
		</title>
    </head>

    <body>
		<header>
            <div id="centerblock">
				<h1><a href="index"><?php echo $title; ?></a></h1>
				<h2><?php echo $subtitle; ?></h2>
			</div>
        </header>
