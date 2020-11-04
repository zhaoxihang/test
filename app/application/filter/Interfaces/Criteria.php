<?php


namespace app\application\filter\Interfaces;


interface Criteria
{
    public function meetCriteria(array $persons):array ;

}