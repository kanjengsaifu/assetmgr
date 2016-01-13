<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class View extends CI_Controller 
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
		$per_page = 8;
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			$data['group_list'] = $this->Asset->grp_list();
			$data['divisi_list'] = $this->Asset->div_list();
			if($this->input->post("group") && $this->input->post("group") <> '0') 
			{
				$group=$this->input->post("group");
				$data['group']=$group;
				
				$this->db->select('AS_USE');	
				$this->db->from('ASSET_DTL');	
				$this->db->where('AS_GRP',$group);
				$this->db->group_by("AS_USE");
				$query = $this->db->get();
				
				if ($query->num_rows() <> 0)
				{
					$list=array();
					foreach ($query->result_array() as $row)
   				{
   					$list[]=$row;
   				}
   				$data['masa_list'] = $list;
   			}
			}
			else $group=null;
			if($this->input->post("masa") && $this->input->post("masa") <> '0') 
			{
				$masa=$this->input->post("masa");
				$data['masa']=$masa;
			}
			else $masa=null;
			if($this->input->post("itm_name")) 
			{
				$itm_name = str_replace('"', '', $this->input->post("itm_name"));
				$itm_name = str_replace("'", "", $itm_name);
				$data['itm_name']=$itm_name;
			}
			else $itm_name=null;
			
			if($this->input->post("divisi") && $this->input->post("divisi") <> '0') 
			{
				$divisi = $this->input->post("divisi");
				$data['divisi']=$divisi;
			}
			else $divisi=null;
			
			if(isset($group)) $data['item_list'] = $this->Asset->item_list($group,$masa,$itm_name,'ASC',$divisi);
			if(isset($data['item_list'])) 
			{
   			
   			$total_row = $this->Asset->item_list_tot_row($group,$masa,$itm_name,'ASC',$divisi);
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
   			//$this->load->view('input/item_list',$data);
   		}elseif(isset($group)){
   			$data['err_search_item'] = "Data tidak ditemukan !";
   		}
			
			$this->load->view('view/find',$data);
		}
	}
	
	function view_detail($itm_id)
	{
		//echo "Item Id = ".$itm_id;
		//$this->db->select('AS_USE');	
		$this->db->from('ASSET_DTL');	
		$this->db->where('AS_ID',$itm_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			$data['item'] = $query->row();
			$this->load->view('view/item_detail',$data);
		}else echo "Item dengan id <b>".$itm_id."</b> tidak ditemukan !";
	}
	
	function edit_detail($itm_id)
	{
		$this->db->from('ASSET_DTL');	
		$this->db->where('AS_ID',$itm_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			$data['item'] = $query->row();
			$this->load->view('view/edit_detail',$data);
		}else echo "Item dengan id <b>".$itm_id."</b> tidak ditemukan !";
	}
	
	function get_masa($grp)
	{
		$this->db->select('AS_USE');	
		$this->db->from('ASSET_DTL');	
		$this->db->where('AS_GRP',$grp);
		$this->db->group_by("AS_USE");
		$query = $this->db->get();
		?>
		<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="0" border="0">
			<tr class='row1'>
				<td style="padding-left:5px;" width="150"><b>Masa Penggunaan</b></td>
				<td style="padding-left:5px;">
					<select name="masa" id="masa">
						<option value="0">All</option>
						<?php
						if ($query->num_rows() <> 0)
						{
							foreach ($query->result_array() as $row)
   						{
							?>
								<option value="<?php echo $row['AS_USE'];?>"><?php echo number_format($row['AS_USE'],1,'.',',');?></option>
							<?php
							}
						}
						?>
					</select>	
			 		tahun
				</td>
			</tr>
		</table>
		<?php
	}
		
}
?>