<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/assets/css/style.css">
		<link rel="icon" href="img/favicon.ico" />
		<title><?php echo $error_title; ?></title>
	</head>

	<body>
		<div id="redirectBlock">
			<h1><font color="red"><?php echo $error_type; ?></font></h1>
			
			<p><?php echo $error_message; ?></p>
			
			<p><center><a href="javascript:history.back()">Go Back</a></center></p>
		</div>
	</body>
</html> 
