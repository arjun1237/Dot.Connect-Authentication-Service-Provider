// for changecompdata.php
//----------------------------------------------------------------------


var poi = $('#f-option');
var title = $('#s-option');

var update = $('#update17');
var email = $('#email17');
var submit = $('#submit17');
var spin = $('#spinner17');

var cross1 = $('#correct117');
var cross2 = $('#correct127');

var warning = $('#warning17');

var ph = null;


// selector onlick functionalities
//----------------------------------------------------------------------

// if New Point Of Contact button is clicked
poi.click(function(){
	ph = 'New Point of Contact';
	update.val('');
	update.attr('placeholder', ph);
	poi.val('poi');
	update.css({borderColor: "#6c5e6d"});
	cross1.css({visibility: "hidden"});
	warning.css({visibility: "hidden"});
})


// if New Company Title button is clicked
title.click(function(){
	ph = 'New Company Title'
	update.val('');
	update.attr('placeholder', ph);
	title.val('title');
	update.css({borderColor: "#6c5e6d"});
	cross1.css({visibility: "hidden"});
	warning.css({visibility: "hidden"});
})


// update focus and blur functionalities of email field
//------------------------------------------------------------------------

email.focus(function(){
	email.attr("placeholder", "");
	email.css({color: '#f44523', backgroundColor: '#f4eff1'});
})

email.blur(function(){
	email.attr("placeholder", "Company Email   [Registered]");
	email.css({color: '#f4eff1', backgroundColor: '#6c5e6d'});
	if(!checkmail()){
		email.css({borderColor: "#e01d1d"});
		cross2.css({visibility: "visible"});
		warning.css({visibility: "visible"});
	}
	else{
		email.css({borderColor: "#6c5e6d"});
		cross2.css({visibility: "hidden"});
		warning.css({visibility: "hidden"});
	}
})


// email focus and blur functionlities of 'to update'(either point of contact or company title) field
// ------------------------------------------------------------------------------------------------------

update.focus(function(){
	update.attr("placeholder", "");
	update.css({color: '#f44523', backgroundColor: '#f4eff1'});
})

update.blur(function(){
	update.attr("placeholder", ph);
	update.css({color: '#f4eff1', backgroundColor: '#6c5e6d'});
	if(!checkName(update.val())){
		update.css({borderColor: "#e01d1d"});
		cross1.css({visibility: "visible"});
		warning.css({visibility: "visible"});
	}
	else{
		update.css({borderColor: "#6c5e6d"});
		cross1.css({visibility: "hidden"});
		warning.css({visibility: "hidden"});
	}
})


// submit button blur, focus and click functionalities
//------------------------------------------------------------------------

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

// check email is valid
//-----------------------------------------------------------------------------

function checkmail(){
	if((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.val())))
		return true;
	return false;
}


// check name is valid
//--------------------------------------------------------------

function checkName(name){
	if(/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/.test(name))		
		return true;
	return false;
}


// function to validate entries
//-------------------------------------------------------------

function validate(msg){
	var ch1 = checkName(update.val());
	var ch2 = checkmail();
	var ch3 = (poi.val() !== 'null' || title.val()!== 'null');
	if(ch1 && ch2 && ch3)
		return true;
	else if(!ch3){
		if(msg)
			alert('Please select what to update.');
		return false;
	}
	else if(update.val() == '' || email.val() == ''){
		if(msg)
			alert('Please don\'t leave the fields empty.');
		return false;
	}
	else if(!ch1){
		if(msg)
			alert('Please correct invalid entires.');
		return false;
	}
	else if(!ch2){
		if(msg)
			alert('Email entered is invalid. Please correct.');
		return false;
	}
	return false;
}