<?php
/**
 * This Class contains all the business logic and the persistence layer for the status of leave request.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.7.0
 */

if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This Class contains all the business logic and the persistence layer for the status of leave request.
 */
class Contract_Types_model extends CI_Model {

    /**
     * Default constructor
     * @author Emilien NICOLAS <milihhard1996@gmail.com>
     */
    public function __construct() {

    }

    /**
     * Get the list of types or type
     * @param int $id optional id of a type
     * @return array record of types
     * @author Emilien NICOLAS <milihhard1996@gmail.com>
     */
    public function getTypes($id = 0) {
        if ($id === 0) {
            $query = $this->db->get('contract_types');
            return $query->result_array();
        }
        $query = $this->db->get_where('types', array('id' => $id));
        return $query->row_array();
    }

    /**
     * Get the list of types or type
     * @param string $name type name
     * @return array record of a contract type
     * @author Emilien NICOLAS <milihhard1996@gmail.com>
     */
    public function getTypeByName($name) {
        $query = $this->db->get_where('contract_types', array('name' => $name));
        return $query->row_array();
    }

    /**
     * Get the list of status as an ordered associative array
     * @return array Associative array of types (id, name)
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function getTypesAsArray($id = 0) {
        $listOfTypes = array();
        $this->db->from('contract_types');
        $this->db->order_by('name');
        $rows = $this->db->get()->result_array();
        foreach ($rows as $row) {
            $listOfTypes[$row['id']] = $row['description'];
        }
        return $listOfTypes;
    }

    /**
     * Get the name of a given status id
     * @param int $id ID of the status
     * @return string label of the status
     * @author Emilien NICOLAS <milihhard1996@gmail.com>
     */
    public function getName($id) {
        $type = $this->getTypes($id);
        return $type['name'];
    }
	
	public function getDesciption($id) {        
        $query = $this->db->get_where('contract_types', array('id' => $id));
        return $query['description'];
    }
}
