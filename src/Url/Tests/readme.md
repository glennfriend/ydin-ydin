```php
 use Ydin\Url\Convert;

$email = 'ken@hotmail';
echo Convert::mailto($email);
 
    // Output
    <a href="mailto:ken@hotmail">ken@hotmail</a>
 
 
$url = 'https://google.com.tw';
echo Convert::link($url);
 
    // Output
    <a href="https://google.com.tw" target="_blank">https://google.com.tw</a>
```

```php
use Ydin\Url\UrlMake;

$url = 'https://example.com/hello/world?&data=100';
$urlInfo = UrlMake::parse($url);
/*
Array
(
    [scheme] => 'https'
    [host]   => 'example.com'
    [path]   => '/hello/world'
    [query]  => '&data=100'
    [queryInfo] => Array
        (
            [data] => '100'
        )

    [pathInfo] => Array
        (
            [dirname]   => '/hello'
            [basename]  => 'world'
            [filename]  => 'world'
            [extension] => ''
        )

)
*/

$url = UrlMake::build($urlInfo);
/*
    https://example.com/hello/world?data=100
*/

$url = 'https://example.com/hello/world?&data=%7Babc%7D';
$url = UrlMake::convertBrackets($url);
/*
    https://example.com/hello/world?&data={abc}
*/
```
