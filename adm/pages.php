<?php
include("header.php");
include("menu.php");

// Config setters
$bdd = mysql_pdo_connect();

// Get pages order content
$query = $bdd->prepare('SELECT * FROM pw_pages_order ORDER BY order_menu ASC');
$query->execute();
$result = $query->fetchAll();
$query->closeCursor();
?>

<section>
	<article>
		<?php
		if(isset($_SESSION['username'])) {
		?>
			<h1>New page</h1>
			
			<p><center><a href="editpage">Add new page</a></center></p>
			
			<h1>Pages</h1>
			<p>
				<center>
					<table class="wstyle" width="90%">
						<tr>
							<th width="10%">ID</th>
							<th width="50%">Page name (title)</th>
							<th>Actions</th>
						</tr>
						
						<?php
						$query = $bdd->prepare('SELECT COUNT(*) FROM pw_pages');
						$query->execute();
						$pages_nb = $query->fetchColumn();
						$query->closeCursor();
						
						foreach($result as $value) {
							$query = $bdd->prepare('SELECT name FROM pw_pages WHERE id = :id');
							$query->bindParam(':id',$value['page_id']);
							$query->execute();
							$resultItem = $query->fetch();
							$query->closeCursor();
			
							$id = $value['page_id'];
							$hidden = $value['hidden'];
							$protected = $value['protected'];
							$disabled = $value['disabled'];
							$order = $value['order_menu'];
							$name = $resultItem['name'];
							?>
							<tr>
								<td><?php echo $id; ?></td>
								<td style="text-align:left"><?php echo $name; ?></td>
								<td>
									<?php if($order > 0) { ?>
										<a href="editpage?id=<?php echo $id; ?>&act=3"><img src="../inc/img/admin/page_up.png" title="Move page up"></a>
									<?php } else { ?>
										<img src="../inc/img/admin/page_up_deactivated.png" title="Move page up">
									<?php } ?>
									
									<?php if($order < $pages_nb-1) { ?>
										<a href="editpage?id=<?php echo $id; ?>&act=4"><img src="../inc/img/admin/page_down.png" title="Move page down"></a>
									<?php } else { ?>
										<img src="../inc/img/admin/page_down_deactivated.png" title="Move page down">
									<?php } ?>
									
									<?php if($id != 0) { ?>
										<a href="editpage?id=<?php echo $id; ?>&act=1"><img src="../inc/img/admin/page_edit.png" title="Edit page"></a>
									<?php } else { ?>
										<img src="../inc/img/admin/page_edit_disabled.png" title="Page edition is disabled">
									<?php } ?>
									
									<?php if(!$hidden) { ?>
										<a href="editpage?id=<?php echo $id; ?>&act=9"><img src="../inc/img/admin/page_hide.png" title="Hide page (will not appear in menu)"></a>
									<?php } else { ?>
										<a href="editpage?id=<?php echo $id; ?>&act=10"><img src="../inc/img/admin/page_show.png" title="Show page (will appear in menu)"></a>
									<?php } ?>
									
									<?php if(!$disabled) { ?>
										<a href="editpage?id=<?php echo $id; ?>&act=7"><img src="../inc/img/admin/page_disable.png" title="Disable page (will not be accessible)"></a>
									<?php } else { ?>
										<a href="editpage?id=<?php echo $id; ?>&act=8"><img src="../inc/img/admin/page_enable.png" title="Enable page (will be accessible)"></a>
									<?php } ?>
									
									<?php if(!$protected) { ?>
										<a href="editpage?id=<?php echo $id; ?>&act=2"><img src="../inc/img/admin/page_delete.png" title="Delete page"></a>
									<?php } else { ?>
										<img src="../inc/img/admin/page_delete_protected.png" title="Delete page">
									<?php } ?>
								</td>
							</tr>
							<?php
						}
						?>
					</table>
				</center>
			</p>
			
			<h1>Legend</h1>
			<p>
				<table>
					<tr>
						<td width="20%"><img src="../inc/img/admin/page_up.png"></td>
						<td style="text-align:left">Move page up</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_up_deactivated.png"></td>
						<td style="text-align:left">Page cannot be moved up (first page after homepage)</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_down.png"></td>
						<td style="text-align:left">Move page down</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_down_deactivated.png"></td>
						<td style="text-align:left">Page cannot be moved down (last page)</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_edit.png"></td>
						<td style="text-align:left">Edit page</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_edit_disabled.png"></td>
						<td style="text-align:left">Page edition is disabled</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_show.png"></td>
						<td style="text-align:left">Show page in the menu</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_hide.png"></td>
						<td style="text-align:left">Hide page from the menu (remains accessible)</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_enable.png"></td>
						<td style="text-align:left">Enable page</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_disable.png"></td>
						<td style="text-align:left">Disable page (cannot be publicly accessed)</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_delete.png"></td>
						<td style="text-align:left">Delete page</td>
					</tr>
					<tr>
						<td><img src="../inc/img/admin/page_delete_protected.png"></td>
						<td style="text-align:left">Page is protected and cannot be deleted</td>
					</tr>
				</table>
			</p>
		<?php
		} else { // redirect to index
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
