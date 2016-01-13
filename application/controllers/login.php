<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->view('home');
	}
	
	function do_login()
	{
		$data['username'] = $this->input->post("username");
		
		if(trim($_POST['username']) == '' or trim($_POST['password']) == '' or $this->login_check($this->input->post("username"))==false)
		{
			$data['log_error'] = '<b>Error</b>: <br />'.$this->lang->line('login_invalid_username_and_password');
		}else{
			redirect('home');
		}
		
		$this->load->view('home',$data);
	}
	
	function login_check($username)
	{
		$password = $this->input->post("password");	
		
		if(!$this->Employee->login($username,$password))
		{
			//$this->form_validation->set_message('login_check', $this->lang->line('login_invalid_username_and_password'));
			//$this->form_validation->set_message('login_check', 'Invalid Username and Password');
			return false;
		}
		return true;		
	}
	
	
}
?>