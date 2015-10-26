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
        $("#user-picture").toggleClass("active");
});
function logout(){
	$.ajax({
	   url: 'public/php/logout.php',
	   type: 'post',
	   data:{action:'logout'},
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

//UPLOAD DE IMAGENS
var storedFiles = [];
var c = 0;
var b = 0;
var d = 1;
$(document).ready(function() {
	$('#upload').on('change', fileSelected);
	$('body').on("click", '.cancel', removeFile);
	$('#startupload').on('click', startUpload);
	$('#upload-container').hide();
	$('#container-close').on('click', containerHide);
});
function containerHide(e) {
	$('#upload-container').hide();
}

function fileSelected(e) {
	$('#upload-container').show();
	var files = e.target.files;
	var filesArr = Array.prototype.slice.call(files);
    for (var i = 0; i < files.length; i++) {
    	storedFiles.push(files[i]);
    	DataURLFileReader.read(files[i], function (err, fileInfo) {
	        if (err != null) {
	            alert('Arquivo diferente de imagem!');
	        }
	        else {
	         	var html = '<tr id="file_'+c+'" class="template-upload fade in">'+
					'<td><img width="50" height="50" src="'+fileInfo.fileContent+'" alt="'+fileInfo.name+'"></td>'+
					'<td><p class="name">'+fileInfo.name+'</p><strong class="error text-danger"></strong></td>'+
					'<td style="width: 30%;"><p class="size">'+fileInfo.size()+'</p><div class="progress"><div id="bar_'+c+'" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div></td>'+
					'<td class="pull-right">'+
					'<button class="btn btn-primary start"><i class="fa fa-upload"></i><span>Start</span></button> '+
					'<button class="btn btn-warning cancel"><i class="fa fa-minus-circle"></i><span>Remover</span></button>'+
					'</td></tr>';
	            $('#queue').append(html);
	            c++;
	        }
	    });
    }
}
 
var DataURLFileReader = {
    read: function (file, callback) {
        var reader = new FileReader();
        var fileInfo = {
            name: file.name,
            type: file.type,
            fileContent: null,
            size: function () {
                var FileSize = 0;
                if (file.size > 1048576) {
                    FileSize = Math.round(file.size * 100 / 1048576) / 100 + " MB";
                }
                else if (file.size > 1024) {
                    FileSize = Math.round(file.size * 100 / 1024) / 100 + " KB";
                }
                else {
                    FileSize = file.size + " bytes";
                }
                return FileSize;
            }
        };
        if (!file.type.match('image.*')) {
            callback("file type not allowed", fileInfo);
            return;
        }
        reader.onload = function () {
            fileInfo.fileContent = reader.result;
            callback(null, fileInfo);
        };
        reader.onerror = function () {
            callback(reader.error, fileInfo);
        };
        reader.readAsDataURL(file);
    }
};

function removeFile(e) {
	var file = $(this).data("file");
	for(var i=0;i<storedFiles.length;i++) {
		if(storedFiles[i].name === file) {
			storedFiles.splice(i,1);
			break;
		}
	}
	$(this).parents('tr').remove();
}

function startUpload(e) {
	e.preventDefault();
	e.stopPropagation();
	for(var i=0, j=storedFiles.length; i<j; i++)
	{
        var data = new FormData();
        data.append("upload", storedFiles[i]);
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener("progress", uploadProgress, false);
        xhr.addEventListener("load", uploadComplete, false);
        xhr.addEventListener("error", uploadFailed, false);
        xhr.addEventListener("abort", uploadCanceled, false);
        xhr.open("POST", "public/php/upload.php");
        xhr.send(data);
	}
}

function uploadProgress(e){
    var percentComplete = (e.loaded / e.total) * 100;
    if  (percentComplete > 100){
    	percentComplete = 100;
    }
	$('#bar_'+b).css('width', '0%');
    $('#bar_'+b).html('0%');
    $('#bar_'+b).css('width', percentComplete+'%');
    $('#bar_'+b).html(percentComplete+'%');
    b++;
}

function uploadComplete(e) {
    /* This event is raised when the server send back a response */
    console.log(e.target.responseText+'upload feito');
    if (storedFiles.length == d) {location.reload()};
    d++;
}

function uploadFailed(e) {
    alert("There was an error attempting to upload the file.");
}

function uploadCanceled(e) {
    alert("The upload has been canceled by the user or the browser dropped the connection.");
}
 
//  INFINITE SCROLL PARA O RETORNO DE IMAGENS

 var ajax_arry = [];
 var ajax_index = 0;
 var sctp = 100;
 $(function() {
     $('#loading').show();
     $.ajax({
         url: "public/php/scroll.php",
         type: "POST",
         data: "page=1",
         cache: false,
         success: function(response) {
             $('#loading').hide();
             $('#gallery').html(response);
         }
     });
     $(window).scroll(function() {
         var height = $('#gallery').height();
         var scroll_top = $(this).scrollTop();
         if (ajax_arry.length > 0) {
             $('#loading').hide();
             for (var i = 0; i < ajax_arry.length; i++) {
                 ajax_arry[i].abort();
             }
         }
         var page = $('#gallery').find('.nextpage').val();
         var isload = $('#gallery').find('.isload').val();
         if ($(window).scrollTop() == ( $(document).height() - $(window).height()) && isload == 'true') {
             $('#loading').show();
             var ajaxreq = $.ajax({
                 url: "public/php/scroll.php",
                 type: "POST",
                 data: "page=" + page,
                 cache: false,
                 success: function(response) {
                     $('#gallery').find('.nextpage').remove();
                     $('#gallery').find('.isload').remove();
                     $('#loading').hide();
                     $('#gallery').append(response);
                 }
             });
             ajax_arry[ajax_index++] = ajaxreq;
         }
         return false;
         if ($(window).scrollTop() == $(window).height()) {
             alert("bottom!");
         }
     });
 });