<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function index()
	{	
		$this->load->helper('asset_helper');
		
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'required|callback_contact_name');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('postalcode', 'Postal Code', 'required|callback_postal_code');
		$this->form_validation->set_rules('phone', 'Phone', 'required|callback_phone_number');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('comments', 'Comments', 'required|xss_clean|valid_base64');
		$this->form_validation->set_message('contact_name', 'Name must be two words');
		$this->form_validation->set_message('postal_code', 'Invalid Postal Code');
		$this->form_validation->set_message('phone_number', 'Invalid Phone Number');
		$this->form_validation->set_message('valid_base64', 'Invalid Comment. Please do not put any HTML in the comment section.');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->template->show('contact');
		}
		else
		{
			if($this->send_email($_POST))
			{
				//$error = $this->email->print_debugger();
				$this->template->show('contactsuccess');
			}
		}
	}
	
	public function contact_name($input) 
	{
		if (preg_match( '/^\w{2,}[ ]\w{2,}$/', $input))
		{
			return TRUE;
		}	
		else 
		{
			return FALSE;
		}
	}
	
	public function postal_code($input) 
	{
		if (preg_match('/^[\w][\d][\w][ ]?[\d][\w][\d]$/', $input))
		{
			return TRUE;
		}	
		else 
		{
			return FALSE;
		}
	}
	
	public function phone_number($input) 
	{
		if (preg_match( '/^\(?\d{3}\)?[ -]?\d{3}[ -]?\d{4}$/', $input))
		{
			return TRUE;
		}	
		else 
		{
			return FALSE;
		}
	}
	
	public function send_email($content)
	{
		date_default_timezone_set('America/Toronto');
		$sent_date = date('l jS \of F Y h:i:s A');
		$message =  "Sent on: " . $sent_date . "<br /> " . 
					"Name: " . $content['name'] . " <br />" . 
					"Address: " . $content['address'] . " <br />" . 
					"Postal Code: " . $content['postalcode'] . " <br />". 
					"Phone Number: " . $content['phone'] . " <br />" .
					"Email: " . $content['email'] . " <br />" . 
					"Comments: " . $content['comments'];
		$this->load->library('email');
		$config = array(
			'mailtype' => 'html'
		);
		$this->email->initialize($config);
		$this->email->from("000277970@csu.mohawkcollege.ca ", "Salt Kettle");
		$this->email->to('000277970@csu.mohawkcollege.ca, jasonhm@csu.mohawkcollege.ca');
		$this->email->subject('Salt Kettle Guess House Inquiry');
		$this->email->message($message);
		if($this->email->send())
		{
			return true;
		}
		else
		{	
			return false;
		}
		
	}
	
	public function printCtlr() 
	{
		highlight_file('application/controllers/contact.php'); 
        exit;
	}
	
	public function printView() 
    {      
        highlight_file('application/views/contact.php'); 
        exit;  
    } 
}