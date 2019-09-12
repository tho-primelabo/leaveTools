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
class Booking extends CI_Controller {
   
    /**
     * Default constructor
     * @author tho le <thole419@gmail.com>
     */
    public function __construct() {
        parent::__construct();
        //setUserContext($this);
		$this->load->model('booking_model');
    }

    public function index() { 
		$this->auth->checkIfOperationIsAllowed('booking');
		$this->load->view('booking/index'); 
      } 

}
