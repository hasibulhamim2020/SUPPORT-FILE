<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require "../../support/inc.all.php";

$address=find_a_field('project_info','proj_address',"1");

$issue_no 		= $_REQUEST['v_no'];

$j_date = $_REQUEST['p_date'];

if($j_date!=""){

$ji_date_con.=" and b.ji_date=".$j_date;
}



$datas=find_all_field('black_tea_consumption','s','issue_no='.$issue_no);



$sql1="select b.* from black_tea_consumption b where b.issue_no = '".$issue_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$se_id=$info->se_id;

$warehouse_id=$info->warehouse_id;

$carried_by=$info->carried_by;

$remarks=$info->remarks;

$issue_date=$info->issue_date;

$entry_by=$info->entry_by;
}



$sql1="select b.*,i.unit_name, i.finish_goods_code from black_tea_consumption b,item_info i where b.item_id=i.item_id and b.issue_no = '".$issue_no."'";


 $sql2="select b.item_id, i.item_name, sum(b.item_in-b.item_ex) as fg_stock, i.unit_name, i.finish_goods_code from journal_item b,item_info i, item_sub_group s, warehouse w where i.sub_group_id=s.sub_group_id and  w.warehouse_id=b.warehouse_id and b.item_id=i.item_id and b.warehouse_id='5' and i.sub_group_id='1096000900010000' and b.ji_date BETWEEN '2010-12-31' and '".$issue_date."' group by b.item_id";
"'";

 $sql3="select b.item_id, i.item_name as raw_item, sum(b.item_in-b.item_ex) as raw_stock, i.unit_name, i.finish_goods_code from journal_item b,item_info i, item_sub_group s, warehouse w where i.sub_group_id=s.sub_group_id and  w.warehouse_id=b.warehouse_id and b.item_id=i.item_id and b.warehouse_id='5' and i.sub_group_id='1096000300010000' and b.ji_date BETWEEN '2010-12-31' and '".$issue_date."' group by b.item_id";
"'";


$data1=db_query($sql1);

$data2=db_query($sql2);

$data3=db_query($sql3);



$pi=0;

$total=0;


while($info3=mysqli_fetch_object($data3)){ 

$ri++;

$fg_code[] = $info3->finish_goods_code;

$item_id_raw[] = $info3->item_id;

$item_name_raw[] = $info3->raw_item;

$unit_name_raw[] = $info3->unit_name;

$raw_stock[] = $info3->raw_stock;

$tot_raw_stock += $info3->raw_stock;
}



while($info2=mysqli_fetch_object($data2)){ 

$fi++;

$fg_code[] = $info2->finish_goods_code;

$item_id_fg[] = $info2->item_id;

$item_name[] = $info2->item_name;

$unit_name_fg[] = $info2->unit_name;

$fg_stock[] = $info2->fg_stock;

$tot_fg_stock += $info2->fg_stock;
}



while($info=mysqli_fetch_object($data1)){ 

$pi++;


$qc_by=$info->qc_by;

$item_id[] = $info->item_id;

$unit_name[] = $info->unit_name;

$finish_goods_code[] = $info->finish_goods_code;

$today_open[] = $info->today_open;

$tot_today_open +=$info->today_open;

$today_receive[] = $info->today_receive;

$tot_today_receive += $info->today_receive;

$today_issue[] = $info->today_issue;

$tot_today_issue += $info->today_issue;

$today_close[] = $info->today_close;

$tot_today_close += $info->today_close;

$total_unit[] = $info->total_unit;

$item_rate[] = $info->item_rate;

$today_sale_amt[] = $info->today_sale_amt;

$total_today_sale_amt +=$info->today_sale_amt;
$issue_date = $info->issue_date;
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Daily Stock Position Report :.</title>

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
.style2 {font-weight: bold}
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

        <td bgcolor="#CCCCCC" style="text-align:center; color:#000; font-size:20px; font-weight:bold;"> <strong style="font-size:22px"><?

if($_SESSION['user']['group']>1)

echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);

