<?php


namespace app\application\filter\lib;


use app\application\filter\Interfaces\Criteria;

class AndCriteria implements Criteria
{
    /**
     * @var Criteria
     */
    private $criteria;

    /**
     * 其他标准
     * @var Criteria
     */
    private $otherCriteria;

    public function __construct(Criteria $criteria , Criteria $otherCriteria){
        $this->criteria = $criteria;
        $this->otherCriteria = $otherCriteria;
    }

    public function meetCriteria(array $persons): array
    {
        $firstCriteriaPersons = $this->criteria->meetCriteria($persons);
        return $this->otherCriteria->meetCriteria($firstCriteriaPersons);
    }


}