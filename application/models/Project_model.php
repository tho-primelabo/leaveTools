<?php
/**
 * This Class contains all the business logic and the persistence layer for the types of leave request.
 * @copyright  Copyright (c) 2014-2019 
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/tho-primelabo/leavetool
 * @since         0.4.0
 */

if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This Class contains all the business logic and the persistence layer for the types of leave request.
 */
class Project_model extends CI_Model {

    /**
     * Default constructor
     * @author Tho Le <thole419@gmail.com>
     */
    public function __construct() {
		parent::__construct(); 
    }

    public function loadData($id=null){
		if($id){
			$query = $this->db->get_where('project' ,array('manager_id' => $id));
		}
		else{
		$query = $this->db->get_where('project' );
			
		}
		//print_r($query);die();
        return $query;
	}
	 public function getAll(){
		
		$id = $this->input->post('id');
		$query = $this->db->get_where('project' ,array('manager_id' => $id));
			
		
		//print_r($query);die();
        return $query;
	}
	public function insert(){
		$title = $this->input->post('title');
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$uid = $this->session->userdata('id');
		$roomId = $this->input->post('roomid');
		//print_r($this->session->userdata); die();
		$data = array(
            'title' => $title,
            'start' => $start,
			'uid'   => $uid,
			'roomid'=> $roomId,
            'end'   => $end);
		$this->db->insert('events', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	
		//return $this->db->insert('events');
	}
	 public function update(){
		$data = array(
            'title' => $this->input->post('title'),
            'start' => $this->input->post('start'),
            'end' => $this->input->post('end'),
			'roomid' =>$this->input->post('roomid')
        );
		//	print_r($this->db->where('id', $this->input->post('id'))); die;
		$this->db->where('id', $this->input->post('id'));
        return $this->db->update('events', $data);
	}
	 public function delete(){
		 $id = $this->input->post('id');
		 print_r($id);
		return $this->db->delete('events', array('id' => $id));
	}
	public function getUidById() {
		$id = $this->input->post('id');
		$query = $this->db->get_where('events', array('id' => $id));
		//print_r($query);
		$record = $query->row_array();
        if (!empty($record)) {
            return $record['uid'];
        } else {
            return '';
        }
      
	}
}
