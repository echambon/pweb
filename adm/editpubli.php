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
	<?php 
	if(isset($_SESSION['username'])) {
		$monthList = array("jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec");
		?>
	
		<?php
		if(!isset($_GET['act'])) { 
			$formActive = 1;
			$editing = 0;
			?>
			<h1>New publication</h1>
			
			<p>Here, you can add a new publication to the publications page. You will also be able to edit the following parameters on the publications list.</p>
		<?php
		}
		else
		{
			$act = (int)htmlspecialchars($_GET['act']);
			$formActive = 0;
			$editing = 0;
			if(!isset($_GET['id'])) {
			?>
				<meta http-equiv="refresh" content="1; URL=publis">
				<h1><font color="red">No publication selected.</font></h1><p>Redirecting...</p>
			<?php
			} else {
				$id = (int)htmlspecialchars($_GET['id']);
				
				// Get current publication data
				$query = $bdd->prepare('SELECT * FROM pw_publis WHERE id = :id');
				$query->bindParam(':id',$id);
				$query->execute();
				if($query != NULL) {
					$resultItem = $query->fetch();
					$query->closeCursor();
					
					if($resultItem != NULL) {
						if($act == 2 OR $act == 3) {
							if(!mysql_edit_publi_by_id($bdd,$id,$act)) {
							?>
								<meta http-equiv="refresh" content="1; URL=publis">
								<h1><font color="red">Undocumented error.</font></h1><p>Don't mess up with the URL parameters! Redirecting...</p>
							<?php
							} else {
								// Update last modification date
								mysql_update_lastmodif($bdd);
							?>
								<meta http-equiv="refresh" content="0; URL=publis">
								<h1><font color="blue">Publication edited.</font></h1><p>Redirecting...</p>
							<?php
							}
						} else if($act == 4) {
							?>
							<h1>Delete publication</h1>
							<?php
							if(isset($_POST['confirm'])) {
								// Get publication info
								$query = $bdd->prepare('SELECT * FROM pw_publis WHERE id = :id');
								$query->bindParam(':id',$id);
								$query->execute();
								$publiToDelete = $query->fetch(PDO::FETCH_ASSOC);
								$query->closeCursor();
								
								// Delete pdf file from ../assets/publis/
								$fileToDelete = "../assets/publis/".$publiToDelete['pdf'];
								unlink($fileToDelete);
								
								// Delete slides pdf, if any
								if($publiToDelete['pdfslides'] != "") {
									$slidesToDelete = "../assets/slides/".$publiToDelete['pdfslides'];
									unlink($slidesToDelete);
								}
								
								// Delete page from pw_pages
								$query = $bdd->prepare('DELETE FROM pw_publis WHERE id = :id');
								$query->bindParam(':id',$id);
								$query->execute();
								
								// Update last modification date
								mysql_update_lastmodif($bdd);
								?>
								<meta http-equiv="refresh" content="1; URL=publis">
								<p><center><font color="blue"><b>Publication was deleted! Redirecting...</b></font></center></p>
							<?php
							} else {
							?>
								<form method=post action="editpubli?id=<?php echo $id; ?>&act=4">
									<center>
										Do you really want to delete this publication (ID: <b><?php echo $id; ?></b>)?<br><font color="red"><b>This cannot be reversed and will also erase attached pdf files!!!</b></font><br>
										<input type="submit" name="confirm" value="Confirm"> or <a href="publis">Cancel</a>
									</center>
								</form>
							<?php
							}
						} else if($act == 1) {
							$formActive = 1;
							$editing = 1;
							?>
							<h1>Publication edition</h1>
							
							<p>You are editing a publication (ID: <b><?php echo $id; ?></b>).</p>
							<?php
						} else {
						?>
							<meta http-equiv="refresh" content="1; URL=publis">
							<h1><font color="red">Undocumented error.</font></h1><p>Don't mess up with the URL parameters! Redirecting...</p>
						<?php
						}
					} else {
					?>
						<meta http-equiv="refresh" content="1; URL=publis">
						<h1><font color="red">Publication ID not found.</font></h1><p>Redirecting...</p>
					<?php
					}
				} else {
				?>
					<meta http-equiv="refresh" content="1; URL=publis">
					<h1><font color="red">Invalid ID.</font></h1><p>Redirecting...</p>
				<?php
				}
			}
		}
		
		if($formActive) {
			if(isset($_POST['submit'])) {
				if(!$editing) {
					// INSERT
					if(!empty(htmlspecialchars($_POST['title'])) && !empty(htmlspecialchars($_POST['authors'])) && !empty(htmlspecialchars($_POST['source'])) && !empty(htmlspecialchars($_POST['year'])) && !empty(htmlspecialchars($_POST['bibtexid']))) {
						// Check if $_POST['bibtexid'] is not already present and do not proceed if it is
						$query = $bdd->prepare('SELECT id FROM pw_publis WHERE bibtex_id=:bibtex_id');
						$query->bindParam(':bibtex_id',htmlspecialchars($_POST['bibtexid']));
						$query->execute();
						$result = $query->fetch(PDO::FETCH_ASSOC);
						$query->closeCursor();
						
						if($result != NULL) {
						?>
							<meta http-equiv="refresh" content="1; URL=publis">
							<p><center><font color="red"><b>BibTeX identifier already exists!</b></font></center></p>
						<?php
						} else {
							if(!empty($_FILES['pdffile']['name'])) {
								// Upload pdf file
								$target_dir = "../assets/publis/";
								$target_file = $target_dir.basename($_FILES['pdffile']['name']);
								$errorCode = file_upload($_FILES['pdffile'],$target_file,"pdf");
								
								switch($errorCode) {
									case 0:
										$pdf = basename($_FILES['pdffile']['name']);
										break;
									case 1:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>File is too large!</b></font></center></p>
										<?php
										break;
									case 2:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>Only pdf files are allowed!</b></font></center></p>
										<?php
										break;
									default:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>An error occurred while uploading the publication file.</b></font></center></p>
										<?php
										break;
								}
							} else {
								$pdf = "";
							}
							
							// Upload slides pdf file, if any
							if(!empty($_FILES['slidesfile']['name'])) {
								// Upload pdf file
								$target_dir = "../assets/slides/";
								$target_file = $target_dir.basename($_FILES['slidesfile']['name']);
								$errorCode = file_upload($_FILES['slidesfile'],$target_file,"pdf");
								
								switch($errorCode) {
									case 0:
										$pdfslides = basename($_FILES['slidesfile']['name']);
										break;
									case 1:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>File is too large!</b></font></center></p>
										<?php
										break;
									case 2:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>Only pdf files are allowed!</b></font></center></p>
										<?php
										break;
									default:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>An error occurred while uploading the slides file.</b></font></center></p>
										<?php
										break;
								}
							} else {
								$pdfslides = "";
							}
							
							// Upload zip archive, if any
							if(!empty($_FILES['archivefile']['name'])) {
								// Upload pdf file
								$target_dir = "../assets/archives/";
								$target_file = $target_dir.basename($_FILES['archivefile']['name']);
								$errorCode = file_upload($_FILES['archivefile'],$target_file,"zip");
								
								switch($errorCode) {
									case 0:
										$zipfile = basename($_FILES['archivefile']['name']);
										break;
									case 1:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>File is too large!</b></font></center></p>
										<?php
										break;
									case 2:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>Only zip files are allowed!</b></font></center></p>
										<?php
										break;
									default:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>An error occurred while uploading the archive file.</b></font></center></p>
										<?php
										break;
								}
							} else {
								$zipfile = "";
							}
							
							// Create entry in pw_publis
							$stmt = $bdd->prepare("INSERT INTO pw_publis (title,type,status,authors,source,pages,note,address,month,year,abstract,bibtex_id,pdf,pdfslides,zipfile,disabled) VALUES (:title,:type,:status,:authors,:source,:pages,:note,:address,:month,:year,:abstract,:bibtex_id,:pdf,:pdfslides,:zipfile,0)");
							$stmt->bindParam(':title',$title);
							$stmt->bindParam(':type',$type);
							$stmt->bindParam(':status',$status);
							$stmt->bindParam(':authors',$authors);
							$stmt->bindParam(':source',$source);
							$stmt->bindParam(':pages',$pages);
							$stmt->bindParam(':note',$note);
							$stmt->bindParam(':address',$address);
							$stmt->bindParam(':month',$month);
							$stmt->bindParam(':year',$year);
							$stmt->bindParam(':abstract',$abstract);
							$stmt->bindParam(':bibtex_id',$bibtex_id);
							$stmt->bindParam(':pdf',$pdf);
							$stmt->bindParam(':pdfslides',$pdfslides);
							$stmt->bindParam(':zipfile',$zipfile);
							
							$title = htmlspecialchars($_POST['title']);
							$type = $_POST['publtype'];
							$status = $_POST['publstatus'];
							$authors = htmlspecialchars($_POST['authors']);
							$source = htmlspecialchars($_POST['source']);
							$pages = htmlspecialchars($_POST['pages']);
							$note = htmlspecialchars($_POST['note']);
							$address = htmlspecialchars($_POST['address']);
							$month = $_POST['month'];
							$year = (int)$_POST['year'];
							$abstract = htmlspecialchars($_POST['abstract']);
							$bibtex_id = htmlspecialchars($_POST['bibtexid']);
							
							$stmt->execute();
							
							// Update last modification date
							mysql_update_lastmodif($bdd);
							?>
							<meta http-equiv="refresh" content="1; URL=publis">
							<p><center><font color="blue"><b>Publication was added successfully! Redirecting...</b></font></center></p>
						<?php
						}
					} else {
					?>
						<meta http-equiv="refresh" content="1; URL=publis">
						<p><center><font color="red"><b>Empty fields detected!</b></font></center></p>
					<?php
					}
				} else {
					// UPDATE
					if(!empty(htmlspecialchars($_POST['title'])) && !empty(htmlspecialchars($_POST['authors'])) && !empty(htmlspecialchars($_POST['source'])) && !empty(htmlspecialchars($_POST['year'])) && !empty(htmlspecialchars($_POST['bibtexid']))) {
						// Check if $_POST['bibtexid'] is not already present and do not proceed if it is
						$query = $bdd->prepare('SELECT id FROM pw_publis WHERE bibtex_id=:bibtex_id AND id!=:id');
						$query->bindParam(':id',$id);
						$query->bindParam(':bibtex_id',htmlspecialchars($_POST['bibtexid']));
						$query->execute();
						$result = $query->fetch(PDO::FETCH_ASSOC);
						$query->closeCursor();
						
						if($result != NULL) {
						?>
							<meta http-equiv="refresh" content="1; URL=publis">
							<p><center><font color="red"><b>BibTeX identifier already exists!</b></font></center></p>
						<?php
						} else { 
						
							// Recover current pdf and pdfslides
							$query = $bdd->prepare('SELECT pdf,pdfslides FROM pw_publis WHERE id=:id');
							$query->bindParam(':id',$id);
							$query->execute();
							$publiInfo = $query->fetch(PDO::FETCH_ASSOC);
							$query->closeCursor();
							
							$pdf = $publiInfo['pdf'];
							$pdfslides = $publiInfo['pdfslides'];
							$zipfile = $publiInfo['zipfile'];
							
							if(!empty($_FILES['pdffile']['name'])) {
								// Delete previous file
								$fileToDelete = "../assets/publis/".$pdf;
								unlink($fileToDelete);
							
								// Upload pdf file
								$target_dir = "../assets/publis/";
								$target_file = $target_dir.basename($_FILES['pdffile']['name']);
								$errorCode = file_upload($_FILES['pdffile'],$target_file,"pdf");
								
								switch($errorCode) {
									case 0:
										$pdf = basename($_FILES['pdffile']['name']);
										break;
									case 1:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>File is too large!</b></font></center></p>
										<?php
										break;
									case 2:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>Only pdf files are allowed!</b></font></center></p>
										<?php
										break;
									default:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>An error occurred while uploading the publication file.</b></font></center></p>
										<?php
										break;
								}
							}
							
							if(!empty($_FILES['slidesfile']['name'])) {
								// Delete slides pdf, if any
								if($pdfslides != "") {
									$slidesToDelete = "../assets/slides/".$pdfslides;
									unlink($slidesToDelete);
								}
								
								// Upload pdf file
								$target_dir = "../assets/slides/";
								$target_file = $target_dir.basename($_FILES['slidesfile']['name']);
								$errorCode = file_upload($_FILES['slidesfile'],$target_file,"pdf");
								
								switch($errorCode) {
									case 0:
										$pdfslides = basename($_FILES['slidesfile']['name']);
										break;
									case 1:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>File is too large!</b></font></center></p>
										<?php
										break;
									case 2:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>Only pdf files are allowed!</b></font></center></p>
										<?php
										break;
									default:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>An error occurred while uploading the slides file.</b></font></center></p>
										<?php
										break;
								}
							}
							
							if(!empty($_FILES['archivefile']['name'])) {
								// Delete archive file, if any
								if($zipfile != "") {
									$archiveToDelete = "../assets/archives/".$zipfile;
									unlink($archiveToDelete);
								}
								
								// Upload zip file
								$target_dir = "../assets/archives/";
								$target_file = $target_dir.basename($_FILES['archivefile']['name']);
								$errorCode = file_upload($_FILES['archivefile'],$target_file,"zip");
								
								switch($errorCode) {
									case 0:
										$zipfile = basename($_FILES['archivefile']['name']);
										break;
									case 1:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>File is too large!</b></font></center></p>
										<?php
										break;
									case 2:
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>Only zip files are allowed!</b></font></center></p>
										<?php
										break;
									default:
									echo $errorCode;
										?>
											<meta http-equiv="refresh" content="1; URL=publis">
											<p><center><font color="red"><b>An error occurred while uploading the archive file.</b></font></center></p>
										<?php
										break;
								}
							}
							
							// Update entry
							$query = $bdd->prepare('UPDATE pw_publis SET title=:title, type=:type, status=:status, authors=:authors, source=:source, pages=:pages, note=:note, address=:address, month=:month, year=:year, abstract=:abstract, bibtex_id=:bibtex_id, pdf=:pdf, pdfslides=:pdfslides, zipfile=:zipfile WHERE id='.$id.'');
							$query->bindParam(':title',$title);
							$query->bindParam(':type',$type);
							$query->bindParam(':status',$status);
							$query->bindParam(':authors',$authors);
							$query->bindParam(':source',$source);
							$query->bindParam(':pages',$pages);
							$query->bindParam(':note',$note);
							$query->bindParam(':address',$address);
							$query->bindParam(':month',$month);
							$query->bindParam(':year',$year);
							$query->bindParam(':abstract',$abstract);
							$query->bindParam(':bibtex_id',$bibtex_id);
							$query->bindParam(':pdf',$pdf);
							$query->bindParam(':pdfslides',$pdfslides);
							$query->bindParam(':zipfile',$zipfile);
							
							// Variables
							// $pdf
							// $pdfslides
							$title = htmlspecialchars($_POST['title']);
							$type = $_POST['publtype'];
							$status = $_POST['publstatus'];
							$authors = htmlspecialchars($_POST['authors']);
							$source = htmlspecialchars($_POST['source']);
							$pages = htmlspecialchars($_POST['pages']);
							$note = htmlspecialchars($_POST['note']);
							$address = htmlspecialchars($_POST['address']);
							$month = $_POST['month'];
							$year = (int)$_POST['year'];
							$abstract = htmlspecialchars($_POST['abstract']);
							$bibtex_id = htmlspecialchars($_POST['bibtexid']);
							
							// Update entry in pages table
							$query->execute();
							
							// Update last modification date
							mysql_update_lastmodif($bdd);
							?>
							<meta http-equiv="refresh" content="1; URL=publis">
							<p><center><font color="blue"><b>Publication was edited successfully! Redirecting...</b></font></center></p>
							<?php
						}
					} else {
					?>
					<p><center><font color="red"><b>Empty fields detected!</b></font></center></p>
					<?php
					}
				}
			} else {
			
				if($editing) {
					// define editing variables
					$query = $bdd->prepare('SELECT * FROM pw_publis WHERE id=:id');
					$query->bindParam(':id',$id);
					$query->execute();
					$publiInfo = $query->fetch(PDO::FETCH_ASSOC);
					$query->closeCursor();
					
					$title = $publiInfo['title'];
					$type = $publiInfo['type'];
					$status = $publiInfo['status'];
					$authors = $publiInfo['authors'];
					$source = $publiInfo['source'];
					$pages = $publiInfo['pages'];
					$note = $publiInfo['note'];
					$address = $publiInfo['address'];
					$month = $publiInfo['month'];
					$year = $publiInfo['year'];
					$bibtex_id = $publiInfo['bibtex_id'];
					$abstract = $publiInfo['abstract'];
					
					$cur_pdf = $publiInfo['pdf'];
					$cur_slides = $publiInfo['pdfslides'];
					$cur_archive = $publiInfo['zipfile'];
					if($cur_pdf == "") { $cur_pdf = "<i>none</i>"; }
					if($cur_slides == "") { $cur_slides = "<i>none</i>"; }
					if($cur_archive == "") { $cur_archive = "<i>none</i>"; }
				}
				?>
				<form method=post action="editpubli<?php if($editing) { ?>?id=<?php echo $id; ?>&act=1<?php } ?>" enctype="multipart/form-data">
					<h2>Publication title</h2><input type="text" name="title" size="50" value="<?php if($editing) { echo $title; } ?>"><font color="red"><b>*</b></font>
					
					<h2>Publication type</h2>
					<?php
					if(!$editing) {
						?>
						<input type="radio" name="publtype" value="0" checked> Journal
						<input type="radio" name="publtype" value="1"> International conference
						<input type="radio" name="publtype" value="2"> National conference
						<input type="radio" name="publtype" value="3"> Seminar
						<input type="radio" name="publtype" value="4"> PhD conference
						<?php
					} else {
						?>
						<input type="radio" name="publtype" value="0" <?php if($type == 0) { ?>checked<?php } ?>> Journal
						<input type="radio" name="publtype" value="1" <?php if($type == 1) { ?>checked<?php } ?>> International conference
						<input type="radio" name="publtype" value="2" <?php if($type == 2) { ?>checked<?php } ?>> National conference
						<input type="radio" name="publtype" value="3" <?php if($type == 3) { ?>checked<?php } ?>> Seminar
						<input type="radio" name="publtype" value="4" <?php if($type == 4) { ?>checked<?php } ?>> PhD conference
						<?php
					}
					?>
					
					<h2>Publication status</h2>
					<?php
					if(!$editing) {
						?>
						<input type="radio" name="publstatus" value="0" checked> Submitted
						<input type="radio" name="publstatus" value="1"> Accepted (under revision)
						<input type="radio" name="publstatus" value="2"> Accepted
						<input type="radio" name="publstatus" value="3"> Published
						<?php
					} else {
						?>
						<input type="radio" name="publstatus" value="0" <?php if($status == 0) { ?>checked<?php } ?>> Submitted
						<input type="radio" name="publstatus" value="1" <?php if($status == 1) { ?>checked<?php } ?>> Accepted (under revision)
						<input type="radio" name="publstatus" value="2" <?php if($status == 2) { ?>checked<?php } ?>> Accepted
						<input type="radio" name="publstatus" value="3" <?php if($status == 3) { ?>checked<?php } ?>> Published
						<?php
					}
					?>
					
					
					<h2>Authors</h2><input type="text" name="authors" size="50" value="<?php if($editing) { echo $authors; } ?>"><font color="red"><b>*</b></font><br>(e.g.: John Smith, Albert Einstein, etc.)
					
					<h2>Source</h2><input type="text" name="source" size="50" value="<?php if($editing) { echo $source; } ?>"><font color="red"><b>*</b></font><br>(e.g.: 6th Conference on Smithonian Operators)
					
					<h2>Pages</h2><input type="text" name="pages" size="50" value="<?php if($editing) { echo $pages; } ?>"><br>(e.g.: 25--32)
					
					<h2>Note</h2><input type="text" name="note" size="50" value="<?php if($editing) { echo $note; } ?>">
					
					<h2>Address</h2><input type="text" name="address" size="50" value="<?php if($editing) { echo $address; } ?>"><br>(e.g.: City (Country))
					
					<h2>Date</h2>
					<select name="month">
						<?php
						for($ii = 0; $ii < sizeof($monthList); $ii++) {
						?>
							<option value="<?php echo $ii; ?>" <?php if($editing) { if($month == $ii) { ?>selected<?php }} ?>><?php echo $monthList[$ii]; ?></option>
						<?php
						}
						?>
					</select><input type="text" name="year" size="5" value="<?php if($editing) { echo $year; } ?>" maxlength="4"><font color="red"><b>*</b></font>
					
					<h2>BibTeX identifier</h2><input type="text" name="bibtexid" size="50" value="<?php if($editing) { echo $bibtex_id; } ?>"><font color="red"><b>*</b></font>
					
					<h2>PDF file</h2><input type="file" name="pdffile" id="pdffile"><b><?php if($editing) { echo "Current: ".$cur_pdf; } ?></b>
					
					<h2>Slides file</h2><input type="file" name="slidesfile" id="slidesfile"><b><?php if($editing) { echo "Current: ".$cur_slides; } ?></b>
					
					<h2>Archive file</h2><input type="file" name="archivefile" id="archivefile"><b><?php if($editing) { echo "Current: ".$cur_archive; } ?></b>
					
					<h2>Abstract</h2>
					<textarea id="abstract" name="abstract" rows="8" cols="100"><?php if($editing) { echo $abstract; } ?></textarea><br>(no html formatting)
					
					<center>
						<input type="submit" name="submit" value="<?php if(isset($_GET['act'])) { ?>Update<?php } else { ?>Add<?php } ?> publication">
						 or <a href="publis">Cancel</a>
					</center>
				</form>
		<?php
			}
		}
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
