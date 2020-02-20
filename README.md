# Auth Service SDK

[Changelog](./CHANGELOG.md)

## 1. Installation ##

`composer install miinto/auth_service-sdk` 

## 2. Usage ##

To create the SDK you should use `\Miinto\AuthService\Sdk\Factory` like this:

```php
    $urlToApi = 'https://internal-api-auth-uat.miinto.net';
    $httpClient = \Http\Discovery\HttpClientDiscovery::find();
    $requestFactory = new \Phalcon\Http\Message\ServerRequestFactory();
    $basicClient = \Miinto\AuthService\Sdk\Http\Client\Factory::createBasicClient($urlToApi, $httpClient, $requestFactory);
    
    $sdk = \Miinto\AuthService\Sdk\Factory::createClient($basicClient);
```
**CAUTION** $basicClient implements PSR-18, PSR-17 and PSR-7 standards so $httpClient should be instance of `\Psr\Http\Client\ClientInterface` (PSR-18) $requestFactory should be instance of `\Psr\Http\Message\ServerRequestFactoryInterface` (PSR-17)

## 3. Usecases ##

### 3.1 Check status
```php   
    $status = $sdk->status();       
```
Result:
```php
    array(2) {
      ["name"]=>
      string(12) "auth-service"
      ["status"]=>
      string(2) "OK"
    }
```

### 3.2 Create a new channel ###
```php
    /** @var \Miinto\AuthService\Sdk\Dto\Channel $channel */ 
    $channel = $sdk->createChannel('user_miinto@miinto.com','*******');
```

**CAUTION**: `\Miinto\AuthService\Sdk\Http\Response\Exception` will be thrown when credentials are incorrect.

### 3.3 Get a channel data ###
```php
    $credentail = new \Miinto\AuthService\Sdk\Dto\Credential("M!t!Ch!v1!0000201962-5e3190abe7899-1970472339", "d1f925426*************************");
    
    /** @var \Miinto\AuthService\Sdk\Dto\Channel $channel */
    $channel = $sdk->getChannel('M!p!Ch!v1!0000007003-58f5e271d4932-2117689427', $credentail);  
``` 

**CAUTION**: `\Miinto\AuthService\Sdk\Http\Response\Exception` will be thrown when a channel doesn't exists or credentials are incorrect.