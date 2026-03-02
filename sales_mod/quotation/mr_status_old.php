<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type="Show";
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$c_id = $_SESSION['proj_id'];

$title='Sales Quotation Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'sale_requisition_master';
$unique = 'do_no';
$status = 'CHECKED';
$target_url = '../quotation/mr_print_view.php';

?>
<script language="javascript">
function custom(theUrl,c_id){
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}
</script>



  <div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">

      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group row m-0">
              <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> SQ Status :</label>
              <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                <select name="status" id="status">
                  <option><?=$_POST['status']?></option>
                  <option>UNCHECKED</option>
                  <option>CHECKED</option>
                  <option>ALL</option>
                </select>

              </div>
            </div>
          </div>

          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7">
            <div class="row">


              <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date :</label>
                  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                   <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />


                  </div>
                </div>

              </div>


              <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date :</label>
                  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                      <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
                  </div>
                </div>


              </div>


            </div>



          </div>


          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <input type="submit" name="submitit" id="submitit" class="btn1 btn1-submit-input" value="VIEW DETAIL"/>

          </div>

        </div>
      </div>




      <!--Table start-->
      <div class="container-fluid pt-5 p-0 ">

        <div class="tabledesign2">
          <?
          if($_POST['status']!=''&&$_POST['status']!='ALL')
            $con .= 'and a.status="'.$_POST['status'].'"';

          if($_POST['fdate']!=''&&$_POST['tdate']!='')
            $con .= 'and a.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
            $tr_type="Search";


          $res='select a.do_no,concat("Q-000",a.do_no) as Quotation_no, DATE_FORMAT(a.do_date, "%d-%m-%Y") as Qutation_date, a.status,concat(d.dealer_code,"-",d.dealer_name_e) as dealer_name,  a.entry_at from sale_requisition_master a,dealer_info d where
  a.dealer_code=d.dealer_code '.$con.' and a.status in ("CHECKED", "COMPLETED") group by a.do_no order by a.do_no desc';
          echo link_report2($res,'mr_print_view.php',$c_id);



          ?>
        </div>


      </div>
    </form>
  </div>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>