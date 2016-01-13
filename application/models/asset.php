<?php
class Asset extends CI_Model 
{
	function __construct()
  {
  	parent::__construct();
  	$this->db = $this->load->database('default', TRUE);
 	}
 	
 	function grp_list()
	{
		//$this->db->select('GRP_ID,GRP_CODE,GRP_DESC');	
		$this->db->from('ASSET_GRP');	
		$this->db->where('GRP_STATUS','O');
		$this->db->order_by("GRP_DESC", "asc");
		$query = $this->db->get();
		$list = array();
		if ($query->num_rows() <> 0)
		{
			foreach ($query->result_array() as $row)
   		{
				$list[] = $row;
   		}
		}
		return $list; 
	}
	
	function div_list()
	{
		$this->db->from('ASSET_DIV');	
		$this->db->where('DIV_STATUS','O');
		$this->db->order_by("DIV_DESC", "asc");
		$query = $this->db->get();
		$list = array();
		if ($query->num_rows() <> 0)
		{
			foreach ($query->result_array() as $row)
   		{
				$list[] = $row;
   		}
		}
		return $list; 
	}
	
	function item_list($grp=null,$masa=null,$key=null,$order="DESC",$div=null,$per_page=6,$offset=0)
	{
		/*
		//$this->db = $this->load->database('default', TRUE);
		//$this->db->select('*');	
		$this->db->from('ASSET_DTL');	
		$this->db->where('AS_STATUS','O');
		if($grp<>null) $this->db->where('AS_GRP',$grp);
		$this->db->order_by("AS_CODE", "desc");
		$query = $this->db->get();
		
		
		$sql = "select * from (select *,ROW_NUMBER() OVER(ORDER BY AS_CODE ".$order.") AS rownum ";
		$sql .= "from ".$this->db->dbprefix('ASSET_DTL')." ";
		$sql .= "where AS_STATUS='O' ";
		if ($grp<>null) $sql .= "and AS_GRP='".$grp."' ";
		if ($masa<>null) $sql .= "and AS_USE='".$masa."' ";
		if ($key<>null) $sql .= "and (AS_CODE like '%".$key."%' or AS_NAME like '%".$key."%') ";
		//$sql .= "order by AS_CODE ".$order." ";
		$sql .= ") ";
		$sql .= " as item_list where rownum between ".($offset+1)." AND ".($offset+$per_page)." ";
		
		$query = $this->db->query($sql);
		*/
		
		$sql = "select * ";
		$sql .= "from ".$this->db->dbprefix('ASSET_DTL')." ";
		$sql .= "left join ".$this->db->dbprefix('ASSET_DIV')." on AS_DIV=DIV_ID ";
		$sql .= "where AS_STATUS='O' ";
		if ($grp<>null) $sql .= "and AS_GRP='".$grp."' ";
		if ($div<>null) $sql .= "and AS_DIV='".$div."' ";
		if ($masa<>null) $sql .= "and AS_USE='".$masa."' ";
		if ($key<>null) $sql .= "and (AS_CODE like '%".$key."%' or AS_NAME like '%".$key."%') ";
		$sql .= "order by AS_GRP,AS_USE ".$order.",AS_CODE ".$order." ";
		
		$query = $this->db->query($sql);
		
		$list = array();
		if ($query->num_rows() <> 0)
		{
			foreach ($query->result_array() as $row)
   		{
				$list[] = $row;
   		}
   		return $list;
   	}
		return NULL; 
	}
	
	function item_list_tot_row($grp=null,$masa=null,$key=null,$order="DESC",$div=null,$per_page=6,$offset=0)
	{
		$sql = "select * ";
		$sql .= "from ".$this->db->dbprefix('ASSET_DTL')." ";
		$sql .= "where AS_STATUS='O' ";
		if ($grp<>null) $sql .= "and AS_GRP='".$grp."' ";
		if ($div<>null) $sql .= "and AS_DIV='".$div."' ";
		if ($masa<>null) $sql .= "and AS_USE='".$masa."' ";
		if ($key<>null) $sql .= "and (AS_CODE like '%".$key."%' or AS_NAME like '%".$key."%') ";
		$sql .= "order by AS_CODE ".$order." ";
		
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function get_grp_info($grp_cd)
	{
		$this->db->from('ASSET_GRP');	
		$this->db->where('GRP_CODE',$grp_cd);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $employee_id is NOT an employee
			$grp_obj=parent::get_grp_info(-1);
			//$person_obj=$this->get_person_info(-1);
			
			//Get all the fields from employee table
			$fields = $this->db->list_fields('ASSET_GRP');
			
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$grp_obj->$field='';
			}
			
			return $grp_obj;
		}
	}
	
	function get_div_info($div_id)
	{
		$this->db->from('ASSET_DIV');	
		$this->db->where('DIV_ID',$div_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			/*
			//Get empty base parent object, as $employee_id is NOT an employee
			//$div_obj=parent::get_grp_info(-1);
			$div_obj=$this->get_person_info(-1);
			
			//Get all the fields from employee table
			$fields = $this->db->list_fields('ASSET_DIV');
			
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$div_obj->$field='';
			}
			*/
			$div_obj->DIV_ID='0';
			$div_obj->DIV_DESC='';
			return $div_obj;
		}
	}
	
	function dateDiff($dformat, $endDate, $beginDate)
	{
		$date_parts1 = explode($dformat, $beginDate);
		$date_parts2 = explode($dformat, $endDate);
		$start_date = gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
		$end_date = gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
		return ($end_date-$start_date);
	}

} 	
?>