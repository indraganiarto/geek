<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
//uncomment for debuging mode

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

class Usergroupprivilege extends MX_Controller {

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
        $this->params['table'] = "office.sys_usergroupprivileges";  
        $this->params['primary'] = "usergroupprivilege_id";  
        //set true if primarykey is autoincrement  
        $this->params['autoincrement'] = "true";
    }
    function browse()
    {
        //config datatable attribute
        $tmpl = array ( 'table_open'  => '<table id="big_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">' );
        $this->table->set_template($tmpl);
        //heading table caption
        $this->table->set_heading('User Group ID','Name','Modul','Action');
        $data['callback'] = base_url().$this->modul.'/'.$this->router->fetch_class()."/get_browse_data";
        $data['breadcrumb'] = "<li>User > Manage User Group Privilege</li>";
        $data['header'] = $this->get_header_section();
        $data['list_title'] = "<i class='icon-bookmark'></i>User Group Privilege List";
        $data['modul_description'] = "User Management";
        echo Modules::run('office/template/show_datatable', $data);
    }
   
    function get_browse_data()
    {
        //data query for datatable
        $this->datatables->select('a.usergroupprivilege_id,b.usergroup_id,b.nm_usergroup,c.label_item','Action')
        ->unset_column('a.usergroupprivilege_id')
        ->from('office.sys_usergroupprivileges a')
        ->join('office.sys_usergroups b','b.usergroup_id=a.usergroup_id','left')
        ->join('office.menu_item c','a.modul=c.menu_item_id','left')
        //get buttons action
        ->add_column('Actions', $this->get_buttons('$1'), 'a.usergroupprivilege_id');
        
        echo $this->datatables->generate();
    }
    function get_buttons($id)
    {
        //draw input button
        $html = '<span class="actions">';
        $html.= '<a href="javascript:deleteRow(\''.$id.'\',\''.base_url().$this->modul.'/usergroupprivilege/delete\');" class="btn red mini">x</a>';
        $html.= '<a href="javascript:loadContent(\''.base_url().'index.php/'.$this->modul.'/usergroupprivilege/edit/'.$id.'\');" class="btn mini"><i class="icon-edit"></i></a>';
        $html.= '</span>';
     
        return $html;
    }
    function get_header_section(){
        //draw head section content
        $html = '<div class="content-box-header">
                    <span><a href="javascript:loadContent(\''.site_url().'/user/usergroupprivilege/add/\');" class="btn orange">+ Add New</a></span>
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
            $param['autoincrement'] = $this->params['autoincrement'];
            $param['post']['insert'] = $_POST;
            $this->load->library("dtform",$param);
            $this->dtform->run_process();

        }else{
            //generate form
            $this->getfields_edit();
            $param['form']['add'] = $this->_fields_edit;
            $param['form']['breadcrumb'] = "<li>User > <small>Add User Group Privilege</small></li>";
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
                $param['form']['breadcrumb'] = "<li>User > <small>Edit User Group Privilege</small></li>";
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
            'usergroupprivilege_id' => array(
                    'type'=> "hidden"
            ),
            'usergroup_id'  => array(
                    'type'=> "sourcequery",
                    'data' => $this->coremodel->getusergroup(),
                    'label' => "User Group"       
            ),
            'modul'  => array(
                    'type'=> "sourcequery",
                    'data' => $this->coremodel->getmodul(),
                    'label' => "Modul"       
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