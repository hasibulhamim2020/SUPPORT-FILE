<?php

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


$title='Cheque  Approval';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');
?>

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

var ra=(document.getElementById('ra_'+id).value)*1;

var flag=(document.getElementById('flag_'+id).value); 

if(ra>0){

var strURL="received_amt_ajax.php?item_id="+item_id+"&ra="+ra+"&flag="+flag;}

else

{

alert('Receive Amount Must be Greater Than Zero.');

document.getElementById('ra_'+id).value = '';

document.getElementById('ra_'+id).focus();

return false;

}



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
<div class="row bg-form-titel">
    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> From Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                       <input name="do_date_fr" type="text" id="do_date_fr" class="form-control" value="<?=date('Y-m-01');?>" required autocomplete="off"/>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input name="do_date_to" type="text" id="do_date_to" value="<?=date('Y-m-d');?>" class="form-control"  required autocomplete="off"/>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select name="checked" id="checked" class="form-control">
	
						  <option <?=($_POST['checked']=='NO')?'Selected':'';?> value="NO">UN-CHECKED</option>
	
						  <option <?=($_POST['checked']=='YES')?'Selected':'';?> value="YES" >PRINTED</option>
						  
						  <option <?=($_POST['checked']=='CANCELLED')?'Selected':'';?>>CANCELLED</option>

                    </select>
                    </div>
                </div>

            </div>
			<? $ledger_group_id=124002; ?>
			            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Accounts</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select name="issue_from_ac"   type="text" id="issue_from_ac" class="form-control" />
								    <option></option>
									<? 
									
									foreign_relation('accounts_ledger','ledger_id','concat(ledger_id,"  ",ledger_name)',$issue_from_ac,'ledger_group_id="'.$ledger_group_id.'"');
									
									
									
									
									?>
								</select>
                    </div>
                </div>

            </div>
            
			
			
			<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1">
			<div class="form-group row m-0">
                   <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cheque No :</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input name="cheq_no" id="cheq_no" type="text" value="" class="form-control" />
                    </div>
                </div>
			 </div>
			
			
			
			
			
			
        </div>
    </div>
    
    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 pt-3">
        
        <input type="submit" name="submitit" id="submitit" value="Voucher View" class="btn1 btn1-bg-submit"/>
    </div>
