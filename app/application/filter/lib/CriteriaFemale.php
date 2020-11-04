<?php


namespace app\application\filter\lib;


use app\application\filter\Interfaces\Criteria;

class CriteriaFemale implements Criteria
{

    public function meetCriteria(array $persons): array
    {
        $femalePersons = [];
        foreach ($persons as $person){
            if($person->getGender() == 'Female'){
                $femalePersons[] = $person;
            }
        }

        return $femalePersons;
    }


}