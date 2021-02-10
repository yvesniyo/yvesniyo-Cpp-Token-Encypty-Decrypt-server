<?php

namespace Encrypt;

class Encrypt
{



    public static function encrypt(Token $token): string
    {
        return self::exchange(TokenOrganizer::encode($token));
    }


    public static function decrypt(String $token): string
    {
        return self::exchange($token);
    }


    private static function exchange($token): string
    {
        $chars = str_split($token);
        $result = [];
        foreach ($chars as $char) {
            switch ($char) {
                case "0":
                    $result[] = "9";
                    break;
                case "1":
                    $result[] = "8";
                    break;
                case "2":
                    $result[] = "7";
                    break;
                case "3":
                    $result[] = "6";
                    break;
                case "4":
                    $result[] = "4";
                    break;
                case "5":
                    $result[] = "5";
                    break;
                case "6":
                    $result[] = "3";
                    break;
                case "7":
                    $result[] = "2";
                    break;
                case "8":
                    $result[] = "1";
                    break;
                case "9":
                    $result[] = "0";
                    break;
                default:
                    break;
            }
        }
        return implode("", $result);
    }
}
