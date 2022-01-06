```php
use Ydin\ThirdParty\Laravel\Url\UrlGrammar;

/**
 * @var $request \Illuminate\Http\Request;
 */
$url = 'https://www.example.com/api/module/action-name?page=1';
$options += [
    'totalCount' => 18,
    'limit'      => 15,
];
echo UrlGrammar::buildResponseLinks($request, $options);
```
