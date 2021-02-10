<?php
//include composer autoload here, if you didn't

use Encrypt\Token;

$id       =  "1030";
$amount   =  "000100";
$deviceId =  "6424839";

$token    = new Token($id, $amount, $deviceId);

$tokenFormated = $token->formatByFourDigits(); // something like 9834 7416 0995 9995 8969

echo $tokenFormated;
