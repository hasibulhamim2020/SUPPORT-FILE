<div class="print_box">
						
<table class="mt-5" border="0" cellspacing="0" cellpadding="0" align="left">
<tr>
<td>
<form class="m-0 pl-1 pr-1" action="SaveToExcel.php" method="post" name="form_excel" target="_blank" id="form_excel" onsubmit='$("#datatodisplay").val( $("<div>").append( $("#grp").eq(0).clone() ).html() )'>
<input  type="image" src="../../../../public/assets/images/xls_hover.png" width="40" height="40">
<input type="hidden" id="datatodisplay" name="datatodisplay" />
<input type="hidden" id="page_title" name="page_title" value="<?=$title?>" />
</form>

</td>
																				

<?php /*?><td >
<form class="m-0 pl-1 pr-1" action="ShowForPDF.php" method="post"  name="form_pdf" target="_blank" id="form_pdf" onsubmit='$("#datatodisplay2").val( $("<div>").append( $("#grp").eq(0).clone() ).html() )'>
<input  type="image" src="../../../../public/assets/images/pdf.png" width="40" height="40">
<input type="hidden" id="datatodisplay2" name="datatodisplay2" />
<input type="hidden" id="page_title" name="page_title" value="<?=$title?>" />
<input type="hidden" id="report_detail" name="report_detail" value="<?=$report_detail?>" />
</form>
</td><?php */?>

<td>
<form class="m-0 pl-1 pr-1" action="ShowForPrint_mamun.php" method="post" name="form_print" target="_blank" id="form_print" onsubmit='$("#datatodisplay1").val( $("<div>").append( $("#grp").eq(0).clone() ).html() )'>
<input  type="image" src="../../../../public/assets/images/print.png" width="40" height="40">
<input type="hidden" id="datatodisplay1" name="datatodisplay1" />
<input type="hidden" id="page_title" name="page_title" value="<?=$title?>" />
<input type="hidden" id="report_detail" name="report_detail" value="<?=$report_detail?>" />
</form>
</td>


</tr>
</table>
</div>