<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";



do_calander('#issue_date');
do_calander('#exp_date');
do_calander('#rec_date');
do_calander('#ins_start_date');
do_calander('#ins_end_date');
do_datatable('table_head');



// ::::: Edit This Section ::::: 
$unique='chq_print_id';  		// Primary Key of this Database table
$title='Cheque Book Settings Entry' ; 	// Page Name and Page Title
$page="cheque_book_settings_entry.php";		// PHP File Name
$table='chq_print_setup';		// Database Table Name Mainly related to this page


$crud    = new crud($table);
$$unique = $_GET[$unique];

//for submit..................................
if(isset($_POST['submit']))
{		
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$crud->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
}

//for update..................................
if(isset($_POST['update']))
{
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
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
	function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}
</script>


<div class="container-fluid">
   
 <div class="container">
<form action="<?=$page?>?<?=$unique?>=<?=$$unique?>" method="post" enctype="multipart/form-data">
<input name="<?=$unique?>" required="" type="hidden" id="<?=$unique?>" value="<?=$$unique;?>" >	


  <div class="row">
    <div class="col-md-2 mb-3">
        <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">General</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Cheque Date</a>
	
  </li>
  <li class="nav-item">
    <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="two" aria-selected="false">Chq P. Name</a>
  </li>
	<li class="nav-item">
    <a class="nav-link" id="five-tab" data-toggle="tab" href="#five" role="tab" aria-controls="five" aria-selected="false">Cheque Amount</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Date</a>
  </li>
    <li class="nav-item">
    <a class="nav-link" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="one" aria-selected="false">Payee Name</a>
  </li>
    
    <li class="nav-item">
    <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="three" aria-selected="false">Amount In Words</a>
  </li>
    <li class="nav-item">
    <a class="nav-link" id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="four" aria-selected="false">Amount</a>
  </li>
</ul>
    </div>
    <!-- /.col-md-4 -->
        <div class="col-md-10">
      <div class="tab-content" id="myTabContent">
  <div class=" n-form tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" >
  <p class="p-0" style="color:#FF0000; text-align:center;">Sample Size: Width: 240mm / Height: 92mm </p>
  <div class="row">
        <div class="col-sm-6">

			

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Bank Name: </label>
                    <div class="col-sm-7 p-0">
					<select name="chq_id" id="chq_id"  value="<?=$chq_id;?>">
					<option value="<?=$chq_id;?>"><?=find_a_field('chq_setup','bank_name','id="'.$chq_id.'"');?></option>
					<?php 
						echo $d_sql='select * from chq_setup';
					$d_query = db_query($d_sql);
					while($d_row = mysqli_fetch_object($d_query)){
					?>
						<option value="<?=$d_row->bank_name?>"><?=find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id='.$d_row->bank_name);?></option>
					<?php } ?>
					</select>	
					
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Width: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="width" type="text" id="width" tabindex="1" value="<?=$width;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Height : </label>
                    <div class="col-sm-7 p-0  d-flex  align-items-center">
						
						<input name="height" type="text" id="height" tabindex="1" value="<?=$height;?>" ><span>mm</span>
                    </div>
                </div>

        </div>
		
</div>

</div>
  
  
  <div class="tab-pane fade n-form" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <p class="p-0" style="color:#FF0000; text-align:center;">Sample Size: Left: 17mm / Top: 26mm / Width: 50mm / Height: 6mm /Font Size: 15</p>
<div class="row">
        <div class="col-sm-6">
		        
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Left: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="acct_pay_left" type="text" id="acct_pay_left" tabindex="1" value="<?=$acct_pay_left;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Top: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="acct_pay_top" type="text" id="acct_pay_top" tabindex="1" value="<?=$acct_pay_top;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Width: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="acct_pay_width" type="text" id="acct_pay_width" tabindex="1" value="<?=$acct_pay_width;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Height: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="acct_pay_hight" type="text" id="acct_pay_hight" tabindex="1" value="<?=$acct_pay_hight;?>" > <span>mm</span>
                    </div>
                </div>


        </div>
		
		<div class="col-sm-6">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Align: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">																			
					<select name="acct_pay_align" id="acct_pay_align" onchange="applyAlignment('accountPayee','acct_pay_align')" value="<?=$acct_pay_align?>" >
						<option><?=$acct_pay_align?></option> 
                      	<option value="left">LEFT</option>    
					    <option value="center">CENTER</option>                		
						<option value="right">RIGHT</option>
					 </select>	
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Font Name: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="acct_pay_font" type="text" id="acct_pay_font" tabindex="1" value="<?=$acct_pay_font;?>" >
                    </div>
                </div>
			
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="acct_pay_font_size" type="text" id="acct_pay_font_size" tabindex="1" value="<?=$acct_pay_font_size;?>" >
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                            <button id="minusBtnY">Up</button>
							<button id="plusBtnY">Down</button>
                            <button id="minusBtnX">Left</button>
                            <button id="plusBtnX">Right</button>
                            
                    </div>
                </div>

        </div>
		
</div>
  </div>
  
  <div class="tab-pane fade n-form" id="contact" role="tabpanel" aria-labelledby="contact-tab">
      <p class="p-0" style="color:#FF0000; text-align:center;">Sample Size: Left: 203mm / Top: 20mm / Width: 5mm / Height: 6mm /Font Size: 15 /Letter Space: 1mm / Section: 1mm </p>
