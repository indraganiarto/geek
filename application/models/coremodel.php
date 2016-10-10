<?php

class Coremodel extends CI_Model{
		
		function getusergroup(){
			$sql = "SELECT usergroup_id as keydt, nm_usergroup as valuedt FROM office.sys_usergroups";
			$query = $this->db->query($sql)->result_array();
			return @$query;
		}
		function getmodul(){
			$sql = "SELECT menu_item_id as keydt, CASE WHEN type_item='Menu' THEN CONCAT('{',label_item,'}') ELSE label_item END as valuedt FROM office.menu_item ORDER BY type_item";
			$query = $this->db->query($sql)->result_array();
			return @$query;
		}
		function getauthors(){
			$sql = "SELECT CONCAT(author_id,'|',name) as valuedt, author_id as keydt FROM office.authors";
			$query = $this->db->query($sql)->result_array();
			return @$query;
		}
		function getcountry(){
			$sql = "SELECT cd_country as keydt, nm_country as valuedt FROM office.tb_country";
			$query = $this->db->query($sql)->result_array();
			return @$query;
		}
		function filterprovincebycountry($id){
			$sql = "SELECT cd_province as keydt, nm_province as valuedt FROM office.tb_province WHERE cd_country='".$id."'";
			
			$query = $this->db->query($sql)->result_array();
			return @$query;
		}
		function filtercitybyprovince($id){
			$sql = "SELECT cd_city as keydt, nm_city as valuedt FROM office.tb_city WHERE cd_province='".$id."'";
			
			$query = $this->db->query($sql)->result_array();
			return @$query;
		}

		function getcity(){
			$sql = "SELECT cd_city as keydt, nm_city as valuedt FROM office.tb_city";
			$query = $this->db->query($sql)->result_array();
			return @$query;
		}
		function getprovince($nm_province=null){
			$where = "";
			if($nm_province!=null){
				$where = " WHERE lower(nm_province) LIKE '%".$nm_province."%'";
			}
			$sql = "SELECT cd_province as keydt, nm_province as valuedt FROM office.tb_province $where";

			$query = $this->db->query($sql)->result_array();
			return @$query;
		}
	
}


