 //jQuery to collapse the navbar on scroll
$(window).scroll(function() {
	if (document.getElementById("#nav")) {
	    if ($(".navbar").offset().top > 50) {
	        $(".navbar-fixed-top").addClass("top-nav-collapse");
	    } else {
	        $(".navbar-fixed-top").removeClass("top-nav-collapse");
	    }
	}
});

//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1000, 'easeInOutExpo');
        event.preventDefault();
    });
});

$(document).ready(function() {
	// Set up an event listener for the form.
	$('#login-form').submit(function(event) {
		event.preventDefault();	//STOP default action
	    // TODO
	    function manageInput (status, input){
	    	if (status == 'on') {
			    $('#login').prop('disabled', true),
				$('#password').prop('disabled', true)
	    	} else {
			    $('#login').prop('disabled', false),
				$('#password').prop('disabled', false)
	    	};

	    	$(input).focus();
	    }

	    manageInput('on');

		var login = $('#login').val();
		var password = $('#password').val();
		if ($('#login').val() && $('#password').val()) {
			var remember = 0;
			if ($('#remember').is(':checked')) remember = 1;
			var data = 'login='+login+'&password='+password+'&remember='+remember;
			$.ajax(
			{
				url : $(this).attr('action'),
				type: $(this).attr('method'),
				data : data,
				success:function(data)
				{
					if(data == '0'){
						//console.log(data);
						location.reload();
					} else {
						var inputFocus;
						if (data == 1) {
							msgInfo = 'Senhas digitadas não são iguais',
							msgType = 'warning',
							msgIcon = 'fa fa-exclamation',
							$('#password').val(""),
							inputFocus = '#password'
						} else {
							msgInfo = 'Este usuário não existe',
							msgType = 'danger',
							msgIcon = 'fa fa-exclamation-triangle',
							$('#login').val(""),
							$('#password').val(""),
							inputFocus = '#login'
						}
						$.notify({
							icon: msgIcon,
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
							onClose: manageInput('false', inputFocus)
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
		} else {
			$.notify({
				//icon: 'fa fa-paw',
				message: 'Os campos devem ser preenchidos'
			}, {
				type: 'danger',
				animate: {
					enter: 'animated bounceIn',
					exit: 'animated bounceOut'
				},
				placement: {
					from: "bottom",
					align: "left"
				},
				onClose: manageInput('false', '#login')
			});
		};
	});
});

$("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active"),
        $("#user-picture").toggleClass('disabled');
});
function logout(){
	$.ajax({
	   url: 'public/php/logout.php?action=logout',
	   cache: false,
	   success: function(data){
	       location.reload();
	       //window.location.href = data;
	   }
	});
}
//logout usuário
$( "#logout" ).click(function() {
  	//alert( "Handler for .click() called." );
  	logout();
});