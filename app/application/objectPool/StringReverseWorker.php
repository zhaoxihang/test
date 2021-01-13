<?php


namespace app\application\objectPool;


class StringReverseWorker
{
    private $createdAt;

    private $text;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function run(string $text)
    {
        $this->text = strrev($text);
        return $this->text;
    }
}