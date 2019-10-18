<?/**
 * Description of Order Controller
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Order extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->model('Site_model', 'site');
    }
    // upload xlsx|xls file
    public function index() {
        $data['page'] = 'order';
        $data['title'] = 'Data Table | TechArise';
        echo 'test'; die();
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
?>