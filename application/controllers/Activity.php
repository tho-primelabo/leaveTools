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
class Activity extends CI_Controller
{

    /**
     * Default constructor
     * @author tho le <thole419@gmail.com>
     */
    public function __construct()
    {
        parent::__construct();
        setUserContext($this);
        $this->load->model('activity_model');
        $this->load->model('rooms_model');

    }

    public function index()
    {
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

    public function loadData()
    {
        $projects = $this->activity_model->loadData($this->input->get('id'));
        $data_events = array();

        foreach($projects->result() as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "title" => $r->name,               
                "end" => $r->end_date,
                "start" => $r->start_date
            );
        }

     echo json_encode($data_events);
     exit();
    }
    public function getActivities()
    {
        $activity = $this->activity_model->getAll();
        //print_r($projects);die();
        $data_events = array();

        foreach($activity->result() as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "code" => $r->code
            );
        }

     echo json_encode($data_events);
     exit();
       
    }
    public function insert()
    {
        // $this->auth->checkIfOperationIsAllowed('create_booking');
        $eventid = $this->booking_model->insert();
        $uid = $this->session->userdata('id');
         $events = array(
            'id' => $eventid,
            'uid'=>$uid
         );
        if ($events) {
            echo json_encode($events);
        }
        //return $events;

        //print_r(json_encode($res));
        //redirect('booking');
    }
    public function update()
    {
        $this->auth->checkIfOperationIsAllowed('update_booking');
        $uid = $this->booking_model->getUidById();
        $uidSession = $this->session->userdata('id');
        //print_r($uid);
        if ($uid == $uidSession) {
            $data = $this->booking_model->update();

            $this->session->set_flashdata('msg', lang('contract_edit_msg_success'));
            echo json_encode($data);
        }
    }
    public function delete()
    {

        $this->auth->checkIfOperationIsAllowed('delete_booking');
        $uid = $this->booking_model->getUidById();
        $uidSession = $this->session->userdata('id');
        //echo $uid;echo ' '.$uidSession;die();
        if ($uid == $uidSession) {
            $data = $this->booking_model->delete();

            $this->session->set_flashdata('msg', lang('contract_delete_msg_success'));
            echo json_encode($data);
        }
        //redirect('booking');
    }

}
