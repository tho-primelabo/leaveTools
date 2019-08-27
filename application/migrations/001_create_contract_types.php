<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_contract_types extends CI_Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'contract_types';

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'alias' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($this->set_schema_table);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->set_schema_table);
    }
}
