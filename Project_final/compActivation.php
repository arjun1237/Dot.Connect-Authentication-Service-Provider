<!-- This page is for activation of compnay account.  -->

<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<title>Dot.Connect: Company Account Activation </title>

	<link rel="icon" href="pics/DotConnect.png">  <!-- tab icon -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- i used echo date to store versions of style each time i save to avoid being cached -->
	<link rel="stylesheet" href="style/style1.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style2.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style3.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style4.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style5.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>

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
		<div class="login page121" id="login1">
			<p id='header12'>Company Account Activation</p>
			<form action="redirectEmail.php" method="POST" onsubmit="return validate(true)">
				<input id='email12' type="text" spellcheck='false' name="email" placeholder="Company Email   [Registered]">
				<input id='submit12' type="submit" name="submit" value='   ACTIVATE'>
			</form>
			<i class="fa fa-cog fa-spin" id="spinner12"></i>
			<div class="redMainPage14">
				<p id='mainpage14' ><a href="company.php"> Back to Main Page </a></p> 
			</div>
		</div>

	</div>

	<script type="text/javascript" src="JavaScript/script3.js?<?php echo date('l jS \of F Y h:i:s A'); ?>">	</script>

</body>

</html>