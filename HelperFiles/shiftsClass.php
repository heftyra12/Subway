<?php

class shiftsClass{
  
    /*Class Variables*/
    private $shift_id;
    private $start_time;
    private $end_time;
    
    /*Constructor*/
    public function __construct(){
        
    }
    
    /*GET METHODS*/
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
