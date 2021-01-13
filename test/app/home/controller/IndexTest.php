<?php
namespace test\app\home\controller;

use app\application\objectPool\WorkerPool;
use app\home\controller\Index;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    public function testIndex()
    {
        $Index = new Index();
        $this->assertEquals(4, $Index->index(4));
    }

    /**
     * 对象池模式
     */
    public function testObjectOne()
    {
        $pool = new WorkerPool();
        $worker1 = $pool->get();
        $worker2 = $pool->get();
        $this->assertCount(2, $pool);
        $this->assertNotSame($worker1, $worker2);
    }

    /**
     * 对象池模式
     */
    public function testObjectTwo()
    {
        $pool = new WorkerPool();
        $worker1 = $pool->get();
        $pool->dispose($worker1);
        $worker2 = $pool->get();
        $this->assertCount(1, $pool);
        $this->assertSame($worker1, $worker2);
    }
}