<div class="row">
        <div class="col-sm-6">
		        
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Left: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="date_left" type="text" id="date_left" tabindex="1" value="<?=$date_left;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Top: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="date_top" type="text" id="date_top" tabindex="1" value="<?=$date_top;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Width: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="date_width" type="text" id="date_width" tabindex="1" value="<?=$date_width;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Hight: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="date_hight"  type="text" id="date_hight" tabindex="1" value="<?=$date_hight;?>" > <span>mm</span>
                    </div>
                </div>


        </div>
		
		<div class="col-sm-6">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Align: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">																			
					<select name="date_align" id="date_align" value="<?=$date_align?>" >
						<option><?=$date_align?></option> 
                      	<option value="left">LEFT</option>    
					    <option value="center">CENTER</option>                		
						<option value="right">RIGHT</option>
					 </select>	
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Font Name: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="date_font" type="text" id="date_font" tabindex="1" value="<?=$date_font;?>" >
                    </div>
                </div>
			
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="date_font_size"  type="text" id="date_font_size" tabindex="1" value="<?=$date_font_size;?>" >
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                            <button id="chq_date_minusBtnY">Up</button>
							<button id="chq_date_plusBtnY">Down</button>
                            <button id="chq_date_minusBtnX">Left</button>
                            <button id="chq_date_plusBtnX">Right</button>
                            
                    </div>
                </div>

        </div>
		
		<div class="col-sm-12 ">
			<h4 align="center" style="background-color: wheat;">Date Spacing</h4>
			<div class="col-sm-6">
			                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Letter: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="date_letter"  type="text" id="date_letter" tabindex="1" value="<?=$date_letter;?>" >
                    </div>
                </div>
			</div>
			<div class="col-sm-6">
			                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Section: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="date_section"  type="text" id="date_section" tabindex="1" value="<?=$date_section;?>" >
                    </div>
                </div>
			</div>
		
		
		</div>
		
</div>
  
  </div>
  
  
  
<div class="tab-pane fade n-form" id="one" role="tabpanel" aria-labelledby="one-tab">
      <p class="p-0" style="color:#FF0000; text-align:center;">Sample Size: Left: 80mm / Top: 33mm / Width: 150mm / Height: 8mm /Font Size: 15 </p>
<div class="row">
        <div class="col-sm-6">
		        
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Left: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="name_left"  type="text" id="name_left" tabindex="1" value="<?=$name_left;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Top: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="name_top"  type="text" id="name_top" tabindex="1" value="<?=$name_top;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Width: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="name_width"  type="text" id="name_width" tabindex="1" value="<?=$name_width;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Hight: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="name_hight"  type="text" id="name_hight" tabindex="1" value="<?=$name_hight;?>" > <span>mm</span>
                    </div>
                </div>


        </div>
		
		<div class="col-sm-6">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Align: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">																			
					<select name="name_align" onchange="applyAlignment('chq_pay_name','name_align')" id="name_align" value="<?=$name_align?>" >
						<option><?=$name_align?></option> 
                      	<option value="left">LEFT</option>    
					    <option value="center">CENTER</option>                		
						<option value="right">RIGHT</option>
					 </select>	
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Font Name: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="name_font" type="text" id="name_font" tabindex="1" value="<?=$name_font;?>" >
                    </div>
                </div>
			
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="name_font_size"  type="text" id="name_font_size" tabindex="1" value="<?=$name_font_size;?>" >
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                            <button id="minusBtnY_chq_pay_name">Up</button>
							<button id="plusBtnY_chq_pay_name">Down</button>
                            <button id="minusBtnX_chq_pay_name">Left</button>
                            <button id="plusBtnX_chq_pay_name">Right</button>
                            
                    </div>
                </div>

        </div>
		
</div>
  
  </div>
  
  
  <div class="tab-pane fade n-form" id="two" role="tabpanel" aria-labelledby="two-tab">
  <p class="p-0" style="color:#FF0000; text-align:center;">Sample Size: Left: 14mm / Top: 32mm / Width: 60mm / Height: 6mm /Font Size: 15</p>
<div class="row">
        <div class="col-sm-6">
		        
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Left: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="bearer_left" type="text" id="bearer_left" tabindex="1" value="<?=$bearer_left;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Top: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="bearer_top"  type="text" id="bearer_top" tabindex="1" value="<?=$bearer_top;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Width: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="bearer_width"  type="text" id="bearer_width" tabindex="1" value="<?=$bearer_width;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Hight: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="bearer_hight"  type="text" id="bearer_hight" tabindex="1" value="<?=$bearer_hight;?>" > <span>mm</span>
                    </div>
                </div>


        </div>
		
		<div class="col-sm-6">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Align: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">																			
					<select name="bearer_align" onchange="applyAlignment('bearer','bearer_align')" id="bearer_align" value="<?=$bearer_align?>" >
						<option><?=$bearer_align?></option> 
                      	<option value="left">LEFT</option>    
					    <option value="center">CENTER</option>                		
						<option value="right">RIGHT</option>
					 </select>	
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Font Name: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="bearer_font"  type="text" id="bearer_font" tabindex="1" value="<?=$bearer_font;?>" >
                    </div>
                </div>
			
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="bearer_font_size"  type="text" id="bearer_font_size" tabindex="1" value="<?=$bearer_font_size;?>" >
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                            
							<button id="bearer_minusBtnY">Up</button>
							<button id="bearer_plusBtnY">Down</button>
                            <button id="bearer_minusBtnX">Left</button>
                            <button id="bearer_plusBtnX">Right</button>
                            
                    </div>
                </div>

        </div>
		
