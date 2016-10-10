<?php
############################################
# Author : Indra Ganiarto                  #
# Email : indra.developer.web.id@gmail.com #
############################################

class Dtform {


	function __construct($params=null){

		$this->ci =& get_instance();
		$this->ci->load->model('ifunction');
		$this->ci->load->library('ckeditor');
		$this->ci->load->library('ckfinder');

		if($params != null){

			$this->params = $params;

		}else{

			$err = array('status' => 0,'error' => 'Missing Parameter!!' );
			echo json_encode($err);

		}

	}

	function generate(){

		switch ($this->params['action']) {
			case '1':
				# generate add form
				$this->build_add_form();
				break;
			case '2':
				# generate edit form
				$this->build_edit_form();
				break;
			
		}

	}
	function build_add_form(){

				$fields = $this->params['form']['add'];
				$form = "";
				foreach(array_keys($fields) as $title){
					$input_type = @$fields[$title]['type'];
					$fields_param['attribute'] = $fields[$title];
					$fields_param['title'] = $title;
					$fields_param['action'] = 1;
					
				
					switch($input_type){
						case "text" :
							$fields_param['custom_type'] = 0;
							$form .= $this->renderInputText($fields_param);
							break;
						case "file" :
							$form .= $this->renderInputImage($fields_param);
							break;
						case "number" :
							$fields_param['custom_type'] = 1;
							$form .= $this->renderInputText($fields_param);
							break;
						case "hidden" :
							$fields_param['custom_type'] = 2;
							$form .= $this->renderInputText($fields_param);
							break;
						case "password" :
							$fields_param['custom_type'] = 3;
							$form .= $this->renderInputText($fields_param);
							break;
						case "date" :
							$fields_param['custom_type'] = 4;
							$form .= $this->renderInputText($fields_param);
							break;
						case "datetime" :
							$fields_param['custom_type'] = 5;
							$form .= $this->renderInputText($fields_param);
							break;
						case "time" :
							$fields_param['custom_type'] = 6;
							$form .= $this->renderInputText($fields_param);
							break;
						case "textarea" :
							$form .= $this->renderInputTextarea($fields_param);
							break;	
						case "editor" :
							$form .= $this->renderTextEditor($fields_param);
							break;
						case "editor2" :
							$form .= $this->renderTextEditorV2($fields_param);
							break;
						case "sourcequery" :
							$form .= $this->renderSourceQuery($fields_param);
							break;
						case "sourcearray" :
							$form .= $this->renderSourceArray($fields_param);
							break;
						case "radio" :
							$form .= $this->renderRadioButton($fields_param);
							break;
						case "map" :
							$form .= $this->renderGeoLocation($fields_param);
							break;
						case "custom_input" :
							$form .= $fields_param['attribute']['html'];
							break;
					}

				}
				$this->form_container($form);

	}
	function build_edit_form(){
				
				$fields = $this->params['form']['edit'];
				$table = $this->params['table'];
				$key = $this->params['key'];
				$id = $this->params['edit']['id'];
				$sql = "SELECT * FROM ".$table." WHERE ".$key."='".$id."'";
				
				$query = $this->ci->db->query($sql);
				$result = $query->result_array();
				$fields = $this->params['form']['edit'];

				$form = "";
				foreach(array_keys($fields) as $title){
					$input_type = @$fields[$title]['type'];
					$fields_param['attribute'] = $fields[$title];
					$fields_param['title'] = $title;
					$fields_param['action'] = 2;
					$fields_param['result'] = @$result[0];
				
					switch($input_type){
						case "text" :
							$fields_param['custom_type'] = 0;
							$form .= $this->renderInputText($fields_param);
							break;
						case "file" :
							$form .= $this->renderInputImage($fields_param);
							break;
						case "number" :
							$fields_param['custom_type'] = 1;
							$form .= $this->renderInputText($fields_param);
							break;
						case "hidden" :
							$fields_param['custom_type'] = 2;
							$form .= $this->renderInputText($fields_param);
							break;
						case "password" :
							$fields_param['custom_type'] = 3;
							$form .= $this->renderInputText($fields_param);
							break;
						case "date" :
							$fields_param['custom_type'] = 4;
							$form .= $this->renderInputText($fields_param);
							break;
						case "datetime" :
							$fields_param['custom_type'] = 5;
							$form .= $this->renderInputText($fields_param);
							break;
						case "time" :
							$fields_param['custom_type'] = 6;
							$form .= $this->renderInputText($fields_param);
							break;
						case "textarea" :
							$form .= $this->renderInputTextarea($fields_param);
							break;	
						case "editor" :
							$form .= $this->renderTextEditor($fields_param);
							break;
						case "editor2" :
							$form .= $this->renderTextEditorV2($fields_param);
							break;
						case "sourcequery" :
							$form .= $this->renderSourceQuery($fields_param);
							break;
						case "sourcearray" :
							$form .= $this->renderSourceArray($fields_param);
							break;
						case "radio" :
							$form .= $this->renderRadioButton($fields_param);
							break;
						case "map" :
							$form .= $this->renderGeoLocation($fields_param);
							break;
						case "custom_input" :
							$form .= $fields_param['attribute']['html'];
							break;
					}

				}
				$this->form_container($form);

	}


