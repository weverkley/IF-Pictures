//UPLOAD DE IMAGENS
var storedFiles = [];
var c = 0;
var b = 0;
var d = 1;
var search;
$(document).ready(function() {
	$('#upload').on('change', fileSelected);
	$('body').on("click", '.cancel', removeFile);
	$('#startupload').on('click', startUpload);
	$('#upload-container').hide();
	$('#container-close').on('click', containerHide);
	$('#cancelupload').on('click', abort_all_xhr);
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

function abort_all_xhr(){
  if (storedFiles.length>0) {
        for(var i=0; i<storedFiles.length; i++){
            storedFiles[i].abort();
        }
        storedFiles.length = 0;
        $(this).parents('tr').remove();
    };
}

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
	$('.button-upload').prop('disabled', true);
	$('#startupload').prop('disabled', true);
	$('.start').prop('disabled', true);
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

//MENU DE CONTEXTO

(function() {
  
  "use strict";

  //////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  //
  // H E L P E R    F U N C T I O N S
  //
  //////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////

  /**
   * Function to check if we clicked inside an element with a particular class
   * name.
   * 
   * @param {Object} e The event
   * @param {String} className The class name to check against
   * @return {Boolean}
   */
  function clickInsideElement( e, className ) {
    var el = e.srcElement || e.target;
    
    if ( el.classList.contains(className) ) {
      return el;
    } else {
      while ( el = el.parentNode ) {
        if ( el.classList && el.classList.contains(className) ) {
          return el;
        }
      }
    }

    return false;
  }

  /**
   * Get's exact position of event.
   * 
   * @param {Object} e The event passed in
   * @return {Object} Returns the x and y position
   */
  function getPosition(e) {
    var posx = 0;
    var posy = 0;

    if (!e) var e = window.event;
    
    if (e.pageX || e.pageY) {
      posx = e.pageX;
      posy = e.pageY;
    } else if (e.clientX || e.clientY) {
      posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
      posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
    }

    return {
      x: posx,
      y: posy
    }
  }

  //////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  //
  // C O R E    F U N C T I O N S
  //
  //////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  
  /**
   * Variables.
   */
  var contextMenuClassName = "context-menu";
  var contextMenuItemClassName = "context-menu-item";
  var contextMenuLinkClassName = "context-menu-link";
  var contextMenuActive = "context-menu-active";

  var taskItemClassName = "thumbnail";
  var taskItemInContext;

  var clickCoords;
  var clickCoordsX;
  var clickCoordsY;

  var menu = document.querySelector("#context-menu");
  var menuItems = menu.querySelectorAll(".context-menu-item");
  var menuState = 0;
  var menuWidth;
  var menuHeight;
  var menuPosition;
  var menuPositionX;
  var menuPositionY;

  var windowWidth;
  var windowHeight;

  /**
   * Initialise our application's code.
   */
  function init() {
    contextListener();
    clickListener();
    keyupListener();
    resizeListener();
  }

  /**
   * Listens for contextmenu events.
   */
  function contextListener() {
    document.addEventListener( "contextmenu", function(e) {
      taskItemInContext = clickInsideElement( e, taskItemClassName );

      if ( taskItemInContext ) {
        e.preventDefault();
        toggleMenuOn();
        positionMenu(e);
      } else {
        taskItemInContext = null;
        toggleMenuOff();
      }
    });
  }

  /**
   * Listens for click events.
   */
  function clickListener() {
    document.addEventListener( "click", function(e) {
      var clickeElIsLink = clickInsideElement( e, contextMenuLinkClassName );

      if ( clickeElIsLink ) {
        e.preventDefault();
        menuItemListener( clickeElIsLink );
      } else {
        var button = e.which || e.button;
        if ( button === 1 ) {
          toggleMenuOff();
        }
      }
    });
  }

  /**
   * Listens for keyup events.
   */
  function keyupListener() {
    window.onkeyup = function(e) {
      if ( e.keyCode === 27 ) {
        toggleMenuOff();
      }
    }
  }

  /**
   * Window resize event listener
   */
  function resizeListener() {
    window.onresize = function(e) {
      toggleMenuOff();
    };
  }

  /**
   * Turns the custom context menu on.
   */
  function toggleMenuOn() {
    if ( menuState !== 1 ) {
      menuState = 1;
      menu.classList.add( contextMenuActive );
    }
  }

  /**
   * Turns the custom context menu off.
   */
  function toggleMenuOff() {
    if ( menuState !== 0 ) {
      menuState = 0;
      menu.classList.remove( contextMenuActive );
    }
  }

  /**
   * Positions the menu properly.
   * 
   * @param {Object} e The event
   */
  function positionMenu(e) {
    clickCoords = getPosition(e);
    clickCoordsX = clickCoords.x;
    clickCoordsY = clickCoords.y;

    menuWidth = menu.offsetWidth + 4;
    menuHeight = menu.offsetHeight + 4;

    windowWidth = window.innerWidth;
    windowHeight = window.innerHeight;

    if ( (windowWidth - clickCoordsX) < menuWidth ) {
      menu.style.left = windowWidth - menuWidth + "px";
    } else {
      menu.style.left = clickCoordsX + "px";
    }

    if ( (windowHeight - clickCoordsY) < menuHeight ) {
      menu.style.top = windowHeight - menuHeight + "px";
    } else {
      menu.style.top = clickCoordsY + "px";
    }
  }

  /**
   * Dummy action function that logs an action when a menu item link is clicked
   * 
   * @param {HTMLElement} link The link that was clicked
   */
  function menuItemListener( link ) {
    console.log( "Task ID - " + taskItemInContext.getAttribute("data-id") + ", Task action - " + link.getAttribute("data-action"));
    var xhr = new XMLHttpRequest();
    xhr.open("GET" ,"public/php/preview.php?id="+taskItemInContext.getAttribute("data-id")+"");
    xhr.addEventListener('readystatechange', function(){
        if(xhr.readyState === 4){
            if(xhr.status === 200){
            	$('.modal-body').html().show();
                //$('#large-image').attr('src', 'public/php/search.php?id='+xhr.responseText+'')
            };
        }
    }, false);
    xhr.send();
    toggleMenuOff();

  }

  /**
   * Run the app.
   */
  init();

})();

$(document).ready(function () {
    $('#preview-modal').on('show.bs.modal', function (event) { // id of the modal with event
      var button = $(event.relatedTarget) // Button that triggered the modal
      var title = 'Visualizando imagem'
      var content = ''
      // Update the modal's content.
      var modal = $(this)
      modal.find('.modal-title').text(title)
      //modal.find('.modal-body').text(content)     
      modal.find('button.btn-danger').val()
    })
});

//  INFINITE SCROLL PARA O RETORNO DE IMAGENS
var pageIndex = 0;
var noresults = 0;
var returned = 0;
$(document).ready(function () {
	if(noresults == 0) GetData();
    $(window).scroll(function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            if(noresults == 0) {
                GetData();
                $('#loading').show();
            }
        }
    });
});
function GetData() {
	//creating a ajax request
	pageIndex++;
	var xhr = new XMLHttpRequest();
	xhr.open("GET" ,"public/php/scroll.php?page="+pageIndex+"", true);
	xhr.addEventListener('readystatechange', function(){
		if(xhr.readyState === 4){
			if(xhr.status === 200){
			 	result = JSON.parse(xhr.responseText);
				$('#loading').hide();
			 	//format the result and display them
			 	if(result.length && noresults == 0){
			 		for (var i = 0; i < result.length; i++) {
			 			resultMarkup = '<div class="col-lg-3 col-md-4 col-xs-6">',
		    			resultMarkup += '<img data-id="'+result[i].$id+'"class="img-responsive thumbnail" src="public/php/search.php?id='+result[i].$id+'" ><br>',
		    			resultMarkup += '</div>',
		    			//console.log(result[i].$id),
			 			$('#gallery').append(resultMarkup)
			 		};
			 		//append the results to the results div
			 		//empty the resultMarkup variable
			 		resultMarkup = '',
			 		returned++;
			 	}else{
			 		if (returned == 0) p = '<div class="container"><p class="col-lg-12 text-center">Você não possui imagens.</p><div>';
			 		else p = '<div class="container"><p class="col-lg-12 text-center">Não há mais imagens a serem carregadas.</p><div>';
			 		if (noresults == 0) $('#gallery').append(p); 
			 		noresults++;
			 	}
			}
		}
	}, false);
    xhr.setRequestHeader('Cache-Control', 'cache');
	xhr.send();
}
