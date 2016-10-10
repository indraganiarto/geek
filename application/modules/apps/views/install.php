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
                                $html = "<div class='install-status'>";
                                if($modul_install_status==1){
                                    if($action_type=="install"){
                                        $html.="<h3 class='success-report'>Module '".$modul_name."'' have been installed.</h3>";
                                    }else{
                                        $html.="<h3 class='success-report'>Module '".$modul_name."'' have been uninstalled.</h3>";
                                    }
                                }else{
                                    if($action_type=="install"){
                                        $html.="<h3 class='error-report'>Failed install '".$modul_name."''.[ERROR_CODE:".$modul_install_status."]</h3>";
                                    }else{
                                        $html.="<h3 class='error-report'>Failed uninstall '".$modul_name."''.[ERROR_CODE:".$modul_install_status."]</h3>"; 
                                    }
                                }
                                $html.= "</div>";
                                echo $html;
                            ?>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $(".swbutton").bootstrapSwitch();
                    });
                </script>