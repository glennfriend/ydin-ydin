
Json Parse
```php
use Ydin\Json\Parse as JsonParse;

try {
    $file = base_path('') . '/tests/resources/xxxxxx/refounds_success.json';
    $json = JsonParse::parseFile($file);
}
catch (Exception $e) {
    echo 'Json format error : ' . $e->getMessage() . "\n";
    echo 'File              : ' . $file . "\n";
    exit;
}

print_r($json);
```

