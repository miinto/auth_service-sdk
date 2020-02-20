<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk;

use \Miinto\ApiClient\Client as MiintoClient;
use \Miinto\ApiClient\Request\Factory as MiintoRequestFactory;
use \Miinto\AuthService\Sdk\Dto\Factory as DtoFactory;

class Factory
{
    public static function createClient(string $url, MiintoClient $httpClient, MiintoRequestFactory $requestFactory): Client
    {
        return new Client($url, $httpClient, $requestFactory, new DtoFactory());
    }
}