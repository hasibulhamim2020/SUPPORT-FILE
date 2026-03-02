<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Chaque Book Issue';
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
//echo $proj_id;



js_ledger_subledger_autocomplete_new('contra',$proj_id,$voucher_type); ?>
<?php
	

	$led2=db_query("select id, center_name FROM cost_center WHERE 1 ORDER BY center_name ASC LIMIT 50");
	if(mysqli_num_rows($led2) > 0)
	{
		$data2 = '[';
		while($ledg2 = mysqli_fetch_row($led2))
		{
			$data2 .= '{ name: "'.$ledg2[1].'", id: "'.$ledg2[0].'" },';
		}
		$data2 = substr($data2, 0, -1);
		$data2 .= ']';
	}
	else
	{
		$data2 = '[{ name: "empty", id: "" }]';
	}
?>
<script type="text/javascript">

$(document).ready(function(){

    function formatItem(row) {
		//return row[0] + " " + row[1] + " ";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

    var data2 = <?php echo $data2; ?>;
    $("#cc_code").autocomplete(data2, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name; /// + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
  });
  
</script>
<script type="text/javascript">
function DoNav(theUrl)
{
	var URL = 'voucher_view_popup.php?'+theUrl;
	popUp(URL);
}
function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>

<script type="text/javascript" src="../common/js/check_balance.js"></script>

<script type="text/javascript" src="../common/coutra_check.js"></script>

<style type="text/css">
<!--
.style1 {font-size: 18px}
.style2 {font-size: 10px}
div.ui-datepicker {font-size: 62.5%;}
-->
</style>

<script language="javascript" type="text/javascript">

function voucher_no(val)
	{
		var voucher_mode = val;
		
		if( voucher_mode == 0 )
		{
			document.getElementById('coutra_no').value		= "";
			document.getElementById('coutra_no').readOnly	= false;
			document.getElementById('coutra_no').select();
			document.getElementById('coutra_no').focus();
		}
		else if( voucher_mode == 1 )
		{
			document.getElementById('coutra_no').value		= "<?php echo $coutra_no;?>";
			document.getElementById('coutra_no').readOnly	= true;
		}
	}

function goto_tab()
{
	//alert('tab mamaun');
	document.getElementById('type').focus();
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 18px}
.style2 {font-size: 10px}
-->
</style>



      <form id="form1" name="form1" method="post" action="coutra_note_new.php<?php if($_GET['action']=='edit') echo "?action=EDITING&v_no=".$_GET['v_no']."&v_type=".$_GET['v_type'];?>" onsubmit="return checking()">
        <table width="80%" border="2"  align="left" style="border:1px solid #C1DAD7; border-collapse:collapse">
          <tr>
            <td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                      
                      <tr>
                        <td><div align="right">Account Ledger:</div></td>
                        <td><input name="c_id" type="text" id="c_id" value="" class="input1" tabindex="4"/></td>
                      </tr>
                      <tr>
                        <td><div align="right"><span>Bank:</span></div></td>
                        <td><input name="c_date" type="text" id="c_date" value="" tabindex="5"/></td>
                      </tr>
                      <tr>
                        <td><div align="right">Chaque Book Leaf:</div></td>
                        <td><input name="c_no" type="text" id="c_no" value="" tabindex="6"/></td>
                      </tr>
                      <tr>
                        <td><div align="right">Issue Date :</div></td>
                        <td><input name="c_no" type="text" id="c_no" value="" tabindex="6"/></td>
                      </tr>

                    </table></td>
				  </tr>
			  </table>			</td>
          </tr>
          <tr>
            <td valign="top"><span id="tbl"></span> <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">
                <tr>
                  <td align="right"><label>
                    <div align="center">
                      <input name="coutra_varify" type="submit" id="coutra_varify" class="btn" value="Contra Varified" />
                      </div>
                  </label></td>
                  </tr>
            </table></td>
          </tr>
        </table>
        <input name="count" id="count" type="hidden" value="" />
      </form>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>