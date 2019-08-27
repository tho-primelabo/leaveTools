<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_contract_types extends CI_Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'contract_types';

    public function up()
    {
        $fields = array(
            'alias' => array(
                'name' => 'alias',
                'type' => 'VARCHAR',
                'constraint' => '100' //change
            ),
        );
        $this->dbforge->modify_column($this->set_schema_table, $fields);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->set_schema_table);
    }
}
