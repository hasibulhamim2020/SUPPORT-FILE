<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Gift Offer Report';

//do_calander('#od1');
do_calander("#od1");

$table_master='sale_gift_offer';
$unique_master='id';
$page = $target_url = 'gift_offer.php';
$tr_type="Show";


?>



<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Type</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                           <select name="dealer_type" id="dealer_type">
								 <option></option>
								 <? foreign_relation('dealer_type','id','dealer_type',$_POST['dealer_type'],'1');?>
							</select>

                        </div>
                    </div>
                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Offer Date</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input  name="od1" type="text" id="od1" value="<? if($_POST['od1']!='') echo $_POST['od1']; else echo date('Y-m-d');?>"/>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
                       
						<input name="new" type="submit" class="btn1 btn1-bg-submit" value="VIEW REPORT" tabindex="12" />
						<input name="flag" id="flag" type="hidden" value="1" />
                </div>

            </div>
        </div>

            
        </div>

        <!--return Table design start-->
        <div class="container-fluid pt-5 p-0 ">
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
						<th>ID</th>
						<th>Offer Name</th>
						<th>Customer Type</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Item Qty</th>
						<th>Gift Code</th>
						<th>Gift Name</th>
						<th>Gift Qty</th>
						<th>Start Date</th>
						<th>End Date</th>
						
                </tr>
                </thead>

                <tbody class="tbody1">
				
				 <? 
					  if(isset($_POST['new'])){
					if($_POST['od1']!='')
					$con .= ' and a.start_date <= "'.$_POST['od1'].'" and a.end_date >= "'.$_POST['od1'].'" ';
					if($_POST['dealer_type']>0)
					$con .= ' and a.dealer_type_id="'.$_POST['dealer_type'].'"';
                    $tr_type="Search";
					
					if($_POST['gpn']!='')
					$con .= ' and a.offer_name="'.$_POST['gpn'].'"';
					
					$res = 'select a.id,a.id,a.offer_name,a.dealer_type as customer_type,b.finish_goods_code as i_code,b.item_name,a.item_qty,c.finish_goods_code as g_code,c.item_name as gift_name,a.gift_qty,a.start_date,a.end_date from sale_gift_offer a,item_info b,item_info c where b.item_id=a.item_id and c.item_id=a.gift_id '.$con;
					
					
						$query=db_query($res);
						while($data=mysqli_fetch_object($query)){
					
					?>

               <tr>
					<td><?=$data->id?></td>
					<td style="text-align:left"><?=$data->offer_name?></td>
					<td style="text-align:left"><?=$data->customer_type?></td>
					<td><?=$data->i_code?></td>
					<td style="text-align:left"><?=$data->item_name?></td>
					<td><?=$data->item_qty?></td>
					<td><?=$data->g_code?></td>
					<td style="text-align:left"><?=$data->gift_name?></td>
					<td><?=$data->gift_qty?></td>
					<td><?=$data->start_date?></td>
					<td><?=$data->end_date?></td>
					
					
				</tr>




					<? }?>
					
					
					
					<? }?>
                </tbody>
            </table>

        </div>
    </form>

    

</div>






<?php /*?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><fieldset style="width:700px;">
	      <div>
        <label style="width:150px;">Customer Type : </label>
        
        <select name="dealer_type" id="dealer_type">
		 <option></option>
		 <? foreign_relation('dealer_type','id','dealer_type',$_POST['dealer_type'],'1');?>
		</select>
      </div>
      <div>
        <label style="width:150px;">Offer Date : </label>
        
        <input style="width:155px;"  name="od1" type="text" id="od1" value="<? if($_POST['od1']!='') echo $_POST['od1']; else echo date('Y-m-d');?>"/>
      </div>
      
      </fieldset></td>
    </tr>
  <tr>
    <td><div style="margin-left:240px;">
   
<input name="new" type="submit" class="btn1 btn1-bg-submit" value="View Report" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="1" />

    </div></td>
    </tr>
</table>

  <? 
  if(isset($_POST['new'])){
if($_POST['od1']!='')
$con .= ' and a.start_date <= "'.$_POST['od1'].'" and a.end_date >= "'.$_POST['od1'].'" ';
if($_POST['dealer_type']>0)
$con .= ' and a.dealer_type_id="'.$_POST['dealer_type'].'"';

if($_POST['gpn']!='')
$con .= ' and a.offer_name="'.$_POST['gpn'].'"';

$res = 'select a.id,a.id,a.offer_name,a.dealer_type as customer_type,b.finish_goods_code as i_code,b.item_name,a.item_qty,c.finish_goods_code as g_code,c.item_name as gift_name,a.gift_qty,a.start_date,a.end_date from sale_gift_offer a,item_info b,item_info c where b.item_id=a.item_id and c.item_id=a.gift_id '.$con;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
echo link_report($res,$page);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
  <? } ?>
  </form>

</div><?php */?>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>