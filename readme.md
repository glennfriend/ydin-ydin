
### Install
composer config "repositories.ydin" path "packages/Cor/Ydin"
composer require "cor/ydin:dev-master"

### Unit Test
```
./vendor/bin/phpunit --testdox
```

### report
```
./vendor/bin/phpunit  --configuration phpunit.report.xml
firefox _build/coverage/index.html
```

