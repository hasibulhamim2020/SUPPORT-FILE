<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type ="Show";


$c_id = $_SESSION['proj_id'];
$title='Chalan Varification';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');
$depot_id = $_POST['depot_id'];
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
<style>
.form-group{
	margin-bottom:3px!important;
	}
	.col-md-4{	
		padding-top:10px;
		}
</style>





<div class="form-container_large">
    
    <form id="form2" name="form2" method="post" action="">
           
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Date</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                           <input name="do_date_fr" type="text" id="do_date_fr" class="form-control" value="<? if($_POST['do_date_fr']!='') echo $_POST['do_date_fr']; else echo date ('Y-m-01')?>" required autocomplete="off"/>
                        </div>
                    </div>

                </div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Date To</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                             <input name="do_date_to" type="text" id="do_date_to" value="<? if($_POST['do_date_to']!='') echo $_POST['do_date_to']; else echo date ('Y-m-d')?>" class="form-control"  required autocomplete="off"/>
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="checked" id="checked" class="form-control">
							  <option></option>
							  <option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
							  <option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
							</select>
                        </div>
                    </div>

                </div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer Type</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="dealer_type" id="dealer_type" class="form-control">
							<option value=""  <?=($_POST['dealer_type']=='')?'Selected':'';?>>All</option>
							<option value="Distributor"  <?=($_POST['dealer_type']=='Distributor')?'Selected':'';?>>Distributor</option>
							<option value="Corporate"    <?=($_POST['dealer_type']=='Corporate')?'Selected':'';?>>Corporate</option>
							<option value="SuperShop"    <?=($_POST['dealer_type']=='SuperShop')?'Selected':'';?>>SuperShop</option>
							<option value="TradeFair"    <?=($_POST['dealer_type']=='TradeFair')?'Selected':'';?>>TradeFair</option>
						  </select>
                        </div>
                    </div>

                </div>

                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depot</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="depot_id" id="depot_id" class="form-control">
                                <option value=""></option>
                                <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot_id'],'1 order by warehouse_id');?>
                            </select>
                        </div>
                    </div>
                </div>

				
                </div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer Group</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="dealer_group" id="dealer_group" class="form-control" >
							   <option value="<?=$_POST['dealer_group']?>"><?=$_POST['dealer_group']?></option>
							   <option value=""></option>
							   <option value="A">A</option>
							   <option value="B">B</option>
							   <option value="C">C</option>
							   <option value="D">D</option>
							   <option value="E">E</option>
							   <option value="M">M</option>
							</select>
                        </div>
                    </div>

                </div>

            </div>
        </div>


		<div class="container-fluid p-0 ">

				<div class="n-form-btn-class">
					<input type="submit" name="submitit" id="submitit" value="View Chalan"  class="btn1 btn1-submit-input" />
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
						  <th>Receivable Amt </th>
						  <th>Chalan Amt</th>
						  <th>&nbsp;</th>
						  <th>Checked?</th>
					</tr>
                        
                   
                    </thead>

                    <tbody class="tbody1">
						<? if($_POST['do_date_fr']!=''){
									  
							
							$i=0;
							
							$datefr = strtotime($_POST['do_date_fr']);
							$dateto = strtotime($_POST['do_date_to']);
							$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));
							$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));
							if($_SESSION['user']['group']>1){ $group_s='AND j.group_for='.$_SESSION['user']['group'];}
							
									if($depot_id>0) {$depot_con = ' and SUBSTR(j.tr_no,7,2)='.$depot_id;}
									if($_POST['checked']!='') {$checked_con = ' and j.checked="'.$_POST['checked'].'" ';}
									if($_POST['dealer_type']!=''){$dealer_type_con=' and d.dealer_type="'.$_POST['dealer_type'].'"';}
									if($_POST['dealer_group']!='') {$dealer_group_con=' and d.product_group="'.$_POST['dealer_group'].'"';}
									$tr_type="Search";
									    $sql="SELECT DISTINCT 
									
											  j.tr_no,
											  sum(j.dr_amt) as dr_amt,
											  sum(j.cr_amt) as cr_amt,
											  j.jv_date,
											  j.jv_no,
											  l.ledger_name,
											  j.tr_id,
											  j.entry_by,
											  j.entry_at,
											  j.checked,
											  j.jv_no,
											  u.fname
							
											FROM
											  secondary_journal j,
											  accounts_ledger l,
											  dealer_info d,
											  user_activity_management u,
											  sale_do_master m
											WHERE
											  
											  j.entry_by=u.user_id and
											 d.account_code = l.ledger_id and 
											  j.tr_from = 'Sales' AND 
											  j.tr_id = m.do_no and d.dealer_code = m.dealer_code and 
											  j.jv_date between '".$_POST['do_date_fr']."' AND '".$_POST['do_date_to']."'  ".$group_s." ".$depot_con.$checked_con.$dealer_type_con.$dealer_group_con." 
											group by  j.tr_no";
								  $query=db_query($sql);
								  
		  ?>
		  
							<?


						  
						  while($data=mysqli_fetch_object($query)){
						  $received = $received + ($data->cr_amt);
						  ?>
                      
                            <tr <?=($i%2==0)?'class="alt"':'';?> >
								  <td align="center"><div align="left"><?=++$i;?></div></td>
								  <td align="center"><div align="left"><? echo $data->tr_id;?></div></td>
								  <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
								  <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>
								  <td align="center"><div align="left"><? echo $data->entry_at;?></div></td>
								  <td align="center"><div align="left"><?=$data->fname;?></div></td>
								  <td align="center"><div align="right">
							<?=number_format(($data->cr_amt-$data->dr_amt),2);?>
								  </div></td>
								  <td align="right"><?=number_format(($data->cr_amt),2);?></td>
								  <td align="center"><a target="_blank" href="sales_sec_print_view.php?jv_no=<?=$data->jv_no ?>">
							<input name="radio_<?=$data->jv_no;?>" type="radio" value="" <?=($data->checked=='YES')?'checked="checked"':'';?>  style="width:20px;" />
								  </a></td>
								  <td align="center"><span id="divi_<?=$data->tr_no?>">
							<? 
							if(($data->checked=='YES')){
							?>
							
							<!--<input type="button" name="Button" value="YES"  onclick="window.open('sales_sec_print_view.php?jv_no=<?=rawurlencode(url_encode($data->jv_no));?>');" class="btn1 btn1-bg-submit"/>-->
							
							<input type="button" name="Button" value="YES"  onclick="window.open('sales_sec_print_view.php?c=<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($data->jv_no));?>');" class="btn1 btn1-bg-submit"/>
							
							
							
							<?
							}elseif(($data->checked=='')){
							?>
<input type="button" name="Button" value="NO" onclick="window.open('sales_sec_print_view.php?c=<?=rawurlencode(url_encode($c_id))?>&v=<?=rawurlencode(url_encode($data->jv_no))?>');" class="btn1 btn1-bg-cancel"/>

							<? }?>
          </span></td>
      

                        </tr>
						
						<? } } ?>

                    </tbody>
                </table>





        </div>
    </form>
</div>











<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
