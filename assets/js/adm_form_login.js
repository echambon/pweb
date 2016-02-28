$(document).ready(function() {
	$('#loginForm').on('submit', function(e) {
		e.preventDefault(); 	// avoiding normal redirect behaviour
		
		var $this = $(this); 	// form jQuery object
		
		// Retrieving variables
		var username = $('#username').val();
		var password = $('#password').val();
		
		// Check if variables are not empty before sending request
		if(username === '' || password === '') {
			$("#messageContainer").html("<div id='error'>Empty fields detected.</div>");
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
