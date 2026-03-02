<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Depot Sales Varification List';

$now=time();

do_calander('#do_date_fr');

do_calander('#do_date_to');

$depot_id = $_POST['depot_id'];

?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">

								      <table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">

                                        <tr>

                                          <td><div align="right"><strong>Chalan Date :</strong></div></td>

                                          <td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" style="width:150px;"/></td>

                                          <td>-to-</td>

                                          <td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" style="width:150px;"/></td>

                                          <td rowspan="5"><input type="submit" name="submitit" id="submitit" value="View Depot Sales" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>

                                        </tr>

                                        <tr>

                                          <td><div align="right"><strong>Dealer Code: </strong></div></td>

                                          <td colspan="3"><label>

                                            <input name="dealer_code" type="text" id="dealer_code" value="<?=$_POST['dealer_code']?>" />

                                          </label></td>

                                        </tr>

                                        <tr>

                                          <td><div align="right"><strong>Dearler Type: </strong></div></td>

                                          <td colspan="3"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                                            <select name="dealer_type" id="dealer_type" style="width:150px;">

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

                                          <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                                              <select name="depot_id" id="depot_id" style="width:250px;">

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



$datefr = strtotime($_POST['do_date_fr']);

$dateto = strtotime($_POST['do_date_to']);

$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));

$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));

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

				  j.user_id,

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

				  j.jv_date between '".$day_from."' AND '".$day_end."' AND 

				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con." ".$depot_con.$checked_con.$dealer_type_con.$dealer_group_con.$dealer_code_con." AND

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

</table>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>