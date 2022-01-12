<?php
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
