<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $this->config->item('site_name');?> versi <?php echo $this->config->item('version');?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-1.6.4.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-ui-1.8.16.custom.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.pagination.js"></script>-->
    <script type='text/javascript'>
        var site = "<?php echo site_url()?>";
        var loading_image_large = "<?php echo base_url();?>asset/images/loading_large.gif";
    </script>
    <script type="text/javascript" src="<?php echo base_url();?>asset/js/app.js" ></script>
    
    <link href="<?php echo base_url();?>asset/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>asset/css/jpaginate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>asset/css/vader/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
    
   	<link rel="shorcut icon" href="<?php echo base_url(); ?>asset/images/favicon.ico" />
    
</head>
<body>

<div id="container">
	<div id='header'>
   	<div class='logo'>
   		<h1>Company Asset Manager</h1>
   		<?php
    	if($this->Employee->is_logged_in())
    	{ ?>
   			[ Login as : <b><font color="#dd4b39"><?php echo $user_info->first_name; ?></font></b> ]
   		<?php
   		} ?>
   	</div>
		<div class='tabs'>
    	<a class='current_tab' href="javascript:void(0);" onclick='load("home/front","#content");switch_tab(this);'>
    		<img src="<?php echo base_url().'asset/images/home.png';?>" width=32 height=32 border="0" alt="Menubar Image">
    		Home
    	</a>
    	
    	<?php
    	if($this->Employee->is_logged_in())
    	{
 				foreach($allowed_modules->result() as $module)
				{
				?>
	    		<a id='<?php echo $module->module_id; ?>' class='tab' href="javascript:void(0);" onclick='load("<?php echo $module->module_id;?>","#content");switch_tab(this);'>
    				<img src="<?php echo base_url().'asset/images/'.$module->module_id.'.png';?>" width=32 height=32 border="0" alt="Menubar Image">
    				<?php echo $this->lang->line("module_".$module->module_id) ?>
    			</a>
    		<?php
				}
			}
			?>
			<a class='tab' href="javascript:void(0);" onclick='load("home/about","#content");switch_tab(this);'>
    		<img src="<?php echo base_url().'asset/images/info.png';?>" width=32 height=32 border="0" alt="Menubar Image">
    		About
    	</a>
    	<?php
    	if($this->Employee->is_logged_in())
			{
    	?>
    	<a class='tab' href="<?php echo site_url('home/logout');?>" >
    		<img src="<?php echo base_url().'asset/images/logout.png';?>" width=32 height=32 border="0" alt="Menubar Image">
    		logout
    	</a>
    	<?php
    	}
    	?>
    </div>
  </div>
	 
	<div id='content'>
		<?php
		if(!$this->Employee->is_logged_in())
		{
			$this->load->view('login');
		}else{
			$this->load->view('default');
		}		
		?>
	 	
	</div>	
	 	
	<div id='footer'>
   	<div class='left_footer'><?php echo $this->config->item('site_name');?> &copy; 2011 by <font color="#FF8000"><a href="mailto:whaone@gmail.com">whaone</a></font></div>
   	<div class='right_footer'>versi <?php echo $this->config->item('version');?></div>
  </div>
</div>

</body>
</html>