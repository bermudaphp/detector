# Install
```bash
composer require bermudaphp/detector
````
# Usage
```php
$detector = new FinfoDetector;

$detector->detectMimeType(file_get_contents('index.html')) // text/html;
$detector->detectExtension(file_get_contents('index.html')) // html;
````
