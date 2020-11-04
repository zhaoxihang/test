<?php


namespace app\application\filter\lib;


use app\application\filter\Interfaces\Criteria;

class CriteriaMale  implements Criteria
{

    public function meetCriteria(array $persons): array
    {
        $malePersons = [];
        foreach ($persons as $person){
            if($person->getGender() == 'Male'){
                $malePersons[] = $person;
            }
        }

        return $malePersons;
    }

}