<!-- This page is for employee registration.  -->

<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<title>Dot.Connect: Employee Registration</title>

	<link rel="icon" href="pics/DotConnect.png">  <!-- tab icon -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- i used echo date to store versions of style each time i save to avoid being cached -->
	<link rel="stylesheet" href="style/style1.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style2.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style3.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style4.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>

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
		<div class="login" id="layout221">
			<div id='heading22'>
				Employee Registration
			</div>

			<div id='form25'>
				<form action='empVerify.php' method='POST' onsubmit='return validate(true)'>
					<input type="text" name="fname" id='fname23' class='input28' placeholder='First Name'> 
					<input type="text" name="lname" id='lname24' class='input28' placeholder='Last Name'>
					<input type="number" name="CRNum" id='crnum29' class='input28' placeholder='Company Registration Number'>
					<input type="text" name="email" id='email30' class='input28' placeholder='Email ID [Official]'>
					<input type="password" name="pwd" id='password31' class='input28' placeholder='Set Password'>
					<input type="number" name="code" id='code32' class='input28' placeholder="Code">
					<input type="number" name="mob" id='mob33' class='input28' placeholder='Mobile Number [Optional]'>
					<input type="submit" name="submit" id='submit35' value='   REGISTER'>
				</form>
			</div>

			<div id='pavilion40'>			
				<p class="pav11"><a href='login.php'>Login</a></p></br>
				<p class="pav11"><a href='empAcntAct.php'>Account Activation</a></p>
			</div>

			<p><i class="fa fa-cog fa-spin" id='spin41'></i></p>
			<p id='warning42'></p>

			<div class="container50" id='msgbox50'>			  
			  <div class="dialogbox50">
			    <div class="body50">
			      <span class="tip50 tip-left50"></span>
			      <div class="message50">
			        <span>Must contain: <br />1 uppercase letter, <br />1 lowercase letter, <br />1 special character, <br />1 numeric value and atleast <br />10 characters in length.</span>
			      </div>
			    </div>
			  </div>
			</div>


			<div id='wrong99'>
				<p id='wrong91' class='wrong95'>&#10006;</p>
				<p id='wrong92' class='wrong95'>&#10006;</p>
				<p id='wrong93' class='wrong95'>&#10006;</p>
				<p id='wrong94' class='wrong95'>&#10006;</p>
			</div>

		</div>

	</div>

	<script type="text/javascript" src="JavaScript/script5.js?<?php echo date('l jS \of F Y h:i:s A'); ?>">	</script>

</body>

</html>