<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type="Show";




$c_id = $_SESSION['proj_id'];
$title='Purchase Return Verification';
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



















<form id="form2" name="form2" method="post" action="">
	<div class="form-container_large">

		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">

						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR Verification Date :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="do_date_fr" type="text" id="do_date_fr" class="form-control" value="<? if($_POST['do_date_fr']!='') echo $_POST['do_date_fr']; else echo date ('Y-m-01')?>" required autocomplete="off"/>
							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR Date To :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								 <input name="do_date_to" type="text" id="do_date_to" value="<? if($_POST['do_date_to']!='') echo $_POST['do_date_to']; else echo date ('Y-m-d')?>" class="form-control"  required autocomplete="off"/>
							</div>
						</div>
						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked :</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<span class="oe_form_group_cell">
										<select name="checked" id="checked" class="form-control">
											<option></option>
											<option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
											<option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
											<?php /*?><option <?=($_POST['checked']=='PROBLEM')?'Selected':'';?>>PROBLEM</option><?php */?>
										</select>
									</span>
							</div>
						</div>




					</div>
				</div>

				<!--Right form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">


						<?php /*?><div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Region Wise : </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<span class="oe_form_group_cell" >
											<select name="region_id[]" id="region_id[]" class="form-control">if (in_array("Irix", $os))
												<? //foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['region_id'],' 1 order by BRANCH_NAME');
												echo $sql = 'select BRANCH_ID,BRANCH_NAME from branch where  1 order by BRANCH_NAME';
												$query = db_query($sql);
												while($info = mysqli_fetch_object($query)){
													?>
													<option></option>
													<option value="<?=$info->BRANCH_ID?>" <?=(@in_array($info->BRANCH_ID, $_POST['region_id']))?'Selected':'';?>><?=$info->BRANCH_NAME?></option>
													<?
												}
												?>
											</select>
										</span>
							</div>
						</div><?php */?>

						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depot : </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<span class="oe_form_group_cell" >
									  <select name="depot_id" id="depot_id" class="form-control">
										  <option></option>
										  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'use_type="WH" order by warehouse_name');?>
									  </select>
									</span>
							</div>
						</div>



					</div>
				</div>


			</div>


			<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input type="submit" name="submitit" id="submitit" value="View Chalan" class="btn1 btn1-submit-input" />
				</div>

			</div>

		</div>





		<div class="container-fluid pt-5 p-0 ">


			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">


				<tr class="bgc-info">

					<th>SL</th>

					<th>PR#</th>
					<th>CH#</th>
					<th>Dealer Name</th>
					<th>Entry At</th>
					<th>Entry By </th>
					<th>Return Amt</th>
					<th>&nbsp;</th>
					<th>Checked?</th>
				</tr>
				</thead>

				<tbody class="tbody1">


				<?
				if($_POST['do_date_fr']!=''){
					$tr_type="Search";
					$i=0;
					// $datefr = $_POST['do_date_fr'];
					// $dateto = $_POST['do_date_to'];
					$datefr = $_POST['do_date_fr'];
					$dateto =$_POST['do_date_to'];
					//$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));
					//$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));
					$return_sql = 'select * from purchase_return_type where 1';
					$qry = db_query($return_sql);
					$t=0;
					while($rd=mysqli_fetch_object($qry)){
						if($t>0){
							$return_type .= ',';
						}
						$return_type .="'";
						$return_type .= $rd->return_type;
						$return_type .="'";
						$t++;

					}

					if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

					if($depot_id>0) $depot_con = 'and d.group_for='.$depot_id;
					if($_POST['checked']!='') $depot_con .= ' and j.checked="'.$_POST['checked'].'"';
					  $sql="SELECT
				  j.tr_no,
				  sum(1) as co,
				  sum(j.dr_amt) as cr_amts,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_id,
				  u.fname,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  j.dr_amt
				FROM
				  secondary_journal j,
				  accounts_ledger l,
				  vendor d,
				  user_activity_management u
				WHERE
				  j.tr_from in ('Purchase Return','return') AND
				  j.dr_amt >0 AND
				  j.jv_date  between '".$datefr."' AND '".$dateto."' AND
				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con."
				group by  j.tr_no";
					$query=db_query($sql);

					while($data=mysqli_fetch_object($query)){
						$received = $received + $data->dr_amt;
						?>

						<tr <?=($i%2==0)?'class="alt"':'';?>>
							<td><?=++$i;?></td>
							<td><? echo $data->tr_no;?></td>
							<td><? echo $data->tr_no;?></td>
							<td><? echo $data->ledger_name;?></td>
							<td><? echo $data->entry_at;?></td>
							<td><? echo $data->fname;?></td>
							<td><?=number_format($data->dr_amt,2);?></td>
							
							<?php /*?><td><a target="_blank" href="prr_sec_print_view.php?jv_no=<?=rawurlencode(url_encode($data->jv_no)) ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td><?php */?>
							
							
							<td><a target="_blank" href="prr_sec_print_view.php?c=<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($data->jv_no));?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
							
							
							
							<td>
								<span id="divi_<?=$data->tr_no?>">
									<?
									if(($data->checked=='YES')){
										?>
										
										<?php /*?><input type="button" name="Button" value="YES"  onclick="window.open('prr_sec_print_view.php?jv_no=<?=rawurlencode(url_encode($data->jv_no));?>');" class="btn1 btn1-bg-submit"/><?php */?>
										
										
										<input type="button" name="Button" value="YES"  onclick="window.open('prr_sec_print_view.php?c=<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($data->jv_no));?>');" class="btn1 btn1-bg-submit"/>
										
										
										
   
  
										<?
									}elseif(($data->checked !='YES')){
										?>
										<input type="button" name="Button" value="NO"  onclick="window.open('prr_sec_print_view.php?c=<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($data->jv_no));?>');" class="btn1 btn1-bg-cancel"/>
									<? }?>
								</span>							</td>
						</tr>
					<? }}?>

				<tr>
					<td colspan="6" align="center">
						<div align="right">
							<strong>Total Amt : </strong>						</div>					</td>
					<td align="right"><?=number_format($received,2);?></td>
					<td></td>
					<td></td>
				</tr>
				</tbody>
			</table>





		</div>

 

	</div>

