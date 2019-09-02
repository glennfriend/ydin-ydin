## ydin

### Install
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

