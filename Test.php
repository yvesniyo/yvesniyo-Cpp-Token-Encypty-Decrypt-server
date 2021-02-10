<?php
require "vendor/autoload.php";

use Encrypt\Token;


$id       =  "1030"; // id of this transaction
$amount   =  "000100";
$deviceId =  "6424839";


$token    = new Token($id, $amount, $deviceId);

header("Content-Type: application/json");

$theNumber = (int) $token->getString();

echo json_encode([
    "theNumber" => $theNumber,
    "token    " => $token->getString(),
    "formated_token" => $token->formatByFourDigits(),
    "details" => Token::parse($token)
]);
