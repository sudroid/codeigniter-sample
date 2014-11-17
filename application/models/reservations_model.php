<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

class Reservations_model extends CI_Model {

    private $table = 'Lab_Reservations';

	public function __construct() { 
        parent::__construct(); 
    } 
    
    public function getRoominfo($id) {
        $query = $this->db->select('*')->where('number = '.$id)->get('Lab_Roomrates');
        return $query->result();
    }

    public function getUnavailables() {
    	$this->db->select('COUNT(*) as count');
    	$count = $this->db->get('Lab_Roomrates')->result();
        $query_Unavailable = $this->db->select('date', 'COUNT(*)')->group_by('date')
                                      ->having('COUNT(*) = '.$count[0]->count)->get($this->table);
        return $query_Unavailable->result();
    }

    public function truncate() {
        $this->db->truncate($this->table);
    }

    public function getUnavailablerooms($date1, $date2) {
        $query = $this->db
                 ->select('*')->distinct()
                 ->from($this->table)
                 ->join('Lab_Roomrates', 'Lab_Roomrates.id = Lab_Reservations.room_ID')
                 ->where("date BETWEEN '$date1' AND '$date2'", NULL, FALSE)->get();
        return $query->result();
    }

    public function getAvailablerooms($id) {
        $query = $this->db->select('*')->where('id != '.$id)->get('Lab_Roomrates');
        return $query->result();
    }

    public function addBooking($booking){
        $insert_Query = $this->db->insert($this->table, $booking);
        return $this->db->insert_id();
    }

    public function countRooms(){
        $query = $this->db->select('COUNT(*) as count')->get('Lab_Roomrates');
        return $query->result();
    }
}