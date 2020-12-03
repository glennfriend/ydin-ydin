## ydin

### Install from local composer package
```
composer config "repositories.ydin" path "packages/ydin-ydin"
php -d memory_limit=-1  /usr/local/bin/composer require "ydin/ydin:dev-master"
```

### Unit Test
```
clear && ./vendor/bin/phpunit --testdox
```

### report
```
./vendor/bin/phpunit  --configuration phpunit.report.xml
firefox _build/coverage/index.html
```

### 分類方式
- 預計參考 https://github.com/symfony/symfony/tree/4.4/src/Symfony/Component