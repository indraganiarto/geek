<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class systemlogactivities {

    function __construct() {
        @session_start();
        $this->ci = &get_instance();
    }

    function writelogactivities() {

        if(isset($_SESSION['ul_logged']['id'])){
            //get access path and explode per segment (classname, method, parameter)
            $uri_string = $this->ci->uri->ruri_string();
            //echo $uri_string;
            $ex_uri_string = explode("/",$uri_string);

            $accesspath['classdirectory'] = strtolower($this->ci->router->fetch_directory());
            $accesspath['classname'] = strtolower($this->ci->router->fetch_class());
            $accesspath['method'] = strtolower($this->ci->router->fetch_method());

            $tot_segment = count($ex_uri_string);
            for($i = 3; $i < $tot_segment;$i++){
                $accesspath['param'][] = strtolower($ex_uri_string[$i]);
            }
            
            $str_uri_param = implode('/',$accesspath['param']);
            $time_stamp = date("d-m-Y H:i:s");
            $str_uri_segment =  '/'.$accesspath['classname'].'/'.$accesspath['method'].'/'.$accesspath['param'][0];
            $activity = "Undefine Activity.";
            $modul = "Undefine Modul.";
            //define modul uris access
            $uri_moduls = array(

                'dashboard' => array(
                                        '/office/index/' => 'open_dashboard'
                                    ),
                'poi' => array(
                                '/office/poi/add' => 'open_form_add',
                                '/process/add/poi' => 'add',
                                '/office/poi/list' => 'list',
                                '/office/poi/edit' => 'open_form_edit',
                                '/process/edit/poi' => 'edit',
                                '/process/office/poi_filter' => 'filter',
                                '/office/poi/features' => 'feature',
                                '/office/form/features_poi' => 'open_form_add_feature',
                                '/process/add/features-poi' => 'add_feature',
                                '/office/form/features_path' => 'open_form_edit_feature',
                                '/process/edit/features-poi' => 'edit_feature',
                                '/office/form/features_path' => 'open_feature_cover',
                                '/process/cover/features_path' => 'upload_feature_cover',
                                '/office/form/add_poi' => 'choose_method_add',
                                '/office/poi/list_approve_poi' => 'open_list_approve',
                                '/office/form/features_poi_ed' => 'open_form_edit_feature',
                                '/office/form/objects_cover' => 'open_form_change_cover',
                                '/office/poi/list_duplicate' => 'list_duplicate',
                                '/office/form/galleries_poi' => 'open_gallery_poi',
                                '/process/edit/galleries' => 'upload_gallery_cover',
                                '/office/form/list_duplicate' => 'open_duplicate_poi_list'
                              
                              ),
                 'news' => array(

                                '/office/news/add' => 'open_form_add',
                                '/process/add/news' => 'add',
                                '/office/news/list' => 'list',
                                '/office/news/edit' => 'open_form_edit',
                                '/process/edit/news' => 'edit',
                                '/office/form/news_cover' => 'open_news_cover',
                                '/process/cover/news_cover' => 'upload_news_cover',
                                '/office/form/galleries_news' => 'open_news_galleries',
                                '/process/edit/galleries/news_id' => 'upload_news_galleries'
                                
                              ),
                 'magazine' => array(

                                '/office/magazine/add' => 'open_form_add',
                                '/process/add/magazine' => 'add',
                                '/office/magazine/list' => 'list',
                                '/office/magazine/edit' => 'open_form_edit',
                                '/process/edit/magazine' => 'edit',
                                '/office/form/magazine_cover' => 'open_news_cover',
                                '/process/cover/magazine_cover' => 'upload_news_cover',
                                '/office/form/galleries_magazine' => 'open_news_galleries',
                                '/process/edit/galleries/magazine_id' => 'upload_news_galleries'
                                
                              ),
                 'categories' => array(

                                '/office/form/add_categories' => 'open_form_add',
                                '/process/add/categories' => 'add',
                                '/office/form/main_categories' => 'open_form_main_cat',
                                '/office/categories/main' => 'main_categories_list',
                                '/office/form/main_ed' => 'open_form_edit_main_cat',
                                '/process/edit/categories-menu' => 'edit_main_cat',
                                '/office/form/sub_categories' => 'open_form_sub_cat',
                                '/office/categories/sub' => 'sub_categories_list',
                                '/office/categories/subsub' => 'subsub_categories_list',
                                '/office/form/subsub_categories' => 'open_form_subsub_cat',
                                '/office/form/sub_ed' => 'open_form_edit_sub_cat',
                                '/process/edit/categories-submenu1' => 'edit_sub_cat',
                                '/office/form/subsub_ed' => 'open_form_edit_subsub_cat',
                                '/process/edit/categories-submenu2' => 'edit_subsub_cat',
                                
                              ),
                 'ads' => array(

                                '/office/ads/list' => 'list',
                                '/office/form/add_ads' => 'open_form_add_ads',
                                '/office/form/ads_ed' => 'open_form_edit_ads',
                                '/process/edit/ads' => 'edit',
                                '/process/add/ads' => 'add_ads',
                                '/office/schedule/list' => 'list_schedule',
                                '/office/schedule/add' => 'open_form_add_schedule',
                                '/process/add/schedule' => 'add_schedule',
                                '/office/schedule/edit' => 'open_form_edit_schedule',
                                '/office/recommended/list' => 'list_recommended',
                                '/office/recommended/add_rec' => 'open_form_add_recommended',
                                '/process/add/recommended' => 'add_recommended',
                                '/office/recommended/list_recommended_detail' => 'list_detail_recommended',
                                '/office/form/rec_ed' => 'open_form_edit_recommended',
                                '/process/edit/recommended' => 'edit_recommended',
                                '/office/recommended/add_rec_detail' => 'open_form_add_detail_recommended',
                                '/process/add/rec_detail' => 'add_detail_recommended',
                                '/office/recommended/edit_rec_detail' => 'open_form_edit_detail_recommended',
                                '/process/edit/rec_detail' => 'edit_detail_recommended',
                                '/process/edit/rec_detail' => 'edit_detail_recommended',
                                
                              )

            );
            if(in_array($str_uri_segment,array_keys($uri_moduls['dashboard']))){
                $activity = $uri_moduls['dashboard'][$str_uri_segment];
                $modul = "dashboard";
            }
            if(in_array($str_uri_segment,array_keys($uri_moduls['poi']))){
                $activity = $uri_moduls['poi'][$str_uri_segment];
                $modul = "poi";
            }
            if(in_array($str_uri_segment,array_keys($uri_moduls['news']))){
                $activity = $uri_moduls['news'][$str_uri_segment];
                $modul = "news";
            }
            if(in_array($str_uri_segment,array_keys($uri_moduls['magazine']))){
                $activity = $uri_moduls['magazine'][$str_uri_segment];
                $modul = "magazine";
            }
            if(in_array($str_uri_segment,array_keys($uri_moduls['categories']))){
                $activity = $uri_moduls['categories'][$str_uri_segment];
                $modul = "categories";
            }
            if(in_array($str_uri_segment,array_keys($uri_moduls['ads']))){
                $activity = $uri_moduls['ads'][$str_uri_segment];
                $modul = "ads";
            }

            $log_in_json = '{
                "method" : "No Action POST",
                "param" : "'.$str_uri_param.'",
                "url" : "'.current_url().'"
            }';

            //check post data pre submit
            if(isset($_POST)){
                if(count($_POST)>0){
                    $data = json_encode($_POST);
                    $log_in_json = '{

                        "method" : "POST",
                        "param" : "'.$str_uri_param.'",
                        "data" : ['.$data.'],
                        "url" : "'.current_url().'"

                    }';
                }
            }


            //ignore some uri access by system
            $ignore_access_uri = array(

                'process/autocomplete',
                'office/getpoilist',
                'office/getlogactivitylist',
                'office/log',
                'office/getnewslist',
                'office/showlogdetail',
                'office/getfeatures',
                'office/getapprovepoi',
                'office/getduplicatepoi',
                'office/getpoilistduplicate',
                'office/getnewslist',
                'office/getmagazinelist',
                'office/getmaincategorylist',
                'office/getsubcategorylist',
                'office/getsubsubcategorylist',
                'office/getadslist',
                'office/getschedulelist',
                'office/list_poi',
                'office/getrecommendedlist',
                'office/getrecommendedlistdetail'

            );

            //ignore some uri access by system with firts parameter

            $ignore_access_uriparam = array(

                 'office/form/features_poi_edit',
                 'office/form/features_poi_frame',
                 'office/form/list_duplicate_content',
                 'process/office/main_categories',
                 'process/office/sub_categories',
                 'process/office/subsub_categories'

            );

            //ignore some parameter coz failed load resource
            $ignore_access_param = array(

                'assets/img/menu-toggler.png',
                'img/menu-toggler.png',
                'static/i/loading_s.gif',
                'list/assets/img/menu-toggler.png',
                'edit/static/i/loading_s.gif',
                'features/assets/img/menu-toggler.png',
                'features_poi_frame',
                'features/static/i/loading_s.gif',
                'edit/id/assets/img/menu-toggler.png',
                'edit/id/static/i/loading_s.gif',
                'main/assets/img/menu-toggler.png',
                'main/static/i/loading_s.gif',
                'sub/assets/img/menu-toggler.png',
                'sub/static/i/loading_s.gif',
                'subsub/static/i/loading_s.gif',
                'subsub/assets/img/menu-toggler.png'

            );

            $check_uri =  $accesspath['classname'].'/'.$accesspath['method'];
            $check_uri_firstparam =  $accesspath['classname'].'/'.$accesspath['method'].'/'.$accesspath['param'][0];


            //handle delete

            if($check_uri=="process/remove"){

                if(count($_POST)>0){

                    $key = $_POST['c'];
                    $id = $_POST['idx'];

                    //filter poi modul
                    $modul_state['poi'] = array('poi','feature','galleries');
                    if(in_array($key,$modul_state['poi'])){
                        $modul = "poi";
                        $activity = "delete_".$key."_item";
                    }
                    $modul_state['news'] = array('news','galleries');
                    if(in_array($key,$modul_state['news'])){
                        $modul = "news";
                        $activity = "delete_".$key."_item";
                    }
                    $modul_state['magazine'] = array('magazine','galleries');
                    if(in_array($key,$modul_state['magazine'])){
                        $modul = "magazine";
                        $activity = "delete_".$key."_item";
                    }
                    $modul_state['categories'] = array('menu','submenu1','submenu2');
                    if(in_array($key,$modul_state['categories'])){
                        $modul = "categories";
                        $activity = "delete_".$key."_item";
                    }
                    $modul_state['ads'] = array('ads');
                    if(in_array($key,$modul_state['ads'])){
                        $modul = "ads";
                        $activity = "delete_".$key."_item";
                    }

                }

            }

            //filter uri
            if(!in_array($check_uri, $ignore_access_uri)){

                if(!in_array($check_uri_firstparam, $ignore_access_uriparam)){

                 //filter param
                    if(!in_array($str_uri_param, $ignore_access_param)){

                        //unmark if use filter string
                        //$str_filter = str_replace("'","",$log_in_json);
                        //$data = str_replace('"','',$str_filter);

                        //remove space
                        $str_param = str_replace(' ', '', $log_in_json);
                       
                        //insert log to db
                        $data_insert = array(
                            'parameter' => $log_in_json,
                            'modul' =>  $modul,
                            'activity' => $activity,
                            'id_user' => $_SESSION['ul_logged']['id'],
                            'time_stamp' => date('Y-m-d H:i:s')
                        );

                        //print_r($data_insert);exit;
                        $this->ci->db->insert('office.log_user',$data_insert);
                    }
                }
            }
        }
    }

}
