<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type ="Show";


$title='Chalan Varification Report';

$now=time();

do_calander('#do_date_fr');

do_calander('#do_date_to');

$depot_id = $_POST['depot_id'];

?>



<!--Hrm All report pages design-->
<form id="form1" name="form1" method="post" action="">
    <div class="form-container_large">
       
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Date From</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan To</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Depot</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="depot_id" id="depot_id" class="form-control">
											<option value=""></option>
                                                <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'use_type="SD" order by warehouse_name');?>

                                 </select>
                            </div>
                        </div>




                    </div>
                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                      

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer Code</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="dealer_code" type="text" id="dealer_code" value="<?=$_POST['dealer_code']?>" class="form-control" />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer Type</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="dealer_type" id="dealer_type" class="form-control">

                                              <option value=""  <?=($_POST['dealer_type']=='')?'Selected':'';?>>All</option>

                                              <option value="Distributor"  <?=($_POST['dealer_type']=='Distributor')?'Selected':'';?>>Distributor</option>

                                              <option value="Corporate"    <?=($_POST['dealer_type']=='Corporate')?'Selected':'';?>>Corporate+SuperShop</option>

                                 </select>
                            </div>
                        </div>
						





                    </div>
                </div>


            </div>

        </div>

        <div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input type="submit" name="submitit" id="submitit" value="View Chalan" class="btn1 btn1-submit-input"/>
				</div>

		</div>
		
		
		<div class="container-fluid">
		
			<tr>
                <th class="pl-2" align="right"><? include('PrintFormat.php');?></th>
            </tr>
		</div>
		
		
		
		<div class="container-fluid p-0 ">


				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					
					
					<tr class="bgc-info">
					
					
						  <th>SL</th>
					
						  
					
						  <th>DO#</th>
					
						  <th>CH#</th>
					
						  <th>Dealer Name</th>
					
						  <th>Chalan At</th>
					
						  <th>Chalan By </th>
					
						  <th>Item</th>
					
						  <th>Chalan Amt</th>

     
					</tr>
					</thead>

					<tbody class="tbody1">
					
					<?





		 if($_POST['do_date_fr']!=''){

$i=0;



$datefr = $_POST['do_date_fr'];

$dateto = $_POST['do_date_to'];

//$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));

//$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));

if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];



if($depot_id>0) $depot_con = 'and d.depot='.$depot_id;

if($_POST['dealer_code']!='') {$dealer_code_con=' and d.dealer_code="'.$_POST['dealer_code'].'"';}

if($_POST['dealer_type']=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';}

if($_POST['dealer_type']=='Corporate') {$dealer_type_con=' and d.dealer_type!="Distributor"';}

if($_POST['dealer_group']!='') {$dealer_group_con=' and d.product_group="'.$_POST['dealer_group'].'"';}
$tr_type="Search";

		 $sql="SELECT DISTINCT 
 
				  j.tr_no,

				  sum(1) as co,

				  sum(j.dr_amt) as dr_amts,

				  j.jv_date,

				  j.jv_no,

				  l.ledger_name,

				  j.tr_id,

				  j.entry_by,

				  j.entry_at,

				  j.checked,

				  j.jv_no,

				  j.dr_amt

				FROM

				  secondary_journal j,

				  accounts_ledger l,

				  dealer_info d

				WHERE

					d.account_code = l.ledger_id and 

				  j.tr_from = 'Sales' AND 

				  j.dr_amt >0 AND 

				  j.jv_date between '".$datefr."' AND '".$dateto."' AND 

				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con." ".$checked_con.$dealer_type_con.$dealer_group_con.$dealer_code_con." AND

				  j.checked='YES'

				group by  j.tr_no";

	  $query=db_query($sql);

	  

	  while($data=mysqli_fetch_object($query)){

	  $received = $received + $data->dr_amt;

	  ?>

					<tr>
				
					  <td align="center"><div align="left"><?=++$i;?></div></td>
				
					  <td align="center"><div align="left"><? echo $data->tr_id;?></div></td>
				
					  <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
				
					  <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>
				
					  <td align="center"><div align="left"><? echo $data->entry_at;?></div></td>
				
					  <td align="center"><div align="left"><? echo @find_a_field('user_activity_management','fname','user_id='.$data->user_id);?></div></td>
				
					  <td align="center"><div align="left"><?=find_a_field('sale_do_chalan','sum(1)','chalan_no='.$data->tr_no).' item received';?></div></td>
				
					  <td align="right"><?=number_format($data->dr_amts,2);?></td>

     			 </tr>
				 
				 
				 <? } } ?>
				 <tr class="alt">

        		<td colspan="7" align="center"><div align="right"><strong>Total Amt : </strong></div>

          

           			 <div align="left"></div></td>

        			<td align="right"><?=number_format($received,2);?></td>

        </tr>

					</tbody>
				</table>





			</div>


        
    </div>

</form>



