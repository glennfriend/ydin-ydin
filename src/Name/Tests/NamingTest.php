<?php

use PHPUnit\Framework\TestCase;
use Ydin\Name\Naming;

class NamingTest extends TestCase
{
    /**
     * @test
     */
    public function convert()
    {
        $name = new Naming('books admin a b');
        $this->assertEquals('booksadminab', $name->lower());
        $this->assertEquals('booksAdminAB', $name->lowerCamel());
        $this->assertEquals('BooksAdminAB', $name->upperCamel());
        $this->assertEquals('BOOKSADMINAB', $name->upper());
        $this->assertEquals('books_admin_a_b', $name->lower('_'));
        $this->assertEquals('Books_Admin_A_B', $name->upperCamel('_'));
        $this->assertEquals('BOOKS_ADMIN_A_B', $name->upper('_'));
        $this->assertEquals('BOOKS-ADMIN-A-B', $name->upper('-'));
        $this->assertEquals('BOOKS  ADMIN  A  B', $name->upper('  '));

        //
        $name = new Naming(' books  admin  a  b  ');
        $this->assertEquals('booksadminab', $name->lower());

        $name = new Naming('books--admin--a--b');
        $this->assertEquals('booksadminab', $name->lower());

        $name = new Naming('books__admin__a__b');
        $this->assertEquals('booksadminab', $name->lower());

        $name = new Naming('booksAdminAB');
        $this->assertEquals('booksadminab', $name->lower());
    }

}
