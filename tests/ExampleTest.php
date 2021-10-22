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

        $data=Service::consume('fttx-api')
              ->via('customer/pramodk_home')
              ->attach('status_code')
              ->toArray();
        print_r($data);
    }
}