else

echo $_SESSION['proj_name'];

				?>. Pkg. Div.<br /></strong> <!--<br /><strong><?=$address?></strong> --></td>
      </tr>

      <tr>

        <td bgcolor="#CCCCCC" style="text-align:center; color:#000; font-size:15px; font-weight:bold;">Khan Tea Estate, Chiknagool, Sylhet </td>
      </tr>
      
      <tr>

        <td bgcolor="#CCCCCC" style="text-align:center; color:#000; font-size:16px; font-weight:bold;">Daily Stock Report </td>
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

		    <td valign="top">&nbsp;</td>

			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			  <tr>
				<tr>

				<td align="right" valign="middle">  Date : </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;

                        <span class="style2">
                        <?=date("d M, Y",strtotime($issue_date))?>
                        </span></td>
                    </tr>

                </table></td>
			    </tr>

				<!--<tr>

				<td align="right" valign="middle">Note  : </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;<?php echo $remarks;?></td>

                    </tr>

                </table></td>

			    </tr>-->

			  

			  

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
    <td>	</td>
  </tr>
  <tr>
    <td>To<br />
	The Managing Director<br />
	M. Ahmed Tea &amp; Lands Co. Ltd. Pkg. Div. <br />
	Dargamohalla, Sylhet.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Dear Sir <br />
    Givens Below are the Particulars of present stock & necessary others on &nbsp;<b><?=date("d M, Y",strtotime($issue_date))?></b>&nbsp; for your kind information.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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

        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Black Tea </strong></div></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Stock</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Packet Tea </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Stock</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>
       </tr>

       

<? for($i=0;$i<$ri;$i++){?>

      

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id_raw[$i]);?></td>

        <td align="left" valign="top"><?=number_format($raw_stock[$i],2);?></td>
        <td align="left" valign="top"><?=$unit_name_raw[$i]?></td>
        <td align="left" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item_name[$i]?></td>
        <td align="left" valign="top"><?=number_format($fg_stock[$i],2);?></td>
        <td align="left" valign="top"><?=$unit_name_fg[$i]?></td>
      </tr>
		
		<? }?>
      <tr>
        <td colspan="2" align="center" valign="top"><div align="right"><strong>Total</strong></div></td>
        <td align="right" valign="top"><span class="style1">
          <?=number_format($tot_raw_stock,2)?>
        </span></td>
        <td align="left" valign="top"><strong>KG</strong></td>
        <td align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top"><div align="right"><strong>Total</strong></div></td>
        <td align="right" valign="top"><span class="style1">
          <?=number_format($tot_fg_stock,2)?>
        </span></td>
        <td align="left" valign="top"><strong>KG</strong></td>
      </tr>
  </table></td>
  </tr>

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="3" style="font-size:12px">&nbsp;</td>
    </tr>

  <tr>

    <td width="38%">&nbsp;</td>

    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>

    <td>&nbsp;</td>

    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>

    <td>&nbsp;</td>

    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>

    <td colspan="3" align="center"><strong><br />

      </strong>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
          <td><div align="center"><?php /*?><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?><?php */?>  <hr style="width:60%;" /></div></td>
          
          <td>&nbsp;</td>
          <td width="39%"><div align="center"><?php /*?><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?><?php */?>  <hr style="width:60%;" /></div></td>
        </tr>
        <tr>

          <td width="38%"><div align="center">Supervisor</div></td>

          

          <td width="23%">&nbsp;</td>
          <td><div align="center">Assistant Manager </div></td>
          </tr>
      </table></td>
    </tr>

  <tr>

    <td><div align="center">M. Ahmed Tea &amp; Lands Co. Ltd. Pkg. Div.</div></td>
 <td width="23%">&nbsp;</td>
    <td width="39%"><div align="center">M. Ahmed Tea &amp; Lands Co. Ltd. Pkg. Div.</div></td>
  </tr>
    </table>

    <div class="footer1"> </div>    </td>
  </tr>
</table>

</body>

</html>

