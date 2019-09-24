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
		$this->load->model('rooms_model');

    }

    public function index() { 
		setUserContext($this);
		$data = getUserContext($this);
		$data['rooms'] = $this->rooms_model->getRooms();
        $data['title'] = 'Booking';	
		$this->auth->checkIfOperationIsAllowed('booking');
		
		$this->load->view('templates/header', $data);
		$this->load->view('menu/index', $data);
		
		$this->load->view('booking/index');
		$this->load->view('templates/footer');
      } 
	  
	  public function loadData(){
		 $events = $this->booking_model->loadData($this->input->get('roomid'));
		 //$res = '';
		 //foreach($events as $key=>$event){
			//$res[] = $event;
		 //}
		 echo json_encode($events);
	  }
	  public function insert(){
		$this->auth->checkIfOperationIsAllowed('create_booking');
		 $events = $this->booking_model->insert();
		 if($events){
 			echo json_encode($events);
		 }
		
		
		 //print_r(json_encode($res));
		 //redirect('booking');
	  }
	public function update(){
		$this->auth->checkIfOperationIsAllowed('update_booking');
		$uid = $this->booking_model->getUidById();
		$uidSession = $this->session->userdata('id');
		//print_r($uid);
		if ($uid == $uidSession) {
			$data=$this->booking_model->update();
			
			$this->session->set_flashdata('msg', lang('contract_edit_msg_success'));
			echo json_encode($data);
	}
	}
	  public function delete()
    {
		
        $this->auth->checkIfOperationIsAllowed('delete_booking');
		$uid = $this->booking_model->getUidById();
		$uidSession = $this->session->userdata('id');
		if ($uid == $uidSession) {
			$data = $this->booking_model->delete();
			
			$this->session->set_flashdata('msg', lang('contract_delete_msg_success'));
			echo json_encode(1);
		}
    	//redirect('booking');
    }

}
