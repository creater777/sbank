<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 29.12.2021
 * Time: 10:50
 */

namespace sbank\requests;


use sbank\common\Request;

class BalanceRequest extends Request
{
    public $currency;
    public $merchant_id;

    public function getMethod()
    {
        return 'GET';
    }

    public function getAddress()
    {
        return '/balance';
    }
}
