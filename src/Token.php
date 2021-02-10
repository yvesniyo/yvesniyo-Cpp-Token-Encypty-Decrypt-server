<?php

namespace Encrypt;

use JsonSerializable;
use Stringable;

class Token implements JsonSerializable, Stringable
{

    protected $id;

    protected $key;

    protected $amount;

    protected $deviceId;

    protected $order;



    /**
     * 
     * @param string $id 
     * The id in your app must be length of 4 and only digits
     * @param string $amount
     * The amount of money this amount must be of length 6 and only digits are allowed
     * @param string $deviceId
     * Device Id must be of length 7 and only digits are allowed
     */

    public function __construct(string $id, string $amount, string $deviceId)
    {
        $random_order = mt_rand(1, 16);
        $order = ($random_order < 10) ? "0" . $random_order : $random_order . "";

        $random_key = mt_rand(1, 9);
        $key = $random_key . "";

        if (strlen($id) != TokenOrganizer::LENGTH_ID) {
            throw new \Exception("Id should be of length " . TokenOrganizer::LENGTH_ID, 1);
        }
        $this->validate($id, "Id");
        $this->id = $id;
        if (strlen($key) != TokenOrganizer::LENGTH_KEY) {
            throw new \Exception("Key should be of length " . TokenOrganizer::LENGTH_KEY, 1);
        }
        $this->validate($key, "Key");
        $this->key = $key;
        if (strlen($amount) != TokenOrganizer::LENGTH_AMOUNT) {
            throw new \Exception("Amount should be of length " . TokenOrganizer::LENGTH_AMOUNT, 1);
        }
        $this->validate($amount, "Amount");
        $this->amount = $amount;
        if (strlen($deviceId) != TokenOrganizer::LENGTH_DEVICE_ID) {
            throw new \Exception("DeviceId should be of length " . TokenOrganizer::LENGTH_DEVICE_ID, 1);
        }
        $this->validate($deviceId, "DeviceId");
        $this->deviceId = $deviceId;
        if (strlen($order) != TokenOrganizer::LENGTH_ORDER) {
            throw new \Exception("Order should be of length " . TokenOrganizer::LENGTH_ORDER, 1);
        }
        $this->validate($order, "Order");
        $this->order = $order;
    }


    private function validate(String $value, String $field)
    {
        $array = str_split($value);
        foreach ($array as $data) {
            if (!is_numeric($data)) {
                throw new \Exception("No characters allowed on " . $field . " Field", 1);
            }
        }
    }


    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */
    public function setAmount($amount)
    {
        if (strlen($amount) != TokenOrganizer::LENGTH_AMOUNT) {
            throw new \Exception("Amount should be of length " . TokenOrganizer::LENGTH_AMOUNT, 1);
        }
        $this->validate($amount, "Amount");

        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        if (strlen($id) != TokenOrganizer::LENGTH_ID) {
            throw new \Exception("Id should be of length " . TokenOrganizer::LENGTH_ID, 1);
        }
        $this->validate($id, "Id");
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the value of key
     *
     * @return  self
     */
    public function setKey($key)
    {
        if (strlen($key) != TokenOrganizer::LENGTH_KEY) {
            throw new \Exception("Key should be of length " . TokenOrganizer::LENGTH_KEY, 1);
        }
        $this->validate($key, "Key");
        $this->key = $key;

        return $this;
    }

    /**
     * Get the value of deviceId
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set the value of deviceId
     *
     * @return  self
     */
    public function setDeviceId($deviceId)
    {
        if (strlen($deviceId) != TokenOrganizer::LENGTH_DEVICE_ID) {
            throw new \Exception("DeviceId should be of length " . TokenOrganizer::LENGTH_DEVICE_ID, 1);
        }
        $this->validate($deviceId, "DeviceId");
        $this->deviceId = $deviceId;

        return $this;
    }


    /**
     * Get the value of order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */
    public function setOrder($order)
    {
        if (strlen($order) != TokenOrganizer::LENGTH_ORDER) {
            throw new \Exception("Order should be of length " . TokenOrganizer::LENGTH_ORDER, 1);
        }
        $this->validate($order, "Order");
        $this->order = $order;

        return $this;
    }


    /**
     * Get the value of output
     */
    public function getString(): String
    {
        return Encrypt::encrypt($this);
    }


    public function jsonSerialize()
    {
        return [
            "amount" => intval($this->amount),
            "device_id" => intval($this->deviceId),
            "id" => intval($this->id),
        ];
    }


    public function __toString()
    {
        return $this->getString();
    }

    public function formatByFourDigits(): String
    {
        $token = str_split($this . "");
        for ($j = -1; $j < 20; $j += 5) {
            $value = [" "];
            if ($j != 0)
                array_splice($token, $j, 0, $value);
        }
        unset($token[count($token) - 2]);
        return implode($token);
    }


    public static function parse(string $token): Token
    {
        return TokenOrganizer::decode(Encrypt::decrypt($token));
    }
}
