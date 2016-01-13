<script type="text/javascript">
	$(document).ready(function() {

		$('#addnewuser').submit(function() {
					
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
<div class='title'>Tambahkan user baru</div>
<br>
<div style='margin:auto;width:600px;border:1px solid #D8DFEA;	padding:2px;	background:#FFFFFF;'>
<?php echo form_open('config/addnewuser',array('name'=>'addnewuser','id'=>'addnewuser'));?>
<table width="100%" bgcolor="#DDDDDD" cellpadding="0" cellspacing="1" border="0" align="center">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<div class="subTopic"></div>
					</td>
					<td align="right">
						[ <a href="javascript:void(0);" onclick='load("config/config","#content");switch_tab("#config");'>Kembali</a> ]
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="1" border="0">
	<tr bgcolor="#FFFFFF">
		<td width="160">&nbsp;Username&nbsp;<font color="red" size="1"><b>*</b></font></td>
		<td><input type="text" name="username" value="<?php echo set_value('username'); ?>" size="15" /></td>
	</tr>
	<tr bgcolor="#EEEEEE">
		<td>&nbsp;Password&nbsp;<font color="red" size="1"><b>*</b></td>
		<td><input type="password" name="passwd" size="15" /></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>&nbsp;Konfirmasi Password&nbsp;<font color="red" size="1"><b>*</b></td>
		<td><input type="password" name="conpasswd" size="15" /></td>
	</tr>
	<tr bgcolor="#EEEEEE">
		<td>&nbsp;Nama Lengkap&nbsp;<font color="red" size="1"><b>*</b></td>
		<td><input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" size="40" /></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>&nbsp;Email</td>
		<td><input type="text" name="email" value="<?php echo set_value('email'); ?>" size="20" /></td>
	</tr>
	<tr bgcolor="#EEEEEE">
		<td>&nbsp;Telepon</td>
		<td><input type="text" name="telp" value="<?php echo set_value('telp'); ?>" size="20" /></td>
	</tr>
  <tr bgcolor="#FFFFFF">
 		<td valign="top">&nbsp;Alamat</td>
 		<td><textarea cols=38 rows=3 name="addr"><?php echo set_value('addr'); ?></textarea></td>
 	</tr>
 	<tr>
 		<td colspan="2">&nbsp;<font color="red" size="1"><b>*</b></font>&nbsp;<font size="1">harus diisi</font>
 			<div align="right"><?php echo form_submit('addButton','Simpan'); ?></div>
 		</td>
 	</tr>
</table>
    	
<?php echo form_close(); ?>
</div>
<br>
<?php 
echo validation_errors();
if(isset($error_msg)){
	echo "<div class=\"error\">$error_msg</div>";
} 
?>