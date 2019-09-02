### PHP version & composer
    "crossjoin/browscap" 2.x 的版本必須要使用 PHP 5.6 以上 (目前是使用這個版本)
    "crossjoin/browscap" 3.x 的版本必須要使用 PHP 7 以上

### use myself library to composer
```
{
    "require" : {
        "cor/ydin": "dev-master"
    },
    "repositories": [
        {
            "type": "path",
            "url": "packages/Cor/Ydin/src"
        }
    ],
}
```

### use github to composer
```
{
    "require" : {
        "cor/ydin": "dev-master"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/glennfriend/Ydin.git"
        }
    ],
}
```
