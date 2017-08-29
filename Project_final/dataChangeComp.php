<!-- this page updates the Point of Contact or the Compnay Title as per the user needs -->

<?php

include('DBconnect.php');
include('common.php');

if(isset($_POST['email']) && isset($_POST['selector']) && isset($_POST['update'])){

	// avoids cross site scripting
	$email = normalize($_POST['email']);
	$toUpdate = normalize($_POST['selector']);
	$value = normalize($_POST['update']);

	// check if the user entry was genuine
	validate($email, 'email', 'Email');
	validate($toUpdate, 'name', 'Input');
	validate($value, 'name', 'Input');

	// proceed if email does not exists
	if(!check($email)){
		$msg = 'Email';
		header("Location: errorMsg.php?msg=$msg&er=3");
		die();
	}

	// proceed if the value of update is Point of Contact
	if($toUpdate === 'poi'){

		// update the POC value onto the databse
		updatePOI($email, $value);
	}

	// proceed if the value of update is Company Title
	else if($toUpdate === 'title'){

		// update the Title value onto the databse
		updateTitle($email, $value);
	}

	// proceed if the above values do not match for update
	else{
		header("Location: errorMsg.php?er=1");
		die();
	}

	//redirect
	header("Location: dataChangeSuccess.php");
	die();
}
else{ 
	header("Location: errorMsg.php?er=1");
	die();
}



// function to update Company title
//-------------------------------------------------------------------------------------------

function updateTitle($email, $value){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE companyInfo SET title = :ttl WHERE email=:em;
	 	");
	 	$query->execute(array('em'=>$email, 'ttl'=>$value));
	 	$conn=null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

// function to update Point of contact
//-------------------------------------------------------------------------------------------

function updatePOI($email, $value){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE companyInfo SET pointContact = :poi WHERE email=:em;
	 	");
	 	$query->execute(array('em'=>$email, 'poi'=>$value));
	 	$conn=null;
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}


// function to check whether the email exits
//---------------------------------------------------------------------------------------------------------------

function check($email){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"SELECT * FROM companyInfo WHERE email=:em;
	 	");

	 	$query->execute(array('em'=>$email));
	 	$conn=null;
	 	$res=$query->fetchAll();

	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	if(count($res) !== 1)
		return false;
	else
		return true;
}


?>