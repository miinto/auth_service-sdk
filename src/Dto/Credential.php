<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk\Dto;

class Credential
{
    /** @var string */
    protected $channelId;

    /** @var string */
    protected $token;

    /**
     * Channel constructor.
     *
     * @param string $channelId
     * @param string $token*
     */
    public function __construct(string $channelId, string $token)
    {
        $this->channelId = $channelId;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}