<?php

namespace Pramod\PhpApiConsumer\Traits;

use GuzzleHttp\Client;

trait ConsumerHttpClient
{

    public function performRequest()
    {
        try {
            $client = new Client([
                'base_uri' => $this->baseUri
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
}
