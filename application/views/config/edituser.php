<script type="text/javascript">
	$(document).ready(function() {

		$('#updateuser').submit(function() {
					
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
<div class='title'>Edit User</div>
<br>
<div style='margin:auto;width:600px;border:1px solid #D8DFEA;	padding:2px;	background:#FFFFFF;'>
<?php echo form_open('config/updateuser',array('name'=>'updateuser','id'=>'updateuser'));?>
<table width="100%" bgcolor="#DDDDDD" cellpadding="2" cellspacing="1" border="0" align="center">
	<tr>
		<td colspan=2>
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

<?php
	foreach($user as $line=>$usr){
	?>
 		<tr bgcolor="#EEEEEE">
 			<td width="160">&nbsp;Username</td>
 			<td><b><?php echo $usr['username']; ?></b></td>
 		</tr>
		<tr bgcolor="#FFFFFF">
 			<td>&nbsp;Nama Lengkap</td>
 			<td><input type="text" name="first_name" value="<?php if(isset($first_name)) echo $first_name; elseif($usr['first_name']<>" ") echo $usr['first_name'] ?>" size="40" /></td>
 		</tr>
 		<tr bgcolor="#EEEEEE">
 			<td>&nbsp;Email</td>
 			<td><input type="text" name="email" value="<?php if(isset($email)) echo $email; elseif($usr['email']<>" ") echo $usr['email'] ?>" size="20" /></td>
 		</tr>
 		<tr bgcolor="#FFFFFF">
 			<td>&nbsp;Telepon</td>
 			<td><input type="text" name="telp" value="<?php if(isset($telp)) echo $telp; elseif($usr['phone_number']<>" ") echo $usr['phone_number'] ?>" size="20" /></td>
 		</tr>
 		<tr bgcolor="#EEEEEE">
 			<td valign="top">&nbsp;Alamat</td>
 			<td><textarea cols=38 rows=3 name="addr"><?php if(isset($addr)) echo $addr; else echo $usr['address_1'] ?></textarea></td>
 		</tr>
 		<tr>
 		<?php 
 		$person_id = $usr['person_id'];
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
if(isset($error_msg)){
	echo "<div class=\"error\">$error_msg</div>";
}
?><br>
<br>
<br>
	