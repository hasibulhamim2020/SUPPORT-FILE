<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Direct Purchase Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = 'chalan_view2.php';

 if(isset($_POST['delete'])){
 $dp_no=$_POST['dp_no'];
 ///////backup data to table//////
 $ins_backup='insert into direct_purchase_delete_info(or_no,delete_by)values("'.$dp_no.'","'.$_SESSION['user']['id'].'")';
 db_query($ins_backup);
 
 /////////journal delete////
 $jour_delete='delete from journal where tr_no="'.$dp_no.'" and tr_from="DirectPurchase"';
 db_query($jour_delete);
 
 /////////secondary_journal delete////
  $sec_jour_delete='delete from secondary_journal where tr_no="'.$dp_no.'" and tr_from="DirectPurchase"';
 db_query($sec_jour_delete);
 
 /////////journal_item delete////
 $ji_delete='delete from journal_item where sr_no="'.$dp_no.'" and tr_from="DirectPurchase"';
 db_query($ji_delete);
 
 /////////warehouse Other Receive Details delete////
  $wrd_delete='delete from warehouse_other_receive_detail where or_no="'.$dp_no.'"';
  db_query($wrd_delete);
  
    /////////warehouse Other Receive delete////
   $wr_delete='delete from warehouse_other_receive where or_no="'.$dp_no.'"';
  db_query($wr_delete);
  
  echo "<h2 style='color:red;font-weight:bold;'>Deleted Successfully</h2>";
 }
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>



<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
         
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Direct Purchase No:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="dp_no" id="dp_no"    />
                        </div>
                    </div>

                </div>
                 

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
                    <input type="submit" name="delete" id="delete" value="Delete" class="btn1 btn1-bg-cancel"/ >
                </div>

            </div>
        </div>






         
    </form>
</div>













 

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>