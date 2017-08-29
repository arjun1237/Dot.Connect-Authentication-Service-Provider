// for company.php page
//-----------------------------------------------------------------------


var mails = ['gmail', 'yahoo', 'outlook', 'hotmail']; // arrays to store all free mails.


// initializing all input ID variables
//------------------------------------------------

var poiFName = $("#poiName");
var poiLName = $("#poiName1");
var compTitle = $("#compTitle");
var compRegNumber = $("#compRegNumber");
var compMail = $("#compMail");
var warning = $("#wrongCred1");

// First Name focus n Blur events
//---------------------------------------------------------------------------

poiFName.focus(function(){
	attChange(poiFName[0],"");
	$("#display11").css({visibility: "hidden"});      // make cross hidden
	poiFName.css({borderColor: "#6c5e6d"});           // change border color
})

poiFName.blur(function(){
	// trim spaces
	var temp = poiFName.val().trim();
	poiFName.val(temp);

	attChange(poiFName[0],"First Name");

	// if the Point of Contact first name is blank
	if(!poiFName.val()){
		$("#display11").css({visibility: "visible"});    // make cross visible
		poiFName.css({borderColor: "#e01d1d"});          // add border color to red
		warning.html("* All credentials are must");      // give warning signal
	}

	// if the Point of Contact first name is NOT empty
	else{
		poiFName.css({borderColor: "#6c5e6d"});
		// if last name has some value
		if(poiLName.val()){
			$("#display11").css({visibility: "hidden"});    // hide cross symbol
		}
		if(poiLName.val() && compTitle.val() && compRegNumber.val() && compMail.val() && checkmail()){
			warning.html("");
		}
	}
})

// Last Name focus and blur events
//-----------------------------------------------------------------------------------------------

poiLName.focus(function(){
	attChange(poiLName[0],"");
	$("#display11").css({visibility: "hidden"});      // make cross hidden
	poiLName.css({borderColor: "#6c5e6d"});           // change border color
})

poiLName.blur(function(){
	// trim spaces
	var temp = poiLName.val().trim();
	poiLName.val(temp);

	attChange(poiLName[0],"Last Name");

	// if the Point of Contact last name is blank
	if(!poiLName.val()){
		$("#display11").css({visibility: "visible"});    // make cross visible
		poiLName.css({borderColor: "#e01d1d"});          // add border color to red
		warning.html("* All credentials are must");      // give warning signal
	}

	// if the Point of Contact last name is NOT blank
	else{
		poiLName.css({borderColor: "#6c5e6d"});
		// if first name has some value
		if(poiFName.val()){
			$("#display11").css({visibility: "hidden"});    // hide cross symbol
		}
		if(poiFName.val() && compTitle.val() && compRegNumber.val() && compMail.val() && checkmail()){
			warning.html("");
		}
	}
})



// Company Title focus and blur events
//---------------------------------------------------------------------------------------------

compTitle.focus(function(){
	attChange(compTitle[0],"");
	$("#display12").css({visibility: "hidden"});        // cross symbol to hidden
	compTitle.css({borderColor: "#6c5e6d"});            // change border color
})

compTitle.blur(function(){
	// trim spaces
	var temp = compTitle.val().trim();
	compTitle.val(temp);
	
	attChange(compTitle[0],"Company Title");

	// if the company title is left empty
	if(!compTitle.val()){
		$("#display12").css({visibility: "visible"});     // make cross visible
		compTitle.css({borderColor: "#e01d1d"});          // add border color to red
		warning.html("* All credentials are must");       // give warning signal
	}

	// if company title is NOT empty
	else{
		compTitle.css({borderColor: "#6c5e6d"});
		$("#display12").css({visibility: "hidden"});
		if(poiFName.val() && poiLName.val() && compRegNumber.val() && compMail.val() && checkmail()){
			warning.html("");
		}
	}
})



// Registration Number focus and blur events
//--------------------------------------------------------------------------------------

compRegNumber.focus(function(){
	attChange(compRegNumber[0],"");
	$("#display13").css({visibility: "hidden"});        // cross symbol to hidden
	compRegNumber.css({borderColor: "#6c5e6d"});        // change border color
})

compRegNumber.blur(function(){
	attChange(compRegNumber[0],"Registration Number");

	// if registration number is empty
	if(!compRegNumber.val()){
		$("#display13").css({visibility: "visible"});     // make cross visible
		compRegNumber.css({borderColor: "#e01d1d"});      // add border color to red
		warning.html("* All credentials are must");       // give warning signal
	}

	// if registration number is NOT empty
	else{
		compRegNumber.css({borderColor: "#6c5e6d"});
		$("#display13").css({visibility: "hidden"});
		if(poiFName.val() && poiLName.val() && compTitle.val() && compMail.val() && checkmail()){
			warning.html("");
		}
	}
})



// Company Email focus and blur events
//------------------------------------------------------------------------------------------------------

