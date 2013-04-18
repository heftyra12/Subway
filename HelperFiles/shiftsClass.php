<?php

class shiftsClass{
  
    /*Class Variables*/
    private $shift_id;
    private $start_time;
    private $end_time;
    private $shift_day;
    
    /*Constructor*/
    public function __construct($shift_id,$shift_day,$start_time,$end_time){   
        $this->shift_day = $shift_day;
        $this->shift_id = $shift_id;
        $this->start_time = $start_time;
        $this->end_time = $end_time; 
    }
    /*GET METHODS*/
    public function getShiftDay(){
        return $this->shift_day;
    }
    public function getShiftID(){
        return $this->shift_id;
    }
    public function getStartTime(){
        return $this->start_time;
    }
    public function getEndTime(){
        return $this->end_time;
    }
    
    /*SET METHODS*/
    public function setShiftDay($shift_day){
        $this->shift_day = $shift_day;
    }
    public function setShiftID($shift_id){
        $this->shift_id = $shift_id;
    }
    public function setStartTime($start_time){
        $this->start_time = $start_time;
    }
    public function setEndTime($end_time){
        $this->end_time = $end_time;
    }   
}
?>
