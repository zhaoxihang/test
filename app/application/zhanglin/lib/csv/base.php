<?php


namespace app\application\zhanglin\lib\csv;


use app\application\zhanglin\tools\csvFile;

abstract class base
{
    /**
     * @var csvFile
     */
    private $initial_csv;

    public function __construct()
    {
        $this->initial_csv = new csvFile();
    }
}