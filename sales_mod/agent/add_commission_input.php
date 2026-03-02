<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='Commission Agent Setup';

$page="add_commission_agent.php";



$table='sales_commission_agent';

$unique='ca_id';

$shown='ca_name';











if(isset($_GET['proj_code'])){ $proj_code=$_GET[$proj_code]; }



$crud      =new crud($table);



$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();



		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['entry_by']=$_SESSION['user']['id'];

$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($unique);

}









if(isset($_POST['update']))

{

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}





if(isset($_POST['delete']))

{		$condition=$unique."=".$unique;		$crud->delete($condition);

		unset($unique);

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($unique))

{

$condition=$unique."=".$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $key=$value;}

}

if (!isset($unique)) {
    $unique = db_last_insert_id($table, $unique);
}

if ($_POST['gf'] == 999) {
    unset($_SESSION['gf']);
    unset($_POST['gf']);
}


?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table class="w-100" border:0;">
    <tr>
      <td>
	  
	  <table class="w-100" border:0;">
          <tr>
            <td><fieldset>
             
              <div class="buttonrow"></div>
              <div class="form-group row">
                <!-- Material input -->
                <label for="inputPassword3MD" class="col-sm-2 col-form-label">Agent  ID</label>
                <div class="col-sm-10">
                  <div class="md-form mt-0">
                    <input class="form-control" name="ca_id" type="text" id="ca_id" value="<?=$ca_id?>">
                  </div>
                </div>
              </div>
              <div class="form-group row">

                <label for="inputPassword3MD" class="col-sm-2 col-form-label">Agent Name</label>
                <div class="col-sm-10">
                  <div class="md-form mt-0">
                    <input class="form-control" name="ca_name" type="text" id="ca_name" value="<?=$ca_name?>" />
                  </div>
                </div>
              </div>
              <div class="form-group row">

                <label for="inputPassword3MD" class="col-sm-2 col-form-label">Concern Company:</label>
                <div class="col-sm-10">
                  <div class="md-form mt-0">
                    <select class="form-control" name="group_for" id="group_for">
                      <?	$sql="select * from user_group where status!=1 order by group_name";

											$query=db_query($sql);

											while($datas=mysqli_fetch_object($query))

										{

										?>
                      <option <? if($datas->id==$group_for){ echo 'Selected ';}?> value="<?=$datas->id?>">
                      <?=$datas->group_name?>
                      </option>
                      <? } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">

                <label for="inputPassword3MD" class="col-sm-2 col-form-label">Contact No:</label>
                <div class="col-sm-10">
                  <div class="md-form mt-0">
                    <input class="form-control" name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" />
                  </div>
                </div>
              </div>
              <div class="form-group row">

                <label for="inputPassword3MD" class="col-sm-2 col-form-label">Area Name:</label>
                <div class="col-sm-10">
                  <div class="md-form mt-0">
                    <select name="area_id" id="area_id" class="form-control" required>
                      <option></option>
                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$area_id,' 1');?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">

                <label for="inputPassword3MD" class="col-sm-2 col-form-label">Sales Depot:</label>
                <div class="col-sm-10">
                  <div class="md-form mt-0">
                    <select name="warehouse_id" id="warehouse_id" class="form-control" required>
                      <option></option>
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,' center_depot= "Yes" and warehouse_id!=5');?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group row">

                <label for="inputPassword3MD" class="col-sm-2 col-form-label">Address:</label>
                <div class="col-sm-10">
                  <div class="md-form mt-0">
                    <input class="form-control" name="address" type="text" id="address" value="<?=$address?>" />
                  </div>
                </div>
              </div>
              <div class="form-group row">

                <label for="inputPassword3MD" class="col-sm-2 col-form-label">Status:</label>
                <div class="col-sm-10">
                  <div class="md-form mt-0">
                    <select name="status" id="status" class="form-control">
                      <option>
                      <?=$status?>
                      </option>
                      <option>ACTIVE</option>
                      <option>INACTIVE</option>
                    </select>
                  </div>
                </div>
              </div>
              </fieldset></td>
          </tr>
        </table>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
	  
	  <table style="width:100%; border:0; border-collapse:collapse; padding:0;">
         <thead>
          <tr>
            <td><div class="button">
                <? if(!isset($_GET[$unique])){?>
                <input name="insert" type="submit" id="insert" value="Save" class="btn btn-success"/>
                <? }?>
              </div></td>
            <td><div class="button">
                <? if(isset($_GET[$unique])){?>
                <input name="update" type="submit" id="update" value="Update" class="btn btn-primary"/>
                <? }?>
              </div></td>
            <td><div class="button">
                <input name="reset" type="button" class="btn btn-info" id="reset" value="Reset" onclick="parent.location='<?=$page?>'"/>
              </div></td>
            <td><div class="button">
                <input class="btn btn-delete" name="delete" type="submit" id="delete" value="Delete"/>
              </div></td>
          </tr>
          </thead>
        </table>
		
		</td>
    </tr>
  </table>
</form>
<?php

require_once SERVER_CORE."routing/layout.bottom.php";

?>
