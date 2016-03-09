<?php
// KNOWN BUGS: not all hyphens are supported in mysql_print_publis_by_type, at the moment: acute, grave and circ (on all chars)

/* 
* mysql_pdo_connect
* Connects to MySql DB and returns DB handler
*/
function mysql_pdo_connect() {
	try {
		$bdd = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8',''.MYSQL_USER.'',''.MYSQL_PASSWD.'');
	}
	catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
	return $bdd;
}

/* 
* mysql_get_website_config
* Fetches pw_config content in an array
*/
function mysql_get_website_config($bdd) {
	$query = $bdd->prepare('SELECT * FROM pw_config');
	$query->execute();
	$result = $query->fetchAll();
	$query->closeCursor();
	
	return $result;
}

/*
* mysql_print_page_content_by_id
* Prints the page content or an error message if the page is not found
*/
function mysql_print_page_content_by_id($bdd,$id) {
	$query = $bdd->prepare('SELECT * FROM pw_pages WHERE id=:id LIMIT 1');
	$query->bindParam(':id',$id);
	$query->execute();
	$result = $query->fetchAll();
	$query->closeCursor();
	
	$query = $bdd->prepare('SELECT * FROM pw_pages_order WHERE page_id=:id LIMIT 1');
	$query->bindParam(':id',$id);
	$query->execute();
	$resultInfo = $query->fetch(PDO::FETCH_ASSOC);
	$query->closeCursor();
	
	if($result != NULL) {
		if(!$resultInfo['disabled']) {
			echo htmlspecialchars_decode($result[0]['content']);
		} else {
			echo "<h1><font color='red'>Error</font></h1><p>This page is not accessible. Redirecting...</p><meta http-equiv='refresh' content='1; URL=index'>";
		}
	} else {
		echo "<h1><font color='red'>Error</font></h1><p>The page you are looking for does not exist. Redirecting...</p><meta http-equiv='refresh' content='1; URL=index'>";
	}
}

/*
* mysql_edit_page_by_id
* 
*/
function mysql_edit_page_by_id($bdd,$id,$act,$pages_nb) {
	// Recover page order information	
	$query = $bdd->prepare('SELECT * FROM pw_pages_order WHERE page_id=:id LIMIT 1');
	$query->bindParam(':id',$id);
	$query->execute();
	$pageOrderInfo = $query->fetch(PDO::FETCH_ASSOC);
	$query->closeCursor();
	
	// $act == 3: page up
	if($act == 3) {
		$oldPageOrder = $pageOrderInfo['order_menu'];
		if($oldPageOrder > 0) {
			$newPageOrder = $oldPageOrder-1;
			// Update page order and next page order info
			$query = $bdd->prepare('UPDATE pw_pages_order SET order_menu=:oldPageOrder WHERE order_menu=:newPageOrder');
			$query->bindParam(':oldPageOrder',$oldPageOrder);
			$query->bindParam(':newPageOrder',$newPageOrder);
			$query->execute();
			
			$query = $bdd->prepare('UPDATE pw_pages_order SET order_menu=:newPageOrder WHERE page_id=:page_id');
			$query->bindParam(':newPageOrder',$newPageOrder);
			$query->bindParam(':page_id',$id);
			$query->execute();
			// No error
			return 1;
		}
	// $act == 4: page down
	} else if($act == 4) {
		// Check if page order can be increased
		$oldPageOrder = $pageOrderInfo['order_menu'];
		if($oldPageOrder < $pages_nb-1) {
			$newPageOrder = $oldPageOrder+1;
			// Update page order and next page order info
			$query = $bdd->prepare('UPDATE pw_pages_order SET order_menu=:oldPageOrder WHERE order_menu=:newPageOrder');
			$query->bindParam(':oldPageOrder',$oldPageOrder);
			$query->bindParam(':newPageOrder',$newPageOrder);
			$query->execute();
			
			$query = $bdd->prepare('UPDATE pw_pages_order SET order_menu=:newPageOrder WHERE page_id=:page_id');
			$query->bindParam(':newPageOrder',$newPageOrder);
			$query->bindParam(':page_id',$id);
			$query->execute();
			// No error
			return 1;
		}
	// $act == 7: disable page
	} else if($act == 7) {
		// Check if page is not already disabled
		$isDisabled = $pageOrderInfo['disabled'];
		if(!$isDisabled) {
			// Set page status to disabled
			$query = $bdd->prepare('UPDATE pw_pages_order SET disabled=1 WHERE page_id=:page_id');
			$query->bindParam(':page_id',$id);
			$query->execute();
			// No error
			return 1;
		}
	// $act == 8: enable page
	} else if($act == 8) {
		// Check if page is not already enabled
		$isEnabled = !$pageOrderInfo['disabled'];
		if(!$isEnabled) {
			// Set page status to enabled
			$query = $bdd->prepare('UPDATE pw_pages_order SET disabled=0 WHERE page_id=:page_id');
			$query->bindParam(':page_id',$id);
			$query->execute();
			// No error
			return 1;
		}
	// $act == 9: hide page from menu
	} else if($act == 9) {
		$isHidden = $pageOrderInfo['hidden'];
		if(!$isHidden) {
			// Set page status to hidden
			$query = $bdd->prepare('UPDATE pw_pages_order SET hidden=1 WHERE page_id=:page_id');
			$query->bindParam(':page_id',$id);
			$query->execute();
			// No error
			return 1;
		}
	// $act == 10: show page in menu
	} else if($act == 10) {
		$isShown = !$pageOrderInfo['hidden'];
		if(!$isShown) {
			// Set page status to hidden
			$query = $bdd->prepare('UPDATE pw_pages_order SET hidden=0 WHERE page_id=:page_id');
			$query->bindParam(':page_id',$id);
			$query->execute();
			// No error
			return 1;
		}
	}
	return 0;
}

