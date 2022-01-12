<?php
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
            Base64Url::encode(JsonUtil::encode($head)).".".Base64Url::encode(JsonUtil::encode($payload)),
            $apiSecret,
            true
        ));
    }

    public function compareSignature($signature, $apiKey){
        return hash_equals($signature, $this->getSignature($apiKey));
    }
}
