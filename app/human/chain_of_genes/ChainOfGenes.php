<?php


namespace app\human\chain_of_genes;


class ChainOfGenes
{
    protected $mutation_arr = [
        [75,25],
        [99,1],
        [99,1],
        [99,1]
    ];

    function get_rand($proArr) {

        $result = '';

        //概率数组的总概率精度

        $proSum = array_sum($proArr);

        //概率数组循环

        foreach ($proArr as $key => $proCur) {

            $randNum = mt_rand(1, $proSum);             //抽取随机数

            if ($randNum <= $proCur) {

                $result = $key;                         //得出结果

                break;

            } else {

                $proSum -= $proCur;

            }

        }

        unset ($proArr);

        return $result;

    }


    function isMutation():bool
    {
        $flog = true;
        foreach ($this->mutation_arr as $value){
            if(!$this->get_rand($value)){
                $flog = false;
                break;
            }
        }
        return $flog;
    }

    function mutationPosition(){
        $randNum = [];
        for ($i = 0; $i <= 4; $i++){
            $randNum[$i] = [mt_rand(1, 100)];
        }
        $randNum["5"] = [mt_rand(1,60)=>$this->mutationIsGood()];
        return $randNum;
    }

    function mutationIsGood():bool
    {
        return (bool)$this->get_rand([50,50]);
    }
}