<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk;

use \Miinto\AuthService\Sdk\Http\Client\ClientInterface as HttpClientInterface;
use \Miinto\AuthService\Sdk\Dto\Factory as DtoFactory;

class Factory
{
    /**
     * @param HttpClientInterface $client
     *
     * @return Client
     */
    public static function createClient(HttpClientInterface $client): Client
    {
        return new Client($client, new DtoFactory());
    }
}