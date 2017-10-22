<section>
	<article>
		<h1>Pages</h1>
		
		<div id="messageContainer2"></div>
		
		<p><a href="" id="testClick">Test</a></p>
		
		<h1>New page</h1>
		
		<p>Here, you can create a new page to display content on your website.</p>
		
		<div id="messageContainer"></div>
		
		<form id="pageForm" method="post" action="/adm/process_page">
			<h2>Name <font color="red"><b>*</b></font></h2><input type="text" id="pname" name="pname" size="50">
			<h2>URL</h2><input type="text" id="url" name="url" size="50" readonly>
			<h2>Parent page</h2>
			<select>
				<option value="0" selected="selected">None</option>
				<?php echo $parent_pages_list_options; ?>
			</select>
			<h2>Menu options</h2>
			<h2>Content</h2><textarea id="content" name="content" rows="10" style="width:100%;resize: none;"></textarea>
			<center style="padding-top:20px"><input type="submit"></center>
		</form>
	</article>
</section>
