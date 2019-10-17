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
        $this->load->model('users_model');
    }

    public function ajax_list()
	{
		$users = $this->users_model->getUsersByDate(0);
		$dataArray = array();
        foreach ($users as $element) {
            $sub_array  = array();  
                
            $sub_array[] = $element->id."<div style='text-align:right;float:right'><a href='".base_url()."payslip/edit/". $element->id."' title=".lang('payslip_index_thead_tip_edit')."><i class='mdi mdi-currency-usd nolink'></i></a></div>".
            "<div style='text-align:right;float:right'><a href='".base_url()."payslip/detail/". $element->id."' title=".lang('<payslip_index_thead_tip_detail></payslip_index_thead_tip_detail>')."><i class='mdi mdi-details nolink'></i></a></div>" ;  
            $sub_array[] = $element->firstname;  
            $sub_array[] = $element->lastname;  
            $sub_array[] = $element->salary; 
            $sub_array[] = $element->salaryNet; 
            $sub_array[] = $element->number_dependant;  
            // $sub_array[] = '<button type="button" name="update" id="'.$element->id.'" class="btn btn-warning btn-xs">Update</button>
            // <button type="button" name="delete" id="'.$element->id.'" class="btn btn-danger btn-xs">Delete</button>';  
            
            $dataArray[] = $sub_array; 
        }
        echo json_encode(array("data" => $dataArray)); die();
	}


    public function index()
    {
        $this->auth->checkIfOperationIsAllowed('list_contracts');
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);
        $month = date('m');
        $data['title'] = lang('contract_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_contracts_list');
        //echo $date;
        //if ($date == 0) {
          //  $date = date('Y-m-d');
        //}
        //$dateObj = DateTime::createFromFormat('!m', $month);
        $data['year'] = date('Y');
        $data['month'] = date('M');
        $data['users'] = $this->users_model->getUsersByDate(0);
        $data['rooms'] = $this->rooms_model->getRooms();
        //echo json_encode($data['users']);die();
        $data['payslip'] = [];
            // echo $payslip;
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/index', $data);
        $this->load->view('templates/footer');
    }
    public function bydate($date)
    {
        $this->auth->checkIfOperationIsAllowed('list_contracts');
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);
        $curmonth = (int)date('m');
        $curYear = (int)date('y');
        $data['title'] = lang('contract_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_contracts_list');
        //echo $date;die();
        if ($date == 0) {
            $date = date('Y-m-d');
        }
        $dateValue = strtotime($date); 
        $mon = (int)date("m", $dateValue)." "; 
        $year = (int)date('y', $dateValue)."";
        //$dateObj = DateTime::createFromFormat('!m', $month);
        $data['year'] = date('Y');
        $data['month'] = date('M');
        if ($mon > $curmonth || $year > $curYear) {
            $data['users'] = $this->users_model->getUsersByMonth();
            $date = 0;
           // echo  $mon ; echo $curmonth;die();
        }
        else {
            //echo  $mon; die();
            $data['users'] = $this->users_model->getUsersByDate($date);
        }
        $data['rooms'] = $this->rooms_model->getRooms();
        //echo json_encode($data['users']);
        //$data['payslip'] = [];
            // echo $payslip;
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/index', $data);
        $this->load->view('templates/footer');
        
    }
    public function edit($id)
    {
        $this->auth->checkIfOperationIsAllowed('edit_user');
        $data = getUserContext($this);
        //echo $id;die();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('polyglot');
        $data['title'] = lang('users_edit_html_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_create_user');

        $this->form_validation->set_rules('txtSalary', lang('payslip_edit_field_salary'), 'required|strip_tags');
        
        if ($this->config->item('ldap_basedn_db')) $this->form_validation->set_rules('ldap_path', lang('users_edit_field_ldap_path'), 'strip_tags');
        //$uid = $this->session->userdata('id');
        $data['users_item'] = $this->users_model->getUsers($id);
        //echo json_encode($data['users_item']);die();
        $data['rooms'] = $this->rooms_model->getRooms();
        if (empty($data['users_item'])) {
            redirect('notfound');
        }

               
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/edit', $data);
        $this->load->view('templates/footer');
    
        //$this->users_model->updateUsers();
       // $this->session->set_flashdata('msg', lang('users_edit_flash_msg_success'));
        /*if (isset($_GET['source'])) {
            redirect($_GET['source']);
        } else {
            redirect('payslip');
        }*/
        
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
        // update user
        $userid = $this->input->post('userid');
		$sal =  $this->input->post('salary');
		
		$txtNumberOfDep = (int)$this->input->post('txtNumberOfDep');
        $this->db->trans_start();
        $salary_id = $this->payslip_model->create();
        $this->users_model->updateSalaryNNumberDependantById($userid, $sal, $txtNumberOfDep);
        $this->db->trans_complete();
        //echo $salary_id; die();
        $data['payslip'] = [];
        if (isset($salary_id)) {
            $data['payslip'] = $this->payslip_model->getPayslip($salary_id);
            // echo $payslip;
            //$this->session->set_flashdata('msg', lang('users_create_flash_msg_success'));
        }        
        echo json_encode($data['payslip']);//die();
    }
    public function bulkCreate($date) {
        //$date = date('2019-12-10');
        $query = $this->users_model->getUsers();
       if(isset($query) && count($query) > 0) {
            $this->db->trans_start();
            foreach($query as $row) {
                $this->payslip_model->CalcuateNETSalary($row['id'], $row['salary'], $row['number_dependant'], 1, $date);
            }
            $this->db->trans_complete();
            $this->session->set_flashdata('msg', lang('users_edit_flash_msg_success'));
        }
        $dateValue = strtotime($date); 
        //$mon = date("m", $dateValue)." "; 
        //$year = date('y', $dateValue)."";
       
        //echo  $data['year']; die();
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);
        $data['year'] = date('Y', $dateValue)."";
        $data['month'] = date('F', $dateValue)."";
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        $data['users'] = $this->users_model->getUsersByDate($date);
        $data['rooms'] = $this->rooms_model->getRooms();
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/index', $data);
        $this->load->view('templates/footer');
    }
    public function detail($uid)
    {
        $this->auth->checkIfOperationIsAllowed('list_contracts');
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);
        $data['userid'] = $uid;
        $month = date('F');
        $year = date('Y');
        $data['month'] = $month;
        $data['year'] = $year;
        $data['title'] = lang('contract_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_contracts_list');
        //echo  $fromDate."" + ":" + $toDate.""; die();
        //if ($date == 0) {
          //  $date = date('Y-m-d');
        //}
        //$dateObj = DateTime::createFromFormat('!m', $month);
        //$data['year'] = date('Y');
        //$data['month'] = date('M');
        $data['salaries'] = $this->payslip_model->getSalaryByUserId($uid);
        $data['rooms'] = $this->rooms_model->getRooms();
        //echo json_encode($data['users']);die();
        //$data['payslip'] = [];
            // echo $payslip;
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, TRUE);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/detail', $data);
        $this->load->view('templates/footer');
    }
      public function filterDate()
    {
        $this->auth->checkIfOperationIsAllowed('list_contracts');
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);
       
        $data['title'] = lang('contract_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_contracts_list');
        //echo  $date;
        $uid = $this->input->post('userid');
        $date = $this->input->post('date');
        $salaries = $this->payslip_model->getAllSalByUserIdNFromDateToDate($uid, $date);
        $data['rooms'] = $this->rooms_model->getRooms();
        $dataArray = array();
        foreach ($salaries as $element) {            
            $dataArray[] = array(
                $element['salary_id'],
                $element['date'],
                $element['salary_basic'],               
                $element['salary_net'],
                $element['social_insurance'],
                $element['health_insurance'],
                $element['taxable_incom'],
                $element['personal_income_tax'],
                $element['income_before_tax'],
                $element['unEmployment_insurance'],
                $element['peson_tax_payer'],
                $element['salary_overtime'],
                
                
                $element['salary_other']
            );
        }
        echo json_encode(array("data" => $dataArray)); //die();
        //$data['payslip'] = [];
            // echo $payslip;
        
    }
}
