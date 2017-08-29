<?php

include('hash.php');

$salt = '2d3b64a371c6d3275556b0a7a';

$pass = "India@1237";

$hash = createhash($salt.$pass);

echo $hash;

?>