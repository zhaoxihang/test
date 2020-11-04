<?php


namespace app\application\filter\lib;


class Person
{
    /**
     * 姓名
     * @var string
     */
    private $name;

    /**
     * 性别
     * @var string
     */
    private $gender;

    /**
     * 婚姻状况
     * @var string
     */
    private $maritalStatus;

    public function __construct(string $name,string $gender,string $maritalStatus)
    {
        $this->name = $name;
        $this->gender = $gender;
        $this->maritalStatus = $maritalStatus;
    }

    public function getName(){
        return $this->name;
    }

    public function getGender(){
        return $this->gender;
    }

    public function getMaritalStatus(){
        return $this->maritalStatus;
    }


}