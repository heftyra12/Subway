<?php

class Availability{
    
    public $employee_id;
    public $monday_start;
    public $monday_end;
    public $tuesday_start;
    public $tuesday_end;
    public $wednesday_start;
    public $wednesday_end;
    public $thursday_start;
    public $thursday_end;
    public $friday_start;
    public $friday_end;
    public $saturday_start;
    public $saturday_end;
    public $sunday_start;
    public $sunday_end;
    
    public function __construct(){
        
        $this->monday_start="";
        $this->monday_end="";
        $this->tuesday_start="";
        $this->tuesday_end="";
        $this->wednesday_start="";
        $this->wednesday_end="";
        $this->thursday_start="";
        $this->thursday_end="";
        $this->friday_start="";
        $this->friday_end="";
        $this->saturday_start="";
        $this->saturday_end="";
        $this->sunday_start="";
        $this->sunday_end="";
        $this->employee_id="";
    }
    
    //Get Methods.
    public function getEmployeeID(){
        return $this->employee_id;
    }
    public function getMondayStart(){
        return $this->monday_start;
    }
    public function getMondayEnd(){
        return $this->monday_end;
    }
    public function getTuesdayStart(){
        return $this->tuesday_start;
    }
    public function getTuesdayEnd(){
        return $this->tuesday_end;
    }
    public function getWednesdayStart(){
        return $this->wednesday_start;
    }
    public function getWednesdayEnd(){
        return $this->wednesday_end;
    }
    public function getThursdayStart(){
        return $this->thursday_start;
    }
    public function getThursdayEnd(){
        return $this->thursday_end;
    }
    public function getFridayStart(){
        return $this->friday_start;
    }
    public function getFridayEnd(){
        return $this->friday_end;
    }
    public function getSaturdayStart(){
        return $this->saturday_start;
    }
    public function getSaturdayEnd(){
        return $this->saturday_end;
    }
    public function getSundayStart(){
        return $this->sunday_start;
    }
    public function getSundayEnd(){
        return $this->sunday_end;
    }
    
    //Set Methods
    public function setEmployeeID($employee_id){
        $this->employee_id=$employee_id;
    }
    public function setMondayStart($monday_start){
        $this->monday_start = $monday_start;
    }
    public function setMondayEnd($monday_end){
        $this->monday_end = $monday_end;
    }
    public function setTuesdayStart($tuesday_start){
        $this->tuesday_start = $tuesday_start;
    }
    public function setTuesdayEnd($tuesday_end){
        $this->tuesday_end = $tuesday_end;
    }
    public function setWednesdayStart($wednesday_start){
        $this->wednesday_start = $wednesday_start;
    }
    public function setWednesdayEnd($wednesday_end){
        $this->wednesday_end = $wednesday_end;
    }
    public function setThursdayStart($thursday_start){
        $this->thursday_start = $thursday_start;
    }
    public function setThursdayEnd($thursday_end){
        $this->thursday_end = $thursday_end;
    }
    public function setFridayStart($friday_start){
        $this->friday_start = $friday_start;
    }
    public function setFridayEnd($friday_end){
        $this->friday_end = $friday_end;
    }
    public function setSaturdayStart($saturday_start){
        $this->saturday_start= $saturday_start;
    }
    public function setSaturdayEnd($saturday_end){
        $this->saturday_end = $saturday_end;
    }
    public function setSundayStart($sunday_start){
        $this->sunday_start = $sunday_start;
    }
    public function setSundayEnd($sunday_end){
        $this->sunday_end = $sunday_end;
    }
}
?>
