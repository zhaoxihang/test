<?php


namespace app\application\dependency_injection;


class Bar
{
    protected $time;

    public function __construct()
    {
        $this->time = new \DateTime();
//        $this->time = $time;
    }
}