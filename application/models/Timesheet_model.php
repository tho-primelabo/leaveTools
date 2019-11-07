<?php
/**
 * This Class contains all the business logic and the persistence layer for the types of leave request.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/tho-primelabo/leavetool
 * @since         0.4.0
 */

if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This Class contains all the business logic and the persistence layer for the timesheet.
 */
class Timesheet_model extends CI_Model {

    /**
     * Default constructor
     * @author Tho Le <thole419@gmail.com>
     */
    public function __construct() {
        
    }

    public function loadData($id=null){
		if($id){
			$query = $this->db->get_where('timesheet' ,array('employee_id' => $id));
		}
		else{
		$query = $this->db->get_where('timesheet' );
			
		}
		//print_r($query);die();
        return $query;
	}
    public function getTimesheetByID($id) {
        
        $query = $this->db->get_where('timesheet' ,array('id' => $id));
		//print_r($query);die();
        return $query->row_array();
	}
    public function insert(){
		$date = $this->input->post('date');
		$curDate = $this->input->post('curDate');
		$comments = $this->input->post('comments');
        $employee_id = $this->input->post('id');
		$project_id =  $this->input->post('project_id');
        $activity_id =  $this->input->post('activity_id');
		$hours = $this->input->post('hours');
		//print_r($this->session->userdata); die();
		$data = array(
            'date' => $date,
            'date_submitted' => $curDate,
			'project_id'   => $project_id,
            'activity_id'   => $activity_id,
            'employee_id' =>$employee_id,
			'hours'=> $hours,
            'comments'   => $comments);
       //print_r($data); die();
		$this->db->insert('timesheet', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	
		//return $this->db->insert('events');
	}
    public function update(){
		$data = array(
            'project_id' => $this->input->post('project_id'),
            'activity_id' => $this->input->post('activity_id'),
            'comments' => $this->input->post('comments'),
			'hours' =>$this->input->post('hours'),
            'date_submitted' => date('Y-m-d')
        );
		//	print_r($this->db->where('id', $this->input->post('id'))); die;
		$this->db->where('id', $this->input->post('id'));
        return $this->db->update('timesheet', $data);
	}
	 public function delete(){
		 $id = $this->input->post('id');
		 //print_r($id);
		return $this->db->delete('timesheet', array('id' => $id));
	}
    public function getUidById() {
		$id = $this->input->post('id');
		$query = $this->db->get_where('timesheet', array('id' => $id));
		//print_r($query);die();
		$record = $query->row_array();
        if (!empty($record)) {
            return $record['employee_id'];
        } else {
            return '';
        }
      
	}
}
