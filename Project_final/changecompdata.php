<!-- This page is for accepting details for updating company information . -->


<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<title>Dot.Connect: Update Company Data</title>

	<link rel="icon" href="pics/DotConnect.png">  <!-- tab icon -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- i used echo date to store versions of style each time i save to avoid being cached -->
	<link rel="stylesheet" href="style/style1.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style2.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style3.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style6.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>

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

		<div class="login" id='total17'>
			<div id='heading17'>
				Company Data Update
			</div>

			<form action="dataChangeComp.php" method="POST" onsubmit="return validate(true)">
				<div id="div117">
					<p id='toupdate'>To Update :-</p>
					<div class="container">	
						<ul>
							<li>
								<input type="radio" id="f-option" name="selector" value='null'>
								<label for="f-option">Point of Contact</label>
								<div class="check"></div>
							</li>

							<li>
								<input type="radio" id="s-option" name="selector" value='null'>
								<label for="s-option">Company Title</label>
								<div class="check"><div class="inside"></div></div>
							</li>
						</ul>
					</div>
					<input id='update17' type="text" name="update" placeholder="">
					<input id='email17' type="text" name="email" placeholder="Company Email   [Registered]">
					<p id='warning17'>* Invalid Entries</p>
					<input id='submit17' type="submit" name="submit" value='&nbsp;&nbsp;&nbsp;UPDATE'>
				</div>
			</form>

			<div id='belowpart17'>
				<p><a href="company.php">Back to Main Page</a></p>
			</div>
			<i class="fa fa-cog fa-spin" id="spinner17"></i>
			<p class='cross17' id='correct117'>&#x2716;</p>
			<p class='cross17' id='correct127'>&#x2716;</p>
		</div>

	</div>

	<script type="text/javascript" src="JavaScript/script4.js?<?php echo date('l jS \of F Y h:i:s A'); ?>">	</script>

</body>

</html>