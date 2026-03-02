/*
.........................................
.	jquery emil validation	.
.	Cloud Account Book				.
.	ABDULLAH AL MAMUN					.
.	SOFTWARE ENGINEER					.
.	CloudCodz								.
.	30-05-2009							.
.										.
.........................................


*/
function Validation_forget_form()
{
	
	//alert('hi mamun');
	
		
		
		
		if(($('#email').val() == ''  ) )
				{
							   $('#email').css('border','2px #ff0000 solid');
								 
							   return false;
				}
				else
				{
					
							$('#email').css('border','2px #00ff00 solid');
							if(isInValidEmail($('#email').val())){
							
							
							
						}
						else
						{
						
							 $('#email').css("border","2px #ff0000 solid");
							 return false;						
							 
							 
							 
						}
					
				}
				
		
		



	$('#forget_form').submit();
		
			
		
}



function isInValidEmail(email){
			
			    var RegExp = /^((([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+(\.([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+)*)@((((([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.))*([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.)[\w]{2,4}|(((([0-9]){1,3}\.){3}([0-9]){1,3}))|(\[((([0-9]){1,3}\.){3}([0-9]){1,3})\])))$/
			
			    if(RegExp.test(email))
			    {
			
			        return true;		
			
			    }
			    else
			    {
			
			        return false;	
			
			    }
			
}


