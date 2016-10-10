<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);*/
class Office extends CI_Controller {


	function __construct()
	{
		parent::__construct();
        $this->load->database();
		$this->load->helper(array('html', 'url'));
		$this->load->model('ifunction');
		$this->load->model('coremodel');

	}
	
	public function index()
	{ 
		session_start();
		if(isset($_SESSION['ul_logged']['id'])){
			$var = array(
					'current' 	=> 'dashboard',
					'target' 	=> 'home'
			);
			$this->load->view('main', $var);
			
		}
		else $this->load->view('login');
	}
	function home(){
			
		$this->load->view('home');
	}
	public function form($tp, $dx=0,$dxmain=0)
	{
		session_start();
		if(empty($_SESSION['ul_logged']['id'])) exit('<p align="center">Session expired! [<a href="'.base_url().'index.php/process/office/logout">Sign Out</a>]</p>');
		$var = array(
				'tp' => $tp,
				'dx' => $dx,
				'dxmain' => $dxmain
		);
		$this->load->view('form', $var);
	}
	public function list_poi()
	{
			//$data['response'] = 'false';
			$Qlists = $this->db->query("SELECT object_id, title FROM un_objects ORDER BY object_id ASC");
			 
            foreach($Qlists->result_object() as $list){
            			$data[] = array(
								        'object_id' => $list->object_id,
								        'title' => $list->title 
								);

            }
            echo json_encode($data) ;
           
	}
	public function showlogdetail($param)
	{
		session_start();
		if(isset($_SESSION['ul_logged']['id'])){
			
			$var = array(
					'current' 	=> 'log',
					'method' 	=> 'log.list_login',
					'target' 	=> 'admin/log/logdetail',
					'param' => $param,
					'meta' 		=> 'admin/meta',
					'footer' 	=> 'admin/footer',
			);
			$this->load->view('main', $var);
		}
		else $this->load->view('office/template/login');
	}
	public function encrypt($password){
        echo $this->ifunction->get_pswd($password);
    }
	
}
