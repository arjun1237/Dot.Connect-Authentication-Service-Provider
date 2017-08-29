<!-- the page accepts the user input of email and password and verifies the details and prints the same -->

<?php

include("DBconnect.php");
include('hash.php');
include('common.php');

if(isset($_GET['email']) && isset($_GET['token'])){

	// normalize - avoids cross site scripting.
	$email = normalize($_GET['email']);
	$token = normalize($_GET['token']);

	// checks whether the the inputs are valid.
	validate($email, 'email', 'Email');
	validate($token, 'num', 'Token');

	// checking whether the email and token match
	checkall($email, $token);

	// new token is generated for updation.
	$token2 = crypto_rand();

	// new token is updated for the corresponding email
	updatetoken($email, $token2);
}

else{
	header("Location: errorMsg.php?er=1");
	die();
}


// function to update token details for the email provided
//-----------------------------------------------------------------

function updatetoken($email, $token){
	$conn=connect();
	try {
	 	$query = $conn->prepare(
	 		"UPDATE employee set token = :tk where email = :em;
	 	");

	 	$query->execute(array(':tk'=>$token, ':em'=> $email));
	 	$conn=null;
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}


// function to check whether email and token match, else redirect
//---------------------------------------------------------------------------

function checkall($email, $token){
	$conn=connect();
	try {
 		$query = $conn->prepare(
	 		"SELECT * from employee where token = :tk and email = :em;
	 	");

		$query->execute(array(':tk'=> $token, ':em'=> $email));
		$conn = null;
	 	$res=$query->fetchAll();

	 	if(count($res) != 1){
	 		$msg = 'credentials';
			header("Location: errorMsg.php?msg=$msg&er=4");
			die();
	 	}
	}
    catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
}



?>



<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<title>Dot.Connect: Employee Account Verification</title>

	<link rel="icon" href="pics/DotConnect.png">  <!-- tab icon -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- i used echo date to store versions of style each time i save to avoid being cached -->
	<link rel="stylesheet" href="style/style1.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style2.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style3.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style4.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style5.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style7.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>

	<!-- This carries the main layout division where everything si displayed -->
	<div class="layout1">

		<!-- This contains the logo part, which is the left side of the layout -->
		<div class="logo">
			<div class="dots">
				<p> <i class="fa fa-circle" style="color:#caabc0;"></i> &nbsp; &nbsp; <i class="fa fa-circle" style="color:#42383f;"></i> </p>
				<p> <i class="fa fa-circle" style="color:#705f6a;"></i> &nbsp; &nbsp; <i class="fa fa-circle" style="color:#0a0809;"></i> </p>
			</div>
			<div class="webName">
				<p id="dot" style="color:#857a81;">Dot<i class="fa fa-circle" style="color:#24c44e; font-size: 16px;"></i>Connect</p>
			</div>
		</div>

		<!-- This contains the registration part, which is the right side of the layout -->
		<div class="login">
			
			<p id='heading75'>Password Reset</p>

			<div id ='input76'>
				<input id='password99' type="password" name="email" placeholder="Set New Password">
				<input id='submit78' type="button" name="submit" value='   UPDATE'>
			</div>

			<i class="fa fa-cog fa-spin" id='spin99'></i>

			<p id="below99"><a href='login.php'>Login Page</a></p>

			<p id='comment99'></p>

			<div class="container50" id='msgbox60'>			  
			  <div class="dialogbox50">
			    <div class="body50">
			      <span class="tip50 tip-left50"></span>
			      <div class="message50">
			        <span>Must contain: <br />1 uppercase letter, <br />1 lowercase letter, <br />1 special character, <br />1 numeric value and atleast <br />10 characters in length.</span>
			      </div>
			    </div>
			  </div>
			</div>

		</div>

	</div>
<?php

// the following javascript code manages focus and blur attributes of the input elements 
// and once the submit button is clicked, it ajaxes to verify info and get the verified result
// and accordingly displays the message received from ajaxed URL.

echo"
	<script type='text/javascript'>	

		var pass = $('#password99');
		var submit = $('#submit78');
		var msg = $('#msgbox60');
		var form = $('#input76');
		var comment = $('#comment99');
		var comment1 = $('#comment90');
		var spin = $('#spin99');

		// password input focus function
		pass.focus(function(){
			pass.attr('placeholder', '');
			pass.css({color: '#f44523', backgroundColor: '#f4eff1'});
			msg.css({visibility: 'visible'});
		})

		// password input blur function
		pass.blur(function(){
			pass.attr('placeholder', 'Set New Password');
			pass.css({color: '#f4eff1', backgroundColor: '#6c5e6d'});
			msg.css({visibility: 'hidden'});
		})

		// submit button click function
		submit.click(function(){
			if(validate()){
				submit.css({visibility: 'hidden'});
				spin.css({visibility: 'hidden'});
				pass.css({visibility: 'hidden'});
				comment.css({visibility: 'visible'});

				// receives the comment from resetpass3.php by ajax-ing
				comment.load('resetpass3.php', {
					email: '".$email."',
					token: '".$token2."',
					pass: pass.val(),
				})
			}				
		})

		// function to check the password is valid
		function validate(){
			if(checkpwd())
				return true;
			else{
				alert('The password must contain 1 uppercase letter, 1 lowercase letter, 1 special character, 1 numeric value and the character length must be equal to or exceed 10.');
				return false;
			}
		}

		// function to check whether password passes all requirements
		function checkpwd(){
			if(/\d/g.test(pass.val()) && /[A-Z]/.test(pass.val()) && /[a-z]/.test(pass.val()) && pass.val().length >= 10)
				return true;
			return false;
		}
";
?>

	</script>

</body>

</html>