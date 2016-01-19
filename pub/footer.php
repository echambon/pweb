		<footer>
			<div id="centerblock">
				<h1>Contact</h1>
				<p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
			</div>
        </footer>
		
		<?php
		// Getting page generation time
		$endScriptTime = microtime(TRUE);
		$totalScriptTime = $endScriptTime-$startScriptTime;
		?>
		
		<div id="copyright">
			Crystal Clear Icons are licensed under GNU Lesser General Public License (LGPL)
			<br> Last modification: <b><?php echo $lastmodif; ?></b> &bull; <a href="<?php echo CMS_WEBPAGE; ?>" target="_blank">pweb</a> <b><?php echo CMS_VERSION; ?></b> &bull; Generated in <b><?php echo number_format(1000*$totalScriptTime, 0); ?></b> ms
		</div>
    </body>
</html>
