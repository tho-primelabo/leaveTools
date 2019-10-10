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
        $query = $this->db->get('salary');
        //echo json_encode($query);die();
        return $query->row_array();
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
        $salary = $this->getPayslipByDate($id, $curDate);
        return $salary['date'];
    }
    public function getSalaryIDByUserIdnCurDate($id, $curDate) {
        $salary = $this->getPayslipByDate($id, $curDate);
        return $salary['salary_id'];
    }
    
    /**
     * Insert a new payslip. Data are taken from HTML form.
     * @return int number of affected rows
     * @author Tho Le <thole419@gmail.com>
     */
    public function create() {
        $userid = $this->input->post('userid');
		$sal = (double)$this->input->post('salary');
		$chkIncludedIns = (int)$this->input->post('chkIncludedIns');
		$txtNumberOfDep = (int)$this->input->post('txtNumberOfDep');
        $curDate = date('Y-m-d'); 
		//print_r($this->session->userdata); die();
        
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
    public function updateTypes($id, $name, $deduct, $acronym) {
        $deduct = ($deduct == 'on')?TRUE:FALSE;
        $data = array(
            'acronym' => $acronym,
            'name' => $name,
            'deduct_days_off' => $deduct
        );
        $this->db->where('id', $id);
        return $this->db->update('types', $data);
    }
    
    /**
     * Count the number of time a leave type is used into the database
     * @param int $id identifier of the leave type record
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function usage($id) {
        $this->db->select('COUNT(*)');
        $this->db->from('leaves');
        $this->db->where('type', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['COUNT(*)'];
    }
    public function CalcuateNETSalary($userid, $salaryGross, $txtNumberOfDep, $chkIncludedIns, $curDate) {
        $social_insurance = ($salaryGross * 0.08);
        $health_insurance = ($salaryGross * 0.015);
        $unEmployment_insurance = ($salaryGross*0.01);
        
        if ($chkIncludedIns == 0) {
            $unEmployment_insurance = 0;
        }
        $income_before_tax = $salaryGross - ($social_insurance + $health_insurance + $unEmployment_insurance);
        $peson_tax_payer = $txtNumberOfDep*3600000;
        if ($income_before_tax < 0) {
            $income_before_tax = 0;
        }
         $personal_income_tax = 0;
        $taxable_incom = $income_before_tax - (9000000 + $peson_tax_payer);
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
            'salary_net'  => $income_before_tax - $personal_income_tax,
			'salary_other'=> $salary_other);
           // print_r($data); echo $data ;die();
        $date = $this->getDateByUserIdnCurDate($userid, $curDate);
        //echo $date; die();
        if (isset($date)) {

            $this->db->where('date', $date);
            $this->db->where('employee_id', $userid);
            $this->db->update('salary', $data);
            return $this->getSalaryIDByUserIdnCurDate($userid, $curDate);
        }
        else {
            $this->db->insert('salary', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }
    }
}
