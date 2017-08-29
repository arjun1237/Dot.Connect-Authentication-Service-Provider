<!-- thsi page accepts the activation code and activates the user account -->

<?php

include('DBconnect.php');
include('hash.php');
include('ipdata.php');
include('common.php');

if(isset($_GET['email']) && isset($_GET['token'])){

	// avoids cross site scripting
	$email = normalize($_GET['email']);
	$token = normalize($_GET['token']);

	// check if the user entry is genuine
	validate($email, 'email', 'Email');
	validate($token, 'num', 'Token');

	$tokenUpdate = crypto_rand();

	// check if the provided email exists
	investigate();

	// update the token so previous token cannot be taken advantage of
	updatetoken();

	// activate the account
	activate();

	// refresh the notLogged count to 0 in login table of databse
	refresh();

	// redirect
	header("Location: regMessage.php");
	die();
}
else{		  
	header("Location: errorMsg.php?er=1");
	die();
}



//function to update the notlogged to 0 in login table of databse.
//----------------------------------------------------------------------

function refresh(){
	global $email;
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE login SET notlogged=:a WHERE email=:em;
	 	");
	 	$query->execute(array(':em'=>$email, ':a'=>0));
	 	$conn = null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

//function to activate the account
//----------------------------------------------------------------------

function activate(){
	global $email;
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE employee SET active=:a WHERE email=:em;
	 	");
	 	$query->execute(array(':em'=>$email, ':a'=>1));
	 	$conn = null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

//function to update the token
//----------------------------------------------------------------------

function updatetoken(){
	global $email, $tokenUpdate;
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE employee SET token=:tk WHERE email=:em;
	 	");
	 	$query->execute(array(':em'=>$email, ':tk'=>$tokenUpdate));
	 	$conn = null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}



// function to check whether the said email exits or redirect to specific page.
//-----------------------------------------------------------------------------------------------------------

function investigate(){
	global $email, $token;
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"SELECT token FROM employee WHERE email = :em;
	 	");

	 	$query->execute(array(':em'=>$email));
	 	$conn = null;
	 	$res=$query->fetchAll();


	 	if(count($res) == 1){
		 	foreach($res as $row){
		 		$tk=$row['token'];
		 		break;
	 		}
	 	}
	 	elseif(count($res) == 0){
	 		$msg = 'Activation Code';		  
			header("Location: errorMsg.php?msg=$msg&er=3");
			die();
	 	}
	 	else{
			header("Location: errorMsg.php?er=1");
			die();
	 	}
	 	if($token !=  $tk){
	 		$msg = 'Activation Code';		  
			header("Location: errorMsg.php?msg=$msg&er=3");
			die();
	 	}
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}


?>