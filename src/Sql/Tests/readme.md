
Sql
```php
use Ydin\Sql\Convert as SqlConvert;

list($sqlConvert, $bindingsConvert) = SqlConvert::convertPreparedStatementAboutAttribEmulation($sql, $bindings);
echo $sqlConvert;
dump($bindingsConvert);
```

