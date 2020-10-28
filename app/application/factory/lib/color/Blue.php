<?php


namespace app\application\factory\lib\color;


use app\application\factory\Interfaces\Color;

class Blue implements Color
{

    public function fill()
    {
        return 'blue';
    }
}