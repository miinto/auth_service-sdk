<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk\Dto\Mapper\FromArray;

use \Miinto\AuthService\Sdk\Dto;

class Channel
{
    /**
     * @param array $httpResponseData
     * @param Dto\Factory $channelFactory
     *
     * @return Dto\Channel
     */
    public static function map(array $httpResponseData, Dto\Factory $channelFactory): Dto\Channel
    {
        return $channelFactory->createChannel(
            $httpResponseData['id'],
            $httpResponseData['token'],
            $httpResponseData['data']['accessorId'],
            $httpResponseData['privileges']
        );
    }
}