<!-- the below program creates a token and sends to the particular email for activation -->

<?php

include("DBconnect.php");
include('mailExp.php');
include('hash.php');
include('common.php');

if(isset($_GET['email'])){

	$email = normalize($_GET['email']);  // avoids cross site scripting
	validate($email, 'email', 'Email');  // checks if email is genuine

	if(!checkMail()){
		$msg='email';
		header("Location: errorMsg.php?msg=$msg&er=3");
		die();
	}

	$token = crypto_rand();             // creates new token
	changetoken($email,$token);         // updates the new token into the given email

	$regNum = null;
	$name = null;
	extractInfo();                      // extract registration numbera and name info from the given email


	// send activation code through email to the user
	if(isset($email) && isset($regNum) && isset($name) && isset($token))
		sendmail($email, $name, $regNum, $token);
	else{
		header("Location: errorMsg.php?er=1");
		die();
	}
	// redirect
	header("Location: activMsg.php?email=$email");
}
else{
	header("Location: errorMsg.php?er=1");
	die();
}


// check if email exists in the database
//----------------------------------------------------------

function checkMail(){
	$conn=connect();
	global $email;
	$ch = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT * FROM companyInfo where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email));
	 	$conn=null;
	 	$res=$query->fetchAll();

	 	if(count($res) == 1){
	 		$ch = true;
	 	}

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $ch;
}




// get the regNum and POI info for the email match
//-----------------------------------------------------------------------------------

function extractInfo(){
	$conn=connect();
	global $email, $regNum, $name;
	try {
	 	$query = $conn->prepare(
	 		"SELECT regNum, pointContact from companyInfo where email=:em;
	 	");

	 	$query->execute(array(':em'=>$email));
	 	$conn=null;
	 	$res=$query->fetchAll();

	 	foreach ($res as $row) {
	 		$regNum = $row['regNum'];
	 		$name = $row['pointContact'];
	 	}

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}



// the token is updated for the particular email ID
//----------------------------------------------------------------------------------------

function changetoken($email, $token){
	$conn = connect();
	try {
		$query = $conn->prepare(
				"UPDATE companyInfo SET token=:hh WHERE email=:em;
			");
		$query->execute(array(':hh'=>$token,':em'=>$email));   // helps avoid SQL injection attack
		$conn=null;
	}
	catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}




?>