</div>
  
  </div>
  
  <div class="tab-pane fade n-form" id="five" role="tabpanel" aria-labelledby="five-tab">
  <p class="p-0" style="color:#FF0000; text-align:center;">Sample Size: Left: 25mm / Top: 45mm / Width: 60mm / Height: 6mm /Font Size: 15</p>
<div class="row">
        <div class="col-sm-6">
		        
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Left: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="muri_amount_left"  type="text" id="muri_amount_left" tabindex="1" value="<?=$muri_amount_left;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Top: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="muri_amount_top" type="text" id="muri_amount_top" tabindex="1" value="<?=$muri_amount_top;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Width: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="muri_amount_width"  type="text" id="muri_amount_width" tabindex="1" value="<?=$muri_amount_width;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Hight: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="muri_amount_height"  type="text" id="muri_amount_height" tabindex="1" value="<?=$muri_amount_height;?>" > <span>mm</span>
                    </div>
                </div>


        </div>
		
		<div class="col-sm-6">
		
				<!--<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">Line Height: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="in_words_line_height"  type="text" id="in_words_line_height" tabindex="1" value="<?=$in_words_line_height;?>" > <span>mm</span>
                    </div>
                </div>-->
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Align: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">																			
					<select name="muri_amount_align" onchange="applyAlignment('muri_amount_align','muri_amount_align')" id="muri_amount_align" value="<?=$muri_amount_align?>" >
						<option><?=$muri_amount_align?></option> 
                      	<option value="left">LEFT</option>    
					    <option value="center">CENTER</option>                		
						<option value="right">RIGHT</option>
					 </select>	
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Font Name: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="muri_amount_front"  type="text" id="muri_amount_front" tabindex="1" value="<?=$muri_amount_front;?>" >
                    </div>
                </div>
			
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>

                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="muri_amount_front_size"  type="text" id="muri_amount_front_size" tabindex="1" value="<?=$muri_amount_front_size;?>" >
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                            
							<button id="muri_amount_minusBtnY">Up</button>
							<button id="muri_amount_plusBtnY">Down</button>
                             <button id="muri_amount_minusBtnX">Left</button>
                            <button id="muri_amount_plusBtnX">Right</button>
                           
                    </div>
                </div>

        </div>
		
</div>
  
  </div>
  
  <div class="tab-pane fade n-form" id="three" role="tabpanel" aria-labelledby="three-tab">
  <p class="p-0" style="color:#FF0000; text-align:center;">Sample Size: Left: 87mm / Top: 41mm / Width: 100mm / Height: 9mm /Font Size: 15</p>
<div class="row">
        <div class="col-sm-6">
		        
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Left: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="in_words_left"  type="text" id="in_words_left" tabindex="1" value="<?=$in_words_left;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Top: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="in_words_top" type="text" id="in_words_top" tabindex="1" value="<?=$in_words_top;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Width: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="in_words_width"  type="text" id="in_words_width" tabindex="1" value="<?=$in_words_width;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Hight: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="in_words_hight"  type="text" id="in_words_hight" tabindex="1" value="<?=$in_words_hight;?>" > <span>mm</span>
                    </div>
                </div>


        </div>
		
		<div class="col-sm-6">
		
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">Line Height: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="in_words_line_height"  type="text" id="in_words_line_height" tabindex="1" value="<?=$in_words_line_height;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Align: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">																			
					<select name="in_words_align" onchange="applyAlignment('chq_inwords_n1','in_words_align')" id="in_words_align" value="<?=$in_words_align?>" >
						<option><?=$in_words_align?></option> 
                      	<option value="left">LEFT</option>    
					    <option value="center">CENTER</option>                		
						<option value="right">RIGHT</option>
					 </select>	
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Font Name: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="in_words_font"  type="text" id="in_words_font" tabindex="1" value="<?=$in_words_font;?>" >
                    </div>
                </div>
			
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="in_words_font_size"  type="text" id="in_words_font_size" tabindex="1" value="<?=$in_words_font_size;?>" >
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                            
							<button id="chq_inwords_n1_minusBtnY">Up</button>
							<button id="chq_inwords_n1_plusBtnY">Down</button>
                            <button id="chq_inwords_n1_minusBtnX">Left</button>
                            <button id="chq_inwords_n1_plusBtnX">Right</button>
                            
                    </div>
                </div>

        </div>
		
</div>
  
  </div>
  
  
  
  <div class="tab-pane fade n-form" id="four" role="tabpanel" aria-labelledby="four-tab">
  <p class="p-0" style="color:#FF0000; text-align:center;">Sample Size: Left: 195mm / Top: 43mm / Width: 57mm / Height: 13mm /Font Size: 15</p>
