// for empAcntAct.php
//----------------------------------------------------



// variable initializing
//------------------------------------
var email = $('#email77');
var submit = $('#submit78');
var spin = $('#spin79');



// email field focus attribute
//---------------------------------------------------------------

email.focus(function(){
	email.attr("placeholder", "");
	email.css({color: '#f44523', backgroundColor: '#f4eff1'});
})



// email field blur attribute
//---------------------------------------------------------------

email.blur(function(){
	email.attr("placeholder", "Email ID [Official]");
	email.css({color: '#f4eff1', backgroundColor: '#6c5e6d'});
})



// submit field click attribute
//---------------------------------------------------------------

submit.click(function(){
	if(validate(false)){
		submit.val('');
		spin.css({visibility: 'visible'});
	}
})



// check if email is valid
//---------------------------------------------------------------

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