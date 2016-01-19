<?php
include("header.php");
include("menu.php");

// Config setters
$bdd = mysql_pdo_connect();
?>

<section>
	<article>
		<?php
		if(isset($_SESSION['username'])) {
		?>
			<h1>Admin board</h1>
			
			<p>Welcome on the administration board! You can modify the website configuration on this page.</p>
			
			<h1>Website configuration</h1>
			<?php
			$query = $bdd->prepare('SELECT * FROM pw_config');
			$query->execute();
			$websiteInfo = $query->fetchAll();
			$query->closeCursor();
			
			$username 	= $websiteInfo[3]['val'];
			$hashpasswd	= $websiteInfo[4]['val'];
			
			if(isset($_POST['submit'])) {
				$error = 0;
				// check empty fields (some can be left empty)
				if(!empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) {
					$newPassword = 0;
					if(!empty($_POST['newpassword'])) {
						$newPassword = 1;
						$options = [
							'cost' => 10,
							'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
						];
						$newPasswordBcrypt = password_hash(htmlspecialchars($_POST['newpassword']), PASSWORD_BCRYPT, $options);
					}
					
					if($newPassword) {
						if(!empty($_POST['newpasswordrepeat'])) {
							$newPasswordRepeat = password_hash(htmlspecialchars($_POST['newpasswordrepeat']), PASSWORD_BCRYPT, $options);
							if($newPasswordBcrypt != $newPasswordRepeat) {
								$error = 1;
								echo "<font color=\"red\"><b>The two passwords do not match.</b></font></br>";
							}
						} else {
							$error = 1;
							echo "<font color=\"red\"><b>Please repeat new password.</b></font></br>";
						}
					}
					
					$upload = 0;
					if(!empty($_FILES['fileToUpload']['name'])) {
						$target_dir = "../assets/";
						$target_file = $target_dir . "id.png";
						$imageFileType = pathinfo(basename($_FILES['fileToUpload']['name']),PATHINFO_EXTENSION);
						$upload = 1;
						
						$check = getimagesize($_FILES['fileToUpload']['tmp_name']);
						if($check == false) {
							echo "<font color=\"red\"><b>File is not an image.</b></font></br>";
							$error = 1;
						}
						
						// Check file size
						if ($_FILES['fileToUpload']['size'] > 500000) {
							echo "<font color=\"red\"><b>Picture is too large.</b></font></br>";
							$error = 1;
						}
						
						// Check type
						if($imageFileType != "png") {
							echo "<font color=\"red\"><b>Only PNG files are allowed.</b></font></br>";
							$error = 1;
						}
					}
					
					if(!$error && $upload) {
						if(file_exists($target_file)) unlink($target_file);
						if(!move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$target_file)) {
							$error = 1;
							echo "<font color=\"red\"><b>An error occurred while uploading the file.</b></font></br>";
						}
					}
					
					if(!empty($_POST['newusername'])) {
						$username_bdd = htmlspecialchars($_POST['newusername']);
					} else {
						$username_bdd = htmlspecialchars($_POST['username']);
					}
					
					if(!$error) {
						// First, check that current username and password are correct
						if(htmlspecialchars($_POST['username']) == $username && password_verify(htmlspecialchars($_POST['password']), $hashpasswd)) {
							// Update password, if required
							if($newPassword) {
								$newPasswordBcrypt = $bdd->quote($newPasswordBcrypt); // protect with escape characters
								$sql = "UPDATE pw_config SET val=".$newPasswordBcrypt." WHERE id=5";
								$query = $bdd->prepare($sql);
								$query->execute();
							}
							
							// Update website name, subtitle, username, email and homepage content
							$query = $bdd->prepare("UPDATE pw_config SET val='".htmlspecialchars($_POST['name'])."' WHERE id=2"); $query->execute();
							$query = $bdd->prepare("UPDATE pw_config SET val='".htmlspecialchars($_POST['subtitle'])."' WHERE id=3"); $query->execute();
							$query = $bdd->prepare("UPDATE pw_config SET val='".$username_bdd."' WHERE id=4"); $query->execute();
							$query = $bdd->prepare("UPDATE pw_config SET val='".htmlspecialchars($_POST['email'])."' WHERE id=6"); $query->execute();
							$query = $bdd->prepare("UPDATE pw_config SET val='".htmlspecialchars($_POST['content'])."' WHERE id=8"); $query->execute();
							$query = $bdd->prepare("UPDATE pw_config SET val='".htmlspecialchars($_POST['keywords'])."' WHERE id=9"); $query->execute();
							
							// Update last modification date
							mysql_update_lastmodif($bdd);
							echo "<font color=\"blue\"><b>Website configuration updated.</b></font></br>";
							?>
								<meta http-equiv="refresh" content="1; URL=index">
							<?php
						} else {
							echo "<font color=\"red\"><b>Wrong credentials.</b></font></br>";
						}
					}
				} else {
					echo "<font color=\"red\"><b>Some information are missing.</b></font>";
				}
			} else {
		?>
		
		<form method="post" action="index" enctype="multipart/form-data">
			<table>
				<tr>
					<td style="text-align:left">Website title:</td>
					<td style="text-align:left"><input type="text" name="name" size="30" value="<?php echo $websiteInfo[1]['val']; ?>"><font color="red"><b>*</b></font></td>
				</tr>
				<tr>
					<td style="text-align:left">Website subtitle:</td>
					<td style="text-align:left"><input type="text" name="subtitle" size="30" value="<?php echo $websiteInfo[2]['val']; ?>"></td>
				</tr>
				<tr>
					<td style="text-align:left">Current username:</td>
					<td style="text-align:left"><input type="text" name="username" size="30"><font color="red"><b>*</b></font></td>
				</tr>
				<tr>
					<td style="text-align:left">New username:</td>
					<td style="text-align:left"><input type="text" name="newusername" size="30"></td>
				</tr>
				<tr>
				<tr>
					<td style="text-align:left">Current password:</td>
					<td style="text-align:left"><input type="password" name="password" size="30"><font color="red"><b>*</b></font></td>
				</tr>
				<tr>
					<td style="text-align:left">New password:</td>
					<td style="text-align:left"><input type="password" name="newpassword" size="30"></td>
				</tr>
				<tr>
					<td style="text-align:left">Repeat password:</td>
					<td style="text-align:left"><input type="password" name="newpasswordrepeat" size="30"></td>
				</tr>
				<tr>
					<td style="text-align:left">Email:</td>
					<td style="text-align:left"><input type="text" name="email" size="30" value="<?php echo $websiteInfo[5]['val']; ?>"><font color="red"><b>*</b></font></td>
				</tr>
				<tr>
					<td style="text-align:left">Keywords:</td>
					<td style="text-align:left"><input type="text" name="keywords" size="30" value="<?php echo $websiteInfo[8]['val']; ?>"></td>
				</tr>
				<tr>
					<td style="text-align:left">ID picture:</td>
					<td><input type="file" name="fileToUpload" id="fileToUpload"><font color="red"><b>(N.B.: this will overwrite current image)</b></font></td>
				</tr>
			</table>
			<p>
			<textarea id="content" name="content" class="widgEditor nothing"><?php echo htmlspecialchars_decode($websiteInfo[7]['val']); ?></textarea>
			</p>
			<p><input type="submit" value="Save" name="submit"></p>
		</form>
		<?php }
	} else {
	?>
		<h1>Log in form</h1>
		<p>You are not connected. Please connect now to access the administration tools.</p>
		
		<form method=post action="login">
			<table style="width:100%">
			<tr>
				<td style="padding-top:20px">Username<br><input type="text" name="username"></td>
			</tr>
			<tr>
				<td style="padding-top:20px">Password<br><input type="password" name="password"></td>
			</tr>
			<tr>
				<td style="padding-top:20px"><input type="submit" value="Log in"></td>
			</tr>
			</table>
		</form>
	<?php
	}
	?>
	</article>
</section>

<?php
include("footer.php");
?>
