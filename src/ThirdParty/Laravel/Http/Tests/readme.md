```php
use Ydin\ThirdParty\Laravel\Http\RequestQueryOrderParser;

    public function __construct(RequestQueryOrderParser $requestQueryOrderParser)
    {
        $this->requestQueryOrderParser = $requestQueryOrderParser;
    }

    public function perform()
    {
        // one field example
        $sortName = $this->requestQueryOrderParser->name() ?? 'created_at';
        $sortType = $this->requestQueryOrderParser->type() ?? 'DESC';
        dump($sortName, $sortType);

        // mutile fields example
        $sorts = $this->requestQueryOrderParser->getSorts();
        dump($sorts);
    }

```