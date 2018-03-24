<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class VoterHasher
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * VoterHasher constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return string
     */
    public function hash(): string
    {
        return hash('sha512', $this->requestStack->getCurrentRequest()->getClientIp());
    }
}
