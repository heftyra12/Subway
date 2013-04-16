<?php

    class shiftClass{
        
        //Class Variables
        public $shift_id;
        public $shift_day;
        public $shift;
        
        //Empty Class Constructor
        public function __construct(){
            $this->shift_id ="";
            $this->shift_day ="";
            $this->shift="";
        }
         
        //Class get methods.
        public function getShiftID(){
            return $this->shift_id;
        }
        public function getShiftDay(){
            return $this->shift_day;
        }
        public function getShift(){
            return $this->shift;
        }
        
        //Class set methods.
        public function setShiftID($shift_id){
            $this->shift_id = $shift_id;
        }
        public function setShiftDay($shift_day){
            $this->shiftDay = $shift_day;
        }
        public function setShift($shift){
            $this->shift = $shift;
        }
    }
?>