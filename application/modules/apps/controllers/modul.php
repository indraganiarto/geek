<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start();
//uncomment for debuging mode

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
ini_set('allow_url_fopen ','ON');
error_reporting(-1);

class Modul extends MX_Controller {

    var $modul = "apps"; //modul name
    var $params = array();

    public function __construct() {

        parent::__construct();
    
    }
    function list_modul(){
        
        $modul_dir = $_SERVER['DOCUMENT_ROOT'].'/application/modules/';
        $file_map = "modulreg.config";
        $modul_reg = $modul_dir.$file_map;
        if (file_exists($modul_reg)) {
             $data['moduldir'] = simplexml_load_file($modul_reg);
        } else {
            exit('Failed to open '.$modul_reg.'.');
        }
        $data['breadcrumb'] = "<li>Apps > Modul</li>";
        $data['header'] = "";
        $data['list_title'] = "<i class='icon-bookmark'></i>Modul List";
        $data['modul_description'] = "Apps Configuration";
        $this->load->view("modul",$data);
    
    }
    function install($minstalldir=null){

        if($minstalldir!=null){

            if($minstalldir!=""){
                $modul_dir_path = $_SERVER['DOCUMENT_ROOT'].'/application/modules/'.$minstalldir;
                $moduliteminfo = "/modul.info"; 
                $modulinstallitem = "/modul.install";
                $modulinstallitempath = $modul_dir_path.$modulinstallitem;
                $moduliteminfopath = $modul_dir_path.$moduliteminfo;

                if(file_exists($modulinstallitempath)){
                    $installitem = simplexml_load_file($modulinstallitempath);
                    $sqlaltermenu = $installitem->install->altermenu->sql;
                    $sqlstructuredepedency = $installitem->install->query->sql;
                    //generate menu 
                    if($sqlaltermenu!=""){
                        $menuquery = $this->db->query($sqlaltermenu);
                        if($menuquery){
                            $data['menu_item_install_status'] = 1;
                        }else{
                            $data['menu_item_install_status'] = 0;
                        }
                    }else{
                        $data['menu_item_install_status'] = 2;
                    }
                    //generate structure
                    if($sqlstructuredepedency!=""){ 
                        $structurequery = $this->db->query($sqlstructuredepedency);
                        if($structurequery){
                            $data['structure_install_status'] = 1;
                        }else{
                            $data['structure_install_status'] = 0;
                        }
                    }else{
                        $data['structure_install_status'] = 2;
                    }
                    //check depedency installation status
                    if($data['menu_item_install_status']==1&&$data['structure_install_status']==1){
                        //if everything ok then register to table moduls
                        if(file_exists($moduliteminfopath)){
                            $modinfo = simplexml_load_file($moduliteminfopath);
                            $modul_id = $installitem->install->key;
                            $modul_name = @$modinfo->name;
                            $modul_desc = @$modinfo->description;
                            $modul_dev = @$modinfo->developer;
                            $modul_group = @$modinfo->group;
                            $modul_version = @$modinfo->version;
                            $regmod = array(
                                "modul_id" => (string)$modul_id,
                                "modul_name" => (string)$modul_name, 
                                "modul_desc" => (string)$modul_desc, 
                                "developer" => (string)$modul_dev, 
                                "modul_group" => (string)$modul_group, 
                                "version" => (string)$modul_version,
                                "is_enabled" => "0"
                            );

                            $data['modul_name'] = @$modinfo->name;
                            $data['modul_version'] = @$modinfo->version;

                            $queryinsert = $this->db->insert("office.moduls",$regmod);
                            if($queryinsert){
                                $data['modul_install_status'] = 1;
                            }else{
                                $data['modul_install_status'] = 0;
                            }
                        }

                    }else{
                        //send error status
                        $data['modul_install_status'] = 2;
                    }

                }

                $data['breadcrumb'] = "<li>Apps > Modul Installation Status </li>";
                $data['header'] = "";
                $data['list_title'] = "<i class='icon-bookmark'></i>Install Status";
                $data['modul_description'] = "Apps Configuration";
                $data['action_type'] = "install";
                $this->load->view("install",$data);
            }

        }

    }
    function uninstall($minstalldir=null){
        if($minstalldir!=null){

            if($minstalldir!=""){
                $modul_dir_path = $_SERVER['DOCUMENT_ROOT'].'/application/modules/'.$minstalldir;
                $moduliteminfo = "/modul.info"; 
                $modulinstallitem = "/modul.install";
                $modulinstallitempath = $modul_dir_path.$modulinstallitem;
                $moduliteminfopath = $modul_dir_path.$moduliteminfo;

                if(file_exists($modulinstallitempath)){
                    $installitem = simplexml_load_file($modulinstallitempath);
                    $sqlremovemenu = $installitem->uninstall->removemenu->sql;
                    $sqlstructuredepedency = $installitem->uninstall->query->sql;
                    //generate menu 
                    if($sqlremovemenu!=""){
                        $menuquery = $this->db->query($sqlremovemenu);
                        if($menuquery){
                            $data['menu_item_install_status'] = 1;
                        }else{
                            $data['menu_item_install_status'] = 0;
                        }
                    }else{
                        $data['menu_item_install_status'] = 2;
                    }
                    //generate structure
                    if($sqlstructuredepedency!=""){ 
                        $structurequery = $this->db->query($sqlstructuredepedency);
                        if($structurequery){
                            $data['structure_install_status'] = 1;
                        }else{
                            $data['structure_install_status'] = 0;
                        }
                    }else{
                        $data['structure_install_status'] = 2;
                    }
                    //check depedency installation status
                    if($data['menu_item_install_status']==1&&$data['structure_install_status']==1){
                        //if everything ok then register to table moduls
                        if(file_exists($moduliteminfopath)){
                            $modinfo = simplexml_load_file($moduliteminfopath);
                            $modul_id = $installitem->install->key;

                            $data['modul_name'] = @$modinfo->name;
                            $data['modul_version'] = @$modinfo->version;

                            $querydelete = $this->db->query("DELETE FROM office.moduls WHERE modul_id='".$modul_id."'");
                            if($querydelete){
                                $data['modul_install_status'] = 1;
                            }else{
                                $data['modul_install_status'] = 0;
                            }
                        }

                    }else{
                        //send error status
                        $data['modul_install_status'] = 2;
                    }

                }

                $data['breadcrumb'] = "<li>Apps > Modul Uninstallation Status </li>";
                $data['header'] = "";
                $data['list_title'] = "<i class='icon-bookmark'></i>Uninstall Status";
                $data['modul_description'] = "Apps Configuration";
                $data['action_type'] = "uninstall";
                $this->load->view("install",$data);
            }

        }
    }
}