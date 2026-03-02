<?php
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 



$title='General Ledger Configuration';			// Page Name and Page Title

do_datatable('table_head');

$page="gl_config.php";		// PHP File Name

$table='config_group_class';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='group_for';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);

$setClass=find_a_field($table,'group_for','group_for="'.$_SESSION['user']['group'].'"');
if($_SESSION['user']['group']==$setClass){
$$unique =find_a_field($table,'group_for','group_for="'.$_SESSION['user']['group'].'"');
}


//for Insert..................................

if(isset($_POST['insert']))

{		

$_POST['proj_id']= $_SESSION['proj_id'];

$now				= time();

$_POST['group_for']=$_SESSION['user']['group'];

$entry_by = $_SESSION['user']['id'];

$crud->insert();
	
$type=1;

$msg='New Entry Successfully Inserted.';

echo "<script>window.top.location='".$page."'</script>";

}





//for Modify..................................



if(isset($_POST['update']))

{


		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}

//for Delete..................................






if(isset($$unique))

{

$condition="group_for='".$$unique."'";

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

//if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {color: #FFFFFF}

-->

</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
<!--<?=$$unique?>-->
  <tr>

    

    <td valign="top" width="100%">
	<div class="left">   
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2" style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B">
								  										<div align="center">
                                          <?=$title?>
                                        </div>
								  </td>
								  
                                </tr>

                                <tr>
								
								
								

                                  <td width="100%" colspan="2" style="padding-top:10px;">
								  
								  
								  
								  <div class="box" style="width:400px; padding-top:10px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
									
									<input name="id" type="hidden" value="<?=$id?>"/>

									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Sales:</td>
									   <td>
										<input name="sales_ledger" type="text" id="sales_ledger" tabindex="1" value="<?=$sales_ledger?>" class="form-control" >
									
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Sales Discount:</td>
									   <td>
										<input name="sales_discount" list="l_4" type="text" id="sales_discount" tabindex="1" value="<?=$sales_discount?>"  class="form-control" >
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Sales Vat:</td>
									   <td>
										<input name="sales_vat" list="l_4" type="text" id="sales_vat" tabindex="1" value="<?=$sales_vat?>"  class="form-control" >										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Sales Return:</td>
									   <td>
										<input name="sales_return" list="l_4" type="text" id="sales_return" tabindex="1" value="<?=$sales_return?>"  class="form-control" >
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>COGS:</td>
									   <td>
										<input name="cogs_ledger" list="l_4" type="text" id="cogs_ledger" tabindex="1" value="<?=$cogs_ledger?>"  class="form-control" >										</td>
                                      </tr>
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Purchase Discount:</td>
									   <td>
						<input name="purchase_discount"  type="text" id="purchase_discount" tabindex="1" value="<?=$purchase_discount?>"  class="form-control" >
										</td>
                                      </tr>  
									  
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Purchase Vat:</td>
									   <td>
										<input name="purchase_vat" list="l_4" type="text" id="purchase_vat" tabindex="1" value="<?=$purchase_vat?>"  class="form-control" >
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Purchase AIT:</td>
									   <td>
						<input name="purchase_ait"  type="text" id="purchase_ait" tabindex="1" value="<?=$purchase_ait?>"  class="form-control" >
										</td>
                                      </tr>
									
									  
									   <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>WIP:</td>
									   <td>
										<input name="wip_ledger" list="l_4" type="text" id="wip_ledger" tabindex="1" value="<?=$wip_ledger?>"  class="form-control" >
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Local Purchase:</td>
									   <td>
										<input name="localPurchase" list="l_4" type="text" id="localPurchase" tabindex="1" value="<?=$localPurchase?>"  class="form-control" >
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Local Sales:</td>
									   <td>
										<input name="localSales" list="l_4" type="text" id="localSales" tabindex="1" value="<?=$localSales?>"  class="form-control" >
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Direct Sales:</td>
									   <td>
										<input name="directSales" list="l_4" type="text" id="directSales" tabindex="1" value="<?=$directSales?>"  class="form-control" >
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Cash Ledger:</td>
									   <td>
										<input name="directSales" list="l_4" type="text" id="cash_ledger" tabindex="1" value="<?=$cash_ledger?>"  class="form-control" >
										</td>
                                      </tr>
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Bank Ledger:</td>
									   <td>
										<input name="directSales" list="l_4" type="text" id="bank_ledger" tabindex="1" value="<?=$bank_ledger?>"  class="form-control" >
										</td>
                                      </tr>
									  
									  
									  
									  
									  

                                      <!--<tr>

                                        <td>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for"  tabindex="7" style="width:220px;">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select></td>
                                      </tr>-->
									  
									 <!-- <tr>

                                        <td>Status:</td>

                                        <td><select name="status" id="status"  style="width:250px;">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="Active">Active</option>

                                          <option value="Inactive">Inactive</option>


                                        </select></td>

                                      </tr>
             -->

                                      

									
									  

                                      

                                      
									  

                                    

                                      

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                

                                <tr>

                                  <td colspan="2">&nbsp;</td>
                                </tr>

                                <tr>

                                  <td colspan="2">

								  <div class="box1">

								    <table width="30%" border="0" cellspacing="0" cellpadding="0" align="center">

					<tr>
					<? if($$unique==''){?>
                 	 <td><div class="button">
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn btn-primary" />
					  </div>
					  </td>
					<? }else{?>
                 	 <td>
				  	<div class="button">
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn btn-success" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn btn-warning" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                  <td>
                  <!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->                    </td>
                </tr>
							        </table>
								  </div>								  </td>
                                </tr>
                              </table>

    </form>

							</div></td>

  </tr>

</table>


<?

	 require_once SERVER_CORE."routing/layout.bottom.php";

?>