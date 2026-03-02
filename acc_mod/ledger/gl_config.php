<?php
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 
 $tr_type="Show";


// ::::: Edit This Section ::::: 


create_combobox('sales_ledger');
create_combobox('sales_discount');
create_combobox('sales_return');
create_combobox('sales_vat');
create_combobox('cogs_ledger');
create_combobox('wip_ledger');
create_combobox('purchase_discount');
create_combobox('purchase_vat');
create_combobox('purchase_ait');
create_combobox('localPurchase');
create_combobox('localSales');
create_combobox('directSales');
create_combobox('cash_ledger');
create_combobox('bank_ledger');

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
		$tr_type="Edit";

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
<style>
.update-success {
    background: orange;
    border-color: #28a745;
    color: #fff !important;
    transition: all 0.4s ease;
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(40, 167, 69, 0.6);
}

.update-success::after {
    content: " ✓";
    font-weight: bold;
}
</style>


  
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

<div class="container-fluid">
			<div class="row m-0 p-0">
			
			<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card text-center">
					  <div class="card-body">
						<h5 class="card-title bold ">
						Accounts Type
						</h5>
						
						<div class="d-flex ustify-content-between p-3">
						 
						<select name="accounts_type" id="accounts_type">
						<option value="<?php echo $accounts_type;?>"><?php echo $accounts_type;?></option>
							<option value="Periodical">Periodical</option>
							<option value="Perpectual">Perpectual</option>
						</select>
						
						</div>
						<div >
						<input type="button" class="btn btn-success submit-btn" data-section="accounts_type"    value="Update" />
						</div>
						 
					  </div>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-12 new">
  <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title fw-bold">
        Sales Setup
      </h5>

      <div class="d-flex flex-column p-3 text-start">

        <label class="mb-1">Sales Ledger</label>
<select name="sales_ledger" id="sales_ledger" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$sales_ledger,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

        <label class="mb-1">Sales Discount</label>
<select name="sales_discount" id="sales_discount" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$sales_discount,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

        <label class="mb-1">Sales VAT</label>
<select name="sales_vat" id="sales_vat" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$sales_vat,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>
		    <label class="mb-1">Sales Return</label>
       <select name="sales_return" id="sales_return" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$sales_return,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>
			    <label class="mb-1">COGS</label>
              <select name="cogs_ledger" id="cogs_ledger" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$cogs_ledger,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

      </div>

      <div>
        <input type="button" class="btn btn-success submit-btn" data-section="sales_setup"   value="Update" />
      </div>

    </div>
  </div>
</div>

				
				<div class="col-lg-3 col-md-3 col-sm-12 new">
  <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title fw-bold">
        Purchase Setup
      </h5>

      <div class="d-flex flex-column p-3 text-start">

        <label class="mb-1">Purchase Discount</label>
              <select name="purchase_discount" id="purchase_discount" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$purchase_discount,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

        <label class="mb-1">Purchase VAT</label>
              <select name="purchase_vat" id="purchase_vat" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$purchase_vat,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

        <label class="mb-1">Purchase AIT</label>
              <select name="purchase_ait" id="purchase_ait" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$purchase_ait,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>
		    <label class="mb-1">Local Purchase</label>
              <select name="localPurchase" id="localPurchase" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$localPurchase,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>
	 

      </div>

      <div>
        <input type="button" class="btn btn-success submit-btn" data-section="purchase_setup"   value="Update" />
      </div>

    </div>
  </div>
</div>
				
				<div class="col-lg-3 col-md-3 col-sm-12 new">
  <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title fw-bold">
        WIP Setup
      </h5>

      <div class="d-flex flex-column p-3 text-start">

        <label class="mb-1">WIP Ledger</label>
      <select name="wip_ledger" id="wip_ledger" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$wip_ledger,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

        
	 

      </div>

      <div>
        <input type="button" class="btn btn-success submit-btn" data-section="wip_setup"   value="Update" />
      </div>

    </div>
  </div>
</div>
				
				<div class="col-lg-3 col-md-3 col-sm-12 new">
  <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title fw-bold">
       Local Sales
      </h5>

      <div class="d-flex flex-column p-3 text-start">

        <label class="mb-1">Local Sales Ledger</label>
      <select name="localSales" id="localSales" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$localSales,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

        
	 

      </div>

      <div>
        <input type="button" class="btn btn-success submit-btn" data-section="local_sales"   value="Update" />
      </div>

    </div>
  </div>
</div>
				
				<div class="col-lg-3 col-md-3 col-sm-12 new">
  <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title fw-bold">
        Direct Sales
      </h5>

      <div class="d-flex flex-column p-3 text-start">

        <label class="mb-1">Direct Sales Ledger</label>
       <select name="directSales" id="directSales" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$directSales,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

        
	 

      </div>

      <div>
        <input type="button" class="btn btn-success submit-btn" data-section="direct_sales"   value="Update" />
      </div>

    </div>
  </div>
</div>
				<div class="col-lg-3 col-md-3 col-sm-12 new">
  <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title fw-bold">
        Cash Ledger
      </h5>

      <div class="d-flex flex-column p-3 text-start">

        <label class="mb-1">Cash Ledger</label>
       <select name="cash_ledger" id="cash_ledger" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$cash_ledger,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>
        
	 

      </div>

      <div>
        <input type="button" class="btn btn-success submit-btn" data-section="cash_ledger"   value="Update" />
      </div>

    </div>
  </div>
</div>
				<div class="col-lg-3 col-md-3 col-sm-12 new">
  <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title fw-bold">
        Bank Ledger
      </h5>

      <div class="d-flex flex-column p-3 text-start">

        <label class="mb-1">Bank Ledger</label>
          <select name="bank_ledger" id="bank_ledger" class="form-control"  >
									<option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$bank_ledger,"1 and group_for='".$_SESSION['user']['group']."'  order by ledger_id");?>
</select>

        
	 

      </div>

      <div>
        <input type="button" class="btn btn-success submit-btn"   data-section="bank_ledger" value="Update" />
      </div>

    </div>
  </div>
</div>
			
			</div>
</div>							   

    </form>

  <script>
$(document).on('click', '.submit-btn', function(e){
    e.preventDefault();

    let btn = $(this);
    let originalText = btn.val();
    let section = btn.data('section');

    btn.prop('disabled', true).val('Updating...');

    let formData = new FormData($('#form1')[0]);
    formData.append('section', section);

    $.ajax({
        url: 'save_account_settings_ajax.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,

        success: function(response){

            // success popup (already working)
   

            // button success effect
            btn
              .val('Update Complete')
              .addClass('update-primary');

            // OPTIONAL: reset button after 3 seconds
            setTimeout(function(){
                btn
                  .prop('disabled', false)
                  .removeClass('update-success')
                  .val(originalText);
            }, 3000);
        },

        error: function(){
            btn.prop('disabled', false).val(originalText);
            alert('Something went wrong!');
        }
    });
});
</script>




<?

	 require_once SERVER_CORE."routing/layout.bottom.php";

?>