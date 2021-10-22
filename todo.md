## Proposed Method
```php
Service::consume('customer_service')
        ->via('path')
        ->with('')
        ->timeout('60')
        ->ssl(false)
        ->attach(['status_code'])
        ->toArray()
```