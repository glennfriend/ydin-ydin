```php
use Cor\Ydin;

$email = 'ken@hotmail';
echo Ydin\Url\Convert::mailto($email);

    // Output
    <a href="mailto:ken@hotmail">ken@hotmail</a>


$url = 'https://google.com.tw';
echo Ydin\Url\Convert::link($url);

    // Output
    <a href="https://google.com.tw" target="_blank">https://google.com.tw</a>
```