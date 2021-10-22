<?php

namespace Pramod\PhpApiConsumer\Parser;

class WithParser
{
    protected $requestedHeadersPayload;
    public $headers=[
        
    ];
    public $method;
    public $version;
    public $payload;
    public function __construct($requestedPayload)
    {
        $this->requestedHeadersPayload=$requestedPayload;
        $this->parsePayload();
        return $this;
    }

    protected function parsePayload()
    {
        foreach ($this->requestedHeadersPayload as $key => $value) {
            $this->{$key}=$value;
        }
    }

    public function __get($name)
    {
        return $this->requestedHeadersPayload->{$name};
    }
}
