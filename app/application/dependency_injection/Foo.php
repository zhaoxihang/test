<?php


namespace app\application\dependency_injection;


class Foo
{
    protected $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }
}