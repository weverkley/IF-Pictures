$(function(){
	$(".search_keyword").keyup(function() 
	{ 
	    var search_keyword_value = $(this).val();
	    if(search_keyword_value!='')
	    {
            var data = new FormData();
            data.append('search_keyword', search_keyword_value);
            var xhr = new XMLHttpRequest();
			xhr.onreadystatechange=function() {
			    if ( xhr.readyState==4 && xhr.status==200) {
			      $('#result').html(xhr.responseText);
			    }
			}
            xhr.open("POST", "public/php/searchpeople.php");
            xhr.send(data);
	    }
	    return false;    
	});

	$('#search_keyword_id').click(function(){
	    $("#result").fadeIn();
	});
});