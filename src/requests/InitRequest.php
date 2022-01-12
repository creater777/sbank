<?php
namespace sbank\requests;

use sbank\common\Request;

/**
 */
class InitRequest extends Request
{
    const LANGUAGES = ['ru', 'en'];

    public $amount;
    public $description;
    public $finish_url;
    public $language = 'ru';
    public $merchant_id;
    public $notification_url;
    public $order;
    public $product_id;
    public $to_card;

    public function setLanguage($language = 'ru'){
        $language = mb_strtolower($language);
        if (key_exists($language, self::LANGUAGES)){
            $this->language = $language;
        }
    }

    public function getLanguage(){
        return $this->language;
    }

    public function getMethod()
    {
        return 'POST';
    }

    public function getAddress()
    {
        return '/init';
    }
}
