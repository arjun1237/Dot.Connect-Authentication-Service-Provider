<!-- The page connects to mySQL when the connect() is called    
CREDIT: university of Kent web development module documents-->


<?php

function connect(){
	$host = 'dragon.ukc.ac.uk';
	$dbname = 'dotConnectDB';
	$user = 'dotConnectDB';
	$pwd = 'oid%ylo';
	try {
		$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if ($conn) {
			return $conn;
		} 
		else {
			echo 'Failed to connect';
		}
	} 
	catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}

?>