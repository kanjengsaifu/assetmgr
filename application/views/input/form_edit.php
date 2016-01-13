
<!--<?php echo form_open_multipart('input/update_item', array('name'=>'update_item', 'id'=>'update_item'));?>-->
<input type="hidden" name="itm_id" value="<?php echo $item->AS_ID; ?>" />
<input type="hidden" name="group" id="group" value="<?php echo $item->AS_GRP; ?>" />
<table width="700" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="0" border="0">
	<tr bgcolor="#DDDDDD">
		<td align="center" colspan=2><b>Edit Item</b></td>
	</tr>
	<tr class='row2' height="24">
		<td style="padding-left:5px;"><b>Grup</b></td>
		<td style="padding-left:5px;">
			<?php echo $this->Asset->get_grp_info($item->AS_GRP)->GRP_DESC; ?>
		</td>
	</tr>
	<tr class='row1' height="24">
		<td style="padding-left:5px;"><b>Kode Item</b></td>
		<td style="padding-left:5px;">
			<?php echo $item->AS_CODE; ?>
		</td>
	</tr>
	<tr class='row2'>
		<td style="padding-left:5px;"><b>Nama Item</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="itm_name" id="itm_name" value="<?php echo $item->AS_NAME; ?>" size="60" onkeyup="replaceQuote(this);" onchange="replaceQuote(this);" />
		</td>
	</tr>
	<tr class='row1'>
		<td style="padding-left:5px;"><b>Nilai Perolehan</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="nl_perolehan" id="nl_perolehan" value="<?php echo number_format($item->AS_NP,2,'.',','); ?>" size="20" onkeyup="formatNumber(this);" onchange="formatNumber(this);"/>
		</td>
	</tr>
	<tr class='row2'>
		<td style="padding-left:5px;"><b>Tanggal Perolehan</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="tgl_perolehan" id="tgl_perolehan" size="10" value="<?php if(isset($tgl_perolehan)) echo $tgl_perolehan; else echo date("d-m-Y", strtotime($item->AS_INDATE)); ?>" />
		</td>
	</tr>
	<tr class='row1'>
		<td style="padding-left:5px;"><b>Masa Penggunaan</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="masa" id="masa" value="<?php echo number_format($item->AS_USE,1,'.',','); ?>" size="2"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/> tahun
		</td>
	</tr>
	<tr class='row2'>
		<td style="padding-left:5px;"><b>Voucher</b></td>
		<td style="padding-left:5px;">
			<input type="text" name="vcr" id="vcr" value="<?php echo $item->AS_VOUCHER; ?>" size="20" onkeyup="replaceQuote(this);" onchange="replaceQuote(this);" />
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
							foreach($divisi_list as $line=>$div){
							?>
								<option value="<?php echo $div['DIV_ID']; ?>" <?php if($item->AS_DIV==$div['DIV_ID']) echo "selected=\"selected\""; ?> ><?php echo $div['DIV_DESC']; ?></option>
							<?php
							}
						}
						?>
						<!--<option value="new">Tambah divisi......</option>-->
			</select>	
		</td>
	</tr>
	<tr bgcolor="#DDDDDD">
		<td colspan=2>
			<div align="right"><?php echo form_submit('addButton','Simpan'); ?></div>	
		</td>
	</tr>
</table>
<!--<?php echo form_close(); ?>-->