<div class="row">
        <div class="col-sm-6">
		        
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Left: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="amount_left"  type="text" id="amount_left" tabindex="1" value="<?=$amount_left;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Top: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="amount_top"  type="text" id="amount_top" tabindex="1" value="<?=$amount_top;?>" > <span>mm</span>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Width: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="amount_width"  type="text" id="amount_width" tabindex="1" value="<?=$amount_width;?>" > <span>mm</span>
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Hight: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="amount_hight"  type="text" id="amount_hight" tabindex="1" value="<?=$amount_hight;?>" > <span>mm</span>
                    </div>
                </div>


        </div>
		
		<div class="col-sm-6">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Align: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">																			
					<select name="amount_align" onchange="applyAlignment('amount','amount_align')" id="amount_align" value="<?=$amount_align?>" >
						<option><?=$amount_align?></option> 
                      	<option value="left">LEFT</option>    
					    <option value="center">CENTER</option>                		
						<option value="right">RIGHT</option>
					 </select>	
                    </div>
                </div>
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label ">  Font Name: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="amount_font" type="text" id="amount_font" tabindex="1" value="<?=$amount_font;?>" >
                    </div>
                </div>
			
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                    <input name="amount_font_size"  type="text" id="amount_font_size" tabindex="1" value="<?=$amount_font_size;?>" >
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-5 pl-0 pr-0 col-form-label "> Font Size: </label>
                    <div class="col-sm-7 p-0 d-flex  align-items-center">														
                            
							<button id="amount_minusBtnY">Up</button>
							<button id="amount_plusBtnY">Down</button>
                            <button id="amount_minusBtnX">Left</button>
                            <button id="amount_plusBtnX">Right</button>
                            
                    </div>
                </div>

        </div>
		
				
		<div class="col-sm-12 col-md-12 n-form-btn-class">
					<? if(!isset($_POST[$unique])&&!isset($_GET[$unique])) {?>
					<input name="submit" type="submit" id="submit" value="SAVE" class="btn1 btn1-bg-submit">
					
					<? }?>
                     
					 <? if(isset($_POST[$unique])||isset($_GET[$unique])) {?>
					 <input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update">

					<? }?>

                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='cheque_book_settings_entry.php'">
                    

                 
                </div>
		
</div>
  
  </div>
  
  
  
  
  
	</div>
    </div>
  </div>
  
</form>
  
  
  
</div>
<!-- /.container -->
<?php
	$style=find_all_field('chq_print_setup','','chq_print_id="'.$_GET[$unique].'"');
 ?>
<style type="text/css">
		.body {
/*			width: 210mm;
			height: 297mm;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;*/
			position:relative;
			background-color:#99FFFF !important;
		}

		/* Style content with shaded background */
		.chq-content {
			width: <?=$style->width?>mm;
			height: <?=$style->height?>mm;
			padding: 4mm;
			box-sizing: border-box;
			font-family: Arial, sans-serif;
			background-color: #f0f0f0;
		}
		
		.account-payee, .chq-date, .chq-pay-name, .bearer, .chq-inwords-n1, .chq-inwords-n2, .amount,.muri_amount{
			position:absolute !important;
			border:1px solid #333;
			padding: 3px;
		}
		

		
		.chq-date{
			left: <?=$style->date_left;?>mm;
			top: <?=$style->date_top;?>mm;
			border:none;
			display:flex;
			justify-content: center;
		}

		.chq-date .latter3, .chq-date .latter5{
			margin-left:<?=$style->date_section;?>mm;
		}
		
				

			.muri_amount{
			left: <?=$style->muri_amount_left; ?>mm;
			top: <?=$style->muri_amount_top; ?>mm;
			width:<?=$style->muri_amount_width; ?>mm;
			height:<?=$style->muri_amount_height; ?>mm;
			display:flex;
			justify-content: <?=$style->muri_amount_align; ?>;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:<?=$style->muri_amount_front_size; ?>px;
		}					
		
		
						

		
								
		.chq-inwords-n2{
			left: 5mm;
			top: 46mm;
			width:120mm;
			height:8mm;
			display:flex;
			justify-content: center;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:15px;
		}
		
										

</style>



