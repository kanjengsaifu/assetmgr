<script type="text/javascript">
	$(document).ready(function() {

		$('#updatepriv').submit(function() {
					
					var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
					
					$.ajax({
						type: 'POST',
						url: $(this).attr('action'),
						data: $(this).serialize(),
						beforeSend: function(){
            	$('#content').html(image_load);
        		},
						success: function(data) {
							$('#content').html(data);
						}
					})
					return false;
		});
	})
</script>	
<div class='title'>Edit Hak Akses</div>
<br> 	
<?php
if(!isset($error_msg))
{
?>
	<div style='margin:auto;width:350px;border:1px solid #D8DFEA;	padding:2px;	background:#FFFFFF;'>
	<table width="100%" bgcolor="#EEEEEE" cellpadding="2" cellspacing="1" border="0" align="center">
		<tr>
  		<td>
	    	<table width="100%" cellpadding="0" cellspacing="0" border="0">
    			<tr>
	    			<td>
    					<div class="subTopic">Edit hak akses untuk user '<b><font color="blue"><?php echo $username; ?></font></b>'</div>
    				</td>
    				<td align="right">
	    				[ <a href="javascript:void(0);" onclick='load("config/config","#content");switch_tab("#config");'>Kembali</a> ]
    				</td>
    			</tr>
    		</table>
    	</td>
  	</tr>
	</table>		
	<?php echo form_open_multipart('config/updatepriv', array('name'=>'updatepriv', 'id'=>'updatepriv'));?>
	<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="1" border="0">
		<tr bgcolor="#DDDDDD">
 			<td width="40" align="center">&nbsp;<b>Akses</b></td>
 			<td>&nbsp;<b>Module</b></td>
 		</tr>
	</table>
	<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="1" border="0">
		<?php
		foreach($modules as $line=>$mod){
		?>
 			<tr bgcolor="#EEEEEE">
	 			<td width="40" align="center"><input type="checkbox" name="fields[]" value="<?php echo $mod['module_id']; ?>" <?php if($mod['person_id'] == $person_id) echo "checked=\"checked\""; ?>></td>
	    	<td>&nbsp;<?php echo $mod['module_id']; ?></td>
  	  </tr>
				
  	<?php 
  	}?>
  	<tr>
  		<td></td>
  		<td align="right"><?php echo form_submit('saveButton','Simpan'); ?>
  		</td>
  	</tr>
	</table>
	<?php 
	echo form_hidden('person_id', $person_id);
	?>
	<?php echo form_close(); ?>
	</div>
	<br><?php echo validation_errors();
}else{
	echo "<div class=\"error\">$error_msg</div>";
	?><div align="center">[ <a href="<?php echo site_url('config/config'); ?>">Kembali</a> ]</div><?php
}
?><br>
			