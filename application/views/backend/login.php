<?php
  /*
  *@define resources base path
  */
  define('JS_BASE_PATH',base_url().'assets/js/');
  define('CSS_BASE_PATH',base_url().'assets/css/');
  define('IMG_BASE_PATH',base_url().'assets/img/');
  define('PLUGINS_BASE_PATH',base_url().'assets/plugins/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Ulin ULin | Admin</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link href="<?php echo PLUGINS_BASE_PATH; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo CSS_BASE_PATH; ?>metro.css" rel="stylesheet" />
  <link href="<?php echo PLUGINS_BASE_PATH; ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="<?php echo CSS_BASE_PATH; ?>style.css" rel="stylesheet" />
  <link href="<?php echo CSS_BASE_PATH; ?>style_responsive.css" rel="stylesheet" />
  <link href="<?php echo CSS_BASE_PATH; ?>style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_BASE_PATH; ?>uniform/css/uniform.default.css" />
  <link rel="shortcut icon" href="<?php echo IMG_BASE_PATH; ?>favicon.ico" />
</head>

<body class="login">

  <div class="logo">
    <img src="<?php echo base_url().'static/'?>/img/logo.png" alt="" /> 
  </div>

  <div class="content">

       <form action="<?php echo base_url() ?>index.php/auth/login" method="post" id="iforms_f5" onsubmit="return iForms_s(5)">
         <input type="hidden" id="timereload" value="1" />
          <h3 class="form-title">Login to your account</h3>
          
          <div class="alert alert-error hide">
            <button class="close" data-dismiss="alert"></button>
            <span>Enter any username and passowrd.</span>
          </div>
          <div class="control-group">
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <div class="controls">
              <div class="input-icon left">
                <i class="icon-user"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username"/>
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="controls">
              <div class="input-icon left">
                <i class="icon-lock"></i>
                <input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password"/>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <label class="checkbox">
            <input type="checkbox" name="remember" value="1"/> Remember me
            </label>
            <button type="submit" class="btn green pull-right">
            Login <i class="m-icon-swapright m-icon-white"></i>
            </button>            
          </div>
           
        </form>
     <div id="iforms_r5" style="text-align:center;font-size:12px"></div>
  </div>

  <div class="copyright">
    2014 &copy; Ulin Ulin Indonesia.
  </div>

  <script src="<?php echo JS_BASE_PATH; ?>jquery-1.8.3.min.js"></script>
  <script src="<?php echo PLUGINS_BASE_PATH; ?>bootstrap/js/bootstrap.min.js"></script>  
  <script src="<?php echo PLUGINS_BASE_PATH; ?>uniform/jquery.uniform.min.js"></script> 
  <script src="<?php echo JS_BASE_PATH; ?>jquery.blockui.js"></script>
  <script src="<?php echo PLUGINS_BASE_PATH; ?>jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="<?php echo JS_BASE_PATH; ?>app.js"></script>
  <script>
    jQuery(document).ready(function() {     
      App.initLogin();
    });
  </script>
   <script language="javascript" src="<?php echo JS_BASE_PATH; ?>form.js"></script> 
  <script language="javascript" src="<?php echo JS_BASE_PATH; ?>login.js"></script>  

</body>
</html>
