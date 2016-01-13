<br>
<center>
<h2>Selamat datang di <?php echo $this->config->item('site_name');?></h2>

<br><br><br>
<div class="homelink">
	<?php
 	foreach($allowed_modules->result() as $module)
	{
	?>
		&nbsp;&nbsp;
   	<a href="javascript:void(0);" onclick='load("<?php echo $module->module_id;?>","#content");switch_tab("#<?php echo $module->module_id; ?>");'><img src="<?php echo base_url().'asset/images/48'.$module->module_id.'.png';?>" width=48 height=48 border="0" alt="Menubar Image">
   	<?php echo $this->lang->line("module_".$module->module_id.'_desc') ?></a><br><br><br>
   
		<?php
	}
	?>
</div>
<br>
</center>