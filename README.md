# Api Consumer


This Package developed to request various external api without creating external service or traits.

## Installation

You can install the package via composer:

```bash
composer require pramod/php-api-consumer
```

## Usage

<i>Please Refer Test Case For Complete Reference which is located in tests/ExampleTest.php</i>

### Basic Syntax
```php
Service::consume('fttx-api')
    ->via('customer/pramodk_home')
    ->with([
        'headers'=>[
                    'Authorization'=>'xx',
                    'Content-Type'=>'',
                    'Accept'=>''
                    ],
        'method'=>'POST',
        'version'=>'v1',
        'payload'=>[
            'name'=>'name is here'
        ]
    ])
    ->attach('status_code')
    ->toArray();
```


# Call Your **Graphql** Api (**Next Release**)

1. Add Your Service setting on <<**config/api-consumer.php**>>
```php
<?php

return [
    'default'=>[
        'timeout'=>10,
        'ssl_verification'=>true,
        'method'=>"GET"
    ],
    'consumer' => [
        'graphqlTest'=>[
            'baseUri'=>'https://countries.trevorblades.com/',
            'timeout'=>60,
            // 'ssl_verification'=>false //my default its true
        ]
    ]
];

```

2.  Add your endpoint on your request class
    + In case of **graphQl** key inside **with** auto set **Accept** and **Content-Type** headers as **application/json**
    + Method is set as **POST**
    + Need to pass your **graphql** query in **query** key
    + Default It call **toJson()**
```php
return Api::consume('graphqlTest')
            ->via('fcm/graphql')
            ->with([
                'graphQl'=>[
                    'query'=>'query{
                            continents{
                              code
                              name
                              countries{
                                code
                                name
                                native
                              }
                            }
                          }'
                    ]
            ])
```

<i>List of all public graphql Api to test </l>
```
https://github.com/APIs-guru/graphql-apis
```
#### Descriptions
1. **consume**
    
    Request Or find Service Name mapped in config file having basic application url,version definitions. It has two payload.
    
        consume($apiHostname, $hosturl)
    
    Default Hosturl will be **.wlink.com.np**

2.  **via**

    This method is used to point service end or function name written in service Namespace
    +  Available Method
        +   first parameter: <i>Api endpoint or uri</i>
        +   Second parameter: <i>if second param is **true**, first param must be method name defined inside your services Folder's class</i>

3.  **with**

    Includes all parameter including headers, payload, query string and method name

4.  **conversion** method [By Default it call **toJson()** method]
    +   **toArray**
    +   **toJson**
    +   **toCollection**
5.  **ssl** method 
    +   either true or false, By default its **True**
6.  **timeout** method 
    +   you can pass second value, By Default its **30 seconds**

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email pramodktwl@gmail.com instead of using the issue tracker.

## Credits

- [Pramod Katuwal](https://github.com/pramod)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## HAPPY CODING :) 
## Test 
```
php vendor/phpunit/phpunit/phpunit
```