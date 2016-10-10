  <?php

    $user_pict = base_url().'/media/photos/resize/'.$_SESSION['ul_logged']['pict'];
    if($_SESSION['ul_logged']['pict']!=""){
        $user_pict_path = $_SERVER['DOCUMENT_ROOT'] .'/media/photos/resize/'.$_SESSION['ul_logged']['pict'];
        if(!file_exists($user_pict_path)){
            $user_pict = base_url().'assets/backend/img/blank-user.jpg';
        }
    }else{
        $user_pict = base_url().'assets/backend/img/blank-user.jpg';
    }

  ?>

   <div class="header navbar navbar-inverse navbar-fixed-top">
        
        <div class="navbar-inner">
            <div class="container-fluid">
 
                <a class="brand" href="<?php echo site_url();?>">
                 <img alt="logo" src="<?php echo IMG_BASE_PATH; ?>logo_home.png">
                </a>
           
                <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                <img src="<?php echo IMG_BASE_PATH; ?>menu-toggler.png" alt="" />
                </a>          
                    
                <ul class="nav pull-right">   

                    <li class="dropdown user" style="margin-top:4px;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="username"><?php echo $_SESSION['ul_logged']['nm'] ?></span>
                        <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li style="height:130px;overflow-y:hidden;"><a href="#"><img src="<?php echo $user_pict;?>" style="width:130px;"></a></li>
                            <li><a id="changeprofile" href="javascript:void(0);" onclick="popupcontent('<?php echo base_url(); ?>user/author/edit/<?php echo $_SESSION['ul_logged']['author_id']; ?>/1','#changeprofile');return false;" ><i class="icon-user"></i> Edit Profile</a></li>
                            <li><a id="changepass" href="javascript:void(0);"  onclick="popupcontent('<?php echo base_url(); ?>user/usersys/edit/<?php echo $_SESSION['ul_logged']['id']; ?>/1','#changepass');return false;" ><i class="icon-key"></i> Change Password</a></li>
                            <li style="background: beige;"><a href="<?php echo base_url() ?>office/auth/logout" onclick="return confirm('Are you sure you want to Sign Out?')"><i class="icon-off"></i> Log Out</a></li>
                        </ul>
                    </li>

                </ul>
  
            </div>
        </div>

    </div>
    