<div class="body">
		<div class="chq-content">
		<div id="accountPayee"   style="position: absolute; left: <?= $style->acct_pay_left; ?>mm; top: <?= $style->acct_pay_top; ?>mm; width: <?= $style->acct_pay_width; ?>mm; height: <?= $style->acct_pay_hight; ?>mm; display: flex; justify-content: <?= $style->acct_pay_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->acct_pay_font_size; ?>px;" class="account-payee">Cheque Date</div>
		
		<div id="muri_amount"   style="position: absolute; left: <?= $style->muri_amount_left; ?>mm; top: <?= $style->muri_amount_top; ?>mm; width: <?= $style->muri_amount_width; ?>mm; height: <?= $style->muri_amount_height; ?>mm; display: flex; justify-content: <?= $style->muri_amount_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->muri_amount_front_size; ?>px;" class="muri_amount">Cheque Amount</div>
		
		
		
		<div id="chq_date" style=" border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px; left: <?= $style->date_left; ?>mm; top: <?= $style->date_top; ?>mm; border: none; display: flex; justify-content: center;" class="chq-date">
			<div style="width: <?= $style->date_width; ?>mm; height: <?= $style->date_hight; ?>mm; border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px;"  id="latter1" class="latter1">0</div>
			<div style="width: <?= $style->date_width; ?>mm; height: <?= $style->date_hight; ?>mm; border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px;"  id="latter2" class="latter2">0</div>
			<div style="width: <?= $style->date_width; ?>mm; height: <?= $style->date_hight; ?>mm; border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px;"  id="latter3" class="latter3">0</div>
			<div style="width: <?= $style->date_width; ?>mm; height: <?= $style->date_hight; ?>mm; border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px;"  id="latter4" class="latter4">0</div>
			<div style="width: <?= $style->date_width; ?>mm; height: <?= $style->date_hight; ?>mm; border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px;"  id="latter5" class="latter5">0</div>
			<div style="width: <?= $style->date_width; ?>mm; height: <?= $style->date_hight; ?>mm; border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px;"  id="latter6" class="latter6">0</div>
			<div style="width: <?= $style->date_width; ?>mm; height: <?= $style->date_hight; ?>mm; border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px;"  id="latter7" class="latter7">0</div>
			<div style="width: <?= $style->date_width; ?>mm; height: <?= $style->date_hight; ?>mm; border: 1px solid #333; margin-left: <?= $style->date_letter; ?>mm; display: flex; justify-content: <?= $style->date_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->date_font_size; ?>px;"  id="latter8" class="latter8">0</div>
		</div>
		<div id="chq_pay_name" style="left: <?= $style->name_left; ?>mm; top: <?= $style->name_top; ?>mm; width: <?= $style->name_width; ?>mm; height: <?= $style->name_hight; ?>mm; display: flex; justify-content: <?= $style->name_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->name_font_size; ?>px;" class="chq-pay-name">Pay To Testing Name</div>
		<div id="bearer" style="left: <?= $style->bearer_left; ?>mm; top: <?= $style->bearer_top; ?>mm; width: <?= $style->bearer_width; ?>mm; height: <?= $style->bearer_hight; ?>mm; display: flex; justify-content: <?= $style->bearer_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->bearer_font_size; ?>px;" class="bearer">Pay to Cheque</div>
		<div id="chq_inwords_n1" style="left: <?= $style->in_words_left; ?>mm; top: <?= $style->in_words_top; ?>mm; width: <?= $style->in_words_width; ?>mm; height: <?= $style->in_words_hight; ?>mm; line-height: <?= $style->in_words_line_height; ?>mm; display: flex; justify-content: <?= $style->in_words_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->in_words_font_size; ?>px;" class="chq-inwords-n1">Amount in Words</div>
		<!--<div class="chq-inwords-n2">Amount in word</div>-->
		<div id="amount" style="left: <?= $style->amount_left; ?>mm; top: <?= $style->amount_top; ?>mm; width: <?= $style->amount_width; ?>mm; height: <?= $style->amount_hight; ?>mm; display: flex; justify-content: <?= $style->amount_align; ?>; align-items: center; font-family: Arial, Helvetica, sans-serif; font-size: <?= $style->amount_font_size; ?>px;" class="amount">**00000**</div>

		
		</div>

</div>


<script>



function applyAlignment(elementId,fromtextstyle) {
   
        var selectedAlignment = document.getElementById(fromtextstyle).value;
        document.getElementById(elementId).style.justifyContent  = selectedAlignment;
    }

    //for Account Payeee

  const plusBtnY = document.getElementById('plusBtnY');
  const minusBtnY = document.getElementById('minusBtnY');
  const plusBtnX = document.getElementById('plusBtnX');
  const minusBtnX = document.getElementById('minusBtnX');

  plusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('accountPayee', 'top', 2,'acct_pay_top');
 
});

minusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('accountPayee', 'top', -2,'acct_pay_top');
 
});

plusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('accountPayee', 'left', 2,'acct_pay_left');
  
});

minusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('accountPayee', 'left', -2,'acct_pay_left');

});


    //for  Payeee  Name

  const chq_pay_name_plusBtnY = document.getElementById('plusBtnY_chq_pay_name');
  const chq_pay_name_minusBtnY = document.getElementById('minusBtnY_chq_pay_name');
  const chq_pay_name_plusBtnX = document.getElementById('plusBtnX_chq_pay_name');
  const chq_pay_name_minusBtnX = document.getElementById('minusBtnX_chq_pay_name');



  chq_pay_name_plusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_pay_name', 'top', 2,'name_top');
 
});

chq_pay_name_minusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_pay_name', 'top', -2,'name_top');
 
});

chq_pay_name_plusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_pay_name', 'left', 2,'name_left');
  
});

chq_pay_name_minusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_pay_name', 'left', -2,'name_left');

});
   


//for  Bearer


  const bearer_plusBtnY = document.getElementById('bearer_plusBtnY');
  const bearer_minusBtnY = document.getElementById('bearer_minusBtnY');
  const bearer_plusBtnX = document.getElementById('bearer_plusBtnX');
  const bearer_minusBtnX = document.getElementById('bearer_minusBtnX');



  bearer_plusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('bearer', 'top', 2,'bearer_top');
 
});

bearer_minusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('bearer', 'top', -2,'bearer_top');
 
});

