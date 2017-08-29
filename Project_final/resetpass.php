<!-- this file is the starting point of password reset process where the token is set and sent to the user -->


<?php

include("DBconnect.php");
include('mailExp.php');
include('hash.php');
include('common.php');



// if the email is set, a token is created and mail is sent preparing for password reset
//---------------------------------------------------------------------------------------------------------------

if(isset($_POST['email'])){

	// avoids cross site scripting
	$email = normalize($_POST['email']);

	// checks if the email is valid
	validate($email, 'email', 'Email');

	// checks if email is valid and extracts the corresponding user's name from the database
	$name = checkmail($email);

	// a new token is generated
	$token = crypto_rand();

	// the new token is updated onto the respective email
	updatetoken($email, $token);

	// email is sent with email and token information for next step of password reset process
	sendmail($email, $name, $email, $token, 4);

	// redirects once all the above ticked off
	header("Location: resetmessage.php");
	die();
}

else{
	header("Location: errorMsg.php?er=1");
	die();	
}



// function updates the token for the given email in the database
//---------------------------------------------------------------------------------------------------------------

function updatetoken($email, $token){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE employee set token = :tk where email = :em;
	 	");

	 	$query->execute(array(':tk'=>$token, ':em'=> $email));
	 	$conn=null;
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}


// function to check if the email provided exits and returns the name corresponding, else redirect it error page
//---------------------------------------------------------------------------------------------------------------

function checkmail($email){
	$conn=connect();
	$name = null;
	try {
	 	$query = $conn->prepare(
	 		"SELECT name FROM employee where email = :em;
	 	");

	 	$conn = null;
	 	$query->execute(array(':em'=> $email));
	 	$res=$query->fetchAll();

	 	if(count($res) == 1){
	 		foreach ($res as $row) {
	 			$name = $row['name'];
	 		}
	 	}
	 	else{	 		
			$msg = 'Email';
			header("Location: errorMsg.php?msg=$msg&er=3");
			die();
	 	}
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $name;
}


?>


