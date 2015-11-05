//  INFINITE SCROLL PARA O RETORNO DE IMAGENS
var pageIndex = 0;
var noresults = 0;
var returned = 0;
$(document).ready(function() {
    if (noresults == 0) GetData();
    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            if (noresults == 0) {
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
    xhr.open("GET", "public/php/gallery.php?page=" + pageIndex + "", true);
    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                result = JSON.parse(xhr.responseText);
                //console.log(result);
                $('#loading').hide();
                //format the result and display them
                if (result.length && noresults == 0) {
                    for (var i = 0; i < result.length; i++) {
                        resultMarkup = '<div class="Image_Wrapper">',
                            resultMarkup += '<a><img data-id="' + result[i].hash+ '"class="context" src="public/upload/thumbnail/' + result[i].hash + '" ></a>',
                            resultMarkup += '</div>',
                            //console.log(result[i].$id),
                            $('#gallery').append(resultMarkup)
                            // hide all the images until we resize them
                            $('.Collage .Image_Wrapper').css("opacity", 0);
                            // set a timer to re-apply the plugin
                            if (resizeTimer) clearTimeout(resizeTimer);
                            resizeTimer = setTimeout(collage, 50);
                    };
                    //append the results to the results div
                    //empty the resultMarkup variable
                    resultMarkup = '',
                        returned++;
                } else {
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

// COLLAGE PARA GALERIA DE IMAGENS

$(window).load(function() {
    $(document).ready(function() {
        collage();
        $('.Collage').collageCaption();
    });
});
// Here we apply the actual CollagePlus plugin
function collage() {
    $('.Collage').removeWhitespace().collagePlus({
        'fadeSpeed': 2000,
        'targetHeight': 200,
        'effect': 'effect-2',
        'direction': 'vertical',
        'allowPartialLastRow': true
    });
};
// This is just for the case that the browser window is resized
var resizeTimer = null;
$(window).bind('resize', function() {
    // hide all the images until we resize them
    $('.Collage .Image_Wrapper').css("opacity", 0);
    // set a timer to re-apply the plugin
    if (resizeTimer) clearTimeout(resizeTimer);
    resizeTimer = setTimeout(collage, 200);
});