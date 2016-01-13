<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class Config extends CI_Controller 
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
			$this->userlist();
		}
	}
	
	function userlist()
	{
		$this->db = $this->load->database('default', TRUE); 
		$sql = "select emp.person_id,	emp.superuser, emp.username , ppl.first_name, ppl.last_name, ppl.phone_number, ppl.email, ppl.address_1 from ".$this->db->dbprefix('employees')." emp ";
		$sql .= "left join ".$this->db->dbprefix('people')." ppl on emp.person_id=ppl.person_id ";
		$sql .= "where emp.deleted = 0 ";
		//$sql .= "and emp.superuser = 0 ";
		$sql .= "order by emp.person_id";
		$query = $this->db->query($sql);
		if($query){	
			if ($query->num_rows() > 0)
			{
   			foreach ($query->result_array() as $row)
   			{
    			$users[] = $row;
   			}
   			$data['userslist'] = $users;
			}else{
				$data['error'] = "data '<b>user</b>' tidak ditemukan !";
			}
		}
		$data['user_info'] = $this->Employee->get_logged_in_employee_info();	
		$this->load->view("config/config",$data);
	}
	
	function newuser()
	{
			$this->load->view("config/newuser");
	}
	
	function addnewuser()
	{
		$this->form_validation->set_rules('username', 'Username', 'callback_exists_username');
		$this->form_validation->set_rules('passwd', 'Password', 'required|matches[conpasswd]');
		$this->form_validation->set_rules('conpasswd', 'Konfimasi password', 'required');
		$this->form_validation->set_rules('first_name', 'Nama lengkap', 'required');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
		$this->form_validation->set_rules('telp', 'Nomor telepon', 'callback_ceck_phone');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
					
		if ($this->form_validation->run() == FALSE)
		{
			$this->newuser();
		}else{
			$now_dt=date('Y-m-d H:i:s.000');
			$this->db = $this->load->database('default', TRUE); 
			
			$this->db->trans_start(TRUE); // Query will be rolled back
			$insquery = "insert into ".$this->db->dbprefix('people')." (first_name,email,phone_number,address_1,create_dt) ";
			$insquery .= "values ('".$this->input->post("first_name")."', '".$this->input->post("email")."', '".$this->input->post("telp")."', '".$this->input->post("addr")."','".$now_dt."')";
			$this->db->query($insquery);
			$this->db->trans_complete();
			
			$this->db->select('person_id');	
			$this->db->from('people');	
			$this->db->where('people.create_dt',$now_dt);
			$query = $this->db->get();
		
			if($query->num_rows()==1)
			{
				$person_id = $query->row()->person_id;
			}
			
			$passwd=md5($this->input->post("passwd"));
			
			$this->db->trans_start(TRUE); // Query will be rolled back
			$insquery = "insert into ".$this->db->dbprefix('employees')." (person_id,username,password,create_dt) ";
			$insquery .= "values ('".$person_id."','".$this->input->post("username")."', '".$passwd."','".$now_dt."')";
			$this->db->query($insquery);
			$this->db->trans_complete();
			
			$this->userlist();
			//echo "<div class=\"code\">person_id = $person_id</div>";
			//echo "<div class=\"code\">insquery = $insquery</div>";
		}
		
		
		/*
		insert into `gbj_people` (first_name,last_name ) values ('agus','wicaksono');
		insert into gbj_employees (username,password,person_id,deleted) values ('agus',md5('test'),SELECT LAST_INSERT_ID(),0); 
		*/
		
		
	}
	
	
	function editpwd($user_id)
	{
			$this->db = $this->load->database('default', TRUE); 
			$sql = "select person_id,username from ".$this->db->dbprefix('employees')." ";
			$sql .= "where person_id= '".$user_id."' ";
			//$sql .= "and superuser=0 ";
			$query = $this->db->query($sql);
			if ($query->num_rows() <> 0)
			{
				$data['username']=$query->row()->username;
				$data['person_id']=$query->row()->person_id;
				$this->load->view("config/editpwd",$data);
			}else{
				$data['error_msg'] = "User tidak ditemukan !";
				$this->userlist();
			}		
	}
	
	function updatepwd()
	{
		$this->form_validation->set_rules('passwd', 'Password', 'required|matches[conpasswd]');
		$this->form_validation->set_rules('conpasswd', 'Konfimasi password', 'required');
				
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
					
		if ($this->form_validation->run() == FALSE)
		{
			$this->editpwd($this->input->post("person_id"));
		}else{
			$passwd=md5($this->input->post("passwd"));
			$this->db = $this->load->database('default', TRUE); 
			$this->db->trans_start(TRUE); // Query will be rolled back
			$insquery = "update ".$this->db->dbprefix('employees')." set password='".$passwd."' ";
			$insquery .= "where person_id='".$this->input->post("person_id")."' ";
			$this->db->query($insquery);
			$this->db->trans_complete();
			
			$this->userlist();
		}
		
	}
	
	function edituser($user_id)
	{
			$this->db = $this->load->database('default', TRUE); 
			$sql = "select ppl.person_id,emp.username,ppl.first_name,ppl.phone_number,ppl.email,ppl.address_1 from ".$this->db->dbprefix('people')." ppl ";
			$sql .= "left join ".$this->db->dbprefix('employees')." emp on emp.person_id=ppl.person_id ";
			$sql .= "where ppl.person_id= '".$user_id."' ";
			$query = $this->db->query($sql);
			if ($query->num_rows() <> 0)
			{
				$user = array();
				foreach ($query->result_array() as $row)
   			{
		 			$user[] = $row;
   			}
   			$data['user'] = $user;
			}else{
				$data['error_msg'] = "User tidak ditemukan !";
			}
			if($this->input->post("addr")) $data['addr'] = $this->input->post("addr");
			$this->load->view("config/edituser",$data);
	}
	
	function updateuser()
	{
		$this->form_validation->set_rules('first_name', 'Nama lengkap', 'required');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
		$this->form_validation->set_rules('telp', 'Nomor telepon', 'callback_ceck_phone');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
					
		if ($this->form_validation->run() == FALSE)
		{
			$data['first_name']= $this->input->post("first_name");
			$data['email']= $this->input->post("email");
			$data['telp']= $this->input->post("telp");
			$data['addr']= $this->input->post("addr");
			$this->load->vars($data);
			$this->edituser($this->input->post("person_id"));
		}else{
			$this->db = $this->load->database('default', TRUE); 
			$this->db->trans_start(TRUE); // Query will be rolled back
			$updatequery = "update ".$this->db->dbprefix('people')." ";
			$updatequery .= "set first_name='".$this->input->post("first_name")."', email='".$this->input->post("email")."', phone_number='".$this->input->post("telp")."', address_1='".$this->input->post("addr")."' ";
			$updatequery .= "where person_id='".$this->input->post("person_id")."' ";
			$this->db->query($updatequery);
			$this->db->trans_complete();
			
			$this->userlist();
		}
	}
	
	function userpriv($user_id)
	{
		$this->db = $this->load->database('default', TRUE); 
		$sql = "select username from ".$this->db->dbprefix('employees')." ";
		$sql .= "where person_id= '".$user_id."' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() <> 0)
		{
			$data['username']=$query->row()->username;
			
			$sql = "select md.module_id,pms.person_id from ".$this->db->dbprefix('modules')." md ";
			$sql .= "left join ".$this->db->dbprefix('permissions')." pms on md.module_id=pms.module_id and pms.person_id= '".$user_id."' ";
			//$sql .= "where ppl.person_id= '".$user_id."' ";
			$query = $this->db->query($sql);
			if ($query->num_rows() <> 0)
			{
				$modules = array();
				foreach ($query->result_array() as $row)
   			{
					$modules[] = $row;
   			}
   			$data['modules'] = $modules;
   			$data['person_id'] = $user_id;
			}
		}else{
			$data['error_msg'] = "User tidak ditemukan !";
		}
					
		$this->load->view("config/userpriv",$data);
	}
	
	function updatepriv()
	{
		//$fields = $_POST['fields'];
		$fields = $this->input->post("fields");
		if (is_array($fields)) {
			$this->db = $this->load->database('default', TRUE); 
			//delete permissions sebelumnya
			$this->db->trans_start(TRUE); // Query will be rolled back
			$deletequery = "delete from ".$this->db->dbprefix('permissions')." ";
			$deletequery .= "where person_id='".$this->input->post("person_id")."' ";
			$this->db->query($deletequery);
			$this->db->trans_complete();
			
			foreach ($fields as $key=>$val) {
				//$data['error_msg'] .= "$key -> $val  <br />";
				//echo "$key -> $val --".$this->input->post("person_id")." <br />";
				$this->db->trans_start(TRUE); // Query will be rolled back
				$insquery = "insert into ".$this->db->dbprefix('permissions')." (module_id,person_id) ";
				$insquery .= "values ('".$val."', '".$this->input->post("person_id")."') ";
				$this->db->query($insquery);
				$this->db->trans_complete();
				//echo "insquery = ".$insquery."<br>";
			}
		}
		//$this->userpriv($this->input->post("person_id"));
		$this->userlist();
	}
	
	function deluser($user_id)
	{
			$this->db = $this->load->database('default', TRUE); 
			$sql = "select ppl.person_id,emp.username,ppl.first_name from ".$this->db->dbprefix('people')." ppl ";
			$sql .= "left join ".$this->db->dbprefix('employees')." emp on emp.person_id=ppl.person_id ";
			$sql .= "where ppl.person_id= '".$user_id."' ";
			$query = $this->db->query($sql);
			if ($query->num_rows() <> 0)
			{
				$user = array();
				foreach ($query->result_array() as $row)
   			{
		 			$user[] = $row;
   			}
   			$data['user'] = $user;
   			$data['person_id'] = $user_id;
   			$data['do_del'] = TRUE;
			}else{
				$data['error_msg'] = "User tidak ditemukan !";
				$data['do_del'] = FALSE;
			}
			$this->load->vars($data);
			$this->userlist();
	}
	
	function dodeluser()
	{
		if (($this->input->post("person_id")) && ($this->input->post("person_id") <> '1')) {
			$this->db = $this->load->database('default', TRUE); 
			//delete user permissions
			$this->db->trans_start(TRUE); // Query will be rolled back
			$deletequery = "delete from ".$this->db->dbprefix('permissions')." ";
			$deletequery .= "where person_id='".$this->input->post("person_id")."' ";
			$this->db->query($deletequery);
			$this->db->trans_complete();
			
			//delete user employees
			$this->db->trans_start(TRUE); // Query will be rolled back
			$deletequery = "delete from ".$this->db->dbprefix('employees')." ";
			$deletequery .= "where person_id='".$this->input->post("person_id")."' ";
			$this->db->query($deletequery);
			$this->db->trans_complete();
			
			//delete user people
			$this->db->trans_start(TRUE); // Query will be rolled back
			$deletequery = "delete from ".$this->db->dbprefix('people')." ";
			$deletequery .= "where person_id='".$this->input->post("person_id")."' ";
			$this->db->query($deletequery);
			$this->db->trans_complete();
		}
		$this->userlist();
	}
	
	/***Fungsi-fungsi**********************************************/
	
	function exists_username($name)
	{
		if($name == ''){
			$this->form_validation->set_message('exists_username', '%s belum terisi !');
			return FALSE;
		}else{
			$this->db = $this->load->database('default', TRUE); 
			$sql = "select username from ".$this->db->dbprefix('employees')." ";
			$sql .= "where username= '".$name."' ";
			$query = $this->db->query($sql);
			if ($query->num_rows() == 0)
			{
				return TRUE;
			}else{
				$this->form_validation->set_message('exists_username', '%s sudah pernah digunakan !');
				return FALSE;
			}
		}
	}
	
	function ceck_phone($str)
  {
    if($str == ''){
			return TRUE;
		}else{
    	if (preg_match("/[^0-9\^;]/", $str)){
    		$this->form_validation->set_message('ceck_phone', 'Input %s tidak benar ! <br>pisahkan dengan tanda ";" untuk lebih dari satu nomor');
				return FALSE;
    	}else{
	    	return TRUE;
    	}
    }
  }
  
  
}
?>