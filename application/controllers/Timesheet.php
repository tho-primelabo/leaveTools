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
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view("timesheet/index.php");
        $this->load->view('templates/footer');
       
    }

}
