<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
//uncomment for debuging mode

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

class Usergroup extends MX_Controller {

    var $modul = "user"; //modul name
    var $params = array();

    public function __construct() {
        parent::__construct();

        //load dependancy library
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model('ifunction');
        $this->getparams();
    }
    function getparams(){
        //set parameter
        $this->params['table'] = "office.sys_usergroups";  
        $this->params['primary'] = "usergroup_id";  
        //set true if primarykey is autoincrement  
        //$this->params['autoincrement'] = "false";
    }
    function browse()
    {
        //config datatable attribute
        $tmpl = array ( 'table_open'  => '<table id="big_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">' );
        $this->table->set_template($tmpl);
        //heading table caption
        $this->table->set_heading('User Group ID','Name','Action');
        $data['callback'] = base_url().$this->modul.'/'.$this->router->fetch_class()."/get_browse_data";
        $data['breadcrumb'] = "<li>User > Manage User Group</li>";
        $data['header'] = $this->get_header_section();
        $data['list_title'] = "<i class='icon-bookmark'></i>User Group List";
        $data['modul_description'] = "User Management";
        echo Modules::run('office/template/show_datatable', $data);
    }
   
    function get_browse_data()
    {
        //data query for datatable
        $this->datatables->select('usergroup_id,usergroup_id as id,nm_usergroup','Action')
        ->unset_column('usergroup_id')
        ->from('office.sys_usergroups')
        //get buttons action
        ->add_column('Actions', $this->get_buttons('$1'), 'usergroup_id');
        
        echo $this->datatables->generate();
    }
    function get_buttons($id)
    {
        //draw input button
        $html = '<span class="actions">';
        $html.= '<a href="javascript:deleteRow(\''.$id.'\',\''.base_url().$this->modul.'/usergroup/delete\');" class="btn red mini">x</a>';
        $html.= '<a href="javascript:loadContent(\''.base_url().'index.php/'.$this->modul.'/usergroup/edit/'.$id.'\');" class="btn mini"><i class="icon-edit"></i></a>';
        $html.= '</span>';
     
        return $html;
    }
    function get_header_section(){
        //draw head section content
        $html = '<div class="content-box-header">
                    <span><a href="javascript:loadContent(\''.site_url().'/user/usergroup/add/\');" class="btn orange">+ Add New</a></span>
                 </div>';
        return $html;
    }
    function add(){
        //event add
        $param['action'] = 1;
        if(count($_POST)>0){
            //submit data      
            $param['table'] = $this->params['table'];
            $param['key'] = $this->params['primary'];
            $param['post']['insert'] = $_POST;
            $this->load->library("dtform",$param);
            $this->dtform->run_process();

        }else{
            //generate form
            $this->getfields_edit();
            $param['form']['add'] = $this->_fields_edit;
            $param['form']['breadcrumb'] = "<li>User > <small>Add User Group</small></li>";
            $param['form']['title'] = "<i class='icon-globe'></i>Add New";
            $param['form']['header'] = "";
            $param['form']['insert']['url'] = $this->modul.'/'.$this->router->fetch_class().'/add';
            $param['form']['jsscript'] = $this->getJSscript();
            $this->load->library("dtform",$param);
            $this->dtform->generate();

        }

    }
    function edit($id=null){
        //edit event
        $param['action'] = 2;
        if(count($_POST)>0){
            //updating data
            $param['table'] = $this->params['table'];
            $param['key'] = $this->params['primary'];
            $param['post']['update'] = $_POST;
            $this->load->library("dtform",$param);
            $this->dtform->run_process();
        }else{
            //generate form
            if($id!=null){
                $this->getfields_edit();
                $param['form']['edit'] = $this->_fields_edit;
                $param['form']['breadcrumb'] = "<li>User > <small>Edit User Group</small></li>";
                $param['form']['title'] = "<i class='icon-globe'></i>Edit Form";
                $param['form']['header'] = "";
                $param['edit']['id'] = $id;
                $param['table'] = $this->params['table'];
                $param['key'] = $this->params['primary'];
                $param['form']['edit']['url'] = $this->modul.'/'.$this->router->fetch_class().'/edit';
                $param['form']['jsscript'] = $this->getJSscript();
                $this->load->library("dtform",$param);
                $this->dtform->generate();
            }
        }

    }
    function delete(){

        if(count($_POST)>0){
            //delete data handler
            $param['action'] = 3;
            $param['table'] = $this->params['table'];
            $param['key'] = $this->params['primary'];
            $param['post']['delete'] = $_POST['ID'];
            $this->load->library("dtform",$param);
            $this->dtform->run_process();

        }

    }
    function getfields_edit(){
        //form parameter
        $this->_fields_edit = array(
            //set fields and attribute
            'usergroup_id' => array(
                    'type'=> "text",
                    'label' => "User Group ID",
                    'validation' => "required"
            ),
            'nm_usergroup'  => array(
                    'type'=> "text",
                    'class' => "w505",
                    'validation' => "required",
                    'label' => "Name"       
            ),
            'description'  => array(
                    'type'=> "editor",
                    'label' => "Description"       
            )

        );
    }
    function getJSscript(){
        //custom js for jquery handler
        $js = '<script>
                    $(document).ready(function(){
                      
                    });
              </script>';

        return $js;

    }

}