</div>


	<div class="container-fluid pt-5 p-0 ">

			<table width="1215" class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					 <th width="23">SL</th>

					  <!--<th>TR No #</th>-->
				
					  <th width="61">JV No #</th>
				
					  <!--<th>JV Date </th>-->
					  <th width="87">Issue From </th>
					  <th width="209">Entry Date  </th>
				
					  <!--<th>TR From </th>-->
					  <th width="87">CHQ No. </th>
					  <th width="90">CHQ Name </th>
					  <th width="245">CHQ Date </th>
					  <th width="65">Amount </th>
				
					  <!--<th>CR Amt </th>-->
					  <th width="74">CHQ Type </th>
					  <th width="129">Cheque</th>
				
					  <th width="97">CHQ Status </th>
				</tr>
				</thead>

				<tbody class="tbody1">

				<?





		 if($_POST['do_date_fr']!=''){

	  $i=0;
		
		if($_POST['issue_from_ac']!='') $bank_con = ' and j.ledger_id="'.$_POST['issue_from_ac'].'" ';
		
		if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';

	 	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

		if($_POST['depot_id']>0) $depot_con = ' and w.warehouse_id="'.$_POST['depot_id'].'" ';
		
		 if($_POST['cheq_no']>0) 
		 $cheque_no_con = ' and j.cheq_no="'.$_POST['cheq_no'].'" ';

		if($_POST['voucher_type']!='') {$voucher_type_con=' and j.tr_from="'.$_POST['voucher_type'].'"';}
		$tr_type="Search";
		
        

	    $sql=" select DISTINCT j.tr_no, j.jv_no, j.jv_date, sum(j.dr_amt) as dr_amt, sum(j.cr_amt) as cr_amt, j.tr_from, u.fname, j.entry_at, j.checked, j.secondary_approval
		  	, cheq_no, cheq_date, j.received_from, j.type, DATE(j.entry_at) AS just_date,j.ledger_id
				

				FROM

				 cheque_secondary_journal j, accounts_ledger l, user_activity_management u 
				  
			

				WHERE


				 j.cr_amt>0 and j.entry_by = u.user_id AND j.tr_from like 'Cheque Issue' and
				
	

				  j.jv_date between '". $_POST['do_date_fr']."' AND  '". $_POST['do_date_to']."' AND 

				  j.ledger_id = l.ledger_id ".$group_s.$checked_con.$depot_con.$voucher_type_con.$cheque_no_con.$bank_con." group by j.jv_no order by j.jv_no desc";

	  $query=db_query($sql);

	  

	  while($data=mysqli_fetch_row($query)){
$received = $received + $data[1];
	  ?>



      <tr class="alt">

      <td align="center">

        <?=++$i;?>     </td>

      <!--<td align="center"><? echo $data[0];?></td>-->

      <td align="center"><? echo $data[1];?></td>

      <!--<td align="center"><?= date('d-m-Y',strtotime($data[2]));?></td>-->

      <!--<td align="center"><? echo find_a_field('cheque_secondary_journal','max(tr_no)','1');?></td>-->
	   <td align="center">
	  <? $issueFrom = find_a_field('cheque_secondary_journal','ledger_id','jv_no="'.$data[1].'" and cr_amt>0');
	  	 $issueTo = find_a_field('cheque_secondary_journal','ledger_id','jv_no="'.$data[1].'" and dr_amt>0');
		 echo find_a_field('accounts_ledger','ledger_name','ledger_id="'.$issueFrom.'"');
	  ?></td>
	  
	  <td align="center"><? echo $data[14];?></td>
	  <td align="center"><? echo $data[10];?></td>
	  <td align="center"><? echo $data[12];?></td>
      <td align="center"><? echo $data[11];?></td>
      <!--<td align="center"><? echo number_format($data[3],2); $total_dr +=$data[3];?></td>-->

      <td align="center"><? echo number_format($data[4],2); $total_cr +=$data[4];?></td>
      <td align="center"><? echo $data[13];?></td>

      <td align="center"> <a href="cheque_print.php?jv_no=<?php echo $data[1];?>" target="_blank"><img src="../images/cheque.jpg" width="16" height="16" border="0"></a>
	  
	  <!--<a target="_blank" href="general_voucher_print_view_for_approval.php?jv_no=<?=$data[1] ?>"><img src="../images/print.png" width="20" height="20" /></a>--></td>

      <td align="center"><span id="divi_<?=$data[1]?>">

            <? 

						  if(($data[8]=='YES')){
			
			?>
			
			<input type="button" name="Button" value="YES"  onclick="window.open('general_voucher_print_view_for_cheque.php?jv_no=<?=$data[1] ?>');" class="btn1 btn1-bg-submit"/>
			
			<?
			
			}elseif(($data[8]=='NO')){
			
			?>
			
			<input type="button" name="Button" value="NO"  onclick="window.open('cheque_issue_approve.php?jv_no=<?=$data[1] ?>');" class="btn1 btn1-bg-cancel" />
			
			<? }elseif(($data[8]=='CANCELLED')){
			
			?>
			
			<input type="button" name="Button" value="CANCELLED"  onclick="window.open('cheque_issue_cancelled.php?jv_no=<?=$data[1] ?>');" class="btn1 btn1-bg-cancel" />
			
			<? }?>
			
			
					  </span></td>
				  </tr>
			
				  <? }}?>
				  <tr class="alt">

        <td align="center">&nbsp;</td>

        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
        <td align="center"><strong>Total</strong></td>
<!--        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>-->
<!--        <td align="center"><strong><?= number_format($total_dr,2);?></strong></td>-->
        <td align="center"><strong><?= number_format($total_cr,2);?></strong></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>

        <td align="center">&nbsp;</td>
      </tr>
				</tbody>
	  </table>





  </div>

</form>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
