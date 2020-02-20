<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk;

use \Miinto\AuthService\Sdk\Dto;
use \Miinto\AuthService\Sdk\Http\Client\ClientInterface as HttpClientInterface;
use \Miinto\AuthService\Sdk\Dto\Mapper\FromArray\Channel as ChannelMapper;

class Client
{
    /** @var Dto\Factory */
    protected $dtoFactory;

    /** @var HttpClientInterface */
    protected $httpClient;

    /**
     * AuthService constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param Dto\Factory $dtoFactory
     */
    public function __construct(
        HttpClientInterface $httpClient,
        Dto\Factory $dtoFactory
    ) {
        $this->httpClient = $httpClient;
        $this->dtoFactory = $dtoFactory;
    }

    /**
     * Check if api app works fine
     *
     * @GET /status
     *
     * @return array
     */
    public function status(): array
    {
        $path = '/status';

        return $this->httpClient->get($path);
    }

    /**
     * @POST /channels
     *
     * @param string $identifier
     * @param string $secret
     *
     * @return Dto\Channel
     */
    public function createChannel(string $identifier, string $secret): Dto\Channel
    {
        $path = '/channels';
        $postData = [
            'identifier' => $identifier,
            'secret' => $secret
        ];

        $responseData = $this->httpClient->post($path, null, $postData);

        return ChannelMapper::map($responseData, $this->dtoFactory);
    }

    /**
     * @param string $channelId
     * @param Dto\Credential $credentail
     *
     * @return array
     */
    public function getChannel(string $channelId, Dto\Credential $credentail): Dto\Channel
    {
        $path = '/channels/' . $channelId;
        $responseData = $this->httpClient->get($path, $credentail);

        return ChannelMapper::map($responseData, $this->dtoFactory);
    }
}