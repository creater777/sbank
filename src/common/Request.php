<?php
namespace sbank\common;


use Base64Url\Base64Url;
use Jose\Component\Core\Util\JsonConverter;

abstract class Request extends BaseObject
{
    protected $api_secret = '';
    protected $signature;

    abstract public function getMethod();
    abstract public function getAddress();
    abstract protected function getPayload($data);

    public function __construct($api_secret, array $params)
    {
        parent::__construct($params);
        $this->api_secret = $api_secret;
        $this->signature = $this->getSignature($params);
    }

    private function getSignature($data){
        unset($data['api_secret']);
        unset($data['signature']);
        ksort($data);
        $head = [
            'alg' => 'HS256'
        ];
        return Base64Url::encode(hash_hmac('sha256',
            Base64Url::encode(JsonConverter::encode($head)).".".Base64Url::encode(JsonConverter::encode($this->getPayload($data))),
            $this->api_secret,
            true
        ));
    }

    public function getAsArray(): array
    {
        $data = parent::getAsArray();
        unset($data['api_secret']);
        return $data;
    }
}
