<!-- the page takes in username and password and gets it verified through ajax from .js files, if succeeds, then goes to home page -->

<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<title>Dot.Connect: Login</title>

	<link rel="icon" href="pics/DotConnect.png">  <!-- tab icon -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style/style1.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style2.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style3.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>

</head>

<body>
	<div class="layout1">
		<div class="logo">
			<div class="dots">
				<p> <i class="fa fa-circle" style="color:#caabc0;"></i> &nbsp; &nbsp; <i class="fa fa-circle" style="color:#42383f;"></i> </p>
				<p> <i class="fa fa-circle" style="color:#705f6a;"></i> &nbsp; &nbsp; <i class="fa fa-circle" style="color:#0a0809;"></i> </p>
			</div>
			<div class="webName">
				<p id="dot" style="color:#857a81;">Dot<i class="fa fa-circle" style="color:#24c44e; font-size: 16px;"></i>Connect</p>
			</div>
		</div>
		<div class="login" id="login">
			<div class="logWord">
				Login
			</div>
			</br>
			<form action='' method='POST' id='form99' onsubmit='return validate()'>
				<input spellcheck="false" type="text" name="username" placeholder="Official Email ID" id="username" /> </br></br>
				<input spellcheck="false" type="password" name="password" placeholder="Password" id="password" />
				<input type="submit" name="submit" value="" id="signIn"/>
			</form>
			<i id="unlock1" class="fa fa-unlock-alt" ></i>
			<br/><i id="user1" class="fa fa-user" ></i> <br/><br/><br/>
			<i id="key1" class="fa fa-key" ></i>
			<i id="spin21" class="fa fa-gear fa-spin"></i>
			<div id='warning211'>
				
			</div>
			<div id='belowpart212'>
				<p id="credentials" ><a href="forgotten.php"> Forgotten password?&nbsp; RESET </a></p>
				<p id="register" > <a href="empSignup.php">Not a member?&nbsp; REGISTER</a> </p>
				<p id='belowpart211'><a href="empAcntAct.php">Account Activation</a></p>
				<p id='belowpart214'><a href="company.php">Company Registration</a></p>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="JavaScript/script1.js?<?php echo date('l jS \of F Y h:i:s A'); ?>">	</script>
</body>
</html>