<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">

								      <table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" style="background-color:#FF9999;">

                                        <tr>

                                          <td><div align="right"><strong>Chalan Date :</strong></div></td>

                                          <td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" class="form-control"/></td>

                                          <td>-to-</td>

                                          <td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" class="form-control"/></td>

                                          <td rowspan="5"><input type="submit" name="submitit" id="submitit" value="View Chalan" class="btn1 btn1-submit-input"/></td>

                                        </tr>

                                        <tr>

                                          <td><div align="right"><strong>Dealer Code: </strong></div></td>

                                          <td colspan="3"><label>

                                            <input name="dealer_code" type="text" id="dealer_code" value="<?=$_POST['dealer_code']?>" class="form-control" />

                                          </label></td>

                                        </tr>

                                        <tr>

                                          <td><div align="right"><strong>Dealer Type: </strong></div></td>

                                          <td colspan="3"><span class="oe_form_group_cell" >

                                            <select name="dealer_type" id="dealer_type" class="form-control">

                                              <option value=""  <?=($_POST['dealer_type']=='')?'Selected':'';?>>All</option>

                                              <option value="Distributor"  <?=($_POST['dealer_type']=='Distributor')?'Selected':'';?>>Distributor</option>

                                              <option value="Corporate"    <?=($_POST['dealer_type']=='Corporate')?'Selected':'';?>>Corporate+SuperShop</option>

                                            </select>

                                          </span></td>

                                        </tr>

                                        <tr>

                                          <!--<td><div align="right"><strong>Dealer Group: </strong></div></td>

                                          <td colspan="3"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                                            <select name="dealer_group" id="dealer_group" style="width:250px;">

                                              <option value="<?=$_POST['dealer_group']?>">

                                                <?=$_POST['dealer_group']?>

                                              </option>

                                              <option value=""></option>

                                              <option value="A">A</option>

                                              <option value="B">B</option>

                                              <option value="C">C</option>

                                              <option value="D">D</option>

                                              <option value="M">M</option>

                                            </select>

                                          </span></td>-->

                                        </tr>

                                        <tr>

                                          <td><div align="right"><strong>Chalan Depot : </strong></div></td>

                                          <td colspan="3"><div align="left"><span class="oe_form_group_cell">

                                              <select name="depot_id" id="depot_id" class="form-control">
<option value=""></option>
                                                <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'use_type="SD" order by warehouse_name');?>

                                              </select>

                                          </span></div></td>

                                        </tr>

                                      </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td><div id="reporting">

									<table id="grp"  class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">

      <tr>

      <th>SL</th>

	  

      <th>DO#</th>

      <th>CH#</th>

      <th>Dealer Name</th>

      <th>Chalan At</th>

      <th>Chalan By </th>

      <th>Item</th>

      <th>Chalan Amt</th>

      </tr><?





		 if($_POST['do_date_fr']!=''){

$i=0;



$datefr = $_POST['do_date_fr'];

$dateto = $_POST['do_date_to'];

//$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));

//$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));

if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];



if($depot_id>0) $depot_con = 'and d.depot='.$depot_id;

if($_POST['dealer_code']!='') {$dealer_code_con=' and d.dealer_code="'.$_POST['dealer_code'].'"';}

if($_POST['dealer_type']=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';}

if($_POST['dealer_type']=='Corporate') {$dealer_type_con=' and d.dealer_type!="Distributor"';}

if($_POST['dealer_group']!='') {$dealer_group_con=' and d.product_group="'.$_POST['dealer_group'].'"';}

		 $sql="SELECT DISTINCT 
 
				  j.tr_no,

				  sum(1) as co,

				  sum(j.dr_amt) as dr_amts,

				  j.jv_date,

				  j.jv_no,

				  l.ledger_name,

				  j.tr_id,

				  j.entry_by,

				  j.entry_at,

				  j.checked,

				  j.jv_no,

				  j.dr_amt

				FROM

				  secondary_journal j,

				  accounts_ledger l,

				  dealer_info d

				WHERE

					d.account_code = l.ledger_id and 

				  j.tr_from = 'Sales' AND 

				  j.dr_amt >0 AND 

				  j.jv_date between '".$datefr."' AND '".$dateto."' AND 

				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con." ".$checked_con.$dealer_type_con.$dealer_group_con.$dealer_code_con." AND

				  j.checked='YES'

				group by  j.tr_no";

	  $query=db_query($sql);

	  

	  while($data=mysqli_fetch_object($query)){

	  $received = $received + $data->dr_amt;

	  ?>



      <tr <?=($i%2==0)?'class="alt"':'';?>>

      <td align="center"><div align="left"><?=++$i;?></div></td>

      <td align="center"><div align="left"><? echo $data->tr_id;?></div></td>

      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>

      <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>

      <td align="center"><div align="left"><? echo $data->entry_at;?></div></td>

      <td align="center"><div align="left"><? echo @find_a_field('user_activity_management','fname','user_id='.$data->user_id);?></div></td>

      <td align="center"><div align="left"><?=find_a_field('sale_do_chalan','sum(1)','chalan_no='.$data->tr_no).' item received';?></div></td>

      <td align="right"><?=number_format($data->dr_amts,2);?></td>

      </tr>

	  <? }}?>

	        <tr class="alt">

        <td colspan="7" align="center"><div align="right"><strong>Total Amt : </strong></div>

          

            <div align="left"></div></td>

        <td align="right"><?=number_format($received,2);?></td>

        </tr>

</table> 

									</div>

											

		</td>

		</tr>

		</table>

		</div></td>    

  </tr>

</table><?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>