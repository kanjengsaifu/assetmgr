<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class Input extends CI_Controller 
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
			$this->new_item();
		}
	}
	
	function new_item()
	{
		if($this->input->post("group") && $this->input->post("group") <> "0" && $this->input->post("group") <> "new")
		{
			$grp = $this->input->post("group");
		}else{
			$grp = null;
		}
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			$data['group_list'] = $this->Asset->grp_list();
			$data['divisi_list'] = $this->Asset->div_list();
			if($grp <> null) 
   		{
   			$data['item_list'] = $this->Asset->item_list($grp);
   			$data['group'] = $grp;
   			
   			$per_page = 5;
   			$total_row = $this->Asset->item_list_tot_row($grp);
   			$data['total_row'] = $total_row;
   			$i=1;
   			$j=1;
		   	$pg=1;
		   	foreach ($data['item_list'] as $row)
   			{
			  	$items[$pg][$i] = $row;
			  	if(($i == $per_page) && ($j < $total_row)) 
			  	{
			  		$pg++;
			  		$i=0;
			  	}
			  	$i++;
			  	$j++;
   			}
   			$data['item_list'] = $items;
   			$data['pg'] = $pg;
   		}
   		
			$this->load->view('input/new_item',$data);
		}
	}
	
	function add_grp()
	{
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			if (trim($_POST['grp_name']) == '') {
				$error[] = 'Nama grup harus diisi';
			}
			if (trim($_POST['grp_cd']) == '') {
				$error[] = 'Kode grup harus diisi';
			}
			
			if (isset($error)) {
				$data['err_add']=TRUE;
				$data['error_msg']=implode('<br />', $error);
				$this->load->vars($data);
				//$this->load->view('input/new_item',$data);				
				$this->new_item();
			} else {
				$grp_name = str_replace('"', '', $this->input->post("grp_name"));
				$grp_name = str_replace("'", "", $grp_name);
				$grp_cd = str_replace('"', '', $this->input->post("grp_cd"));
				$grp_cd = str_replace("'", "", $grp_cd);
				$this->db = $this->load->database('default', TRUE); 
				$sql = "select GRP_CODE from ".$this->db->dbprefix('ASSET_GRP')." ";
				$sql .= "where GRP_CODE= '".strtoupper($grp_cd)."' ";
				$query = $this->db->query($sql);
				if ($query->num_rows() == 0)
				{				
					$now_dt=date('Y-m-d H:i:s.000');
					
					$this->db->trans_start(TRUE); // Query will be rolled back
					$insquery = "insert into ".$this->db->dbprefix('ASSET_GRP')." (GRP_CODE,GRP_DESC,GRP_INDATE) ";
					$insquery .= "values ('".strtoupper($grp_cd)."','".strtoupper($grp_name)."', '".$now_dt."')";
					$this->db->query($insquery);
					$this->db->trans_complete();
					
					$data['group']=strtoupper($grp_cd);
					//$this->load->view('input/new_item',$data);
					$this->load->vars($data);
					$this->new_item();
				}else{
					$data['err_add_group']=TRUE;
					$data['grp_error_msg']='Grup dengan kode <b>'.strtoupper($grp_cd).'</b> sudah ada';
					$this->load->vars($data);
					//$this->load->view('input/new_item',$data);				
					$this->new_item();
				}
			}
		}
	}
	
	function add_div()
	{
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			if (trim($_POST['div_name']) == '') {
				$error[] = 'Nama divisi harus diisi';
			}
			
			if (isset($error)) {
				$data['err_add']=TRUE;
				$data['error_msg']=implode('<br />', $error);
				$this->load->vars($data);
				$this->new_item();
			} else {
				$div_name = str_replace('"', '', $this->input->post("div_name"));
				$div_name = str_replace("'", "", $div_name);
				$this->db = $this->load->database('default', TRUE); 
				$sql = "select DIV_DESC from ".$this->db->dbprefix('ASSET_DIV')." ";
				$sql .= "where DIV_DESC= '".strtoupper($div_name)."' ";
				$query = $this->db->query($sql);
				if ($query->num_rows() == 0)
				{				
					$now_dt=date('Y-m-d H:i:s.000');
					
					$this->db->trans_start(TRUE); // Query will be rolled back
					$insquery = "insert into ".$this->db->dbprefix('ASSET_DIV')." (DIV_DESC,DIV_INDATE) ";
					$insquery .= "values ('".strtoupper($div_name)."', '".$now_dt."')";
					$this->db->query($insquery);
					$this->db->trans_complete();
					
					$sql = "select DIV_ID from ".$this->db->dbprefix('ASSET_DIV')." ";
					$sql .= "where DIV_DESC= '".strtoupper($div_name)."' ";
					$query = $this->db->query($sql);
					
					//$data['divisi']=strtoupper($div_id);
					$data['divisi']=$query->row()->DIV_ID;
					$this->load->vars($data);
					$this->new_item();
				}else{
					$data['err_add_divisi']=TRUE;
					$data['divisi_error_msg']='Divisi dengan nama <b>'.strtoupper($div_name).'</b> sudah ada';
					$this->load->vars($data);
					$this->new_item();
				}
			}
		}
	}
	
	function add_item()
	{
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			if ($this->input->post("group")=="0" || $this->input->post("group")=="new") {
				$error[] = 'Anda belum memilih grup';
			}
			if (trim($this->input->post("itm_name")) == '') {
				$error[] = 'Nama item harus diisi';
			}
			if (trim($this->input->post("nl_perolehan")) == '') {
				$error[] = 'Nilai perolehan harus diisi';
			}
			if ($this->fungsi->valid_date($this->input->post("tgl_perolehan")) <> TRUE ) {
				$error[] = $this->fungsi->valid_date($this->input->post("tgl_perolehan"));
			}
			if (trim($this->input->post("masa")) == '') {
				$error[] = 'Masa penggunaan harus diisi';
			}
			//if ($this->input->post("divisi")=="0" || $this->input->post("divisi")=="new") {
			//	$error[] = 'Anda belum memilih divisi';
			//}
			
			if (isset($error)) {
				$data['err_add']=TRUE;
				$data['error_msg']=implode('<br />', $error);
				$this->load->vars($data);		
				$this->new_item();
			} else {
				
				$now_dt=date('Y-m-d H:i:s.000');
				
				if(!$this->input->post("itm_id"))
				{
					
					$grp_cd = strtoupper($this->input->post("group"));
					$itm_name = str_replace('"', '', $this->input->post("itm_name"));
					$itm_name = str_replace("'", "", $itm_name);
					$itm_name = strtoupper($itm_name);
					$nl_perolehan = str_replace(",", "", $this->input->post("nl_perolehan"));
					$nl_perolehan = floatval($nl_perolehan);
					$tgl_perolehan = date('Y-m-d H:i:s.000', strtotime($this->input->post("tgl_perolehan")));
					$masa = str_replace(",", "", $this->input->post("masa"));
					$masa = floatval($masa);		
					$vcr = str_replace('"', '', $this->input->post("vcr"));
					$vcr = str_replace("'", "", $vcr);
					$vcr = strtoupper($vcr);	
					if ($this->input->post("divisi")=="0" || $this->input->post("divisi")=="new") $div_id = 0;
					else $div_id = strtoupper($this->input->post("divisi"));
				
					$this->db = $this->load->database('default', TRUE); 
				
					//cari kode asset terakhir yg digunakan
					$sql = "select AS_CODE from ".$this->db->dbprefix('ASSET_DTL')." ";
					$sql .= "where AS_GRP= '".$grp_cd."' ";
					//$sql .= "and AS_USE= '".$masa."' ";
					$sql .= "order by AS_CODE DESC ";
					$query = $this->db->query($sql);
					if ($query->num_rows() > 0)
					{
						$last_code=intval(substr($query->row()->AS_CODE,-6))+1;
					}else{
						$last_code=1;
					}
				
					$i = 1;
					$zero = "";
					while ($i <= (6-strlen($last_code))) {
	    			$zero .= "0";
    				$i++;  
					}
				
					//$itm_code = $grp_cd.$masa."-".$zero.$last_code;
					$itm_code = $grp_cd."-".$zero.$last_code;
				
					//echo "itm_code = ".$itm_code;
				
					if($masa == 0)$as_ppb=0;
					else $as_ppb=floatval($nl_perolehan/($masa*12));
					if($nl_perolehan == 0)$as_tpt=0;
					else $as_tpt=floatval((($as_ppb*12)/$nl_perolehan)*100);
					//echo "PTP = ".$as_ptp;
				
				
					$this->db->trans_start(TRUE); // Query will be rolled back
					$insquery = "insert into ".$this->db->dbprefix('ASSET_DTL')." (AS_CODE,AS_GRP,AS_NAME,AS_NP,AS_INDATE,AS_USE,AS_PPB,AS_TPT,AS_LASTUPDATED_DT,AS_VOUCHER,AS_DIV) ";
					$insquery .= "values ('".$itm_code."','".$grp_cd."', '".$itm_name."', ".$nl_perolehan.", '".$tgl_perolehan."', ".$masa.", ".$as_ppb.", ".$as_tpt.", '".$now_dt."', '".$vcr."', '".$div_id."')";
					//echo "<br>insquery = ".$insquery;
					$this->db->query($insquery);
					$this->db->trans_complete();
				
					
				}else{
					$itm_id = $this->input->post("itm_id");
					$itm_name = str_replace('"', '', $this->input->post("itm_name"));
					$itm_name = str_replace("'", "", $itm_name);
					$itm_name = strtoupper($itm_name);
					$nl_perolehan = str_replace(",", "", $this->input->post("nl_perolehan"));
					$nl_perolehan = floatval($nl_perolehan);
					$tgl_perolehan = date('Y-m-d H:i:s.000', strtotime($this->input->post("tgl_perolehan")));
					$masa = str_replace(",", "", $this->input->post("masa"));
					$masa = floatval($masa);	
					$vcr = str_replace('"', '', $this->input->post("vcr"));
					$vcr = str_replace("'", "", $vcr);
					$vcr = strtoupper($vcr);			
					if($masa == 0)$as_ppb=0;
					else $as_ppb=floatval($nl_perolehan/($masa*12));
					if($nl_perolehan == 0)$as_tpt=0;
					else $as_tpt=floatval((($as_ppb*12)/$nl_perolehan)*100);
					if ($this->input->post("divisi")=="0" || $this->input->post("divisi")=="new") $div_id = 0;
					else $div_id = strtoupper($this->input->post("divisi"));
				
					$this->db = $this->load->database('default', TRUE); 
					
					$this->db->trans_start(TRUE); // Query will be rolled back
					$updtquery = "update ".$this->db->dbprefix('ASSET_DTL')." ";
					$updtquery .= "set AS_LASTUPDATED_DT = '".$now_dt."' ";
					$updtquery .= ",AS_NAME = '".$itm_name."' ";
					$updtquery .= ",AS_NP = '".$nl_perolehan."' ";
					$updtquery .= ",AS_INDATE = '".$tgl_perolehan."' ";
					$updtquery .= ",AS_USE = '".$masa."' ";
					$updtquery .= ",AS_PPB = '".$as_ppb."' ";
					$updtquery .= ",AS_TPT = '".$as_tpt."' ";
					$updtquery .= ",AS_VOUCHER = '".$vcr."' ";
					$updtquery .= ",AS_DIV = '".$div_id."' ";
					$updtquery .= "where AS_ID = '".$itm_id."' ";
					//echo "<br>updtquery = ".$updtquery;
					$this->db->query($updtquery);
					$this->db->trans_complete();
				}
				$this->new_item();
			}
		}
	}
	
	function show_item()
	{
		if($this->input->post("group") && $this->input->post("group") <> "0" && $this->input->post("group") <> "new")
		{
			$grp = $this->input->post("group");
		}else{
			$grp = null;
		}
		
		if($this->input->post("itm_name") && $this->input->post("itm_name") <> "")
		{
			$key = str_replace('"', '', $this->input->post("itm_name"));
			$key = str_replace("'", "", $key);
		}else{
			$key = null;
		}
		
		if($grp <> null) 
   	{
   		$data['item_list'] = $this->Asset->item_list($grp,null,$key);
   		$data['group'] = $grp;
   		if($data['item_list']==null) echo "<center>Data tidak ditemukan.....</center>";
   		else {
   			$per_page = 5;
   			$total_row = $this->Asset->item_list_tot_row($grp,null,$key);
   			$data['total_row'] = $total_row;
   			$i=1;
   			$j=1;
		   	$pg=1;
		   	foreach ($data['item_list'] as $row)
   			{
			  	$items[$pg][$i] = $row;
			  	if(($i == $per_page) && ($j < $total_row)) 
			  	{
			  		$pg++;
			  		$i=0;
			  	}
			  	$i++;
			  	$j++;
   			}
   			$data['item_list'] = $items;
   			$data['pg'] = $pg;
   			$this->load->view('input/item_list',$data);
   		}
   	}else{
   		echo "<center>Silahkan pilih Grup terlebih dahulu.....</center>";
   	}
   		
		
	}
	
	function edit_detail($itm_id)
	{
		$this->db->from('ASSET_DTL');	
		$this->db->where('AS_ID',$itm_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			$data['item'] = $query->row();
   		$data['divisi_list'] = $this->Asset->div_list();
			$this->load->view('input/form_edit',$data);
		}else echo "Item dengan id <b>".$itm_id."</b> tidak ditemukan !";
	}
	
	function delete_item()
	{
		if(!$this->Employee->is_logged_in() or !$this->Employee->has_permission($this->uri->segment(1),$this->Employee->get_logged_in_employee_info()->person_id))
		{
			$this->load->view('login');
		}else{
			
			if($this->input->post("del_item_id"))
			{
				//echo "itm_id ".$this->input->post("del_item_id");
				//echo "<br>itm_grp ".$this->input->post("group");
				
				$this->db = $this->load->database('default', TRUE); 
					
				$this->db->trans_start(TRUE); // Query will be rolled back
				$updtquery = "update ".$this->db->dbprefix('ASSET_DTL')." ";
				$updtquery .= "set AS_STATUS = 'C' ";
				$updtquery .= "where AS_ID = '".$this->input->post("del_item_id")."' ";
				//echo "<br>updtquery = ".$updtquery;
				$this->db->query($updtquery);
				$this->db->trans_complete();
				
			}
			$this->show_item();
		}
	}
	
	/****Fungsi-Fungsi****/
	
}