<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ;?>

<div class="footer">
    2015 &copy; Geek CMS.
    <div class="span pull-right" style="max-width: 26px;">
        <span class="go-top"><i class="icon-angle-up"></i></span>
    </div>
</div>

<table id="if_box" border="0" cellpadding="0" cellspacing="0">
	<tr class="ifheader"><td class="ifleft"></td><td class="ifmiddle"></td><td class="ifright"></td></tr>
	<tr class="ifbody"><td colspan="3" class="ifmiddle"><div id="if_popcontent"></div></td></tr>
	<tr class="iffooter"><td class="ifleft"></td><td class="ifmiddle"></td><td class="ifright"></td></tr>
</table>
<table id="if-box" border="0" cellpadding="0" cellspacing="0">
	<tr class="ifheader"><td class="ifleft"></td><td class="ifmiddle"></td><td class="ifright"></td></tr>
	<tr class="ifbody"><td colspan="3" class="ifmiddle"><div id="if-popcontent"></div></td></tr>
	<tr class="iffooter"><td class="ifleft"></td><td class="ifmiddle"></td><td class="ifright"></td></tr>
</table>

<script src="<?php echo JS_BASE_PATH; ?>jquery-1.8.3.min.js"></script> 
<script src="<?php echo JS_BASE_PATH; ?>jquery-ui.js"></script> 
<script type="text/javascript" language="javascript" src="<?php echo JS_BASE_PATH; ?>jquery.dataTables.min.js"></script>
<script language="javascript" src="<?php echo JS_BASE_PATH; ?>form.js"></script>    
<script language="javascript" src="<?php echo JS_BASE_PATH; ?>popup.js"></script>    
<script language="javascript" src="<?php echo JS_BASE_PATH; ?>misc.js"></script> 
<script language="javascript" src="<?php echo JS_BASE_PATH; ?>bootstrap-timepicker.js"></script> 
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>ckeditor/config.js?t=D08E"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>ckeditor/lang/en.js?t=D08E"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>ckeditor/styles.js?t=D08E"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>chosen-bootstrap/chosen/chosen.jquery.min.js"></script>

<script src="<?php echo PLUGINS_BASE_PATH; ?>breakpoints/breakpoints.js"></script>       
<script src="<?php echo PLUGINS_BASE_PATH; ?>jquery-ui/jquery-ui-1.10.1.custom.min.js"></script> 
<script src="<?php echo PLUGINS_BASE_PATH; ?>jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo PLUGINS_BASE_PATH; ?>fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo PLUGINS_BASE_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo JS_BASE_PATH; ?>jquery.blockui.js"></script> 
<script src="<?php echo JS_BASE_PATH; ?>jquery.cookie.js"></script> 
<script src="<?php echo JS_BASE_PATH; ?>jquery.validationEngine.js"></script> 
<script src="<?php echo JS_BASE_PATH; ?>jquery.validationEngine-en.js"></script> 
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="<?php echo JS_BASE_PATH; ?>jquery.pulsate.min.js"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>bootstrap-daterangepicker/daterangepicker.js"></script>  
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>bootstrap3-datetimepicker/js/moment.js"></script>  
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>bootstrap3-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>  
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>lightbox/js/lightbox.js"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo PLUGINS_BASE_PATH; ?>bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="<?php echo JS_BASE_PATH; ?>app.js"></script>                
<script>
    var base_url = '<?php echo base_url(); ?>';
    jQuery(document).ready(function() { 
        App.setPage("index"); 
        App.init();
        $('.datetime').datetimepicker();
        $.cookie("history_url",'<?php echo base_url(); ?>office/home');
        $.cookie("current_url",'<?php echo base_url(); ?>office/home');
        //var con = setInterval(function(){ NetStateStatus() }, 10000);
        $(".swbutton").bootstrapSwitch();
        
    });
    function loadContent(url,modul,menu,prevURL){
        if($("#postinsert").length>0){
            if($("#postinsert").serialize()!=$("#postinsert").data("serialize")){
                var r = confirm("WARNING : Your changes will be lost if you dont save it! Are you sure want to leave this page?");
                if (r == false) {
                    return false;
                } 
            }
        }
        if($("#postupdate").length>0){
            if($("#postupdate").serialize()!=$("#postupdate").data("serialize")){
                var r = confirm("WARNING : Your changes will be lost if you dont save it! Are you sure want to leave this page?");
                if (r == false) {
                    return false;
                } 
            }
        }

        $.cookie("current_url",url);
        $.cookie("history_url",prevURL);
        $.cookie("current_modul",modul);
        $.cookie("current_menu",menu);
        $("#ulin-wrapper").html("<img style='margin-top:100px;margin-left:100px' src='<?php echo base_url(); ?>assets/backend/img/ajax-loader_dark.gif'><h3 style='margin-left: 100px;'>Loading Page. Please wait...</h3>");
        $("#ulin-wrapper").load(url,function(response, status, xhr){
            if(status == "error") {
                if(xhr.status==0){
                    xhr.statusText = "No Internet Connection.";
                }
                $("#ulin-wrapper").html("<div class='error-report' style='margin:10px;margin-top:0px;'>Sorry but there was an error: " + xhr.status + " " + xhr.statusText + "</div>");
            }else{
                $(".modul").removeClass("open");
                $(".menu").removeClass("active");
                $("#modul_" + modul).addClass("open");
                $("#menu_" + menu).addClass("active");
            }
            
        });
       
    }
    (function($){
        
        $( "#toggle" ).click(function() {
          $( "#combobox" ).toggle();
        });
    })(jQuery);
    function checkNetConnection(){

         var xhr = new XMLHttpRequest();
         var file = base_url + "dot.png";
         var r = Math.round(Math.random() * 10000); 
         xhr.open('HEAD', file + "?subins=" + r, false); 
         try {
          xhr.send(); 
          if (xhr.status >= 200 && xhr.status < 304) {
           return true;
          } else {
           return false;
          }
         } catch (e) {
          return false;
         }

    }
    function NetStateStatus(){
        if(checkNetConnection()==false){
           $(".navbar-inner").css("background-color","#bbb !important");
        }else{
           $(".navbar-inner").css("background-color","#008853 !important");
        }
    }
    function popupcontent(url,selector){
        $(selector).fancybox({
            type: 'ajax',
            href: url
        });      
    };
</script>

