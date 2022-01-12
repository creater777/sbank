<?php
namespace sbank\common;


use Base64Url\Base64Url;

/**
 * Class Request
 *
 * Основной класс для запросов к апи
 *
 * @package sbank\common
 */
abstract class Request extends BaseObject
{
    protected $api_secret = '';
    protected $signature;

    abstract public function getMethod();
    abstract public function getAddress();

    public function __construct($api_secret, array $params)
    {
        parent::__construct($params);
        $this->api_secret = $api_secret;
        $this->signature = $this->getSignature($params);
    }

    /**
     * @param array $data
     * @return array
     */
    private function getPayload(array $data): string
    {
        return Base64Url::encode(JsonUtil::encode([
            "PATH" => $this->getAddress(),
            $this->getMethod() => $data
        ]));
    }

    /**
     * @return string
     */
    private function getHead(): string
    {
        return Base64Url::encode(JsonUtil::encode([
            'alg' => 'HS256'
        ]));
    }

    /**
     * Генерация JMS сигнатуры
     * @param $data
     * @return string
     */
    private function getSignature(array $data): string
    {
        unset($data['api_secret']);
        unset($data['signature']);
        ksort($data);
        return Base64Url::encode(hash_hmac('sha256',
            $this->getHead().".".$this->getPayload($data),
            $this->api_secret,
            true
        ));
    }

    /**
     * @return array
     */
    public function getAsArray(): array
    {
        $data = parent::getAsArray();
        unset($data['api_secret']);
        return $data;
    }
}
