<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{	
		$this->load->helper('asset_helper');
		$this->template->show('admin');
	}
}