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
class Test extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('Site_model', 'site');
        //setUserContext($this);
    }
    // upload xlsx|xls file
    public function index() {
        $data['page'] = 'order';
        $data['title'] = 'Data Table | TechArise';
       
       // echo 'test'; die();
        $this->load->view('order/index', $data);
    }
    // get Orders List
    public function getOrderList() {    
        $orderID = $this->input->post('order_id');
        $name = $this->input->post('name');
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');        
        if(!empty($orderID)){
            $this->site->setOrderID($orderID);
        }        
        if(!empty($name)){
            $this->site->setName($name);
        }                
        if(!empty($startDate) && !empty($endDate)) {
            $this->site->setStartDate(date('Y-m-d', strtotime($startDate)));
            $this->site->setEndDate(date('Y-m-d', strtotime($endDate)));
        }        
        $getOrderInfo = $this->site->getOrders();
        $dataArray = array();
        foreach ($getOrderInfo as $element) {            
            $dataArray[] = array(
                $element['order_id'],
                date(DATE_FORMAT_SIMPLE, $element['order_date']),
                $element['name'],
                $element['city'],
                $element['amount'],
                $element['status'],
            );
        }
        echo json_encode(array("data" => $dataArray));
    }

    

}
