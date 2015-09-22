$(document).ready(function() {
	// Set up an event listener for the form.
	$('#login-form').submit(function(event) {
		event.preventDefault();	//STOP default action
	    // TODO
	    function disableInput (status){
	    	if (status == 'on') {
			    $('#login').prop('disabled', true),
				$('#password').prop('disabled', true)
	    	} else {
			    $('#login').prop('disabled', false).focus(),
				$('#password').prop('disabled', false).val("")
	    	};
	    }

	    disableInput('on');

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
				if(data == '0'){
					console.log(data);
				} else {
					if (data == 1) {
						msgInfo = "Senhas digitadas não são iguais",
						msgType = "warning"
					} else {
						msgInfo = "Este usuário não existe",
						msgType = "danger"
					}
					$.notify({
						//icon: 'fa fa-paw',
						message: msgInfo
					}, {
						type: msgType,
						animate: {
							enter: 'animated bounceIn',
							exit: 'animated bounceOut'
						},
						placement: {
							from: "bottom",
							align: "left"
						},
						onClose: disableInput('false')
					});
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