<?php

class template extends MX_Controller{
	
	function __construct(){

		parent::__construct();


	}

	function show_datatable($data){

		$this->load->view('datatable',$data);

	}


}