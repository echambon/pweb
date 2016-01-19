<?php
include("header.php");
include("menu.php");

// Config setters
$bdd = mysql_pdo_connect();

// Some useful variables
$query = $bdd->prepare("SELECT COUNT(*) FROM pw_pages");
$query->execute();
$pages_nb = $query->fetchColumn();
$query->closeCursor();
?>

<section>
	<article>
	<?php if(isset($_SESSION['username'])) { ?>
	
		<?php if(!isset($_GET['act'])) { 
			$formActive = 1;
			$editing = 0;
			?>
			<h1>Page creation</h1>
			
			<p>Here, you can add a new page to your website. Note it will be automatically added in the menu after the last existing page. You can edit these parameters on the pages table after creation.</p>
		<?php
		}
		else
		{
			$act = (int)htmlspecialchars($_GET['act']);
			$formActive = 0;
			$editing = 0;
			if(!isset($_GET['id'])) {
			?>
				<meta http-equiv="refresh" content="1; URL=pages">
				<h1><font color="red">No page selected.</font></h1><p>Redirecting...</p>
			<?php
			} else {
				$id = (int)htmlspecialchars($_GET['id']);
				
				// Get current page data and page order nb
				$query = $bdd->prepare('SELECT * FROM pw_pages_order WHERE page_id = :page_id');
				$query->bindParam(':page_id',$id);
				$query->execute();
				
				if($query != NULL) {
					$resultItem = $query->fetch();
					$query->closeCursor();
					
					if($resultItem != NULL) {
						if($act > 2) {
							if(!mysql_edit_page_by_id($bdd,$id,$act,$pages_nb)) {
							?>
								<meta http-equiv="refresh" content="1; URL=pages">
								<h1><font color="red">Undocumented error.</font></h1><p>Don't mess up with the URL parameters! Redirecting...</p>
							<?php
							} else {
								// Update last modification date
								mysql_update_lastmodif($bdd);
							?>
								<meta http-equiv="refresh" content="0; URL=pages">
								<h1><font color="blue">Page edited.</font></h1><p>Redirecting...</p>
							<?php
							}
						} else if($act == 2) {
						?>
							<h1>Delete page</h1>
							<?php
							if($_SERVER['REQUEST_METHOD'] == 'POST') {
								// Delete page from pw_pages
								$query = $bdd->prepare('DELETE FROM pw_pages WHERE id = :id');
								$query->bindParam(':id',$id);
								$query->execute();
								
								// Update order_menu for pages with greater order_menu ...
								$query = $bdd->prepare('SELECT order_menu FROM pw_pages_order WHERE page_id=:page_id');
								$query->bindParam(':page_id',$id);
								$query->execute();
								$resultOrderMenu = $query->fetch(PDO::FETCH_ASSOC);
								$query->closeCursor();
								
								$delpageOrderMenu = $resultOrderMenu['order_menu'];
								for($ii = $delpageOrderMenu+1; $ii < $pages_nb; $ii++) {
									$newOrderMenu = $ii - 1;
									$query = $bdd->prepare('UPDATE pw_pages_order SET order_menu = :newOrderMenu WHERE order_menu = :ii');
									$query->bindParam(':newOrderMenu',$newOrderMenu);
									$query->bindParam(':ii',$ii);
									$query->execute();
								}
								
								// Delete page info from pw_pages_order								
								$query = $bdd->prepare('DELETE FROM pw_pages_order WHERE page_id = :page_id');
								$query->bindParam(':page_id',$id);
								$query->execute();
								
								// Update last modification date
								mysql_update_lastmodif($bdd);
								?>
								<meta http-equiv="refresh" content="1; URL=pages">
								<p><center><font color="blue"><b>Page was deleted! Redirecting...</b></font></center></p>
							<?php
							} else {
							?>
								<form method=post action="editpage?id=<?php echo $id; ?>&act=2">
									<center>
										Do you really want to delete this page (ID: <b><?php echo $id; ?></b>)?</br><font color="red"><b>This cannot be reversed!!!</b></font></br>
										<input type="submit" value="Confirm"> or <a href="pages">Cancel</a>
									</center>
								</form>
							<?php
							}
						} else if($act == 1) {
							if($id != 0) {
								$formActive = 1;
								$editing = 1;
								?>
								<h1>Page edition</h1>
								
								<p>You are editing a page (ID: <b><?php echo $id; ?></b>).</p>
								<?php
							} else {
								?>
								<meta http-equiv="refresh" content="1; URL=pages">
								<h1><font color="red">Uneditable page.</font></h1><p>You are not allowed to edit this page! Redirecting...</p>
								<?php
							}
						} else {
							?>
							<meta http-equiv="refresh" content="1; URL=pages">
							<h1><font color="red">Undocumented error.</font></h1><p>Don't mess up with the URL parameters! Redirecting...</p>
							<?php
						}
					} else {
						?>
						<meta http-equiv="refresh" content="1; URL=pages">
						<h1><font color="red">Page ID not found.</font></h1><p>Redirecting...</p>
						<?php
					}
				} else {
					?>
					<meta http-equiv="refresh" content="1; URL=pages">
					<h1><font color="red">Invalid ID.</font></h1><p>Redirecting...</p>
					<?php
				}
			}
		}
		?>	
		
		<?php
		if($formActive) {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				if(!$editing) {
					if(!htmlspecialchars(empty($_POST['content'])) && !empty(htmlspecialchars($_POST['title']))) {
						// Add page to the pw_pages table
						$stmt = $bdd->prepare('INSERT INTO pw_pages (name,content) VALUES (:name, :content)');
						$stmt->bindParam(':name',$name);
						$stmt->bindParam(':content',$content);
						
						$name = htmlspecialchars($_POST['title']);
						$content = htmlspecialchars($_POST['content']);
						$stmt->execute();
						
						// Add the page order entry
						// TODO
						$stmt = $bdd->prepare('INSERT INTO pw_pages_order (page_id,order_menu,hidden,disabled,protected) VALUES (:page_id, :order_menu, 0, 0, 0)');
						$stmt->bindParam(':page_id',$page_id);
						$stmt->bindParam(':order_menu',$order_menu);
						
						// Recover page_id
						$query = $bdd->prepare('SELECT * FROM pw_pages ORDER BY id DESC LIMIT 1');
						$query->execute();
						$lastPageId = $query->fetch(PDO::FETCH_ASSOC);
						$query->closeCursor();
						
						$page_id = $lastPageId['id'];
						
						// Recover bigger order_menu (=number of pages)
						$order_menu = $pages_nb;
						
						// Execute statement
						$stmt->execute();
						
						// Update last modification date
						mysql_update_lastmodif($bdd);
						?>
						<meta http-equiv="refresh" content="1; URL=pages">
						<p><center><font color="blue"><b>Page was created successfully! Redirecting...</b></font></center></p>
						<?php
					} else {
					?>
					<meta http-equiv="refresh" content="1; URL=pages">
					<p><center><font color="red"><b>Empty fields detected!</b></font></center></p>
					<?php
					}
				} else {
					// UPDATE
					if(!htmlspecialchars(empty($_POST['content'])) && !empty(htmlspecialchars($_POST['title']))) {
						// Variables
						$name = htmlspecialchars($_POST['title']);
						$content = htmlspecialchars($_POST['content']);
						
						// Update entry in pages table
						$query = $bdd->prepare('UPDATE pw_pages SET name=:name, content=:content WHERE id=:id');
						$query->bindParam(':id',$id);
						$query->bindParam(':name',$name);
						$query->bindParam(':content',$content);
						$query->execute();
						
						// Update last modification date
						mysql_update_lastmodif($bdd);
						?>
						<meta http-equiv="refresh" content="1; URL=pages">
						<p><center><font color="blue"><b>Page was edited successfully! Redirecting...</b></font></center></p>
						<?php
					} else {
					?>
					<p><center><font color="red"><b>Empty fields detected!</b></font></center></p>
					<?php
					}
				}
			} else {
		?>
		
		<?php
		if($editing) {
			$query = $bdd->prepare('SELECT * FROM pw_pages WHERE id=:id LIMIT 1');
			$query->bindParam(':id',$id);
			$query->execute();
			$pageInfo = $query->fetch(PDO::FETCH_ASSOC);
			$query->closeCursor();
			
			$name = $pageInfo['name'];
			$content = htmlspecialchars_decode($pageInfo['content']);
		}
		?>
			<form method=post action="editpage<?php if($editing) { ?>?id=<?php echo $id; ?>&act=1<?php } ?>">
				<h2>Title</h2><input type="text" name="title" size="50" value="<?php if($editing) { echo $name; } ?>">
				<h2>Content</h2>
				<textarea id="content" name="content" class="widgEditor nothing">
				<?php if($editing) { echo $content; } ?>
				</textarea>
				<center>
					<input type="submit" value="<?php if(isset($_GET['act'])) { ?>Edit<?php } else { ?>Create<?php } ?> page">
					 or <a href="pages">Cancel</a>
				</center>
			</form>
			<?php }} ?>
	<?php
	} else {
	?>
		<meta http-equiv="refresh" content="0; URL=index">
		<h1><font color="red">Not connected.</font></h1><p>Redirecting...</p>
	<?php
	}
	?>
	</article>
</section>

<?php
include("footer.php");
?>
