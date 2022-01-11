<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 29.12.2021
 * Time: 4:10
 */

namespace sbank\callbacks;


use sbank\common\Callback;

class FinishCallback extends Callback
{
    public $invoice_id;
    public $amount;
    public $order;
    public $merchant_id;
    public $product_id;
    public $currency;
    public $signature;
}
