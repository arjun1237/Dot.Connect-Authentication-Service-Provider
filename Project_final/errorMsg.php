<!-- This page is for displaying error message.  -->


<?php

include('common.php');

$ch = false;
if(isset($_GET['er'])){

	$er = normalize($_GET['er']);           //avoids cross site scrpting
	if(isset($_GET['msg'])){
		$msg = normalize($_GET['msg']);     //avoids cross site scrpting
		$ch = true;
	}

	validate($er, 'num', 'Error Code');     // checks if the error code is genuine
}
else{
	header("Location: errorMsg.php?er=1");
	die();
}

?>

<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<title>Dot.Connect: Error Message</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- i used echo date to store versions of style each time i save to avoid being cached -->
	<link rel="stylesheet" href="style/style1.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style2.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style3.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
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

		<div class='login'>
			<div id='message16'>

			<!-- as per the user error code entry, it displays the appropriate message -->
				<?php
					if($er == 1){
						echo '<span> &#10006 </span> &nbsp; There seems to be a problem with the page. We request you to try again.';
					}
					elseif($er==2 && $ch){
						echo "<span> &#10006 </span> &nbsp; The $msg that was provided seems to be registered already. We request you to try again.";
					}
					elseif($er==3 && $ch){
						echo "<span> &#10006 </span> &nbsp; The $msg that was provided does not exist. We request you to try again.";
					}
					elseif($er==4 && $ch){
						echo "<span> &#10006 </span> &nbsp; The $msg that was provided does not match with the registered company.";
					}
					elseif($er==5 && $ch){
						echo "<span> &#10006 </span> &nbsp; The $msg that was provided, unfortunately, is not activated.";
					}
					else{
						echo '<span> &#10006 </span> &nbsp; There seems to be a problem with the page. We request you to try again.';
					}
				?>
			</div>

			<div id='belowPart16'>
				<p><a href="company.php">Company Registration</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="empSignup.php">Employee Registration</a></p>
				<p><a href="compActivation.php">Company Acount Activation</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="empAcntAct.php">Employee Account Activation</a></p>
				<p><a href="changecompdata.php">Update Company Details</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="login.php">Employee Login</a></p>
			</div>
		</div>
	</div>
</body>
</html>