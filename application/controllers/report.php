<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class Report extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			$this->find();
			//echo "Halaman Report";
		}
	}
	
	function find()
	{
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			$data['group_list'] = $this->Asset->grp_list();
			//$data['item_list'] = $this->Asset->item_list();
			$this->load->view('report/find',$data);
		}
	}
	
	function find_report()
	{
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			if($this->input->post("group") && $this->input->post("group") <> '0') $grp = $this->input->post("group");
			else $grp = null;
			$data['grp'] = $grp;
			$data['tgl'] = $this->input->post("tgl");
			$data['item_list'] = $this->Asset->item_list($grp,null,null,'ASC');
			if($data['item_list'] == null) echo "<center>Data tidak ditemukan.....</center>";
			else $this->load->view('report/item_list',$data);
		}
	}
	
	function export_excel()
	{
		if(!$this->Employee->is_logged_in())
		{
			echo "<center>access is not allowed !</center>";
		}else{
			if($this->input->post("group") && $this->input->post("group") <> '0') $grp = $this->input->post("group");
			else $grp = null;
			$data['grp'] = $grp;
			$data['tgl'] = $this->input->post("tgl");
			$data['item_list'] = $this->Asset->item_list($grp,null,null,'ASC');
			if($data['item_list'] == null) echo "<center>Data tidak ditemukan.....</center>";
			else $this->load->view('report/excel/list_asset',$data);
		}
	}
		
}
?>