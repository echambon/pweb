<!DOCTYPE html>

<?php
session_set_cookie_params(1800,"/");
session_start();

$startScriptTime = microtime(TRUE);

// Headers
include("../inc/constants.php");
include("../inc/config.php");
include("../inc/functions.php");
?>

<html>
    <head>
        <link rel="stylesheet" href="../style.css">
		<link rel="icon" href="../inc/img/admin/faviconAdmin.ico" />
		<script type="text/javascript" src="../inc/js/widgEditor/scripts/widgEditor.js"></script>
		<meta name="cms-name" content="pweb">
		<meta name="cms-version" content="<?php echo CMS_VERSION; ?>">
        <title>Admin board</title>
		
		<style type="text/css" media="all">
			@import "../inc/js/widgEditor/css/widgEditor.css";
		</style>
    </head>

    <body>
		<header>
            <div id="centerblock">
				<h1><a href="index">Admin board</a></h1>
				<h2></h2>
			</div>
        </header>
