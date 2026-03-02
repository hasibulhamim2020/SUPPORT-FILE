<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type="Show";
do_calander("#to_date");

do_calander("#from_date");





error_reporting(E_ERROR | E_WARNING | E_PARSE);



$title='Sales Target Setup (SR Wise)';

$proj_id=$_SESSION['proj_id'];

$now=time();



if(isset($_POST['add'])){

$cd= new crud('sales_target');

$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date("Y-m-d H:i:s");


foreach ($_POST['forLoopss'] as $fordata){


 $_POST['item_id']=$fordata;

 $_POST['unit_name']=$_POST['unit_name_'.$_POST['item_id']];
 
 $_POST['target_amount_ip']=$_POST['d_price_amt_'.$_POST['item_id']];
 



 $_POST['qty']=$_POST['qty_'.$_POST['item_id']];


 if( $_POST['qty']!='' ){

 
    $exist=find_a_field('sales_target','id','sales_person="'.$_POST['sales_person'].'" and to_date="'.$_POST['to_date'].'" and from_date="'.$_POST['from_date'].'" and item_id="'.$_POST['item_id'].'" ');
   

if($exist>0){
////Here I put same target for dealer and SR
$up='update sales_target set qty="'.$_POST['qty'].'",target_amount_ip="'.$_POST['target_amount_ip'].'",target_amount_tp="'.$_POST['target_amount_ip'].'"  where id='.$exist;
db_query($up);

}else{

  $cd->insert();
  }
  
  }
  
  }
  

  
  }
?>



<style type="text/css">



<!--



.style2 {



	color: #0000FF;



	font-weight: bold;



}



.style3 {



	color: #006600;



	font-weight: bold;



}



.style4 {



	color: #FFFFFF;



	font-weight: bold;



}



.style5 {



	color: #000033;



	font-weight: bold;



}

.style6 {color: #FFFFFF}



-->



</style>



<script>







function getXMLHTTP() { //fuction to return the xml http object







		var xmlhttp=false;	







		try{







			xmlhttp=new XMLHttpRequest();







		}







		catch(e)	{		







			try{			







				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");



			}



			catch(e){







				try{







				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");







				}







				catch(e1){







					xmlhttp=false;







				}







			}







		}







		 	







		return xmlhttp;







    }







	function update_value(id)







	{







var item_id=id; // Rent





var dr=(document.getElementById('dr_'+id).value)*1; 



var opdate=(document.getElementById('op_date').value);



var narration=(document.getElementById('narration_'+id).value); 



var flag=(document.getElementById('flag_'+id).value); 







var strURL="opening_budget_ajax.php?item_id="+item_id+"&dr="+dr+"&opdate="+opdate+"&narration="+narration+"&flag="+flag;







		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {



				if (req.readyState == 4) {



					// only if "OK"



					if (req.status == 200) {						



						document.getElementById('divi_'+id).style.display='inline';



						document.getElementById('divi_'+id).innerHTML=req.responseText;						



					} else {



						alert("There was a problem while using XMLHTTP:\n" + req.statusText);



					}



				}				



			}



			req.open("GET", strURL, true);



			req.send(null);



		}	







}







</script>











	<form id="form2" name="form2" method="post" action="">

<div class="form-container_large">



		<div class="container-fluid bgc-yello1">

			<div class="row">
			
			<div class="col-6">

				<div class=" pt-1 pb-1">

					<div class="form-group row m-0 pb-1 pt-1">

						<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date</label>

						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

							<input name="from_date" type="text" class="required " id="from_date"  

value="<?=date("Y-m-01");?>"  required autocomplete="off"/>

						</div>

					</div>
					
					
					<div class="form-group row m-0 pb-1 pt-1">

			<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Distributor List</label>

						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

		<input list="dfg" name="dealer_code" type="text" class="required " id="dealer_code"    required autocomplete="off"/>
		
		<datalist id="dfg">
		
		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1');?>
		
		</datalist>

						</div>

					</div>
					
					
					
					</div>
					
					</div>
					
					<div class="col-6">
					
					<div class=" pt-1 pb-1">
					
					<div class="form-group row m-0 pb-1 pt-1">

						<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TO  Date</label>

						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

							<input name="to_date" type="text" class="required " id="to_date"  value="<?=date("Y-m-31");?>" required autocomplete="off"/>


						</div>

					</div>
					
					<div class="form-group row m-0 pb-1 pt-1">

