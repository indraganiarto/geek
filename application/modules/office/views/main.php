<?php
  /*
  *@define resources base path
  */

  define('JS_BASE_PATH',base_url().'assets/backend/js/');
  define('CSS_BASE_PATH',base_url().'assets/backend/css/');
  define('IMG_BASE_PATH',base_url().'assets/backend/img/');
  define('PLUGINS_BASE_PATH',base_url().'assets/plugins/');
  define('META_DESCRIPTION','Geek Administrator Page');
  define('META_TITLE','Geek | Admin');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="<?php echo PLUGINS_BASE_PATH; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo CSS_BASE_PATH; ?>metro.css" rel="stylesheet" />
<link href="<?php echo PLUGINS_BASE_PATH; ?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="<?php echo PLUGINS_BASE_PATH; ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo CSS_BASE_PATH; ?>style.css" rel="stylesheet" />
<link href="<?php echo CSS_BASE_PATH; ?>style_responsive.css" rel="stylesheet" />
<link href="<?php echo CSS_BASE_PATH; ?>style_light.css" rel="stylesheet" id="style_color" />
<link href="<?php echo CSS_BASE_PATH; ?>validationEngine.jquery.css" rel="stylesheet" id="style_color" />
<link href="<?php echo CSS_BASE_PATH; ?>jquery.dataTables.css" rel="stylesheet" id="style_color" />
<link href="<?php echo PLUGINS_BASE_PATH; ?>ckeditor/skins/moono/editor.css?t=D08E" rel="stylesheet" type="text/css" >
<script language="javascript">var HOST="<?php echo base_url()?>";</script>

<?php $this->load->view('meta'); ?>
    
</head>

<body class="fixed-top">
    <?php $this->load->view('header'); ?>
    
    <div class="page-container row-fluid">
        <div class="page-sidebar nav-collapse collapse">
        <?php $this->load->view('sidebar'); ?>
        </div>
        <div class="page-content" id="ulin-wrapper">
        <?php $this->load->view($target); ?>
        </div>
    </div>

    <?php $this->load->view('footer'); ?>
</body>
</html>
