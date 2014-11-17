<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Areservations extends CI_Controller {

	public function __construct() 
	{
		parent::__construct(); 
		if(!$this->ion_auth->logged_in())
	    {
	    	if (!$this->ion_auth->is_admin()) {
		      redirect(base_url() . 'index.php?/auth/login');
		    }
	    }
		$this->load->library('session');
		$this->load->model('Areservations_model');
		$prefs = array (
               'show_next_prev'  => TRUE,
               'next_prev_url'   => 'index.php?/areservations/calendar'
             );
		$prefs['template'] = '

		   {table_open}<table border="0" cellpadding="5" cellspacing="5" width="650px" height="350px">{/table_open}

		   {heading_row_start}<tr>{/heading_row_start}

		   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

		   {heading_row_end}</tr>{/heading_row_end}

		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td>{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}

		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td>{/cal_cell_start}

		   {cal_cell_content}<span style="color:red">{day}</span><br/><a href="#" id="{day}">( {content} )</a>{/cal_cell_content}
		   {cal_cell_content_today}<span style="font-weight:bold;color:red">{day}</span><br /><a href="#" id="{day}">( {content} )</a>{/cal_cell_content_today}

		   {cal_cell_no_content}{day} <br/>( 0 ){/cal_cell_no_content}
		   {cal_cell_no_content_today}<span style="font-weight:bold">{day}</span> <br/>( 0 ){/cal_cell_no_content_today}

		   {cal_cell_blank}&nbsp;{/cal_cell_blank}

		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}

		   {table_close}</table>{/table_close}
		';
		
		$cal_data[0] = ""; 
		$current_date = getdate();
		$this->session->set_userdata(
        		array(
        				'calendarYear' => $current_date['year'],
        				'calendarMonth'	 => $current_date['mon']
        			)
		);

		if ($this->router->method  == 'calendar') {
            $this->session->set_userdata( 
                array('calendarYear'     =>  $this->uri->segment(3) , 
                      'calendarMonth'     =>     $this->uri->segment(4)   )); 
        }   

        $day_contents = $this->Areservations_model->getRoomfilled();

        foreach ($day_contents as $dates) {
        	$d = strtotime($dates->date);
			list($year, $month, $day) = explode("-", date("Y-m-j", $d));
			if ($this->session->userdata('calendarMonth') == $month && $this->session->userdata('calendarYear') == $year) {
				$cal_data[$day] = $dates->count;
			}
		}
		$this->load->library('calendar',  $prefs);  
		$this->TPL['calendar']=$this->calendar->generate( $this->session->userdata('calendarYear'), 
       		 					   $this->session->userdata('calendarMonth'), 
       		 					   $cal_data);
	}

	public function index()
	{	
		$this->template->show('admin_reservations', $this->TPL);
	}

	public function calendar() {
		$cal_data[0] = ""; 
        $day_contents = $this->Areservations_model->getRoomfilled();

		foreach ($day_contents as $dates) {
        	$d = strtotime($dates->date);
			list($year, $month, $day) = explode("-", date("Y-m-j", $d));
			if ($this->session->userdata('calendarMonth') == $month && $this->session->userdata('calendarYear') == $year) {
				$cal_data[$day] = $dates->count;
			}
		}

		$this->TPL['calendar'] = $this->calendar->generate( $this->session->userdata('calendarYear'), 
       		 					   $this->session->userdata('calendarMonth'), 
       		 					   $cal_data);
		$this->template->show('admin_reservations', $this->TPL);
	}

	public function roomlist(){
		$this->TPL['rooms_list'] = $this->Areservations_model->getRoomList($this->input->post('selected_date'));
		echo json_encode($this->TPL);
	}

	public function roominfo(){
		$this->TPL['rooms_info'] = $this->Areservations_model->getRoomInfo($this->input->post('selected_date'), $this->input->post('first_name'), $this->input->post('last_name'));
		echo json_encode($this->TPL);
	}

	public function printView() 
    {   
	    highlight_file("application/views/admin_reservations.php");
        exit;  
    } 

    /**
	*	Print roomrates controller
	*/
	public function printCtlr() 
	{
		highlight_file('application/controllers/adminReservations.php'); 
        exit;
	}

}