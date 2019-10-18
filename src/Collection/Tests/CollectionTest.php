<?php

use PHPUnit\Framework\TestCase;

class Collection_CollectionTest extends TestCase
{
    public function setUp(): void
    {
        $this->items = [
            [
                'name' => 'Chris',
                'age' => 145,
            ],[
                'name' => 'vivian',
                'age' => 18,
            ],[
                'name' => 'Hello Kitty',
                'age' => 18,
            ],[
                'name' => 'Hello Kitty',
                'age' => '200',
            ],[
                'name' => 'kevin',
                'age' => 15,
            ],
        ];
        $this->collection = new Ydin\Collection\Collection();
        $this->collection->insertMany($this->items);
    }

    private function getCollection()
    {
        return $this->collection;
    }

    // --------------------------------------------------------------------------------
    // test
    // --------------------------------------------------------------------------------
    public function test_insert()
    {
        $collection = $this->getCollection();
        $this->assertEquals( true, 5 === count($collection->toArray()) );

        $collection->insert($this->items[0]);
        $items = $collection->toArray();
        $this->assertEquals( true, 6 === count($collection->toArray()) );
    }

    public function test_unique()
    {
        $collection = $this->getCollection();

        // unique, 有區分大小寫
        $collection->unique('name');
        $this->assertEquals( true, 4 === count($collection->toArray()) );
    }

    public function test_filter()
    {
        $collection = $this->getCollection();

        $this->assertEquals( true,  'Chris' === $collection->toArray()[0]['name'] );
        $this->assertEquals( true,  '200'   === $collection->toArray()[3]['age'] );

        $collection->filter('name', 'strtolower,trim,to_string');
        $this->assertEquals( true,  'chris' === $collection->toArray()[0]['name'] );

        $collection->filter('age',  'to_int');
        $this->assertEquals( true,  200 === $collection->toArray()[3]['age'] );
    }

    public function test_sort()
    {
        $collection = $this->getCollection();

        $this->assertEquals( true, 'vivian' === $collection->toArray()[1]['name'] );

        // 多欄位排序
        $collection->sort('name ASC, age DESC');
        $this->assertEquals( true, 'Hello Kitty' === $collection->toArray()[1]['name'] );
    }

    public function test_get()
    {
        $collection = $this->getCollection();

        // 只取匹配到的第一筆 or null
        $this->assertEquals( true,  15 === $collection->get('name == kevin')['age'] );

        // 糢糊匹配
        $this->assertEquals( true, 'vivian' === $collection->get('name % via')['name'] );

        // > >= < <=
        $this->assertEquals( true, $collection->get('age >= 30')['age'] >= 30 );
        $this->assertEquals( true, 0 === count($collection->get('age < 10')) );
        $this->assertEquals( true, $collection->get('age <  18')['age'] <  18 );
        $this->assertEquals( true, $collection->get('age <= 18')['age'] <= 18 );

        // in
        $this->assertEquals( true, 15 === $collection->get('age in 10,15,20')['age'] );
        $this->assertEquals( true, "Hello Kitty" === $collection->get('name in ooo.xxx,Hello Kitty')['name'] );

        // 不論大小寫的匹配
        $this->assertEquals( true, 0 === count($collection->get('name == Kevin')) );
        $this->assertEquals( true, 'kevin' === $collection->get('name == Kevin', '/i')['name'] );
    }

    public function test_find()
    {
        $collection = $this->getCollection();

        $this->assertEquals( true, 2 === count($collection->find('name % v')) );
    }

}
