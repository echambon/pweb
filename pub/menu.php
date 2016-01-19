<nav>
	<ul>
		<li><a href="index">Home</a></li>
		<?php
		$query = $bdd->prepare('SELECT * FROM pw_pages_order WHERE disabled = 0 AND hidden = 0 ORDER BY order_menu ASC');
		$query->execute();
		$result = $query->fetchAll();
		$query->closeCursor();
		
		foreach($result as $value) {
			$query = $bdd->prepare('SELECT name FROM pw_pages WHERE id = :id');
			$query->bindParam(':id',$value['page_id']);
			$query->execute();
			$resultItem = $query->fetch();
			$query->closeCursor();
			if($value['page_id'] == 0) {
			?>
				<li><a href="publis"><?php echo $resultItem[0]; ?></a></li>
			<?php
			} else {
			?>
				<li><a href="<?php echo $value['page_id']; ?>"><?php echo $resultItem[0]; ?></a></li>
			<?php
			}
		}
		?>
	</ul>
</nav>