/*
*
*
*/
function mysql_edit_publi_by_id($bdd,$id,$act) {
	// Recover publication information
	// N.B.: at this stage, the publication is known to exist
	$query = $bdd->prepare('SELECT disabled FROM pw_publis WHERE id=:id LIMIT 1');
	$query->bindParam(':id',$id);
	$query->execute();
	$publiInfo = $query->fetch(PDO::FETCH_ASSOC);
	$query->closeCursor();
	
	// $act == 2: disable publication
	if($act == 2) {
		// Check if publication is not already disabled
		$isDisabled = $publiInfo['disabled'];
		if(!$isDisabled) {
			// Set page status to disabled
			$query = $bdd->prepare('UPDATE pw_publis SET disabled=1 WHERE id=:id');
			$query->bindParam(':id',$id);
			$query->execute();
			// No error
			return 1;
		}
	// $act == 3: enable publication
	} else if($act == 3) {
		// Check if publication is not already enabled
		$isEnabled = !$publiInfo['disabled'];
		if(!$isEnabled) {
			// Set page status to enabled
			$query = $bdd->prepare('UPDATE pw_publis SET disabled=0 WHERE id=:id');
			$query->bindParam(':id',$id);
			$query->execute();
			// No error
			return 1;
		}
	}
}

/*
* mysql_update_lastmodif
* This updates the last modification entry in pw_config
*/
function mysql_update_lastmodif($bdd) {
	$query = $bdd->prepare('UPDATE pw_config SET val=:lastmodif WHERE id=1');
	$query->bindParam(':lastmodif',$date);
	
	$date = date("Y/m/d");
	
	$query->execute();
}

