<!-- this page activates the company account -->

<?php

include('DBconnect.php');
include('hash.php');
include('common.php');

$reg = null;
$token = null;

if(isset($_GET['regNum']) && isset($_GET['token'])){

	// avoids cross site scripting
	$reg = normalize($_GET['regNum']);
	$token = normalize($_GET['token']);
	
	// checks if user entry is genuine
	validate($reg, 'num', 'Registration Number');
	validate($token, 'num', 'Token');

	$tokenUpdate = crypto_rand();

	// check whether the provided email exits
	investigate();

	// update the token so the old one cannot be reused
	updatetoken();

	// activate the account
	activate();

	// redirect
	header("Location: regMessage.php");
	die();
}
else{		  
	header("Location: errorMsg.php?er=1");
	die();
}



//function to activate the account
//----------------------------------------------------------------------

function activate(){
	global $reg;
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE companyInfo SET active=:a WHERE regNum=:r;
	 	");
	 	$query->execute(array(':r'=>$reg, ':a'=>1));
	 	$conn = null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

//function to update the token
//----------------------------------------------------------------------

function updatetoken(){
	global $reg, $tokenUpdate;
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE companyInfo SET token=:h WHERE regNum=:r;
	 	");
	 	$query->execute(array(':r'=>$reg, ':h'=>$tokenUpdate));
	 	$conn = null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}



// function to check whether the said email exits or redirect to specific page.
//-----------------------------------------------------------------------------------------------------------

function investigate(){
	global $reg, $token;
	$conn=connect();
	$hh = null;
	try {
	 	$query = $conn->prepare(
	 		"SELECT token FROM companyInfo WHERE regNum = :r;
	 	");

	 	$query->execute(array(':r'=>$reg));
	 	$conn = null;
	 	$res=$query->fetchAll();


	 	if(count($res) == 1){
		 	foreach($res as $row){
		 		$hh=$row['token'];
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

	 	if($token !==  $hh){
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