<?php
    if(isset($back_url)){
        if($back_url!=''){
            $burl = $back_url;
        }else{
            $burl = "javascript:loadContent($.cookie('history_url'),$.cookie('current_modul'),$.cookie('current_menu'),$.cookie('current_url'));";
        }
    }else{
        $burl = "javascript:loadContent($.cookie('history_url'),$.cookie('current_modul'),$.cookie('current_menu'),$.cookie('current_url'));";
    }
?>
<div class="container-fluid">  
    <div class="row-fluid">
        <div class="span12" style="margin-top: 20px;">     
            <div class="jumbotron"><div class="coffee" style="float:left"></div><h1 style="text-align:left;">Code & Coffee</h1><h3 style="text-align: left;font-style: italic;"><?php echo @$modul_description; ?></h3></div>
        </div>
        <div class="span12" style="margin:0px;"> 
            <?php if(!isset($breadcrumb_disabled)){ ?>    
                <ul class="breadcrumb">
                  <?php echo @$breadcrumb; ?>
                </ul> 
            <?php } ?>
        </div>
    </div>
    <div id="tracecontainer">
     <div class="row-fluid">
            <div class="span12">
                <div class="portlet">
                    <div class="portlet-title" style="height: 45px;">
                        <h4><?php echo @$list_title; ?></h4>
                        <div class="tools">
                            <span><a href="<?php echo $burl; ?>" class="btn default">Back</a></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="content-box">
                            <?php
                                if(isset($moduldir)){

                                    $modulcount = count($moduldir);
                                    $modul_dir_path = $_SERVER['DOCUMENT_ROOT'].'/application/modules/';
                                    $moduliteminfo = "/modul.info"; 
                                    $modulinstallitem = "/modul.install"; 
                                    $html = "<table class='tb-modul'>";
                                    $html.= "<thead>
                                                <tr>
                                                    <th>Enable/Disable</th>
                                                    <th>Modul</th>
                                                    <th>Developer/Vendor</th>
                                                    <th>Descripton</th>
                                                    <th>Version</th>
                                                    <th>Group</th>
                                                    <th>Install/Uninstall</th>
                                                <tr>
                                            </thead>";
                                    $html.= "<tbody";
                                    for($i = 0;$i < $modulcount;$i++){
                                        $html.="<tr>";
                                        $modulitemdir = $modul_dir_path.$moduldir->moduldir[$i];
                                        $iteminfo = $modulitemdir.$moduliteminfo;
                                        $iteminstall = $modulitemdir.$modulinstallitem;
                                        $installstatus = 0;
                                        $enabled = 0;

                                        if (file_exists($iteminfo)) {

                                            if (file_exists($iteminstall)) {

                                                  $installdata = simplexml_load_file($iteminstall);
                                                  $keyexists = $installdata->install->key;

                                                  if($keyexists==""){
                                                      $uniqkey = md5(rand());
                                                      $dom=new DOMDocument();
                                                      $dom->load($iteminstall);
                                                      $root=$dom->documentElement;
                                                      $install=$root->getElementsByTagName('install')->item(0);
                                                      $install->appendChild($dom->createElement('key',$uniqkey));
                                                      $dom->save($iteminstall);
                                                  }else{
                                                      $sql = "SELECT * FROM office.moduls WHERE modul_id='".$keyexists."'";
                                                      $query = $this->db->query($sql)->result_array();
                                                      if(count($query)>0){
                                                        $installstatus = 1;
                                                        $menabled = @$query[0]['is_enabled'];
                                                        if($menabled==1){
                                                           $enabled = 1; 
                                                        }
                                                      }
                                                  }
                                            }

                                            $itemdata = simplexml_load_file($iteminfo);
                                            if($installstatus==1){
                                                if($enabled==1){
                                                    $checked = "checked";
                                                }else{
                                                    $checked = "";
                                                }
                                                $disabled = "";
                                                $installaction = "<a href='javascript:loadContent(\"".base_url()."apps/modul/uninstall/".$moduldir->moduldir[$i]."\",\"79\",\"81\",$.cookie(\"current_url\"));' class='btn red'>Uninstall</a>";
                                            }else{
                                                $disabled = "disabled";
                                                $checked = "";
                                                $installaction = "<a href='javascript:loadContent(\"".base_url()."apps/modul/install/".$moduldir->moduldir[$i]."\",\"79\",\"81\",$.cookie(\"current_url\"));' class='btn green'>Install</a>";
                                            }
                                            $html.= "<td><input class='swbutton' ".$disabled." ".$checked." data-size='small' type='checkbox'></td>";
                                            $html.= "<td>".$itemdata->name."</td>";
                                            $html.= "<td>".$itemdata->developer."</td>";
                                            $html.= "<td>".$itemdata->description."</td>";
                                            $html.= "<td>".$itemdata->version."</td>";
                                            $html.= "<td>".$itemdata->group."</td>";
                                            $html.= "<td>".$installaction."</td>";

                                        }
                                        $html.="</tr>";
                                    }
                                    $html.= "</tbody>";
                                    $html.= "</table>";
                                    echo $html;
                                }

                            ?>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $(".swbutton").bootstrapSwitch();
                    });
                </script>