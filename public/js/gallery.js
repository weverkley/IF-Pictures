//  INFINITE SCROLL PARA O RETORNO DE IMAGENS
var pageIndex = 0;
var noresults = 0;
var returned = 0;
$(document).ready(function () {
    GetImage();
    $(window).scroll(function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            GetImage();
            if(noresults == 0) $('#loading').show();
        }
    });
});
function GetImage() {
    //creating a ajax request
    pageIndex++;
    var xhr = new XMLHttpRequest();
    xhr.open("GET" ,"public/php/gallery.php?page="+pageIndex+"");
    xhr.addEventListener('readystatechange', function(){
        if(xhr.readyState === 4){
            if(xhr.status === 200){
                //alert(xhr.responseText);
                result = JSON.parse(xhr.responseText);
                $('#loading').hide();
                //format the result and display them
                if(result.length && noresults == 0){
                    for (var i = 0; i < result.length; i++) {
                        resultMarkup = '<div class="col-lg-3 col-md-4 col-xs-6">';
                        resultMarkup += '<img width="250" height="150" class="img-responsive lazy thumbnail" src="public/php/search.php?id='+result[i].$id+'" ><br>';
                        resultMarkup += '</div>';
                        //console.log(result[i].$id);
                        $('#gallery').append(resultMarkup);
                    };
                    //append the results to the results div
                    //empty the resultMarkup variable
                    resultMarkup = '';
                    returned++;
                }else{
                    if (returned == 0) p = '<p class="col-md-6 col-md-offset-3 text-center">Não há imagens a serem exibidas.</p>';
                    else p = '<p class="col-md-6 col-md-offset-3 text-center">Não há mais imagens a serem carregadas.</p>';
                    if (noresults == 0) $('#gallery').append(p);
                    noresults = 1;
                }
            }
        }
    }, false);
    xhr.send();
}
