

/*function authenticate(){
	doAjax();
	return;

}

function doAjax(){
	
	var authcode;
	authcode = JSON.stringify($('#auth').val());
	ajax = theAjax("authenticate", authcode);
	
	
}

function theAjax(method, authcode){
	
	return $.ajax({
		url: 'authenticate.php',
		type: 'POST',
	data: {method: method, authcode: authcode}
		
});
}*/



$(function() {
	
    $('#verify').on('submit', function(e) {
        $.post('authenticate.php', $(this).serialize(), function (data) {
		
        }).error(function() {

        });

    });

});
