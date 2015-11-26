$('#search-button').on('click', function(e){
    GetData($('#name').val());
});
$('#back').hide();
//  INFINITE SCROLL PARA O RETORNO DE IMAGENS
var pageIndex = 0;
var noresults = 0;
var returned = 0;
$(document).ready(function() {
    //if (noresults == 0) GetData();
    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            if (noresults == 0) {
                GetData($('#name').val());
                $('#loading').show();
            }
        }
    });
});

function GetData(search) {
    $('#button-group').hide();
    $('#header').hide();
    $('#chevron').hide();
    $('.input-group').hide();
    $('#back').show();
    $('#footer-panel').removeClass('margin');
    //creating a ajax request
    pageIndex++;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "public/php/gallery.php?page=" + pageIndex + "&search="+ search, true);
    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                result = JSON.parse(xhr.responseText);
                //console.log(result);
                $('#loading').hide();
                //format the result and display them
                if (result.length && noresults == 0) {
                    for (var i = 0; i < result.length; i++) {
                        resultMarkup = '<div class="Image_Wrapper ImageWrapper ContentWrapperB chrome-fix">',
                            resultMarkup += '<a><img data-id="' + result[i].hash + '"class="context" src="public/upload/thumbnail/' + result[i].hash + '" ></a>',
                            resultMarkup += '<div class="ContentB">',
                            resultMarkup += '<div class="Content">',
                            resultMarkup += '<h2>'+ result[i].name +'</h2>Data: '+ result[i].timestamp +'',
                            resultMarkup += '<br><a target="_blank" class="btn btn-xs btn-success" href="index.php?p=visualizar.html&image='+ result[i].hash +'"><i class="fa fa-search"></i></a>',
                            resultMarkup += '</div></div>',
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
                    if (returned == 0) p = '<div class="container"><div class="alert alert-warning text-center">'
                        + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                        + 'Não há nenhuma imagem a ser mostrada.<div>';
                    else p = '<div class="container"><div class="alert alert-warning text-center">'
                            + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                            + 'Não há mais imagens a serem carregadas.<div>';
                    if (noresults == 0) $('#gallery').append(p);
                    noresults++;
                }
            }
        }
    }, false);
    xhr.setRequestHeader('Cache-Control', 'cache');
    xhr.send();
}