<?php
namespace sbank;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Prophecy\Exception\Doubler\ClassNotFoundException;
use sbank\common\Request;
use sbank\requests\BalanceRequest;
use sbank\requests\Host2HostRequest;
use sbank\requests\InitRequest;
use sbank\requests\SBPRequest;
use sbank\requests\StatusRequest;
use sbank\requests\ThreeDSRequest;
use sbank\requests\WebhookSignDebug;
use sbank\requests\WithdrawalRequest;
use sbank\requests\WithdrawalStatusRequest;
use sbank\callbacks\FinishCallback;
use sbank\callbacks\NotificationCallback;

/**
 * Class SbankApiTest
 * @package sbank
 *
 * Реализованные методы апи.
 * Реализация должна быть в классе с наймспейсом sbank/request
 * в дирректории ./requests и наследоваться от sbank/common/Request
 * Метод должен быть промаплен в METHOD_MAP
 *
 * @method init(array $data)
 * @method SBP(array $data)
 * @method host2host(array $data)
 * @method threeDS(array $data)
 * @method status(array $data)
 * @method balance(array $data)
 * @method withdrawal(array $data)
 * @method withdrawalStatus(array $data)
 * @method webhookSignDebug(array $data)
 */
class SbankApi
{
    private $api_secret;

    /**
     * @var Client $client
     */
    private $client;

    /**
     * @var Request $request
     */
    public $request = null;
    public $responce = null;

    private const METHOD_MAP = [
        'init' => InitRequest::class,
        'SBP' => SBPRequest::class,
        'host2host' => Host2HostRequest::class,
        'threeDS' => ThreeDSRequest::class,
        'status' => StatusRequest::class,
        'balance' => BalanceRequest::class,
        'withdrawal' => WithdrawalRequest::class,
        'withdrawalStatus' => WithdrawalStatusRequest::class,
        'webhookSignDebug' => WebhookSignDebug::class
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
     * @return Response
     * @throws \Exception
     */
    public function __call($name, $arguments): string
    {
        $className = self::METHOD_MAP[$name];
        if (!class_exists($className, true)){
            throw new \Exception("$className not found");
        }
        $this->request = new $className($this->api_secret, ...$arguments);
        $options = $this->prepareOptions($this->request);
        try {
            /**
             * @var Response $response
             */
            $response = $this->client->request(
                $this->request->getMethod(),
                $this->request->getAddress(),
                $options
            )->getBody();
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }
        $this->responce = $response->getContents();
        return $this->responce;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function prepareOptions(Request $request): array
    {
        $bodyArr = $request->getAsArray();
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
    public function verifyNotificationSignature(array $data): bool
    {
        if (empty($data['signature'])){
            return false;
        }
        $inSignature = $data['signature'];
        unset($data['signature']);
        return (new NotificationCallback($data))->compareSignature($inSignature, $this->api_secret);
    }
}
