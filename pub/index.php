<?php
include("header.php");
include("menu.php");
?>

<section>
	<article>
		<table style="width:100%">
		<tr>
			<td width="25%"><img src="../assets/<?php echo $idimg; ?>"></td>
			<td colspan="3" class="leftalign">
			<?php echo htmlspecialchars_decode($hometext); ?>
			</td>
		</tr>
		</table> 
	</article>
</section>

<?php
include("footer.php");
?>