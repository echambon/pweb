<?php
include("header.php");
include("menu.php");

// Config setters
$bdd = mysql_pdo_connect();

// Types:
// 0 - Journal
// 1 - International conference
// 2 - National conference
// 3 - Seminar
// 4 - PhD student conference (unpublished bibtex by default)

// Status:
// 0 - Submitted
// 1 - Accepted, under revision
// 2 - Accepted
// 3 - Published
?>

<section>
	<article>
	<?php if(isset($_SESSION['username'])) { 
		// Get publications
		$query = $bdd->prepare('SELECT * FROM pw_publis ORDER BY year DESC, month DESC');
		$query->execute();
		$publis = $query->fetchAll();
		$query->closeCursor();
		
		$monthList = array("jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec");
		?>
		<h1>New publication</h1>
		
		<p><center><a href="editpubli">Add new publication</a></center></p>
		
		<h1>Publications</h1>
		<p>
			<center>
				<table class="wstyle" width="90%">
					<tr>
						<th width="5%">ID</th>
						<th width="55%">Title</th>
						<th width="10%">Date</th>
						<th width="10%">Type</th>
						<th width="10%">Status</th>
						<th>Actions</th>
					</tr>
					
					<?php
					foreach($publis as $value) {
						$disabled = $value['disabled'];
						$id = $value['id'];
					?>
					<tr>
						<td><?php echo $value['id']; ?></td>
						<td style="text-align:left"><?php echo $value['title']; ?></td>
						<td><?php echo $monthList[$value['month']]; ?>, <?php echo $value['year']; ?></td>
						<td>
						<?php
						switch($value['type']) {
							case 0:
								$type = "Journal";
								break;
							case 1:
								$type = "Int. Conf.";
								break;
							case 2:
								$type = "Nat. Conf.";
								break;
							case 3:
								$type = "Seminar";
								break;
							case 4:
								$type = "PhD Conf.";
								break;
							
						}
						echo $type;
						?>
						</td>
						<td>
						<?php
						switch($value['status']) {
							case 0:
								$status = "Submitted";
								break;
							case 1:
								$status = "Accepted (Rev)";
								break;
							case 2:
								$status = "Accepted";
								break;
							case 3:
								$status = "Published";
								break;
						}
						echo $status;
						?></td>
						<td>
							<a href="editpubli?id=<?php echo $id; ?>&act=1"><img src="../inc/img/admin/page_edit.png" title="Edit publication"></a>
							
							<?php if(!$disabled) { ?>
								<a href="editpubli?id=<?php echo $id; ?>&act=2"><img src="../inc/img/admin/page_disable.png" title="Hide publication"></a>
							<?php } else { ?>
								<a href="editpubli?id=<?php echo $id; ?>&act=3"><img src="../inc/img/admin/page_enable.png" title="Show publication"></a>
							<?php } ?>
							
							<a href="editpubli?id=<?php echo $id; ?>&act=4"><img src="../inc/img/admin/page_delete.png" title="Delete publication"></a>
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
					<td width="20%"><img src="../inc/img/admin/page_edit.png"></td>
					<td width="250px" style="text-align:left">Edit publication</td>
				</tr>
				<tr>
					<td><img src="../inc/img/admin/page_enable.png"></td>
					<td style="text-align:left">Show publication</td>
				</tr>
				<tr>
					<td><img src="../inc/img/admin/page_disable.png"></td>
					<td style="text-align:left">Hide publication</td>
				</tr>
				<tr>
					<td><img src="../inc/img/admin/page_delete.png"></td>
					<td style="text-align:left">Delete publication</td>
				</tr>
			</table>
		</p>
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
