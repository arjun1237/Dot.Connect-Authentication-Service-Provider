<!-- testing -->



<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 70%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
</br>
<p style="font-family: arial, sans-serif; ">Keep Refreshing to see change - </p>
</br>
<?php

include('../Project_final/hash.php');

$str = 'AmirKhan';


function murmurhash3_int($key,$seed=0){
  $key  = array_values(unpack('C*',(string) $key));
  $klen = count($key);
  $h1   = (int)$seed;
  for ($i=0,$bytes=$klen-($remainder=$klen&3) ; $i<$bytes ; ) {
    $k1 = $key[$i]
      | ($key[++$i] << 8)
      | ($key[++$i] << 16)
      | ($key[++$i] << 24);
    ++$i;
    $k1  = (((($k1 & 0xffff) * 0xcc9e2d51) + ((((($k1 >= 0 ? $k1 >> 16 : (($k1 & 0x7fffffff) >> 16) | 0x8000)) * 0xcc9e2d51) & 0xffff) << 16))) & 0xffffffff;
    $k1  = $k1 << 15 | ($k1 >= 0 ? $k1 >> 17 : (($k1 & 0x7fffffff) >> 17) | 0x4000);
    $k1  = (((($k1 & 0xffff) * 0x1b873593) + ((((($k1 >= 0 ? $k1 >> 16 : (($k1 & 0x7fffffff) >> 16) | 0x8000)) * 0x1b873593) & 0xffff) << 16))) & 0xffffffff;
    $h1 ^= $k1;
    $h1  = $h1 << 13 | ($h1 >= 0 ? $h1 >> 19 : (($h1 & 0x7fffffff) >> 19) | 0x1000);
    $h1b = (((($h1 & 0xffff) * 5) + ((((($h1 >= 0 ? $h1 >> 16 : (($h1 & 0x7fffffff) >> 16) | 0x8000)) * 5) & 0xffff) << 16))) & 0xffffffff;
    $h1  = ((($h1b & 0xffff) + 0x6b64) + ((((($h1b >= 0 ? $h1b >> 16 : (($h1b & 0x7fffffff) >> 16) | 0x8000)) + 0xe654) & 0xffff) << 16));
  }
  $k1 = 0;
  switch ($remainder) {
    case 3: $k1 ^= $key[$i + 2] << 16;
    case 2: $k1 ^= $key[$i + 1] << 8;
    case 1: $k1 ^= $key[$i];
    $k1  = ((($k1 & 0xffff) * 0xcc9e2d51) + ((((($k1 >= 0 ? $k1 >> 16 : (($k1 & 0x7fffffff) >> 16) | 0x8000)) * 0xcc9e2d51) & 0xffff) << 16)) & 0xffffffff;
    $k1  = $k1 << 15 | ($k1 >= 0 ? $k1 >> 17 : (($k1 & 0x7fffffff) >> 17) | 0x4000);
    $k1  = ((($k1 & 0xffff) * 0x1b873593) + ((((($k1 >= 0 ? $k1 >> 16 : (($k1 & 0x7fffffff) >> 16) | 0x8000)) * 0x1b873593) & 0xffff) << 16)) & 0xffffffff;
    $h1 ^= $k1;
  }
  $h1 ^= $klen;
  $h1 ^= ($h1 >= 0 ? $h1 >> 16 : (($h1 & 0x7fffffff) >> 16) | 0x8000);
  $h1  = ((($h1 & 0xffff) * 0x85ebca6b) + ((((($h1 >= 0 ? $h1 >> 16 : (($h1 & 0x7fffffff) >> 16) | 0x8000)) * 0x85ebca6b) & 0xffff) << 16)) & 0xffffffff;
  $h1 ^= ($h1 >= 0 ? $h1 >> 13 : (($h1 & 0x7fffffff) >> 13) | 0x40000);
  $h1  = (((($h1 & 0xffff) * 0xc2b2ae35) + ((((($h1 >= 0 ? $h1 >> 16 : (($h1 & 0x7fffffff) >> 16) | 0x8000)) * 0xc2b2ae35) & 0xffff) << 16))) & 0xffffffff;
  $h1 ^= ($h1 >= 0 ? $h1 >> 16 : (($h1 & 0x7fffffff) >> 16) | 0x8000);
  return $h1;
}
function murmurhash3($key,$seed=0){
  return base_convert(murmurhash3_int($key,$seed),10,32);
}


echo"

<table>
  <tr>
    <th>Type</th>
    <th>Crypto</th>
    <th>Normal</th>
  </tr>
  <tr>
    <td>Random Number</td>
    <td>".floor(100000000*(hexdec(bin2hex(openssl_random_pseudo_bytes(3)))/0xffffffff))."</td>
    <td>".rand(100000, 999999)."</td>
  </tr>
  <tr>
    <td>Hashing of string '".$str."'</td>
    <td>".sha1($str)."</td>
    <td>".murmurhash3($str)."</td>
  </tr>
  <tr>
    <td>Salting for string '".$str."'</td>
    <td>".$str.salt()."</td>
    <td>".$str.murmurhash3(rand(100000, 999999))."</td>
  </tr>
</table>

";
?>


</body>
</html>
