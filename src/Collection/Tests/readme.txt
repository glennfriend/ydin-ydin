
    $collection = new Ydin\Collection\Collection();

    $items = [
        [
            'name' => 'vivian',
            'age' => 18,
        ],[
            'name' => 'Hello Kitty',
            'age' => 20,
        ],[
            'name' => 'kevin',
            'age' => 15,
        ],
    ];

    $collection->insert($items[0]);
        新增一組陣列 (無視索引值)

    $collection->insertMany($items);
        新增多組陣列 (無視索引值)

    $collection->filter('name', 'strtolower,trim,toInt,toString');
        將陣列中所有 name 欄位的值做以下的變更
            strtolower()
            trim()
            convert to int
            convert to string

    $collection->unique('name');
        與欄位 name 同相值的陣列, 將會被移除, 只留第一筆

    $collection->sort('name ASC, age DESC');
        多欄位排序

    各種的匹配
        >
        >=
        <
        <=
        ==
        !==
        ===
        !==
        %
        in

    補助匹配
        /i      不分大小寫

    $collection->get('name == kevin');
    $collection->get('name === kevin');
    $collection->get('name % via');
        糢糊匹配

    $collection->get('age >= 30');
    $collection->get('age < 10');
    $collection->get('age in 10,20,30');
    $collection->get('name == kevin', '/i');
        不論大小寫的匹配

    $array = $collection->find('name % k');
        匹配多筆

    $array = $collection->toArray();

