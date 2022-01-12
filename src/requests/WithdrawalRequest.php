<?php
namespace sbank\requests;


use sbank\common\Request;

class WithdrawalRequest extends Request
{
    public $amount;
    public $currency;
    public $merchant_id;
    public $notification_url;
    public $order;
    public $pan;

    public function getMethod()
    {
        return 'POST';
    }

    public function getAddress()
    {
        return '/withdrawal_request';
    }
}
