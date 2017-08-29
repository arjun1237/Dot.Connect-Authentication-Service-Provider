<!-- // this page contains functions that is used in most of the .php pages -->


<?php

// function helps take out unwanted characters from names  : CREDIT: StachOverFlow website
//-------------------------------------------------------------------------------------------------------------------
function normalize($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);    // helps avoid cross-site scripting
  return $data;
}


// function to validate the user entry
//--------------------------------------------------------------------------------------------------

function validate($input, $type, $msg = 'Input'){
	if($type == 'name'){
		if (!preg_match("/^[a-z0-9_\-\s]+$/i",$input)){
			header("Location: errorMsg.php?msg=$msg&er=1");
			die();
		}
	}
	else if($type == 'num'){
		if(!is_numeric($input)){
			header("Location: errorMsg.php?msg=$msg&er=1");
			die();
		}
	}
	else if($type == 'email'){
		if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
			header("Location: errorMsg.php?msg=$msg&er=1");
			die();
	    }
	}
	else if($type == 'empty'){
		if (empty($input)) {
			header("Location: errorMsg.php?er=1");
			die();
	    }
	}
}


?>