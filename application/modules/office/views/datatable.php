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
                                if(isset($header)){
                                    echo $header;
                                }
                            ?>   
                             <script type="text/javascript">
                                    $(document).ready(function() {
                                        var oTable = $('#big_table').dataTable( {
                                            "bProcessing": true,
                                            "bServerSide": true,
                                            "sAjaxSource": '<?php echo $callback; ?>',
                                                    "bJQueryUI": false,
                                                    "sPaginationType": "full_numbers",
                                                    "iDisplayStart ":20,
                                                    "oLanguage": {
                                                "sProcessing": "<img src='<?php echo base_url(); ?>assets/backend/img/ajax-loader_dark.gif'>"
                                            },  
                                            "fnInitComplete": function() {
                                                    //oTable.fnAdjustColumnSizing();
                                             },
                                                    'fnServerData': function(sSource, aoData, fnCallback)
                                                {
                                                  $.ajax
                                                  ({
                                                    'dataType': 'json',
                                                    'type'    : 'POST',
                                                    'url'     : sSource,
                                                    'data'    : aoData,
                                                    'success' : fnCallback
                                                  });
                                                }
                                        } );
                                    } );
                                    function deleteRow(id,url,dummypost){

                                        var data = { ID : id }
                                        var r = confirm("Are you sure want to delete this row?");
                                        
                                        if (r == true) {
                                            $.post(url,data,function(res){
                                                alert(res.msg);
                                                if(dummypost){
                                                    loadContent($.cookie("current_url") + "/true",$.cookie("current_modul"),$.cookie("current_menu"));
                                                }else{
                                                    loadContent($.cookie("current_url"),$.cookie("current_modul"),$.cookie("current_menu"));
                                                }
                                            },'json');
                                        }else{
                                          
                                        }
                                        return false;
                                    
                                    }
                            </script>
                            <?php echo $this->table->generate(); ?>
                        </div>
                    </div>
                </div>