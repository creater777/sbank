<?php
use PHPUnit\Framework\TestCase;
use sbank\SbankApi;

class SbankApiTest extends TestCase
{
    /**
     * @var SbankApi
     */
    private $api;
    private $config;

    protected function setUp()
    {
        $this->config = require(__DIR__."/_fixtures/config.php");
        $this->api = new SbankApi($this->config['key'], $this->config['baseUri'], ['verify' => false]);
    }

    public function testSBPAction()
    {
        $request = $this->config['SBPRequest'];
        $response = $this->api->SBP($request);
        $result = json_decode($response);
        $this->assertTrue(json_last_error() == JSON_ERROR_NONE, "Response mast be JSON. ".$response);
        $this->assertTrue($result->status === "redirect", "Error response: ". json_encode($result));
    }

    public function testHost2hostRequestAction()
    {
        $request = $this->config['host2hostRequest'];
        $response = $this->api->host2host($request);
        $result = json_decode($response);
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "Response mast be JSON. ".$response);
        $this->assertTrue($result->status === "redirect", "Error response: ". json_encode($result));
    }

    public function testThreeDSAction()
    {
        $request = $this->config['threeDSRequest'];
        $response = $this->api->threeDS($request);
        $result = json_decode($response);
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "Response mast be JSON. ".$response);
        $this->assertTrue($result->status === "redirect", "Error response: ". json_encode($result));
    }

    public function testBalanceAction()
    {
        $request = $this->config['balanceRequest'];
        $response = $this->api->balance($request);
        $result = json_decode($response);
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "Response mast be JSON. ".$response);
        $this->assertTrue($result->status === "success", "Error response: ".json_encode($result->field_errors));
        $this->assertTrue(!empty($result->balance), "Balance field mast be exist in result");
    }

    public function testErrorStatusAction()
    {
        $request = $this->config['statusRequest'];
        $response = $this->api->status($request);
        $result = json_decode($response);
        $this->assertTrue(json_last_error() == JSON_ERROR_NONE, "Response mast be JSON. ".$response);
        $this->assertTrue(isset($result->field_errors), "Error fields must be not exist");
        $error = $result->field_errors;
        $this->assertTrue($error->order[0] === "Order does not exist", "Error response: ".json_encode($error->order));
    }

    public function testDrawalAction()
    {
        $request = $this->config['drawalRequest'];
        $response = $this->api->withdrawal($request);
        $result = json_decode($response);
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "Response mast be JSON. ".$response);
        $this->assertTrue($result->status === "success", "Error response: ".json_encode($result->field_errors));

        $drawalStatusRequest = $this->config['drawalStatusRequest'];
        $drawalStatusRequest['id'] = (string) $result->withdrawal_request->id;
        $response = $this->api->withdrawalStatus($drawalStatusRequest);
        $result = json_decode($response);
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "Response mast be JSON. ".$response);
        $this->assertTrue($result->status === "success", "Error response: ".json_encode($result->field_errors));
    }

    public function testErrorWebhookSignDebugAction()
    {
        $request = $this->config['webhookSignDebug'];
        $response = $this->api->webhookSignDebug($request);
        $result = json_decode($response);
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "Response mast be JSON. ".$response);
        $this->assertTrue($result->status === "error", "Error status in not get");
    }
}
