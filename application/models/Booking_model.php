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
class Booking_model extends CI_Model {

    /**
     * Default constructor
     * @author Tho Le <thole419@gmail.com>
     */
    public function __construct() {
		parent::__construct(); 
    }

    public function loadData(){
		$query = $this->db->get_where('events');
        return $query->result_array();
	}
	public function insert(){
		$title = $this->input->post('title');
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$data = array(
            'title' => $title,
            'start' => $start,
            'end'   => $end);
			
		return $this->db->insert('events', $data);
	}
	 public function update($id){
		$data = array(
            'title' => $this->input->post('title'),
            'start' => $this->input->post('start'),
            'end' => $this->input->post('end')
        );
		$this->db->where('id', $this->input->post('id'));
        return $this->db->update('contracts', $data);
	}
	 public function delete($id){
		$this->db->delete('events', array('id' => $id));
	}
}
