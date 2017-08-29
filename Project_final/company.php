<!-- This page is for company registration.  -->

<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<title>Dot.Connect: Company Registration</title>

	<link rel="icon" href="pics/DotConnect.png">  <!-- tab icon -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- i used echo date to store versions of style each time i save to avoid being cached -->
	<link rel="stylesheet" href="style/style1.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style2.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style3.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>

	<!-- This carries the main layout division where everything is displayed -->
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
		<div class="login" id="login1">
			<form action="compValid.php" method="POST" onsubmit="return validate(true);">
				<p class="writing1" id="compReg">Company Registration</p> </br>
				<div class="writing1" id="poc">Point of Contact</div>
				<input class="companyReg sec1" spellcheck="false" type="text" name="firstNamePOI" placeholder="First Name" id="poiName" /> 
				<input class="companyReg sec1" spellcheck="false" type="text" name="lastNamePOI" placeholder="Last Name" id="poiName1" /></br> 
				<input class="companyReg" spellcheck="false" type="text" name="compTitle" placeholder="Company Title" id="compTitle" /></br>  
				<input class="companyReg" spellcheck="false" type="number" name="compRegNumber" placeholder="Registration Number" id="compRegNumber" /></br>
				<input class="companyReg" spellcheck="false" type="text" name="compMail" placeholder="Company Email  [valid]" id="compMail" />
				<p id="wrongCred1"></p></br>
				<input type="hidden" name="mailEnd" value="" id='mailEnd1'>
				<input class="companyReg" type="submit" name="submit" value="   REGISTER" id="signIn2"/>
			</form>
			<i class="fa fa-cog fa-spin" id="spinner11"></i>
		</div>

		<!-- This contains the cross mark to indicate something wrong with the input. -->
		<div id="greenChecks1">		
			<i class="fa fa-remove greenCh" id="display11" ></i> </br>
			<i class="fa fa-remove greenCh" id="display12"></i> </br>
			<i class="fa fa-remove greenCh" id="display13"></i> </br>
			<i class="fa fa-remove greenCh" id="display14"></i> 
		</div>

		<!-- The message box for the emial input -->
		<div class="container11" id="msgBox11">		  
		  <div class="dialogbox11">
		    <div class="body11">
		      <span class="tip tip-left"></span>
		      <div class="message11">
		        <span>E-Mail must be company based. Dont use freemails.</span>
		      </div>
		    </div>
		  </div>		  
		</div>

		<div id='pavilion'>
			<p class="pav11 top78"><a href='compActivation.php'>Account Activation</a></p></br>
			<p class="pav11 top78"><a href='changecompdata.php'>Rename Company Title</a></p></br>
			<p class="pav11 lefty11  top78"><a href='changecompdata.php'>Change Point Of Contact</a></p>
		</div>

	</div>

	<script type="text/javascript" src="JavaScript/script.js?<?php echo date('l jS \of F Y h:i:s A'); ?>">	</script>

</body>

</html>