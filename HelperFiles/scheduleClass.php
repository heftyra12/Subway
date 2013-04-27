<?php

class scheduleClass {

    private $schedule_id;
    private $employee_id;
    private $first_name;
    private $last_name;
    private $week_no;
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
    private $break;
    private $total_hours;

    function __construct() {

        $day = array(1, 2, 3, 4, 5, 6, 7);
        $start_time = array();
        $end_time = array();
    }

    public function getScheduleID() {
        return $this->schedule_id;
    }

    public function getEmployeeID() {
        return $this->employee_id;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getWeekNo() {
        return $this->week_no;
    }

    public function getMondayStart() {
        return $this->mon_start;
    }

    public function getMondayEnd() {
        return $this->mon_end;
    }

    public function getTuesdayStart() {
        return $this->tues_start;
    }

    public function getTuesdayEnd() {
        return $this->tues_end;
    }

    public function getWednesdayStart() {
        return $this->wed_start;
    }

    public function getWednesdayEnd() {
        return $this->wed_end;
    }

    public function getThursdayStart() {
        return $this->thurs_start;
    }

    public function getThursdayEnd() {
        return $this->thurs_end;
    }

    public function getFridayStart() {
        return $this->fri_start;
    }

    public function getFridayEnd() {
        return $this->fri_end;
    }

    public function getSaturdayStart() {
        return $this->sat_start;
    }

    public function getSaturdayEnd() {
        return $this->sat_end;
    }

    public function getSundayStart() {
        return $this->sun_start;
    }

    public function getSundayEnd() {
        return $this->sun_end;
    }

    public function getBreak() {
        return $this->break;
    }

    public function getTotalHours() {
        return $this->total_hours;
    }

    public function setScheduleID($schedule_id) {
        $this->schedule_id = $schedule_id;
    }

    public function setEmployeeID($employee_id) {
        $this->employee_id = $employee_id;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function setWeekNo($week_no) {
        $this->week_no = $week_no;
    }

    public function setMondayStart($mon_start) {
        $this->mon_start = $mon_start;
    }

    public function setMondayEnd($mon_end) {
        $this->mon_end = $mon_end;
    }

    public function setTuesdayStart($tues_start) {
        $this->tues_start = $tues_start;
    }

    public function setTuesdayEnd($tues_end) {
        $this->tues_end = $tues_end;
    }

    public function setWednesdayStart($wed_start) {
        $this->wed_start = $wed_start;
    }

    public function setWednesdayEnd($wed_end) {
        $this->wed_end = $wed_end;
    }

    public function setThursdayStart($thurs_start) {
        $this->thurs_start = $thurs_start;
    }

    public function setThursdayEnd($thurs_end) {
        $this->thurs_end = $thurs_end;
    }

    public function setFridayStart($fri_start) {
        $this->fri_start = $fri_start;
    }

    public function setFridayEnd($fri_end) {
        $this->fri_end = $fri_end;
    }

    public function setSaturdayStart($sat_start) {
        $this->sat_start = $sat_start;
    }

    public function setSaturdayEnd($sat_end) {
        $this->sat_end = $sat_end;
    }

    public function setSundayStart($sun_start) {
        $this->sun_start = $sun_start;
    }

    public function setSundayEnd($sun_end) {
        $this->sun_end = $sun_end;
    }

    public function setBreak($break) {
        $this->break = $break;
    }

    public function setTotalHours($total_hours) {
        $this->total_hours += $total_hours;
    }

}

?>