</form>








<?/*>
<br>
<br>
<br>
<br>
<br>



				<form id="form2" name="form2" method="post" action="">	

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td><table width="75%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">
              <tr>
                <td><div align="right"><strong>PR Verification Date :</strong></div></td>
                <td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" class="form-control"/>
                 </td>
                <td>-to-</td>
                <td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" class="form-control"/></td>
                <td rowspan="4">
					<label>
                  <input type="submit" name="submitit" id="submitit" value="View Chalan" class="btn1 btn1-submit-input" />
                </label>
				</td>
              </tr>
              <tr>
                <td><div align="right"><strong>Checked : </strong></div></td>
                <td colspan="3"><div align="left">
						<span class="oe_form_group_cell">
                    <select name="checked" id="checked" class="form-control">
                      <option></option>
					  <option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
					  <option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
					  <option <?=($_POST['checked']=='PROBLEM')?'Selected':'';?>>PROBLEM</option>
                    </select>
                </span>
					</div></td>
                </tr>
              <tr>
                <td><div align="right"><strong>Region Wise  : </strong></div></td>
                <td colspan="3"><div align="left">

						<span class="oe_form_group_cell" >
                    <select name="region_id[]" id="region_id[]" class="form-control">if (in_array("Irix", $os))
                      <? //foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['region_id'],' 1 order by BRANCH_NAME');
					echo $sql = 'select BRANCH_ID,BRANCH_NAME from branch where  1 order by BRANCH_NAME';
					  $query = db_query($sql);
					  while($info = mysqli_fetch_object($query)){
					  ?>
					  <option></option>
					  <option value="<?=$info->BRANCH_ID?>" <?=(@in_array($info->BRANCH_ID, $_POST['region_id']))?'Selected':'';?>><?=$info->BRANCH_NAME?></option>
					  <?
					  }
					  ?>
                    </select>
                </span>
				
				</div></td>
                </tr>
              <tr>
                <td><div align="right"><strong> Depot : </strong></div></td>
                <td colspan="3"><div align="left">
						<span class="oe_form_group_cell" >
                  <select name="depot_id" id="depot_id" class="form-control">
				    <option></option>
                    <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'use_type="SD" order by warehouse_name');?>
                  </select>
                </span>

					</div></td>
                </tr>
              
            </table></td>
	    </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td>
      <table width="98%" align="center" cellspacing="0" class="tabledesign">
      <tbody>
      <tr>
      <th>SL</th>
	  
      <th>PR#</th>
      <th>CH#</th>
      <th>Dealer Name</th>
      <th>Entry At</th>
      <th>Entry By </th>
      <th>Return Amt</th>
      <th>&nbsp;</th>
      <th>Checked?</th>
      </tr>


	  <?
	if($_POST['do_date_fr']!=''){
	  $i=0;
$datefr = $_POST['do_date_fr'];
$dateto = $_POST['do_date_to'];
$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));
$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));
$return_sql = 'select * from purchase_return_type where 1';
$qry = db_query($return_sql);
$t=0;
while($rd=mysqli_fetch_object($qry)){
if($t>0){
$return_type .= ',';
}
$return_type .="'";
$return_type .= $rd->return_type;
$return_type .="'";
$t++;

}

	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];
		
	if($depot_id>0) $depot_con = 'and d.depot='.$depot_id;
	     $sql="SELECT
				  j.tr_no,
				  sum(1) as co,
				  sum(j.dr_amt) as cr_amts,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_id,
				  u.fname,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  j.dr_amt
				FROM
				  secondary_journal j,
				  accounts_ledger l,
				  vendor d,
				  user_activity_management u
				WHERE
				   
				  d.ledger_id = l.ledger_id and 
				  j.tr_from in (".$return_type.") AND 
				  j.dr_amt >0 AND 
				  j.jv_date  between '".$datefr."' AND '".$dateto."' AND 
				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con."
				group by  j.tr_no";
	  $query=db_query($sql);
	  
	  while($data=mysqli_fetch_object($query)){
	  $received = $received + $data->cr_amt;
	  ?>

      <tr <?=($i%2==0)?'class="alt"':'';?>>
      <td align="center"><div align="left"><?=++$i;?></div></td>
      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
      <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>
      <td align="center"><div align="left"><? echo $data->entry_at;?></div></td>
      <td align="center"><div align="left"><? echo $data->fname;?></div></td>
      <td align="right"><?=number_format($data->dr_amt,2);?></td>
      <td align="center"><a target="_blank" href="sr_sec_print_view.php?jv_no=<?=$data->jv_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
      <td align="center"><span id="divi_<?=$data->tr_no?>">
<? 
if(($data->checked=='YES')){
?>
<input type="button" name="Button" value="YES"  onclick="window.open('prr_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" class="btn1 btn1-bg-submit"/>
<?
}elseif(($data->checked !='YES')){
?>
<input type="button" name="Button" value="NO"  onclick="window.open('prr_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" class="btn1 btn1-bg-cancel"/>
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
  </td>
	    </tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>
		<div>
                    
		<table width="100%" border="0" cellspacing="0" cellpadding="0">		
		<tr>		
		<td>
		<div style="width:380px;"></div></td>
		</tr>
		</table>
	        </div>
		</td>
		</tr>
      </table>
	</td>
  </tr>
</table>
</form>



<*/?>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
