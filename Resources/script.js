$(function function_name() {
	$('#form').on('submit',function(event){ 
		if ( ($('#symbol').val().length <= 0) ){
			event.preventDefault();
		}
	});
});