<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roomrates extends CI_Controller {
	
	public function __construct() 
	{
		parent::__construct(); 
		$this->load->model('roomrates_model');
	}
	
	/**
	 * 	Read room data
	 * 	This page is public
	*/
	public function index()
	{	
		$this->load->library('form_validation');
		$data['link'] = $_SERVER['PHP_SELF']. "?/roomrates/";
		$data['roomrates'] = $this->roomrates_model->getAllRoomrates();
		if(count($data['roomrates'])==0)
		{
			echo 'nothing here!';
		}
		
		$this->load->helper('asset_helper');
		$this->template->show('roomrates', $data);
	}

	/**
	*  	Get room data by room id and fill input fields with those values
	*/
	public function edit($id)
	{
		$data['link'] = $_SERVER['PHP_SELF']. "?/roomrates/save";
		$data['editRoom'] = $this->roomrates_model->getRoomID($id);
		$this->template->show('roomrates', $data);
	}

	/**
	*  	Save/update room information in database
	*  	Refresh on save or die 
	*/
	public function save()
	{
		if($_POST){ 
			$id = $this->input->post('id');
			$room = array(	
							'name' => $this->input->post('name'),
                            'description' => $this->input->post('description'),
                            'number' => $this->input->post('number'),
                            'rate' => $this->input->post('rate')
                		 );
            $this->roomrates_model->updateRoom($id, $room);
            $return = $this->db->affected_rows();
            if($return == 0)
            {
				die('error updating the record. '. $return .' rows affeced.');
			}
		}
		redirect('index.php?/roomrates', 'refresh');
	}

	/**
	*	Display blank new room information
	*/
	public function add(){
		$data['link'] = $_SERVER['PHP_SELF']. "?/roomrates/adding";
		$room = array(array('id' => "4",
							'name' => "",
                            'description' => "",
                            'number' => "",
                            'rate' => "",
                            'image' => ""));
		$roomObj = json_decode(json_encode($room), FALSE);
		$data['editRoom'] = $roomObj;
		$this->template->show('roomrates', $data);
	}

	/**
	*	Add new room information into database	
	*/
	public function adding(){
		if($_POST){
			$room = array(	
							'name' => $this->input->post('name'),
                            'description' => $this->input->post('description'),
                            'number' => $this->input->post('number'),
                            'rate' => $this->input->post('rate')
                		 );
			$this->roomrates_model->addRoom($room);
            $return = $this->db->affected_rows();
            if($return == 0){
				die('error inserting the record. '. $return .' rows affeced.');
			}	
			else {
				$this->index();
			}
		}
		redirect('index.php?/roomrates', 'refresh');
	}

	/**
	*	Delete room by id
	*/
	public function delete($id)
	{
		$this->roomrates_model->deleteRoom($id);
		redirect('index.php?/roomrates', 'refresh');
	}

	/**
	*	Browse with CKEditor
	*	Images are read from the directory folder 
	*/
	public function browse()
	{

		$url = '/home/students/000277970/public_html/10125/lab01/assets/img/uploads/';
		$url2 ='https://csu.mohawkcollege.ca/~000277970/10125/lab01/assets/img/uploads/';
		if(ENVIRONMENT=='development')
            $upload_path = $url2;
        else
            $upload_path = $url2;

		?><h2>Select a photo for the room description:</h2><br/> <?
		if ($handle = opendir($url)) {
			while (($photo = readdir($handle)) !== false) {
		        ?><a href=# onClick = "window.opener.CKEDITOR.tools.callFunction( 1 ,'<?= $upload_path ?><?= $photo ?>') ; self.close();"><img src="<?= $upload_path ?><?= $photo ?>" height="150px" /></a>
        		<?
		    }
		}
	}

	/**
	*	Upload selected image to directory folder
	*/
	public function upload()
	{
		$error_msg='';
		$url = '/home/students/000277970/public_html/10125/lab01/assets/img/uploads/';
		$url2 ='https://csu.mohawkcollege.ca/~000277970/10125/lab01/assets/img/uploads/';
		if(($_FILES['upload']['size']) > 10000){
			$error_msg='image size is too big.';
		}
		else {
			$file_uploaded = move_uploaded_file($_FILES['upload']['tmp_name'], $url.$_FILES['upload']['name']);	}

		if (isset($file_uploaded)) {
			$error_msg='';
		}
		else {
			$error_msg .=' file upload fail';
		}

		$func_num = $_GET['CKEditorFuncNum'];  
		$file_path = $url2.$_FILES['upload']['name'];
		$output = '<html><body>'.$error_msg.'<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$func_num.', "'.$file_path.'","'.$error_msg.'");</script></body></html>';
		echo $output;
	}

	/**
	*	Print roomrates controller
	*/
	public function printCtlr() 
	{
		highlight_file('application/controllers/roomrates.php'); 
        exit;
	}
	
	/**
	*	Print roomrates view
	*/
	public function printView() 
    {      
        highlight_file('application/views/roomrates.php'); 
        exit;  
    } 

	/**
	*	Print roomrates model
	*/
    public function printModel() 
    {      
        highlight_file('application/models/roomrates_model.php'); 
        exit;  
    } 
}