bearer_plusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('bearer', 'left', 2,'bearer_left');
  
});

bearer_minusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('bearer', 'left', -2,'bearer_left');

});


//for  chq_inwords_n1


  const chq_inwords_n1_plusBtnY = document.getElementById('chq_inwords_n1_plusBtnY');
  const chq_inwords_n1_minusBtnY = document.getElementById('chq_inwords_n1_minusBtnY');
  const chq_inwords_n1_plusBtnX = document.getElementById('chq_inwords_n1_plusBtnX');
  const chq_inwords_n1_minusBtnX = document.getElementById('chq_inwords_n1_minusBtnX');



  chq_inwords_n1_plusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_inwords_n1', 'top', 2,'in_words_top');
 
});

chq_inwords_n1_minusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_inwords_n1', 'top', -2,'in_words_top');
 
});

chq_inwords_n1_plusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_inwords_n1', 'left', 2,'in_words_left');
  
});

chq_inwords_n1_minusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_inwords_n1', 'left', -2,'in_words_left');

});



//for  amount


  const amount_plusBtnY = document.getElementById('amount_plusBtnY');
  const amount_minusBtnY = document.getElementById('amount_minusBtnY');
  const amount_plusBtnX = document.getElementById('amount_plusBtnX');
  const amount_minusBtnX = document.getElementById('amount_minusBtnX');



  amount_plusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('amount', 'top', 2,'amount_top');
 
});

amount_minusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('amount', 'top', -2,'amount_top');
 
});

amount_plusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('amount', 'left', 2,'amount_left');
  
});

amount_minusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('amount', 'left', -2,'amount_left');

});


//for  muri amount


  const muri_amount_plusBtnY = document.getElementById('muri_amount_plusBtnY');
  const muri_amount_minusBtnY = document.getElementById('muri_amount_minusBtnY');
  const muri_amount_plusBtnX = document.getElementById('muri_amount_plusBtnX');
  const muri_amount_minusBtnX = document.getElementById('muri_amount_minusBtnX');
//
//
//
  muri_amount_plusBtnY.addEventListener('click', () => {

    event.preventDefault();
    updateStyle('muri_amount', 'top', 2,'muri_amount_top');
 
});
//
muri_amount_minusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('muri_amount', 'top', -2,'muri_amount_top');
 
});
//
muri_amount_plusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('muri_amount', 'left', 2,'muri_amount_left');
  
});
//
muri_amount_minusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('muri_amount', 'left', -2,'muri_amount_left');

});
//for  date



  const chq_date_plusBtnY = document.getElementById('chq_date_plusBtnY');
  const chq_date_minusBtnY = document.getElementById('chq_date_minusBtnY');
  const chq_date_plusBtnX = document.getElementById('chq_date_plusBtnX');
  const chq_date_minusBtnX = document.getElementById('chq_date_minusBtnX');



  chq_date_plusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_date', 'top', 2,'date_top');
 
});

chq_date_minusBtnY.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_date', 'top', -2,'date_top');
 
});

chq_date_plusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_date', 'left', 2,'date_left');
  
});

chq_date_minusBtnX.addEventListener('click', () => {
    event.preventDefault();
    updateStyle('chq_date', 'left', -2,'date_left');

});






