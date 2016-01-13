<style>
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	fieldset { padding:0; border:0; margin-top:25px; }
	.ui-dialog .ui-state-error { padding: .3em; }
	.validateTips { border: 1px solid transparent; padding: 0.3em; }
	.errorMsg { border: 1px solid transparent; padding: 0.3em; }
</style>
<script type="text/javascript">
	$.fx.speeds._default = 500;
	$(document).ready(function() {

		$('#add_item').submit(function() {
					
					var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>",
							errormsg = $( ".errorMsg" );
					
					if(document.add_item.group.value == "new" || document.add_item.group.value == "0")
					{
						alert('Anda belum memilih Grup!');
						//errormsg.text( 'Anda belum memilih Grup!' );
						//$( "#dialog-modal" ).dialog( "open" );
						$('#group').focus();
					}else if(document.add_item.itm_name.value == ""){
						alert('Anda belum mengisi Nama item!');
						//errormsg.text( 'Anda belum mengisi Nama item!' );
						//$( "#dialog-modal" ).dialog( "open" );
						$('#itm_name').focus();
					}else if(document.add_item.nl_perolehan.value == ""){
						alert('Anda belum mengisi Nilai Perolehan!');
						//errormsg.text( 'Anda belum mengisi Nilai Perolehan!' );
						//$( "#dialog-modal" ).dialog( "open" );
						$('#nl_perolehan').focus();
					}else if (isDate(document.add_item.tgl_perolehan.value)==false){
						//alert('Format tanggal perolehan tidak tepat!');
						$('#tgl_perolehan').focus();
					}else if(document.add_item.masa.value == ""){
						alert('Anda belum mengisi Masa Penggunaan!');
						//errormsg.text( 'Anda belum mengisi Masa Penggunaan!' );
						//$( "#dialog-modal" ).dialog( "open" );
						$('#masa').focus();
						
					//}else if(document.add_item.divisi.value == ""){
					//	alert('Anda belum memilih Divisi!');
					//	$('#divisi').focus();
						
					}else{
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
					}
					return false;
		});
		
		$('#update_item').submit(function() {
					
					var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>",
							errormsg = $( ".errorMsg" );
					
					
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
		
		$('#add_new_group_form').submit(function() {
					
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
		
		$('#add_new_divisi_form').submit(function() {
					
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
		
		$('#show_item').submit(function() {
					
					var image_load = "<div class='ajax_loading_small'><img src='"+loading_image_large+"' /></div>";
					
					$.ajax({
						type: 'POST',
						url: $(this).attr('action'),
						data: $(this).serialize(),
						beforeSend: function(){
            	$('#div_itemls').html(image_load);
        		},
						success: function(data) {
							$('#div_itemls').html(data);
						}
					})
					return false;
		});
		
	})
	
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$( "#tgl_perolehan" ).datepicker({dateFormat: 'dd-mm-yy'});
		
		var grp_name = $( "#grp_name" ),
			grp_cd = $( "#grp_cd" ),
			allFields = $( [] ).add( grp_name ).add( grp_cd ).add( div_name ),
			div_name = $( "#div_name" ),
			tips = $( ".validateTips" );
			
		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}
		
		function checkLength( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Jumlah karakter untuk " + n + " harus diantara " +
					min + " dan " + max + " karakter." );
				return false;
			} else {
				return true;
			}
		}
		
		function checkFixLength( o, n, jml ) {
			if ( o.val().length == jml ) {
				return true;
			} else {
				o.addClass( "ui-state-error" );
				updateTips( n + " harus terdiri dari " +
					jml + " karakter." );
				return false;
			}
		}

		function checkRegexp( o, regexp, n ) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}
		
		$( "#dialog-modal" ).dialog({
			autoOpen: false,
			height: 140,
			modal: true
		});
		
		$( "#dialog-message" ).dialog({
			autoOpen: 
			<?php 
				if (isset($err_add) && $err_add==TRUE) echo "true"; else echo "false";
			?>
			,
			resizable: false,
			width: 350,
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$( "#dialog-add-group" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 290,
			width: 350,
			modal: true,
			buttons: {
				"Tambah": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkLength( grp_name, "Nama grup", 3, 60 );
					bValid = bValid && checkFixLength( grp_cd, "Kode grup", 3 );

					if ( bValid ) {
						$('#add_new_group_form').submit();
						$( this ).dialog( "close" );
					}
					
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$( "#dialog-add-divisi" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 240,
			width: 350,
			modal: true,
			buttons: {
				"Tambah": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkLength( div_name, "Nama divisi", 3, 60 );

					if ( bValid ) {
						$('#add_new_divisi_form').submit();
						$( this ).dialog( "close" );
					}
					//$('#add_new_divisi_form').submit();
					//$( this ).dialog( "close" );
					
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$( "#dialog-item-detail" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 400,
			width: 500,
			modal: true,
			show: "blind",
			hide: "blind",
			buttons: {
				Close: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$( "#dialog-delete-item" ).dialog({
			autoOpen: false,
			resizable: false,
			width: 350,
			modal: true,
			buttons: {
				Delete: function() {
					$('#form_delete_item').submit();
					$( this ).dialog( "close" );
				},
				Cencel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	
	function group_action(grp)
  {
  	if(grp.value=='new'){
			$( "#dialog-add-group" ).dialog( "open" );
			grp.value='0';
		}
		/*else if(grp.value!='0'){
			send_form_loading(document.add_item,'input/new_item','#content');
		}*/
  }
  
  function divisi_action(div)
  {
  	if(div.value=='new'){
			$( "#dialog-add-divisi" ).dialog( "open" );
			div.value='0';
		}
	}
  
  function show_item_list(grp)
  {
  	if(grp.value!='0'){
			$('#show_item').submit();
		}
  }
  
  function open_edit_item(itm)
  {
  	load('input/edit_detail/' + itm,'#form_item');
  }
  
  function open_dialog_item(itm)
  {
  	$( "#dialog-item-detail" ).dialog("open");
  	load('view/view_detail/' + itm,'#dialog-item-detail');
  }
  
  
</script>	

<!--DIV ERROR MESSAGES-->
<div id="dialog-modal" title="Error">
	<p class="errorMsg">Pesan error</p>
</div>
<!--End of DIV ERROR MESSAGES-->

<!--DIV DELETE ITEM-->
<div id="dialog-delete-item" title="Delete Item">
	Anda akan menghapus item [<b><span id="delete_itemid">kode</span></b>] <b><span id="delete_itemname">name</span></b> 
	<br> Lanjutkan ?
	
</div>

<!--End of DIV DELETE ITEM-->

<!--FORM TAMBAH GRUP BARU-->
<div id="dialog-add-group" title="Tambah Grup">
	
	<p class="validateTips">Silahkan isi data grup.</p>
	<?php echo form_open_multipart('input/add_grp', array('name'=>'add_new_group_form','id'=>'add_new_group_form'));?>
		<fieldset>
			<label for="grp_name">Nama Grup</label>
			<input type="text" name="grp_name" id="grp_name" class="text ui-widget-content ui-corner-all value="<?php if(isset($grp_name)) echo $grp_name; ?>" size="30" />
			<label for="grp_cd">Kode Grup</label>
			<input type="text" name="grp_cd" id="grp_cd" class="text ui-widget-content ui-corner-all value="<?php if(isset($grp_cd)) echo $grp_cd; ?>" size="30" />
		</fieldset>
		
	<?php echo form_close(); ?>
	<?php 
	if(isset($grp_error_msg)){
		echo "<br><div style='width:60%;background-color:#232323;border:1px solid #BCBCBC;margin:0 auto;padding:5px;'>".$grp_error_msg."</div>";
	} 
	?>
</div>

<div id="dialog-message" title="Data gagal disimpan">
	<br>
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 10px 25px 0;"></span>
		Error :	<?php 
		if(isset($error_msg)){
			//echo "<div style='width:60%;background-color:#232323;border:1px solid #BCBCBC;margin:0 auto;padding:5px;'>".$grp_error_msg."</div>";
			echo $error_msg;
		} 
	?>
	</p>
</div>
<!--End Of FORM TAMBAH GRUP BARU-->

<!--FORM TAMBAH DIVISI BARU-->
<div id="dialog-add-divisi" title="Tambah Divisi">
	
	<p class="validateTips">Silahkan isi data divisi.</p>
	<?php echo form_open_multipart('input/add_div', array('name'=>'add_new_divisi_form','id'=>'add_new_divisi_form'));?>
		<fieldset>
			<label for="div_name">Nama Divisi</label>
			<input type="text" name="div_name" id="div_name" class="text ui-widget-content ui-corner-all value="<?php if(isset($div_name)) echo $div_name; ?>" size="30" />
		</fieldset>
		
	<?php echo form_close(); ?>
	<?php 
	if(isset($div_error_msg)){
		echo "<br><div style='width:60%;background-color:#232323;border:1px solid #BCBCBC;margin:0 auto;padding:5px;'>".$div_error_msg."</div>";
	} 
	?>
</div>
<!--End Of FORM TAMBAH DIVISI BARU-->

<div class='title'>
	<?php echo $this->lang->line("module_".$this->uri->segment(1)."_desc");?>
</div>


<?php echo form_open_multipart('input/add_item', array('name'=>'add_item', 'id'=>'add_item'));?>
<div id='form_item' class='div_round'>
<table width="700" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="0" border="0">
	<tr bgcolor="#DDDDDD">
		<td align="center" colspan=2><b>Input Item Baru</b></td>
	</tr>
	<tr class='row1'>
		<td style="padding-left:5px;"><b>Grup</b></td>
		<td style="padding-left:5px;">
			<select name="group" id="group" onchange='group_action(this)'>
						<option value="0">Pilih grup..........</option>
						<?php
						if(isset($group_list))
						{
							foreach($group_list as $line=>$item){
							?>
								<option value="<?php echo $item['GRP_CODE']; ?>" <?php if(isset($group) && $group==$item['GRP_CODE']) echo "selected=\"selected\""; ?> ><?php echo $item['GRP_DESC']." [".$item['GRP_CODE']."] "; ?></option>
							<?php
							}
						}
						?>
						<option value="new">Tambah grup......</option>
			</select>	
		</td>
	</tr>
	<tr class='row2'>
		<td style="padding-left:5px;"><b>Nama Item</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="itm_name" id="itm_name" value="<?php echo set_value('itm_name'); ?>" size="60" onkeyup="replaceQuote(this);" onchange="replaceQuote(this);" />
		</td>
	</tr>
	<tr class='row1'>
		<td style="padding-left:5px;"><b>Nilai Perolehan</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="nl_perolehan" id="nl_perolehan" value="<?php echo set_value('nl_perolehan'); ?>" size="20" onkeyup="formatNumber(this);" onchange="formatNumber(this);"/>
		</td>
	</tr>
	<tr class='row2'>
		<td style="padding-left:5px;"><b>Tanggal Perolehan</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="tgl_perolehan" id="tgl_perolehan" size="10" value="<?php if(isset($tgl_perolehan)) echo $tgl_perolehan; else echo date("d-m-Y"); ?>" />
		</td>
	</tr>
	<tr class='row1'>
		<td style="padding-left:5px;"><b>Masa Penggunaan</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="masa" id="masa" value="<?php echo set_value('masa'); ?>" size="2"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/> tahun
		</td>
	</tr>
	<tr class='row2'>
		<td style="padding-left:5px;"><b>Voucher</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="vcr" id="vcr" value="<?php echo set_value('vcr'); ?>" size="20" onkeyup="replaceQuote(this);" onchange="replaceQuote(this);" />
		</td>
	</tr>
	<tr class='row1'>
		<td style="padding-left:5px;"><b>Divisi</b></td>
		<td style="padding-left:5px;">
			<select name="divisi" id="divisi" onchange='divisi_action(this)'>
						<option value="0">Pilih divisi..........</option>
						<?php
						if(isset($divisi_list))
						{
							foreach($divisi_list as $line=>$item){
							?>
								<option value="<?php echo $item['DIV_ID']; ?>" <?php if(isset($divisi) && $divisi==$item['DIV_ID']) echo "selected=\"selected\""; ?> ><?php echo $item['DIV_DESC']; ?></option>
							<?php
							}
						}
						?>
						<option value="new">Tambah divisi......</option>
			</select>	
		</td>
	</tr>
	<tr bgcolor="#DDDDDD">
		<td colspan=2>
			<div align="right"><?php echo form_submit('addButton','Simpan'); ?></div>	
		</td>
	</tr>
</table>
</div>
<?php echo form_close(); ?>

<br>
<div class='title'>Daftar Item</div>
<div class='div_round_width'>
	<?php echo form_open_multipart('input/show_item', array('name'=>'show_item', 'id'=>'show_item'));?>
	&nbsp;&nbsp;<b>Grup</b>&nbsp; <select name="group" id="group" onchange='show_item_list(this)'>
		<option value="0">Pilih grup..........</option>
		<?php
			if(isset($group_list))
			{
				foreach($group_list as $line=>$item){
				?>
					<option value="<?php echo $item['GRP_CODE']; ?>" <?php if(isset($group) && $group==$item['GRP_CODE']) echo "selected=\"selected\""; ?> ><?php echo $item['GRP_DESC']." [".$item['GRP_CODE']."] "; ?></option>
				<?php
				}
			}
			?>
	</select>	
	&nbsp;&nbsp;&nbsp;&nbsp;<b>Kode/Nama item</b>
	&nbsp; <input type="text" name="itm_name" id="itm_name" value="<?php if(isset($itm_name)) echo $itm_name;?>" size="50" onkeyup="replaceQuote(this);" onchange="replaceQuote(this);" />
	<?php echo form_close(); ?>
</div><br>
<div id="div_itemls" class='div_round_width'>
	<?php
	if(isset($item_list) && isset($pg)) {
		$this->load->view('input/item_list');
	}else{ ?>
		<center>Silahkan pilih Grup atau input Kode/Nama item.....<center>
	<?php
	} ?>
</div>
<div id="dialog-item-detail" title="Detail Asset">
	
</div>
<br>
