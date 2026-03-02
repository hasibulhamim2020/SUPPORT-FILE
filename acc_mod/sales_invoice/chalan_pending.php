<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$c_id = $_SESSION['proj_id'];
$title='Sales Invoice Submit';
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


<script language="javascript">
function custom(theUrl,c_id)
{
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
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
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer Type</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="dealer_type" id="dealer_type" class="form-control">
							<option></option>
							<? foreign_relation('dealer_type','id','dealer_type',$_POST['dealer_type'],'1')?>
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
						  <th>Checked?</th>
					</tr>
                        
                   
                    </thead>

                    <tbody class="tbody1">
						<? 
									  
							
							$i=0;
							
							$datefr = strtotime($_POST['do_date_fr']);
							$dateto = strtotime($_POST['do_date_to']);
							if($_POST['do_date_fr']!='' && $_POST['do_date_to']!=''){ $con = ' and c.chalan_date between "'.$_POST['do_date_fr'].'" and "'.$_POST['do_date_to'].'"';}
							if($_POST['dealer_type']>0) { $con .= ' and d.dealer_type="'.$_POST['dealer_type'].'"'; }
							
									if($depot_id>0) $depot_con = ' and SUBSTR(j.tr_no,7,2)='.$depot_id;
									
									if($_POST['dealer_type']!=''){$dealer_type_con=' and d.dealer_type="'.$_POST['dealer_type'].'"';}
									
									   $sql="SELECT DISTINCT 
									
											  c.chalan_no,
											  sum(c.total_amt) as chalan_amt,
											  c.do_no,
											  c.chalan_date,
											  d.dealer_name_e,
											  c.entry_at,
											  u.fname
							
											FROM
											  sale_do_chalan c,
											  dealer_info d,
											  user_activity_management u
											  
											WHERE
											  c.dealer_code=d.dealer_code and u.user_id=c.entry_by ".$con."
											  group by  c.chalan_no";
								  $query=db_query($sql);
								  
		  ?>
		  
							<?


						  
						  while($data=mysqli_fetch_object($query)){
						  $received = $received + ($data->cr_amt);
						  ?>
                      
                            <tr <?=($i%2==0)?'class="alt"':'';?> >
								  <td align="center"><div align="left"><?=++$i;?></div></td>
								  <td align="center"><div align="left"><? echo $data->do_no;?></div></td>
								  <td align="center"><div align="left"><? echo $data->chalan_no;?></div></td>
								  <td align="center"><div align="left"><? echo $data->dealer_name_e;?></div></td>
								  <td align="center"><div align="left"><? echo $data->entry_at;?></div></td>
								  <td align="center"><div align="left"><?=$data->fname;?></div></td>
								 
								  <td align="right"><?=number_format(($data->chalan_amt),2);?></td>
								  <td align="center">
			<!-- <a target="_blank" href="invoice_print_view.php?chalan_no='<?=url_encode($data->chalan_no);?>'" class="btn btn-primary">Invoice</a>-->
								  
						<a target="_blank" href="invoice_print_view.php?c='<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($data->chalan_no));?>'" class="btn btn-primary">Invoice</a>
								  
								  </td>
								  
                        </tr>
						
						<? } ?>

                    </tbody>
                </table>





        </div>
    </form>
</div>











<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
