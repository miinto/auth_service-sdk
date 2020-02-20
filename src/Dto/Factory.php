<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk\Dto;

class Factory
{
    /**
     * @param string $channelId
     * @param string $token
     *
     * @return Credential
     */
    public static function createCredential(string $channelId, string $token): Credential
    {
        return new Credential($channelId, $token);
    }

    /**
     * @param string $channelId
     * @param string $token
     * @param int $accessorId
     * @param array $privileges
     *
     * @return Channel
     */
    public static function createChannel(string $channelId, string $token, int $accessorId, $privileges = []): Channel
    {
        return new Channel($channelId, $token, $accessorId, $privileges);
    }
}