<!-- this page looks into validation of employee mail, and tokening random number for verification later on-->

<?php

include("DBconnect.php");
include('mailExp.php');
include('hash.php');
include('ipdata.php');
include('mobile.php');
include('common.php');

// First pass
//-----------------------------------------------------------------------------------------

if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['CRNum']) && isset($_POST['email']) && isset($_POST['pwd'])){

	// avoids cross site scripting
	$fname = normalize($_POST["fname"]);
	$lname = normalize($_POST["lname"]);
	$regNum = normalize($_POST['CRNum']);
	$email = normalize($_POST["email"]);
	$pwd = normalize($_POST['pwd']);

	// check if the user entires were genuine
	validate($fname, 'name', 'First Name');
	validate($lname, 'name', 'Last Name'); 
	validate($regNum, 'num', 'Registration Number'); 
	validate($email, 'email', 'Email'); 

	if(!checkpass($pwd)){                              // check password for its content
		header("Location: errorMsg.php?er=1");
		die();
	}

	$name = $fname.' '.$lname;

	if(!companycheck($regNum)){                        // verify if company exists
		$msg = 'Registration Number';
		header("Location: errorMsg.php?msg=$msg&er=3");
		die();
	}

	if(!companyAct($regNum)){                          // verify if company is active
		$msg = 'Company Registration Number';
		header("Location: errorMsg.php?msg=$msg&er=5");
		die();
	}

	$domain = substr($email, strpos($email, '@')+1);
	if(!domaincheck($regNum, $domain)){                // verify if the email domain matches with the company
		$msg = 'Email Domain';
		header("Location: errorMsg.php?msg=$msg&er=4");
		die();
	}

	if(checkduplicate($regNum, $email)){               // verify if the email is unique
		$msg = 'Email ID';
		header("Location: errorMsg.php?msg=$msg&er=2");
		die();
	}

	// get salt to be added to password
	$salt = salt();

	// hash the salt and password put together
	$hash = createhash($salt.$pwd);

	// generate token
	$token = crypto_rand();

	// register the employee in employee table of databse
	registerEmp($email, $regNum, $hash, $salt, $token, $name);

	// send activation mail to the user's email ID
	sendmail($email, $name, $email, $token, 2);

	// Add IP address of the user to the location table of the database
	addip($email);

	// proceed only if both mobile number and code has been provided
	if(isset($_POST['mob']) && isset($_POST['code']) && $_POST['mob'] != '' && $_POST['code'] != ''){

		// avoid cross site scripting
		$mob = normalize($_POST['mob']);
		$code = normalize($_POST['code']);

		// check if the mob and code numbers provided are genuinely numbers
		if(is_numeric($mob) && is_numeric($code)){
			$mToken = crypto_rand(100000, 999999);

			// store new token created into the mobile table of the databse
			storeMob($email, $code, $mob, $mToken);

			// send sms of the token created
			$smsMsg = "Token for mobile verification: $mToken";
			sendsms($code.''.$mob, 'Dot.Connect', $smsMsg);

			// redirect this if mob and code is set and sms has been sent
			header("Location: empVerifyCheck.php?email=$email&val=1");
			die();
		}
	}
	
	// redirect this when mob or code not set
	header("Location: empVerifyCheck.php?email=$email");
	die();
}
else{
	header("Location: errorMsg.php?er=1");
	die();	
}



// function to store mobile details
//-------------------------------------------------------------------------------------------------

function storeMob($email, $code, $mob, $token){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"INSERT into mobile(email, token, code, mobile) VALUES(:em, :tk, :cd, :mob);
	 	");

	 	$query->execute(array(':em'=> $email, ':tk'=>$token, ':cd'=> $code, ':mob'=> $mob));
	 	$conn=null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

// function to store ip adress and location details
//-------------------------------------------------------------------------------------------------

function addip($email){

	$res = getLocationInfoByIp();
	$ip = $res['ip'];
	$country = $res['country'];
	$city = $res['city'];

	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"INSERT into location(email, IPAddress, city, country) VALUES(:em, :ip, :ct, :co);
	 	");

	 	$query->execute(array(':em'=> $email, ':ip'=>$ip, ':ct'=> $city, ':co'=> $country));
	 	$conn=null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

// function to check if email already exits
//-------------------------------------------------------------------------------------------------

function registerEmp($email, $reg, $hash, $salt, $token, $name){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"INSERT into employee(email, hash, salt, token, regNum, name) VALUES(:em, :hh, :st, :tk, :reg, :n);

	 	");

	 	$query->execute(array(':em'=> $email, ':reg'=>$reg, ':hh'=> $hash, ':st'=> $salt, 'tk'=> $token, ':n'=> $name));
	 	$conn=null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

// function to check if email already exits
//-------------------------------------------------------------------------------------------------

function checkduplicate($reg, $email){
	$conn=connect();
	$check = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT email from employee where regNum = :reg;
	 	");

	 	$query->execute(array(':reg'=>$reg));
	 	$conn=null;
	 	$res=$query->fetchAll();
	 	
	 	foreach($res as $row){
	 		if($row['email'] == $email)
	 			$check = true;
	 	}

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $check;
}

// function to check if the email domain matches with the company
//-------------------------------------------------------------------------------------------------

function domaincheck($reg, $domain){
	$conn=connect();
	$check = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT mailDomain from companyInfo where regNum = :reg;
	 	");

	 	$query->execute(array(':reg'=>$reg));
	 	$conn=null;
	 	$res=$query->fetchAll();
	 	
	 	foreach($res as $row){
	 		if($row['mailDomain'] == $domain)
	 			$check = true;
	 	}

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $check;
}


// function to check if the company account is activated
//--------------------------------------------------------------------------------------------------------

function companyAct($reg){
	$conn=connect();
	$check = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT active FROM companyInfo where regNum = :reg;
	 	");

	 	$query->execute(array(':reg'=>$reg));
	 	$conn=null;
	 	$res=$query->fetchAll();
	 	
	 	foreach($res as $row){
	 		if($row['active'] == 1)
	 			$check = true;
	 	}

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $check;
}

// function to check if the company exists
//--------------------------------------------------------------------------------------------------------

function companycheck($reg){
	$conn=connect();
	$check = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT * FROM companyInfo where regNum = :r;
	 	");

	 	$query->execute(array(':r'=>$reg));
	 	$conn=null;
	 	$res=$query->fetchAll();
	 	
	 	if(count($res) == 1)
	 		$check = true;

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $check;
}


// function to validate password
//---------------------------------------------------------------------------------------------------------

function checkpass($pwd){
	if(strlen($pwd) < 10)
		return false;
	if(!preg_match('~[0-9]~',$pwd))
		return false;
	if(!preg_match('/[A-Z]/',$pwd))
		return false;
	if(!preg_match('/[a-z]/',$pwd))
		return false;
	return true;
}



?>