<?php

    class employeeClass{
        
        //Class Variables
        public $employee_first_name;
        public $employee_last_name;
        public $employee_email;
        public $employee_type;
        public $employee_minor;
        public $employee_id;
        public $employee_availability;
        
        //Empty Class Constructor
        public function __construct(){
            $this->employee_first_name ="";
            $this->employee_last_name = "";
            $this->employee_email = "";
            $this->employee_type ="";
            $this->employee_id ="";
            $this->employee_minor ="No";
            $this->employee_availability="";
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
        public function setEmployeeAvailability($employee_availability){
            $this->employee_availability = $employee_availability;
        }
    }
?>

