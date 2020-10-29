<?php


namespace app\application\enum;


use PhpEnum\ListEnum;

class CityEnum extends ListEnum
{
    const PROVINCE_LIAONING = ['','','Liaoning'];
    const CITY_BEIJING = ['','','Beijing'];
    const CITY_SHANGHAI = ['','','shanghai'];

    /**
     * 省
     * @var
     */
    private $province;

    /**
     * 市
     * @var
     */
    private $city;

    /**
     * 名称
     * @var
     */
    private $name;

    /**
     * ListEnum function. Programmers cannot invoke this constructor,
     * and must override this function to assign values to properties.
     *
     * @param array $list the value of this enum constant, and here it is expected to be used assign variables as list.
     * @example list(mixed $var1 [, mixed $... ]) = $list;
     */
    protected final function ListEnum($list)
    {
        list($this->province,$this->city,$this->name) = $list;
    }

    /**
     * Returns list enum constant length.
     * Programmers must override this function to returns a integers greater than zero.
     *
     * @return int list enum constant length
     */
    public static function length()
    {
        return 3;
    }

    /**
     * @return mixed
     */
    public function getProvince(){
        return $this->province;
    }

    /**
     * @return mixed
     */
    public function getCity(){
        return $this->province;
    }

    /**
     * @return mixed
     */
    public function getName(){
        return $this->province;
    }
}