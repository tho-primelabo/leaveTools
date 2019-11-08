<?php
/**
 * This controller loads the static and custom pages of the application
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/tho-primelabo/leavetool
 * @since         0.4.0
 */

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * This class serve default and timesheet pages.
 * Please note that a page can be the implementation of a custom report (see Controller Report)
 */
class Timesheet extends CI_Controller {
   
    /**
     * Default constructor
     * @author Tho Le <thole419@gmail.com>
     */
    public function __construct() {
        parent::__construct();
        setUserContext($this);
        $this->load->model('rooms_model');
      
        $this->lang->load('timesheet', $this->language);
        $this->load->model("timesheet_model");

    }
    public function index(){

        $data = getUserContext($this);
        $data['rooms'] = $this->rooms_model->getRooms();
        $this->auth->checkIfOperationIsAllowed('booking');
        $data['title'] = lang('contract_index_title');
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view("timesheet/index.php");
        $this->load->view('templates/footer');
       
    }
    public function loadData()
    {
        //echo $this->input->get('id');die();
        $timesheets = $this->timesheet_model->loadData($this->input->get('id'));
        $data_events = array();

        foreach($timesheets->result() as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "title" => $r->project_id,               
                "end" => $r->date,
                "start" => $r->date
            );
        }

     echo json_encode($data_events);
     exit();
    }

    public function update()
    {
        $this->timesheet_model->update();
        $this->session->set_flashdata('msg', lang('contract_update_msg_success'));
        //$data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        //exit();
    }
    public function updateByDrop()
    {
        $this->timesheet_model->updateByDrop();
        $this->session->set_flashdata('msg', lang('contract_update_msg_success'));
       // $data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        //exit();
    }
    public function insert()
    {
       $id = $this->timesheet_model->insert();
       $uid = $this->session->userdata('id');
      $timesheet = array(
            'id' => $id,
            'uid'=>$uid
         );
        if ($timesheet) {
            echo json_encode($timesheet);
        }
       // exit();
    }
     public function getTimesheetByID()
    {
      
        $id = $this->input->post('id');
        $query = $this->timesheet_model->getTimesheetByID($id);
        echo json_encode($query);
       
    }
    public function delete()
    {
        $uid = $this->timesheet_model->getUidById();
        $uidSession = $this->session->userdata('id');
        //echo $uid;echo ': '.$uidSession;die();
        if ($uid == $uidSession) {
            $data = $this->timesheet_model->delete();
            //$this->session->set_flashdata('msg', lang('contract_delete_msg_success'));
            echo json_encode($data);
        }
    }

}
