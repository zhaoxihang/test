<?php


namespace app\human;


use app\human\chain_of_genes\ChainOfGenes;

abstract class HumanBase
{
    public $id ;

    protected $the_chain_of_genes ;

    public function __construct()
    {
        //生成他自己的基因链，存储到数据库生成唯一id
        $this->the_chain_of_genes = $this->createTheChainOfGenes();
    }

    /**
     * 生成基因链
     */
    protected function createTheChainOfGenes($parent = null,$mother = null){
        $chain_of_genes = new ChainOfGenes();
        return $chain_of_genes->isMutation()?$chain_of_genes->mutationPosition():[];
    }



}