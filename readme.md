## ydin

### Install from composer
```
composer require "ydin/ydin:0.1.0"
```

### Install from myself
```
composer config "repositories.ydin" path "packages/Ydin/Ydin"
composer require "ydin/ydin:dev-master"
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

