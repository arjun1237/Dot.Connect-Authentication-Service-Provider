<!-- this includes mobile functionality -->


<?php


// function sends sms to numbers in most countries (excludes US $ Canada becase of sms alert restrictions from other countries).
//-------------------------------------------------------------------------------------------------------------------------------
function sendsms($number, $from, $msg){

    $user = 'arjun.kp1237@gmail.com';
    $pwd = 'Textlocal1237';

    // vars takes in values for POST fields variables.
    $vars = 'uname='.$user.'&pword='.$pwd.'&message='.$msg.'&from='.$from.'&selectednums='.$number.'&info=1&test=0';

    // uses txtlocal sms service to send sms using curl functions
    $curl = curl_init('http://www.txtlocal.com/sendsmspost.php');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    echo $result = curl_exec($curl);
    curl_close($curl);
}


?>