<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Rejected Voucher Log';
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
                       <input name="do_date_fr" type="text" id="do_date_fr" class="form-control" value="<?=$_POST['do_date_fr']?>" required autocomplete="off"/>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" class="form-control"  required autocomplete="off"/>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select name="checked" id="checked" class="form-control">

						  <option></option>
	
						  <option <?=($_POST['checked']=='NO')?'Selected':'';?>>No</option>
	
						  <option <?=($_POST['checked']=='YES')?'Selected':'';?>>Yes</option>

                    </select>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Voucher Type</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select name="voucher_type" id="voucher_type" class="form-control">
							<option></option>
			
							  <? foreign_relation('voucher_config','voucher_type','voucher_type',$_POST['voucher_type'],'1');?>
			
						</select>

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

			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					 <th>SL</th>

					  <th>TR No #</th>
				
					  <th>JV No #</th>
				
					  <th>JV Date </th>
				
					  <th>TR From </th>
					  <th>DR Amt </th>
				
					  <th>CR Amt </th>
					  <th>Entry By </th>
				
					  <th>Entry At </th>
				
					  <th>&nbsp;</th>
				
				</tr>
				</thead>

				<tbody class="tbody1">

				<?





		 if($_POST['do_date_fr']!=''){

	  $i=0;

		if($_POST['checked']!='') $checked_con = ' and j.secondary_approval="'.$_POST['checked'].'" ';

	 	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

		if($_POST['depot_id']>0) $depot_con = ' and w.warehouse_id="'.$_POST['depot_id'].'" ';

		if($_POST['voucher_type']!='') {$voucher_type_con=' and j.tr_from="'.$_POST['voucher_type'].'"';}
		


		    $sql=" select DISTINCT j.tr_no, j.jv_no, j.jv_date, sum(j.dr_amt) as dr_amt, sum(j.cr_amt) as cr_amt, j.tr_from, u.fname, j.entry_at, j.checked, j.secondary_approval
				

				FROM

				 secondary_journal_del j, accounts_ledger l, user_activity_management u 
				  
			


				WHERE
j.tr_from in('Payment','Receipt','Journal','Contra') and
				 j.entry_by = u.user_id AND
				
	

				  j.jv_date between '". $_POST['do_date_fr']."' AND  '". $_POST['do_date_to']."' AND j.checked!='Unfinished'

				  AND j.ledger_id = l.ledger_id ".$group_s.$checked_con.$depot_con.$voucher_type_con." group by j.jv_no";

	  $query=db_query($sql);

	  

	  while($data=mysqli_fetch_row($query)){
$received = $received + $data[1];
	  ?>



      <tr class="alt">

      <td align="center">

        <?=++$i;?>

     </td>

      <td align="center"><? echo $data[0];?></td>

      <td align="center"><? echo $data[1];?></td>

      <td align="center"><?= date('d-m-Y',strtotime($data[2]));?></td>

      <td align="center"><? echo $data[5];?></td>
      <td align="center"><? echo number_format($data[3],2); $total_dr +=$data[3];?></td>

      <td align="center"><? echo number_format($data[4],2); $total_cr +=$data[4];?></td>
      <td align="center"><? echo $data[6];?></td>

      <td align="center"><? echo $data[7];?></td>

      <td align="center"><a target="_blank" href="general_voucher_print_view_for_del.php?jv_no=<?=$data[1]?>"><img src="../images/print.png" width="20" height="20" /></a></td>

				  </tr>
			
				  <? }}?>
				  <tr class="alt">

        <td align="center">&nbsp;</td>

        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center"><strong>Total</strong></td>
        <td align="center"><strong><?= number_format($total_dr,2);?></strong></td>
        <td align="center"><strong><?= number_format($total_cr,2);?></strong></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>

      </tr>

				</tbody>
			</table>





		</div>

</form>


<br /><br />


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

