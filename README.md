PHP Ninja Blocks Helper Library
===============================

PHP library for interacting with the Ninja Blocks platform.

For the time being only Device has been implemented. If you would like to use other non-implemented API features there is a generic MakeRequest function to use make the calls.


## How to use

1. Include/Require nbapi.php into your PHP script
2. Instantiate a Device object with your access token

```
$deviceAPI = new Device("YOUR ACCESS TOKEN");
```

3. Use the implemented methods

```
$deviceAPI->getDevices();
$deviceAPI->actuate($guid, $da);
$deviceAPI->subscribe($guid, $url);
$deviceAPI->unsubscribe($guid);
$deviceAPI->data($guid, $from, $to);
$deviceAPI->image($guid);
$deviceAPI->lastHeartbeat($guid);
```
