<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservations extends CI_Controller {

	public function __construct() 
	{
		parent::__construct(); 

		$this->load->library('form_validation');
		$this->load->library('session');

		$prefs = array (
               'show_next_prev'  => TRUE,
               'next_prev_url'   => 'index.php?/reservations/calendar'
             );
		$prefs['template'] = '

		   {table_open}<table border="0" cellpadding="2" cellspacing="2" width="300px">{/table_open}

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

		   {cal_cell_content}<div class="red">{day}</div>{/cal_cell_content}
		   {cal_cell_content_today}<div class="red"><span style="font-weight:bold">{day}</span></div>{/cal_cell_content_today}

		   {cal_cell_no_content}<div class="green">{day}<div class="green">{/cal_cell_no_content}
		   {cal_cell_no_content_today<div class="green">}<span style="font-weight:bold">{day}</span></div>{/cal_cell_no_content_today}

		   {cal_cell_blank}&nbsp;{/cal_cell_blank}

		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}

		   {table_close}</table>{/table_close}
		';
		$this->load->library('calendar',  $prefs);  

		$this->load->model('roomrates_model');
		$this->load->model('reservations_model');
		
		$this->load->helper('asset_helper');
		$this->load->helper('form');

		if ($this->router->method  == 'calendar') {
            $this->session->set_userdata( 
                array('calendarYear'     =>  $this->uri->segment(3) , 
                      'calendarMonth'     =>     $this->uri->segment(4)   )); 
        }               
        $unavailable_dates = $this->reservations_model->getUnavailables();
        if ($unavailable_dates != null) 
    	{
	    		foreach ($unavailable_dates as $dates) {
	        	$d = strtotime($dates->date);
				list($year, $month, $day) = explode("-", date("Y-m-j", $d));
				$cal_data[$day] = "";
			}
		}
		else {
			$cal_data[0] = "";
		}
        $this->TPL['calendar']=$this->calendar->generate( $this->session->userdata('calendarYear'), 
       		 					   $this->session->userdata('calendarMonth'), 
       		 					   $cal_data);
        $this->stripe = array(
            "secret_key"      => "sk_test_PQuOLMsE82XttXQAFdREGmur",
            "publishable_key" => "pk_test_lQTVJgx88qykSAnwPFpVYy1Z"
        );
        $this->TPL['year_options'] =array(
        				'0'		=> '',
						'2014'  => '2014',
						'2015'  => '2015',
						'2016'  => '2016',
						'2017'  => '2017',
						'2018'  => '2018',
						'2019'  => '2019'
					);
    	$this->TPL['month'] = array();
    	for($counter = 1;$counter <= 12; $counter++){ 
    		$this->TPL['month_options'][0] = "";
    		$this->TPL['month_options'][$counter] = $counter;
    	}
	}
	
	public function index()
	{	
		$this->session->sess_destroy();
		$unavailable_dates = $this->reservations_model->getUnavailables();
		$this->TPL['unavailable_dates'] = $unavailable_dates;
		$this->template->show('reservations1', $this->TPL);
	}

	public function refresh() {
		$this->reservations_model->truncate();
		redirect('index.php?/reservations', 'refresh');
	}

	public function calendar() {
		if ($this->router->method  == 'calendar') {
            $this->session->set_userdata( 
                array('calendarYear'     =>  $this->uri->segment(3) , 
                      'calendarMonth'     =>     $this->uri->segment(4)   )); 
        }
        $unavailable_dates = $this->reservations_model->getUnavailables();
        $cal_data[0]="";
        foreach ($unavailable_dates as $dates) {
			list($year, $month, $day) = explode("-", $dates->date);
			if ($year == $this->session->userdata('calendarYear') && $month == $this->session->userdata('calendarMonth')) { 
				$cal_data[$day] = "";
			}
		}
		$this->TPL['calendar'] = $this->calendar->generate( $this->session->userdata('calendarYear'), 
       		 					   $this->session->userdata('calendarMonth'), 
       		 					   $cal_data);
		$this->template->show('reservations1', $this->TPL);
	}

	public function selectDates($act){ 

        if ($act == 'continue') {
            if (empty($_POST['arrivalDate']) || empty($_POST['departureDate'])) {
                //formerror 
                $this->TPL['error_msg'] = '<p class="ink-label red">Please select dates for your arrival and departure.</p>'; 
                $pageView = '1'; 
            }
            else {
            	$arrivalDate = date_create($_POST['arrivalDate']); 
            	$departureDate = date_create($_POST['departureDate']);
            	$diff = date_diff($arrivalDate, $departureDate);
            	$this->TPL['duration'] = $diff->format('%d');
            	$this->TPL['arrivalDate'] = $arrivalDate->format( 'M d, Y' );
            	$this->TPL['departureDate'] = $departureDate->format( 'M d, Y' );

            	$unavailable_rooms = $this->reservations_model->getUnavailablerooms($_POST['arrivalDate'], $_POST['departureDate']);
            	// $i=0;
            	// foreach ($unavailable_rooms as $rooms) {
            	// 	$room_arr[$i++] = array( $rooms->id, $rooms->date);
            	// }
            	
            	if ($unavailable_rooms != null) { 
					$this->TPL['unavailable_rooms'] = $unavailable_rooms;
				}
				else {
					$this->TPL['unavailable_rooms'] = "";
				}
				$count = $this->reservations_model->countRooms();
				if ($unavailable_rooms != null) { 
					if( $count[0]->count == count($unavailable_rooms) ){
						$available_rooms = '';
					}
					else {
						foreach ($unavailable_rooms as $room) {
							$available_rooms = $this->reservations_model->getAvailablerooms($room->id);
						}
					}
				}
				else {
					$available_rooms = $this->reservations_model->getAvailablerooms(0);
				}
				$this->TPL['available_rooms'] = $available_rooms;
		
				if ($this->router->method  == 'selectDates') {
		            $this->session->set_userdata( 
		                array('arrivalDate'    		 	=> $arrivalDate->format( 'M d, Y' ), 
		                      'departureDate'			=> $departureDate->format( 'M d, Y' ),
		                      'duration' 				=> $diff->format('%d'),
		                      'unavailable_rooms' 		=> $unavailable_rooms,
		                      'available_rooms' 		=> $available_rooms 
		                      )
		            ); 
		        } 
		        
                $pageView = '2'; 
            } 
        }

        if ($act == 'jumpTo') {   
        	$this->TPL['arrivalDate'] = date("Y-m-j", strtotime($this->session->userdata('arrivalDate')));
        	$this->TPL['departureDate'] = date("Y-m-j", strtotime($this->session->userdata('departureDate')));
        	$pageView = '1'; 
        }

        $this->template->show('reservations'.$pageView, $this->TPL);
    } 

    public function roomsRates($act){
        if ($act == 'continue') { 
        	$pageView = '3' ;
        	$this->template->show('reservations'.$pageView, $this->TPL);
        }
        if ($act == 'jumpTo') {
        	$this->TPL['duration'] = $this->session->userdata('duration');
        	$this->TPL['arrivalDate'] = $this->session->userdata('arrivalDate');
        	$this->TPL['departureDate'] = $this->session->userdata('departureDate');
        	$this->TPL['unavailable_rooms'] = $this->session->userdata('unavailable_rooms');
        	$this->TPL['available_rooms'] = $this->session->userdata('available_rooms');
        	$pageView = '2'; 
        	$this->template->show('reservations'.$pageView, $this->TPL);
        }    
        if ($act == 'pickRoom') {
        	$this->TPL['duration'] = $this->session->userdata('duration');
        	$this->TPL['arrivalDate'] = $this->session->userdata('arrivalDate');
        	$this->TPL['departureDate'] = $this->session->userdata('departureDate');
        	$this->TPL['unavailable_rooms'] = $this->session->userdata('unavailable_rooms');
        	$this->TPL['available_rooms'] = $this->session->userdata('available_rooms');
        	$this->TPL['selected_room'] = $this->reservations_model->getRoominfo($this->input->post('room_number'));
        	$pageView = '2';  
        	echo json_encode($this->TPL);
        } 
    } 

    public function confirmation($act){ 
        if ($act == 'continue') { 
        	$room_number = $this->input->post('room_number');
        	if ( $room_number != "" ) {
	        	$this->TPL['duration'] = $this->session->userdata('duration');
		    	$this->TPL['arrivalDate'] = $this->session->userdata('arrivalDate');
		    	$this->TPL['departureDate'] = $this->session->userdata('departureDate');
		    	$this->TPL['selected_room'] = $this->reservations_model->getRoominfo($room_number);
		    	$this->session->unset_userdata('unavailable_rooms');
	    	$this->session->unset_userdata('available_rooms');
		    	$this->session->set_userdata('selected_room_number',  $room_number);
	        	$pageView = '3' ;
	        }
	        else {
	        	$this->TPL['error_msg'] = '<p class="ink-label red">Please select a room.</p>'; 
	        	$pageView = '2' ;
	        }	
        }
        if ($act == 'jumpTo') {
        	$pageView = '2'; 
        }    
        $this->template->show('reservations'.$pageView, $this->TPL);
    } 

	public function finalPayment($act){ 
        if ($act == 'continue') {
        	$this->form_validation->set_rules('first_name', 'FirstName', 'required');
        	$this->form_validation->set_rules('last_name', 'LastName', 'required');
        	$this->form_validation->set_rules('email', 'Email', 'required');
        	$this->form_validation->set_rules('card_name', 'CardName', 'required');
        	$this->form_validation->set_rules('card_type', 'CardType', 'required');
        	$this->form_validation->set_rules('card_number', 'CardNumber', 'required');
        	$this->form_validation->set_rules('expiry_month', 'ExpiryMonth', 'required|is_natural_no_zero');
        	$this->form_validation->set_rules('expiry_year', 'ExpiryYear', 'required|is_natural_no_zero');
        	$this->form_validation->set_rules('sec_code', 'SecurityCode', 'required');
        	$this->TPL['error_msg'] = '<p class="ink-label red">Please fill in all fields.</p>';
    		$this->TPL['duration'] = $this->session->userdata('duration');
	    	$this->TPL['arrivalDate'] = $this->session->userdata('arrivalDate');
	    	$this->TPL['departureDate'] = $this->session->userdata('departureDate');
	    	$this->TPL['selected_room'] = $this->reservations_model->getRoominfo($this->session->userdata('selected_room_number'));

	    	
        	if ($this->form_validation->run() == FALSE){
				$pageView = '3' ;
			}
			else{
				if($_POST){ 
					$arrivalDate=strtotime($this->session->userdata('arrivalDate'));
					$departureDate=strtotime($this->session->userdata('departureDate'));
					$room_id = $this->TPL['selected_room'];
					while ($arrivalDate <  $departureDate) {
						$booking = array(
								'date' 			=> date("Y-m-j", $arrivalDate),
								'room_ID' 		=> $room_id[0]->id,
								'first_name' 	=> $this->input->post('first_name'),
								'last_name' 	=> $this->input->post('last_name'),
								'email'			=> $this->input->post('email')
							);
			            $this->reservations_model->addBooking($booking);
			            $arrivalDate = strtotime("+1 day", $arrivalDate);
					}
		            $return = $this->db->affected_rows();
		            if($return == 0)
		            {
						die('error updating the record. '. $return .' rows affeced.');
					}
					$this->TPL['name'] = $this->input->post('first_name') . " " . $this->input->post('last_name');
					$this->TPL['email'] = $this->input->post('email');
					$this->TPL['card_name'] = $this->input->post('card_name');
					$this->TPL['card_type'] =  $this->input->post('card_type');
					$this->TPL['card_number'] =  $this->input->post('card_number');
					$this->TPL['expiry_month'] =  $this->input->post('expiry_month');
					$this->TPL['expiry_year'] =  $this->input->post('expiry_year');
					$this->TPL['sec_code'] =  $this->input->post('sec_code');

					$this->session->set_userdata('name', $this->TPL['name']);
					$this->session->set_userdata('card', $this->TPL['card_name'].' '.$this->TPL['card_type']);
					$this->session->set_userdata('email', $this->TPL['email']);

					if(ENVIRONMENT=='localhost2') {
						require_once('vendor/stripe/lib/Stripe.php');
					}
					else {
						require_once('/home/students/000277970/public_html/10125/lab01/vendor/stripe/lib/Stripe.php');
					}
					try {
						Stripe::setApiKey($this->stripe['secret_key']);

						$card['number'] = $this->TPL['card_number'];
						$card['expiry_month'] = $this->TPL['expiry_month'];
						$card['expiry_year'] = $this->TPL['expiry_year'];
	 					$customer = Stripe_Customer::create(array(
						    'email' => $this->TPL['email'],
						    'card'  => $card
						));
	 					$charge = Stripe_Charge::create(array(
						    'customer' => $customer->id,
						    'amount'   => $this->TPL['selected_room'][0]->rate, 
						    'currency' => 'cad'
						));
					} 
					catch (Stripe_CardError $e) {
						echo "error";
					}
					$pageView = '4';
				}
			}
        }
        if ($act == 'jumpTo') {
        	$pageView = '3'; 
        }    
        $this->template->show('reservations'.$pageView, $this->TPL);
    } 

    public function thanks() {
    	$this->TPL['selected_room'] = $this->reservations_model->getRoominfo($this->session->userdata('selected_room_number'));
    	$this->TPL['success_message'] = '<h1>Successfully charged $'.($this->TPL['selected_room'][0]->rate).'!</h1>';
    	$this->template->show('reservations_success', $this->TPL);
    }

    public function bookingPdf() {
    	$this->TPL['selected_room'] = $this->reservations_model->getRoominfo($this->session->userdata('selected_room_number'));
    	$this->load->library("Pdf");
    	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator("Susan Chan");
		$title = "Booking Receipt";
		$pdf->SetTitle($title);
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont('helvetica');
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetFont('helvetica', '', 9);
		$pdf->setFontSubsetting(false);
		$pdf->AddPage();
		$content = " 
			<h1>Booking Information</h1>
			<p>Thank you for choosing Salt Kettle House, ".$this->session->userdata('name')."!<p>
			<p>Here are the information for the booking you have just paid for!</p>
			<ul>
				<li>Your arrival date is: ".$this->session->userdata('arrivalDate')."</li>
				<li>Your departure date is: ".$this->session->userdata('departureDate') ."</li>
				<li>You will be staying for: ".$this->session->userdata('duration') ."</li>
				<li>The room you have paid for is:<br/>
					Room ".$this->TPL['selected_room'][0]->number." - ".$this->TPL['selected_room'][0]->name."</li>
				<li>The cost that has been charged is: $".$this->TPL['selected_room'][0]->rate ."</li>	
				<li>The charged to: ".$this->session->userdata('card')."</li>	
			</ul>
			<p>Happy stay!</p>
		";
		$pdf->writeHTML($content, true, false, true, false, '');
		$pdf->Output('receipt.pdf', 'I');
		$this->session->sess_destroy();
    }
	/**
	*	Print roomrates controller
	*/
	public function printCtlr() 
	{
		highlight_file('application/controllers/reservations.php'); 
        exit;
	}
	
	/**
	*	Print roomrates view
	*/
	public function printView($view) 
    {      
    	$view_array = array(  
	        		'1' =>	'application/views/reservations1.php',
	        		'2' =>	'application/views/reservations2.php',
	        		'3' =>	'application/views/reservations3.php', 
	        	 	'4' =>	'application/views/reservations4.php',
	        	 	'success' => 'application/views/reservations_success.php'
	        	);
	    highlight_file($view_array[$view]);
        exit;  
    } 

	/**
	*	Print roomrates model
	*/
    public function printModel() 
    {      
        highlight_file('application/models/reservations_model.php'); 
        exit;  
    } 
}