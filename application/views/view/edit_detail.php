<?php
if(isset($item))
{ ?>
	<script type="text/javascript">
	$(function() {
		$( "#tgl_perolehan" ).datepicker({dateFormat: 'dd-mm-yy'});
	}
	</script>
	<br>
	<?php echo form_open_multipart('input/edit_item', array('name'=>'edit_item', 'id'=>'edit_item'));?>
	<table width="95%" align="center" cellpadding="2" cellspacing="1" border="0">
		<tr class="row2_dark">
			<td style="padding-left:5px;" width="180">
				<b>Kode</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo $item->AS_CODE; ?>				
			</td>
		</tr>
		<tr class="row1_dark">
			<td style="padding-left:5px;">
				<b>Grup</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo $this->Asset->get_grp_info($item->AS_GRP)->GRP_DESC; ?>
			</td>
		</tr>
		<tr class="row2_dark">
			<td style="padding-left:5px;">
				<b>Nama</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<input type="text" name="itm_name" id="itm_name" value="<?php echo $item->AS_NAME; ?>" size="60" onkeyup="replaceQuote(this);" onchange="replaceQuote(this);" />
			</td>
		</tr>
		<tr class="row2_dark">
			<td style="padding-left:5px;">
				<b>Nilai Perolehan</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<input type="text" name="nl_perolehan" id="nl_perolehan" value="<?php echo number_format($item->AS_NP,2,'.',','); ?>" size="20" onkeyup="formatNumber(this);" onchange="formatNumber(this);"/>
			</td>
		</tr>
		<tr class="row1_dark">
			<td style="padding-left:5px;">
				<b>Tanggal Perolehan</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<input type="text" name="tgl_perolehan" id="tgl_perolehan" size="10" value="<?php if(isset($tgl_perolehan)) echo $tgl_perolehan; else echo date("d-m-Y", strtotime($item->AS_INDATE)); ?>" />
			</td>
		</tr>
		<tr class="row2_dark">
			<td style="padding-left:5px;">
				<b>Masa Penggunaan</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<input type="text" name="masa" id="masa" value="<?php echo number_format($item->AS_USE,1,'.',','); ?>" size="2"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/> tahun
			</td>
		</tr>
		
	</table>
	<?php echo form_close(); ?>
<?php
}
?>