<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk\Dto;

class Channel extends Credential
{
    /** @var array */
    protected $privileges = [];

    /** @var int */
    protected $accessorId;

    /**
     * Channel constructor.
     *
     * @param string $channelId
     * @param string $token
     * @param int $accessorId
     * @param array $privileges
     *
     */
    public function __construct(string $channelId, string $token, int $accessorId, $privileges = [])
    {
        $this->channelId = $channelId;
        $this->token = $token;
        $this->accessorId = $accessorId;
        $this->privileges = $privileges;
    }

    /**
     * @return array
     */
    public function getPrivileges(): array
    {
        return $this->privileges;
    }

    /**
     * @return int
     */
    public function getAccessorId(): int
    {
        return $this->accessorId;
    }


}