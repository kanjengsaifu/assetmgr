<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
if(isset($do_del) && $do_del==TRUE){
?>
	<script type='text/javascript'>
		$( "#dialog-del-user" ).dialog({
			//autoOpen: false,
			resizable: false,
			height: 120,
			width: 350,
			modal: true,
			buttons: {
				"Delete": function() {
					$('#do_delete_user_form').submit();
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
				
		$(document).ready(function() {
		
			$('#do_delete_user_form').submit(function() {
					
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
	<div id="dialog-del-user" title="Konfirmasi delete user">
		Hapus user dengan username <b><?php echo $user[0]['username']; ?></b> ?
	</div>
	<form method='post' action='config/dodeluser' name='do_delete_user_form' id='do_delete_user_form'>
		<input type="hidden" name="person_id" value="<?php echo $person_id; ?>" />
	</form>
<?php	
}
?>
<div class='title'>Daftar User</div>
<br>
<br>
<div class='div_round'>
<table cellpadding="0" cellspacing="1" border="0" width="100%" align="center">
	<tr bgcolor="#EEEEEE" height="22">
		<td align="right">
			[ <a href="javascript:void(0);" onclick='load("config/newuser","#content");switch_tab("#config");'>Tambah User</a> ]&nbsp;&nbsp;
		</td>
	</tr>
	<tr bgcolor="#DDDDDD">
		<td align="center">
			<?php
			if(isset($error))
			{
				echo "<div class='error'>$error</div>";
			}else{ ?>
				<table width="100%" bgcolor="#DDDDDD" border="0" cellpadding="1" cellspacing="1">
					<tr bgcolor="#CCCCCC">
 						<td width="30">&nbsp;<b>Id</b></td>
 						<td width="80">&nbsp;<b>Username</b></td>
 						<td width="180">&nbsp;<b>Nama</b></td>
 						<td>&nbsp;<b>Alamat</b></td>
 						<td width="80">&nbsp;</td>
 					</tr>
  	
					<?php
					$color = "EEEEEE"; 
					foreach($userslist as $line=>$user){
						if ($color == "EEEEEE") $color = "FFFFFF";
						else $color = "EEEEEE"; 
						?>
						<tr bgcolor="#<?php echo $color; ?>" height="25">
							<td width="30" valign="top" style="padding-left:5px;"><?php echo $user['person_id']; ?></td>
							<td width="80" valign="top" style="padding-left:5px;"><?php echo $user['username']; ?></td>
							<td width="180" valign="top" style="padding-left:5px;"><?php echo $user['first_name']." ".$user['last_name']; ?></td>
							<td width="300" valign="top" style="padding-left:5px;"><?php 
							if ($user['address_1']<>" ") echo $user['address_1']."<br>"; 
							if ($user['phone_number']<>" ") echo "<font color=\"blue\">Telepon</font> : ".$user['phone_number']."<br>";
							if ($user['email']<>" ") echo "<font color=\"blue\">Email</font> : ".$user['email']."<br>";
							?></td>
							<td align="center" valign="center" style="padding-left:5px;">
								<?php
								if($user['superuser']==0 or ($user['superuser']==1 && $user_info->person_id==$user['person_id']))
								{ ?>
									<a title="Ganti password user" href="javascript:void(0);" onclick='load("<?php echo 'config/editpwd/'.$user['person_id']; ?>","#content");switch_tab("#config");'> 
										<span class="ui-icon ui-icon-key" style="float:left; margin:0 0 0 0;"> 
									</a>
									<a title="Edit user" href="javascript:void(0);" onclick='load("<?php echo 'config/edituser/'.$user['person_id']; ?>","#content");switch_tab("#config");'> 
										<span class="ui-icon ui-icon-pencil" style="float:left; margin:0 0 0 0;"> 
									</a>
									<a title="Atur Hak Akses" href="javascript:void(0);" onclick='load("<?php echo 'config/userpriv/'.$user['person_id']; ?>","#content");switch_tab("#config");'> 
										<span class="ui-icon ui-icon-locked" style="float:left; margin:0 0 0 0;"> 
									</a>
									<?php
									if($user_info->person_id<>$user['person_id'] && $user['superuser']==0)
									{ ?>
										<a title="Hapus user" href="javascript:void(0);" onclick='load("<?php echo 'config/deluser/'.$user['person_id']; ?>","#content");switch_tab("#config");'>
											<span class="ui-icon ui-icon-trash" style="float:left; margin:0 0 0 0;"></span>
										</a>
									<?php
									}
								} ?>
							</td>
						</tr>
						<?php
					}	?>
				</table>
			<?php
			} ?>
 		</td>
	</tr>
</table>
</div>			
		