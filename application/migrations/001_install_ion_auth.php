<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_ion_auth extends CI_Migration {

	public function up()
	{
		// Drop table 'groups' if it exists		
		$this->dbforge->drop_table('groups');

		// Table structure for table 'groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('groups');

		// Dumping data for table 'groups'
		$data = array(
			array(
				'id' => '1',
				'name' => 'frontdesk',
				'description' => 'Has access to RESERVATIONS'
			),
			array(
				'id' => '2',
				'name' => 'manager',
				'description' => 'Has access to RESERVTIONS and ROOMS & RATES'
			),
			array(
				'id' => '3',
				'name' => 'owner',
				'description' => 'Has access to RESERVTIONS and ROOMS & RATES and SYSTEM'
			)
		);
		$this->db->insert_batch('groups', $data);


		// Drop table 'users' if it exists
		$this->dbforge->drop_table('users');

		// Table structure for table 'users'
		$this->dbforge->add_field(array(
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '80',
			),
			'role' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users');

		// Dumping data for table 'users'
		$data = array(
			0 => array(
				'username' => 'frontdesk',
				'password' => 'frontdesk',
				'role' => 'frontdesk'
			),
			1 => array(
				'username' => 'manager',
				'password' => 'manager',
				'role' => 'manager'
			),
			2 => array(
				'username' => 'owner',
				'password' => 'owner',
				'role' => 'owner'
			)
		);
		$this->db->insert('users', $data);


		// Drop table 'users_groups' if it exists		
		$this->dbforge->drop_table('users_groups');

		// Table structure for table 'users_groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users_groups');

		// Dumping data for table 'users_groups'
		$data = array(
			array(
				'id' => '1',
				'user_id' => '1',
				'group_id' => '1',
			),
			array(
				'id' => '2',
				'user_id' => '2',
				'group_id' => '2',
			),
			array(
				'id' => '3',
				'user_id' => '3',
				'group_id' => '3',
			)
		);
		$this->db->insert_batch('users_groups', $data);

	}

	public function down()
	{
		$this->dbforge->drop_table('users');
		$this->dbforge->drop_table('groups');
		$this->dbforge->drop_table('users_groups');
	}
}
