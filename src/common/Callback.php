<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 30.12.2021
 * Time: 15:26
 */

namespace sbank\common;


use Base64Url\Base64Url;
use Jose\Component\Core\Util\JsonConverter;

class Callback extends BaseObject
{
    public function getSignature($apiSecret){
        $head = [
            'alg' => 'HS256'
        ];
        $payload = $this->getAsArray();
        return Base64Url::encode(hash_hmac('sha256',
            Base64Url::encode(JsonConverter::encode($head)).".".Base64Url::encode(JsonConverter::encode($payload)),
            $apiSecret,
            true
        ));
    }

    public function compareSignature($signature, $apiKey){
        return hash_equals($signature, $this->getSignature($apiKey));
    }
}
