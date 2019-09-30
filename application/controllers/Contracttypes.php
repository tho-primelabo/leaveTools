<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This class allows to manage the list of leave types
 */
class Contracttypes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        setUserContext($this);
        $this->load->model('Contracttypes_model', 'contract_types');
        $this->lang->load('contracttypes', $this->language);
        $this->load->model('rooms_model');
    }

    public function index()
    {
        $this->auth->checkIfOperationIsAllowed('leavetypes_list');
        $data = getUserContext($this);
        $data['contracttypes'] = $this->contract_types->getContractTypes();
        $data['title'] = lang('contracttypes_type_title');
        $data['rooms'] = $this->rooms_model->getRooms();
        $data['help'] = $this->help->create_help_link('global_link_doc_page_edit_leave_type');
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('contracttypes/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Display a form that allows adding a leave type
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function create()
    {
        $this->auth->checkIfOperationIsAllowed('leavetypes_create');
        $data = getUserContext($this);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = lang('leavetypes_popup_create_title');
        $data['leavetypes'] = $this->contract_types->getContractTypes();

        $this->form_validation->set_rules('name', lang('leavetypes_popup_create_field_name'), 'required|strip_tags');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contracttypes/create', $data);
        } else {
            $this->contract_types->setContractTypes();
            $this->session->set_flashdata('msg', lang('leavetypes_popup_create_flash_msg'));
            redirect('contracttypes');
        }
    }

    public function edit($id)
    {
        $this->auth->checkIfOperationIsAllowed('contracttypes_edit');
        $data = getUserContext($this);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = lang('contracttypes_popup_update_title');
        $data['id'] = $id;
        $data['contracttypes'] = $this->contract_types->getContractTypes();
        $data['contracttypes'] = $this->contract_types->getContractTypes($id);

        $this->form_validation->set_rules('name', lang('contracttypes_popup_update_field_name'), 'required|strip_tags');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contracttypes/edit', $data);
        } else {
            $this->contract_types->updateContractTypes(
                $id,
                $this->input->post('name'),
                $this->input->post('alias'),
                $this->input->post('description')
            );
            $this->session->set_flashdata('msg', lang('contracttypes_popup_update_flash_msg'));
            redirect('contracttypes');
        }
    }

    /**
     * Action : delete a leave type
     * @param int $id leave type identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function delete($id)
    {
        $this->auth->checkIfOperationIsAllowed('leavetypes_delete');
        if ($id != 0) {
            if ($this->contract_types->usage($id) > 0) {
                $this->session->set_flashdata('msg', lang('leavetypes_popup_delete_flash_forbidden'));
            } else {
                $this->contract_types->deleteType($id);
                $this->session->set_flashdata('msg', lang('leavetypes_popup_delete_flash_msg'));
            }
        } else {
            $this->session->set_flashdata('msg', lang('leavetypes_popup_delete_flash_error'));
        }
        redirect('contracttypes');
    }

    /**
     * Action: export the list of all leave types into an Excel file
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function export()
    {
        $this->auth->checkIfOperationIsAllowed('leavetypes_export');
        $this->load->view('leavetypes/export');
    }
}
