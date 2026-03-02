<?php


session_start();


//====================== EOF ===================


//var_dump($_SESSION);



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$pi_no 		= $_REQUEST['pi_no'];





$ms_data=find_all_field('production_issue_master','s','pi_no='.$pi_no);



$concern=find_all_field('user_group','','id='.$_SESSION['user']['group']);




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">


<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<title>.: Depot Transfer Report :.</title>


<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>


<script type="text/javascript">


function hide()


{


    document.getElementById("pr").style.display="none";


}


</script>


<style>
.jvbutton {
    display: block;
	float:left;
    width: auto;
    height: 25px;
    background: #4E9CAF;
    padding: 5px 20px 5px 20px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    line-height: 25px;
	
	margin-right: 20px;
}


.jvbutton:hover {

    color: #000000;
    font-weight: bold;

}

</style>
</head>


<body style="font-family:Tahoma, Geneva, sans-serif">


<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">


  <tr>


    <td colspan="2"><div class="header">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			
			
			
			<tr>

              <td width="20%"><p><strong><?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/1.png" width="100%" /><?php */?></strong></p></td>

               <td width="60%" align="center"><strong style="font-size:24px">
        <?=$concern->group_name?>
        <br />
        </strong><strong style="font-size:12px; margin-bottom:5px;">
        <?=$concern->address?>
        </strong><br />
		<strong style="font-size:12px;  margin-bottom:10px;">
       Phone: <?=$concern->phone?>, Fax: <?=$concern->fax?>
        </strong>		</td>
                <td width="20%">&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			
			

              

            </table></td>
          </tr>



        </table></td>
	    </tr>
    </table>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">


	  <tr>


	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


          <tr>


            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


              <tr>


                <td>


				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">


      <tr>


        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">Depot Transfer  Note  </td>
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


		          <td width="40%" align="right" valign="middle"><label>From Warehouse: </label></td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


		            <tr>


		              <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$ms_data->warehouse_from);?></td>
		              </tr>


		            </table></td>
		          </tr>


		        <tr>


		          <td align="right" valign="center"> To Warehouse:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$ms_data->warehouse_to);?></td>
                    </tr>


                  </table></td>
		        </tr>
		        <tr>
		          <td align="right" valign="center"> Sales Type:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><?php echo find_a_field('sales_type','sales_type','id='.$ms_data->sales_type);?></td>
                    </tr>


                  </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
		        </table>		      </td>


			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">


			  <tr>


                <td align="right" valign="middle"> TR No:</td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td>&nbsp;<strong><?php echo $pi_no;?></strong></td>
                    </tr>


                </table></td>
				<tr>


				<td align="right" valign="middle">TR Date:</td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td>&nbsp;<?=date("d-M-Y",strtotime($ms_data->pi_date))?></td>
                    </tr>


                </table></td>
			    </tr>


<tr>


				<td align="right" valign="middle">Invoice No:</td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td>&nbsp;<?=$ms_data->invoice_no?></td>
                    </tr>


                </table></td>
			    </tr>
				
				<? if ($ms_data->received_by>0) {?>
				
				<tr>


				<td align="right" valign="middle">Received Date:</td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td>&nbsp;<?=date("d-M-Y",strtotime($ms_data->receive_date))?></td>
                    </tr>


                </table></td>
			    </tr>
				
				<? }?>

			  


			  


			  </table></td>
		  </tr>


		</table>		</td>
	  </tr>
    </table>


    </div></td>
  </tr>


  <tr>


    


	<td colspan="2">	</td>
  </tr>


  <tr id="pr">
  	<td width="94"><div >


  <div align="left">


<input name="button" type="button" onclick="hide();window.print();" value="Print" />
  </div>


</div></td>
    <td width="706"><!--<a target="_blank"  class="jvbutton" href="production_consumption_report.php?v_no=<?=$pr_no;?>"> Consumption View</a>--></td>
  </tr>
  
  
  <tr>


    <td colspan="2">


      


<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">


       <tr>


        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>


        <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>
        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>


        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Ctn</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong> Qty in KG </strong></td>
        </tr>
		
		
		  <?
	   
	   
