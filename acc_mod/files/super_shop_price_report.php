<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Super Shop Price Report';
$proj_id=$_SESSION['proj_id'];

auto_complete_from_db('dealer_info','dealer_name_e','dealer_code','dealer_type="SuperShop" and canceled="Yes"','dealer');
?>
<script type="text/javascript">

$(document).ready(function(){

    function formatItem(row) {
		//return row[0] + " " + row[1] + " ";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

    var data = <?php echo $data; ?>;
    $("#ledger_id").autocomplete(data, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
	
	var data = <?php echo $data1; ?>;
    $("#cc_code").autocomplete(data, {
		matchContains: true,
		minChars: 0,        
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name + " : [" + row.id + "]";
		},
		formatResult: function(row) {            
			return row.id;
		}
	});	

  });

</script>
<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("#fdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	});
		$(function() {
		$("#tdate").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	});

});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report">
								      <form action="../../sales_mod/pages/ido/master_report.php?report=1" method="get" name="codz" id="codz" target="_blank">
                                        <table width="80%" border="0" align="center">
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td align="right" bgcolor="#FF9966"><strong>Corporate Dealer: </strong></td>
                                            <td bgcolor="#FF9966"><strong>
                                              <input name="dealer" type="text" id="dealer" value="<?=$_POST['dealer']?>" />
                                            </strong></td>
                                            <td bgcolor="#FF9966"><strong>
                                              <input type="submit" name="submitit" id="submitit" value="Show Price" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
                                              <input type="hidden" name="report" value="1" />
                                            </strong></td>
                                          </tr>
                                        </table>
								        <br />
								        <br />
                                        <p>&nbsp;</p>
							          </form>
								    </div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td>									</td>
								  </tr>
		</table>

							</div></td>
</tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>