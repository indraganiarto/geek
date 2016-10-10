<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed') ?>
<!-- BEGIN SIDEBAR MENU --> 
            <ul>
                <li>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <span class="main-menu-caption hidden-phone" id="main-menu-caption">GEEK CMS</span>
                    <div class="sidebar-toggler hidden-phone" style="margin-bottom: 14px;"></div>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                </li>
                  <?php 
					//level 1 /main menu
                     $Qlist = $this->db->query("SELECT a.* FROM office.menu_item a
												LEFT JOIN office.sys_usergroupprivileges b ON b.modul = a.menu_item_id
												LEFT JOIN office.sys_usergroups c ON c.usergroup_id = b.usergroup_id 
												LEFT JOIN office.sys_users d ON d.grp_user=c.usergroup_id
												WHERE d.id_user='".$_SESSION['ul_logged']['id']."' order by nr_seq asc");
                    if($Qlist->num_rows){
                    foreach($Qlist->result_object() as $list){ 
		
					if($list->is_has_sub == 1){ 
						if($list->is_popup_action == 1){
							$act_main = "<a rel='if_url' url='".site_url().$list->nm_action."'>".$list->label_item."</a>"; 
						}else{
							$act_main = "<a href='javascript:loadContent(\"".site_url().$list->nm_action."\");'>".$list->label_item."</a>";
						}
						
						
                ?>
                 <li class="has-sub modul" id="modul_<?php echo $list->menu_item_id; ?>">
                    <a href="javascript:;">
                    <i class="<?php echo $list->image_ins?>"></i> 
                    <span class="title"><?php echo $list->label_item?></span>
                    <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                    <?php 
                    //level 2 /submenu
                    $Qlist_item = $this->db->query("Select * From office.menu_item where nm_page ='".$list->nm_action."' and type_item = 'Proc' order by nr_seq asc");
                    if($Qlist_item->num_rows){
						foreach($Qlist_item->result_object() as $list_item){
							
							if($list_item->is_has_sub == 1){
			
					?>
							<li class="has-sub-sub">
								<a href="javascript:;">
								<i class="<?php echo $list_item->image_ins?>"></i> 
								<span class="title"><?php echo $list_item->label_item?></span>
								<span class="arrow "></span>
								</a>
								<ul class="sub-sub">
								<?php
									//level 3/subsubmenu
									$Qlist_subitem = $this->db->query("Select * From office.menu_item where nm_page ='".$list_item->nm_action."' and type_item = 'SubMenu' order by nr_seq asc");
									if($Qlist_item->num_rows){
										foreach($Qlist_subitem->result_object() as $list_subitem){
											if($list_subitem->is_popup_action == 1){
												$act_submenu = "<a rel='if_url' url='".site_url().$list_subitem->nm_action."'>".$list_subitem->label_item."</a>"; 
											}else{
												$act_submenu = "<a href='javascript:loadContent(\"".site_url().$list_subitem->nm_action."\");'>".$list_subitem->label_item."</a>";
											}
								?>	
									
									<li><?php echo $act_submenu ?></li>
								
								<?php
										}
									}
								?>
								</ul>
							</li>
								
					<?php			
							}else{  
								if($list_item->is_popup_action == 1){
									$act = "<a rel='if_url' url='".site_url().$list_item->nm_action."'>".$list_item->label_item."</a>"; 
								}else{
									$act = "<a href='javascript:loadContent(\"".site_url().$list_item->nm_action."\",\"".$list->menu_item_id."\",\"".$list_item->menu_item_id."\",$.cookie(\"current_url\"));'>".$list_item->label_item."</a>";
								}
						?>  

						<li class="menu" id="menu_<?php echo $list_item->menu_item_id; ?>"><?php echo $act ?></li>

						<?php 
							}
						}
                    }?>
                        
                    </ul>
                </li>
                <?php }else{ 
						if($list->is_popup_action == 1){
							$act_main = "<a rel='if_url' url='".site_url().$list->nm_action."'><i class='".$list->image_ins."'></i><span class='title'>".$list->label_item."</span></a>"; 
						}else{
							$act_main = "<a href='javascript:loadContent(\"".site_url().$list->nm_action."\",null,null,$.cookie(\"current_url\"));'><i class='".$list->image_ins."'></i><span class='title'>".$list->label_item."</span></a>";
						}
				?>
					<li class="has-sub" id="modul_<?php echo $list->menu_item_id; ?>"><?php echo $act_main; ?></li>
				<?php }
                } }
                
                ?>
                
            </ul>
            <!-- END SIDEBAR MENU -->
