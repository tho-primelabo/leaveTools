<?php
/**
 * This controller serves all the actions performed on postions
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.1.0
 */

if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This controller serves all the actions performed on postions
 * A postion qualifies the job of an employee.
 * The list of postion is managed by the HR department.
 */
class Rooms extends CI_Controller {

    /**
     * Default constructor
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function __construct() {
        parent::__construct();
        setUserContext($this);
        $this->load->model('Rooms_model');
        $this->lang->load('rooms', $this->language);
    }

    /**
     * Display list of Rooms
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function index() {
        $this->auth->checkIfOperationIsAllowed('list_positions');
        $data = getUserContext($this);
        $this->lang->load('datatable', $this->language);
        $data['rooms'] = $this->Rooms_model->getRooms();
        $data['title'] = lang('Rooms_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_Rooms_list');
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('Rooms/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Display a popup showing the list of Rooms
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function select() {
        $this->auth->checkIfOperationIsAllowed('list_positions');
        $data = getUserContext($this);
        $this->lang->load('datatable', $this->language);
        $data['rooms'] = $this->Rooms_model->getRooms();
        $this->load->view('Rooms/select', $data);
    }

    /**
     * Display a form that allows adding a position
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function create() {
        $this->auth->checkIfOperationIsAllowed('create_positions');
        $data = getUserContext($this);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = lang('Rooms_create_title');

        $this->form_validation->set_rules('name', lang('Rooms_create_field_name'), 'required|strip_tags');
        //$this->form_validation->set_rules('description', lang('Rooms_create_field_description'), 'strip_tags');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('rooms/create', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Rooms_model->setRooms($this->input->post('name'));
            $this->session->set_flashdata('msg', lang('Rooms_create_flash_msg'));
            redirect('rooms');
        }
    }

    /**
     * Display a form that allows to edit a position
     * @param int $id position identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function edit($id) {
        $this->auth->checkIfOperationIsAllowed('edit_positions');
        $data = getUserContext($this);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = lang('rooms_edit_title');
        $data['room'] = $this->Rooms_model->getRooms($id);
        $data['rooms'] = $this->Rooms_model->getRooms();
        //Check if exists
        if (empty($data['room'])) {
            redirect('notfound');
        }
        $this->form_validation->set_rules('name', lang('Rooms_edit_field_name'), 'required|strip_tags');
        //$this->form_validation->set_rules('description', lang('Rooms_edit_field_description'), 'strip_tags');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('rooms/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Rooms_model->updateRoom($id, $this->input->post('name'));
            $this->session->set_flashdata('msg', lang('Rooms_edit_flash_msg'));
            redirect('rooms');
        }
    }

    /**
     * Delete a position
     * @param int $id position identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function delete($id) {
        $this->auth->checkIfOperationIsAllowed('delete_positions');
        $this->Rooms_model->deleteRoom($id);
        $this->session->set_flashdata('msg', lang('rooms_delete_flash_msg'));
        redirect('rooms');
    }

    /**
     * Export the list of all Rooms into an Excel file
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function export() {
        $this->auth->checkIfOperationIsAllowed('export_Rooms');
        $this->load->view('Rooms/export');
    }
}
