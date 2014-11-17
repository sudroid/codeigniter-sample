<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

class Reservations_model extends CI_Model {

    private $table = 'Lab_Reservations';

	public function __construct() { 
        parent::__construct(); 
    } 
    
    public function getAvailables() {
        $query_Available = $this->db->get_where($this->table, array('id' => $id));
        return $query_Available->result();
    }
}