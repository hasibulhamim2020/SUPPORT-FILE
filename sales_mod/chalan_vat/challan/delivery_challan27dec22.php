<?php




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='Delivery Challan Create';







do_calander('#so_date');



do_calander('#chalan_date');





$table_master='sale_do_master';



$table_details='sale_do_details';



 $unique='do_no';













if($_SESSION[$unique]>0)



$$unique=$_SESSION[$unique];







if($_REQUEST[$unique]>0){



$$unique=$_REQUEST[$unique];



$_SESSION[$unique]=$$unique;}



else



 $$unique = $_SESSION[$unique];















if(isset($_POST['confirmm']))



{



		unset($_POST);



		$_POST[$unique]=$$unique;



		$_POST['edit_by']=$_SESSION['user']['id'];



		$_POST['edit_at']=date('Y-m-d h:i:s');



		$_POST['status']='PROCESSING';



		$crud   = new crud($table_master);



		$crud->update($unique);



		unset($$unique);



		unset($_SESSION[$unique]);



		$type=1;



		$msg='Successfully Completed All Purchase Order.';

		

		echo '<script>window.location.replace("select_unfinished_do.php")</script>';



}



if(isset($_POST['return']))



{



		$remarks = $_POST['return_remarks'];

        unset($_POST);

		$_POST[$unique]=$$unique;

        $_POST['status']='MANUAL';

		$_POST['checked_at'] = date('Y-m-d H:i:s');

		$_POST['checked_by'] = $_SESSION['user']['id'];

		$crud   = new crud($table_master);

		$crud->update($unique);

		$note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique.'","CHALAN","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';

		db_query($note_sql);



		unset($$unique);



		unset($_SESSION[$unique]);



		$type=1;

        

        echo $msg='<span style="color:green;">Successfully Returned</span>';

		

		echo '<script>window.location.replace("select_wo_for_challan.php")</script>';



}









if(isset($_POST['delete']))



{



		unset($_POST);



		$_POST[$unique]=$$unique;



		$_POST['edit_by']=$_SESSION['user']['id'];



		$_POST['edit_at']=date('Y-m-d H:i:s');



		$_POST['status']='CHECKED';



		$crud   = new crud($table_master);



		$crud->update($unique);







		unset($$unique);



		unset($_SESSION[$unique]);



		$type=1;



		$msg='Order Returned.';



}