	function form_container($attribute=null){
			if($this->params['action']==1){
				$frm = 'postinsert';
			}else{
				$frm = 'postupdate';
			}
			$brc = "";
			$bb = "";
			$boxcontent = "min-height:500px;";
			if(!isset($this->params['form']['breadcrumb_disabled'])){
				$brc = '<ul class="breadcrumb">'.$this->params['form']['breadcrumb'].'</ul>';
			}
			if(!isset($this->params['form']['back_disabled'])){
				$bb = '<a href="javascript:loadContent($.cookie(\'history_url\'),$.cookie(\'current_modul\'),$.cookie(\'current_menu\'),$.cookie(\'current_url\'));" class="btn default">Back</a>';
			}
			if(isset($this->params['form']['container_style'])){
				$boxcontent = $this->params['form']['container_style'];
			}
			$html = $this->params['form']['jsscript'];
			$html.= '<div class="container-fluid">
					<div class="row-fluid">
					<div class="span12">'.$brc.'</div>
					</div>
					<div>
					<div class="row-fluid" style="background-color: white;">
					<div class="span12">
					<div class="portlet">
					<div class="portlet-title" style="height:45px;">
					<h4>'.$this->params['form']['title'].'</h4>
					<div class="tools">
					<span>'.$bb.@$this->params['form']['cmd']['top'].'</span>
					</div>
					</div>
					<div class="portlet-body">        
					<div class="content-box">
					<div class="content-box-header-frm"><h3>'.$this->params['form']['header'].'</h3></div>
					<div class="content-box-content" style="'.$boxcontent.'">
					<div id="report"></div>
					<form id="'.$frm.'">
					<table border="0" width="100%">
					';
			$html.= $attribute;
			$html.= '<tr height="40"><td colspan="2"></td><td><input type="submit" id="submits" class="btn orange" value="Submit" /> <input type="reset" class="btn" value="Reset" /></td></tr>';
			$html.='</table>
					</form>
					</div>
					</div>';
			if(isset($this->params['disabled_js_init'])){
				if($this->params['disabled_js_init']==false){
					$html.= $this->js_plugin();
				}
			}else{
				$html.= $this->js_plugin();
			}

			echo $html;
			
	}

