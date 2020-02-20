<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Request;

use \Psr\Http\Message\RequestInterface;
use \Miinto\AuthService\Sdk\Dto\Channel;

interface SignerInterface
{
    /**
     * @param RequestInterface $request
     * @param Channel $credential
     *
     * @return RequestInterface
     */
    public function sign(RequestInterface $request, Channel $credential): RequestInterface;
}