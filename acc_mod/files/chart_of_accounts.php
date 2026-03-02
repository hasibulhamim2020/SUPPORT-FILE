<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Chart Of Accounts';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
?>


<section class="content-main">

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->

<div class="form-container_large">
  
  
  
<form id="form1" name="form1" method="post" action="">
<div class="container">
  
  <div class="row">

		<div class="col-md-2">
		<label for="" class="col-form-label col-form-label-sm">Class</label>
		<div class="">
		<select class="form-control" name="class_type" id="class_type" onchange="FetchSubClass(this.value)">
				  <option value="<?=$_POST['class_type']?>"><?=find1("select class_name from acc_class where id='".$_POST['class_type']."'");?></option>
				  <? optionlist("select id,class_name from acc_class where 1 order by id");?>
				<option></option>
				</select>
		</div>
		</div>
		

		<div class="col-md-2 form-group">
		<label for="" class="col-form-label col-form-label-sm">Sub Class</label>
		<div class="">
		<select class="form-control" name="sub_class_type" id="sub_class_type" onchange="FetchGroup(this.value)">
				  <option value="<?=$_POST['sub_class_type']?>"><?=find1("select sub_class_name from acc_sub_class where id='".$_POST['sub_class_type']."'");?></option>
				  <? 
				  if($_POST['class_type']>0){ $dcon2=' and acc_class="'.$_POST['class_type'].'"'; }
				  optionlist('select id,sub_class_name from acc_sub_class where 1 '.$dcon2.' order by id');?>
				<option></option>
				</select>
		</div>
		</div>
		
		
		<div class="col-md-3 form-group">
		<label for="" class="col-form-label col-form-label-sm">Group</label>
		<div class="">
		  <select class="form-control" name="group_name" id="group_name">
		<option value="<?=$_POST['group_name'];?>"><?=find1("select group_name from ledger_group where group_id='".$_POST['group_name']."'");?></option>
		<? 
		if($_POST['sub_class_type']>0){ $dcon3=' and acc_sub_class="'.$_POST['sub_class_type'].'"'; }
		$sql_group_list='select group_id,group_name from ledger_group where 1 '.$dcon3.' order by group_name asc';
		optionlist($sql_group_list); ?>
		<option></option>
		</select>
		</div>
</div>
		
		
		<div class="col-md-2 form-group">
		<label for="" class="col-form-label col-form-label-sm">Ledger Name</label>
		<div class="">
		<input name="name" type="text" id="name" value="<?php echo $_REQUEST['name']; ?>" autocomplete="off"/>
		</div>
	</div>
	
	
    <div class="col-md-2 form-group">
    		<label for="" class="col-form-label col-form-label-sm">Code View</label>
    		<div class="">
                <select class="form-control" name="acc_code_view" id="acc_code_view">
                <option value="<? if($_POST['acc_code_view']!=''){ echo $_POST['acc_code_view'];}else{ echo 'No';}?>"><? if($_POST['acc_code_view']!=''){ echo $_POST['acc_code_view'];}else{ echo 'No';}?></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                </select>
            </div>
    </div>



<div class="col-md-3 form-group">
    <div class="col-md-6">
      <button type="submit" class="btn btn-primary">SHOW</button>
    </div>
</div>



</div>
<!--end row-->
 

</div>
</form>





<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
		  
		  <tr>
            <td align="right"><? //include('PrintFormat.php');?></td>
          </tr>
          <tr>
            <td><div id="reporting">
                <table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
                  <thead>
                    <tr>
                      <th width="10%">Class</th>
                      <th width="25%">Sub Class</th>
                      <th width="25%">Group</th>
                      <th>Ledger</th>
                    </tr>
                  </thead>
                  
				  
				  
<?php
	if($_POST['class_type']!=""){$con1= " and id = '".$_POST['class_type']."'";}
	if($_REQUEST['ladger_group']!=""){$con2= " and group_name LIKE '%".$_REQUEST['ladger_group']."%'";}
	
	if($_REQUEST['group_type']!="" && $_REQUEST['ladger_group']!="" ){
	    $con.= " and group_name LIKE '%".$_REQUEST['ladger_group']."%' and group_type LIKE '%". $_REQUEST['group_type']."%'";
	}
	
// ----------- 1
$rrr = "select id,class_name from acc_class where 1 ".$con1." order by id asc";
$report = db_query($rrr);
while($rp=mysqli_fetch_row($report)){ ?>
        <tr<? $i++; if($i%2==0)$cls=' class="alt"'; else $cls=''; echo $cls;?>>
        <td style="color:red;font-size:12px;">&nbsp;
        <? if($_POST['acc_code_view']=='Yes'){ echo $rp[0].'-'.$rp[1];}else{ echo $rp[1];} ?>
        </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
    
    </tr>
<?
// ------------------ 2
if($_REQUEST['sub_class_type']!="" ){$con2= " and id = '".$_REQUEST['sub_class_type']."'";}

$select2 = 'select id,sub_class_name as name from acc_sub_class where acc_class = '.$rp[0].' '.$con2.' order by id asc';
$query2 = db_query($select2);	
while($r = mysqli_fetch_object($query2)){ ?>
                  <tr>
                    <td></td>
<?php if($_POST['acc_code_view']=='Yes'){ $view2 = $r->id.'-'.$r->name;}else{ $view2 = $r->name;} ?>					
                    <td style="color:blue;font-size:11"><? echo $view2;?></td>
                    <td></td>
                    <td></td>
                  </tr>

<?
// ------------------ 3
if($_REQUEST['group_name']!="" ){$con3= " and group_id = '".$_REQUEST['group_name']."'";}

$select3= 'select group_id,group_name from ledger_group where acc_sub_class = '.$r->id.' '.$con3.' order by group_id asc';
$query3 = db_query($select3);	
while($r3 = mysqli_fetch_object($query3)){ ?>
                  <tr>
                    <td></td>
                    <td></td>
<?php if($_POST['acc_code_view']=='Yes'){ $view3 = $r3->group_id.'-'.$r3->group_name;}else{ $view3 = $r3->group_name;} ?>					
                    <td style="color:green;font-size:11"><? echo $view3;?></td>
                    <td></td>
                  </tr>
                  
<?
// ------------------ 4
if($_REQUEST['name']!="" ){$con4= " and ledger_name LIKE '%".$_REQUEST['name']."%'";}

$select4= 'select ledger_id,ledger_name from accounts_ledger where ledger_group_id = '.$r3->group_id.' '.$con4.' order by ledger_id asc';
$query4 = db_query($select4);	
while($r4 = mysqli_fetch_object($query4)){ ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
<?php if($_POST['acc_code_view']=='Yes'){ $view4 = $r4->ledger_id.'-'.$r4->ledger_name;}else{ $view4 = $r4->ledger_name;} ?>					
                    <td style="color:black;font-size:11"><? echo $view4;?></td>
                    
                  </tr>
                  


<? } //end 4 ?>
<? } //end 3 ?>
<? } //end 2 ?>
<? } //end 1 ?>
               
               
               
               
               
               
               
               
                </table>
              </div>
              <!--<div id="pageNavPosition">--></div></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>




</div>
				

<!-- Body end -->
</section>


<script type="text/javascript">
  function FetchSubClass(id){
    $('#sub_class_type').html('');
    $('#group_name').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { class_type : id},
      success : function(data){
         $('#sub_class_type').html(data);
      }

    })
  }

  function FetchGroup(id){ 
    $('#group_name').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { sub_class_type : id},
      success : function(data){
         $('#group_name').html(data);
      }

    })
  }
</script>


<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>