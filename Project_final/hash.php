<?php


// functions to create cryptographically secure random number  : CREDIT: stackoverflow website
//----------------------------------------------------------------------------------------------------------

function crypto_rand($min=10000000000,$max=1000000000000000,$pedantic=True) {
    $diff = $max - $min;
    if ($diff <= 0) return $min; // not so random...
    $range = $diff + 1; // because $max is inclusive
    $bits = ceil(log(($range),2));
    $bytes = ceil($bits/8.0);
    $bits_max = 1 << $bits;
    $num = 0;
    do {
        $num = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes))) % $bits_max;
        if ($num >= $range) {
            if ($pedantic)
                continue; // start over instead of accepting bias
            $num = $num % $range;  // to hell with security
        }
        break;
    } while (True);  // because goto attracts velociraptors
    return $num + $min;
}




// functions for rnadom testing
//----------------------------------------------------------------------------------------------------------

function randomStuff(){  
    $rand = bin2hex(random_bytes(16)).substr(md5(uniqid(rand(), true)), 16, 16).crypto_rand();
    return $rand;
}




// creates hash of the password provided
//-------------------------------------------------------------------

function createhash($pass){
    return substr(hash('sha512', $pass), 20, 45);
}




// function to generate salts for the password
//----------------------------------------------------------

function salt(){
    return substr(hash('sha256', rand()), 13, 25);
}

?>