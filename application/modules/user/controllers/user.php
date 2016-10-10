<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MX_Controller {

	function __construct(){

		parent::__construct();

	}
	public function index(){

		echo "OK";

	}
	function changeprofile($id=null){

		echo "ID: ".$id;

	}
}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */ 
