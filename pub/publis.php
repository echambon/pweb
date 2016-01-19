<?php
include("header.php");
include("menu.php");

// Check if publications page is enabled
$query = $bdd->prepare('SELECT disabled FROM pw_pages_order WHERE page_id = 0');
$query->execute();
$isDisabled = $query->fetchColumn();
$query->closeCursor();

// Count publications types
$query = $bdd->prepare('SELECT COUNT(*) FROM pw_publis WHERE type = 0 AND disabled = 0');
$query->execute();
$journal_nb = $query->fetchColumn();
$query->closeCursor();

$query = $bdd->prepare('SELECT COUNT(*) FROM pw_publis WHERE type = 1 AND disabled = 0');
$query->execute();
$intconf_nb = $query->fetchColumn();
$query->closeCursor();

$query = $bdd->prepare('SELECT COUNT(*) FROM pw_publis WHERE type = 2 AND disabled = 0');
$query->execute();
$natconf_nb = $query->fetchColumn();
$query->closeCursor();

$query = $bdd->prepare('SELECT COUNT(*) FROM pw_publis WHERE type = 3 AND disabled = 0');
$query->execute();
$seminar_nb = $query->fetchColumn();
$query->closeCursor();

$query = $bdd->prepare('SELECT COUNT(*) FROM pw_publis WHERE type = 4 AND disabled = 0');
$query->execute();
$phdconf_nb = $query->fetchColumn();
$query->closeCursor();
?>

<section>
	<article>
		<?php
		if(!$isDisabled) {
			if($journal_nb > 0) {
			?>
				<h1>Journals</h1>
				<?php
				mysql_print_publis_by_type($bdd,0);
			}
			?>
			
			<?php
			if($intconf_nb > 0) {
			?>
				<h1>International conferences</h1>
				<?php
				mysql_print_publis_by_type($bdd,1);
			}
			?>
			
			<?php
			if($natconf_nb > 0) {
			?>
				<h1>National conferences</h1>
				<?php
				mysql_print_publis_by_type($bdd,2);
			}
			?>
			
			<?php
			if($seminar_nb > 0) {
			?>
				<h1>Seminars</h1>
				<?php
				mysql_print_publis_by_type($bdd,3);
			}
			?>
			
			<?php
			if($phdconf_nb > 0) {
			?>
				<h1>PhD Students Conferences</h1>
				<?php
				mysql_print_publis_by_type($bdd,4);
			}
		} else {
			echo "<h1><font color='red'>Error</font></h1><p>The page you are looking for does not exist. Redirecting...</p><meta http-equiv='refresh' content='1; URL=index'>";
		}
		?>
	</article>
</section>

<?php
include("footer.php");
?>
