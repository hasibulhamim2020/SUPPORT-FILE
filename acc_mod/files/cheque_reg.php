<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";


$now=time();

$title='Cheque Setup';

$unique='warehouse_id';

$unique_field='cheque_no';

$table='cheque_reg';

$page="cheque_reg.php";



$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$unique_field]))

{

$$unique = $_POST[$unique];

//for Record..................................



if(isset($_POST['record']))



{		

$_POST['cheque_status']='UNCHECKED';

$bank_id = $_POST['bank_id'];

$cheque_no = $_POST['cheque_no'];

$_POST['entry_at']=date('Y-m-d h:s:i');

$_POST['entry_by']=$_SESSION['user']['id'];

$crud->insert();



$type=1;

$tr_type="Search";

$msg='New Entry Successfully Inserted.';



unset($_POST);



unset($$unique);



}







}



if(isset($$unique))



{



$condition=$unique."=".$$unique;	



$data=db_fetch_object($table,$condition);



foreach ($data as $key => $value)



{ $$key=$value;}



}



?>



<script type="text/javascript">
function nav(lkf){document.location.href = '<?=$page?>';}
</script>













  <div class="container-fluid">

    <div class="row">

      <div class="col-md-8">

        <div class="container n-form1">

          <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
            <thead class="thead1">
            <tr class="bgc-info">
              <th >ID</th>
			  <th >Bank Name</th>
              <th>Cheque Number</th>


            </tr>

            </thead>



            <tbody class="tbody1">
			
					<?
           			 $res="select bank_id,COUNT(*) as count,warehouse_id,cheque_no,cheque_status from cheque_reg where  use_type = 'WH' and  cheque_status = 'UNCHECKED' GROUP BY bank_id ORDER BY `bank_id` ;";
					$query = db_query($res);
		
					$i=1;
					while($row=mysqli_fetch_row($query)){
					?>
                        <tr>
                            <td><?=$i++?></td>
							<td><? echo find_a_field('accounts_ledger','ledger_name','ledger_id="'.$row->bank_id.'" ')?></td>
                            <td><?=$row->count?></td> 
                        </tr>
						<? } ?>
						
            </tbody>

          </table>



        </div>



      </div>





      <div class="col-md-4">

        <form id="form1" name="form1" class="n-form" method="post" action="<?=$page?>">

		

          <h4 align="center" class="n-form-titel1"> Cheque Manage</h4>

<? $ledger_group_id=124002; ?>
			<div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label"> Bank Name :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					<select name="bank_id" id="bank_id">
								    <option></option>
									<? 
									
									foreign_relation('accounts_ledger','ledger_id','concat(ledger_id,"  ",ledger_name)',$issue_from_ac,'ledger_group_id="'.$ledger_group_id.'"');
									
									
									
									
									?>
								</select>



            </div>

          </div>

          <div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label"> Cheque Number :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

              					<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>

					<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

				  <input name="cheque_no" type="text" id="cheque_no" value="" required  class="form-control"/>





            </div>

          </div>

	




          <div class="n-form-btn-class">

		  


<input name="record" type="submit" id="record" value="Record"  class="btn1 btn1-bg-submit" />

<? if($_SESSION['user']['level']==5){?>

<input class="btn1 btn1-bg-cancel" name="delete" type="submit" id="delete" value="Delete"/>




<? }
 $tr_type="Delete";
?>



          </div>





        </form>



      </div>



    </div>









  </div>











<script type="text/javascript">
	document.onkeypress=function(e){
	var e=window.event || e
	var keyunicode=e.charCode || e.keyCode
	if (keyunicode==13)
	{
		return false;
	}
}
</script>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>