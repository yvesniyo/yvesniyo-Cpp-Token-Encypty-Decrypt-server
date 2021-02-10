<?php

namespace Encrypt;

class TokenOrganizer
{

    public const LENGTH_DEVICE_ID = 7;
    public const LENGTH_AMOUNT    = 6;
    public const LENGTH_ID        = 4;
    public const LENGTH_ORDER     = 2;
    public const LENGTH_KEY       = 1;



    public static function decode(String $token): Token
    {
        $order     = substr($token, 0, self::LENGTH_ORDER);
        $id        = "";
        $key       = "";
        $amount    = "";
        $device_id = "";

        $steps     = self::stepOrders()[$order];
        $next      = 0;
        foreach ($steps as $step) {
            switch ($step) {
                case 'id':
                    $id = substr($token, $next, self::LENGTH_ID);
                    $next += self::LENGTH_ID;
                    break;
                case 'device_id':
                    $device_id = substr($token, $next, self::LENGTH_DEVICE_ID);
                    $next += self::LENGTH_DEVICE_ID;
                    break;
                case 'amount':
                    $amount = substr($token, $next, self::LENGTH_AMOUNT);
                    $next += self::LENGTH_AMOUNT;
                    break;
                case 'order':
                    $order = substr($token, $next, self::LENGTH_ORDER);
                    $next += self::LENGTH_ORDER;
                    break;
                case 'key':
                    $key = substr($token, $next, self::LENGTH_KEY);
                    $next += self::LENGTH_KEY;
                    break;
                default:
                    break;
            }
        }
        $token = new Token($id, $amount, $device_id);
        $token->setOrder($order);
        $token->setKey($key);
        return $token;
    }

    public static function encode(Token $token): String
    {
        return implode("", self::getArray($token));
    }

    private static function getArray(Token $token): array
    {
        $order = $token->getOrder();
        $steps = self::stepOrders()[$order];
        $result = [];
        foreach ($steps as $step) {
            $data = "";
            switch ($step) {
                case 'id':
                    $data = $token->getId();
                    break;
                case 'device_id':
                    $data = $token->getDeviceId();
                    break;
                case 'order':
                    $data = $token->getOrder();
                    break;
                case 'amount':
                    $data = $token->getAmount();
                    break;
                case 'key':
                    $data = $token->getKey();
                    break;
                default:
                    break;
            }
            $result[] = $data;
        }

        return $result;
    }


    private static function stepOrders()
    {
        return [
            "01" => [
                "order",
                "device_id",
                "amount",
                "key",
                "id"
            ],
            "02" => [
                "order",
                "amount",
                "device_id",
                "key",
                "id"
            ],
            "03" => [
                "order",
                "amount",
                "device_id",
                "id",
                "key"
            ],
            "04" => [
                "order",
                "amount",
                "id",
                "device_id",
                "key"
            ],
            "05" => [
                "order",
                "amount",
                "id",
                "key",
                "device_id"
            ],
            "06" => [
                "order",
                "id",
                "amount",
                "key",
                "device_id"
            ],
            "07" => [
                "order",
                "id",
                "key",
                "amount",
                "device_id"
            ],
            "08" => [
                "order",
                "id",
                "device_id",
                "key",
                "amount"
            ],
            "09" => [
                "order",
                "id",
                "device_id",
                "amount",
                "key"
            ],
            "10" => [
                "order",
                "device_id",
                "amount",
                "id",
                "key"
            ],
            "11" => [
                "order",
                "device_id",
                "id",
                "amount",
                "key"
            ],
            "12" => [
                "order",
                "device_id",
                "key",
                "id",
                "amount"
            ],
            "13" => [
                "order",
                "key",
                "id",
                "amount",
                "device_id"
            ],
            "14" => [
                "order",
                "key",
                "id",
                "device_id",
                "amount"
            ],
            "15" => [
                "order",
                "key",
                "amount",
                "id",
                "device_id"
            ],
            "16" => [
                "order",
                "key",
                "device_id",
                "amount",
                "id"
            ],
        ];
    }
}
