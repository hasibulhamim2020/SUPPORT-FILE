<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";









$title='Add Division Information';

$page="div.php";



$table='division';

$unique='division_CODE';

$shown='division_name';

$tr_type="show";









$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();
$tr_type="Add";
$id = $_POST['dealer_code'];
		
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}









if(isset($_POST['update']))

{



		$crud->update($unique);

$id = $_POST['dealer_code'];
		




		$type=1;

		$msg='Successfully Updated.';
		
		$tr_type="Edit";

}





if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

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

if(!isset($$unique)){ $$unique=db_last_insert_id($table,$unique);}

?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>






<div class="container-fluid">
    <div class="row">
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">



            <div class="container n-form1">
                <table class="table table-sm" border="0" cellspacing="0" cellpadding="0">

            <tr>
              <td >
                  <? 	$res='select '.$unique.','.$unique.' as DIVISION_CODE,'.$shown.' as DIVISION_NAME  from '.$table;

											echo $crud->link_report($res,$link);?>

                </td>
            </tr>
          </table>

            </div>

        </div>


       <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6  setup-right">
            <form id="form1" name="form1" class="n-form" method="post" action="" enctype="multipart/form-data">
                <h4 align="center" class="n-form-titel1 text-uppercase"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Division Code:</label>
                    <div class="col-sm-9 p-0">
                       <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text"  readonly/>


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Division Name: </label>
                    <div class="col-sm-9 p-0">
                        <input name="division_name" type="text" id="division_name" tabindex="2" value="<?=$division_name?>">

                    </div>
                </div>

              <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">CO-Ordinator Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

              <select name="head_id" id="head_id" >
								<option></option>
								<?

								foreign_relation('user_activity_management','user_id','username',$head_id,'1');

								?>
					</select>


            </div>

          </div>

                <div class="n-form-btn-class">
                    <? if(!isset($_GET[$unique])){?>
                        <input name="insert" type="submit" id="insert" value="Save" class="btn1 btn1-bg-submit" />
                        <? }?>
                      
                    
                        <? if(isset($_GET[$unique])){?>
                        <input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
                        <? }?>
                      
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                      

                </div>


            </form>

        </div>

    </div>

</div>



<?php

require_once SERVER_CORE."routing/layout.bottom.php";

?>
