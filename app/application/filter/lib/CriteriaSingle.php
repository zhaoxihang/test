<?php


namespace app\application\filter\lib;


use app\application\filter\Interfaces\Criteria;

class CriteriaSingle implements Criteria
{

    public function meetCriteria(array $persons): array
    {
        $singlePersons = [];
        foreach ($persons as $person){
            if($person->getMaritalStatus() == 'singleDog'){
                $singlePersons[] = $person;
            }
        }

        return $singlePersons;
    }


}