/*
*
*
*/
function mysql_print_publis_by_type($bdd,$type) {
	$query = $bdd->prepare('SELECT * FROM pw_publis WHERE type=:type ORDER BY status ASC, year DESC, month DESC');
	$query->bindParam(':type',$type);
	$query->execute();
	$phdconf = $query->fetchAll();
	$query->closeCursor();
		
	$currentYear = 0;
	
	$h2printed = 0;
	foreach($phdconf as $value) {
		// New h2 subsection if year is different from the previous one
		if(!$value['disabled']) {
			$bibtexType = "@unpublished";
			switch($value['status']) {
					case 0:
						if(!$h2printed) {
							echo "<h2>Submitted</h2>";
							$h2printed = 1;
						}
						break;
					case 1:
						if(!$h2printed) {
							echo "<h2>Accepted (under revision)</h2>";
							$h2printed = 1;
						}
						break;
					case 2:
						if(!$h2printed) {
							echo "<h2>Accepted</h2>";
							$h2printed = 1;
						}
						break;
					case 3:
						if($value['year'] != $currentYear) {
							$currentYear = $value['year'];
							echo "<h2>".$currentYear."</h2>";
						}
						switch($value['type']) {
							case 0:
								$bibtexType = "@article";
								break;
							case 1:
								$bibtexType = "@inproceedings";
								break;
							case 2:
								$bibtexType = "@inproceedings";
								break;							
						}
						break;
			}
			
			// Create citation div
			echo "<div id='citation'>";
			
			// Print title
			echo "<p class='title'>".$value['title']."</p>";
			
			// Print authors
			echo "<p class='authors'>".$value['authors']."</p>";
			
			// Print source
			echo "<p class='source'>";
			switch($value['type']) {
				case 0: // Journal
					echo "In ";
					break;
				case 1: // Int conf
					echo "In Proc. of the ";
					break;
				case 2:
					echo "In Proc. of the ";
					break;
				case 3:
					echo "";
					break;
				case 4:
					echo "Accepted for presentation in the ";
					break;
			}
			echo $value['source'];
			if($value['address'] != "") {
				echo ", ".$value['address'];
			}
			echo ", ".$value['year']."</p>";
			
			// Print note if any
			if($value['note'] != '') {
				echo "<p class='note'>".$value['note']."</p>";
			}
			
			// Buttons p
			echo "<p class=\"buttons\">";
			
			if($value['type'] != 3) { // this is not a seminar (for which only slides are useful)
				// Print abstract button
				echo "<a href=\"#\" class=\"showAbstract\" onclick=\"showHide('".$value['bibtex_id']."_abstract');return false;\">Abstract</a>";
				
				// Print bibtex button
				echo "<a href=\"#\" class=\"showLink\" onclick=\"showHide('".$value['bibtex_id']."');return false;\">Show/Hide BibTeX</a>";
				
				// Print pdf file link, if any
				if($value['pdf'] != '') {
					//old pdfjs version, echo "<a target=\"_blank\" href=\"../inc/js/pdfjs/web/viewer.html?file=http://".$_SERVER['HTTP_HOST']."/assets/publis/".$value['pdf']."\" class=\"downloadLink\">View online</a>";
					echo "<a target=\"_blank\" href=\"../assets/publis/".$value['pdf']."\" class=\"downloadLink\">View online</a>";
				}
			}
			
			// Print link to slides, if any
			if($value['pdfslides'] != '') {
				//old pdfjs version, echo "<a target=\"_blank\" href=\"../inc/js/pdfjs/web/viewer.html?file=http://".$_SERVER['HTTP_HOST']."/assets/slides/".$value['pdfslides']."\" class=\"slidesLink\">Slides</a>";
				echo "<a target=\"_blank\" href=\"../assets/slides/".$value['pdfslides']."\" class=\"slidesLink\">Slides</a>";
			}
			
			// Print link to downlodable archive, if any
			if($value['zipfile'] != '') {
				echo "<a target=\"_blank\" href=\"../assets/archives/".$value['zipfile']."\" class=\"downloadZipLink\">".$value['zipfile']."</a>";
			}
			
			// End buttons p
			echo "</p>";
			
			// Print abstract
			echo "<div id=\"".$value['bibtex_id']."_abstract\" class=\"more\"><p><b>Abstract</b></p><p>".$value['abstract']."</p></div>";
			
			// Generate bibtex
			echo "<div id=\"".$value['bibtex_id']."\" class=\"more\"><p class=\"bibtex_code\">".$bibtexType."{".$value['bibtex_id'].",</p><div id=\"tabulated\" class=\"bibtex_code\">";
			
				// Address
				if($value['address'] != "") {
					echo "address = {".str_replace(array(" ","(",")"),array("",", ",""),$value['address'])."},<br>";
				}
			
				// Accentuation replacement for bibtex reference
				$pattern = array('#&([A-za-z])(acute);#','#&([A-za-z])(grave);#','#&([A-za-z])(circ);#');
				$replacement = array('\\\'{$1}','\\\`{$1}','\\\^{$1}');
			
				// Title
				$title = htmlentities($value['title'], ENT_NOQUOTES, CHARSET);
				$titleNoHyphen = preg_replace($pattern, $replacement, $title);
				
				echo "title = {".str_replace(array("é"),array("e"),$titleNoHyphen)."},<br>";
				
				// Booktitle or journal (source)
				$source = htmlentities($value['source'], ENT_NOQUOTES, CHARSET);
				$sourceNoHyphen = preg_replace($pattern, $replacement, $source);
				
				if($type == 0) {
					echo "journal = {";
				} else {
					echo "booktitle = {Proc. of the ";
				}
				echo $sourceNoHyphen."},<br>";
				
				// Authors
				$authors = htmlentities($value['authors'], ENT_NOQUOTES, CHARSET);
				$authorsNoHyphen = preg_replace('#&([A-za-z])(acute|grave);#', "\'{1}", $authors);
				$authorsNoComma = preg_replace('#,#',"", $authorsNoHyphen);
				
				echo "author = {";
				
				$explodedAuthors = explode(" ", $authorsNoComma);
				for($ii=0; $ii<sizeof($explodedAuthors); $ii += 2) {
					echo $explodedAuthors[$ii+1].", ".substr($explodedAuthors[$ii], 0, 1).".";
					if($ii<sizeof($explodedAuthors)-2) {
						echo " and ";
					}
				}
				
				echo "},<br>";
				
				// Pages, if defined
				if($value['pages'] != '') {
					echo "pages = {".$value['pages']."},<br>";
				}
				
				// Month
				$monthList = array("jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec");
				echo "month = ".$monthList[$value['month']].",<br>";
				
				// Year
				echo "year = {".$value['year']."}";
				
				// URL
				if($value['pdf'] != '') {
					echo ",<br>url = {http://".$_SERVER['HTTP_HOST']."/assets/publis/".$value['pdf']."}";
				}
			
			echo "</div><p class=\"bibtex_code\">}</p></div>";
			
			// End citation div
			echo "</div>";
		}
	}
}

/*
*	file_upload
*	Uploads file to given destination and returns error code if failed
*/
function file_upload($file_to_upload,$target_file,$extension) {
	$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
							
	// Check file size
	if ($file_to_upload['size'] > 10000000) { // 10 Mo max
		return 1;
	}
	
	// Check type
	if($fileType != $extension) { // "pdf"
		return 2;
	}
	
	if(!move_uploaded_file($file_to_upload['tmp_name'],$target_file)) {
		return 3;
	}
	
	return 0;
}
?>
