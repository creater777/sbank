<?php
namespace sbank\requests;

use sbank\common\Request;

class WithdrawalStatusRequest extends Request
{
    public $id;
    public $merchant_id;

    public function getMethod()
    {
        return 'GET';
    }

    public function getAddress()
    {
        return '/withdrawal_request';
    }
}
