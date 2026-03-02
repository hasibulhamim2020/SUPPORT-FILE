<?php






require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$tr_type="Show";



$title='Delivery Chalan Advence Reports';

$php_ip=substr($_SESSION['php_ip'],0,11);
if($php_ip=='115.127.35.' || $php_ip=='192.168.191'){ 
do_calander('#f_date'/*,'-1800','0'*/);
do_calander('#t_date'/*,'-1800','30'*/);
} else {
	do_calander('#f_date'/*,'-60','0'*/);
	do_calander('#t_date'/*,'-60','0'*/);		
}

do_calander("#cut_date");


if($_POST['target_month']!=''){
$target_month=$_POST['target_month'];}
else{
$target_month=date('n');
}

if($_POST['target_year']!=''){
$target_year=$_POST['target_year'];}
else{
$target_year=date('Y');
}
?>

<!--<tr>
<td><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
<td><div align="left">Territory Wise Target(1)</div></td>
</tr>-->

<div class="d-flex justify-content-center">
  <form action="master_report_target.php" class="n-form1 fo-width pt-4" method="post" name="form1" target="_blank" id="form1">
    <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="2" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                    Dealer Wise Target Ratio(2)
                    </label>
                </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="3"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                    Dealer Wise Target Qty(3)
                    </label>
                </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="4" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                    FO Wise Target Ratio(4)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="217"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                   Target Vs Achivement Report(Dealer Wise)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="218"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                   Target Vs Achivement Report(SO Wise)
                    </label>
                </div>
               <!-- <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="5"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                    FO Wise Target Qty(5)
                    </label>
                </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="6"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                    Product Wise Target(6)
                    </label>
                </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="15" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                    Check Target Qty(15)
                    </label>
                </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="16" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                    Dealer vs FO qty Check(16)
                    </label>
                </div>-->
            </div>
            <div class="col-sm-7">
              <div class="form-group row m-0 mb-1 pl-3 pr-3 d-none">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Company :</label>
                  <div class="col-sm-8 p-0">
                    <select name="by" id="by" class="form-control">
                      <option></option>
                      <? foreign_relation('user_group','id','company_short_code',$group_for,'1 order by company_short_code');?>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Group :</label>
                  <div class="col-sm-8 p-0">
                    <select name="by" id="by" class="form-control">
                      <option></option>
                      <? foreign_relation('product_group','id','group_name',$product_group,'1 order by group_name');?>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Category :</label>
                  <div class="col-sm-8 p-0">
                    <select name="by" id="by" class="form-control">
                      <option></option>
                      <? foreign_relation('item_category','id','category_name',$category_name,'1 order by category_name');?>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product SubCategory :</label>
                  <div class="col-sm-8 p-0">
                    <select name="by" id="by" class="form-control">
                      <option></option>
                      <? foreign_relation('item_subcategory','id','subcategory_name',$subcategory_name,'1 order by subcategory_name');?>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Name :</label>
                  <div class="col-sm-8 p-0">
                    <input style="width:250px" list="items" name="item_id" type="text" class="form-control"  value="" id="item_id" autocomplete="off"/>
                    <datalist id="items">
                    <? foreign_relation('item_info','item_id','concat(item_id,"->",finish_goods_code,"#",item_name)',$item_id,'1  ');?>
                    </datalist>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Year :</label>
                  <div class="col-sm-8 p-0">
                  <select name="year" style="width:160px;" id="year" required="required">
                      <option>2024</option>
                      <option>2025</option>
                      <option>2026</option>
                      <option>2027</option>
					  <option>2028</option>
					  <option>2029</option>
					  <option>2030</option>

                  </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Month :</label>
                  <div class="col-sm-8 p-0">
                    <select name="month" style="width:160px;" id="month" required="required">
                        <option value="1" <?=($target_month=='1')?'selected':''?>>Jan</option>
                        <option value="2" <?=($target_month=='2')?'selected':''?>>Feb</option>
                        <option value="3" <?=($target_month=='3')?'selected':''?>>Mar</option>
                        <option value="4" <?=($target_month=='4')?'selected':''?>>Apr</option>
                        <option value="5" <?=($target_month=='5')?'selected':''?>>May</option>
                        <option value="6" <?=($target_month=='6')?'selected':''?>>Jun</option>
                        <option value="7" <?=($target_month=='7')?'selected':''?>>Jul</option>
                        <option value="8" <?=($target_month=='8')?'selected':''?>>Aug</option>
                        <option value="9" <?=($target_month=='9')?'selected':''?>>Sep</option>
                        <option value="10" <?=($target_month=='10')?'selected':''?>>Oct</option>
                        <option value="11" <?=($target_month=='11')?'selected':''?>>Nov</option>
                        <option value="12" <?=($target_month=='12')?'selected':''?>>Dec</option>
                    </select>
                  </div>
              </div>
              
              
        <div class="form-group row m-0 mb-1 pl-3 pr-3">
            <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Distributor Name :</label>
            <div class="col-sm-8 p-0">
              <input style="width:250px" class="form-control" type="text" list="items" name="dealer_code" id="dealer_code" value="" autocomplete="off">
              <datalist id="party_list">
              <option></option>
              <? 
              $sql_party='select dealer_code,concat(dealer_code2,"-",dealer_name_e) from dealer_info where 1 ';
              foreign_relation_sql($sql_party);
              ?>
              </datalist>
            </div>
        </div>
          <!--<div class="row">-->
          <!--    <div class="col-5">From :</div>-->
          <!--    <div class="col-7">-->
          <!--        <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>-->
          <!--    </div>-->
          <!--</div>-->


          <!--<div class="row">-->
          <!--    <div class="col-5">To :</div>-->
          <!--    <div class="col-7">-->
          <!--        <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>-->
          <!--    </div>-->
          <!--</div>-->

        <div class="form-group row m-0 mb-1 pl-3 pr-3">
            <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Zone :</label>
            <div class="col-sm-8 p-0">
            <select class="form-control col-md-12" name="region_id"  id="region" onchange="FetchZone(this.value)">
                <option></option>
                <? //optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
            <? foreign_relation('branch', 'BRANCH_ID', 'BRANCH_NAME', $group_for, '1 order by BRANCH_NAME'); ?>
          
            </select>
            </div>
        </div>
        <div class="form-group row m-0 mb-1 pl-3 pr-3">
            <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Division :</label>
            <div class="col-sm-8 p-0">
            <select class="form-control col-md-12" name="zone_id"  id="zone" onchange="FetchArea(this.value)">
              <option value=""></option>
          </select>
            </div>
        </div>
        <div class="form-group row m-0 mb-1 pl-3 pr-3">
            <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Territory :</label>
          <div class="col-sm-8 p-0">
            <select class="form-control col-md-12" name="area_id"  id="area" onchange="FetchRoute(this.value)">
                <option value=""></option>
            </select>
          </div>
        </div>
        <div class="form-group row m-0 mb-1 pl-3 pr-3">
            <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">FO Code :</label>
          <div class="col-sm-8 p-0">
            <input list="browsers2" class="form-control" type="text" list="items" name="so_code" id="so_code">
            <datalist id="browsers2">
              <?php //optionlist('select username,concat(username," ",fname) from ss_user where 1 and status=1 order by username');?>
              
              <? foreign_relation('ss_user', 'username', 'concat(username," ",fname)', $group_for, '1 and status=1 order by username'); ?>
            </datalist>
          </div>
        </div>
      </div>
    </div> <!--end row-->
    <div class="n-form-btn-class">
      <input name="submit" type="submit" class="btn1 btn1-submit-input" value="Report" />
    </div>
  </form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>

<script type="text/javascript">
  function FetchZone(id){
    $('#zone').html('');
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { region_id : id},
      success : function(data){
         $('#zone').html(data);
      }

    })
  }

  function FetchArea(id){
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { zone_id : id},
      success : function(data){
         $('#area').html(data);
      }

    })
  }


    function FetchRoute(id){
    $('#route').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { area_id : id},
      success : function(data){
         $('#route').html(data);
      }

    })
  }

</script>


<script type="text/javascript">
  function FetchItemCategory(id){
    $('#category_id').html('');
    $('#subcategory_id').html('');
    $('#item_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { item_group : id},
      success : function(data){
         $('#category_id').html(data);
      }

    })
  }

  function FetchItemSubcategory(id){
    $('#subcategory_id').html('');
    $('#item_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { category_id : id},
      success : function(data){
         $('#subcategory_id').html(data);
      }

    })
  }


  function FetchItem(id){
    $('#item_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { subcategory_id : id},
      success : function(data){
         $('#browsers').html(data);
      }

    })
  }


</script>