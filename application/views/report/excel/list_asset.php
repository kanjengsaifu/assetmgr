<?php
$namaFile = "daftar_asset_".date('d-m-Y', strtotime($tgl)).".xls";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$namaFile");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table width="100%">
	<tr>
		<td colspan="2">
			<b>PT. GLOBAL BANGUNAN JAYA</b>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<b>JLN. TUANKU TAMBUSAI NO.299</b>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<b>PEKANBARU</b>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<b>DAFTAR FIXED ASSET</b>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<b>TANGGAL <?php echo date('d F Y', strtotime($tgl)); ?></b>
		</td>
	</tr>
</table>
<table width="1324" bgcolor="#CCCCCC" align="center" cellpadding="2" cellspacing="1" border="1">
	<tr bgcolor="#EEEEEE">
		<td align="center" width="100" colspan=11><b>Keterangan Aktiva</b></td>
		<td align="center" bgcolor="#DDDDDD" width="100" rowspan=2 colspan=2><b>Total yg sudah disusutkan</b></td>
		<td align="center" bgcolor="#DDDDDD" width="90" rowspan=2 colspan=2><b>Book Value (Sisa)</b></td>
	</tr>
	<tr bgcolor="#DDDDDD">
		<td align="center" width="30" rowspan=2><b>No</b></td>
		<td style="padding-left:5px;" rowspan=2><b>Nama</b></td>
		<td align="center" width="100" rowspan=2><b>Kode</b></td>
		<td align="center" width="100" rowspan=2><b>Divisi</b></td>
		<td align="center" width="100" rowspan=2><b>Voucher</b></td>
		<td align="center" width="100" rowspan=2><b>Nilai Perolehan</b></td>
		<td align="center" width="80" rowspan=2><b>Tanggal Perolehan</b></td>
		<td align="center" width="100" colspan=2><b>Masa</b></td>
		<td align="center" width="100" rowspan=2><b>Penyusutan perbulan</b></td>
		<td align="center" width="90" rowspan=2><b>Tarif <br>pertahun ( % )</b></td>
	</tr>
	<tr bgcolor="#EEEEEE" align="center">
		<td align="center" width="50"><b>Tahun</b></td>
		<td align="center" width="50"><b>Bulan</b></td>
		<td align="center" width="50"><b>Bulan</b></td>
		<td align="center" width="50"><b>Penyusutan</b></td>
		<td align="center" width="50"><b>Bulan</b></td>
		<td align="center" width="50"><b>Penyusutan</b></td>
	</tr>
	<?php
	$i=0;
	$grp_na="";
	$masa_na="";
	$jml_np=0;
	$jml_pny=0;
	$jml_sisa_pny=0;
	$tot_np=0;
	$tot_pny=0;
	$tot_sisa_pny=0;
	foreach($item_list as $line=>$item){
		$i++;
		if($grp_na <> $item['AS_GRP'])
		{			
			if($jml_np<>0){
				?>
				<tr bgcolor="#BBBBBB">
					<td></td>
					<td align="center"><b>TOTAL <?php echo $this->Asset->get_grp_info($grp_na)->GRP_DESC; ?></b></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="padding-right:5px;" align="right"><b><?php echo number_format($jml_np,2,'.',','); ?></b></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="padding-right:5px;" align="right"><b><?php echo number_format($jml_pny,2,'.',','); ?></b></td>
					<td></td>
					<td style="padding-right:5px;" align="right"><b><?php echo number_format($tot_sisa_pny,2,'.',','); ?></b></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td>&nbsp;</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
					
				<?php
				$jml_np=0;
				$jml_pny=0;
				$jml_sisa_pny=0;
			}
				$grp_na = $item['AS_GRP'];
				?>
				
				<tr bgcolor="#FFFFFF">
					<td></td>
					<td align="center" bgcolor="#EEEEEE"><b><?php echo $this->Asset->get_grp_info($item['AS_GRP'])->GRP_DESC; ?></b></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				
				<?php
			}
			if($masa_na <> $item['AS_USE'])
			{
				$masa_na = $item['AS_USE'];
				?>
				
				<tr bgcolor="#FFFFFF">
					<td></td>
					<td align="center" bgcolor="#EEEEEE"><b><?php echo $item['AS_GRP']; ?> (<?php echo number_format($item['AS_USE'],1,'.',','); ?> tahun)</b></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				
				<?php
			}
			?>
			<tr bgcolor="#FFFFFF">
				<td style="padding-right:5px;" align="right"><?php echo $i; ?></td>
				<td style="padding-left:5px;"><?php echo $item['AS_NAME']; ?></td>
				<td style="padding-left:5px;"><?php echo $item['AS_CODE']; ?></td>
				<td style="padding-left:5px;"><?php echo $item['DIV_DESC']; ?></td>
				<td style="padding-left:5px;"><?php echo $item['AS_VOUCHER']; ?></td>
				<td style="padding-right:5px;" align="right"><?php 
					echo number_format($item['AS_NP'],2,'.',','); 
					$jml_np=$jml_np+$item['AS_NP'];
					$tot_np=$tot_np+$item['AS_NP'];
				?></td>
				<td align="center"><?php echo date('d.m.Y', strtotime($item['AS_INDATE'])); ?></td>
				<td align="center"><?php echo number_format($item['AS_USE'],1,'.',','); ?></td>
				<td align="center"><?php echo intval($item['AS_USE']*12); ?></td>
				<td style="padding-right:5px;" align="right"><?php echo number_format($item['AS_PPB'],2,'.',','); ?></td>
				<td align="center"><?php echo number_format($item['AS_TPT'],1,'.',','); ?></td>
				<td align="center"><?php 
					$dt_diff = date('m/01/Y', strtotime($item['AS_INDATE']));
					//$bln_sst = round(($this->Asset->dateDiff("/", date("m/d/Y", time()), $dt_diff)/365)*12, 0);
					$bln_sst = round(($this->Asset->dateDiff("/", date("m/01/Y", strtotime($tgl)), $dt_diff)/365)*12, 0);
					if ($bln_sst >= (12*$item['AS_USE'])) $bln_sst=12*$item['AS_USE'];
					echo $bln_sst; 
				?></td>
				<td style="padding-right:5px;" align="right"><?php 
					$jml_sst = $bln_sst*$item['AS_PPB'];
					echo number_format($jml_sst,2,'.',','); 
					$jml_pny=$jml_pny+$jml_sst;
					$tot_pny=$tot_pny+$jml_sst;
				?></td>
				<td align="center"><?php 
					$bln_sisa = intval(12*$item['AS_USE']) - $bln_sst;
					echo $bln_sisa; 
				?></td>
				<td style="padding-right:5px;" align="right"><?php 
					$jml_sisa = $bln_sisa*$item['AS_PPB'];
					echo number_format($jml_sisa,2,'.',',');
					$jml_sisa_pny=$jml_sisa_pny+$jml_sisa;
					$tot_sisa_pny=$tot_sisa_pny+$jml_sisa;
				?></td>
			</tr>
		<?php
		}
		?>
		<tr bgcolor="#BBBBBB">
			<td></td>
			<td align="center"><b>TOTAL <?php echo $this->Asset->get_grp_info($item['AS_GRP'])->GRP_DESC; ?></b></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="padding-right:5px;" align="right"><b><?php echo number_format($jml_np,2,'.',','); ?></b></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="padding-right:5px;" align="right"><b><?php echo number_format($jml_pny,2,'.',','); ?></b></td>
			<td></td>
			<td style="padding-right:5px;" align="right"><b><?php echo number_format($jml_sisa_pny,2,'.',','); ?></b></td>
		</tr>
		<tr bgcolor="#AAAAAA">
			<td></td>
			<td align="center"><b>GRAND TOTAL</b></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="padding-right:5px;" align="right"><b><?php echo number_format($tot_np,2,'.',','); ?></b></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="padding-right:5px;" align="right"><b><?php echo number_format($tot_pny,2,'.',','); ?></b></td>
			<td></td>
			<td style="padding-right:5px;" align="right"><b><?php echo number_format($tot_sisa_pny,2,'.',','); ?></b></td>
		</tr>
	</table>

