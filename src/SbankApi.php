<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 28.12.2021
 * Time: 12:24
 */

namespace sbank;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Jose\Component\Core\Util\JsonConverter;
use sbank\common\Request;
use sbank\requests\BalanceRequest;
use sbank\requests\Host2HostRequest;
use sbank\requests\SBPRequest;
use sbank\requests\StatusRequest;
use sbank\requests\ThreeDSRequest;
use sbank\requests\WithdrawalRequest;
use sbank\requests\WithdrawalStatusRequest;
use sbank\callbacks\FinishCallback;
use sbank\callbacks\NotificationCallback;

/**
 * Class SbankApiTest
 * @package sbank
 *
 * @method SBP(array $data)
 * @method host2host(array $data)
 * @method threeDS(array $data)
 * @method status(array $data)
 * @method balance(array $data)
 * @method withdrawal(array $data)
 * @method withdrawalStatus(array $data)
 */
class SbankApi
{
    private $api_secret;

    /**
     * @var Client $client
     */
    private $client;

    private const METHOD_MAP = [
        'SBP' => SBPRequest::class,
        'host2host' => Host2HostRequest::class,
        'threeDS' => ThreeDSRequest::class,
        'status' => StatusRequest::class,
        'balance' => BalanceRequest::class,
        'withdrawal' => WithdrawalRequest::class,
        'withdrawalStatus' => WithdrawalStatusRequest::class
    ];

    /**
     * SbankApiTest constructor.
     * @param string $api_secret
     * @param string $base_uri
     * @param array $options
     */
    public function __construct(string $api_secret, string $base_uri, array $options = [])
    {
        $this->api_secret = $api_secret;
        $this->client = new Client(array_merge([
            'base_uri' => $base_uri,
        ], $options));
    }

    /**
     * @param $name
     * @param $arguments
     * @return |null
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $className = self::METHOD_MAP[$name];
        if (!class_exists($className, true)){
            return null;
        }
        /**
         * @var Request $request
         */
        $request = new $className(...$arguments);
        $address = $request->getAddress();
        $options = $this->prepareOptions($request);
        try {
            $response = $this->client->request($request->getMethod(), $address, $options)->getBody();
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }
        $result = $response->getContents();
        return $result;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function prepareOptions(Request $request){
        $bodyArr = $request->getAsArray($this->api_secret);
        $dataKey = $request->getMethod() === 'GET' ? RequestOptions::QUERY : RequestOptions::FORM_PARAMS;
        return [
            $dataKey => $bodyArr,
            'allow_redirects' => false
        ];
    }

    /**
     * @param array $data
     * @return bool
     */
    public function verifyFinishSignature(array $data): bool
    {
        if (empty($data['signature'])){
            return false;
        }
        $inSignature = $data['signature'];
        unset($data['signature']);
        return (new FinishCallback($data))->compareSignature($inSignature, $this->api_secret);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function verifyNotificationSignature(array $data): bool{
        if (empty($data['signature'])){
            return false;
        }
        $inSignature = $data['signature'];
        unset($data['signature']);
        return (new NotificationCallback($data))->compareSignature($inSignature, $this->api_secret);
    }
}
