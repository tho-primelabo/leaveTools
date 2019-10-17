<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('customers_model','customers');
		$this->load->model('rooms_model');
		$this->lang->load('payslip', $this->language);
		setUserContext($this);
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$data = getUserContext($this);
		$countries = $this->customers->get_list_countries();
		$data['rooms'] = $this->rooms_model->getRooms();
		$opt = array('' => 'All Country');
		foreach ($countries as $country) {
			$opt[$country] = $country;
		}
		
		$data['form_country'] = form_dropdown('',$opt,'','id="country" class="form-control"');
		
		//$this->load->view('templates/header', $data);
        //$this->load->view('menu/index', $data);

       $this->load->view('customer/index', $data);
        $this->load->view('templates/footer');
	}

	public function ajax_list()
	{
		$list = $this->customers->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $customers->FirstName;
			$row[] = $customers->LastName;
			$row[] = $customers->phone;
			$row[] = $customers->address;
			$row[] = $customers->city;
			$row[] = $customers->country;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customers->count_all(),
						"recordsFiltered" => $this->customers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

}
