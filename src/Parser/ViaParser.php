<?php

namespace Pramod\PhpApiConsumer\Parser;

class ViaParser
{
    protected $activeUserDefinedMethod;
    protected $requestedUri;
    public function __construct($requestedUri)
    {
        $this->requestedUri=$requestedUri;

        return $this;
    }

    public function getRequestedUri()
    {
        return (isset($this->requestedUri[0]) && ($this->requestedUri[0]==='/'))?
                                    $this->requestedUri
                                    :
                                    '/'.$this->requestedUri;
    }
}
