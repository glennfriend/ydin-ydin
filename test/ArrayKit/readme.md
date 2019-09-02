
使用 . 的方式來取得陣列中的值
```php
$items = [
    'users' => [
        [
            'name'  => 'john',
            'age'   => 20
        ],
        [
            'name'  => 'vivian',
            'age'   => 26
        ],
    ]
];
$dot = Cor\Ydin\ArrayKit\Dot::factory($items);
echo $dot('users.0.age');
echo $dot('users.2.age', 0);
```

