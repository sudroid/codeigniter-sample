<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -  
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{	
		$data["title"] = "The Salt Kettle Guest House";
		$this->load->helper('asset_helper');
		$this->template->show('home', $data); 
	}
	
	public function printCtlr() 
	{
		highlight_file('application/controllers/home.php'); 
        exit;
	}
	
	public function printView() 
    {      
        highlight_file('application/views/home.php'); 
        exit;  
    } 
     
    public function printHelper() 
    {      
        highlight_file('application/helpers/asset_helper.php'); 
        exit;  
    } 
     
    public function printLibrary() 
    {      
        highlight_file('application/libraries/template.php'); 
        exit;  
    } 
    
    public function reservations() 
    {
    	$this->template->show('reservations');
    	
    }
    
    public function roomrates()
    {
    	$this->template->show('roomrates');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */