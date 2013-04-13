<?php

class productivityClass{
    
    //Class Variables
    private $store_number;
    private $week_number;
    private $productivity_array;
    
    //Constructor 
    public function __construct(){
        $this->productivity_array = array(1,2,3,4,5,6,7);
    }
    
    //Get Methods
    public function getStoreNumber(){
        return $this->store_number;
    }
    public function getWeekNumber(){
        return $this->week_number;
    }
    public function getWedProd(){
        return $this->productivity_array[0];
    }
    public function getThursProd(){
        return $this->productivity_array[1];
    }
    public function getFriProd(){
        return $this->productivity_array[2];
    }
    public function getSatProd(){
        return $this->productivity_array[3];
    }
    public function getSunProd(){
        return $this->productivity_array[4];
    }
    public function getMonProd(){
        return $this->productivity_array[5];
    }
    public function getTuesProd(){
        return $this->productivity_array[6];
    }
    
    public function getAllProd(){
        return $this->productivity_array;
    }
    
    //SET METHODS
    public function setWeekNumber($week_number){
        $this->week_number = $week_number;
    }
    public function setStoreNumber($store_number){
        $this->store_number = $store_number;
    }
    public function setWedProd($wed_prod){
        $this->productivity_array[0] = $wed_prod;
    }
    public function setThursProd($thurs_prod){
        $this->productivity_array[1] = $thurs_prod;
    }
    public function setFriProd($fri_prod){
        $this->productivity_array[2] = $fri_prod;
    }
    public function setSatProd($sat_prod){
        $this->productivity_array[3] = $sat_prod;
    }
    public function setSunProd($sun_prod){
        $this->productivity_array[4] = $sun_prod;
    }
    public function setMonProd($mon_prod){
        $this->productivity_array[5]=$mon_prod;
    }
    public function setTuesProd($tues_prod){
        $this->productivity_array[6]=$tues_prod;
    }
    public function setAllProd($prod_array){
        $this->mon_prod = $this->setWedProd($prod_array[0]);
        $this->thurs_prod = $this->setThursProd($prod_array[1]);
        $this->fri_prod = $this->setFriProd($prod_array[2]);
        $this->sat_prod = $this->setSatProd($prod_array[3]);
        $this->sun_prod = $this->setSunProd($prod_array[4]);
        $this->mon_prod = $this->setMonProd($prod_array[5]);
        $this->tues_prod = $this->setTuesProd($prod_array[6]);
    }
}
?>
