<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Basic Reports';

$tr_type="Show";
$php_ip=substr($_SESSION['php_ip'],0,11);
if($php_ip=='115.127.35.' || $php_ip=='192.168.191'){ 
do_calander('#f_date'/*,'-1800','0'*/);
do_calander('#t_date'/*,'-1800','30'*/);
} else {
	do_calander('#f_date'/*,'-60','0'*/);
	do_calander('#t_date'/*,'-60','0'*/);		
}
do_calander("#cut_date");



$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Build the full URL
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


$trimmed_path = str_replace("https://saaserp.ezzy-erp.com/app/views/", "", $url);
$parts = explode('/', $trimmed_path);

 $mod_name = $parts[0]; 
 $folder_name = $parts[1];
 $page_name = $parts[2]; 


	 $res2 ='SELECT  r.folder_name, r.report_no, r.feature_id,r.page_id, p.id AS page_id, f.id AS feature_id, f.feature_name,  m.id AS module_id,  m.module_name
			FROM  user_page_manage p JOIN  user_feature_manage f ON p.feature_id = f.id JOIN  user_module_manage m ON f.module_id = m.id, report_manage r
			WHERE  m.module_file="'.$mod_name.'" and p.folder_name="'.$folder_name.'" and p.page_link="'.$page_name .'" and r.folder_name="'.$folder_name.'" and r.feature_id=f.id and r.page_id=p.id';

								$query=db_query($res2);
								
								While($row=mysqli_fetch_object($query)){
									$page_file[$row->page_no] = $row->page_id;
								}


?>




<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1" style="width:90%">
        <div class="row m-0 p-0">
            <div class="col-sm-6">
                <div align="left">Select Report </div>
				
				<?
					
							 //$res ='select report_name,page_id,report_no,status from report_manage where page_id="'.$page_file[$row->page_id].'" and status="Yes"';
							 
							 $res ='select r.id,r.report_name,r.page_id,r.report_no,r.status,u.user_id,a.user_id,a.report_id 
							 from report_manage r, user_activity_management u,user_report_access a 
							 where r.page_id="'.$page_file[$row->page_id].'" and a.report_id=r.id and a.user_id=u.user_id and u.user_id="'.$_SESSION['user']['id'].'" and a.access="1" and r.status="Yes"';
									
									$query=db_query($res);
								While($row=mysqli_fetch_object($query)){
								
								?>
               
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="<?=$row->report_no?>" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn1">
                         <?=$row->report_name?> (<?=$row->report_no?>)
                    </label>
                </div>
<? } ?>

            </div>
			
			
			
			
			 <!-- <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" />
                    <label class="form-check-label p-0" for="report1-btn">Sales Order Report (1)</label>
                    </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="301" />
                    <label class="form-check-label p-0" for="report1-btn">Undelivered DO Report (301)</label>
				</div>
			  <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1991"  />
                  <label class="form-check-label p-0" for="report1-btn">Delivery Details Report With Amount (1991)</label>
                </div>-->
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1992" />
                    <label class="form-check-label p-0" for="report1-btn">Sales Statement(As Per DO)</label>
                </div>-->
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1993" />
                    <label class="form-check-label p-0" for="report1-btn">Party Collection Summery Group wise</label>
				</div>-->
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="191" />
                    <label class="form-check-label p-0" for="report1-btn">Delivery Summary Report With Amount (191)</label>
				</div>-->

            <div class="col-sm-6" style="width:50%">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name:</label>
                    <div class="col-sm-8 p-0">
						<input type="text" list="item" name="item_id" id="item_id" class="form-control" />
                        <datalist id="item" >
                       		 <option></option>
                      
							<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                   		 </datalist>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Dealer Name:</label>
                    <div class="col-sm-8 p-0">
						<input type="text" list="dealer" name="dealer_code" id="dealer_code" />
						<datalist id="dealer" >
                        
						  <option></option>
						  <? foreign_relation('dealer_info','dealer_code','dealer_name_e');?>
						</datalist>
                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Category:</label>
                    <div class="col-sm-8 p-0">
						<input type="text" list="brand" name="item_brand" id="item_brand" />
                        <datalist id="brand">
						  <option></option>
						  <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>
						</datalist>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">

                        <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>


                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Inventory Name:</label>
                    <div class="col-sm-8 p-0">
                           
							 
							  <select name="depot_id" id="depot_id" >
			 							<option></option>
                  						<? foreign_relation('warehouse w, warehouse_define d','w.warehouse_id','w.warehouse_name',$depot_id,					 'w.warehouse_id=d.warehouse_id and w.use_type="WH" and d.user_id="'.$_SESSION['user']['id'].'" and d.status="Active"');?>
									</select>

                    </div>
                </div>


            </div>

        </div>
        <div class="n-form-btn-class">
			
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
        </div>
    </form>
</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>