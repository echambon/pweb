<script src="/assets/js/jquery.js"></script>
<script>
$(document).ready(function() {
	$('#loginForm').on('submit', function(e) {
		e.preventDefault(); 	// avoiding normal redirect behaviour
		
		var $this = $(this); 	// form jQuery object
		
		// Retrieving variables
		var username = $('#username').val();
		var password = $('#password').val();
		
		// Check if variables are not empty
		if(username === '' || password === '') {
            // Testing
			$("#messageContainer").html("<div id='error'>Missing fields</div>");
        } else {
			// send HTTP request asynchronously
			$.ajax({
                url: 		$this.attr('action'), 	//
                type: 		$this.attr('method'), 	//
                data: 		$this.serialize(), 		//
                dataType: 	'json', 				// JSON
                success: function(json) { 	//
					if(json.error === 0) { // no error
						$("#loginForm").html(""); // deactivate form
						$("#messageContainer").html("<div id='success'>" + json.message + "</div>");
						
						// redirecting
						window.setTimeout(function() {
							window.location.href = '/adm';
						}, 1500);
					} else {
						$("#messageContainer").html("<div id='error'>" + json.message + "</div>");
					}
                }
            });
		}
	});
});
</script>
    
<section>
	<article>
		<h1>Log in form</h1>
		<p>You are not connected. Please connect now to access the administration tools.</p>
		
		<div id="messageContainer"></div>
		
		<form id="loginForm" method="post" action="adm/process_login">
			<table style="width:100%">
			<tr>
				<td style="padding-top:20px">Username<br><input type="text" id="username" name="username"></td>
			</tr>
			<tr>
				<td style="padding-top:20px">Password<br><input type="password" id="password" name="password"></td>
			</tr>
			<tr>
				<td style="padding-top:20px"><input type="submit" value="Log in"></td>
			</tr>
			</table>
		</form>
	</article>
</section>
