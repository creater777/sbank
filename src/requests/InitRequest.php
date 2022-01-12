<?php
/**
 * Created by PhpStorm.
 * User: Professional
 * Date: 28.12.2021
 * Time: 17:15
 */

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

    protected function getPayload($data)
    {
        return [
            "PATH" => $this->getAddress(),
            $this->getMethod() => $data
        ];
    }
}
