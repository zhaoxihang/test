<?php


namespace app\application\filter\lib;


use app\application\filter\Interfaces\Criteria;

class OrCriteria implements Criteria
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

    public function __construct(Criteria $criteria ,Criteria $otherCriteria){
        $this->criteria = $criteria;
        $this->otherCriteria = $otherCriteria;
     }


    public function meetCriteria(array $persons): array
    {
        $firstCriteriaPersons = $this->criteria->meetCriteria($persons);
        $otherCriteriaPersons = $this->otherCriteria->meetCriteria($persons);

        foreach ($otherCriteriaPersons as $person){
            if(!in_array($person ,$firstCriteriaPersons)){
                $firstCriteriaPersons[] = $person;
            }
        }

        return $firstCriteriaPersons;
    }


}