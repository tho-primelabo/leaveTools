<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This Class contains all the business logic and the persistence layer for the status of leave request.
 */
class Contracttypes_model extends CI_Model
{
    public $table = 'contract_types';

    public function __construct()
    {
        parent::__construct();
    }

    public function getContractTypes($id = 0)
    {
        if ($id === 0) {
            $query = $this->db->get($this->table);
            return $query->result_array();
        }
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }

	public function setContractTypes() {
        //$deduct = ($this->input->post('deduct_days_off') == 'on')?TRUE:FALSE;
        $data = array(
            'alias' => $this->input->post('alias'),
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description')
        );
        return $this->db->insert($this->table, $data);
    }
    public function updateContractTypes($id, $name, $alias, $description)
    {
        $data = array(
            'name' => $name,
            'alias' => $alias,
            'description' => $description
        );
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function getTypeByName($name)
    {
        $query = $this->db->get_where($this->table, array('name' => $name));
        return $query->row_array();
    }

    public function getTypesAsArray($id = 0)
    {
        $listOfTypes = array();
        $this->db->from($this->table);
        $this->db->order_by('name');
        $rows = $this->db->get()->result_array();
        foreach ($rows as $row) {
            $listOfTypes[$row['id']] = $row['name'];
        }
        return $listOfTypes;
    }

    public function getName($id)
    {
        $type = $this->getTypes($id);
        return $type['name'];
    }

    public function getDesciption($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query['description'];
    }
}
