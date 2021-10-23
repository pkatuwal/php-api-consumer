<?php

namespace Pramod\PhpApiConsumer\Test;

use Pramod\PhpApiConsumer\Service;

class ExampleTest extends \PHPUnit_Framework_TestCase
{


    /**
     * Test that true does in fact equal true
     */
    public function testTrueIsTrue()
    {

        $data=Service::consume('api-int-beta')
              ->via('single_request/pramodk_home')
              ->attach('status_code')
              ->retry(20)
              ->ssl(true)
              ->toJson();
        // $data = Service::getInstance()::consume('api-int-beta')
        //     ->via('single_request/pramodk_home')
        //     ->attach('status_code')
        //     ->retry(20)
        //     ->toJson();;
        print_r($data);
    }
}
