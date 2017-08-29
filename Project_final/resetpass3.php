<!-- this page is last step of reset password process. this page is ajaxed from resetpass2.php -->

<?php

include("DBconnect.php");
include('hash.php');
include('common.php');

if(isset($_POST['email']) && isset($_POST['token']) && isset($_POST['pass'])) {

	// normalize - checks for cross-site scripting
	$email = normalize($_POST['email']);
	$token = normalize($_POST['token']);
	$pass = normalize($_POST['pass']);

	// checks whether the input are genuine.
	validate($email, 'email', 'Email');
	validate($token, 'num', 'Token');

	// checks whether the email and token matches and if so proceeds
	if(checkall($email, $token)){

		// new token to update the old one so as to avoid being taken advantage of
		$token2 = crypto_rand();

		// password salted and hashed
		$salt = salt();
		$pass = $salt.$pass;
		$hash = createhash($pass);

		// employee details updated and password reset completed
		updateDetails($email, $token2, $hash, $salt);
		echo "Password has been reset successfully.";
	}
}


// function to update the employee details
//---------------------------------------------------------------------------------------

function updateDetails($email, $token, $hash, $salt){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE employee set token = :tk, hash = :hh, salt = :st where email = :em;
	 	");

	 	$query->execute(array(':tk'=>$token, ':hh'=> $hash, ':st'=>$salt, ':em'=> $email));
	 	$conn=null;
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}


// function checks whether the provided email matches with the token
//---------------------------------------------------------------------------------------

function checkall($email, $token){
	$conn=connect();
	$ch = false;
	try {
 		$query = $conn->prepare(
	 		"SELECT * from employee where token = :tk and email = :em;
	 	");

		$query->execute(array(':tk'=> $token, ':em'=> $email));
		$conn = null;
	 	$res=$query->fetchAll();

	 	if(count($res) != 1){
	 		echo 'Token has expired.';
	 	}
	 	else
	 		$ch = true;
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $ch;
}



?>