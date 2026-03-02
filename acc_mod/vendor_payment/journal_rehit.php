<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Advance Payment';

do_calander('#fdate');

do_calander('#tdate');

$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';




echo $sqll= "SELECT jv_no,jv_date,tr_from,tr_no,sum(dr_amt-cr_amt) FROM `journal` WHERE  tr_from='Production Receive'
group by jv_no HAVING sum(dr_amt-cr_amt)!=0";

				$queryy= db_query($sqll);
				
				while($data=mysqli_fetch_object($queryy)){
	
					  $sec_data =find_a_field('secondary_journal','count(jv_no)',' tr_from="'.$data->tr_from.'" and jv_no='.$data->jv_no.'');
					
					if($sec_data>0){
				
						
					 	 $delete = 'delete  from journal where jv_no="'.$data->jv_no.'" and tr_from="'.$data->tr_from.'"';
						db_query($delete);
						
						
						sec_journal_journal2($data->jv_no,$data->jv_no,$data->tr_from);
						$_SESSION['success'] = '<span style="color:green;">Rehit Success!</span>';
						
						echo $data->jv_no.'-Done'.'<br>';
				
				
				}
}



//$sql ="SELECT * FROM `secondary_journal` WHERE `tr_from` LIKE 'Vendor_payment' GROUP by jv_no";
//$query =db_query($sql);
//
//$x=0;
//while($data=mysqli_fetch_object($query)){
//	$x++;
//	sec_journal_journal2($data->jv_no,$data->jv_no,$data->tr_from);
//	echo $x.'-Done.<br>';
//	
//	
//}










//if(isset($_POST['submitit'])){
//
//
//
//                $jv_no = $_POST['jv_no'];
//				$tr_from = $_POST['tr_from'];
//				
//
//					
//					if(($jv_no>0) && ($tr_from!='')){
//				
//				
//						$delete = 'delete * from journal where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//						db_query($delete);
//						sec_journal_journal2($jv_no,$jv_no,$tr_from);
//						$_SESSION['success'] = '<span style="color:green;">Rehit Success!</span>';
//						
//				
//				
//				}
//
//
//                 }

?>

<div class="form-container_large"><span style="color:green; font-weight:bold;"><?=$_SESSION['success'];unset($_SESSION['success'])?></span>
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">


                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">JV No.</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="jv_no" id="jv_no"  value="" />

                        </div>
                    </div>
                </div>
                
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Tr From</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="tr_from" id="tr_from">
                            <option></option>
                            <? foreign_relation('journal','tr_from','tr_from',$_POST['tr_from'],'1 group by tr_from')?>
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                   
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>

    </form>
</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>