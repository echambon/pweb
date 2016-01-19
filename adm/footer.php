		<?php
		// Getting page generation time
		$endScriptTime = microtime(TRUE);
		$totalScriptTime = $endScriptTime-$startScriptTime;
		?>
		
		<footer>
			<div id="centerblock">
				<?php if(isset($_SESSION['username'])) { ?>
				Server path: <b><?php echo getcwd(); ?></b> <br />
				Versions: <b><?php echo phpversion(); ?></b> (PHP); <b><?php echo $bdd->getAttribute(constant("PDO::ATTR_SERVER_VERSION")); ?></b> (MySQL); <b><?php echo CMS_VERSION; ?></b> (<a href="<?php echo CMS_WEBPAGE; ?>" target="_blank">pweb</a> CMS) <br />
				<?php } ?>
				Generated in <b><?php echo number_format(1000*$totalScriptTime, 0); ?></b> ms.
			</div>
        </footer>
		
		<div id="copyright">
			<a href="/index">back to website</a>
		</div>
    </body>
</html>
