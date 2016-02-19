<script src="/assets/js/jquery.js"></script>
<script>
$(document).ready(function() {
	$('#loginForm').on('submit', function(e) {
		e.preventDefault(); 	// avoiding normal redirect behaviour
		
		var $this = $(this); 	// form jQuery object
		
		// Retrieving variables
		var username = $('#username').val();
		
		// Testing
		$("#errorContainer").html("<div id='error'>" + username + "</div>");
	});
});
</script>
    
<section>
	<article>
		<h1>Log in form</h1>
		<p>You are not connected. Please connect now to access the administration tools.</p>
		
		<div id="errorContainer"></div>
		
		<form id="loginForm" method="post" action="adm/login">
			<table style="width:100%">
			<tr>
				<td style="padding-top:20px">Username<br><input type="text" id="username"></td>
			</tr>
			<tr>
				<td style="padding-top:20px">Password<br><input type="password" id="password"></td>
			</tr>
			<tr>
				<td style="padding-top:20px"><input type="submit" value="Log in"></td>
			</tr>
			</table>
		</form>
	</article>
</section>
