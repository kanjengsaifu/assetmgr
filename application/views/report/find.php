<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
	$(document).ready(function() {

		$('#find_report').submit(function() {
					
					var image_load = "<div class='ajax_loading_small'><img src='"+loading_image_large+"' /></div>";
					
					$.ajax({
						type: 'POST',
						url: $(this).attr('action'),
						data: $(this).serialize(),
						beforeSend: function(){
            	$('#list_report').html(image_load);
        		},
						success: function(data) {
							$('#list_report').html(data);
						}
					})
					return false;
		});
		
	})
	
	$(function() {
		$( "#tgl" ).datepicker({dateFormat: 'dd-mm-yy'});
	});

</script>	
<div class='title'>
	<?php echo $this->lang->line("module_".$this->uri->segment(1)."_desc");?>
</div>	
<?php echo form_open_multipart('report/find_report', array('name'=>'find_report', 'id'=>'find_report'));?>
<div class='div_round_xwidth'>
			<b>Tanggal</b> &nbsp;&nbsp;
			<input type="text" name="tgl" id="tgl" size="10" value="<?php if(isset($tgl)) echo $tgl; else echo date("d-m-Y"); ?>" /> &nbsp;&nbsp;
			<b>Grup</b> &nbsp;&nbsp;
			<select name="group" id="group" onchange='rp_group_action(this)'>
						<option value="0">Seluruhnya..........</option>
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
			</select> &nbsp;&nbsp;
			<?php echo form_submit('addButton','Tampilkan'); ?>
</div>
<?php echo form_close(); ?>
<div id='list_report' style="margin-top:10px;margin-left:6px;margin-bottom:15px;width:972px;">
	<div class='div_round_100p'>
		<center>Silahkan pilih grup.....</center>
	</div>
</div>
