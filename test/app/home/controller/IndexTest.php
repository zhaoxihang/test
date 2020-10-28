<?php
namespace test\app\home\controller;

use app\home\controller\Index;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    public function testIndex()
    {
        $Index = new Index();
        $this->assertEquals(4, $Index->index(4));
    }
}