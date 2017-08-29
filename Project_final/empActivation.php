<!-- this page is for sending token to email for account activation -->

<?php

include('DBconnect.php');
include('hash.php');
include('mailExp.php');
include('common.php');

if(isset($_POST['email'])){

	// avoids cross site scripting
	$email = normalize($_POST['email']);

	// check whether email is genuine
	validate($email, 'email', 'Email');

	// proceed if email does not exists
	if(!check($email)){
		$msg = 'Email';
		header("Location: errorMsg.php?msg=$msg&er=3");
		die();
	}

	// proceed if email exists
	else{
		$token = crypto_rand();

		// update new token
		update($email, $token);

		// get name of the person
		$name = getName($email);

		// send email with token to the user
		sendmail($email, $name, $email, $token, 2);

		// redirect
		header("Location: empVerifyCheck.php?email=ak750@kent.ac.uk&val=0");
		die();
	}
}
else{
	header("Location: errorMsg.php?er=1");
	die();
}



// function to extract name of the person whose email has been passed onto parameter
//------------------------------------------------------------------------------------

function getName($email){
	$conn=connect();
	$name = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT name from employee where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email));
	 	$conn=null;
	 	$res=$query->fetchAll();
	 	
	 	foreach($res as $row){
	 		$name = $row['name'];
	 	}

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $name;
}




// function to update new token in employee table of database
//------------------------------------------------------------------------------------

function update($email, $token){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE employee set token=:tk where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email, ':tk'=>$token));
	 	$conn=null;

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}




// function to check if email exists
//------------------------------------------------------------------------------------

function check($email){
	$conn=connect();
	$ch = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT * from employee where email = :em;
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


?>