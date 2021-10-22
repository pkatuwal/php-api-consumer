<?php

namespace Pramod\PhpApiConsumer\Parser;

use InvalidArgumentException;

class ConsumerParser
{
    protected $consumerSettings;
    protected $consumerRequestSettings;
    protected $hostUrl;

    public function __construct($consumerSettings, $hostUrl)
    {
        $this->consumerRequestSettings = $consumerSettings;
        $this->hostUrl=$hostUrl;
        $this->consumerSettings['baseUri'] = $this->parseConsumerSettings();
        return $this;
    }
    

    protected function parseConsumerSettings()
    {
        return 'https://'.$this->consumerRequestSettings.$this->hostUrl;
    }

    public function getBaseUri()
    {
        if ($this->consumerSettings['baseUri']) return $this->consumerSettings['baseUri'];
        throw new InvalidArgumentException('Invalid BaseUri');
    }

    public function getAppVersion()
    {
        return $this->consumerSettings['version']??null;
    }

    public function getSecret()
    {
        return $this->consumerSettings['secret']??null;
    }
    public function getTimeOut()
    {
        return $this->consumerSettings['timeout']??30;
    }
    public function getSslVerify()
    {
        return $this->consumerSettings['ssl_verification']??false;
    }
}
