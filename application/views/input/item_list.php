<?php
if(isset($item_list))
{ ?>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#form_delete_item').submit(function() {
					
					var image_load = "<div class='ajax_loading'><img src='"+loading_image_large+"' /></div>";
					
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
		
		
	});
	
	function confirm_delete_item(itmid,itmcd,itmname)
  {
  	$( "#delete_itemid" ).text(itmcd);
  	$( "#delete_itemname" ).text(itmname);
  	document.form_delete_item.del_item_id.value=itmid;
  	$( "#dialog-delete-item" ).dialog("open");
  	//load('view/view_detail/' + itm,'#dialog-item-detail');
  }
	</script>
	<?php echo form_open_multipart('input/delete_item', array('name'=>'form_delete_item','id'=>'form_delete_item'));?>
		<input type="hidden" name="del_item_id" id="del_item_id" value="0" />
		<input type="hidden" name="group" value="<?php if(isset($group)) echo $group; ?>" />
	<?php echo form_close(); ?>
	<?php if($pg > 1) { ?>
		<div class="searchresult_pagination"></div>
	<?php } ?>
	<div id="Searchresult">
		<table width="98%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="1" border="0">
			<tr bgcolor="#DDDDDD" align="center">
				<td width="53"></td>
				<td style="padding-left:5px;" width="100"><b>Kode</b></td>
				<td style="padding-left:5px;"><b>Nama</b></td>
				<td style="padding-left:5px;" width="100"><b>Nilai Perolehan</b></td>
				<td style="padding-left:5px;" width="60"><b>Masa <br>(tahun)</b></td>
				<td style="padding-left:5px;" width="150"><b>Divisi</b></td>
			</tr>
			<?php
			$class="class='row1'";
			foreach($item_list[1] as $line=>$item){
				?>
				<tr <?php echo $class; ?>>
					<td align="center">
						<a title="View item" href="javascript:void(0);" onclick='open_dialog_item(<?php echo $item['AS_ID']; ?>);'> 
							<span class="ui-icon ui-icon-search" style="float:left; margin:0 0 0 0;"> 
						</a>
						<a title="Edit item" href="javascript:void(0);" onclick='open_edit_item(<?php echo $item['AS_ID']; ?>);'> 
							<span class="ui-icon ui-icon-pencil" style="float:left; margin:0 0 0 0;"> 
						</a>
						<a title="Delete item" href="javascript:void(0);" onclick='confirm_delete_item("<?php echo $item['AS_ID']; ?>","<?php echo $item['AS_CODE']; ?>","<?php echo $item['AS_NAME']; ?>");'> 
							<span class="ui-icon ui-icon-trash" style="float:left; margin:0 0 0 0;"> 
						</a>
						
					</td>					
					<td style="padding-left:5px;"><?php echo $item['AS_CODE']; ?></td>
					<td style="padding-left:5px;">
						<a title="View item" href="javascript:void(0);" onclick='open_dialog_item(<?php echo $item['AS_ID']; ?>);'>
							<?php echo $item['AS_NAME']; ?>
						</a>
					</td>
					<td style="padding-right:5px;" align="right"><?php echo number_format($item['AS_NP'],2,'.',','); ?></td>
					<td style="padding-right:5px;" align="right"><?php echo number_format($item['AS_USE'],1,'.',','); ?></td>
					<td style="padding-left:5px;"><?php echo $item['DIV_DESC']; ?></td>
				</tr>
				<?php
				if($class == "class='row1'") $class="class='row2'";
				else $class="class='row1'";
			} ?>
		</table>
	</div>
	
	<div id="hiddenresult" style="display:none;">
  <?php
		if($pg > 1) {
			for ($pg_no = 1; $pg_no <= $pg; $pg_no++){
				?>
				<div class="result">
					<table width="98%" bgcolor="#DDDDDD" align="center" cellpadding="2" cellspacing="1" border="0">
						<tr bgcolor="#DDDDDD" align="center">
							<td width="53"></td>
							<td style="padding-left:5px;" width="100"><b>Kode</b></td>
							<td style="padding-left:5px;"><b>Nama</b></td>
							<td style="padding-left:5px;" width="100"><b>Nilai Perolehan</b></td>
							<td style="padding-left:5px;" width="60"><b>Masa <br>(tahun)</b></td>
							<td style="padding-left:5px;" width="150"><b>Divisi</b></td>
						</tr>
						<?php
						$class="class='row1'";
						foreach($item_list[$pg_no] as $line=>$item){
							?>
							<tr <?php echo $class; ?>>
								<td align="center">
									<a title="View item" href="javascript:void(0);" onclick='open_dialog_item(<?php echo $item['AS_ID']; ?>);'> 
										<span class="ui-icon ui-icon-search" style="float:left; margin:0 0 0 0;"> 
									</a>
									<a title="Edit item" href="javascript:void(0);" onclick='open_edit_item(<?php echo $item['AS_ID']; ?>);'> 
										<span class="ui-icon ui-icon-pencil" style="float:left; margin:0 0 0 0;"> 
									</a>
									<a title="Delete item" href="javascript:void(0);" onclick='confirm_delete_item("<?php echo $item['AS_ID']; ?>","<?php echo $item['AS_CODE']; ?>","<?php echo $item['AS_NAME']; ?>");'> 
										<span class="ui-icon ui-icon-trash" style="float:left; margin:0 0 0 0;"> 
									</a>
								</td>		
								<td style="padding-left:5px;"><?php echo $item['AS_CODE']; ?></td>
								<td style="padding-left:5px;">
									<a title="View item" href="javascript:void(0);" onclick='open_dialog_item(<?php echo $item['AS_ID']; ?>);'>
										<?php echo $item['AS_NAME']; ?>
									</a>
								</td>
								<td style="padding-right:5px;" align="right"><?php echo number_format($item['AS_NP'],2,'.',','); ?></td>
								<td style="padding-right:5px;" align="right"><?php echo number_format($item['AS_USE'],1,'.',','); ?></td>
								<td style="padding-left:5px;"><?php echo $item['DIV_DESC']; ?></td>
							</tr>
							<?php
							if($class == "class='row1'") $class="class='row2'";
							else $class="class='row1'";
						} ?>
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