$sql_sub="select a.*, i.sub_group_id, s.sub_group_name from warehouse_transfer_detail a, item_info i, item_sub_group s where a.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  a.pi_no='$pi_no' 
group by i.sub_group_id";
$data_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($data_sub)){ 
	   
	   
	   ?>
		
		
		
		
		<?

 $sql1="select b.*, i.unit_name, i.item_name, i.finish_goods_code, s.sub_group_name from warehouse_transfer_detail b,item_info i,item_sub_group s where i.sub_group_id=s.sub_group_id and b.item_id=i.item_id and i.sub_group_id='".$info_sub->sub_group_id."' and b.pi_no = '".$pi_no."' order by s.sub_group_id ";


$data1=db_query($sql1);





$pr=0;


$total=0;


while($info=mysqli_fetch_object($data1)){ 


$pr++;





$qc_by=$info->qc_by;


$item_id = $info->item_id;
$sub_group_name = $info->sub_group_name;

$unit_name= $info->unit_name;


$bag_unit = $info->bag_unit;
$bag_size= $info->bag_size;
$total_unit= $info->total_unit;

$entry_at = $info->entry_at;




		
		
		
		?>


       



      


      <tr>


        <td align="center" valign="top"><?=$pr?></td>


        <td align="center" valign="top"><?=$info->finish_goods_code?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id);?></td>


        <td align="right" valign="top"><?=$info->unit_name;?></td>
        <td align="right" valign="top"><?=$info->pkt_unit; $total_pack_unit +=$info->pkt_unit;?></td>
        <td align="right" valign="top"><?=$info->total_unit; $total_total_unit += $info->total_unit;?></td>
        </tr>




		  <?   }?>

      <tr>
        <td colspan="3" align="right" valign="top"><strong><span style="text-transform:uppercase;">Total <?php /*?><?=$info_sub->sub_group_name?><?php */?>:</span></strong></td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="right" valign="top"><strong>
          <?=number_format($total_pack_unit,2);?>
        </strong></td>
        <td align="right" valign="top"><strong>
          <?=number_format($total_total_unit,2);?>
        </strong></td>
        </tr>
		<? $tot_total_unit = 0;
 $bag_unit_total = 0; }?>
 
 <?php /*?><tr>
        <td colspan="2" align="right" valign="top"><strong><span style="text-transform:uppercase;">GRAND TOTAL:</span></strong></td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="right" valign="top"><strong>
          <?=number_format($grand_tot_total_unit,2);?>
        </strong></td>
        <td align="right" valign="top"><strong>
          <?=number_format($grand_bag_unit_total,2);?>
        </strong></td>
        <td align="right" valign="top">&nbsp;</td>
 </tr><?php */?>
  </table></td>
  </tr>


  <tr>


    <td colspan="2" align="center">


    <table width="100%" border="0" cellspacing="0" cellpadding="0">


  <tr>


    <td colspan="2" style="font-size:12px"><em>Printed By:&nbsp;
        <?=find_a_field('user_activity_management','fname',' user_id='.$_SESSION['user']['id']) ?>
, Printed At:
<?=date('Y-m-d H:i:s') ?>
    </em></td>
    </tr>


  <tr>


    <td width="50%">&nbsp;</td>


    <td>&nbsp;</td>
  </tr>


  <? if($ms_data->remarks!="") {?>
          <tr style="border:1px solid #000; color: #000;">
            <td colspan="2" align="left"><table width="100%" cellspacing="0" cellpadding="0"  style="border:1px solid #000; color: #000; height:28px" >
		  <tr>
		    <td width="15%" align="center" bgcolor="#4E9CAF" style="border:1px;border-color:#000; color: #000; font-size:14px; " ><strong>Note:</strong></td>
			 <td width="85%" align="left" style="border:0px;border-color:#FFF; color: #000; font-size:14px; " ><strong> &nbsp;&nbsp;&nbsp;<?=$datas->remarks;?></strong></td>
          </tr>
		  
</table></td>
          </tr>
		  <? }?>
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
    <td><div align="center"><?php echo find_a_field('user_activity_management','fname','user_id='.$ms_data->entry_by);?></div></td>
    <td><div align="center"><?php echo find_a_field('user_activity_management','fname','user_id='.$ms_data->received_by);?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><hr style="width: 90%" /></td>
    <td><hr style="width: 90%" /></td>
    <td><hr style="width: 90%" /></td>
    <td><hr style="width: 90%" /></td>
  </tr>
  <tr>
    <td width="25%"><div align="center">Prepared By</div></td>
    <td width="25%"><div align="center">Received By</div></td>
    <td width="25%"><div align="center">Store Incharge</div></td>
    <td width="25%"><div align="center">Assistant Manager </div></td>
  </tr>
      </table></td>
    </tr>


  <tr>


    <td>&nbsp;</td>


    <td>&nbsp;</td>
  </tr>
  
  
  <?php /*?><tr>
            <td colspan="2" style="border:1px solid #000; color: #000;" align="center" ><p>
				<? $data=mysqli_fetch_object(db_query("select * from project_info limit 1"));	?>	
				<b><?php echo $data->proj_name ?></b>
				<br />
                <?php echo $data->proj_address;?>
                <br />
				Tell: <?php echo $data->proj_phone; ?></p>                          </td>
          </tr><?php */?>
    </table>


    <div class="footer1"> </div>    </td>
  </tr>
</table>


</body>


</html>


