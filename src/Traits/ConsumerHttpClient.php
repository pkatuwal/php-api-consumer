<?php

namespace Pramod\PhpApiConsumer\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

trait ConsumerHttpClient
{

    public function performRequest()
    {
        try {
            $handlerStack = HandlerStack::create(new CurlHandler());
            $handlerStack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));
            $client = new Client([
                'base_uri' => $this->baseUri,
                'handler'=>$handlerStack
            ]);
            $response = $client->request($this->method, $this->requestUri, $this->getGuzzleOptions());
            return $this->returnPayloadAsAttributes(json_decode($response->getBody()->getContents(), true), $response->getStatusCode());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errorCode = 500;
            return $this->returnPayloadAsAttributes($e->getResponse()->getBody()->getContents(), $errorCode);
        }
    }

    private function getGuzzleOptions()
    {
        $options=[
            'headers' => $this->headers,
            'timeout'=>$this->timeout,
            'verify'=>$this->sslVerify
        ];
        if (isset($this->graphQl) && $this->graphQl!==null) {
            $options[\GuzzleHttp\RequestOptions::JSON]=$this->graphQl;
            return $options;
        }
        $options['form_params']=$this->formParams;
        return $options;
    }
    private function returnPayloadAsAttributes($response, $statusCode){
        if(isset($this->attachAttributes)){
            return [
                'data'=>$response,
                'status_code'=>$statusCode
            ];
        }
        return $response;
    }

    public function retryDecider()
    {
        return function (
            $retries,
            Request $request,
            Response $response = null,
            RequestException $exception = null
        ) {
            if ($retries >= $this->retryAttempts) {
                return false;
            }

            // Retry connection exceptions
            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response) {
                // Retry on server errors
                if ($response->getStatusCode() >= 500 ) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * delay 1s 2s 3s 4s 5s
     *
     * @return Closure
     */
    public function retryDelay()
    {
        return function ($numberOfRetries) {
            return 1000 * $numberOfRetries;
        };
    }
}
