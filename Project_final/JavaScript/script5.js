// for empSignUp.php
//----------------------------------------------------------



// initializing variables
//-----------------------------------------------------------

var fname = $('#fname23');
var lname = $('#lname24');
var compReg = $('#crnum29');
var email = $('#email30');
var pwd = $('#password31');
var countryCode = $('#code32');
var mob = $('#mob33');
var submit = $('#submit35');
var spin = $('#spin41');
var warning = $('#warning42');
var msgbox = $('#msgbox50');

var wrong1 = $('#wrong91');
var wrong2 = $('#wrong92');
var wrong3 = $('#wrong93');
var wrong4 = $('#wrong94');



// adding focus attributes to the input types
//------------------------------------------------------------------------

fname.focus(function(){
	focusAttr(fname, '');
	wrong1.css({visibility: 'hidden'});
})

lname.focus(function(){
	focusAttr(lname, '');
	wrong1.css({visibility: 'hidden'});
})

compReg.focus(function(){
	focusAttr(compReg, '');
	wrong2.css({visibility: 'hidden'});
})

email.focus(function(){
	focusAttr(email, '');
	wrong3.css({visibility: 'hidden'});
})

pwd.focus(function(){
	focusAttr(pwd, '');
	msgbox.css({visibility: 'visible'});
	wrong4.css({visibility: 'hidden'});
})

countryCode.focus(function(){
	focusAttr(countryCode, '');
})

mob.focus(function(){
	focusAttr(mob, '');
})


// function that accepts an id to change focus attributes
//-------------------------------------------------------------------------------------------

function focusAttr(id){
	id.attr('placeholder', '');
	id.css({borderColor: "#6c5e6d", backgroundColor: '#f4eff1', color: '#f44523'});
}




// adding blur attributes to the input types
//------------------------------------------------------------------------

fname.blur(function(){
	var temp = fname.val().trim();
	fname.val(temp);
	if(checkName(fname.val())){
		blurAttr(fname, 'First Name', 1);
	}
	else{
		blurAttr(fname, 'First Name', 2);
		wrong1.css({visibility: 'visible'});
	}
	if(!fname.val())
		warning.html('* The first 4 credentials are must.');
	else if(pwd.css("border-color") === 'rgb(224, 29, 29)' || lname.css("border-color") === 'rgb(224, 29, 29)' || 
			compReg.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('');
	else if(email.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('* Email entered seems invalid.');
	else
		warning.html('');
})

lname.blur(function(){
	var temp = lname.val().trim();
	lname.val(temp);
	if(checkName(lname.val())){
		blurAttr(lname, 'Last Name', 1);
	}
	else{
		blurAttr(lname, 'Last Name', 2);
		wrong1.css({visibility: 'visible'});
	}
	if(!lname.val())
		warning.html('* The first 4 credentials are must.');
	else if(pwd.css("border-color") === 'rgb(224, 29, 29)' || fname.css("border-color") === 'rgb(224, 29, 29)' || 
			compReg.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('* The first 4 credentials are must.');
	else if(email.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('* Email entered seems invalid.');
	else
		warning.html('');
})

compReg.blur(function(){
	if(compReg.val()){
		blurAttr(compReg, 'Company Registration Number', 1);
	}
	else{
		blurAttr(compReg, 'Company Registration Number', 2);
		wrong2.css({visibility: 'visible'});
	}
	if(!compReg.val())
		warning.html('* The first 4 credentials are must.');
	else if(pwd.css("border-color") === 'rgb(224, 29, 29)' || fname.css("border-color") === 'rgb(224, 29, 29)' || 
			lname.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('* The first 4 credentials are must.');
	else if(email.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('* Email entered seems invalid.');
	else
		warning.html('');
})

email.blur(function(){
	if(checkmail()){
		blurAttr(email, 'Email ID [Official]', 1);
	}
	else{
		blurAttr(email, 'Email ID [Official]', 2);
		wrong3.css({visibility: 'visible'});
	}
	if(!checkmail())
		warning.html('* Email entered seems invalid.');
	else if(pwd.css("border-color") === 'rgb(224, 29, 29)' || compReg.css("border-color") === 'rgb(224, 29, 29)' ||
			fname.css("border-color") === 'rgb(224, 29, 29)' || lname.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('* The first 4 credentials are must.');
	else
		warning.html('');
})

pwd.blur(function(){
	msgbox.css({visibility: 'hidden'})
	if(pwd.val()){
		blurAttr(pwd, 'Set Password', 1);
	}
	else{
		blurAttr(pwd, 'Set Password', 2);
		wrong4.css({visibility: 'visible'});
	}
	if(!email.val())
		warning.html('* The first 4 credentials are must.');
	else if(compReg.css("border-color") === 'rgb(224, 29, 29)' || fname.css("border-color") === 'rgb(224, 29, 29)' || 
		lname.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('* The first 4 credentials are must.');
	else if(email.css("border-color") === 'rgb(224, 29, 29)')
		warning.html('* Email entered seems invalid.');
	else
		warning.html('');
})

countryCode.blur(function(){
	blurAttr(countryCode, 'Code', 1);
})

mob.blur(function(){
	blurAttr(mob, 'Mobile Number [Optional]', 1);
})





// function that accepts an id to change blur attributes
//-------------------------------------------------------------------------------------------

function blurAttr(id, ph, val){
	id.attr('placeholder', ph);
	if(val == 1){
		id.css({borderColor: "#6c5e6d", backgroundColor: '#6c5e6d', color: '#f4eff1'});
	}
	else{
		id.css({borderColor: "#e01d1d", backgroundColor: '#6c5e6d', color: '#f4eff1'});
	}
}






// functions that executes focus, click and blur attributes of submit
//-------------------------------------------------------------------------------------------

submit.focus(function(){
	submit.css({backgroundColor: "#bc1e00", borderColor: "#bc1e00"});
})

submit.blur(function(){
	submit.css({backgroundColor: "#f44523", borderColor: "#f44523"});
})

submit.click(function(){
	if(validate(false)){
		submit.val("");
		spin.css({visibility: "visible"});
	}
})





// function that checks if the said #id fits the said regex
//-------------------------------------------------------------------------------------------

function checkName(name){
	if(/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/.test(name))		
		return true;
	return false;
}





// function that checks if the email matches the regex
//-------------------------------------------------------------------------------------------

function checkmail(){
	if((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.val())))
		return true;
	return false;
}



// function that checks password
//-------------------------------------------------------------------------------------------

function checkpwd(){
	if(/\W/g.test(pwd.val()) && /[A-Z]/.test(pwd.val()) && /[a-z]/.test(pwd.val()) && pwd.val().length >= 10)
		return true;
	return false;
}





// function to validate all inputs
//---------------------------------------------------------------------------------------------

function validate(msg){
	if(!checkName(fname.val())){
		if(msg)
			alert('The First Name field has invalid input.');
		return false;
	}
	if(!checkName(lname.val())){
		if(msg)
			alert('The Last Name field has invalid input.');
		return false;
	}
	if(!compReg.val()){
		if(msg)
			alert('The Company Registration Number field cannot be blank.');
		return false;
	}	
	if(!checkmail()){
		if(msg)
			alert('The email entered is invalid.');
		return false;
	}	
	if(!checkpwd()){
		if(msg)
			alert("The password must contain:\n1. 1 uppercase letter,\n2. 1 lowercase letter,\n3. 1 numeric value \n4. 1 special character and\n5. The character length must be equal to or exceed 10.");
		return false;
	}	
	if(mob.val() && !countryCode.val()){
		if(msg)
			alert('Country code not entered.');
		return false;
	}
	return true;
}