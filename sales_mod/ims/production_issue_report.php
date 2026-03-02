<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$pi_no 		= $_REQUEST['v_no'];

$datas=find_all_field('production_issue_master','s','pi_no='.$pi_no);

$sql1="select b.* from production_issue_master b where b.pi_no = '".$pi_no."'";
$data1=db_query($sql1);

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$warehouse_to=$info->warehouse_to;
$warehouse_from=$info->warehouse_from;
$carried_by=$info->carried_by;
$remarks=$info->remarks;
$pi_date=$info->pi_date;
}

$sql1="select b.*,i.unit_name from production_issue_detail b,item_info i where b.item_id=i.item_id and b.pi_no = '".$pi_no."'";
$data1=db_query($sql1);

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;

$qc_by=$info->qc_by;
$item_id[] = $info->item_id;
$unit_name[] = $info->unit_name;
$total_unit[] = $info->total_unit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Production Line Issue Report :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">Production Line Issue  Report</td>
      </tr>
    </table></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="top">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
		        <tr>
		          <td width="40%" align="right" valign="middle">Issue To  : </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to);?></td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="top"> Warehouse From:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_from);?></td>
                    </tr>
                  </table></td>
		        </tr>
		        
		        <tr>
		          <td align="right" valign="middle"> Carried By:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $carried_by;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        </table>		      </td>
			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td align="right" valign="middle"> PI No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>&nbsp;<strong><?php echo $pi_no;?></strong></td>
                    </tr>
                </table></td>
				<tr>
				<td align="right" valign="middle">PI Date : </td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>&nbsp;
                        <?=date("d M, Y",strtotime($pi_date))?></td>
                    </tr>
                </table></td>
			    </tr>
				<tr>
				<td align="right" valign="middle">SR No  : </td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>&nbsp;<?php echo $remarks;?></td>
                    </tr>
                </table></td>
			    </tr>
			  
			  
			  </table></td>
		  </tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  
  <tr>
    <td>
      <div id="pr">
  <div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
  </div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
       <tr>
        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>
        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Issue Qty</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){?>
      
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item_id[$i]?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$unit_name[$i]?></td>
        <td align="right" valign="top"><?=$total_unit[$i]?></td>
        </tr>
<? }?>
  </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>
    </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong><br />
      </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center">Received By </div></td>
          <td><div align="center">Quality Controller </div></td>
          <td><div align="center">Store Incharge </div></td>
          </tr>
      </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    </table>
    <div class="footer1"> </div>
    </td>
  </tr>
</table>
</body>
</html>
