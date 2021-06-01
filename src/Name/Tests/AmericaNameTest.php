<?php

use PHPUnit\Framework\TestCase;
use Ydin\Name\AmericaName;

class AmericaNameTest extends TestCase
{
    /**
     * @test
     * @dataProvider check_lastName_list
     * @param $lastName
     * @param $result
     */
    public function lastNameCase($lastName, $result)
    {
        $this->assertEquals($result, AmericaName::lastNameCase($lastName));
    }

    public function check_lastName_list()
    {
        return [
            ['helloworld', 'Helloworld'],
            ['HELLOWORLD', 'Helloworld'],
            ['hello-world', 'Hello-World'],
            ['de la hoya', 'De La Hoya'],
            ['mchotdog', 'McHotdog'],
            ['difranco', 'DiFranco'],
            ["o'brian", "O'Brian"],
        ];
    }

    /**
     * @test
     * @dataProvider check_titleCase_list
     * @param $name
     * @param $result
     */
    public function titleCase($name, $result)
    {
        $this->assertEquals($result, AmericaName::titleCase($name));
    }

    public function check_titleCase_list()
    {
        return [
            //
            ['helloworld', 'Helloworld'],
            ['HELLOWORLD', 'Helloworld'],
            ['hello-world', 'Hello-World'],
            ['de la hoya', 'De La Hoya'],
            ['mchotdog', 'McHotdog'],
            ['difranco', 'DiFranco'],
            ["o'brian", "O'Brian"],
            //
            ["michael o'brian", "Michael O'Brian"],
            ["michael l'amour", "Michael l'Amour"],
            ["go d'onofrio", "Go d'Onofrio"],
            ['william stanley iii', 'William Stanley III'],
            ['UNITED STATES OF AMERICA', 'United States of America'],
            ['t. von lieres und wilkau', 'T. von Lieres und Wilkau'],
            ['jean-luc picard', 'Jean-Luc Picard'],
            ['hENRIC vIII', 'Henric VIII'],
            ['VAsco da GAma', 'Vasco da Gama'],
        ];
    }
}
