$(document).ready(function() {
	// Set up an event listener for the form.
	$('#login-form').submit(function(event) {
		event.preventDefault();	//STOP default action
	    // TODO
	    $('#login').prop('disabled', true);
		$('#password').prop('disabled', true);

		var login = $('#login').val();
		var password = $('#password').val();
		var remember = $('#remember').val();
		var data = 'login='+login+'&password='+password+'&remember='+remember;
		$.ajax(
		{
			url : $(this).attr('action'),
			type: $(this).attr('method'),
			data : data,
			success:function(data)
			{
				if(data['error'] == '1'){
					console.log(data);
				} else {
					console.log(data);
				}
			},
			error: function(data)
			{
				console.log( "Request failed: " + data );
				$('#login').prop('disabled', false);
				$('#password').prop('disabled', false);
			}
		});
        return false; // avoid to execute the actual submit of the form.
	});
});