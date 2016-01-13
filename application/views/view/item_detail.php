<?php
if(isset($item))
{ ?>
	<br>
	<table width="95%" align="center" cellpadding="2" cellspacing="1" border="0">
		<tr class="row1_dark">
			<td style="padding-left:5px;" width="180">
				<b>Kode</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo $item->AS_CODE; ?>
			</td>
		</tr>
		<tr class="row2_dark">
			<td style="padding-left:5px;">
				<b>Nama</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo $item->AS_NAME; ?>
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
				<b>Nilai Perolehan</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo number_format($item->AS_NP,2,'.',','); ?>
			</td>
		</tr>
		<tr class="row1_dark">
			<td style="padding-left:5px;">
				<b>Tanggal Perolehan</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo date('d M Y', strtotime($item->AS_INDATE)); ?>
			</td>
		</tr>
		<tr class="row2_dark">
			<td style="padding-left:5px;">
				<b>Masa Penggunaan</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo number_format($item->AS_USE,1,'.',','); ?> tahun (<?php echo intval(12*$item->AS_USE); ?> bulan)
			</td>
		</tr>
		<tr class="row1_dark">
			<td style="padding-left:5px;">
				<b>Penyusutan per bulan</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo number_format($item->AS_PPB,2,'.',','); ?>
			</td>
		</tr>
		<tr class="row2_dark">
			<td style="padding-left:5px;">
				<b>Tarif per tahun</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo number_format($item->AS_TPT,1,'.',','); ?> %
			</td>
		</tr>
		<tr class="row1_dark">
			<td style="padding-left:5px;">
				<b>Total yang sudah disusutkan</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php 
					//$dt_diff = date('m/d/Y', strtotime($item->AS_INDATE));
					$dt_diff = date('m/01/Y', strtotime($item->AS_INDATE));
					//$bln_sst = round(($this->Asset->dateDiff("/", date("m/d/Y", time()), $dt_diff)/365)*12, 0);
					$bln_sst = round(($this->Asset->dateDiff("/", date("m/01/Y", time()), $dt_diff)/365)*12, 0);
					if ($bln_sst >= (12*$item->AS_USE)) $bln_sst=12*$item->AS_USE;
					$jml_sst = $bln_sst*$item->AS_PPB;
					echo number_format($jml_sst,2,'.',',')." (".$bln_sst." bulan)";
				?>
			</td>
		</tr>
		<tr class="row2_dark">
			<td style="padding-left:5px;">
				<b>Book Value (Sisa)</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php 
					$bln_sisa = intval(12*$item->AS_USE) - $bln_sst;
					$jml_sisa = $bln_sisa*$item->AS_PPB;
					echo number_format($jml_sisa,2,'.',',')." (".$bln_sisa." bulan)";
				?>
			</td>
		</tr>
		<tr class="row1_dark">
			<td style="padding-left:5px;">
				<b>Voucher</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo $item->AS_VOUCHER; ?>
			</td>
		</tr>
		<tr class="row2_dark">
			<td style="padding-left:5px;">
				<b>Divisi</b>
			</td>
			<td style="padding-left:5px;color:#FF8000;">
				<?php echo $this->Asset->get_div_info($item->AS_DIV)->DIV_DESC; ?>
				else echo "-";
				?>
			</td>
		</tr>
	</table>
<?php
}
?>