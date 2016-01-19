<?php
include("header.php");
include("menu.php");
?>

<section>
	<article>
		<?php
		if(!isset($_GET['id'])) {
		?>
			<h1><font color="red">Error</font></h1>
			<p>You are not allowed to view this page. Redirecting...</p>
			<meta http-equiv="refresh" content="1; URL=index.php">
		<?php
		} else {
			if(htmlspecialchars($_GET['id']) == 0) {
				$stmt = $bdd->prepare("SELECT disabled FROM pw_pages_order WHERE page_id='0'");
				$stmt->execute();
				$isDisabled = $stmt->fetchColumn();//fetch(PDO::FETCH_ASSOC);
				$stmt->closeCursor();
				if(!$isDisabled) {
				?>
					<meta http-equiv="refresh" content="0; URL=publis.php">
				<?php
				} else {
					echo "<h1><font color='red'>Error</font></h1><p>The page you are looking for does not exist. Redirecting...</p><meta http-equiv='refresh' content='1; URL=index.php'>";
				}
			} else {
				mysql_print_page_content_by_id($bdd,(int)htmlspecialchars($_GET['id']));
			}
		}
		?>		
	</article>
</section>

<?php
include("footer.php");
?>
