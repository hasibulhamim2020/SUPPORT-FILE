<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$address=find_a_field('project_info','proj_address',"1");

$collection_no 		= $_REQUEST['v_no'];



$datas=find_all_field('collection_from_customer','s','collection_no='.$collection_no);



$sql1="select b.* from collection_from_customer b where b.collection_no = '".$collection_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 


$warehouse_id=$info->warehouse_id;

$carried_by=$info->carried_by;


$collection_date=$info->collection_date;

$entry_by=$info->entry_by;
}



 $sql1="select b.*, d.dealer_name_e from collection_from_customer b, dealer_info d where b.dealer_code=d.dealer_code  and b.collection_no = '".$collection_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;



$dealer_code[] = $info->dealer_code;

$dealer_name[] = $info->dealer_name_e;

$tr_no[] = $info->tr_no;

$collection_amt[] = $info->collection_amt;

$ledger_id[] = $info->ledger_id;


}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Daily Black Tea Transection Sheet :.</title>

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

<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">

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

if($_SESSION['user']['group']>0)

echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);

else

echo $_SESSION['proj_name'];

				?><br /></strong> <!--<br /><strong><?=$address?></strong> --></td>

      </tr>

      <tr>

        <td bgcolor="#CCCCCC" style="text-align:center; color:#000; font-size:15px; font-weight:bold;">Cash Collection Report </td>

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

		          <td align="right" valign="middle"> Warehouse:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><strong><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);?></strong></td>
                    </tr>

                  </table></td>
		        </tr>
				
				
				<tr>

		          <td align="right" valign="middle"> Address:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo find_a_field('warehouse','address','warehouse_id='.$warehouse_id);?></td>
                    </tr>

                  </table></td>
		        </tr>
				<?php /*?><tr>
				  <td align="right" valign="middle">Salesman:</td>
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?= find_a_field('salesman','salesman',"id=".$datas->salesman);?></td>
                    </tr>
                  </table></td>
				  </tr><?php */?>
				<tr>
				  <td align="right" valign="middle">&nbsp;</td>
				  <td>&nbsp;</td>
				  </tr>

		        

		        <!--<tr>

		          <td align="right" valign="middle"> Carried By:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo $carried_by;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>-->
		        </table>		      </td>

			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			  <tr>

                <td align="right" valign="middle"> Tr No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;<strong><?php echo $collection_no;?></strong></td>

                    </tr>

                </table></td>

				<tr>

				<td align="right" valign="middle">Tr  Date: </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;

                        <?=date("d-m-Y",strtotime($collection_date))?></td>

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

    <td>

      <div id="pr">

  <div align="left">

<input name="button" type="button" onclick="hide();window.print();" value="Print" />

  </div>

</div>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">

       <tr>

        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>

        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>TR No </strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>
        <td width="46%" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Customer Name </strong></div></td>

        <td width="21%" align="center" bgcolor="#CCCCCC"><strong>Amount</strong></td>
        </tr>

       

<? for($i=0;$i<$pi;$i++){?>

      

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="center" valign="top"><?=$tr_no[$i];?></td>
        <td align="center" valign="top"><?=$dealer_code[$i];?></td>
        <td align="left" valign="top"><?=$dealer_name[$i];?></td>

        <td align="right" valign="top"><?=number_format($collection_amt[$i],2); $tot_amount+=$collection_amt[$i];?></td>
        </tr>
		
		<? }?>
      <tr>
        <td colspan="4" align="center" valign="top"><div align="right"><strong>Total:</strong></div></td>
        <td align="right" valign="top"><span class="style1">
          <?=number_format($tot_amount,2)?>
        </span></td>
      </tr>
  </table></td>

  </tr>

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2" style="font-size:12px">&nbsp;</td>
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
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
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
          <td><div align="center"><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?>  <hr style="width:60%;" /></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>

          <td><div align="center">Prepared By </div></td>

          <td><div align="center">Incharge Person</div></td>

          <td><div align="center">Assistant Manager</div></td>
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

