<?php
/**
 * This controller loads the static and custom pages of the application
 * @copyright  Copyright (c) 2014-2019 
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/tho-primelabo/leavetool
 * @since         0.4.0
 */

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * This class serve default and cutom pages.
 * Please note that a page can be the implementation of a custom report (see Controller Report)
 */
class Booking extends CI_Controller {
   
    /**
     * Default constructor
     * @author tho le <thole419@gmail.com>
     */
    public function __construct() {
        parent::__construct();
		setUserContext($this);
		$this->load->model('booking_model');
    }

    public function index() { 
		setUserContext($this);
		$data = getUserContext($this);
        $data['title'] = 'Booking';
		$this->auth->checkIfOperationIsAllowed('booking');
		$this->load->view('templates/header', $data);
		$this->load->view('menu/index', $data);
		$this->load->view('booking/index');
		$this->load->view('templates/footer');
      } 
	  
	  public function loadData(){
		 $events = $this->booking_model->loadData();
		 foreach($events as $key=>$event){
			$res[] = $event;
		 }
		 echo json_encode($res);
	  }
	  public function insert(){
		//$this->auth->checkIfOperationIsAllowed('create_booking');
		var_dump($events);
		 $events = $this->booking_model->insert();
		 foreach($events as $key=>$event){
			$res[] = $event;
		 }
		 echo json_encode($res);
	  }
	public function update(){
		$this->auth->checkIfOperationIsAllowed('update_booking');
		$data=$this->booking_model->update();
		var_dump($data);
		$this->session->set_flashdata('msg', lang('contract_edit_msg_success'));
		echo json_encode($data);
	}
	  public function delete()
    {
        $this->auth->checkIfOperationIsAllowed('delete_booking');
		$id = $this->input->post('id');
		//print_r($id);
		$this->booking_model->delete();
        //die();
        $this->session->set_flashdata('msg', lang('contract_delete_msg_success'));
        redirect('booking');
    }

}
