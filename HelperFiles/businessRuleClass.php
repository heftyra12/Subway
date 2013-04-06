<?php

class businessRuleClass{
    
    /*CLASS VARIABLES*/
    public $rule_id;
    public $store_id;
    public $rule_description;
    public $rule_value_one;
    public $rule_value_two;
    
    /*CONSTRUCTOR*/
    public function __construct(){}
    
    /*GET METHODS*/
    public function getRuleID(){
        return $this->rule_id;
    }
    public function getRuleDescription(){
        return $this->rule_description;
    }
    public function getRuleValueOne(){
        return $this->rule_value_one;
    }
    public function getRuleValueTwo(){
        return $this->rule_value_two;
    }
    public function getStoreID(){
        return $this->store_id;
    }
    
    /*SET METHODS*/
    public function setRuleValueOne($rule_one){
        $this->rule_value_one = $rule_one;
    }
    public function setRuleValueTwo($rule_two){
        $this->rule_value_two = $rule_two;
    }
    public function setRuleDescription($description){
        $this->rule_description = $description;
    }
    public function setRuleID($id){
        $this->rule_id = $id;
    }
    public function setStoreID($store_id){
        $this->store_id = $store_id;
    }
}

?>
