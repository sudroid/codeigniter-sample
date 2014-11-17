<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

class Areservations_model extends CI_Model {

	private $table = 'Lab_Reservations';

	public function __construct() { 
        parent::__construct(); 
    } 

    public function getRoomfilled() {
    	$query = $this->db->select('date, COUNT(*) as count')->group_by('date')->get($this->table);
        return $query->result();

//     	SELECT date, COUNT(*) FROM Lab_Reservations GROUP BY date
    }

    public function getUnavailables() {
    	$this->db->select('COUNT(*) as count');
    	$count = $this->db->get('Lab_Roomrates')->result();
        $query_Unavailable = $this->db->select('date, COUNT(*)')->group_by('date')
                                      ->having('COUNT(*) = '.$count[0]->count)->get($this->table);
        return $query_Unavailable->result();
    }

    public function getRoomList($date){
        $query = $this->db->join('Lab_Roomrates', 'Lab_Roomrates.id = Lab_Reservations.room_ID')
                          ->select('number, first_name, last_name, name')->where('date', $date)->get($this->table);
        return $query->result();
    }

    public function getRoomInfo($date, $first_name, $last_name){
        $query = $this->db->join('Lab_Roomrates', 'Lab_Roomrates.id = Lab_Reservations.room_ID')
                          ->select('*')->where(array('date' => $date, 'first_name' => $first_name, 'last_name' => $last_name) )->get($this->table);
        return $query->result();
    }
}