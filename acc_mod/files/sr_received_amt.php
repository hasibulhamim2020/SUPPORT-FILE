<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";



$c_id = $_SESSION['proj_id'];
$title='Sales Return Verification';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');

$depot_id = $_POST['depot_id'];
?>
<script>

function getXMLHTTP() {

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


<form id="form1" name="form1" method="post" action="">
    <div class="form-container_large">
       
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SR Date From</label>
                           
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                               <input name="do_date_fr" type="text" id="do_date_fr" class="form-control" value="<? if($_POST['do_date_fr']!='') echo $_POST['do_date_fr']; else echo date ('Y-m-01')?>" required autocomplete="off"/>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SR To </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                 <input name="do_date_to" type="text" id="do_date_to" value="<? if($_POST['do_date_to']!='') echo $_POST['do_date_to']; else echo date ('Y-m-d')?>" class="form-control"  required autocomplete="off"/>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1" style="display:none;">
    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Region Wise </label>
    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
        <select name="region_id" id="region_id" class="form-control">
            <?
              $sql = 'select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME';
              $query = db_query($sql);
              while($info = mysqli_fetch_object($query)){
            ?>
            <option></option>
            <option value="<?=$info->BRANCH_ID?>" <?=($info->BRANCH_ID==$_POST['region_id'])?'Selected':'';?>>
                <?=$info->BRANCH_NAME?>
            </option>
            <? } ?>
        </select>
    </div>
</div>





                    </div>
                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                      

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SR Depot </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="depot_id" id="depot_id" class="form-control">
								<option></option>
								<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'1 order by warehouse_name');?>
							  </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="checked" id="checked" class="form-control">
								  <option></option>
								  <option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
								  <option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
								  <option <?=($_POST['checked']=='PROBLEM')?'Selected':'';?>>PROBLEM</option>
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
		
		
		
		
		
		
		<div class="container-fluid pt-5 p-0 ">


				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					
					
					<tr class="bgc-info">
					
					
						  <th>SL</th>
	  
						  <th>DO#</th>
						  <th>CH#</th>
						  <th>Dealer Name</th>
						  <th>Chalan At</th>
						  <th>Chalan By </th>
						  <th>Chalan Amt</th>
						  <th>&nbsp;</th>
						  <th>Checked?</th>

     
					</tr>
					</thead>

					<tbody class="tbody1">
					
					<?
	if($_POST['do_date_fr']!=''){
	  $tr_type="Search";
	  $i=0;
	  $datefr = $_POST['do_date_fr'];
	  $dateto = $_POST['do_date_to'];
//$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));
//$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));
$return_sql = 'select * from sales_return_type where 1';
$qry = db_query($return_sql);
$t=0;
while($rd=mysqli_fetch_object($qry)){
if($t>0){
$return_type .= ',';
}
$return_type .="'";
$return_type .= $rd->sales_return_type;
$return_type .="'";
$t++;
}
	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];
		
	if($depot_id>0) $depot_con = 'and d.depot='.$depot_id;
	 $sql="SELECT
				  j.tr_no,
				  sum(1) as co,
				  sum(j.cr_amt) as cr_amts,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_id,
				  u.fname,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  j.cr_amt
				FROM
				  secondary_journal j,
				  accounts_ledger l,
				  dealer_info d,
				  user_activity_management u
				WHERE
				   
				  d.account_code = l.ledger_id and 
				  j.tr_from in (".$return_type.") AND 
				  j.cr_amt >0 AND 
				  j.jv_date  between '".$datefr."' AND '".$dateto."' AND 
				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con."
				group by  j.tr_no";
	  $query=db_query($sql);
	  
	  while($data=mysqli_fetch_object($query)){
	  $received = $received + $data->cr_amt;
	  ?>

      <tr <?=($i%2==0)?'class="alt"':'';?>>
      <td align="center"><div align="left"><?=++$i;?></div></td>
      <td align="center"><div align="left"><? echo $data->tr_id;?></div></td>
      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
      <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>
      <td align="center"><div align="left"><? echo $data->entry_at;?></div></td>
      <td align="center"><div align="left"><? echo $data->fname;?></div></td>
      <td align="right"><?=number_format($data->cr_amt,2);?></td>
	  
 <!--     <td align="center"><a target="_blank" href="sr_sec_print_view.php?jv_no=<?=rawurlencode(url_encode($data->jv_no))?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>-->
	  
	  
	   <td align="center"><a target="_blank" href="sr_sec_print_view.php?c=<?=rawurlencode(url_encode($c_id))?>&v=<?=rawurlencode(url_encode($data->jv_no))?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
	  
      <td align="center"><span id="divi_<?=$data->tr_no?>">
<? 
if(($data->checked=='YES')){
?>

<!--<input type="button" name="Button" value="YES"  onclick="window.open('sr_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" class="btn1 btn1-bg-submit"/>-->

<input type="button" name="Button" value="YES"
  onclick="window.open('sr_sec_print_view.php?c=<?=rawurlencode(url_encode($c_id))?>&v=<?=rawurlencode(url_encode($data->jv_no))?>');"
  class="btn1 btn1-bg-submit"/>


<?
}elseif(($data->checked !='YES')){
?>

<!--<input type="button" name="Button" value="NO"  onclick="window.open('sr_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" class="btn1 btn1-bg-cancel"/>-->

<input type="button" name="Button" value="NO"
  onclick="window.open('sr_sec_print_view.php?c=<?=rawurlencode(url_encode($c_id))?>&v=<?=rawurlencode(url_encode($data->jv_no))?>');"
  class="btn1 btn1-bg-cancel"/>


<? }?>
          </span></td>
      </tr>
	  <? }}?>
				 <tr class="alt">
					<td colspan="6" align="center"><div align="right"><strong>Total Amt : </strong></div>
					  
						<div align="left"></div></td>
					<td align="right"><?=number_format($received,2);?></td>
					<td align="center">&nbsp;</td>
					<td align="center"><div align="left"></div></td>
				  </tr>

					</tbody>
				</table>





			</div>


        
    </div>

</form>

	
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
