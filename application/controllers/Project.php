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
class Project extends CI_Controller
{

    /**
     * Default constructor
     * @author tho le <thole419@gmail.com>
     */
    public function __construct()
    {
        parent::__construct();
        setUserContext($this);
        $this->lang->load('project', $this->language);
        $this->load->model('project_model');
        $this->load->model('users_model');
        $this->load->model('rooms_model');
        $this->load->helper('form'); 
        $this->load->helper('download');

    }

    public function index()
    {
        $this->auth->checkIfOperationIsAllowed('list_projects');
        setUserContext($this);
        $data = getUserContext($this);
        $data['rooms'] = $this->rooms_model->getRooms();
        $data['title'] = 'Booking';
        $this->auth->checkIfOperationIsAllowed('booking');

        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);

        $this->load->view('projects/index');
        $this->load->view('templates/footer');
    }

    public function loadData()
    {
        //$projects = $this->project_model->loadData($this->input->get('id'));
        $projects = $this->project_model->getAll();
        $dataArray = array();

        foreach($projects->result() as $element) {
            $sub_array = array();
            
            $sub_array[] = $element->id;
            $sub_array[] = $element->project_code;
            $sub_array[] = $element->name;
            $sub_array[] = $element->location;
            $sub_array[] = $element->manager_id;
            $sub_array[] = $element->start_date;
            $sub_array[] = $element->end_date;
            $sub_array[] = $element->other_details;
            $data = json_encode($sub_array);
            $sub_array[] = "<a href='javascript:editDialog($data);'class='btn btn-primary mr-1' title='edit'><i class='mdi mdi-pencil nolink'></i></a>&nbsp;".
                 "<a href='javascript:deleteDialog($element->id);' class='btn btn-gray confirm-delete'  title='delete'><i class='mdi mdi-delete nolink'></i></a>";

            $dataArray[] = $sub_array;
        }

        return send_ajax_and_exit(["data" => $dataArray]);
    }
    public function getProjects()
    {
        $projects = $this->project_model->getAll();
        //print_r($projects);die();
        $data_events = array();

        foreach($projects->result() as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "name" => $r->name,               
                "project_code" => $r->project_code
            );
        }

     echo json_encode($data_events);
     exit();
       
    }
    public function getManagers()
    {
        $projects = $this->users_model->getUserByRole();
        //print_r($projects);die();
        $data_events = array();

        foreach($projects->result() as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "name" => $r->firstname   
               
            );
        }

     echo json_encode($data_events);
     exit();
       
    }

    public function fetch() {
        $this->auth->checkIfOperationIsAllowed('list_projects');
        //echo 'test';die();
        $data = $this->project_model->getAll();
        //echo json_encode($data->result());die();
        $output = '
        <h3 align="center">Total Data - '.$data->num_rows().'</h3>
        <table class="table table-striped table-bordered" id="projects">
        <tr>
            <th>ID</th>
            <th>Project code</th>
            <th>Name</th>
            <th>Location</th>
            <th>Manager ID</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Other</th>
        </tr>
        ';
        foreach($data->result() as $row)
        {
        $output .= '
        <tr>
            <td>'.$row->id.'</td>
            <td>'.$row->project_code.'</td>
            <td>'.$row->name.'</td>
            <td>'.$row->location.'</td>
            <td>'.$row->manager_id.'</td>
            <td>'.$row->start_date.'</td>
            <td>'.$row->end_date.'</td>
            <td>'.$row->other_details.'</td>
        </tr>
        ';
        }
        $output .= '</table>';
        echo $output;
    }

    public function import()  {
        //echo $_FILES["file"]["name"];die();
        $this->auth->checkIfOperationIsAllowed('list_projects');
        if(isset($_FILES["file"]["name"]))
        {
            $path = $_FILES["file"]["tmp_name"];
            require_once APPPATH . "/third_party/PHPExcel.php";
            $object = PHPExcel_IOFactory::load($path);
            //echo $path;die();
            $allDataInSheet = $object->getActiveSheet()->toArray(null, true, true, true, true, true, true);
            $flag = true;
            $i=0;
            foreach ($allDataInSheet as $value) {
                if($flag){
                     $flag =false;
                    continue;
                }
                $inserdata[$i]['project_code'] = $value['A'];
                $inserdata[$i]['name'] = $value['B'];
                $inserdata[$i]['location'] = $value['C'];
                $inserdata[$i]['manager_id'] = $value['D'];
                $inserdata[$i]['start_date'] = $value['E'];
                $inserdata[$i]['end_date'] = $value['F'];
                $inserdata[$i]['other_details'] = $value['G'];
                $i++;
            }
            
            
            $this->project_model->import($inserdata);
            //print_r($inserdata);
            echo lang('project_import');
        } 
        $this->index();
 }


    public function uploadData(){
        $this->load->library('excel');
        $this->auth->checkIfOperationIsAllowed('list_contracts');
        if ($this->input->post('submit')) {
                  
                  $path = 'uploads/';
                  //echo $path;die();
                  //require_once APPPATH . "/third_party/PHPExcel.php";
                  $config['upload_path'] = $path;
                  $config['allowed_types'] = 'xlsx|xls';
                  $config['remove_spaces'] = TRUE;
                  $this->load->library('upload');
                  $this->upload->initialize($config);            
                  if (!$this->upload->do_upload('file')) {
                      $error = array('error' => $this->upload->display_errors());
                  } else {
                      $data = array('upload_data' => $this->upload->data());
                  }
                  if(empty($error)){
                    if (!empty($data['upload_data']['file_name'])) {
                      $import_xls_file = $data['upload_data']['file_name'];
                  } else {
                      $import_xls_file = 0;
                  }
                  $inputFileName = $path . $import_xls_file;
                  echo $inputFileName; die();
                  try {
                      $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                      $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                      $objPHPExcel = $objReader->load($inputFileName);
                      $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                      $flag = true;
                      $i=0;
                      foreach ($allDataInSheet as $value) {
                        if($flag){
                          $flag =false;
                          continue;
                        }
                        $inserdata[$i]['org_name'] = $value['A'];
                        $inserdata[$i]['org_code'] = $value['B'];
                        $inserdata[$i]['gst_no'] = $value['C'];
                        $inserdata[$i]['org_type'] = $value['D'];
                        $inserdata[$i]['Address'] = $value['E'];
                        $i++;
                      }               
                      $result = $this->import->importdata($inserdata);   
                      if($result){
                        echo "Imported successfully";
                      }else{
                        echo "ERROR !";
                      }             
       
                } catch (Exception $e) {
                     die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                              . '": ' .$e->getMessage());
                  }
                }else{
                    echo $error['error'];
                  }
                  
                  
          }
          $this->load->view('upload');
        }
      
    public function insert()
    {
        $this->auth->checkIfOperationIsAllowed('create_booking');
        $this->project_model->insert();
        echo 'inserted successful !';//lang('project_import');
    
    }
    public function update()
    {
        $id  = $this->input->post('id');
        //print_r("id:".strlen($id));
        if(strlen($id) > 0) {
            $this->auth->checkIfOperationIsAllowed('update_booking');
             $data = $this->project_model->update();
             echo 'updated successful !';//lang('project_import');
        }
        else {
           $this->insert();
        }

        //$this->session->set_flashdata('msg', lang('contract_edit_msg_success'));
        //echo json_encode($data);
       
       
    }
    public function delete($id)
    {

        $this->auth->checkIfOperationIsAllowed('delete_booking');
        return $this->project_model->delete($id);
    }
    public function getManager()
    {

        $this->auth->checkIfOperationIsAllowed('delete_booking');
        return $this->users_model->getUserByRole();
    }

    public function download($fileName = NULL) {   
        if ($fileName) {
         $file = realpath ( "download" ) . "\\" . $fileName;
         // check file exists    
         if (file_exists ( $file )) {
          // get file content
          $data = file_get_contents ( $file );
          //force download
          force_download ( $fileName, $data );
         } else {
          // Redirect to base url
          redirect ( 'project/index');
         }
        }
       }
}
