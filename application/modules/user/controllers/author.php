<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
//uncomment for debuging mode

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

class Author extends MX_Controller {

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
        $this->params['table'] = "office.authors";  
        $this->params['primary'] = "author_id";  
        //set true if primarykey is autoincrement  
        //$this->params['autoincrement'] = "false";
    }
    function browse()
    {
        //config datatable attribute
        $tmpl = array ( 'table_open'  => '<table id="big_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">' );
        $this->table->set_template($tmpl);
        //heading table caption
        $this->table->set_heading('Photo','Author ID','Name','Gender','Mobile','Action');
        $data['callback'] = base_url().$this->modul.'/'.$this->router->fetch_class()."/get_browse_data";
        $data['breadcrumb'] = "<li>User > Manage Author</li>";
        $data['header'] = $this->get_header_section();
        $data['list_title'] = "<i class='icon-bookmark'></i>User List";
        $data['modul_description'] = "User Management";
        echo Modules::run('office/template/show_datatable', $data);
    }
   
    function get_browse_data()
    {
        //data query for datatable
        $this->datatables->select('author_id,CASE WHEN pict <> \'\' THEN CONCAT(\'<div style="width:100px;height:100px;overflow-y:hidden;"><img style="width:100px;" src="'.base_url().'media/photos/thumbs/\',pict,\'" /></div>\') ELSE CONCAT(\'<div style="width:100px; overflow-y:hidden;"><img src="'.base_url().'assets/backend/img/blank-user.jpg" /></div>\') END as pict, author_id as author,name,CASE WHEN gender=\'L\' THEN \'Laki-laki\' ELSE \'Perempuan\' END as gender,mobile','Action')
        ->unset_column('author_id')
        ->from('office.authors')
        //get buttons action
        ->add_column('Actions', $this->get_buttons('$1'), 'author_id');
        
        echo $this->datatables->generate();
    }
    function get_buttons($id)
    {
        //draw input button
        $html = '<span class="actions">';
        $html.= '<a href="javascript:deleteRow(\''.$id.'\',\''.base_url().$this->modul.'/author/delete\');" class="btn red mini">x</a>';
        $html.= '<a href="javascript:loadContent(\''.base_url().'index.php/'.$this->modul.'/author/edit/'.$id.'\');" class="btn mini"><i class="icon-edit"></i></a>';
        $html.= '</span>';
     
        return $html;
    }
    function get_header_section(){
        //draw head section content
        $html = '<div class="content-box-header">
                    <span><a href="javascript:loadContent(\''.site_url().'/user/author/add/\');" class="btn orange">+ Add New</a></span>
                 </div>';
        return $html;
    }
    function add(){
        //event add
        $param['action'] = 1;
        if(count($_POST)>0){
            //submit data   
            
            if(isset($_FILES['file']['name']) && $_FILES['file']['tmp_name']){
                    
                $file_allowed = array('image/gif', 'image/png', 'image/x-png', 'image/jpg', 'image/jpeg', 'image/pjpeg');
                if(!in_array($_FILES['file']['type'], $file_allowed, true)) die();

                $fileext = explode('.', $_FILES['file']['name']);
                $file_ext = strtolower(end($fileext));

                $new_file_name = str_replace(' ','_',$_FILES['file']['name']);
                
                $file_path = './_temp/'.$new_file_name;
                move_uploaded_file($_FILES['file']['tmp_name'], $file_path);

                if(($file_ext == 'gif')||($file_ext == 'png')){
                    $this->ifunction->convert_to_jpg($file_path, './_temp/'.$new_name.'.jpg', $file_ext);
                    $new_file_name = $new_name.'.jpg';
                    $this->ifunction->un_link($file_path);
                }
                
                $this->ifunction->curl(base_url().'media/photos.php?filename='.$new_file_name);

                $_POST['pict'] = $new_file_name;
            }
            else $_POST['pict'] = "";

            $param['table'] = $this->params['table'];
            $param['key'] = $this->params['primary'];
            $param['post']['insert'] = $_POST;
            $this->load->library("dtform",$param);
            $this->dtform->run_process();

        }else{
            //generate form
            $this->getfields_edit();
            $param['form']['add'] = $this->_fields_edit;
            $param['form']['breadcrumb'] = "<li>User > <small>Add Authors</small></li>";
            $param['form']['title'] = "<i class='icon-globe'></i>Add New";
            $param['form']['header'] = "";
            $param['form']['insert']['url'] = $this->modul.'/'.$this->router->fetch_class().'/add';
            $param['form']['jsscript'] = $this->getJSscript();
            $this->load->library("dtform",$param);
            $this->dtform->generate();

        }

    }
    function edit($id=null,$type=0){
        //edit event
        $param['action'] = 2;
        if(count($_POST)>0){
            //updating data

            if(isset($_FILES['file']['name']) && $_FILES['file']['tmp_name']){
                    
                $file_allowed = array('image/gif', 'image/png', 'image/x-png', 'image/jpg', 'image/jpeg', 'image/pjpeg');
                if(!in_array($_FILES['file']['type'], $file_allowed, true)) die();

                $fileext = explode('.', $_FILES['file']['name']);
                $file_ext = strtolower(end($fileext));

                $new_file_name = str_replace(' ','_',$_FILES['file']['name']);
                
                $file_path = './_temp/'.$new_file_name;
                move_uploaded_file($_FILES['file']['tmp_name'], $file_path);

                if(($file_ext == 'gif')||($file_ext == 'png')){
                    $this->ifunction->convert_to_jpg($file_path, './_temp/'.$new_name.'.jpg', $file_ext);
                    $new_file_name = $new_name.'.jpg';
                    $this->ifunction->un_link($file_path);
                }
                
                $this->ifunction->curl(base_url().'media/photos.php?filename='.$new_file_name);

                $_POST['pict'] = $new_file_name;
            }
            else $_POST['pict'] = $_POST['old_file'];

            if(isset($_POST['old_file'])){
                unset($_POST['old_file']);
            }
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
                $param['form']['edit']['author_id']['type'] = "hidden";
                if($type==1){
                    $param['form']['breadcrumb_disabled'] = 1;
                    $param['form']['back_disabled'] = 1;
                    $param['form']['title'] = "<i class='icon-user'></i>".$_SESSION['ul_logged']['nm'];
                    $param['form']['header'] = "";
                }else{
                    $param['form']['breadcrumb'] = "<li>User > <small>Edit Author</small></li>";
                    $param['form']['title'] = "<i class='icon-globe'></i>Edit Form";
                    $param['form']['header'] = "";
                }
                $param['edit']['id'] = $id;
                $param['table'] = $this->params['table'];
                $param['key'] = $this->params['primary'];
                $param['form']['edit']['url'] = $this->modul.'/'.$this->router->fetch_class().'/edit';
                $param['form']['jsscript'] = $this->getJSscript($id);
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
            'author_id' => array( 
                    'type'=> "text",
                    'label' => "Author ID",
                    'validation' => "required"
            ),
            'name'  => array(
                    'type'=> "text",
                    'class' => "w505",
                    'validation' => "required",
                    'label' => "Name"       
            ),
            'bio'  => array(
                    'type'=> "editor",
                    'label' => "Bio"       
            ),
            'gender'  => array(
                    'type'=> "sourcearray",
                    'data' => array("L" => "Laki-laki","P" => "Perempuan"),
                    'label' => "Gender"       
            ),
            'address'  => array(
                    'type'=> "textarea",
                    'style' => "width:95%;height:200px",
                    'label' => "Address"       
            ),
            'no_telp'  => array(
                    'type'=> "number",
                    'validation' => "required",
                    'label' => "No Telp."       
            ),
            'mobile'  => array(
                    'type'=> "number",
                    'validation' => "required",
                    'label' => "Mobile"      
            ),
            'country_id'  => array(
                    'type'=> "sourcequery",
                    'data' => $this->coremodel->getcountry(),
                    'label' => "Country"       
            ),
            'province_id'  => array(
                    'type'=> "sourcequery",
                    'data' => $this->coremodel->getprovince(),
                    'label' => "Province"       
            ),
            'city_id'  => array(
                    'type'=> "sourcequery",
                    'data' => $this->coremodel->getcity(),
                    'label' => "City"       
            ),
            'pict' => array(
                    'type'=> "file",
                    'upload_dir'=> "default",
                    'label' => "Picture"
                       
            )

        );
    }
    function getJSscript($id=null){
        //custom js for jquery handler
        $js = '<script>
                    $(document).ready(function(){
                       
                    });
                  
              </script>';

        return $js;

    }

}