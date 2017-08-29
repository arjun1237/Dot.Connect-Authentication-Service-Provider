// for compActivation.php
//---------------------------------------------------------------------


// initializing variables
//---------------------------------
var submit = $('#submit12');
var spin = $('#spinner12');
var email = $('#email12');


//email field blur and focus functionalities
//--------------------------------------------------------------------------

email.focus(function(){
	email.attr("placeholder", "");
	email.css({color: '#f44523', backgroundColor: '#f4eff1'});
})

email.blur(function(){
	email.attr("placeholder", "Company Email   [Registered]");
	email.css({color: '#f4eff1', backgroundColor: '#6c5e6d'});
})




//submit button click, blur and focus functionalities
//--------------------------------------------------------------------------

submit.focus(function(){
	submit.css({backgroundColor: "#bc1e00", borderColor: "#bc1e00"});
})

submit.blur(function(){
	submit.css({backgroundColor: "#f44523", borderColor: "#f44523"});
})

submit.click(function(){
	var value = validate(false);
	if(value){
		submit.val("");
		spin.css({visibility: "visible"});
	}
})



// function to validate email ID on the client side
//----------------------------------------------------------------------

function validate(value){
	var em = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(em.test(email.val()))
		return true;
	else{
		if(value){
			alert("Please provide a valid email address.");
		}
		return false;
	}
}