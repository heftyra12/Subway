<?php

    class employeeClass{
        
        //Class Variables
        private $employee_first_name;
        private $employee_last_name;
        private $employee_email;
        private $employee_type;
        private $employee_minor;
        private $employee_id;
        private $employee_availability;
        private $mon_start;
        private $mon_end;
        private $tues_start;
        private $tues_end;
        private $wed_start;
        private $wed_end;
        private $thurs_start;
        private $thurs_end;
        private $fri_start;
        private $fri_end;
        private $sat_start;
        private $sat_end;
        private $sun_start;
        private $sun_end;
        
        //Empty Class Constructor
        public function __construct(){
            $this->employee_first_name ="";
            $this->employee_last_name = "";
            $this->employee_email = "";
            $this->employee_type ="";
            $this->employee_minor ="No";
            $this->employee_id ="";
            $this->employee_availability="";
            $this->mon_start="";
            $this->mon_end="";
            $this->tues_start="";
            $this->tues_end="";
            $this->wed_start="";
            $this->wed_end="";
            $this->thurs_start="";
            $this->thurs_end="";
            $this->fri_start="";
            $this->fri_end="";
            $this->sat_start="";
            $this->sat_end="";
            $this->sun_start="";
            $this->sun_end="";
        }
         
        //Class get methods.
        public function getEmployeeID(){
            return $this->employee_id;
        }
        public function getEmployeeFirstName(){
            return $this->employee_first_name;
        }
        public function getEmployeeLastName(){
            return $this->employee_last_name;
        }
        public function getEmployeeEmail(){
            return $this->employee_email;
        }
        public function getEmployeeType(){
            return $this->employee_type;
        }
        public function getEmployeeMinor(){
            return $this->employee_minor;
        }
        public function getMondayStart(){
            return $this->mon_start;
        }
        public function getMondayEnd(){
            return $this->mon_end;
        }
        public function getTuesdayStart(){
            return $this->tues_start;
        }
        public function getTuesdayEnd(){
            return $this->tues_end;
        }
        public function getWednesdayStart(){
            return $this->wed_start;
        }
        public function getWednesdayEnd(){
            return $this->wed_end;
        }
        public function getThursdayStart(){
            return $this->thurs_start;
        }
        public function getThursdayEnd(){
            return $this->thurs_end;
        }
        public function getFridayStart(){
            return $this->fri_start;
        }
        public function getFridayEnd(){
            return $this->fri_end;
        }
        public function getSaturdayStart(){
            return $this->sat_start;
        }
        public function getSaturdayEnd(){
            return $this->sat_end;
        }
        public function getSundayStart(){
            return $this->sun_start;
        }
        public function getSundayEnd(){
            return $this->sun_end;
        }
        public function getEmployeeAvailability(){
            return $this->employee_availability;
        }
        
        //Class set methods.
        public function setEmployeeID($employee_id){
            $this->employee_id = $employee_id;
        }
        public function setEmployeeFirstName($first_name){
            $this->employee_first_name = $first_name;
        }
        public function setEmployeeLastName($last_name){
            $this->employee_last_name = $last_name;
        }
        public function setEmployeeEmail($email){
            $this->employee_email = $email;
        }
        public function setEmployeeType($employee_type){
            $this->employee_type = $employee_type;
        }
        public function setEmployeeMinor($minor){
            $this->employee_minor = $minor;
        }
        public function setMondayStart($mon_start){
            $this->mon_start = $mon_start;
        }
        public function setMondayEnd($mon_end){
            $this->mon_end = $mon_end;
        }
        public function setTuesdayStart($tues_start){
            $this->tues_start = $tues_start;
        }
        public function setTuesdayEnd($tues_end){
            $this->tues_end = $tues_end;
        }
        public function setWednesdayStart($wed_start){
            $this->wed_start = $wed_start;
        }
        public function setWednesdayEnd($wed_end){
            $this->wed_end = $wed_end;
        }
        public function setThursdayStart($thurs_start){
            $this->thurs_start = $thurs_start;
        }
        public function setThursdayEnd($thurs_end){
            $this->thurs_end = $thurs_end;
        }
        public function setFridayStart($fri_start){
            $this->fri_start = $fri_start;
        }
        public function setFridayEnd($fri_end){
            $this->fri_end = $fri_end;
        }
        public function setSaturdayStart($sat_start){
            $this->sat_start = $sat_start;
        }
        public function setSaturdayEnd($sat_end){
            $this->sat_end = $sat_end;
        }
        public function setSundayStart($sun_start){
            $this->sun_start = $sun_start;
        }
        public function setSundayEnd($sun_end){
            $this->sun_end = $sun_end;
        }
        public function setEmployeeAvailability($employee_availability){
            $this->employee_availability = $employee_availability;
        }
    }
?>