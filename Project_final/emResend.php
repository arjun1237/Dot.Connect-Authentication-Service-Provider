<!-- this page is to resend token for either email or mobile verifcation -->

<?php

include('DBconnect.php');
include('hash.php');
include('mailExp.php');
include('mobile.php');
include('common.php');

if(isset($_POST['email']) && isset($_POST['val'])){

	// avoids cross site scripting
	$email = normalize($_POST['email']);
	$val = normalize($_POST['val']);

	// checking whether the user inputs are genuine
	validate($email, 'email', 'Email');
	validate($val, 'num', 'Number');
}

// if the value is 1, send token for email verification
if($val == 1){
	$token = crypto_rand();

	// update the new token into the employee table of databse
	updatetoken($email, $token);

	// get name of the person whose token has been updated
	$name = getname($email);

	// send email to the person for activation
	if(!is_null($name))
		sendmail($email, $name, $email, $token, 2);
	else
		sendmail($email, '', $email, $token, 2);
}

// if the value is 2, send token for mobile verification
if($val == 2){

	// create token between numbers mentioned in parameters
	$token = crypto_rand(100000, 999999);

	// update the token in the mobile table of database
	updatemobtk($email, $token);

	// get the mobile number of the person
	$number = getnum($email);

	// send token as sms
	if(strlen($number) > 5){
		$sms = "Token for mobile verification: $token";
		sendsms($number, 'Dot.Connect', $sms);
	}
}



// function to extract mobile number of the person
//------------------------------------------------------------------------
function getnum($email){
	$conn=connect();
	$num = null;
	try {
	 	$query = $conn->prepare(
	 		"SELECT code, mobile from mobile where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email));
	 	$conn=null;
	 	$res=$query->fetchAll();
	 	
	 	foreach($res as $row){
	 		$num = $row['code'].$row['mobile'];
	 	}	 	

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $num;
}



// function to update the token value of the provided email in the mobile table of database
//-------------------------------------------------------------------------------------------
function updatemobtk($email, $token){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE mobile set token=:tk where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email, ':tk'=>$token));
	 	$conn=null;

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}



// function to get the name of the person whose email ID has been provided
//----------------------------------------------------------------------------
function getname($email){
	$conn=connect();
	$name = null;
	try {
	 	$query = $conn->prepare(
	 		"SELECT name from employee where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email));
	 	$conn=null;
	 	$res=$query->fetchAll();
	 	
	 	foreach($res as $row){
	 		$check = $row['name'];
	 	}	 	
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $check;
}



// function to update the token of the email address provided in the employee table of the database
//----------------------------------------------------------------------------------------------------
function updatetoken($email, $token){
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

?>