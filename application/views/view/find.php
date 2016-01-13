<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 500;
	$(function() {
		$( "#tgl_perolehan" ).datepicker({dateFormat: 'dd-mm-yy'});
		
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
		
		$( "#dialog-edit-detail" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 400,
			width: 700,
			modal: true,
			show: "blind",
			hide: "blind",
			buttons: {
				Save: function() {
					load('view/edit_detail/' + itm,'#dialog-item-detail');
				},
				Cencel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$( "#dialog-message" ).dialog({
			autoOpen: 
			<?php 
				if (isset($err_search_item)) echo "true"; else echo "false";
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

	});
	
	function open_dialog_item(itm)
  {
  	$( "#dialog-item-detail" ).dialog("open");
  	load('view/view_detail/' + itm,'#dialog-item-detail');
  }
  
  function open_dialog_edit_item(itm)
  {
  	$( "#dialog-edit-detail" ).dialog("open");
  	load('view/edit_detail/' + itm,'#dialog-edit-detail');
  }

	$('#find_item').submit(function() {
					
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
		
	function rp_group_action(grp)
  {
  	if(grp.value!='0'){
  		send_form(document.find_item,'view/get_masa/' + grp.value,'#div_masa');
			document.getElementById('div_divisi').style.display = 'block';
			document.getElementById('div_masa').style.display = 'block';
			document.getElementById('div_name').style.display = 'block';
			document.getElementById('div_button').style.display = 'block';
		}else{
			document.getElementById('div_divisi').style.display = 'none';
			document.getElementById('div_masa').style.display = 'none';
			document.getElementById('div_name').style.display = 'none';
			document.getElementById('div_button').style.display = 'none';
		}
  }
</script>	
<div id="dialog-message" title="Pesan">
	<br>
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 10px 25px 0;"></span>
		Error :	<?php 
		if(isset($err_search_item)){
			echo $err_search_item;
		} 
	?>
	</p>
</div>
<div class='title'>
	<?php echo $this->lang->line("module_".$this->uri->segment(1)."_desc");?>
</div>
<div class='div_round'>
<?php echo form_open_multipart('view/find', array('name'=>'find_item', 'id'=>'find_item'));?>
<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="0" border="0">
	<tr bgcolor="#DDDDDD">
		<td align="center" colspan=2><b>Pencarian</b></td>
	</tr>
	<tr class='row2'>
		<td style="padding-left:5px;" width="150"><b>Grup</b></td>
		<td style="padding-left:5px;">
			<select name="group" id="group" onchange='rp_group_action(this)'>
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
		</td>
	</tr>
</table>
<div id="div_divisi" style="display: <?php if(isset($group) && $group<>'0') echo "block"; else echo "none";?>;">
<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="0" border="0">
	<tr class='row1'>
		<td style="padding-left:5px;" width="150"><b>Divisi</b></td>
		<td style="padding-left:5px;">
			<select name="divisi" id="divisi">
				<option value="0">All</option>
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
			</select>	
		</td>
	</tr>
</table>
</div>
<div id="div_masa" style="display: <?php if(isset($group) && $group<>'0') echo "block"; else echo "none";?>;">
<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="0" border="0">
	<tr class='row2'>
		<td style="padding-left:5px;" width="150"><b>Masa Penggunaan</b></td>
		<td style="padding-left:5px;">
			<select name="masa" id="masa">
				<option value="0">All</option>
				<?php
				if(isset($masa_list))
				{
					foreach($masa_list as $line=>$item){
					?>
						<option value="<?php echo $item['AS_USE'];?>" <?php if(isset($masa) && $masa==$item['AS_USE']) echo "selected=\"selected\""; ?>><?php echo number_format($item['AS_USE'],1,'.',',');?></option>
					<?php
					}
				}
				?>			
			</select>	
			 tahun
		</td>
	</tr>
</table>
</div>
<div id="div_name" style="display: <?php if(isset($group) && $group<>'0') echo "block"; else echo "none";?>;">
<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="0" border="0">
	<tr class='row1'>
		<td style="padding-left:5px;" width="150"><b>Nama/Kode Item</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="itm_name" id="itm_name" value="<?php if(isset($itm_name)) echo $itm_name;?>" size="60" onkeyup="replaceQuote(this);" onchange="replaceQuote(this);" />
		</td>
	</tr>
</table>
</div>
<table width="100%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="1" border="0">
	<tr bgcolor="#DDDDDD" height="22">
		<td colspan=2>
			<div align="right" id="div_button" style="display: <?php if(isset($group) && $group<>'0') echo "block"; else echo "none";?>;"><?php echo form_submit('addButton','Tampilkan'); ?></div>	
		</td>
	</tr>
</table>
<?php echo form_close(); ?>
</div>
<br>
<br>
<?php
if(isset($item_list))
{
?>
<div id='list_content_small'>
	<?php if($pg > 1) { ?>
		<div class="searchresult_pagination"></div>
	<?php } ?>
	<div id="Searchresult">
	<table width="100%" bgcolor="#D8DFEA" align="center" cellpadding="2" cellspacing="1" border="0">
		<tr bgcolor="#DDDDDD">
			<td style="padding-left:5px;" width="100" rowspan=2><b>Kode</b></td>
			<td style="padding-left:5px;" rowspan=2><b>Nama</b></td>
			<td align="center" width="100" rowspan=2><b>Nilai Perolehan</b></td>
			<td align="center" width="80" rowspan=2><b>Tanggal Perolehan</b></td>
			<td align="center" width="100" colspan=2><b>Masa</b></td>
			<td align="center" width="100" rowspan=2><b>Divisi</b></td>
		</tr>
		<tr bgcolor="#EEEEEE" align="center">
			<td style="padding-left:5px;" width="50"><b>Tahun</b></td>
			<td style="padding-left:5px;" width="50"><b>Bulan</b></td>
		</tr>
		<?php
		$class="class='row1'";
		foreach($item_list[1] as $line=>$item){
		?>
			<tr <?php echo $class; ?>>
				<td style="padding-left:5px;"><?php echo $item['AS_CODE']; ?></td>
				<td style="padding-left:5px;">
					<a href="javascript:void(0);" onclick='open_dialog_item(<?php echo $item['AS_ID']; ?>);'>
						<?php echo $item['AS_NAME']; ?>
					</a>
				</td>
				<td style="padding-right:5px;" align="right"><?php echo number_format($item['AS_NP'],2,'.',','); ?></td>
				<td align="center"><?php echo date('d.m.Y', strtotime($item['AS_INDATE'])); ?></td>
				<td align="center"><?php echo number_format($item['AS_USE'],1,'.',','); ?></td>
				<td align="center"><?php echo intval($item['AS_USE']*12); ?></td>
				<td style="padding-left:5px;"><?php echo $item['DIV_DESC']; ?></td>
			</tr>
			<?php
			if($class == "class='row1'") $class="class='row2'";
			else $class="class='row1'";
		}
		?>
	</table>
	</div>
	
	<div id="hiddenresult" style="display:none;">
  <?php
		if($pg > 1) {
			for ($pg_no = 1; $pg_no <= $pg; $pg_no++){
				?>
				<div class="result">
					<table width="100%" bgcolor="#D8DFEA" align="center" cellpadding="2" cellspacing="1" border="0">
						<tr bgcolor="#DDDDDD">
							<td style="padding-left:5px;" width="100" rowspan=2><b>Kode</b></td>
							<td style="padding-left:5px;" rowspan=2><b>Nama</b></td>
							<td align="center" width="100" rowspan=2><b>Nilai Perolehan</b></td>
							<td align="center" width="80" rowspan=2><b>Tanggal Perolehan</b></td>
							<td align="center" width="100" colspan=2><b>Masa</b></td>
							<td align="center" width="100" rowspan=2><b>Divisi</b></td>
						</tr>
						<tr bgcolor="#EEEEEE" align="center">
							<td style="padding-left:5px;" width="50"><b>Tahun</b></td>
							<td style="padding-left:5px;" width="50"><b>Bulan</b></td>
						</tr>
						<?php	
						$class="class='row1'";
						foreach($item_list[$pg_no] as $line=>$item){
						?>
							<tr <?php echo $class; ?>>
								<td style="padding-left:5px;"><?php echo $item['AS_CODE']; ?></td>
								<td style="padding-left:5px;">
									<a href="javascript:void(0);" onclick='open_dialog_item(<?php echo $item['AS_ID']; ?>);'>
										<?php echo $item['AS_NAME']; ?>
									</a>
								</td>
								<td style="padding-right:5px;" align="right"><?php echo number_format($item['AS_NP'],2,'.',','); ?></td>
								<td align="center"><?php echo date('d.m.Y', strtotime($item['AS_INDATE'])); ?></td>
								<td align="center"><?php echo number_format($item['AS_USE'],1,'.',','); ?></td>
								<td align="center"><?php echo intval($item['AS_USE']*12); ?></td>
								<td style="padding-left:5px;"><?php echo $item['DIV_DESC']; ?></td>
							</tr>
							<?php
							if($class == "class='row1'") $class="class='row2'";
							else $class="class='row1'";
						}
						?>
					</table>
					
					
				</div>
			<?php
			}
		}
		?>
</div>
<?php
}
?>

<div id="dialog-item-detail" title="Detail Asset">
	
</div>
<div id="dialog-edit-detail" title="Edit Asset">
	
</div>
<script src="<?php echo base_url();?>asset/js/jquery.pagination.js" type="text/javascript"></script>
	<script type="text/javascript">
						// This is a demo that shows 
            // a) how to have pagination for the same content multiple times
            // b) two independent pagination elements
            
            // The elements that will be displayed are in a hidden DIV and are
            // cloned for display. The elements are static, there are no Ajax 
            // calls involved.
            // The elements for the second example are not cloned. Instead, the
            // elements are hidden and the current element is shown.
        
            /**
             * Callback function that displays the content.
             *
             * Gets called every time the user clicks on a pagination link.
             *
             * @param {int} page_index New Page index
             * @param {jQuery} jq the container with the pagination links as a jQuery object
             */
            function searchPageselectCallback(page_index, jq){
                var new_content = $('#hiddenresult div.result:eq('+page_index+')').clone();
                $('#Searchresult').empty().append(new_content);
                return false;
            }
            
            /**
             * Callback function for the image container
             */
            function imagePageselectCallback(page_index, jq) {
                 $('#ImageContainer img:visible').hide();
                 $('#ImageContainer img:eq(' + page_index + ')').show(); 
                
            }
           
            /** 
             * Initialisation function for pagination
             */
            function initPagination() {
                // count entries inside the hidden content
                var num_entries = $('#hiddenresult div.result').length;
                // Create content inside pagination element
                $(".searchresult_pagination").pagination(num_entries, {
                    callback: searchPageselectCallback,
                    items_per_page:1 // Show only one item per page
                });
                // Create pagination for images
                num_entries = $('#ImageContainer img').length;
                $("#ImagePagination").pagination(num_entries, {
                    callback: imagePageselectCallback,
                    items_per_page:1 // Show only one item per page
                });
             }
            
            // When document is ready, initialize pagination
            $(document).ready(function(){      
                initPagination();
            });
	</script>