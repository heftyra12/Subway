<?php

class Productivity{
    
    //Class variables
    public $day;
    public $productivity;
 
    //Constructor
    function __construct(){
        
        $this->day="";
        $this->productivity="";
    }
    
    //Get methods
    public function getDay(){
        return $this->day;
    }
    public function getProductivity(){
        return $this->productivity;
    }
    
    //Set methods
    public function setDay($day){
        $this->day = $day;
    }
    public function setProductivity($productivity){
        $this->productivity = $productivity;
    }
    
}
?>
