<!-- this page displays the message that an activation email has been sent to activate the account and also it accepts the verification code for mobile numbers which is verified through ajax -->

<?php

include('common.php');

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
	<link rel="stylesheet" href="style/style5.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<link rel="stylesheet" href="style/style7.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>

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

		<div class="login" id="login1">
			<p id='message66'>A mail has been sent to your email. </br></br> Please check to activate.</p>

			<?php

			if(isset($_GET['val'])){
				$val = normalize($_GET['val']);
				validate($val, 'num', 'Token');
				if($val == 1){
					echo "<p id='mob67'>Enter 6-digit Mobile verification token code sent to you:</p>";
				}
			}

			?>

			<div id='comment70'>
				
			</div>

			<?php
			
			$email = normalize($_GET['email']);     // avoids cross site scripting
			validate($email, 'email', 'Email');     // checks if email is genuine


			// if sms has been sent display below
			if(isset($val) && $val == 1){

				echo"
				<div id ='form68'>				
					<input id='token69' type='number' name='token' placeholder='     Token'>
					<input type='hidden' name='email' value='$email'>
					<input id='submit70' type='button' name='submit' value='   VERIFY'>
				</div>
				";
			}


			echo 
			"
			<div id= 'bewlowpart110'> 
				<p class='redirect13 red65' id='emresend71'>Have not recieved email yet?&nbsp; RESEND </p>";
				if(isset($val) && $val == 1){
					echo 
					"<p class='redirect13 red65' id='smsresend72'>Have not recieved SMS yet?&nbsp; RESEND</p>";
				}

				?>
				<p class='redirect13 red65'><a href='empSignup.php'>Back to Main Page</a></p>
			</div>
		</div>

	</div>
	<?php
	echo "

	<script type='text/javascript'>
		var token = $('#token69');

		token.focus(function(){
			token.attr('placeholder','');
		})

		token.blur(function(){
			token.attr('placeholder','     Token');;
		})

		var submit = $('#submit70');
		var statement = $('#mob67');
		var form = $('#form68');
		var comment = $('#comment70');

		submit.click(function(){
			statement.css({visibility: 'hidden'});
			form.css({visibility: 'hidden'});
			submit.css({visibility: 'hidden'});

			comment.load('mobvermsg.php', {
				email: '".$email."',
				token: token.val()
			})
		})

		var emRes = $('#emresend71');
		var smsResend = $('#smsresend72');

		smsResend.click(function(){
			$.ajax(
	        {
	            method:'post',
		        url:'emResend.php',
		        data:
		        {
		            'email': '".$email."',
		            'val': '2'
		        }
	        });
		});

		emRes.click(function(){
			$.ajax(
	        {
	            method:'post',
		        url:'emResend.php',
		        data:
		        {
		            'email': '".$email."',
		            'val': '1'
		        }
	        });
		});

	</script>
	";
	?>
</body>

</html>