<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SR List</label>

						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
						
						<span id="ress1">


		<select name="sales_person" type="text" class="required " id="sales_person"  value="<?=$_POST['sales_person']?>"  required autocomplete="off">
		
	
		<option></option>
		<? //foreign_relation('ss_user','user_id','concat(fname,"##",point_id)',$sales_person,'1');?>
		
		</select>
		
		</span>

						</div>

					</div>
					
					
					</div>
					
					</div>
					
					



					<div class="form-group row m-0 pb-1 pt-1">

						<?



								if($_POST['group_id']>0){

				

								$sql="select sum(j.dr_amt),sum(j.cr_amt) from budget_balance j, accounts_ledger a where a.ledger_id=j.ledger_id and j.tr_from='Opening' and a.ledger_group_id = '".$_POST['group_id']."' ";

				

								$query=db_query($sql);

				

								$info=mysqli_fetch_row($query);

				

								$diff=$info[0]-$info[1];

				

								if($diff<0) $diff='('.$diff*(-1).')';

				

								}

				

						?>

						<!--<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Opening Balance Differ</label>

						<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

							<input name="customer_company" type="text" class="required " id="customer_company" value="<?=$diff?>" />

						</div>-->

					</div>



				</div>



				<!--<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-2 pb-3 bgc-violate">

					<h4 class="text-center bold">Total Debit </h4>

					<input name="t_debit" type="text" id="t_debit" value="<?=$info[0]?>" class="required"  />

				</div>



				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-2 pb-3 bgc-light-green">

					<h4 class="text-center bold">Total Credit </h4>

					<input name="t_credit" type="text" id="t_credit" value="<?=$info[1]?>" class="required" minlength="4"/>

				</div>-->



			</div>

		</div>







		<div class="container-fluid bg-form-titel mt-2">

			<div class="row">

<div class="col-3 text-right">Select Group</div>

<div class="col-6">

<select name="item_groups" id="item_groups" >

<option></option>

<? foreign_relation('item_group','group_id','group_name',$item_groups,'group_id in(300000000,400000000,500000000,600000000,900000000,1000000000)')?>

</select>



</div>

</div>

		</div>













		<div class="container-fluid pt-5 p-0 ">



			<table class="table1  table-striped table-bordered table-hover table-sm">

				<thead class="thead1">

				<tr class="bgc-info">

					<th>SL</th>

					<th>Item Id</th>

					<th>Item Name</th>

					<th>Unit</th>
					
					<th>IP Price</th>
					
				 

					<th>Target Qty</th>
					
					<th>IP Amount</th>
					
				 

				</tr>

				</thead>



				<tbody class="tbody1" id="ress">
				
				
				</tbody>

			</table>

		</div>
		
		
<div class="text-center">



<input type="submit" class="btn btn-success" name="add" value="Set target" />

</div>



</div>


	</form>

<script>

$(document).ready(function() {



  $("#item_groups").change(function() {

  

	var group= $(this).val();

	var to_date=$('#to_date').val();

	var from_date=$('#from_date').val();
	
	var sales_person=$('#sales_person').val();
	
	var distibutor= $('#dealer_code').val();

	

	if(sales_person!='' && sales_person>0 && distibutor!='' && distibutor>0){	

	$.ajax({

		  url: "do_item_ajax.php",

		  type: "POST",

		  data: {group:group,to_date:to_date,from_date:from_date,sales_person:sales_person},

		  success: function(data){

		$("#ress").html(data);

 		 }

	});
	
	}else{
	
	alert("Select a Distributor & SR");
	}

  });
  
  
  $("#dealer_code").change(function() {
  
   var code= $(this).val();
   
   	$.ajax({

		  url: "sr_ajax.php",

		  type: "POST",

		  data: {dealer_code:code},

		  success: function(data){

		$("#ress1").html(data);

 		 }

	});
   
   
  
   });


});




</script>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>



