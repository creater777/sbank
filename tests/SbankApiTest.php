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
        $SBPRequest = $this->config['SBPRequest'];
        $result = json_decode($this->api->SBP($SBPRequest));
        $this->assertTrue(json_last_error() == JSON_ERROR_NONE, "SBPRequest result mast be JSON");
        $this->assertTrue($result->status === "success", "Error response");
    }

    public function testHost2histRequestAction()
    {
        $host2histRequest = $this->config['host2histRequest'];
        $result = json_decode($this->api->host2host($host2histRequest));
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "host2histRequest result mast be JSON");
        $this->assertTrue($result->status === "success", "Error response");
    }

    public function testThreeDSAction()
    {
        $threeDSRequest = $this->config['threeDSRequest'];
        $result = json_decode($this->api->threeDS($threeDSRequest));
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "threeDSRequest result mast be JSON");
        $this->assertTrue($result->status === "success", "Error response");
    }

    public function testBalanceAction()
    {
        $balanceRequest = $this->config['balanceRequest'];
        $result = json_decode($this->api->balance($balanceRequest));
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "balanceRequest result mast be JSON");
        $this->assertTrue($result->status === "success", "Error response: ".json_encode($result->field_errors));
        $this->assertTrue(!empty($result->balance), "Balance field mast be exist in result");
    }

    public function testStatusAction()
    {
        $statusRequest = $this->config['statusRequest'];
        $result = json_decode($this->api->status($statusRequest));
        $this->assertTrue(json_last_error() == JSON_ERROR_NONE, "statusAction result mast be JSON");
        $this->assertTrue($result->status === "success", "Error response: ".json_encode($result->field_errors));
    }

    public function testWebhookSignDebugAction()
    {
        $statusRequest = $this->config['statusRequest'];
        $result = json_decode($this->api->status($statusRequest));
        $this->assertTrue(json_last_error() == JSON_ERROR_NONE, "statusAction result mast be JSON");
        $this->assertTrue($result->status === "success", "Error response: ".json_encode($result->field_errors));
    }

    public function testDrawalAction()
    {
        $drawalRequest = $this->config['drawalRequest'];
        $result = json_decode($this->api->withdrawal($drawalRequest));
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "drawalRequest result mast be JSON");
        $this->assertTrue($result->status === "success", "Error response: ".json_encode($result->field_errors));

        $drawalStatusRequest = $this->config['drawalStatusRequest'];
        $drawalStatusRequest['id'] = (string) $result->withdrawal_request->id;
        $result = json_decode($this->api->withdrawalStatus($drawalStatusRequest));
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE, "drawalStatusRequest result mast be JSON");
        $this->assertTrue($result->status === "success", "Error response: ".json_encode($result->field_errors));
    }
}
