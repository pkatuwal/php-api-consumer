<?php

namespace Pramod\PhpApiConsumer;

use Doctrine\Common\Collections\ArrayCollection;
use Pramod\PhpApiConsumer\Parser\ConsumerParser;
use Pramod\PhpApiConsumer\Parser\ViaParser;
use Pramod\PhpApiConsumer\Parser\WithParser;
use Pramod\PhpApiConsumer\Services\Executor;

class Service
{
    public static $consumerPayload;
    private static $instance = null;

    public $config;

    public function __construct()
    {
        $this->config = parse_ini_file('Config/settings.ini', true);
    }


    public static function consume(string $apiConsumer, string $hostUrl = '.wlink.com.np')
    {
        self::$consumerPayload = new ConsumerParser($apiConsumer, $hostUrl);
        return new static;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Service();
        }

        return self::$instance;
    }
    public function via($requestedUri)
    {

        $this->viaPayload = new ViaParser(
            $requestedUri
        );
        return $this;
    }

    public function with(array $headersPayload)
    {
        $this->withPayload = new WithParser($headersPayload);
        return $this;
    }

    public function ssl($enable = true)
    {
        $this->ssl = $enable;
        return $this;
    }
    public function timeout($time = 30)
    {
        $this->timeout = $time;
        return $this;
    }

    public function attach(string $attributes)
    {
        $this->attachAttributes = $attributes;
        return $this;
    }

    public function retry(int $times = 10)
    {
        $this->retry = $times;
        return $this;
    }

    public function toJson()
    {
        $executor = new Executor($this);

        return json_encode($executor->getReceivedContents());
    }
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    public function __get($name)
    {
        if(in_array($name, $this->config)){
            return $this->config[$name];
        }
    }
}