if(prevent_multi_submit()){







if(isset($_POST['confirm'])){





		$ch_date=$_POST['chalan_date'];

		

		$rec_name=$_POST['rec_name'];

		$rec_mob=$_POST['rec_mob'];

		

		$vehicle_no=$_POST['vehicle_no'];

		$driver_name=$_POST['driver_name'];

		

		$driver_mobile=$_POST['driver_mobile'];

		$delivery_point=$_POST['delivery_point'];

		

		$delivery_man=$_POST['delivery_man'];

		$delivery_man_mobile=$_POST['delivery_man_mobile'];





		$entry_by= $_SESSION['user']['id'];

		$entry_at = date('Y-m-d H:i:s');

		

		

		$YR = date('Y',strtotime($ch_date));

  		$yer = date('y',strtotime($ch_date));

  		$month = date('m',strtotime($ch_date));



  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;

   		$cy_id = sprintf("%07d", $ch_cy_id);

   		$chalan_no=''.$yer.''.$month.''.$cy_id;





		

		//$chalan_no = next_transection_no($group_for,$ch_date,'sale_do_chalan','chalan_no');



		//$gate_pass = next_transection_no('0',$ch_date,'sale_do_chalan','gate_pass');



		

		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);



		 $sql = 'select d.*, i.cost_price from sale_do_details d, item_info i where  d.item_id=i.item_id and d.do_no = '.$do_no;



		$query = db_query($sql);



		//$pr_no = next_pr_no($warehouse_id,$rec_date);





		while($data=mysqli_fetch_object($query))



		{

	



			if($_POST['chalan_'.$data->id]>0)



			{

			

	



				$qty=$_POST['chalan_'.$data->id];



				$rate=$_POST['rate_'.$data->id];



				$item_id =$_POST['item_id_'.$data->id];

				

				$amount = ($qty*$rate); 

				

				$cost_amt = ($qty*$data->cost_price); 

 





  $so_invoice = 'INSERT INTO sale_do_chalan (year, ch_id, chalan_no, chalan_date, order_no, do_no, job_no, do_date, item_id, dealer_code, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt, discount, depot_id, group_for, rec_name, rec_mob, vehicle_no, driver_name, driver_mobile, delivery_point, delivery_man, delivery_man_mobile, entry_by, entry_at, status, cost_price, cost_amt)

  

  VALUES("'.$YR.'","'.$ch_cy_id.'","'.$chalan_no.'","'.$ch_date.'","'.$data->id.'","'.$data->do_no.'","'.$data->job_no.'","'.$data->do_date.'","'.$item_id.'","'.$data->dealer_code.'","'.$rate.'","'.$pkt_size.'","'.$pkt_unit.'","'.$qty.'","'.$qty.'","'.$amount.'","'.$discount.'","'.$ms_data->depot_id.'","'.$ms_data->group_for.'","'.$rec_name.'","'.$rec_mob.'","'.$vehicle_no.'","'.$driver_name.'","'.$driver_mobile.'","'.$delivery_point.'","'.$delivery_man.'","'.$delivery_man_mobile.'","'.$entry_by.'","'.$entry_at.'","CHECKED", "'.$data->cost_price.'", "'.$cost_amt.'")';



db_query($so_invoice);







	journal_item_control($item_id, $ms_data->depot_id, $ch_date,  0, $qty, 'Sales', $data->id, $rate, '', $chalan_no, '', '',$ms_data->group_for, $rate->unit_price, '' );



$tr_from="Sales";

$tr_no=$chalan_no;

$tr_id=$data->id;

$tr_type="Add";


}



}





if($chalan_no>0)

{

auto_insert_sales_chalan_secoundary($chalan_no);



}



	



}



}



else



{



	$type=0;



	$msg='Data Re-Submit Warning!';



}







if($$unique>0)



{



		$condition=$unique."=".$$unique;



		$data=db_fetch_object($table_master,$condition);



		foreach ($data as $key => $value)



		{ $$key=$value;}



		



}



//if($delivery_within>0)

//{

//	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);

//}















?>





<script>









function calculation(id){



var chalan=((document.getElementById('chalan_'+id).value)*1);



var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);









 if(chalan>pending_qty)

  {

alert('Can not issue more than pending quantity.');



document.getElementById('chalan_'+id).value='';



  } 





}



</script>







