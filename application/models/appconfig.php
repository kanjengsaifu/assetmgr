<?php
class Appconfig extends CI_Model 
{
	
	function exists($key)
	{
		$this->db = $this->load->database('default', TRUE);
		$this->db->from('app_config');	
		$this->db->where('app_config.app_key',$key);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	function get_all()
	{
		$this->db = $this->load->database('default', TRUE);
		$this->db->from('app_config');
		$this->db->order_by("app_key", "asc");
		return $this->db->get();		
	}
	
	function get($key)
	{
		$this->db = $this->load->database('default', TRUE);
		$query = $this->db->get_where('app_config', array('app_key' => $key), 1);
		
		if($query->num_rows()==1)
		{
			return $query->row()->value;
		}
		
		return "";
		
	}
	
	function save($key,$value)
	{
		$this->db = $this->load->database('default', TRUE);
		$config_data=array(
		'app_key'=>$key,
		'value'=>$value
		);
				
		if (!$this->exists($key))
		{
			return $this->db->insert('app_config',$config_data);
		}
		
		$this->db->where('app_key', $key);
		return $this->db->update('app_config',$config_data);		
	}
	
	function batch_save($data)
	{
		$this->db = $this->load->database('default', TRUE);
		$success=true;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		foreach($data as $key=>$value)
		{
			if(!$this->save($key,$value))
			{
				$success=false;
				break;
			}
		}
		
		$this->db->trans_complete();		
		return $success;
		
	}
		
	function delete($key)
	{
		$this->db = $this->load->database('default', TRUE);
		return $this->db->delete('app_config', array('app_key' => $key)); 
	}
	
	function delete_all()
	{
		$this->db = $this->load->database('default', TRUE);
		return $this->db->empty_table('app_config'); 
	}
}

?>