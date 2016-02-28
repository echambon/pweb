$(document).ready(function() {
	$('#testClick').on('click', function(e) {
		e.preventDefault(); 	// avoiding normal redirect behaviour
		$("#messageContainer2").html("<div id='error'>bonjour</div>");
	});
});

$(document).ready(function() {
	$('#pname').on('change keyup paste', function(e) {
		e.preventDefault(); 		// avoiding normal redirect behaviour
		var elem = $(this);			// get current title value
		
		// TODO here: process value to replace spaces with "-" and delete special characters
		var url = elem.val().replace(/\ /g,'-');
		//url.replace(' ', '-');
		url = url.replace(/[^-a-zA-Z0-9]/g,'');
		
		$("#url").val(url.toLowerCase());
	});
});

$(document).ready(function() {
	$('#pageForm').on('submit', function(e) {
		e.preventDefault(); 	// avoiding normal redirect behaviour
		
		var $this = $(this); 	// form jQuery object
		
		// Retrieve variables
		var pname = $('#pname').val();
		var url = $('#url').val();
		// menu options
		var content = $('#content').val();
		
		// Check if variables are not empty before sending request
		if(pname === '' || url === '') {
			$("#messageContainer").html("<div id='error'>Empty mandatory fields detected.</div>");
        } else {
			// send HTTP request asynchronously
			$.ajax({
                url: 		$this.attr('action'), 	//
                type: 		$this.attr('method'), 	//
                data: 		$this.serialize(), 		//
                dataType: 	'json', 				// JSON
                success: function(json) { 	//
					if(json.error === 0) { // no error
						$("#pageForm").html(""); // deactivate form
						$("#messageContainer").html("<div id='success'>" + json.message + "</div>");
						
						// redirecting
						window.setTimeout(function() {
							window.location.href = '/adm/pages';
						}, 1500);
					} else {
						$("#messageContainer").html("<div id='error'>" + json.message + "</div>");
					}
                }
            });
        }
	});
});
