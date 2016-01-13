<?php
class Module extends CI_Model 
{
	function __construct()
  {
  	parent::__construct();
  	$this->db = $this->load->database('default', TRUE);
 	}
 	
 	function get_allowed_modules($person_id)
	{
		//$this->db = $this->load->database('default', TRUE);
		$this->db->from('modules');
		$this->db->join('permissions','permissions.module_id=modules.module_id');
		$this->db->where("permissions.person_id",$person_id);
		//$this->db->where("permissions.hidden",'0');
		$this->db->order_by("sort", "asc");
		return $this->db->get();		
	}
	
	function get_allowed_submodules($module_id)
	{
		//$this->db = $this->load->database('default', TRUE);
		$this->db->from('submodules');
		//$this->db->join('modules','modules.module_id=submodules.parent_id');
		$this->db->where("submodules.parent_id",$module_id);
		$this->db->order_by("sort", "asc");
		return $this->db->get();		
	}
	
}
?>