<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<!--        top form start hear-->

        <div class="container-fluid bg-form-titel">

            <div class="row">

                <!--left form-->

                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

						 <? $field='do_no';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SO NO </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

        



     						   <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>



      

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

								 <? $field='do_date';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SO Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                           



       						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>





                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

						 		<? $field='job_no';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job No</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

              

							

									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" />

							



                            </div>

                        </div>

						

						



                    </div>







                </div>



                <!--Right form-->

                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

								<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                        

								<input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" readonly="readonly" />

								<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" readonly="readonly"/>



                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

								 <? $field='req_no'; $table='purchase_master';$get_field='req_no';$show_field='req_no';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                          



        						<input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" readonly="readonly"/>



								<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" readonly="readonly"/>





                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

						      

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                       

							<input  name="remarks" type="text" id="remarks" value="<?=$remarks?>"  readonly="readonly"/>



                            </div>

                        </div>

					



                    </div>







                </div>

				

				

				<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

				

							<div class="d-flex justify-content-center pt-2 pb-2">

								<div class="n-form1 fo-white pt-0 p-0">

									<div class="container p-0">

									

									

									

								<table class="table1  table-striped table-bordered table-hover table-sm">

								

									<thead>

																			

												<tr class="bgc-yellow">

										

												  <td><strong>Date</strong></td>

										

												  <td><strong>Chalan No</strong></td>

										

												</tr>

									</thead>

										

										<?

 

										$sql='select distinct chalan_no, chalan_date from sale_do_chalan where do_no='.$$unique.' order by id desc';

										

										$qqq=db_query($sql);

										

										while($aaa=mysqli_fetch_object($qqq)){

										

										?>

										

												<tr>

										

												  <td><?php echo date('d-m-Y',strtotime($aaa->chalan_date));?></td>

										

												  <td ><a target="_blank" href="delivery_challan_print_view.php?v_no=<?=$aaa->chalan_no?>"><?=$aaa->chalan_no?></a></td>

										

												</tr>

										

										<?

										

										}

										

										?>			  



										

										

										

								</table>

										

						

						

						

									</div>

								</div>

							</div>

                   







                </div>

				





            </div>

			

			

			



            

        </div>





			<div class="d-flex justify-content-center pt-5 pb-2">

        <div class="n-form1 fo-white pt-0 p-0">

            <div class="container p-0">

			

			

			

			

			<table class="table1  table-striped table-bordered table-hover table-sm">



					  <tr>

					

						<td colspan="3" align="center"><strong>Entry Information</strong></td>

					

						</tr>

					

					  <tr>

					

						<td align="right" >Created By:</td>

					

						<td align="left" >&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

					

						<td rowspan="2" align="center" ><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/sales_order_print_view.php?v_no=<?=$$unique?>" ><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td>

					

					  </tr>

					

					  <tr>

					

						<td align="right" >Created On:</td>

					

						<td align="left">&nbsp;&nbsp;<?=$entry_at?></td>

					

						</tr>

					

					</table>

                







            </div>

        </div>

    </div>







