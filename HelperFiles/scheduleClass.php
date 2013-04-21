<?php

class scheduleClass{
    
    private $schedule_id;
    private $employee_id;
    private $first_name;
    private $last_name;
    private $week_no;
    private $day;
    private $start_time;
    private $end_time;
    private $break;
    private $total_hours;
    
    function __construct(){
        
        $day = array(1,2,3,4,5,6,7);
        $start_time = array();
        $end_time = array();
        
    }
    
    public function getScheduleID(){
        return $this->schedule_id;
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
    public function getWeekNo(){
        return $this->week_no;
    }
    public function getDay(){
        return $this->day;
    }
    public function getStartTime(){
        return $this->start_time;
    }
    public function getEndTime(){
        return $this->end_time;
    }
    public function getBreak(){
        return $this->break;
    }
    public function getTotalHours(){
        return $this->total_hours;
    }
    
    public function setScheduleID($schedule_id){
        $this->schedule_id = $schedule_id;
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
    public function setWeekNo($week_no){
        $this->week_no = $week_no;
    }
    public function setDay($day){
        $this->day =$day;
    }
    public function setStartTime($start_time){
        $this->start_time = $start_time;
    }
    public function setEndTime($end_time){
        $this->end_time = $end_time;
    }
    public function setBreak($break){
        $this->break = $break;
    }
    public function setTotalHours($total_hours){
        $this->total_hours += $total_hours;
    }
}
?>