	function run_process(){

		switch ($this->params['action']) {
			case '1':
				$this->insert_data($this->params);
				break;
			case '2':
				$this->update_data($this->params);
				break;
			case '3':
				$this->delete_data($this->params);
				break;
		}

	}
	function getnum_rows($sql=null){
		
		return $this->ci->db->query($sql)->num_rows();
				
	}
	function insert_data($params){

		$post = $params['post']['insert'];
		$key = $params['key'];
		$table = $params['table'];
		$key_value = $post[$key];
		if($key_value!=""){
			$sql = "SELECT * FROM ".$table." WHERE ".$key."='".$key_value."'";
			$num_rows = $this->getnum_rows($sql);
		}else{
			$num_rows = 0;
		}
		if(isset($post['path'])){
			unset($post['path']);
		}
		if(isset($post['title'])){
			$post['title'] = htmlentities($post['title'], ENT_COMPAT);
		}
		if(isset($params['autoincrement'])){
			if($params['autoincrement']=="true"){
				unset($post[$key]);
			}
		}
		if($num_rows>0){
			$send_report = 2;
		}else{
			$query = $this->ci->db->insert($table,$post);
			if($query){
				$send_report = 1;
			}else{
				$send_report = 0;
			}
			echo $send_report;
		}

	}
	function delete_data($params){

		$id = $params['post']['delete'];
		$key = $params['key'];
		$table = $params['table'];
		
		$query = $this->ci->db->delete($table, array($key => $id)); 
		if($query){
			$res = array("status" => 1 , "msg" => "ID[$id] have been deleted successfully!");
		}else{
			$res = array("status" => 0 , "msg" => "Failed! There is something wrong when deleted row ID[$id]!");
		}
		echo json_encode($res);
	}
	function update_data($params){

		
			$post = $params['post']['update'];
			$key = $params['key'];
			$table = $params['table'];

			if(isset($post['path'])){
				unset($post['path']);
			}
			if(isset($post['title'])){
				$post['title'] = htmlentities($post['title'], ENT_COMPAT);
			}
			$b = array_keys($post);
			$a = count($b);
			for ($i = 0; $i < $a; $i++) {
				if($b[$i] != $key){
					$fields[$i]= $b[$i]."='".pg_escape_string($post[$b[$i]])."'";
				}else{
					$id= $post[$b[$i]];
				}
			}
			
			$fields_update = implode($fields,",");
			$sqlupdate="UPDATE ".$table." SET ".$fields_update." WHERE ".$key."='".$id."'";
			//echo $sqlupdate;exit
			$query=$this->ci->db->query($sqlupdate);
			if($query){
				$send_report = 1;
			}else{
				$send_report = 0;
			}
			echo $send_report;


	}
	function renderInputText($params){

		$title = $params['title'];
		$display = "table-row";
		$row_id = "";
		if($this->ci->lang->line($title)!=""){
			$field_caption = $this->ci->lang->line($title);
		}else{
			$field_caption =  $title;
		}
		if(isset($params['attribute']['label'])){
			$label = $params['attribute']['label'];
		}else{
			$label = $field_caption;
		}
		if(isset($params['attribute']['display'])){
			$display = $params['attribute']['display'];
		}
		if(isset($params['attribute']['row_id'])){
			$row_id = "id='".$params['attribute']['row_id']."'";
		}
		$class_type = $this->validateInput($params);
		$set_class = $this->setClassAttr($params);
		$maxlength = $this->setMaxLength($params);
		$attr = $this->setReadOnly($params);
		$disabled = $this->setDisabled($params);
		$style = $this->setCustomStyle($params);
		$hidden = "";
		$date_format = "";
		if($params['action']==2){
			$val = @$params['result'][$title];
		}else{
			$val = $this->setInputValue($params);
		}
		$jsinclude = "";
		if(isset($params['custom_type'])){
			if($params['custom_type']==1){
				$type = "text";
				$class_type = "numbersOnly";
			}elseif ($params['custom_type']==2){
				$type = "hidden";
				$hidden = "style='display:none;'";
		    }elseif ($params['custom_type']==3){
				$type = "password";
				$val = "";
			}elseif ($params['custom_type']==4){
				$type = "text";
				$class_type = "input-datepicker";
				$date_format = 'data-date-format="yyyy-mm-dd"';
			}elseif ($params['custom_type']==5){
				$jsinclude = "<script>
								$('#".$title."').datetimepicker({
						          language: 'pt-BR'
						        });
							 </script>";
			}elseif ($params['custom_type']==6){
				$type = "text";
				$jsinclude = "<script>
								$('#".$title."').timepicker({
					                minuteStep: 1,
					                showSeconds: true,
					                showMeridian: false,
					                defaultTime: false
					            });
							 </script>";
			}else{
				$type = "text";
			}
		}else{
			$type = "text";
		}
		if($params['custom_type']==5){
			$input = '<tr height="30" '.$hidden.' height="30" '.$row_id.' style="display:'.$display.';"><td width="120" class="pt9">'.$label.'</td><td width="10" class="pt9">:</td>
						<td colspan="2">
							<div id="'.$title.'" class="input-append date">
							    <input '.$disabled.' '.$style.' '.$attr.' '.$maxlength.' data-format="yyyy-MM-dd hh:mm:ss" type="text" name="'.$title.'" placeholder="'.$title.'" '.$date_format.' class="inputbox '.$set_class.' '.$class_type.'" value=\''.$val.'\' />
							    <span class="add-on" style="height: 20px;border: solid 1px #ccc;">
							      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
							      </i>
							    </span>
							</div>
							'.$jsinclude.'
						</td>
					  </tr>';
		}else{
			$input = '<tr height="30" '.$hidden.' height="30" '.$row_id.' style="display:'.$display.';"><td width="120" class="pt9">'.$label.'</td><td width="10" class="pt9">:</td><td colspan="2"><input '.$disabled.' '.$style.' '.$attr.' '.$maxlength.' type="'.$type.'" name="'.$title.'" id="'.$title.'" placeholder="'.$title.'" '.$date_format.' class="inputbox '.$set_class.' '.$class_type.'" value=\''.$val.'\' />'.$jsinclude.'</td></tr>';
		}
		return $input;
		
	}

