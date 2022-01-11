<?php
$key = 'aa21444f3f71';
$existOrder = 'order-'.uniqid();
$drawalOrder = 'order-'.uniqid();
$notificationUrl = 'https://exemple.com';
$finishUrl = 'https://exemple.com';


$initData = [
    'amount' => '10',
    'order' => $existOrder,
    'merchant_id' => '13',
    'product_id' => '15',
    'to_card' => '4111111111111111',
    'description' => 'sale',
    'language' => 'ru',
    'finish_url' => $notificationUrl,
    'notification_url' => $notificationUrl,
    'api_secret' => $key
];

$SBPRequest = $initData;
$host2histRequest = array_merge($initData, [
    'pan' => '4111111111111111',
    'expire_month' => '01',
    'expire_year' => '25',
    'cvc' => '123'
]);

$threeDSRequest = array_merge($initData, [
    'device_channel' => 'BRW',
    'device_browser_ip' => '0.0.0.0',
    'device_browser_accept_header' => 'text/html',
    'device_browser_java_enabled' => 'false',
    'device_browser_language' => 'RU',
    'device_browser_color_depth' => '32',
    'device_browser_screen_height' => '800',
    'device_browser_screen_width' => '480',
    'device_browser_tz' => '180',
    'device_browser_user_agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0',
    'challenge_window_size' => '02'
]);

$statusRequest = [
    'merchant_id' => '13',
    'order' => $existOrder,
    'product_id' => '15'
];

$balanceRequest = [
    'merchant_id' => '13',
    'currency' => 'RUB',
    'api_secret' => $key
];

$drawalRequest = [
    'amount' => '10',
    'currency' => 'RUB',
    'order' => $drawalOrder,
    'merchant_id' => '13',
    'notification_url' => $notificationUrl,
    'pan' => '4242424242424242',
    'api_secret' => $key
];

$drawalStatusRequest = [
    'merchant_id' => '13',
    'api_secret' => $key
];

return [
    'key' => $key,
    'baseUri' => 'https://sbank.gogo.vc',
//    'baseUri' => 'https://payhub.money',
    'finishUrl' => $notificationUrl,
    'notificationUrl' => $notificationUrl,

    'SBPRequest' => $SBPRequest,
    'host2histRequest' => $host2histRequest,
    'threeDSRequest' => $threeDSRequest,
    'statusRequest' => $statusRequest,
    'balanceRequest' => $balanceRequest,
    'drawalRequest' => $drawalRequest,
    'drawalStatusRequest' => $drawalStatusRequest
];