<div class="container-fluid bg-form-titel">

            <div class="row">

                <!--left form-->

                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

						 <? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$_SESSION['chalan_no']);?>

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Date </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

        

                <input name="chalan_date" type="text" id="chalan_date" required="required" value="<?=($ch_data->chalan_date!='')?$ch_data->chalan_date:date('Y-m-d')?>"/>

            



      

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

								 

                            <label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vehicale No</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                           



        						<input name="vehicle_no" type="text" id="vehicle_no" value="<?=$ch_data->vehicle_no;?>" />



                            </div>

                      </div>

					  

					  <div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Point</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                        		<input  name="delivery_point" type="text" id="delivery_point" value="<?=$ch_data->delivery_point;?>" />

    

                            </div>

                      </div>



                       



                    </div>







                </div>



                <!--Right form-->

                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receiver Name</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                        		<input  name="rec_name" type="text" value="<?=$ch_data->rec_name;?>" id="rec_name" />

    

                            </div>

                      </div>



                        <div class="form-group row m-0 pb-1">

								 

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Driver Name</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                              

								<input name="driver_name" type="text" id="driver_name" value="<?=$ch_data->driver_name;?>"  />



                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Man</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                        		<input  name="delivery_man" type="text" id="delivery_man" value="<?=$ch_data->delivery_man;?>"  />

    

                            </div>

                      </div>



                        

						

						

						

					



                    </div>







                </div>

				

				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receiver Mobile </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                        

								<input   name="rec_mob" value="<?=$ch_data->rec_mob;?>"  type="text" id="rec_mob" />

    

                            </div>

                        </div>



                        <div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Driver Mobile</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                              

								<input  name="driver_mobile"  type="text" id="driver_mobile" value="<?=$ch_data->driver_mobile;?>" />



                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Man Mobile</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                        		<input  name="delivery_man_mobile" type="text" id="delivery_man_mobile" value="<?=$ch_data->delivery_man_mobile;?>"  />

    

                            </div>

                      </div>



                        

						

						

						

					



                    </div>







                </div>

				





            </div>

			

			

			



            

        </div>







        <!--return Table design start-->

        <div class="container-fluid pt-5 p-0 ">

				<? if($$unique>0){



   $sql='select a.id,  a.item_id,  a.unit_price, b.item_name,  b.unit_name,  a.total_unit as qty 

 from sale_do_details a,item_info b, item_sub_group s where b.item_id=a.item_id 

  and b.sub_group_id=s.sub_group_id and  a.do_no='.$$unique;



$res=db_query($sql);



?>

            <table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

             



						<th>SL</th>

			

						<th>Item Name </th>

			

						<th>UOM</th>

			

						<th>SO Qty </th>

			

						<th>Delivered</th>

			

						<th>Pending </th>

			

						<th>Challan Issue </th>

         		   

                </tr>

                </thead>



                <tbody class="tbody1">

				

				 <? while($row=mysqli_fetch_object($res)){$bg++?>



          <tr>



            <td><?=++$ss;?></td>



            <td style="text-align:left"><?=$row->item_name?>

			

			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	

			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>



              <td align="center"><?=$row->unit_name?>                </td>



              <td align="center"><?=number_format($row->qty,2);?></td>



              <td align="center"><? echo number_format($so_qty = (find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>



              <td align="center"><? 



			  

			  echo number_format($unso_qty=($row->qty-$so_qty),2);?>



                <input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$unso_qty?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>



              <td align="center">

			   <? if($unso_qty>0){$cow++;?>



          <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value=""   onKeyUp="calculation(<?=$row->id?>)" />

	



                <? } else echo 'Done';?>			  </td>

              </tr>



          <? }?>



                </tbody>

            </table>



        </div>

    







    <!--button design start-->

    

        <div class="container-fluid p-0 ">



            <div class="n-form-btn-class">

			

			

                <? if($cow<1){

				

				

					

					$vars['status']='COMPLETED';

					

					db_update($table_master, $do_no, $vars, 'do_no');

					

					?>

					<div class="alert alert-success p-2" role="alert">

					 THIS  SALES ORDER IS COMPLETE

					</div>

					

					

					

					

					

					<? }else{

			$chalaned = find_a_field('sale_do_chalan','sum(dist_unit)','do_no="'.$do_no.'"');

			if($chalaned>0){

			?>

			<input name="confirm" type="submit" class="btn1 btn1-submit-input" value="CONFIRM CHALLAN" /></td>

			

			

			

			<? } else{?>

			

			

			<input name="return" type="submit" class="btn1 btn1-bg-cancel" value="RETURN" onclick="return_function()" />

			

			<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/><input type="hidden" name="return_remarks" id="return_remarks"></td>

			

			<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM CHALLAN"  />



<? } }?>

				

					

					

            </div>



        </div>

		

		

	<? } ?>

    </form>



</div>







<?php /*?><div class="form-container_large">



<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">



<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td width="40%" valign="top"><fieldset style="width:100%;">



    <? $field='do_no';?>



      <div>



        <label style="width:140px;" for="<?=$field?>">SO  No: </label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>



      </div>



    <? $field='do_date';?>



      <div>



        <label style="width:140px;" for="<?=$field?>">SO Date:</label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>



      </div>

	  

	  

	  

	 

	  

	   <? $field='job_no';?>



      <div>



        <label style="width:140px;" for="<?=$field?>">Job No:</label>



        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" />



      </div>

	  

	 



    



  

	  

	  

	   





     



    </fieldset></td>



    <td width="9%">			</td>



    <td width="40%"><fieldset style="width:100%;">

	

	

	

	<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>



      <div>



        <label style="width:120px;" for="<?=$field?>">Company:</label>



        <input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" readonly="readonly" style="width:200px;" />



		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" readonly="readonly"/>



      </div>

	  

	  

	  <div>



        <label style="width:120px;" for="<?=$field?>"> Customer:</label>



        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" readonly="readonly"/>



		<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" readonly="readonly"/>



      </div>

	

	





      <div>



        <label style="width:120px;" for="<?=$field?>"> Remarks:</label>



        



		<input  name="remarks" type="text" id="remarks" value="<?=$remarks?>"  readonly="readonly"/>



      </div>



      <div></div>

 



      



              



      <div>





      



      </div>



		</fieldset></td>



    <td width="2%">&nbsp;</td>



  <td width="20%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; font-weight:700;">



	          



        <tr>



          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>



          <td align="left" bgcolor="#9999CC"><strong>Challan No </strong></td>



        </tr>



<?

 

$sql='select distinct chalan_no, chalan_date from sale_do_chalan where do_no='.$$unique.' order by id desc';



$qqq=db_query($sql);



while($aaa=mysqli_fetch_object($qqq)){



?>



        <tr>



          <td bgcolor="#FFFF99" style="font-size:12px; font-weight:700; color:#000000" ><?php echo date('d-m-Y',strtotime($aaa->chalan_date));?></td>



          <td align="center" bgcolor="#FFFF99"><a target="_blank" style="font-size:12px; font-weight:700; color:#000000" href="delivery_challan_print_view.php?v_no=<?=$aaa->chalan_no?>"><?=$aaa->chalan_no?></a></td>



        </tr>



<?



}



?>







      </table></td>



  </tr>



  <tr>



    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">



      <tr>



        <td colspan="4" align="center" bgcolor="#CCFF99"><strong> Entry Information</strong></td>

      </tr>



      <tr>



        <td align="right" bgcolor="#CCFF99">Created By:</td>



        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;



            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>



        



        <td rowspan="2" align="left" bgcolor="#CCFF99"><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/sales_order_print_view.php?v_no=<?=$$unique?>" ><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td>

      </tr>



      <tr>



        <td align="right" bgcolor="#CCFF99">Created On:</td>



        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;



            <?=$entry_at?></td>

        </tr>



    </table></td><?php */?>



  </tr>



  <tr>



    <td colspan="5" valign="top">



<?php /*?>	<? if($ex<time()){?>



	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">



      <tr>



        <td align="right" bgcolor="#FF0000"><div align="center" style="text-decoration:blink"><strong>THIS PURCHASE ORDER IS EXPIRED</strong></div></td>



        </tr>



    </table>



    <? }?><?php */?>



	<?php /*?><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

	

	

	

	



      <tr>

        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td align="right" bgcolor="#9966FF"><strong>Chalan Date:

			  <? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$_SESSION['chalan_no']);?>

			  </strong></td>

              <td align="left" bgcolor="#9966FF"><strong>

                <input style="width:140px;"  name="chalan_date" type="text" id="chalan_date" required="required" value="<?=($ch_data->chalan_date!='')?$ch_data->chalan_date:date('Y-m-d')?>"/>

              </strong></td>

              <td align="right" bgcolor="#9966FF"><strong>Receiver Name:</strong></td>

              <td align="left" bgcolor="#9966FF"><strong>

                <input style="width:140px;"  name="rec_name" type="text" value="<?=$ch_data->rec_name;?>" id="rec_name" />

              </strong></td>

              <td bgcolor="#9966FF" align="right"><strong>Receiver Mobile:</strong></td>

              <td bgcolor="#9966FF"><strong>

                <input style="width:140px;"  name="rec_mob" value="<?=$ch_data->rec_mob;?>"  type="text" id="rec_mob" />

              </strong></td>

            </tr>

            <tr>

              <td align="right" bgcolor="#9999FF"><strong>Vehicale No:</strong></td>

              <td bgcolor="#9999FF"><strong>

                <input style="width:140px;"  name="vehicle_no" type="text" id="vehicle_no" value="<?=$ch_data->vehicle_no;?>" />

                </strong></td>

              <td align="right" bgcolor="#9999FF"><strong>Driver Name: </strong></td>

              <td bgcolor="#9999FF"><strong>

                <input style="width:140px;"  name="driver_name" type="text" id="driver_name" value="<?=$ch_data->driver_name;?>"  />

                </strong></td>

              <td align="right" bgcolor="#9999FF"><strong>Driver Mobile:</strong> </td>

              <td bgcolor="#9999FF"><strong>

                <input style="width:140px;"  name="driver_mobile"  type="text" id="driver_mobile" value="<?=$ch_data->driver_mobile;?>" />

              </strong></td>

            <td>&nbsp;</td>

            </tr>

			 <tr>

              <td align="right" bgcolor="#9999FF"><strong>Delivery Point:</strong></td>

              <td bgcolor="#9999FF"><strong>

                <input style="width:140px;"  name="delivery_point" type="text" id="delivery_point" value="<?=$ch_data->delivery_point;?>" />

                </strong></td>

              <td align="right" bgcolor="#9999FF"><strong>Delivery Man: </strong></td>

              <td bgcolor="#9999FF"><strong>

                <input style="width:140px;"  name="delivery_man" type="text" id="delivery_man" value="<?=$ch_data->delivery_man;?>"  />

                </strong></td>

             

             <td align="right" bgcolor="#9999FF"><strong>Delivery Man Mobile: </strong></td>

              <td bgcolor="#9999FF"><strong>

                <input style="width:140px;"  name="delivery_man_mobile" type="text" id="delivery_man_mobile" value="<?=$ch_data->delivery_man_mobile;?>"  />

                </strong></td>

            </tr>

           

          </table></td>

      </tr>

    </table></td>



    </tr>



</table>



<? if($$unique>0){



   $sql='select a.id,  a.item_id,  a.unit_price, b.item_name,  b.unit_name,  a.total_unit as qty 

 from sale_do_details a,item_info b, item_sub_group s where b.item_id=a.item_id 

  and b.sub_group_id=s.sub_group_id and  a.do_no='.$$unique;



$res=db_query($sql);



?>





<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">



    <tr>



      <td><div class="tabledesign2">



      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">



      <tbody>



          <tr>



            <th width="1%">SL</th>



            <th width="15%">Item_Name </th>



            <th bgcolor="#FFFFFF">UOM</th>



            <th bgcolor="#FF99FF">SO Qty </th>



            <th bgcolor="#009900">Delivered</th>



            <th bgcolor="#FFFF00">Pending </th>



            <th bgcolor="#F57E22">Challan Issue </th>

            </tr>

          

          



          



          <? while($row=mysqli_fetch_object($res)){$bg++?>



          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">



            <td><?=++$ss;?></td>



            <td><?=$row->item_name?>

			

			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	

			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>



              <td width="2%" align="center"><?=$row->unit_name?>                </td>



              <td width="2%" align="center"><?=number_format($row->qty,2);?></td>



              <td width="4%" align="center"><? echo number_format($so_qty = (find_a_field('sale_do_chalan','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>



              <td width="4%" align="center"><? 



			  

			  echo number_format($unso_qty=($row->qty-$so_qty),2);?>



                <input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$unso_qty?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>



              <td width="6%" align="center" bgcolor="#F57E22">

			   <? if($unso_qty>0){$cow++;?>



          <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value=""  style="width:100px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />

	



                <? } else echo 'Done';?>			  </td>

              </tr>



          <? }?>

      </tbody>

      </table>



      </div>



      </td>



    </tr>



  </table><br /> <br />

  



  

  

  

  

	

	<br />

  



<table width="100%" border="0">



<? if($cow<1){



$vars['status']='COMPLETED';



db_update($table_master, $do_no, $vars, 'do_no');



?>



<tr>



<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  SALES ORDER IS COMPLETE</strong></td>



</tr>



<? }else{

$chalaned = find_a_field('sale_do_chalan','sum(dist_unit)','do_no="'.$do_no.'"');

if($chalaned>0){

?>

<tr>

<td align="center" colspan="2"><input name="confirm" type="submit" class="btn1" value="CONFIRM CHALLAN" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>



</tr>





<? } else{?>

<tr>



<td align="center"><input name="return" type="submit" class="btn1 btn1-bg-cancel" value="RETURN" onclick="return_function()" />



<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/><input type="hidden" name="return_remarks" id="return_remarks"></td>



<td align="center"><input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM CHALLAN"  /></td>



</tr>

<? } }?>



</table>



<? }?>



</form>



</div><?php */?>



<script>$("#codz").validate();$("#cloud").validate();</script>

<script>

function return_function() {

  var notes = prompt("Why Return This?","");

  if (notes!=null) {

    document.getElementById("return_remarks").value =notes;

	document.getElementById("cz").submit();

  }

  return false;

}

</script>



<?



require_once SERVER_CORE."routing/layout.bottom.php";




?>