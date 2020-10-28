<?php


namespace app\application\factory\lib\color;


use app\application\factory\Interfaces\Color;

class Green implements Color
{

    public function fill()
    {
        return 'green';
    }
}