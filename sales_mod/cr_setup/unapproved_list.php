<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$tr_type="Show";





// ::::: Edit This Section ::::: 



$title='PARTY CREDIT CONFIGURATION';			// Page Name and Page Title

$page="cr_checking.php";		// PHP File Name

do_calander("#c_start_date");
do_calander("#c_end_date");
do_calander("#effective_start_date");
do_calander("#effective_end_date");


$table='credit_limit_config';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='dealer_type';				// For a New or Edit Data a must have data field
$this_month = date('Y-m-15');


// ::::: End Edit Section :::::
//$prevous_mon = date('m',strtotime($this_month,'-1 month'));
//$sql = 'select * from credit_limit_config where status=0 and mon="'.$prevous_mon.'" and year="'.date('Y')-1.'"';

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$current_date = $_POST['year'].'-'. $_POST['year'].'-15';

$previous_month_date = date('Y-m-d',strtotime($current_date,'-1 month'));
$previous_month_start_date = date('Y-m-01',strtotime($previous_month_date));
$mdays = date('t',strtotime($previous_month_date));
$previous_month_end_date = date('Y-m-'.$mdays,strtotime($previous_month_date));

$parameters = $_POST['parameters'];
$i=0;

/*foreach($parameters as $res){
if($i>0){
$parameter .= ",";
}
$parameter .= $res;
$i++;
}*/

$crud->insert();





$type=1;
$tr_type="Add";
$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{

$parameters = $_POST['parameters'];
$i=0;
foreach($parameters as $res){
if($i>0){
$parameter .= ",";
}
$parameter .= $res;
$i++;
}
$_POST['parameters'] = $parameter;

$_POST['edit_by'] = $_SESSION['user']['id'];
$_POST['edit_at'] = date('Y-m-d H:i:s');
$crud->update($unique);

		$type=1;
    $tr_type="Edit";

		$msg='Successfully Updated.';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;
    $ttr_type="Delete";

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="../custom_css/example-styles.css">
<link rel="stylesheet" type="text/css" href="../custom_css/demo-styles.css">-->
<script>
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
});

$(".chosen-selectAnother").chosen({
  no_results_text: "Oops, nothing found!"
});


</script>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<style>
.pr-3{ 
 padding:3px;
}
</style>


<div class="container-fluid">
    

    </div>

<div class="row">
        <div class="col-sm-12">
            


            <div class="container n-form1">
                <? $res='select c.id,d.dealer_name_e,dt.dealer_type,c.rules as Based,c.critaria as figure, c.timeLine,c.totalMonth as no_of_month,c.c_start_date as period_start_date,c.c_end_date as period_end_date,c.minimumLimit as cc_balance_less_then,c.totalTimes as times,c.maxLimit as max_limit,c.dealerAge as party_age,c.conditionalEffectiveMon as conditional_effective_mon,c.effective_start_date as start_date,c.effective_end_date as end_date from credit_limit_config c left join dealer_type dt on dt.id=c.dealer_type left join dealer_info d on d.dealer_code=c.dealer_code where c.status="UNCHECKED"';
                    //$qry = db_query();
											echo $crud->link_report($res,$link);
											
											?>

            </div>

        </div>
		</div>


</div>











<?php /*?><div class="form-container_large">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td valign="top"><div class="left">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div class="tabledesign" style="height:787px;">
                  <? 	$res='select '.$unique.','.$unique.' AS credit_limit_config_Code,'.$shown.' AS credit_limit_config_name  from '.$table;

											echo $crud->link_report($res,$link);?>
                </div>
                 </td>
            </tr>
          </table>
        </div></td>
      <td valign="top"><form action="" method="post"  enctype="multipart/form-data" >
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2"><fieldset style="width:362px;">
                      <legend>
                      <?=$title?>
                      </legend>
                      <div class="buttonrow"></div>
                      <div>
                        <label> credit_limit_config Code:</label>
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text"  readonly/>
                      </div>
                      <div>
                        <label> credit_limit_config Name:</label>
                        <input name="credit_limit_config_NAME" type="text" id="credit_limit_config_NAME" tabindex="2" value="<?=$credit_limit_config_NAME?>">
                      </div>
					  <div>
                        <label>Under Zone:</label>
						<select id="ZONE_ID" name="ZONE_ID">
						<option></option>
                         <?php foreign_relation('zon', 'ZONE_CODE', 'ZONE_NAME', $ZONE_ID); ?>
					    </select>
                      </div>
                      
                      <!--<div>
                        <label>TSM</label>
						<select id="PBI_ID" name="PBI_ID">
						<option></option>
                         <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'PBI_NAME', $tsm_name,' PBI_DESIGNATION in(56,57,88)'); ?>
					    </select>
                      </div>-->
					  
                      </fieldset></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div>
                        <? if(!isset($_GET[$unique])){?>
                        <input name="insert" type="submit" id="insert" value="Save" class="btn1 btn1-bg-submit" />
                        <? }?>
                      </div></td>
                    <td><div>
                        <? if(isset($_GET[$unique])){?>
                        <input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
                        <? }?>
                      </div></td>
                    <td><div>
                        <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                      </div></td>
                    <td><!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
</div><?php */?>

<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<script>
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})

</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
