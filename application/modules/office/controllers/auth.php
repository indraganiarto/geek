<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->helper(array('url'));
		$this->load->model('ifunction');
	}

	public function logout(){
		unset($_SESSION['ul_logged']); 
		redirect('/office/', 'refresh');
	} 

	public function login(){

	 		$uname = strtolower(strip_tags($_POST['username']));
			$password = strip_tags($_POST['password']);
			if($uname && $password){
				
				$Qcheck = $this->db->query("SELECT grp_user,nm_user,id_user,office.authors.author_id,office.authors.pict
											FROM office.sys_users 
											LEFT JOIN office.authors ON office.authors.author_id = office.sys_users.author_id
											where id_user ='".$uname."' and pwd_user='".$this->ifunction->get_pswd($password)."'
											");
				if($Qcheck->num_rows){
					$check = $Qcheck->result_object();
					$_SESSION['ul_logged']['nm'] = $check[0]->nm_user;
					$_SESSION['ul_logged']['id'] = $check[0]->id_user;
					$_SESSION['ul_logged']['author_id'] = $check[0]->author_id;
					$_SESSION['ul_logged']['grp_user'] = $check[0]->grp_user;
					$_SESSION['ul_logged']['pict'] = $check[0]->pict;

					//record login

					$fields=array(
                      
                        'login'   => $check[0]->id_user 

                    
                    );
                    $this->db->insert('office.login_attempts', $fields);

					echo $this->ifunction->action_response(2, 'iforms_f5', 'alert alert-success', 'Login success, redirecting..');
					
				}
				 else {
				 
				 	echo $this->ifunction->slidedown_response('iforms_f5', 'alert alert-error', 'Invalid login combination.');
				}
			}
			 
			 else echo $this->ifunction->slidedown_response('iforms_f5', 'alert alert-error', 'Please complete the form below.');

	 } 
	
}