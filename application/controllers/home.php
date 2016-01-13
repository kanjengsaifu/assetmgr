<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		
		if($this->uri->segment(1)) $module_id=$this->uri->segment(1);
		else $module_id='home';
		
		$this->module_id=$module_id;
		$logged_in_employee_info=$this->Employee->get_logged_in_employee_info();
		if($logged_in_employee_info<>false) $this->allowed_modules=$this->Module->get_allowed_modules($logged_in_employee_info->person_id);
		else $this->allowed_modules=array();
		$this->user_info=$logged_in_employee_info;
		
	}
	
	
	public function index()
	{
		$data['module_id']=$this->module_id;
		$data['allowed_modules']=$this->allowed_modules;
		$data['user_info']=$this->user_info;
		
		$this->load->view('home',$data);
	}
	
	function front()
	{
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			$data['module_id']=$this->module_id;
			$data['allowed_modules']=$this->allowed_modules;
			$data['user_info']=$this->user_info;
			$this->load->view('default',$data);
		}		
	}
	
	function about()
	{
		$this->load->view('about');
	}
	
	function logout()
	{
		$this->Employee->logout();
	}
}
