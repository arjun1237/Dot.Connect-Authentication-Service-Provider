<!-- The following code has been extracted from https://github.com/PHPMailer/PHPMailer and is used for sending mails-->

<?php

// this is a library that needed to be imported in order to use PHPMailer object.
require 'PHPMailer/PHPMailerAutoload.php';


// sends mail to a particular user and deleivers the message
//--------------------------------------------------------------------------------------------------------------

function sendmail($to, $name, $val, $token, $opt = 1){
	$msg = null;

	// message for account activation using regNum and token values
	if($opt == 1)
		$msg = "Hi $name</br></br>
				Warm Welcome!</br></br>
				Please click the below link to activate your account: </br>
				http://raptor.kent.ac.uk/~ak750/Project_final/activated.php?regNum=$val&token=$token </br></br>
				Regards,</br>
				Dot.Connect";

	// message for account activation using email and token values
	else if($opt == 2)
		$msg = "Hi $name</br></br>
				Warm Welcome!</br></br>
				Please click the below link to activate your account: </br>
				http://raptor.kent.ac.uk/~ak750/Project_final/empActivated.php?email=$val&token=$token </br></br>
				Regards,</br>
				Dot.Connect";

	// message for warning the user about login from a different IP address.
	else if($opt == 3)
		$msg = "Hi $name</br></br>
				Please be informed that there was an attempt to login to your account from a different location: </br>
				<b>IP Address: $token,&nbsp;&nbsp; Area: $val </b> <br /><br />
				If it was you, who logged in, then no action is required from your side. If it wasn't you, then click the below link to reset your password: <br /> 
				http://raptor.kent.ac.uk/~ak750/Project_final/forgotten.php </br></br>
				Regards,</br>
				Dot.Connect";

	// message for password reset
	else if($opt == 4)
		$msg = "Hi $name</br></br>
				Please click the below link to reset password: </br>
				http://raptor.kent.ac.uk/~ak750/Project_final/resetpass2.php?email=$val&token=$token </br></br>
				Regards,</br>
				Dot.Connect";

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmx.com';                         // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'ak750@gmx.com';                    // SMTP username
	$mail->Password = 'projectFinal';                     // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to                   
    $mail->Mailer   = "ssl"; 

	$mail->setFrom('Dot.Connect@DotConnect.com');
	$mail->addAddress($to, $name);                        // Add a recipient
	// $mail->addReplyTo('info@example.com', 'Information');
	// $mail->addCC('cc@example.com');
	$mail->addBCC('arjun.kp1237@gmail.com');

	// $mail->addAttachment('CV.pdf');                   // Add attachments
	$mail->isHTML(true);                                 // Set email format to HTML


	// Subject line options according to the message sent
	if($opt == 1 || $opt == 2)
		$mail->Subject = 'Dot.Connect: Account Activation';
	else if($opt == 3)
		$mail->Subject = 'Dot.Connect: IP Address Suspicion';
	else if($opt == 4)
		$mail->Subject = 'Dot.Connect: Password Reset';
	else
		$mail->Subject = 'Dot.Connect: Important Message';

	$mail->Body    = $msg;

	$mail->AltBody = "To get the complete message please activate HTML in your email platform";

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} 
	else {
	    echo '';
	}
}


?>