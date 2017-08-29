<!-- this page is to check the login details of the user and send back message after verification -->

<?php
include('DBconnect.php');
include('hash.php');
include('ipdata.php');
include('mailExp.php');
include('common.php');

if(isset($_POST['pass']) && isset($_POST['user'])){

	// avoiding cross site scripting
	$pass = normalize($_POST['pass']);
	$user = normalize($_POST['user']);

	// extracting domain from email
	$domain = substr($user, strpos($user, '@')+1);

	// check if company exists and if it exists check whether its active.
	if(checkcomp($domain)){

		// check whether the email provided by the user exists, if it does, then store its employee details in an array
		$ch = checkemail($user);
		if($ch[0]){

			// get all location details of the particular user in an array
			$loc = getLocation($user);

			// get the users current location info
			$ip = getLocationInfoByIp();

			$ipcheck = false;

			// check if current ip matches with the historic location info
			foreach($loc as $location){
				if($location == $ip['ip'])
					$ipcheck = true;
			}

			// if the location does not match, then send a mail to the user saying the account has been logged in from a new location
			if(!$ipcheck){
				sendmail($user, $ch[3], $ip['city'].', '.$ip['country'], $ip['ip'], 3);
				addlocation($user, $ip['ip'], $ip['city'], $ip['country']);
			}

			$hash = createhash($ch[2].$pass);

			// if the attempt is unsuccesful, then it is recorded and if it exceeds 2, then account is blocked
			if($hash !== $ch[1]){
				$attempt = addattempt($user);
			}

			// each time the login is successful, the unsuccessful attempt record is updated to zero
			else{
				attemptzero($user);
				echo 'success!';
			}
		}
	}

}
else{
	echo "* the credentials were not set";
}


// function adds new location details into the location table of the databse
//--------------------------------------------------------------------------------
function addlocation($email, $ip, $city, $country){
	$conn=connect();
	try {
 		$query = $conn->prepare(
	 		"INSERT into location(email, IPAddress, city, country) VALUES(:em, :ip, :ct, :co);
	 	");

		$query->execute(array(':em'=> $email, ':ip'=> $ip, ':ct'=>$city, ':co'=>$country));
	 	$conn=null;
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}


// function updates the no of unsuccessful login attempts to zero
//---------------------------------------------------------------------
function attemptzero($email){
	$conn=connect();
	try {
 		$query = $conn->prepare(
	 		"UPDATE login set notlogged = :nl where email = :em;
	 	");

		$query->execute(array(':nl'=> 0, ':em'=> $email));
	 	$conn=null;
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}


// adds the no of attempts by the user to unsuccessfully login and if it exceeds 2, the user is blocked and a message is sent
//----------------------------------------------------------------------------------------------------------------------------
function addattempt($email){
	$conn=connect();
	$attempt = 0;
	try {
	 	$query = $conn->prepare(
	 		"SELECT * FROM login where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email));
	 	$res=$query->fetchAll();
	 	if(count($res) > 0){
	 		foreach ($res as $row) {
	 			$attempt = $row['notlogged'];
	 		}
	 		$attempt++;
	 		$query2 = $conn->prepare(
		 		"UPDATE login set notlogged = :nl where email = :em;
		 	");

		 	$query2->execute(array(':em'=> $email, ':nl'=> $attempt));
	 	}
	 	else if(count($res) == 0){
	 		$attempt = 1;
	 		$query2 = $conn->prepare(
		 		"INSERT INTO login(email, notlogged) VALUES(:em, :nl);
		 	");

		 	$query2->execute(array(':em'=> $email, ':nl'=> $attempt));
	 	}
	 	if($attempt >= 3){
	 		$query3 = $conn->prepare(
		 		"UPDATE employee set active = :a where email = :em;
		 	");

		 	$query3->execute(array(':a'=>0, ':em'=> $email));
			echo '* Your account has been blocked! Reactivate to login.';
	 	}
	 	else{	 		
			echo '* The credentials did not match. Try again!';
	 	}
	 	$conn=null;
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

// function basically checks for the historic IP Address location details from the given email address
//---------------------------------------------------------------------------------------------------------
function getLocation($email){
	$conn=connect();
	$ch = array();
	try {
	 	$query = $conn->prepare(
	 		"SELECT * FROM location where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email));
	 	$conn=null;
	 	$res=$query->fetchAll();

	 	if(count($res) >= 1){
	 		$i = 0;
	 		foreach ($res as $row) {
	 			$ch[$i] = $row['IPAddress'];
	 			$i++;
	 		}
	 	}
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $ch;
}

// check whether the email provided by the user exists, if it does, then store its employee details in an array or send error message
//-------------------------------------------------------------------------------------------------------------------------------------
function checkemail($email){
	$conn=connect();
	$ch = array();
	$ch[0] = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT * FROM employee where email = :em;
	 	");

	 	$query->execute(array(':em'=> $email));
	 	$conn=null;
	 	$res=$query->fetchAll();

	 	if(count($res) != 1){
	 		echo '* Your email is not registered.';
	 	}
	 	else if(count($res) == 1){
	 		foreach ($res as $row) {
	 			if($row['active'] == 1){
	 				$ch[0] = true;
	 				$ch[1] = $row['hash'];
	 				$ch[2] = $row['salt'];
	 				$ch[3] = $row['name'];
	 			}
	 			else{
	 				echo '* Your email account is not activated';
	 			}
	 		}
	 	}
	 	else{
	 		echo '* Something wrong with the details entered.';
	 	}
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $ch;
}



// check if company exists and if it exists check whether its active, if not send back error messages
//--------------------------------------------------------------------------------------------------------
function checkcomp($domain){
	$conn=connect();
	$ch = false;
	try {
	 	$query = $conn->prepare(
	 		"SELECT * FROM companyInfo where mailDomain = :dom;
	 	");

	 	$query->execute(array(':dom'=> $domain));
	 	$conn=null;
	 	$res=$query->fetchAll();

	 	if(count($res) != 1){
	 		echo '* Your company is not registered.';
	 	}
	 	else if(count($res) == 1){
	 		foreach ($res as $row) {
	 			if($row['active'] == 1)
	 				$ch = true;
	 			else{
	 				echo '* Your company account is not activated';
	 			}
	 		}
	 	}
	 	else{
	 		echo '* Something wrong with the details entered.';
	 	}
	} 
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	return $ch;
}


?>