#Sbank SDK
Обертка для получения доступа к api https://payhub.money

##Установка
```bash
composer install sbank/sdk
```

###Тестирование
```bash
runtests <API_KEY> <BASE_URL>
```
### Пример использования

####Инициализация

```php
include "vendor/autoload.php";

use sbank\SbankApi;

$key = '1234567abcdef';
$api = new SbankApi($key, 'https://sbank.host');
```

####Оплата через систему быстрых платежей (СБП):
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

#####Ответ
```json
{
  "status":"redirect",
  "url":"https://exemple.com?amount=10.0000&invoice_id=684&product_id=15&merchant_id=13&order=order-00003&currency=RUB&signature=mCNJTlfwXadOl07tsoNtjoG8CXfCK0UsS3P36nJnrLg"
}
```

Документация по всем методам апи доствупна https://payhub.money/docs/
