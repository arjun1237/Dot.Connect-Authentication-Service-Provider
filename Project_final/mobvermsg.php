<!-- this page basically verifies mobile and once done it sends back message saying token has been verified or not. -->


<?php
include('DBconnect.php');
include('hash.php');
include('common.php');

// avoids cross site scripting
$email = normalize($_POST['email']);
$token = normalize($_POST['token']);

$ch = check($email, $token);   // checks whether email with the corresponding token exists and accepts a boolean reply.

if($ch){

	// activates the mobile completing the mobile verification.
	activatemob($email);

	// new token is updated onto the email 
	updatetoken(crypto_rand(1000000, 9999999), $email);
	echo "<span style='color:#24c44e;'> &#10004 </span> Mobile number has been successfully verified.";
}
else{
	echo 'Wrong token entered. Please try again.';
}



// function changes the token value so that previous token cannot be taken advantage of by anyone.
//--------------------------------------------------------------------------------------------------------------------

function updatetoken($newTk, $email){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE mobile set token=:tk where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email, ':tk'=>$newTk));
	 	$conn=null;

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}



// function activates the mobile completing the mobile verification.
//--------------------------------------------------------------------------------------------------------------------

function activatemob($email){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE mobile set active=1 where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email));
	 	$conn=null;

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}



// function checks if there exits an email that corresponds to the particular token and returns a boolean value.
//--------------------------------------------------------------------------------------------------------------------

function check($email, $token){
	$conn=connect();
	$check = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT * FROM mobile where token =:tk and email = :em;
	 	");

	 	$query->execute(array(':tk'=> $token, ':em'=> $email));
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

?>