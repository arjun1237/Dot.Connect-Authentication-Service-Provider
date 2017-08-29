<!-- this page looks into validation of company mail, and tokening random number for verification later on-->

<?php

include("DBconnect.php");
include('mailExp.php');
include('hash.php');
include('common.php');


// First pass
//-----------------------------------------------------------------------------------------

if(isset($_POST['firstNamePOI']) && isset($_POST['lastNamePOI']) && isset($_POST['compTitle']) && isset($_POST['compRegNumber']) && isset($_POST['compMail'])){

	// avoids cross site scripting
	$fname = normalize($_POST["firstNamePOI"]);	
	$lname = normalize($_POST["lastNamePOI"]);
	$title = normalize($_POST['compTitle']);
	$num = normalize($_POST["compRegNumber"]);
	$email = normalize($_POST['compMail']);

	// check if the user entry is genuine
	validate($fname, 'name', 'First Name');
	validate($lname, 'name', 'Last Name');
	validate($title, 'name', 'Company Title');
	validate($num, 'num', 'Registration Number');
	validate($email, 'email', 'Email');

	checkDuplicate($num, $email);                                     // checks if duplicates exits in email domain or reg number
	$token = crypto_rand();							                  // create token
	registerComp($fname.' '.$lname, $title, $num, $email, $token);    // register
	sendmail($email, $fname, $num, $token);                           // send email for activation
	header("Location: activMsg.php?email=$email");					  // redirect
	die();
}
else{
	header("Location: errorMsg.php?er=1");
	die();	
}




// function to register the company.
//-----------------------------------------------------------------------------------------------------------

function registerComp($name, $title, $num, $email, $token){
	$domain = substr($email, strpos($email, '@')+1);
	$conn = connect();
	try {
		$query = $conn->prepare(
				"INSERT into companyInfo(regNum, email, mailDomain, token, pointContact, title)
				VALUES(:rn,:em,:mc,:hh,:poi,:ttl);
			");
		$query->execute(array(':rn'=>$num,':em'=>$email,':mc'=>$domain,':hh'=>$token,':poi'=>$name, ':ttl'=>$title));   // helps avoid SQL injection attack
		$conn=null;
	}
	catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}



// function to check whether the email and registration number already exits
//-------------------------------------------------------------------------------------------------------

function checkDuplicate($num, $email){
	$regNums = getRegNum();       // extract all registration number and check to see if it matches with user input
	if(!is_null($regNums)){
		foreach ($regNums as $reg) {
			if($num == $reg){
				$msg = 'Registration Number';     
				header("Location: errorMsg.php?msg=$msg&er=2");
				die();
			}
		}
	}
	$mailEnd = getMailEnd();       // extract all mailEnds to check if emails with similar domains exist
	$endMail = substr($email, strpos($email, '@')+1);
	if(!is_null($mailEnd)){
		foreach ($mailEnd as $domain) {
			if($endMail === $domain){
				$msg = 'Email Domain';
				header("Location: errorMsg.php?msg=$msg&er=2");
				die();
			}
		}
	}
}




// extract all registration numbers
//-----------------------------------------------------------------------------------------------------------


function getRegNum(){
	$conn=connect();
	$regNum = null;
	try {
	 	$query = $conn->prepare(
	 		"SELECT regNum FROM companyInfo;
	 	");

	 	$query->execute();
	 	$conn=null;
	 	$res=$query->fetchAll();

	 	$regNum= array();
	 	$i=0;
	 	foreach($res as $row){
	 		$regNum[$i]=$row['regNum'];
	 		$i++;
	 	}

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $regNum;
}


// extract all domains of email ID
//-----------------------------------------------------------------------------------------------------------

function getMailEnd(){
	$conn=connect();
	$emailEnd = null;
	try {
	 	$query = $conn->prepare(
	 		"SELECT mailDomain FROM companyInfo;
	 	");

	 	$query->execute();
	 	$conn=null;
	 	$res=$query->fetchAll();

	 	$emailEnd= array();
	 	$i=0;
	 	foreach($res as $row){
	 		$emailEnd[$i]=$row['mailDomain'];
	 		$i++;
	 	}

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $emailEnd;
}



?>