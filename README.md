# Auth Service SDK

[Changelog](./CHANGELOG.md)

## 1. Installation ##

`composer install miinto/auth_service-sdk` 

## 2. Usage ##

To create the SDK you should use `\Miinto\AuthService\Sdk\Factory` like this:

```php
  use \Http\Discovery\HttpClientDiscovery;
  use \Http\Discovery\Psr17FactoryDiscovery;
  use \Miinto\ApiClient\Request\Factory as RequestFactory;
  use \Miinto\ApiClient\Factory as MiintoClientFactory;
  use \Miinto\AuthService\Sdk\Factory as ClientFactory;
        
  $urlToApi = 'https://api-auth-uat.miinto.net';
  $streamFactory =  Psr17FactoryDiscovery::findStreamFactory();
  $requestFactory = new RequestFactory(Psr17FactoryDiscovery::findRequestFactory(), $streamFactory);
  $httpClient =  HttpClientDiscovery::find();
  
  $channel = "****************";
  $token   = "****************";
  $miintoClient = MiintoClientFactory::createClient($channel, $token, $httpClient);
  $authClient = ClientFactory::createClient($urlToApi, $miintoClient, $requestFactory);
   
```
**CAUTION** MiintoClientFactory requires the credential data: `channelID` and `token`. If you want to use only methods 
without HMAC signature (_status(), createChannel()_), you can setup empty strings instead of `channelID` and `token`
parameters.
 
## 3. Usecases ##

### 3.1 Check status
```php   
    $status = $authClient->status();       
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
    $channel = $authClient->createChannel('user_miinto@miinto.com','*******');
```

**CAUTION**: `\Miinto\AuthService\Sdk\Http\Response\Exception` will be thrown when credentials are incorrect.

### 3.3 Get a channel data ###
```php
    /** @var \Miinto\AuthService\Sdk\Dto\Channel $channel */
    $channel = $authClient->getChannel('M!p!Ch!v1!0000007003-58f5e271d4932-2117689427');  
``` 

**CAUTION**: `\Miinto\AuthService\Sdk\Http\Response\Exception` will be thrown when a channel doesn't exists or credentials are incorrect.