	function renderInputImage($params){
		$name = "file";
		$title = $params['title'];
		$display = "table-row";
		$row_id = "";
		$style = $this->setCustomStyle($params);
		if(isset($params['attribute']['upload_dir'])){
			$path = $params['attribute']['upload_dir'];
		}else{
			$path = "default";
		}
		if(isset($params['attribute']['initial'])){
			$name = $params['attribute']['initial'];
		}
		if(isset($params['attribute']['display'])){
			$display = $params['attribute']['display'];
		}
		if(isset($params['attribute']['row_id'])){
			$row_id = "id='".$params['attribute']['row_id']."'";
		}
		if($this->ci->lang->line($title)!=""){
			$field_caption = $this->ci->lang->line($title);
		}else{
			$field_caption =  $title;
		}
		if(isset($params['attribute']['label'])){
			$label = $params['attribute']['label'];
		}else{
			$label = $field_caption;
		}
		if($params['action']==2){
			$val = @$params['result'][$title];
		}else{
			$val = $this->setInputValue($params);
		}
		if($params['action']==2){
			$input = '<tr height="30" '.$row_id.' style="display:'.$display.';"><td class="pt9">'.@$label.'</td><td class="pt9">:</td><td><input type="file" name="'.$name.'" id="'.$name.'" class="inputfile"><input type="hidden" '.$style.' name="old_'.$name.'" value="'.@$val.'"></td></tr>';
		}else{
			$input = '<tr height="30" '.$row_id.' style="display:'.$display.';"><td class="pt9">'.@$label.'</td><td class="pt9">:</td><td><input type="file" name="'.$name.'" id="'.$name.'" class="inputfile"><input type="hidden" '.$style.' name="path" value="'.@$path.'"></td></tr>';
		}
		return $input;

	}
	function renderInputTextarea($params){
				$title = $params['title'];
				if($this->ci->lang->line($title)!=""){
					$field_caption = $this->ci->lang->line($title);
				}else{
					$field_caption =  $title;
				}
				if(isset($params['attribute']['label'])){
					$label = $params['attribute']['label'];
				}else{
					$label = $field_caption;
				}
				$class_type = $this->validateInput($params);
				$set_class = $this->setClassAttr($params);
				$attr = $this->setReadOnly($params);
				$style = $this->setCustomStyle($params);
				
				if($params['action']==2){
					$val = $params['result'][$title];
				}else{
					$val = $this->setInputValue($params);
				}
				
				$input = '<tr height="30"><td class="pt9">'.$label.'</td><td class="pt9">:</td><td style="padding-bottom:10px;"><textarea '.$attr.' name="'.$title.'"  class="'.$set_class.' form-control '.$class_type.'" placeholder="'.$title.'" '.$style.'>'.$val.'</textarea></td></tr>';
							 
				return $input;
	}
	function renderTextEditor($params){
				$title = $params['title'];
				if($this->ci->lang->line($title)!=""){
					$field_caption = $this->ci->lang->line($title);
				}else{
					$field_caption =  $title;
				}
				if(isset($params['attribute']['label'])){
					$label = $params['attribute']['label'];
				}else{
					$label = $field_caption;
				}

				if($params['action']==2){
					$val = $params['result'][$title];
				}else{
					$val = $this->setInputValue($params);
				}

				$input = '<tr height="290">
							<td class="pt9">'.$label.'</td><td class="pt9">:</td>
							<td style="padding-bottom:10px;"><textarea id="'.$title.'" class="ckeditor w510 h250"  rows="3">'.$val.'</textarea><input type="hidden" id="ck_'.$title.'" name="'.$title.'"></td>
							<script>
								CKEDITOR.replace( "'.$title.'",
								{
									toolbar : "MyToolbar",
									width:"100%"
									
								});
							</script>
						 </tr>';
				return $input;
	}
	function renderTextEditorV2($params){

				$title = $params['title'];
				if($this->ci->lang->line($title)!=""){
					$field_caption = $this->ci->lang->line($title);
				}else{
					$field_caption =  $title;
				}
				if(isset($params['attribute']['label'])){
					$label = $params['attribute']['label'];
				}else{
					$label = $field_caption;
				}

				if($params['action']==2){
					$val = $params['result'][$title];
				}else{
					$val = $this->setInputValue($params);
				}

				$input = '<tr height="290">
							<td class="pt9">'.$label.'</td><td class="pt9">:</td>
							<td style="padding-bottom:10px;" id="ckwrapper_'.$title.'"></td>
							<td style="display:none;"><input type="hidden" id="ck_'.$title.'" name="'.$title.'"></td>
						 </tr>';
				return $input;
	}
	function renderSourceQuery($params){
			$title = $params['title'];
			$set_class = $this->setClassAttr($params);
			if($this->ci->lang->line($title)!=""){
				$field_caption = $this->ci->lang->line($title);
			}else{
				$field_caption =  $title;
			}
			if(isset($params['attribute']['label'])){
				$label = $params['attribute']['label'];
			}else{
				$label = $field_caption;
			}
			if(isset($params['attribute']['multiselect'])){
				if($params['attribute']['multiselect']==true){
					$multi = "multiple";
				}else{
					$multi = "";
				}
			}else{
				$multi = "";
			}
			if(isset($params['attribute']['append'])){
				$append = $params['attribute']['append'];
			}else{
				$append = "";
			}
			$style = $this->setCustomStyle($params);
			$attr = $this->setDisabled($params);
			if($params['action']==2){
					$input = '<tr height="45" id="tr_'.$title.'"><td class="pt9">'.$label.'</td><td class="pt9">:</td>
								<td colspan="2" id="td_'.$title.'">
								<select class="'.$set_class.'" '.$attr.' name="'.$title.'" '.$style.' '.$multi.' id="'.$title.'">';
						foreach($params['attribute']['data'] as $row){
							if($multi!=""){
								$arr_result = explode(',',$params['result'][$title]);
								if(in_array($row['valuedt'],$arr_result)){
									$input .='	<option selected value="'.$row['keydt'].'">'.$row['valuedt'].'</option>';
								}else{
									$input .='	<option value="'.$row['keydt'].'">'.$row['valuedt'].'</option>';
								}
							}else{
								if($row['keydt']!=$params['result'][$title]){
									$input .='	<option value="'.$row['keydt'].'">'.$row['valuedt'].'</option>';
								}else{
									$input .='	<option selected value="'.$row['keydt'].'">'.$row['valuedt'].'</option>';
								}
							}
						}
					$input .='</select>'.$append.'
							 </td>
							 </tr>';
			}else{
				
					$input = '<tr height="45" id="tr_'.$title.'"><td class="pt9">'.$label.'</td><td class="pt9">:</td>
								<td colspan="2" id="td_'.$title.'">
						 		 <select class="'.$set_class.'" name="'.$title.'" '.$style.' '.$multi.' id="'.$title.'">';
						foreach($params['attribute']['data'] as $row){
							$input .='	<option value="'.$row['keydt'].'">'.$row['valuedt'].'</option>';
						}
					$input .='</select>'.$append.'
							</td>
							</tr>';

			}
			return $input;
	}
	function renderSourceArray($params){
				$title = $params['title'];
				if($this->ci->lang->line($title)!=""){
					$field_caption = $this->ci->lang->line($title);
				}else{
					$field_caption =  $title;
				}
				if(isset($params['attribute']['label'])){
					$label = $params['attribute']['label'];
				}else{
					$label = $field_caption;
				}
				$b = array_keys($params['attribute']['data']);
				$a = count($b);
				if($params['action']==2){
					$input = '<tr height="45" id="tr_'.$title.'"><td class="pt9">'.$label.'</td><td class="pt9">:</td>
								<td colspan="2">	  
							  	<select class="select-chosen" name="'.$title.'" style="min-width:80px;" id="'.$title.'">';
								for ($i = 0; $i < $a; $i++) {
									if($b[$i]!=$params['result'][$title]){
										$input.= '<option value="'.$b[$i].'">'.$params['attribute']['data'][$b[$i]].'</option>';
									}else{
										$input.= '<option selected value="'.$b[$i].'">'.$params['attribute']['data'][$b[$i]].'</option>';
									}
								}
					$input .='</select>
							 <td>
							 </tr>';
				}else{
					$input = '<tr height="45" id="tr_'.$title.'"><td class="pt9">'.$label.'</td><td class="pt9">:</td>
							  <td colspan="2">
							  <select class="select-chosen" name="'.$title.'" style="min-width:80px;" id="'.$title.'">';
						for ($i = 0; $i < $a; $i++) {
							$input.= '<option value="'.$b[$i].'">'.$params['attribute']['data'][$b[$i]].'</option>';
						}
					$input .='</select>
							  <td>
							  </tr>';
				}
				return $input;
	}
	function renderRadioButton($params){
				$title = $params['title'];
				$onclick = "";
				if($this->ci->lang->line($title)!=""){
					$field_caption = $this->ci->lang->line($title);
				}else{
					$field_caption =  $title;
				}
				if(isset($params['attribute']['label'])){
					$label = $params['attribute']['label'];
				}else{
					$label = $field_caption;
				}
				if(isset($params['attribute']['onclick'])){
					$onclick = $params['attribute']['onclick'];
				}
				$b = array_keys($params['attribute']['data']);
				$a = count($b);
				if($params['action']==2){
					$input = '<tr height="45"><td class="pt9">'.$label.'</td><td class="pt9">:</td>
								<td colspan="2">';
								for ($i = 0; $i < $a; $i++) {
									if($b[$i]!=$params['result'][$title]){
										$input.= '<label style="display:inline"><input onclick="'.$onclick.'" style="vertical-align: top;margin-right: 5px;" type="radio" name="'.$title.'" value="'.$b[$i].'" />'.$params['attribute']['data'][$b[$i]].'</label><span style="padding:0 10px">&nbsp;</span>';
									}else{
										$input.= '<label style="display:inline"><input onclick="'.$onclick.'" style="vertical-align: top;margin-right: 5px;" type="radio" name="'.$title.'" value="'.$b[$i].'" checked />'.$params['attribute']['data'][$b[$i]].'</label><span style="padding:0 10px">&nbsp;</span>';
									}
								}
					$input .='<td>
							 </tr>';
				}else{
					$input = '<tr height="45"><td class="pt9">'.$label.'</td><td class="pt9">:</td>
							  <td colspan="2">
							  ';
						for ($i = 0; $i < $a; $i++) {
							$input.= '<label style="display:inline"><input onclick="'.$onclick.'" style="vertical-align: top;margin-right: 5px;" type="radio" name="'.$title.'" value="'.$b[$i].'" />'.$params['attribute']['data'][$b[$i]].'</label><span style="padding:0 10px">&nbsp;</span>';
						}
					$input .='<td>
							  </tr>';
				}
				return $input;
	}
	function renderGeoLocation($params){
				$title = $params['title'];
				if($this->ci->lang->line($title)!=""){
					$field_caption = $this->ci->lang->line($title);
				}else{
					$field_caption =  $title;
				}
				if(isset($params['attribute']['label'])){
					$label = $params['attribute']['label'];
				}else{
					$label = $field_caption;
				}
				if($params['action']==2){
					$input = '<tr height="30"><td class="pt9" rowspan="2">'.$label.'</td><td class="pt9" rowspan="2">:</td><td><input type="text"  id="postcode" class="inputbox w385" autocomplete="off" placeholder="Find Location:" style="margin-top: 11px;"> <input type="button" id="findbutton" class="btn" value="Find" /><input type="text" name="latitude" id="latitude" class="inputbox w240" placeholder="Latitude" value="'.@$params['result']['latitude'].'" style="margin-top:11px;float:right;"/></td><td><input type="text" name="longitude" class="inputbox w240" id="longitude" placeholder="Longitude" value="'.@$params['result']['longitude'].'" style="margin-top:11px;margin-left: 25px;"/></td></tr>
							  <tr><td colspan="2"><p><div id="geomap" style="width:100%;height:300px">Loading...</div></p></td></tr>';
				}else{
					$input = '<tr height="30"><td class="pt9" rowspan="2">'.$label.'</td><td class="pt9" rowspan="2">:</td><td><input type="text"  id="postcode" class="inputbox w385" autocomplete="off" placeholder="Find Location:" style="margin-top: 11px;"> <input type="button" id="findbutton" class="btn" value="Find" /><input type="text" name="latitude" id="latitude" class="inputbox w240" placeholder="Latitude" value="" style="margin-top:11px;float:right;"/></td><td><input type="text" name="longitude" class="inputbox w240" id="longitude" placeholder="Longitude" value="" style="margin-top:11px;margin-left: 25px;"/></td></tr>
							  <tr><td colspan="2"><p><div id="geomap" style="width:100%;height:300px">Loading...</div></p></td></tr>';
				}
				$input .= '<script>
								 var ready;
								 ready = function() {
							      var script = document.createElement("script");
							      script.type = "text/javascript";
							      script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&" + "libraries=places&"+"callback=initialize";
							      document.body.appendChild(script);
							    };
								 $.getScript("'.base_url().'static/js/mapinit.js",function(){
							          $(document).ready(ready);
							     });
						  </script>';
				return $input;
	}
	function validateInput($params){
			if(isset($params['attribute']['validation'])){
				if($params['attribute']['validation']=="required"){
						$class_type = "validate[required]";
				}elseif($params['attribute']['validation']=="email"){
						$class_type = "validate[required,custom[email]]";
				}elseif($params['attribute']['validation']=="number"){
						$class_type = "validate[number]";
				}
			}else{
						$class_type = "";
			}
			return $class_type;
	}
	function setClassAttr($params){
			if(isset($params['attribute']['class'])){
				$set_class = $params['attribute']['class'];
			}else{
				$set_class = "";
			}
			return $set_class;
	}
	function setMaxLength($params){
			if(isset($params['attribute']['maxlength'])){
				$maxlength = "maxlength=".$params['attribute']['maxlength'];
			}else{
				$maxlength = "";
			}
			return $maxlength;
	}
	function setReadOnly($params){
			if(isset($params['attribute']['isreadonly'])){
				$attr = "readonly";
			}else{
				$attr = "";
			}
			return $attr;
	}
	function setDisabled($params){
			if(isset($params['attribute']['isdisabled'])){
				$attr = "disabled";
			}else{
				$attr = "";
			}
			return $attr;
	}
	function setCustomStyle($params){
			$requiredstyle = "";
			if(isset($params['requiredstyle'])){
				$requiredstyle = $params['requiredstyle'];
			}
			if(isset($params['attribute']['style'])){
				$style = "style='".$params['attribute']['style'].";".$requiredstyle."'";
			}else{
				$style = "style='".$requiredstyle."'";
			}
			return $style;
	}
	function setInputValue($params){
			if(isset($params['attribute']['value'])){
				$val = $params['attribute']['value'];
			}else{
				if(isset($params['custom_type'])){
					if($params['custom_type']==1){
						$val = "0";
					}else{
						$val = "";
					}
				}else{
					$val = "";
				}
			}
			return $val;
	}
	function js_plugin(){
		$js ='<script type="text/javascript" src="'.base_url().'static-frontend/js/proxy.php?f=jquery-ui"></script>';
		$js.='<script type="text/javascript">
					
					var PostCodeid = "#postcode";
					var longval = "#longitude";
					var latval = "#latitude";
					var geocoder;
					var map;
					var marker;

					jQuery(".numbersOnly").keyup(function () { 
					    this.value = this.value.replace(/[^0-9\.]/g,"");
					});
					jQuery(document).ready(function () {
						$("#postinsert").validationEngine(); 
						$("#postupdate").validationEngine();

						if($("#postinsert").length>0){
                            $("#postinsert").data("serialize",$("#postinsert").serialize());
                        }

                        if($("#postupdate").length>0){
                            $("#postupdate").data("serialize",$("#postupdate").serialize());
                        }
                        $(window).bind("beforeunload", function(e){
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
                        });
					  	$("#postinsert").submit(function(){
							
							var data = $(this).serialize();
				            var loader = "<span>Saving... Please Wait..</span><br><img src=\''.base_url().'static/img/preload.GIF\'/><br><span id=\'upload-progress\' style=\'display:none\'></span>";
				            var target = "'.site_url().@$this->params['form']['insert']['url'].'";
				            var formData = new FormData($(this)[0]);
				            var progress = $("#report");
				            var body = $("html, body");

				            if($("#postinsert").validationEngine("validate")){

				            	$("#submits").attr("disabled","disabled");
					            progress.addClass("loading-page");
					            progress.html(loader);
					            progress.show();
					            $.ajax({
					                   url: target,
					                   data: formData,
					                   async: true,
					                   contentType: false,
					                   processData: false,
					                   cache: false,
					                   type: "POST",
					                   xhr: function()
                                          {
                                            var xhr = new window.XMLHttpRequest();
                                            //Upload progress
                                            xhr.upload.addEventListener("progress", function(evt){
                                              if (evt.lengthComputable) {
                                                var percentComplete = (evt.loaded / evt.total) * 100;
                                                //Do something with upload progress
                                                $("#upload-progress").show();
                                                $("#upload-progress").html("Uploading Image ... " + Math.round(percentComplete) + " %");
                                                if(percentComplete==100){
                                                    $("#upload-progress").html("File Uploaded !! Processing image and saving data... ");
                                                }
                                                console.log(percentComplete);
                                              }
                                            }, false);
                                            //Download progress
                                            xhr.addEventListener("progress", function(evt){
                                              if (evt.lengthComputable) {
                                                var percentComplete = evt.loaded / evt.total;
                                                //Do something with download progress
                                                console.log(percentComplete);
                                              }
                                            }, false);
                                            return xhr;
                                          },
					                   success: function(data)
					                   {
					                   	   progress.removeClass("loading-page");
					                   	   
					                       if(data==1){
											    $("#postinsert")[0].reset();
											    progress.removeClass("error-report");
											    progress.addClass("success-report");
											    progress.html("successfully insert data!");
											    body.animate({scrollTop:0}, "500");
											    setTimeout("$(\'#ulin-wrapper\').load($.cookie(\'current_url\'));",3000);
					                       }else if(data==2){
					                       		progress.removeClass("success-report");
												progress.addClass("error-report");
												progress.html("Duplicate Data!");
												body.animate({scrollTop:0}, "500");
					                       		setTimeout("$(\'#report\').fadeOut();",3000);
					                       }else{
					                       		progress.removeClass("success-report");
												progress.addClass("error-report");
												progress.html("Cant insert data. Please contact our administrator if you get this message!");
					                       		body.animate({scrollTop:0}, "500");
					                       		setTimeout("$(\'#report\').fadeOut();",3000);
					                       }
					                       $("#submits").removeAttr("disabled");
					                       
					                   },
					                   error: function(xhr, textStatus, error){
                                          progress.removeClass("loading-page");
                                          progress.addClass("error-report");
                                          progress.html(textStatus + " : " + xhr.statusText);
                                          body.animate({scrollTop:0}, "500");
                                          setTimeout("$(\'#report\').fadeOut();",3000);
                                          $("#submits").removeAttr("disabled");
                                      }
					            });
							}
				            return false;
					  	});

						$("#postupdate").submit(function(){
							
							var data = $(this).serialize();
				            var loader = "<span>Saving... Please Wait..</span><br><img src=\''.base_url().'static/img/preload.GIF\'/><br><span id=\'upload-progress\' style=\'display:none\'></span>";
				            var target = "'.site_url().@$this->params['form']['edit']['url'].'";
				            var formData = new FormData($(this)[0]);
				            var progress = $("#report");
				            var body = $("html, body");
				        	
				            if($("#postupdate").validationEngine("validate")){

				            	progress.addClass("loading-page");
					            $("#submits").attr("disabled","disabled");
					            progress.html(loader);
					            progress.show();
					            $.ajax({
					                   url: target,
					                   data: formData,
					                   async: true,
					                   contentType: false,
					                   processData: false,
					                   cache: false,
					                   type: "POST",
					                   xhr: function()
                                          {
                                            var xhr = new window.XMLHttpRequest();
                                            //Upload progress
                                            xhr.upload.addEventListener("progress", function(evt){
                                              if (evt.lengthComputable) {
                                                var percentComplete = (evt.loaded / evt.total) * 100;
                                                //Do something with upload progress
                                                $("#upload-progress").show();
                                                $("#upload-progress").html("Uploading Image ... " + Math.round(percentComplete) + " %");
                                                if(percentComplete==100){
                                                    $("#upload-progress").html("File Uploaded !! Processing image and saving data... ");
                                                }
                                                console.log(percentComplete);
                                              }
                                            }, false);
                                            //Download progress
                                            xhr.addEventListener("progress", function(evt){
                                              if (evt.lengthComputable) {
                                                var percentComplete = evt.loaded / evt.total;
                                                //Do something with download progress
                                                console.log(percentComplete);
                                              }
                                            }, false);
                                            return xhr;
                                          },
					                   success: function(data)
					                   {
					                   	   progress.removeClass("loading-page");
					                       if(data==1){
					                       		progress.removeClass("error-report");
											    progress.addClass("success-report");
											    progress.html("successfully update data!");
	                							body.animate({scrollTop:0}, "500");
	                							setTimeout("$(\'#report\').fadeOut();",3000);
					                       }else{
					                       		progress.removeClass("success-report");
												progress.addClass("error-report");
												progress.html("Cant update data. Please contact our administrator if you get this message!");
					                       		body.animate({scrollTop:0}, "500");
					                       		setTimeout("$(\'#report\').fadeOut();",3000);
					                       }
					                       $("#submits").removeAttr("disabled");
					                       
					                   },
					                   error: function(xhr, textStatus, error){
                                          progress.removeClass("loading-page");
                                          progress.addClass("error-report");
                                          progress.html(textStatus + " : " + xhr.statusText);
                                          body.animate({scrollTop:0}, "500");
                                          setTimeout("$(\'#report\').fadeOut();",3000);
                                          $("#submits").removeAttr("disabled");
                                      }
					            });
							}
				            return false;
					  	});
						$("#submits").click(function(){
                            var arrayOfIds = $.map($(".ckeditor"), function(n, i){
                              return n.id;
                            });
                            var row_id = arrayOfIds.length;
                            for( $i=0;$i < row_id; $i++){
                                var value = CKEDITOR.instances[arrayOfIds[$i]].getData();
                                $("#ck_" + arrayOfIds[$i]).val(value);
                            }
                
                        });
						
					});
			  </script>';

		return $js;

	}
}
