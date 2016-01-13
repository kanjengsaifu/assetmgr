<script type="text/javascript">
	$(document).ready(function() {

		$('#updatepwd').submit(function() {
					
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
<div class='title'>Ganti Password</div>
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
 							<div class="subTopic">Ganti password untuk Username '<b><?php echo $username;?></b>'</div>
 						</td>
 						<td align="right">
 							[ <a href="javascript:void(0);" onclick='load("config/config","#content");switch_tab("#config");'>Kembali</a> ]
 						</td>
 					</tr>
 				</table>
 			</td>
 		</tr>
 	</table>		
	<?php echo form_open('config/updatepwd',array('name'=>'updatepwd','id'=>'updatepwd'));?>
 	<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="1" border="0">
 		<tr bgcolor="#FFFFFF">
 			<td width="160">&nbsp;Password</td>
 			<td><input type="password" name="passwd" size="20" /></td>
 		</tr>
 		<tr bgcolor="#EEEEEE">
 			<td>&nbsp;Konfirmasi Password</td>
 			<td><input type="password" name="conpasswd" size="20" /></td>
 		</tr>
   		
 		<tr>
 			<td></td>
 			<td align="right"><?php echo form_submit('saveButton','Simpan'); ?>
 			</td>
 		</tr>
 	</table>
 	<?php echo form_hidden('person_id', $person_id); ?>
 	<?php echo form_close(); ?>
	</div>
 	<br>
 	<?php echo validation_errors();
}else{
	echo "<div class=\"error\">$error_msg</div>";
	?><div align="center">[ <a href="javascript:void(0);" onclick='load("config/config","#content");switch_tab("#config");'>Kembali</a> ]</div><?php
}
?><br>
		