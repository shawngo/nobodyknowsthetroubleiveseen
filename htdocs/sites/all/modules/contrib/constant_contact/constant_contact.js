// $Id: constant_contact.js,v 1.7 2010/02/02 16:57:55 justphp Exp $
$(document).ready(function(){
	$("#cc_auth").click(function(event){
		constant_contact_auth();
		event.preventDefault();
	});
});

// AJAX function that makes use of the builtin jquery library
function constant_contact_auth()
{
	var the_path = '/' + $('#cc_path').val() + "/constant_contact.ajax.php";
	
	$.get(the_path, {
		  	username:$('#cc_username').val(),
		  	password:$('#cc_password').val()
		},
		function(returned_data)
		{
			$(".cc_auth_res").html(returned_data);
		}
	);
}