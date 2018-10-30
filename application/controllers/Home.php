<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$request = $this->viewcounter->request_details();
		$summary = $this->viewcounter->request_summary();

		$data = compact('request', 'summary');
		$this->load->view('home', $data);
	}

}

?>