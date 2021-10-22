## Proposed Method
```php
Service::consume('customer_service')
        ->via('path')
        ->with('')
        ->attach(['status_code'])
        ->toArray()
```