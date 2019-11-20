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
		
		$query = $this->db->get('project' );
			
		
		//print_r($query);die();
        return $query;
	}
	public function insert(){
		$data = array(
            'project_code' => $this->input->post('project_code'),
            'name' => $this->input->post('name'),
            'location' => $this->input->post('location'),
			'manager_id' =>$this->input->post('manager_id'),
			'start_date' =>$this->input->post('start_date'),
			'end_date' =>$this->input->post('end_date'),
			'other_details' =>$this->input->post('other')
		);
		$this->db->insert('project', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	
		//return $this->db->insert('events');
	}
	 public function update(){
		$data = array(
            'project_code' => $this->input->post('project_code'),
            'name' => $this->input->post('name'),
            'location' => $this->input->post('location'),
			'manager_id' =>$this->input->post('manager_id'),
			'start_date' =>$this->input->post('start_date'),
			'end_date' =>$this->input->post('end_date'),
			'other_details' =>$this->input->post('other')
        );
		//	print_r($this->db->where('id', $this->input->post('id'))); die;
		$this->db->where('id', $this->input->post('id'));
        return $this->db->update('project', $data);
	}
	 public function delete($id){
		//$id = $this->input->post('id');
		 //print_r($id);
		return $this->db->delete('project', array('id' => $id));
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
	public function import($data) {
 
        $res = $this->db->insert_batch('project',$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
 
    }
 
}