// Function to update the style of the specified element
function updateStyle(elementId, property, valueChange, inputfeildtoupdate) {
    const element = document.getElementById(elementId);
    const currentStyleValue = parseInt(element.style[property] || 0);
    element.style[property] = (currentStyleValue + valueChange) + 'mm';
    document.getElementById(inputfeildtoupdate).value= (currentStyleValue + valueChange);
}






     //for account payeee

        const acctPayLeftInput = document.getElementById('acct_pay_left');
        const acctPayTopInput = document.getElementById('acct_pay_top');
        const acctPayWidthInput = document.getElementById('acct_pay_width');
        const acctPayHeightInput = document.getElementById('acct_pay_hight');

        acctPayLeftInput.addEventListener('input', updatePosition);
        acctPayTopInput.addEventListener('input', updatePosition);
        acctPayWidthInput.addEventListener('input', updateWidth);
        acctPayHeightInput.addEventListener('input', updateHeight);

        function updatePosition() {
            const fffchild = document.getElementById("accountPayee");
            fffchild.style.left = acctPayLeftInput.value + 'mm'; // Update left position
            fffchild.style.top = acctPayTopInput.value + 'mm'; // Update top position
        }

        function updateWidth() {
            const fffchild = document.getElementById("accountPayee");
            fffchild.style.width = acctPayWidthInput.value + 'mm'; // Update width
        }
        function updateHeight() {
            const fffchild = document.getElementById("accountPayee");
            fffchild.style.height = acctPayHeightInput.value + 'mm'; // Update widthchq_pay_name_
        }


        //for payee name 
        const chq_pay_name_acctPayLeftInput = document.getElementById('name_left');
        const chq_pay_name_acctPayTopInput = document.getElementById('name_top');
        const chq_pay_name_acctPayWidthInput = document.getElementById('name_width');
        const chq_pay_name_acctPayHeightInput = document.getElementById('name_hight');

        chq_pay_name_acctPayLeftInput.addEventListener('input', chq_pay_name_updatePosition);
        chq_pay_name_acctPayTopInput.addEventListener('input', chq_pay_name_updatePosition);
        chq_pay_name_acctPayWidthInput.addEventListener('input', chq_pay_name_updateWidth);
        chq_pay_name_acctPayHeightInput.addEventListener('input', chq_pay_name_updateHeight);

        function chq_pay_name_updatePosition(elementid) {
           
            const fffchild = document.getElementById("chq_pay_name");
            fffchild.style.left = chq_pay_name_acctPayLeftInput.value + 'mm'; // Update left position
            fffchild.style.top = chq_pay_name_acctPayTopInput.value + 'mm'; // Update top position
        }

        function chq_pay_name_updateWidth() {
            const fffchild = document.getElementById("chq_pay_name");
            fffchild.style.width = chq_pay_name_acctPayWidthInput.value + 'mm'; // Update width
        }
        function chq_pay_name_updateHeight() {
            const fffchild = document.getElementById("chq_pay_name");
            fffchild.style.height = chq_pay_name_acctPayHeightInput.value + 'mm'; // Update width
        }




        //for Bearer 
        const bearer_acctPayLeftInput = document.getElementById('name_left');
        const bearer_acctPayTopInput = document.getElementById('name_top');
        const bearer_acctPayWidthInput = document.getElementById('name_width');
        const bearer_acctPayHeightInput = document.getElementById('name_hight');

        bearer_acctPayLeftInput.addEventListener('input', bearer_updatePosition);
        bearer_acctPayTopInput.addEventListener('input', bearer_updatePosition);
        bearer_acctPayWidthInput.addEventListener('input', bearer_updateWidth);
        bearer_acctPayHeightInput.addEventListener('input', bearer_updateHeight);

        function bearer_updatePosition(elementid) {
           
            const fffchild = document.getElementById("bearer");
            fffchild.style.left = bearer_acctPayLeftInput.value + 'mm'; // Update left position
            fffchild.style.top = bearer_acctPayTopInput.value + 'mm'; // Update top position
        }

        function bearer_updateWidth() {
            const fffchild = document.getElementById("bearer");
            fffchild.style.width = bearer_acctPayWidthInput.value + 'mm'; // Update width
        }
        function bearer_updateHeight() {
            const fffchild = document.getElementById("bearer");
            fffchild.style.height = bearer_acctPayHeightInput.value + 'mm'; // Update width
        }




        //for chq_inwords_n1
        const chq_inwords_n1_acctPayLeftInput = document.getElementById('in_words_left');
        const chq_inwords_n1_acctPayTopInput = document.getElementById('in_words_top');
        const chq_inwords_n1_acctPayWidthInput = document.getElementById('in_words_width');
        const chq_inwords_n1_acctPayHeightInput = document.getElementById('in_words_hight');

        chq_inwords_n1_acctPayLeftInput.addEventListener('input', chq_inwords_n1_updatePosition);
        chq_inwords_n1_acctPayTopInput.addEventListener('input', chq_inwords_n1_updatePosition);
        chq_inwords_n1_acctPayWidthInput.addEventListener('input', chq_inwords_n1_updateWidth);
        chq_inwords_n1_acctPayHeightInput.addEventListener('input', chq_inwords_n1_updateHeight);

        function chq_inwords_n1_updatePosition(elementid) {
           
            const fffchild = document.getElementById("chq_inwords_n1");
            fffchild.style.left = chq_inwords_n1_acctPayLeftInput.value + 'mm'; // Update left position
            fffchild.style.top = chq_inwords_n1_acctPayTopInput.value + 'mm'; // Update top position
        }

        function chq_inwords_n1_updateWidth() {
            const fffchild = document.getElementById("chq_inwords_n1");
            fffchild.style.width = chq_inwords_n1_acctPayWidthInput.value + 'mm'; // Update width
        }
        function chq_inwords_n1_updateHeight() {
            const fffchild = document.getElementById("chq_inwords_n1");
            fffchild.style.height = chq_inwords_n1_acctPayHeightInput.value + 'mm'; // Update width
        }




        //for amount

        const amount_acctPayLeftInput = document.getElementById('amount_left');
        const amount_acctPayTopInput = document.getElementById('amount_top');
        const amount_acctPayWidthInput = document.getElementById('amount_width');
        const amount_acctPayHeightInput = document.getElementById('amount_hight');

        amount_acctPayLeftInput.addEventListener('input', amount_updatePosition);
        amount_acctPayTopInput.addEventListener('input', amount_updatePosition);
        amount_acctPayWidthInput.addEventListener('input', amount_updateWidth);
        amount_acctPayHeightInput.addEventListener('input', amount_updateHeight);

        function amount_updatePosition(elementid) {
           
            const fffchild = document.getElementById("amount");
            fffchild.style.left = amount_acctPayLeftInput.value + 'mm'; // Update left position
            fffchild.style.top = amount_acctPayTopInput.value + 'mm'; // Update top position
        }

        function amount_updateWidth() {
            const fffchild = document.getElementById("amount");
            fffchild.style.width = amount_acctPayWidthInput.value + 'mm'; // Update width
        }
        function amount_updateHeight() {
            const fffchild = document.getElementById("amount");
            fffchild.style.height = amount_acctPayHeightInput.value + 'mm'; // Update width
        }
		
		
		
		//for muri amount

        const muri_amount_acctPayLeftInput = document.getElementById('muri_amount_left');
        const muri_amount_acctPayTopInput = document.getElementById('muri_amount_top');
        const muri_amount_acctPayWidthInput = document.getElementById('muri_amount_width');
        const muri_amount_acctPayHeightInput = document.getElementById('muri_amount_hight');

        muri_amount_acctPayLeftInput.addEventListener('input', muri_amount_updatePosition);
        muri_amount_acctPayTopInput.addEventListener('input', muri_amount_updatePosition);
        muri_amount_acctPayWidthInput.addEventListener('input', muri_amount_updateWidth);
        muri_amount_acctPayHeightInput.addEventListener('input', muri_amount_updateHeight);

        function muri_amount_updatePosition(elementid) {
           
            const fffchild = document.getElementById("muri_amount");
            fffchild.style.left = muri_amount_acctPayLeftInput.value + 'mm'; // Update left position
            fffchild.style.top = muri_amount_acctPayTopInput.value + 'mm'; // Update top position
        }

        function muri_amount_updateWidth() {
            const fffchild = document.getElementById("muri_amount");
            fffchild.style.width = muri_amount_acctPayWidthInput.value + 'mm'; // Update width
        }
        function muri_amount_updateHeight() {
            const fffchild = document.getElementById("muri_amount");
            fffchild.style.height = muri_amount_acctPayHeightInput.value + 'mm'; // Update width
        }
        //for date


        const chq_date_acctPayLeftInput = document.getElementById('date_left');
        const chq_date_acctPayTopInput = document.getElementById('date_top');
        const chq_date_acctPayWidthInput = document.getElementById('date_width');
        const chq_date_acctPayHeightInput = document.getElementById('date_hight');

        chq_date_acctPayLeftInput.addEventListener('input', chq_date_updatePosition);
        chq_date_acctPayTopInput.addEventListener('input', chq_date_updatePosition);
        chq_date_acctPayWidthInput.addEventListener('input', chq_date_updateWidth);
        chq_date_acctPayHeightInput.addEventListener('input', chq_date_updateHeight);

        function chq_date_updatePosition(elementid) {
           
            const fffchild = document.getElementById("chq_date");
            fffchild.style.left = chq_date_acctPayLeftInput.value + 'mm'; // Update left position
            fffchild.style.top = chq_date_acctPayTopInput.value + 'mm'; // Update top position
        }

        function chq_date_updateWidth() {
           
            // const fffchild = document.getElementById("chq_date");
            const fffchild1 = document.getElementById("latter1");
            const fffchild2 = document.getElementById("latter2");
            const fffchild3 = document.getElementById("latter3");
            const fffchild4 = document.getElementById("latter4");
            const fffchild5 = document.getElementById("latter5");
            const fffchild6 = document.getElementById("latter6");
            const fffchild7 = document.getElementById("latter7");
            const fffchild8 = document.getElementById("latter8");
            fffchild1.style.width = chq_date_acctPayWidthInput.value + 'mm'; // Update width
            fffchild2.style.width = chq_date_acctPayWidthInput.value + 'mm'; // Update width
            fffchild3.style.width = chq_date_acctPayWidthInput.value + 'mm'; // Update width
            fffchild4.style.width = chq_date_acctPayWidthInput.value + 'mm'; // Update width
            fffchild5.style.width = chq_date_acctPayWidthInput.value + 'mm'; // Update width
            fffchild6.style.width = chq_date_acctPayWidthInput.value + 'mm'; // Update width
            fffchild7.style.width = chq_date_acctPayWidthInput.value + 'mm'; // Update width
            fffchild8.style.width = chq_date_acctPayWidthInput.value + 'mm'; // Update width
        }
        function chq_date_updateHeight() {
           
//alert('gggggggggggggggggggggggg');

                        
            const fffchild1 = document.getElementById("latter1");
            const fffchild2 = document.getElementById("latter2");
            const fffchild3 = document.getElementById("latter3");
            const fffchild4 = document.getElementById("latter4");
            const fffchild5 = document.getElementById("latter5");
            const fffchild6 = document.getElementById("latter6");
            const fffchild7 = document.getElementById("latter7");
            const fffchild8 = document.getElementById("latter8");
            fffchild1.style.height = chq_date_acctPayHeightInput.value + 'mm'; // Update width
            fffchild2.style.height = chq_date_acctPayHeightInput.value + 'mm'; // Update width
            fffchild3.style.height = chq_date_acctPayHeightInput.value + 'mm'; // Update width
            fffchild4.style.height = chq_date_acctPayHeightInput.value + 'mm'; // Update width
            fffchild5.style.height = chq_date_acctPayHeightInput.value + 'mm'; // Update width
            fffchild6.style.height = chq_date_acctPayHeightInput.value + 'mm'; // Update width
            fffchild7.style.height = chq_date_acctPayHeightInput.value + 'mm'; // Update width
            fffchild8.style.height = chq_date_acctPayHeightInput.value + 'mm'; // Update width


 // Update width
        }







</script>



</div>

<?
    $page_name='Cheque Book Settings Entry' ; 
	require_once SERVER_CORE."routing/layout.bottom.php";
?>