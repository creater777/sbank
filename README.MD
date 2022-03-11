<h1>Sbank SDK</h1>
Обертка для получения доступа к api https://payhub.money

<h2>Установка</h2>

```bash
composer install sbank/sdk
```

<h3>Тестирование</h3>

```bash
runtests <API_KEY> <BASE_URL>
```
<h3>Пример использования</h3>

<h4>Инициализация</h4>

```php
include "vendor/autoload.php";

use sbank\SbankApi;

$key = '1234567abcdef';
$api = new SbankApi($key, 'https://sbank.host');
```

<h4>Оплата через систему быстрых платежей (СБП):</h4>

```php
$data = [
    'amount' => '10',
    'order' => 'order-00003',
    'merchant_id' => '13',
    'product_id' => '15',
    'to_card' => '4111111111111111',
    'description' => 'sale',
    'language' => 'ru',
    'finish_url' => 'https://exemple1.com',
    'notification_url' => 'https://exemple1.com'
];

$result = json_decode($api->SBP($data));
```

<h4>Ответ</h4>

```json
{
  "status":"redirect",
  "url":"https://exemple.com?amount=10.0000&invoice_id=684&product_id=15&merchant_id=13&order=order-00003&currency=RUB&signature=mCNJTlfwXadOl07tsoNtjoG8CXfCK0UsS3P36nJnrLg"
}
```

Документация по всем методам апи доствупна https://payhub.money/docs/
