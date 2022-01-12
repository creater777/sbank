<?php
namespace sbank\common;


class JsonUtil
{
    /**
     * @param mixed $payload
     */
    public static function encode($payload): string
    {
       return json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return mixed
     */
    public static function decode(string $payload)
    {
       return json_decode($payload, true, 512, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
