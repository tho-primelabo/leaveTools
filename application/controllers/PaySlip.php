<?php
/**
 * This controller serves all the actions performed by human resources department
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/tho-primelab/leavetools
 * @since         0.1.0
 */

if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This class serves all the actions performed by human resources department.
 * There is a distinction with Admin controller which contain technical actions on users.
 * HR controller deals with employees.
 */
class Payslip extends CI_Controller {

    /**
     * Default constructor
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function __construct() {
        parent::__construct();
        setUserContext($this);
        $this->lang->load('payslip', $this->language);
        $this->load->model('rooms_model');
        $this->load->model('payslip_model');
    }

    public function index()
    {
        $this->auth->checkIfOperationIsAllowed('list_contracts');
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);
        $data['title'] = lang('contract_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_contracts_list');
        
        $data['rooms'] = $this->rooms_model->getRooms();
       
        $data['payslip'] = [];
            // echo $payslip;
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/payslip', $data);
        $this->load->view('templates/footer');
    }
    public function create () {
        $this->auth->checkIfOperationIsAllowed('create_user');
        $data = getUserContext($this);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('polyglot');
        $data['title'] = lang('users_create_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_create_user');

        $this->load->model('roles_model');
        $data['rooms'] = $this->rooms_model->getRooms();
        $data['roles'] = $this->roles_model->getRoles();
        $this->load->model('contracts_model');
        $data['contracts'] = $this->contracts_model->getContracts();
        $data['public_key'] = file_get_contents('./assets/keys/public.pem', TRUE);
        $salary_id = $this->payslip_model->create();
        if (isset($salary_id)) {
            $data['payslip'] = $this->payslip_model->getPayslip($salary_id);
            // echo $payslip;
            $this->session->set_flashdata('msg', lang('users_create_flash_msg_success'));
        }
        
        echo json_encode($data['payslip']);
        // redirect('payslip');
    }
}
