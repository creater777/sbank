<?php
namespace sbank\requests;


use sbank\common\Request;

/**
 * Class BalanceRequest
 *
 * Получение баланса
 *
 * @package sbank\requests
 */
class BalanceRequest extends Request
{
    /**
     * @var string $currency валюта счета (RUB по умолчанию)
     */
    public $currency;

    /**
     * @var string $merchant_id ваш id в системе
     */
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
