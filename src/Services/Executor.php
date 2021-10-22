<?php

namespace Pramod\PhpApiConsumer\Services;

use Pramod\PhpApiConsumer\Service;
use Pramod\PhpApiConsumer\Traits\ConsumerHttpClient;

class Executor
{
    use ConsumerHttpClient;

    public $baseUri;
    public $requestUri;
    public $formParams;
    public $method;
    public $headers;
    public $timeout;
    public $sslVerify;
    public $graphQl;
    public $attachAttributes;
    protected $receivedContents;

    protected $apiConsumer;

    public function __construct(Service $apiConsumer)
    {
        $this->apiConsumer = $apiConsumer;
        $this->finalRenderPayload();
        $this->receivedContents=$this->performRequest();
        return $this;
    }

    public function getReceivedContents()
    {
        return $this->receivedContents;
    }
    protected function finalRenderPayload()
    {
        
        $this->baseUri = $this->apiConsumer::$consumerPayload->getBaseUri();
        $this->requestUri = $this->getRequestedUri();
        $this->formParams = $this->apiConsumer->withPayload->payload??null;
        // $this->graphQl=$this->apiConsumer->withPayload->graphQl??null;
        $this->attachAttributes = $this->apiConsumer->attachAttributes??null;
        $this->graphQl=null;
        $this->method = $this->getMethod();
        $this->headers = $this->getAuthorizationHeaders();
        $this->timeout=$this->apiConsumer->timeout();
        $this->sslVerify=$this->apiConsumer->ssl();
        //replace Headers global in case of graphql
        $this->replaceHeadersForGraphQl();
    }

    protected function getRequestedUri()
    {
        return $this->apiConsumer->viaPayload->getRequestedUri();
    }
    protected function getMethod()
    {
        if (isset($this->graphQl) && $this->graphQl!==null) {
            return 'POST';
        }
        return $this->apiConsumer->withPayload->method??'GET';
    }

    protected function getAuthorizationHeaders()
    {
        if (empty($this->apiConsumer->withPayload->headers['Authorization'])
            &&
            !empty($this->apiConsumer::$consumerPayload->getSecret())) {
            $this->apiConsumer->withPayload->headers['Authorization']=$this->apiConsumer::$consumerPayload->getSecret();
        }
        return $this->apiConsumer->withPayload->headers??[];
    }

    protected function replaceHeadersForGraphQl()
    {
        if (isset($this->graphQl) && $this->graphQl!==null) {
            $this->headers['Accept']='application/json';
            $this->headers['Content-Type']='application/json';
        }
    }
    

    protected function getSslVerify()
    {
        return $this->apiConsumer::$consumerPayload->ssl_verification??30;
    }
}
