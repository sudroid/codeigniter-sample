<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

class Roomrates_model extends CI_Model {

    private $table = 'Lab_Roomrates';

	public function __construct() { 
        parent::__construct(); 
    } 
    
    /**
    *   Get all room information
    */
    public function getAllRoomrates() {
    	$query_ALL = $this->db->get($this->table);
    	return $query_ALL->result();
    }

    /**
    *   Get room information by id
    */
    public function getRoomID($id) {
    	$query_One = $this->db->get_where($this->table, array('id' => $id));
    	return $query_One->result();
    }

    /**
    *   Add room information into database
    */
    public function addRoom($room){
		$insert_Query = $this->db->insert($this->table, $room);
        return $this->db->insert_id();
    }

    /**
    *   Update room information
    */
    public function updateRoom($id, $room)
    {
    	$update_Query = $this->db->where('id', $id);
    	$this->db->update($this->table, $room);
    }

    /**
    *   Delete room from database
    */
    public function deleteRoom($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}