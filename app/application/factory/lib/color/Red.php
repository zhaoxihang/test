<?php


namespace app\application\factory\lib\color;


use app\application\factory\Interfaces\Color;

class Red implements Color
{

    public function fill()
    {
        return 'red';
    }
}