PHP Ninja Blocks Helper Library
===============================

PHP library for interacting with the Ninja Blocks platform.

For the time being only Device has been implemented. If you would like to use other non-implemented API features there is a generic MakeRequest function to use make the calls.


How to use
----------
1. Include/Require nbapi.php into your PHP script
2. Instantiate a Device object with your access token
```php
    $deviceAPI = new DeviceAPI("YOUR ACCESS TOKEN");
```
3. Use the implemented methods
```php
    $deviceAPI->getDevices();
    $deviceAPI->actuate();
    $deviceAPI->subscribe();
    $deviceAPI->unsubscribe();
    $deviceAPI->data();
    $deviceAPI->lastHeartbeat();
```