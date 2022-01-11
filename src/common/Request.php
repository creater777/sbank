<?php
namespace sbank\common;


use Base64Url\Base64Url;
use Jose\Component\Core\Util\JsonConverter;

abstract class Request extends BaseObject
{
    abstract public function getMethod();
    abstract public function getAddress();

    public function getSignature($apiSecret){
        $data = parent::getAsArray();
        unset($data['api_secret']);
        ksort($data);
        $head = [
            'alg' => 'HS256'
        ];
        $payload = [
            "PATH" => $this->getAddress(),
            $this->getMethod() => $data
        ];
        return Base64Url::encode(hash_hmac('sha256',
            Base64Url::encode(JsonConverter::encode($head)).".".Base64Url::encode(JsonConverter::encode($payload)),
            $apiSecret,
            true
        ));
    }

    public function getAsArray($api_key = null): array
    {
        $data = parent::getAsArray();
        if (!is_null($api_key) && property_exists(get_class($this), 'signature')){
            $data['signature'] = $this->getSignature($api_key);
        }
        return $data;
    }
}