compMail.focus(function(){
	attChange(compMail[0],"");
	$("#display14").css({visibility: "hidden"});        // cross symbol to hidden
	compMail.css({borderColor: "#6c5e6d"});             // change border color
	$("#msgBox11").css({visibility: "visible"});        // make the comment box visible
})

compMail.blur(function(){
	attChange(compMail[0],"Company Email  [valid]");
	$("#msgBox11").css({visibility: "hidden"});

	// if the email value is blank
	if(!compMail.val()){
		$("#display14").css({visibility: "visible"});     // make cross visible
		compMail.css({borderColor: "#e01d1d"});           // add border color to red
		warning.html("* All credentials are must");       // give warning signal
		$("#msgBox11").css({visibility: "visible"});      // comment box remains visible
	}

	// if email value is NOT blank
	else{
		compMail.css({borderColor: "#6c5e6d"});
		$("#display14").css({visibility: "hidden"});

		// if every other credentials are NOT empty
		if(poiFName.val() && poiLName.val() && compTitle.val() && compRegNumber.val()){
			var firstPhase = compMail.val().substr((compMail.val().indexOf('@'))+1,compMail.val().length);
			var mail = firstPhase.substr(0,firstPhase.indexOf('.'));
			if(mails.includes(mail)){
				warning.html("Invalid Email address!");
				$("#msgBox11").css({visibility: "visible"});
				compMail.css({borderColor: "#e01d1d"});					
			}
			else if(!checkmail()) {
				warning.html("Invalid Email address!");
				$("#msgBox11").css({visibility: "visible"});
				compMail.css({borderColor: "#e01d1d"});
			}
			else{
				warning.html("");
				$("#msgBox11").css({visibility: "hidden"});
			}
		}

		// else if the mail is not valid
		else if(!checkmail()) {
			warning.html("Invalid Email address!");           // give warning
			$("#msgBox11").css({visibility: "visible"});      // appear comment box
			compMail.css({borderColor: "#e01d1d"});           // change border color
		}
		else{
			$("#msgBox11").css({visibility: "hidden"});       // hide comment box
		}
	}
})



// attChange function to change the attributes of the input elements.
//------------------------------------------------------------------------------------------------

function attChange(element, ph){
	// on focus attribute
	if(element.placeholder === ""){
		element.setAttribute('placeholder', ph);       // set placeholder to Blank
		element.style.backgroundColor = '#6c5e6d';     // change BG color of the given element
		element.style.color = '#f4eff1';               // word color change
	}
	// on blur attribute
	else{			
		element.setAttribute('placeholder', ph);       // set placeholder to given value
		element.style.backgroundColor = '#f4eff1';     // change BG color of the given element
		element.style.color = "#f44523";               // word color change
	}
}




// Submit button click, focus and blur events
//----------------------------------------------------------------------------------------------

var spin = $("#spinner11");
var submit = $('#signIn2');

submit.click(function(){
	if(validate(false)){
		submit.val("");                     // submit value to Blank
		spin.css({visibility: "visible"});  // spinner to visible
	}
})

submit.focus(function(){
	submit.css({backgroundColor: "#bc1e00", borderColor: "#bc1e00"});
})

submit.blur(function(){
	submit.css({backgroundColor: "#f44523", borderColor: "#f44523"});
})




// form validation
//----------------------------------------------------------------------------------------------------

function validate(msg){
	var firstPhase = compMail.val().substr((compMail.val().indexOf('@'))+1,compMail.val().length);
	var mail = firstPhase.substr(0,firstPhase.indexOf('.'));

	// if any of the field is empty
	if(!(poiFName.val() && poiLName.val() && compTitle.val() && compRegNumber.val() && compMail.val())){
		if(msg)
			alert("Please do not leave the fields empty!");
		return false;
	}

	// if the mail is not valid
	else if (!checkmail()) {
		if(msg)
			alert("Invalid Email address!"); 
		return false;
	}

	// if the mail includes any free mails
	else if(mails.includes(mail)){
		if(msg)
			alert("Email provided must be company mail ID."); 
		return false;
	}

	// if the name entered is not valid
	else if(!(checkName(poiFName.val()) && checkName(poiLName.val()))){
		if(msg)
			alert('Name provided not valid');
		return false;
	}

	// if company name is not valid
	else if(!(checkName(compTitle.val()))){
		if(msg)
			alert('Company Title provided not valid');
		return false;
	}

	// if everything is fine then...
	else{
		$('#mailEnd1').val(firstPhase);     // mailEnd1 is hidden input value which passes on Domain of the email.
		return true;
	}
}



// check email is valid
//---------------------------------------------------------------------------

function checkmail(){
	if((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(compMail.val())))
		return true;
	return false;
}




// check name is valid
//---------------------------------------------------------------

function checkName(name){
	if(/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/.test(name))		
		return true;
	return false;
}