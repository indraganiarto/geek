<?php

	function setBtntoolbar($caption,$url,$class="btn btn-default btn-sm"){
		$caption = setLangline($caption); 
		return "<a href='".$url."' class='".$class."'>".$caption."</a>";

	}
	function setLangline($line){
		$CI =& get_instance();
		$str = $CI->lang->line($line);
		if($str==""){
			$str = $line;
		}
		return $str;
	}
	function renderDatatable($params){
		$CI =& get_instance();
		$query = $CI->db->query($params['sql'])->result_array();
		$columns =explode(',', $params['columns']);
		$ccount = count($columns);
		$dtt = '<table id="'.$params['id'].'" class="table table-striped table-hover">';
		$dtt.= '<thead><tr>';
			for($i=0;$i<$ccount;$i++){
				$column = setLangline($columns[$i]);
				$dtt.= '<th>'.$column.'</th>';
			}
		$dtt.= '</tr></thead><tbody>';
		foreach($query as $list){
			$dtt.="<tr>";
			for($i=0;$i<$ccount;$i++){
				$dtt.= '<td>'.$list[$columns[$i]].'</td>';
			}
			$dtt.="</tr>";
		}
		$dtt.= '</tbody></table>';
		$dtt.= '<script type="text/javascript">
					$(document).ready(function(){
						$("#'.$params['id'].'").dataTable({
			                "sDom" : "<\'dt-top-row\'Tlf>r<\'dt-wrapper\'t><\'dt-row dt-bottom-row\'<\'row\'<\'col-sm-6\'i><\'col-sm-6 text-right\'p>>"
			            });
			            $(".DTTT").html("'.implode('',$params['toolbar']).'");
					});
				</script>';
		return $dtt;
	}
	function renderForm($params){
		$frm = "<form id='frm-".$params['name']."' name='frm-".$params['name']."'>";
		if($params['action']=="1"){
			$frm.= renderFormAdd($params);
		}else{
			//$frm.= renderFormEdit($params);
		}
		$frm.= "</form>";
		return $frm;

	}
	function renderFormAdd($params){
		$form = "";
		foreach (array_keys($params['fields']) as $title) {
			$input_type = @$params['fields'][$title]['type'];
			$fields_param['attribute'] = $params['fields'][$title];
			$fields_param['title'] = $title;
			$fields_param['action'] = $params['action'];

			switch($input_type){

				case "text" :
					$fields_param['input_type']="text";
					$form.= renderInputText($fields_param);
					break;
				case "date" :
					$fields_param['input_type']="date";
					$form.= renderInputText($fields_param);
					break;
				case "number" :
					$fields_param['input_type']="number";
					$form.= renderInputText($fields_param);
					break;

			}
			
		}
		return $form;
	}
	function renderFormEdit($params){

	}
	function renderInputText($params){
		
		//set params
		$title = $params['title'];
		$field_caption = setLangline($title);//label
		$type = $params['input_type'];//type(html5 input)
		$val = setInputValue($params);//if there is custom value
		if($params['action']==2){// set value from edit action
			$val = "";
		}
		$class = setInputClass($params);
		$validate_attr = setInputValidation($params);
		$maxlength_attr = setInputMaxlength($params);
		$size_attr = setInputSize($params);
		$style_attr = setInputStyle($params);
		$id_attr = setInputId($params);
		$readonly_attr = setInputReadOnly($params);
		$disabled_attr = setInputDisabled($params);
		$custom_tag_attr = setInputCustomTag($params);
		$place_holder = setPlaceHolder($params); 

		//create input
		$html = "<section>";
		$html.= "<label class='label'>".$field_caption."</label>";
		$html.= "<label class='input'>";
		$html.= "<input type='".$type."' placeholder='".$place_holder."' maxlength='".$maxlength_attr."' size='".$size_attr."' class='".$class."' ".$validate_attr." value='".$val."' name='".$title."' id='".$id_attr."' ".$readonly_attr." ".$disabled_attr." style='".$style_attr."' ".$custom_tag_attr.">";
		$html.= "</label>";
		$html.= "</section>";
		return $html;
	}
	function setInputValue($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['value'])){
			if($attribute['value']!=""){
				$ret = $attribute['value'];
			}
		}
		return $ret;
	}
	function setInputClass($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['class'])){
			if($attribute['class']!=""){
				$ret = $attribute['class'];
			}
		}
		return $ret;
	}
	function setInputStyle($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['style'])){
			if($attribute['style']!=""){
				$ret = $attribute['style'];
			}
		}
		return $ret;
	}
	function setPlaceHolder($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['placeholder'])){
			if($attribute['placeholder']!=""){
				$ret = $attribute['placeholder'];
			}
		}
		return $ret;
	}
	function setInputValidation($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['validation'])){
			if($attribute['validation']!=""){
				$ret = $attribute['validation'];
			}
		}
		return $ret;
	}
	function setInputMaxlength($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['length'])){
			if($attribute['length']!=""){
				$ret = $attribute['length'];
			}
		}
		return $ret;
	}
	function setInputSize($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['size'])){
			if($attribute['size']!=""){
				$ret = $attribute['size'];
			}
		}
		return $ret;
	}
	function setInputId($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['id'])){
			if($attribute['id']!=""){
				$ret = $attribute['id'];
			}
		}
		return $ret;
	}
	function setInputReadOnly($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['readonly'])){
			if($attribute['readonly']=="1"){
				$ret = "readonly";
			}
		}
		return $ret;
	}
	function setInputDisabled($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['disabled'])){
			if($attribute['disabled']=="1"){
				$ret = "disabled";
			}
		}
		return $ret;
	}
	function setInputCustomTag($params){
		$attribute = $params['attribute'];
		$ret = "";
		if(isset($attribute['custom_tag']) && isset($attribute['custom_tag_value'])){
			if($attribute['custom_tag']!=""){
				$ret = $attribute['custom_tag']."='".$attribute['custom_tag_value']."'";
			}
		}
		return $ret;
	}
?>