<?php
/**
 * This Class contains all the business logic and the persistence layer for the types of leave request.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.4.0
 */

if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This Class contains all the business logic and the persistence layer for the types of leave request.
 */
class Payslip_model extends CI_Model {

    /**
     * Default constructor
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function __construct() {
        
    }

    /**
     * Get the list of types or one type
     * @param int $id optional id of a type
     * @return array record of types
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function getPayslip($id = 0) {
        if ($id === 0) {
            $query = $this->db->get('salary');
            return $query->result_array();
        }
        $query = $this->db->get_where('salary', array('salary_id' => $id));
        return $query->row_array();
    }

    public function getPayslipByDate($id = 0, $date) {
        /*
        $query = $this->db->get_where('salary', array('employee_id' => $id,
                                                      "DATE_FORMAT(date, '%Y-%m')="=> "DATE_FORMAT($date, '%Y-%m')"));*/
        $this->db->where('employee_id', $id);
        $this->db->where( "DATE_FORMAT(date, '%Y-%m')= DATE_FORMAT('$date', '%Y-%m')");
        $this->db->group_by('employee_id');
        $query = $this->db->get('salary');
        //echo json_encode($query);die();
        return $query->result_array();
    }
    
    public function getRowPayslipByDate($id = 0, $date) {
        /*
        $query = $this->db->get_where('salary', array('employee_id' => $id,
                                                      "DATE_FORMAT(date, '%Y-%m')="=> "DATE_FORMAT($date, '%Y-%m')"));*/
        $this->db->where('employee_id', $id);
        $this->db->where( "DATE_FORMAT(date, '%Y-%m')= DATE_FORMAT('$date', '%Y-%m')");
        $this->db->group_by('employee_id');
        $query = $this->db->get('salary');
        //echo json_encode($query);die();
        return $query->row_array();
    }
     public function getRowPayslipHistoryByDate($id = 0, $date) {
        /*
        $query = $this->db->get_where('salary', array('employee_id' => $id,
                                                      "DATE_FORMAT(date, '%Y-%m')="=> "DATE_FORMAT($date, '%Y-%m')"));*/
        $this->db->where('employee_id', $id);
        $this->db->where( "DATE_FORMAT(date, '%Y-%m')= DATE_FORMAT('$date', '%Y-%m')");
        //$this->db->group_by('employee_id');
        $query = $this->db->get('salary_history');
        //echo json_encode($query);die();
        return $query;
    }
      public function getResultPayslipByDate($id = 0, $date) {
        /*
        $query = $this->db->get_where('salary', array('employee_id' => $id,
                                                      "DATE_FORMAT(date, '%Y-%m')="=> "DATE_FORMAT($date, '%Y-%m')"));*/
        $this->db->where('employee_id', $id);
        $this->db->where( "DATE_FORMAT(date, '%Y-%m')= DATE_FORMAT('$date', '%Y-%m')");
        $this->db->group_by('employee_id');
        $query = $this->db->get('salary');
        //echo json_encode($query);die();
        return $query->result_array();
    }
    /**
     * Get the list of types or one type
     * @param string $name type name
     * @return array record of a leave type
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function getTypeByName($name) {
        $query = $this->db->get_where('types', array('name' => $name));
        return $query->row_array();
    }
    
    /**
     * Get the list of types as an ordered associative array
     * @return array Associative array of types (id, name)
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function getTypesAsArray($id = 0) {
        $listOfTypes = array();
        $this->db->from('types');
        $this->db->order_by('name');
        $rows = $this->db->get()->result_array();
        foreach ($rows as $row) {
            $listOfTypes[$row['id']] = $row['name'];
        }
        return $listOfTypes;
    }
    
    /**
     * Get the name of a given type id
     * @param int $id ID of the type
     * @return string label of the type
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function getName($id) {
        $type = $this->getTypes($id);
        return $type['name'];
    }
    
    public function getDateByUserIdnCurDate($id, $curDate) {
        $salary = $this->getRowPayslipByDate($id, $curDate);
        //echo json_encode($salary['date']);die();
        return $salary['date'];
    }
    public function getSalaryIDByUserIdnCurDate($id, $curDate) {
        $salary = $this->getRowPayslipByDate($id, $curDate);
        return $salary;//['salary_id'];
    }

     public function getAllSalByUserIdNFromDateToDate($id, $fromDate = 0, $toDate = 0) {
       //echo $id; echo $fromDate; echo $toDate ;die();
        if ($fromDate == 0 && $toDate == 0) {
            return $this->getSalaryByUserId($id);
        }
        else if ($fromDate != 0 && $toDate == 0) {
            //echo $id; echo $fromDate; echo $toDate; die();
             return $this->getPayslipByDate($id, $fromDate);
        }
        else if ($fromDate == 0 && $toDate != 0) {
             echo $id; echo $fromDate; echo $toDate ;die();
            return $this->getPayslipByDate($id, $toDate);
        }
        //return $salary->result_array();
    }
    
    /**
     * Insert a new payslip. Data are taken from HTML form.
     * @return int number of affected rows
     * @author Tho Le <thole419@gmail.com>
     */
    public function create($curDate = 0) {
        $userid = $this->input->post('userid');
		$sal = (double)$this->input->post('salary');
		$chkIncludedIns = (int)$this->input->post('chkIncludedIns');
		$txtNumberOfDep = (int)$this->input->post('txtNumberOfDep');
        if ($curDate == 0) {
            $curDate = date('Y-m-d'); 
        }
		//print_r($curDate); die();
        
        return $this->CalcuateNETSalary($userid, $sal, $txtNumberOfDep, $chkIncludedIns, $curDate);
       // find userid and date

      // echo $personal_income_tax;
		
    }
    
    /**
     * Delete a leave type from the database
     * @param int $id identifier of the leave type
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function deleteSalary($id) {
        $this->db->delete('salary', array('salary_id' => $id));
    }
    
    /**
     * Update a given leave type in the database.
     * @param int $id identifier of the leave type
     * @param string $name name of the type
     * @param bool $deduct Deduct days off
     * @param string $acronym Acronym of leave type
     * @return int number of affected rows
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function update($uid, $salary, $salary_net, $numDependant, $date) {
        $data = array(            
            'salary_basic'=>$salary,
            'salary_net' => $salary_net,
            'number_dependant' => $numDependant
        );
        $this->db->where('id', $uid);
        $this->db->where( "DATE_FORMAT(date, '%Y-%m')= DATE_FORMAT('$date', '%Y-%m')");
        $result = $this->db->update('salary', $data);
        return $result;
    
    }
    
    /**
     * Count the number of time a leave type is used into the database
     * @param int $id identifier of the leave type record
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function getSalaryByUserId($id) {
        $this->db->select('*');
        //$this->db->from('salary');
        $this->db->where('employee_id', $id);
        $this->db->order_by("date", "desc");
        $query = $this->db->get('salary');
        //echo json_encode($query); die();
        $result = $query->result_array();
        
        return $result;
    }
    public function CalcuateNETSalary($userid, $salaryGross, $txtNumberOfDep, $chkIncludedIns, $curDate) {
        $social_insurance = ($salaryGross * (LMS_SOCIAL_INSURANCE/100));
        $health_insurance = ($salaryGross * (LMS_HEALTH_INSURANCE)/100);
        $unEmployment_insurance = ($salaryGross*(LMS_UNEMPLOYMENT_INSURANCE)/100);
        
        if ($chkIncludedIns == 0) {
            $unEmployment_insurance = 0;
        }
        $income_before_tax = $salaryGross - ($social_insurance + $health_insurance + $unEmployment_insurance);
        $peson_tax_payer = $txtNumberOfDep*LMS_TAX_REDUCE_FAMILY;
        if ($income_before_tax < 0) {
            $income_before_tax = 0;
        }
         $personal_income_tax = 0;
        $taxable_incom = $income_before_tax - (LMS_TAX_PERSON + $peson_tax_payer);
         if ($taxable_incom <= 0 ) {
           $taxable_incom = 0;
         }
         else {
            if ($taxable_incom <= 5000000) {
                $personal_income_tax = $taxable_incom * 0.05;
            }
            else if (5000000 < $taxable_incom  && $taxable_incom <= 10000000) {
                $personal_income_tax = ($taxable_incom * 0.1) - 250000;
            }
            else if (10000000 < $taxable_incom && $taxable_incom <= 18000000) {
                $personal_income_tax = ($taxable_incom * 0.15) - 750000;
            }
            else if (18000000 < $taxable_incom && $taxable_incom  <= 32000000) {
                $personal_income_tax = ($taxable_incom * 0.2) - 1650000;
            }
            else if (32000000 < $taxable_incom && $taxable_incom <= 52000000) {
                $personal_income_tax = ($taxable_incom * 0.25) - 3250000;
            }
            else if (52000000 < $taxable_incom && $taxable_incom  <= 80000000) {
                $personal_income_tax = ($taxable_incom * 0.30) - 5850000;
            }
            else if (80000000 < $taxable_incom) {
                $personal_income_tax = ($taxable_incom * 0.35) - 9850000;
            }
         }// end $taxable_incom
       $salary_other = 0;
       $salary_overtime = 0;
       if ($personal_income_tax <= 0){ 
           $personal_income_tax = 0;
       }
       $data = array(
            'employee_id' => $userid,
            'salary_basic' => $salaryGross,
            'date' => $curDate,
            'social_insurance'   => $social_insurance,
			'health_insurance'=> $health_insurance,
            'peson_tax_payer'   => $peson_tax_payer,
			'unEmployment_insurance'=> $unEmployment_insurance,
			'taxable_incom'   => $taxable_incom,
            'unEmployment_insurance'=> $unEmployment_insurance,
            'salary_overtime'   => $salary_overtime,
            'income_before_tax'   => $income_before_tax,
			'personal_income_tax'   => $personal_income_tax,
            'number_dependant' =>$txtNumberOfDep,
            'salary_net'  => $income_before_tax - $personal_income_tax,
			'salary_other'=> $salary_other);
           // print_r($data); echo $data ;die();
        $date = $this->getDateByUserIdnCurDate($userid, $curDate);
        $salary = $this->getSalaryIDByUserIdnCurDate($userid, $curDate);
        //echo date('h:i:s');
        $salary['date'] = $salary['date'].' '.date('h:i:s');
        $this->db->insert('salary_history', $salary);
       // print_r($salary['date']); die();
        if (isset($date)) {

            //$this->db->where('date', $date);
            $this->db->where( "DATE_FORMAT(date, '%Y-%m')= DATE_FORMAT('$curDate', '%Y-%m')");
            $this->db->where('employee_id', $userid);
            
            $query = $this->db->update('salary', $data);
            //print_r($this->db->last_query());die();
            return $salary['salary_id'];
        }
        else {
            $this->db->insert('salary', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }
    }

    public function exportPayslips() {
        //$date = date('Y-m-d');
        $this->db->select('users.id, users.lastname , users.firstname ,
        users.number_dependant , salary_basic, salary.salary_net as salaryNet ');
        $this->db->join('salary', 'salary.employee_id = users.id', 'left');
       
        $this->db->group_by('users.id');
        $this->db->order_by("date", "asc");
        $query = $this->db->get('users');
        //echo json_encode($query);die();
        //$query = $this->db->get_where('users', array('salary.date' => $date));
        return $query->result_array();
    }
}
