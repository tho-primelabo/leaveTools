<?php
/**
 * This controller serves all the actions performed by human resources department
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/tho-primelab/leavetools
 * @since         0.1.0
 */

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * This class serves all the actions performed by human resources department.
 * There is a distinction with Admin controller which contain technical actions on users.
 * HR controller deals with employees.
 */
class Payslip extends CI_Controller
{

    /**
     * Default constructor
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function __construct()
    {
        parent::__construct();
        setUserContext($this);
        $this->lang->load('payslip', $this->language);
        $this->load->model('rooms_model');
        $this->load->model('payslip_model');
        $this->load->model('users_model');
    }

    public function ajax_list()
    {
        $date = $this->input->post('date');
        // echo $date; die();
        if ($date == '') {
            $date = date('Y-m-d');
        }

        $users = $this->bydate($date);

        //print_r($salHistory);die();
        $dataArray = array();
        foreach ($users as $element) {
            $sub_array = array();
            $salHistory = $this->payslip_model->getRowPayslipHistoryByDate($element->id, $date);
            //print_r($salHistory);die();
            if ($salHistory->num_rows() > 0) {
                $sub_array[] = $element->id . "<div style='padding-left: 5px;float:right'><a href='" . base_url() . "payslip/edit/" . $element->id . "/" . $date . "' title=" . lang('payslip_index_thead_tip_edit') . "><i class='mdi mdi-currency-usd'></i></a></div>" .
                "<div style='padding-left: 5px;float:right'><a href='" . base_url() . "payslip/detail/" . $element->id . "' title=" . lang('payslip_index_thead_tip_detail') . "><i class='mdi mdi-blur'></i></a></div>" .
                // "<div style='float:right'><a href='".base_url()."payslip/history/". $element->id."/".$date. "' title=".lang('payslip_index_thead_tip_history')."><i class='mdi mdi-history'></i></a></div>" ;
                "<div style='float:right'><a href='javascript:displayDialog($element->id);' title='history'><i class='mdi mdi-history'></i></a>";
            } else {
                $sub_array[] = $element->id . "<div style='padding-left: 5px;float:right'><a href='" . base_url() . "payslip/edit/" . $element->id . "/" . $date . "' title=" . lang('payslip_index_thead_tip_edit') . "><i class='mdi mdi-currency-usd'></i></a></div>" .
                "<div style='float:right'><a href='" . base_url() . "payslip/detail/" . $element->id . "' title=" . lang('payslip_index_thead_tip_detail') . "><i class='mdi mdi-blur'></i></a></div>";
            }
            $sub_array[] = $element->firstname;
            $sub_array[] = $element->lastname;
            $sub_array[] = number_format($element->salary_basic);

            $sub_array[] = number_format($element->salaryNet);

            $sub_array[] = $element->number_dependant;
            // $sub_array[] = '<button type="button" name="update" id="'.$element->id.'" class="btn btn-warning btn-xs">Update</button>
            // <button type="button" name="delete" id="'.$element->id.'" class="btn btn-danger btn-xs">Delete</button>';

            $dataArray[] = $sub_array;
        }
        return send_ajax_and_exit(["data" => $dataArray]);
    }

    public function index()
    {
        $this->auth->checkIfOperationIsAllowed('list_payslips');
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);
        $date = $this->input->post('date');
        $month = date('m');
        $data['title'] = lang('contract_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_contracts_list');
        //echo $date;
        if ($date == 0) {
            $date = date('Y-m-d');
            $data['year'] = date('Y');
            $data['month'] = date('F');
        } else {
            $mydate = DateTime::createFromFormat("Y-m-d", $date);
            //echo $date->format("F");

            $data['year'] = $mydate->format('Y');
            $data['month'] = $mydate->format('F');
            //print_r($data['year']); die();
        }
        $data['users'] = $this->users_model->getUsersByDate($date);
        $data['rooms'] = $this->rooms_model->getRooms();
        //echo json_encode($data['users']); echo $data['month'];die();
        //$data['payslip'] = [];
        // echo $payslip;
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, true);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/index', $data);
        $this->load->view('templates/footer');
    }
    public function bydate($date)
    {
        $this->auth->checkIfOperationIsAllowed('list_payslips');
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);
        $curmonth = (int) date('m');
        $curYear = (int) date('y');
        $data['title'] = lang('contract_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_contracts_list');
        //echo $date;die();
        if ($date == 0) {
            $date = date('Y-m-d');
        }
        $dateValue = strtotime($date);
        $mon = (int) date("m", $dateValue) . " ";
        $year = (int) date('y', $dateValue) . "";
        //$dateObj = DateTime::createFromFormat('!m', $month);
        $data['year'] = date('Y');
        $data['month'] = date('M');

        return $this->users_model->getUsersByDate($date);

    }
    public function edit($id, $date = 0)
    {
        $this->auth->checkIfOperationIsAllowed('list_payslips');
        $data = getUserContext($this);
        //echo $date;die();
        if ($date == 0) {
            $date = date('Y-m-d');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('polyglot');
        $data['title'] = lang('users_edit_html_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_create_user');
        $data['date'] = $date;
        $this->form_validation->set_rules('txtSalary', lang('payslip_edit_field_salary'), 'required|strip_tags');

        if ($this->config->item('ldap_basedn_db')) {
            $this->form_validation->set_rules('ldap_path', lang('users_edit_field_ldap_path'), 'strip_tags');
        }

        //$uid = $this->session->userdata('id');
        //$data['users_item'] = $this->users_model->getUsers($id);
        $data['users_item'] = $this->payslip_model->getRowPayslipByDate($id, $date);
        //echo json_encode($data['users_item']);die();
        $data['rooms'] = $this->rooms_model->getRooms();
        if (empty($data['users_item'])) {
            $data['users_item'] = $this->users_model->getUsers($id);
            $data['id'] = $data['users_item']['id'];
            $data['salary'] = $data['users_item']['salary'];
            $data['NoDepend'] = $data['users_item']['number_dependant'];
            //echo json_encode($data['users_item']['salary']);die();
            if (empty($data['users_item'])) {
                redirect('notfound');
            }
        } else {
            $data['id'] = $data['users_item']['employee_id'];
            $data['salary'] = $data['users_item']['salary_basic'];
            $data['NoDepend'] = $data['users_item']['number_dependant'];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/edit', $data);
        $this->load->view('templates/footer');

    }
    public function create($date = 0)
    {
        $this->auth->checkIfOperationIsAllowed('list_payslips');
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
        $data['public_key'] = file_get_contents('./assets/keys/public.pem', true);
        // update user
        $userid = $this->input->post('userid');
        $sal = $this->input->post('salary');

        $txtNumberOfDep = (int) $this->input->post('txtNumberOfDep');
        $date = $this->input->post('date');
        $this->db->trans_start();
        $salary_id = $this->payslip_model->create($date);
        $this->users_model->updateSalaryNNumberDependantById($userid, $sal, $txtNumberOfDep);
        $this->db->trans_complete();
        //echo $salary_id; die();
        $data['payslip'] = [];
        if (isset($salary_id)) {
            $data['payslip'] = $this->payslip_model->getPayslip($salary_id);
            // echo $payslip;
            //$this->session->set_flashdata('msg', lang('users_create_flash_msg_success'));
        }
        echo json_encode($data['payslip']); //die();
    }
    public function bulkCreate()
    {
        //$date = date('2019-12-10');
        $date = $this->input->post('date');
        //echo $date;die();
        $query = $this->users_model->getUsers();
        if (isset($query) && count($query) > 0) {
            $this->db->trans_start();
            foreach ($query as $row) {
                $this->payslip_model->CalcuateNETSalary($row['id'], $row['salary'], $row['number_dependant'], 1, $date);
            }
            $this->db->trans_complete();
            //echo json_encode(lang('users_edit_flash_msg_success'));//die();
            $this->session->set_flashdata('msg', lang('users_edit_flash_msg_success'));
        }
        $dateValue = strtotime($date);

        redirect('payslip/index');
    }

    public function back()
    {
        //$date = date('2019-12-10');
        $date = $this->input->post('date');
        //$time = strtotime($date);
        $date = date('Y-F-d', strtotime($date));
        //echo ($date);die();
        //$this->session->set_flashdata('msg', $date);
        $this->session->set_flashdata('dateSession', $date);
        $users = $this->bydate($date);
        $tmpDate = new DateTime($date);
        $data['month'] = $tmpDate->format('F');
        $data['year'] = $tmpDate->format('Y');
        //$query = $this->users_model->getUsers();
        // echo json_encode($users);die();
        // $dateValue = strtotime($date);
        echo json_encode(array("url" => '/payslip/index'));
        //redirect('payslip/index');
    }
    public function detail($uid)
    {
        $this->auth->checkIfOperationIsAllowed('list_payslips');
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
        //echo json_encode($data['salaries']);die();
        //$data['payslip'] = [];
        // echo $payslip;
        $data['flash_partial_view'] = $this->load->view('templates/flash', $data, true);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('payslip/detail', $data);
        $this->load->view('templates/footer');
    }
    public function filterDate()
    {
        $this->auth->checkIfOperationIsAllowed('list_payslips');
        $this->lang->load('datatable', $this->language);
        $data = getUserContext($this);

        $data['title'] = lang('contract_index_title');
        $data['help'] = $this->help->create_help_link('global_link_doc_page_contracts_list');
        //echo  $date;
        $uid = $this->input->post('userid');
        $date = $this->input->post('date');
        $salaries = $this->payslip_model->getAllSalByUserIdNFromDateToDate($uid, $date);
        //echo json_encode($salaries);die();
        $data['rooms'] = $this->rooms_model->getRooms();
        $dataArray = array();
        foreach ($salaries as $element) {
            $date = $element['date'];
            $dataArray[] = array(
                $element['salary_id'],

                $element['date'] . " &nbsp;<a title='Send Mail' href='" . base_url() . "payslip/mail/$uid/$date'>" . "<i class='mdi mdi-email nolink'></i></a>",
                // "&nbsp;<a href='/' "."title='history'"."<i class='mdi mdi-history nolink'></i></a>",
                number_format($element['salary_basic']),
                number_format($element['salary_net']),
                number_format($element['social_insurance']),
                number_format($element['health_insurance']),
                number_format($element['income_before_tax']),
                number_format($element['personal_income_tax']),
                number_format($element['taxable_incom']),
                number_format($element['unEmployment_insurance']),
                number_format($element['peson_tax_payer']),
                number_format($element['salary_overtime']),

                number_format($element['salary_other']),
            );
        }
        echo json_encode(array("data" => $dataArray));die();
        //$data['payslip'] = [];
        // echo $payslip;

    }

    public function export()
    {
        $this->auth->checkIfOperationIsAllowed('export_user');
        $this->load->view('payslip/export');
    }

    public function exportDetail($userid)
    {
        //echo $this->user_id; die();
        $this->user_id = $userid;
        //echo $this->user_id; die();
        $this->auth->checkIfOperationIsAllowed('export_user');
        $this->load->view('payslip/exportDetail');
    }
    /**
     * Send a payslip request creation email to the employee
     * @param int $id employee request identifier
     * @param int $date of payslip
     * @author tho le <thole419.@gmail.com>
     */
    public function mail($id, $date)
    {
        //echo $id; echo $date; die();
        $this->load->model('users_model');

        //We load everything from DB as the LR can be edited from HR/Employees
        $payslip = $this->payslip_model->getPayslipByDate($id, $date);
        $user = $this->users_model->getUsers($payslip[0]['employee_id']);
        //print_r($user['email']);  die();
        $manager = $this->users_model->getUsers($user['manager']);
        if (empty($user['email'])) {
            $this->session->set_flashdata('msg', lang('leaves_create_flash_msg_error'));
        } else {

            $this->sendMail($user['firstname'], $user['lastname'], $user['email'], $payslip[0], $manager['language']);
            //$this->load->view('payslip/detail');
            $this->detail($payslip[0]['employee_id']);
        }
    }
    public function history($id, $date = 0)
    {
        // echo $id; echo $date;die();
        if ($date == 0) {
            $date = date('Y-m-d');
        }
        //echo $id; echo $date;die();
        $result = $this->payslip_model->getRowPayslipHistoryByDate($id, $date);
        // print_r($result->result_array()); die();
        $response = "<table class='table table-striped' border='0' width='100%'>";
        $response .= "<thead>";
        $response .= "<th>";
        $response .= lang('payslip_index_thead_id');
        $response .= "</th>";
        $response .= "<th>";
        $response .= lang('payslip_gross_salary');
        $response .= "</th>";
        $response .= "<th>";
        $response .= lang('payslip_net_salary');
        $response .= "</th>";
        $response .= "<th>";
        $response .= lang('payslip_field_taxable_incom');
        $response .= "</th>";
        $response .= "<th>";
        $response .= lang('payslip_field_social_insurance');
        $response .= "</th>";
        $response .= "<th>";
        $response .= lang('payslip_field_health_insurance');
        $response .= "</th>";
        $response .= "<th>";
        $response .= lang('payslip_number_dependant');
        $response .= "</th>";
        $response .= "<th>";
        $response .= lang('payslip_employees_thead_date');
        $response .= "</th>";

        foreach ($result->result_array() as $row) {
            $id = $row['id'];
            $salary_basic = $row['salary_basic'];
            $salary = $row['salary_net'];
            $social_insurance = $row['social_insurance'];
            $health_insurance = $row['health_insurance'];
            $income_before_tax = $row['income_before_tax'];
            $number_dependant = $row['number_dependant'];
            $date = $row['date'];

            $response .= "<tr><td>" . $id . "</td>";
            $response .= "<td>" . number_format($salary_basic) . "</td>";
            $response .= "<td>" . number_format($salary) . "</td>";
            $response .= "<td>" . number_format($income_before_tax) . "</td>";
            $response .= "<td>" . number_format($social_insurance) . "</td>";
            $response .= "<td>" . number_format($health_insurance) . "</td>";
            $response .= "<td>" . number_format($number_dependant) . "</td>";
            $response .= "<td>" . $date . "</td></tr>";

        }
        //$response .= "</table>";
        $response .= "</thead>";
        $response .= "</table>";
        echo $response;
        exit;
    }
    public function sendMail2AllUsers()
    {
        //$date = date('2019-12-10');
        $date = $this->input->post('date');
        //echo $date;die();
        if (empty($date)) {
            $date = date('Y-m-d');
        }
        $user = $this->users_model->getUsers();
        if (isset($user) && count($user) > 0) {
            $this->db->trans_start();

            foreach ($user as $row) {
                $payslip = $this->payslip_model->getPayslipByDate($row['id'], $date);

                $manager = $this->users_model->getUsers($row['manager']);
                $this->sendMail($row['firstname'], $row['lastname'], $row['email'], $payslip[0], $manager['language']);

            }
            $this->db->trans_complete();
            //echo json_encode(lang('users_edit_flash_msg_success'));//die();
            $this->session->set_flashdata('msg', lang('paslip_email_flash_msg_success'));
        }
        //$dateValue = strtotime($date);

        redirect('payslip/index');
    }
    private function sendMail($firstName, $lastName, $mail, $payslip, $language)
    {
        //Send an e-mail to the manager
        $this->load->library('email');
        $this->load->library('polyglot');
        $usr_lang = $this->polyglot->code2language($language);

        //We need to instance an different object as the languages of connected user may differ from the UI lang
        $lang_mail = new CI_Lang();
        $lang_mail->load('email', $usr_lang);
        $lang_mail->load('global', $usr_lang);
        $tmpDate = new DateTime($payslip['date']);
        $saldate = $tmpDate->format('d-m-Y');

        $cc = null;
        $this->load->library('parser');
        $data = array(
            'Firstname' => $firstName,
            'Lastname' => $lastName,
            'date' => $saldate,
            'GROSS' => number_format($payslip['salary_basic']),
            'NET' => number_format($payslip['salary_net']),
            'social_insurance' => number_format($payslip['social_insurance']),
            'health_insurance' => number_format($payslip['health_insurance']),
            'taxable_incom' => number_format($payslip['taxable_incom']),

        );
        //$message = $payslip[0]['date'].'gross salary:'.$payslip[0]['salary_basic'];//$this->parser->parse( $data, TRUE);
        $message = $this->parser->parse('emails/' . $language . '/salary', $data, true);
        $to = $mail;
        $subject = 'payslip';
        $this->session->set_flashdata('msg', lang('paslip_email_flash_msg_success'));
        sendMailByWrapper($this, $subject, $message, $to, $cc);
    }
}
