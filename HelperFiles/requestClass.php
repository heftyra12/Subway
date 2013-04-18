<?php

class requestClass{
    
    private $employee_id;
    private $request_id;
    private $first_name;
    private $last_name;
    private $start_date;
    private $end_date;
    private $start_time;
    private $end_time;
    private $start_month;
    private $start_day;
    private $end_month;
    private $end_day;
    
    public function __construct(){
        $this->employee_id="";
        $this->request_id="";
        $this->first_name="";
        $this->last_name="";
        $this->start_date = "";
        $this->end_date="";
        $this->start_time="";
        $this->end_time="";
        $this->start_month="";
        $this->end_month="";
        $this->start_day="";
        $this->end_day="";
    }
    
    public function getRequestID(){
        return $this->request_id;
    }
     public function getEmployeeID(){
        return $this->employee_id;
    }
    public function getFirstName(){
        return $this->first_name;
    }
    public function getLastName(){
        return $this->last_name;
    }
    public function getStartDate(){
        return $this->start_date;
    }
    public function getEndDate(){
        return $this->end_date;
    }
    public function getStartMonth(){
        return $this->start_month;
    }
    public function getStartDay(){
        return $this->start_day;
    }
    public function getEndMonth(){
        return $this->end_month;
    }
    public function getEndDay(){
        return $this->end_day;
    }
    public function getStartTime(){
        return $this->start_time;
    }
    public function getEndTime(){
        return $this->end_time;
    }
   
    
    public function setRequestID($request_id){
        $this->request_id = $request_id;
    }
    public function setStartDate($start_date){
        $this->start_date = $start_date;
    }
    public function setEndDate($end_date){
        $this->end_date = $end_date;
    }
    public function setStartMonth($start_month){
        $this->start_month = $start_month;
    }
    public function setStartDay($start_day){
        $this->start_day = $start_day;
    }
    public function setEndMonth($end_month){
        $this->end_month = $end_month;
    }
    public function setEndDay($end_day){
        $this->end_day = $end_day;
    }
    public function setStartTime($start_time){
        $this->start_time = $start_time;
    }
    public function setEndTime($end_time){
        $this->end_time = $end_time;
    }
    public function setEmployeeID($employee_id){
        $this->employee_id = $employee_id;
    }
    public function setFirstName($first_name){
        $this->first_name = $first_name;
    }
    public function setLastName($last_name){
        $this->last_name = $last_name;
    }   
}
?>
