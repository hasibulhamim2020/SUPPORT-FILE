<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../common/class.numbertoword.php');
jv_double_check();
$title='Chart Of Accounts';
do_calander('#fdate');
do_calander('#tdate');
$active='bankbo';
$proj_id=$_SESSION['proj_id'];
if($_SESSION['user']['group']>1)
$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' ");
else
$cash_and_bank_balance=find_a_field('ledger_group','group_id','group_sub_class=1020');
if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];
if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"]);
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);
$j=0;
for($i=0;$i<strlen($fdate);$i++)
{
if(is_numeric($fdate[$i]))
$time1[$j]=$time1[$j].$fdate[$i];
else $j++;
}
//$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);
//tdate-------------------
$j=0;
for($i=0;$i<strlen($tdate);$i++)
{
if(is_numeric($tdate[$i]))
$time[$j]=$time[$j].$tdate[$i];
else $j++;
}
//$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);
}
?>
<?php 
$led1=db_query("SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name");
if(mysqli_num_rows($led1) > 0)
{	
$data1 = '[';
while($ledg1 = mysqli_fetch_row($led1)){
$data1 .= '{ name: "'.$ledg1[1].'", id: "'.$ledg1[0].'" },';
}
$data1 = substr($data1, 0, -1);
$data1 .= ']';
}
else
{
$data1 = '[{ name: "empty", id: "" }]';
}
?>
<script type="text/javascript">
$(document).ready(function(){
function formatItem(row) {
//return row[0] + " " + row[1] + " ";
}
function formatResult(row) {
return row[0].replace(/(<.+?>)/gi, '');
}
var data = <?php echo $data1; ?>;
$("#cc_code").autocomplete(data, {
matchContains: true,
minChars: 0,        
scroll: true,
scrollHeight: 300,
formatItem: function(row, i, max, term) {
return row.name + " : [" + row.id + "]";
},
formatResult: function(row) {            
return row.id;
}
});	
});
</script>

<style>
.in{
display: block !important;
}
.panel {
margin: 0px !important;
border-radius: 0px !important;
border: 1px !important;
}
.panel-heading {
padding: 0px !important;
}
.panel-default>.one {
background: #696969;
font-weight: bold;
}
.panel-default>.one td{
color: #333333 !important;
}
tr:nth-child(odd){
background-color: #fafafa!important;
color: #333333;
}
.panel-default>.two {
background: #adadad;
font-weight: bold;
}
.panel-default>.three {
background: #d1d1d1;
}
.panel-default>.four {
/* background: #82D8CF; */
}
.panel-heading table tr td {
padding: 3px !important;
font-size: 12px;
}
th,

.sr-ledger-name{
width: 65%;
}
.sr-ledger-dr-amt{
width: 15%;
}
.sr-ledger-cr-amt{
width: 15%;
}
.sr-ledger-action{
width: 5%;
}
.sr-custom-table td{
font-size: 12px;
}
.sr-custom-table td{
padding: 3px;
}

.sr-ledger-action button:before {
  content: "+";
  color: #fff;
  font-size: 18px;
  position: absolute;
  transform: rotate(90deg);
  transition: all 0.6s ease;
}
.sr-ledger-action [aria-expanded="false"]:before {
  content: "+";
  color: #fff;
  font-size: 18px;
  position: absolute;
  transform: rotate(90deg);
  transition: all 0.6s ease;
}
.sr-ledger-action [aria-expanded="true"]:before {
  content: "-";
  color: #fff;
  font-size: 25px;
  position: absolute;
  transform: rotate(180deg);
  transition: all 0.6s ease;
      margin-top: 2px;
    margin-left: 1px;
}

#reporting{
background-color:#FFFFFF;
}
.bgc-color-new1 table tr td{
background: #c7f2f5;
}
.bgc-color-new2 table tr td{
background: #f5e5c7;
}
.bgc-color-new3 table tr td{
background: #edcbef;
}
.bgc-color-new4 table tr td{
background: #efcbcb;
}
.bgc-color-new5 table tr td{
background: #efe9cb;
}
.bgc-new-btn, bgc-new-btn:visited{
    background-color: #24a0ed;
    border: 1px solid #045b91;
    border-radius: 3px;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
}
</style>





<form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate" class="from-control" value="<?=$_POST['fdate']?>" autocomplete="off">
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" class="from-control" value="<?=$_POST['tdate']?>" autocomplete="off">

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="SHOW" class="btn1 btn1-submit-input">
                </div>

            </div>
        </div>

    </form>





<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<div class="left_report">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="zoom: 80%;">
<tr>
<td><div id="reporting"><div id="grp">
<table class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
<!--new add start-->
<?
 if($_REQUEST['cc_id']>0){
   $con .= ' and cc_code="'.$_REQUEST['cc_id'].'" ';
 }
 if($_REQUEST['fdate']!='' && $_REQUEST['tdate']!=''){
   $con .= ' and jv_date between "'.$_REQUEST['fdate'].'" and "'.$_REQUEST['tdate'].'" ';
 }
 
 
 $f_date=$_REQUEST['fdate'];
 $t_date=$_REQUEST['tdate'];
 
 
 //Update Data
 
 
  $sql = "select j.ledger_id, sum(j.dr_amt-j.cr_amt) as opening_amt, a.ledger_group_id, g.acc_sub_sub_class, g.acc_sub_class, g.acc_class from journal j, accounts_ledger a, ledger_group g 
 where j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and j.jv_date <'".$f_date."' group by j.ledger_id, a.ledger_group_id, g.acc_sub_sub_class, g.acc_sub_class, g.acc_class ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $opening_amt[$info->ledger_id]=$info->opening_amt;
		 $grp_opening_amt[$info->ledger_group_id]=$info->opening_amt;
		 $sub_sub_cls_opening_amt[$info->acc_sub_sub_class]=$info->opening_amt;
		 $sub_cls_opening_amt[$info->acc_sub_class]=$info->opening_amt;
		 $cls_opening_amt[$info->acc_class]=$info->opening_amt;
		}
		
		
		
		//$sql = "select ledger_id, sum(dr_amt) as dr_amt, sum(cr_amt) as cr_amt from journal where jv_date between '".$f_date."' and '".$t_date."' group by ledger_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $dr_amt[$info->ledger_id]=$info->dr_amt;
//		 $cr_amt[$info->ledger_id]=$info->cr_amt;
//		}
//		
//	
//		$sql = "select ledger_id, sum(dr_amt-cr_amt) as closing_amt from journal where jv_date <='".$t_date."' group by ledger_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $closing_amt[$info->ledger_id]=$info->closing_amt;
//		}
 
 
 
 //Update Data
 
 
 
 		//$sql = "select ledger_id, sum(dr_amt-cr_amt) as opening_amt from journal where jv_date <'".$f_date."' group by ledger_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $opening_amt[$info->ledger_id]=$info->opening_amt;
//		}
//		
//		
//		
//		$sql = "select ledger_id, sum(dr_amt) as dr_amt, sum(cr_amt) as cr_amt from journal where jv_date between '".$f_date."' and '".$t_date."' group by ledger_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $dr_amt[$info->ledger_id]=$info->dr_amt;
//		 $cr_amt[$info->ledger_id]=$info->cr_amt;
//		}
//		
//	
//		$sql = "select ledger_id, sum(dr_amt-cr_amt) as closing_amt from journal where jv_date <='".$t_date."' group by ledger_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $closing_amt[$info->ledger_id]=$info->closing_amt;
//		}
		
	//Group Data
	//$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as grp_opening_amt from journal j, accounts_ledger a where j.ledger_id=a.ledger_id and j.jv_date <'".$f_date."' group by a.ledger_group_id";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $grp_opening_amt[$info->ledger_group_id]=$info->grp_opening_amt;
//		}
//		
//			
//		$sql = "select a.ledger_group_id, sum(j.dr_amt) as grp_dr_amt, sum(j.cr_amt) as grp_cr_amt from journal j, accounts_ledger a  
//		where j.ledger_id=a.ledger_id and j.jv_date between '".$f_date."' and '".$t_date."' group by a.ledger_group_id";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $grp_dr_amt[$info->ledger_group_id]=$info->grp_dr_amt;
//		 $grp_cr_amt[$info->ledger_group_id]=$info->grp_cr_amt;
//		}
//		
//	$sql = "select a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as grp_closing_amt from journal j, accounts_ledger a where j.ledger_id=a.ledger_id and j.jv_date <='".$t_date."' group by a.ledger_group_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $grp_closing_amt[$info->ledger_group_id]=$info->grp_closing_amt;
//		}
		
		
		//Sub sub Class Data
	
	
	//$sql = "select g.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as sub_sub_cls_opening_amt from journal j, accounts_ledger a, ledger_group g 
//	where j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and j.jv_date <'".$f_date."' group by g.acc_sub_sub_class";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sub_sub_cls_opening_amt[$info->acc_sub_sub_class]=$info->sub_sub_cls_opening_amt;
//		}
//		
//			
//		$sql = "select g.acc_sub_sub_class, sum(j.dr_amt) as sub_sub_cls_dr_amt, sum(j.cr_amt) as sub_sub_cls_cr_amt from journal j, accounts_ledger a,  ledger_group g   
//		where j.ledger_id=a.ledger_id  and a.ledger_group_id=g.group_id  and j.jv_date between '".$f_date."' and '".$t_date."' group by g.acc_sub_sub_class";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sub_sub_cls_dr_amt[$info->acc_sub_sub_class]=$info->sub_sub_cls_dr_amt;
//		 $sub_sub_cls_cr_amt[$info->acc_sub_sub_class]=$info->sub_sub_cls_cr_amt;
//		}
//		
//		$sql = "select g.acc_sub_sub_class, sum(j.dr_amt-j.cr_amt) as sub_sub_cls_closing_amt from journal j, accounts_ledger a, ledger_group g  
//		where j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and j.jv_date <='".$t_date."' group by g.acc_sub_sub_class ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sub_sub_cls_closing_amt[$info->acc_sub_sub_class]=$info->sub_sub_cls_closing_amt;
//		}
			
		
		

	//sub Class Data
	
	
	//$sql = "select s.acc_sub_class, sum(j.dr_amt-j.cr_amt) as sub_cls_opening_amt from journal j, accounts_ledger a, ledger_group g, acc_sub_sub_class s
//	where j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.acc_sub_sub_class=s.id and j.jv_date <'".$f_date."' group by s.acc_sub_class";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sub_cls_opening_amt[$info->acc_sub_class]=$info->sub_cls_opening_amt;
//		}
//		
//			
//		$sql = "select s.acc_sub_class, sum(j.dr_amt) as sub_cls_dr_amt, sum(j.cr_amt) as sub_cls_cr_amt from journal j, accounts_ledger a,  ledger_group g, acc_sub_sub_class s   
//		where j.ledger_id=a.ledger_id  and a.ledger_group_id=g.group_id and g.acc_sub_sub_class=s.id and j.jv_date between '".$f_date."' and '".$t_date."' group by s.acc_sub_class";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sub_cls_dr_amt[$info->acc_sub_class]=$info->sub_cls_dr_amt;
//		 $sub_cls_cr_amt[$info->acc_sub_class]=$info->sub_cls_cr_amt;
//		}
//		
//		$sql = "select s.acc_sub_class, sum(j.dr_amt-j.cr_amt) as sub_cls_closing_amt from journal j, accounts_ledger a, ledger_group g, acc_sub_sub_class s  
//		where j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.acc_sub_sub_class=s.id and j.jv_date <='".$t_date."' group by s.acc_sub_class ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sub_cls_closing_amt[$info->acc_sub_class]=$info->sub_cls_closing_amt;
//		}
			
		
	//acc_class
	
	
	//$sql = "select cl.acc_class, sum(j.dr_amt-j.cr_amt) as cls_opening_amt from journal j, accounts_ledger a, ledger_group g, acc_sub_class cl
//	where j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.acc_sub_class=cl.id and j.jv_date <'".$f_date."' group by cl.acc_class";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $cls_opening_amt[$info->acc_class]=$info->cls_opening_amt;
//		}
//		
//			
//		$sql = "select cl.acc_class, sum(j.dr_amt) as cls_dr_amt, sum(j.cr_amt) as cls_cr_amt from journal j, accounts_ledger a,  ledger_group g, acc_sub_class cl  
//		where j.ledger_id=a.ledger_id  and a.ledger_group_id=g.group_id and g.acc_sub_class=cl.id and j.jv_date between '".$f_date."' and '".$t_date."' group by cl.acc_class";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $cls_dr_amt[$info->acc_class]=$info->cls_dr_amt;
//		 $cls_cr_amt[$info->acc_class]=$info->cls_cr_amt;
//		}
//		
//		$sql = "select cl.acc_class, sum(j.dr_amt-j.cr_amt) as cls_closing_amt from journal j, accounts_ledger a, ledger_group g, acc_sub_class cl 
//		where j.ledger_id=a.ledger_id and a.ledger_group_id=g.group_id and g.acc_sub_class=cl.id and j.jv_date <='".$t_date."' group by cl.acc_class";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $cls_closing_amt[$info->acc_class]=$info->cls_closing_amt;
//		}
 

 
 
?>
<!--new add end-->

<div class="container">
<div class="panel-group" id="faqAccordion">
<table class="table" style="margin: 0px; background: #82D8CF; color: black;">
    <tr style="background: #5c0632 !important; color: white !important;">
      <th style="width: 35%; text-align:center;">Head Title</th>
      <th style="width: 15%; text-align:center;">Opening</th>
	  <th style="width: 15%; text-align:center;">Debit</th>
      <th style="width: 15%; text-align:center;">Credit</th>
	  <th style="width: 15%; text-align:center;">Closing</th>
      <th style="width: 5%; text-align:center;">Action</th>
    </tr>
	
</table>
<?
$select = 'select * from acc_class where 1';
$query = db_query($select);
while($row = mysqli_fetch_object($query)){
?>
<div class="panel panel-default ">
<!--account class start-->
<div class="panel-heading one accordion-toggle question-toggle collapsed bgc-color-new<?=$row->id?>">
<table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom: 0px;;">
<tr>
<td style="width:35%; padding: 0px;font-weight: bold; padding: 5px;padding-bottom: 0px; text-transform: uppercase;" class="sr-ledger-name"><?=$row->class_name?></td>
<td style="width: 15%; text-align: right;">
<? if($cls_opening_amt[$row->id]>0) echo number_format($cls_opening_amt[$row->id],2).' (Dr)'; elseif($cls_opening_amt[$row->id]<0) echo number_format(((-1)*$cls_opening_amt[$row->id]),2).' (Cr)';else echo "0.00"; ?></td>
<td style="width: 15%; text-align: right;" class="sr-ledger-dr-amt"><?=$cls_dr_amt[$row->id]?></td>
<td style="width: 15%; text-align: right;" class="sr-ledger-cr-amt"><?=$cls_cr_amt[$row->id]?></td> 
<td style="width: 15%; text-align: right;">
<? if($cls_closing_amt[$row->id]>0) echo number_format($cls_closing_amt[$row->id],2).' (Dr)'; elseif($cls_closing_amt[$row->id]<0) echo number_format(((-1)*$cls_closing_amt[$row->id]),2).' (Cr)';else echo "0.00"; ?>
</td>
<td  style="width:5%;"class="sr-ledger-action" align="center"><button data-toggle="collapse" data-parent="#faqAccordion"
data-target="#f<?=$row->id?>" class="bgc-new-btn">&emsp;</button></td>
</tr>
</table>
</div>

<!--account sub class start-->
<div id="f<?=$row->id?>" class="panel-collapse collapse" style="height: 0px;">
<div class="panel-body" style="padding: 0px;">
<?
$select2 =  'select * from acc_sub_class where acc_class="'.$row->id.'"';
$query2 = db_query($select2);
while($row2=mysqli_fetch_object($query2)){
?>
<div class="panel panel-default ">
<div class="panel-heading two accordion-toggle question-toggle collapsed">
<table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom: 0px;;">
<tr>
<td style="width: 35%;" class="sr-ledger-name"><span style="font-size: 14px; font-weight: bold; letter-spacing: 5px;">-</span><?=$row2->sub_class_name?></td>
<td style="width: 15%; text-align: right;">
<? if($sub_cls_opening_amt[$row2->id]>0) echo number_format($sub_cls_opening_amt[$row2->id],2).' (Dr)'; elseif($sub_cls_opening_amt[$row2->id]<0) echo number_format(((-1)*$sub_cls_opening_amt[$row2->id]),2).' (Cr)';else echo "0.00"; ?>
</td>
<td style="width: 15%; text-align: right;" class="sr-ledger-dr-amt"><?=$sub_cls_dr_amt[$row2->id]?></td>
<td style="width: 15%; text-align: right;" class="sr-ledger-cr-amt"><?=$sub_cls_cr_amt[$row2->id]?></td> 
<td style="width: 15%; text-align: right;">
<? if($sub_cls_closing_amt[$row2->id]>0) echo number_format($sub_cls_closing_amt[$row2->id],2).' (Dr)'; elseif($sub_cls_closing_amt[$row2->id]<0) echo number_format(((-1)*$sub_cls_closing_amt[$row2->id]),2).' (Cr)';else echo "0.00"; ?>
</td>
<td style="width: 5%;" class="sr-ledger-action"  align="center"><button data-toggle="collapse" data-parent="#faqAccordion"
data-target="#s<?=$row2->id?>" class="bgc-new-btn">&emsp;</button></td>
</tr>
</table>
</div>

<!--account sub sub class start-->
<div id="s<?=$row2->id?>" class="panel-collapse collapse" style="height: 0px;">
<div class="panel-body" style="padding: 0px;">
<?
$select3 =  'select * from acc_sub_sub_class where acc_sub_class="'.$row2->id.'" ';
$query3 = db_query($select3);
while($row3=mysqli_fetch_object($query3)){
?>
<div class="panel panel-default ">
<div class="panel-heading three accordion-toggle question-toggle collapsed">
<table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom: 0px;;">
<tr>
<td style="width: 35%; font-weight: 600;" class="sr-ledger-name"><span style="font-size: 14px; font-weight: bold; letter-spacing: 5px;">--</span><?=$row3->sub_sub_class_name?></td>
<td style="width: 15%; text-align: right;">

<? if($sub_sub_cls_opening_amt[$row3->id]>0) echo number_format($sub_sub_cls_opening_amt[$row3->id],2).' (Dr)'; elseif($sub_sub_cls_opening_amt[$row3->id]<0) echo number_format(((-1)*$sub_sub_cls_opening_amt[$row3->id]),2).' (Cr)';else echo "0.00"; ?>

</td>
<td style="width: 15%; text-align: right;" class="sr-ledger-dr-amt"><?=$sub_sub_cls_dr_amt[$row3->id]?></td>
<td style="width: 15%; text-align: right;" class="sr-ledger-cr-amt"><?=$sub_sub_cls_cr_amt[$row3->id]?></td> 
<td style="width: 15%; text-align: right;">
<? if($sub_sub_cls_closing_amt[$row3->id]>0) echo number_format($sub_sub_cls_closing_amt[$row3->id],2).' (Dr)'; elseif($sub_sub_cls_closing_amt[$row3->id]<0) echo number_format(((-1)*$sub_sub_cls_closing_amt[$row3->id]),2).' (Cr)';else echo "0.00"; ?>
</td>
<td style="width: 5%;" class="sr-ledger-action"  align="center"><button data-toggle="collapse" data-parent="#faqAccordion" data-target="#t<?=$row3->id?>" class="bgc-new-btn">&emsp;</button></td>
</tr>
</table>
</div>

<!--accounts ledger group Start-->
<div id="t<?=$row3->id?>" class="panel-collapse collapse" style="height: 0px;">
<div class="panel-body" style="padding: 0px;">
<?
$select4 =  'select * from ledger_group where acc_sub_sub_class="'.$row3->id.'" ';
$query4 = db_query($select4);
while($row4=mysqli_fetch_object($query4)){
?>
<div class="panel panel-default ">
<div class="panel-heading three accordion-toggle question-toggle collapsed">
<table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom: 0px;;">
<tr>
<td style="width: 35%; font-weight: 600;" class="sr-ledger-name"><span style="font-size: 14px; font-weight: bold; letter-spacing: 5px;">---</span><?=$row4->group_name?></td>
<td style="width: 15%; text-align: right;">
<? if($grp_opening_amt[$row4->group_id]>0) echo number_format($grp_opening_amt[$row4->group_id],2).' (Dr)'; elseif($grp_opening_amt[$row4->group_id]<0) echo number_format(((-1)*$grp_opening_amt[$row4->group_id]),2).' (Cr)';else echo "0.00"; ?>
</td>
<td style="width: 15%; text-align: right;" class="sr-ledger-dr-amt"><?=$grp_dr_amt[$row4->group_id]?> </td>
<td style="width: 15%; text-align: right;" class="sr-ledger-cr-amt"><?=$grp_cr_amt[$row4->group_id]?> </td> 
<td style="width: 15%; text-align: right;">

<? if($grp_closing_amt[$row4->group_id]>0) echo number_format($grp_closing_amt[$row4->group_id],2).' (Dr)'; elseif($grp_closing_amt[$row4->group_id]<0) echo number_format(((-1)*$grp_closing_amt[$row4->group_id]),2).' (Cr)';else echo "0.00"; ?>
 </td>
<td style="width: 5%;" class="sr-ledger-action"  align="center"><button data-toggle="collapse" data-parent="#faqAccordion" data-target="#u<?=$row4->group_id?>" class="bgc-new-btn">&emsp;</button></td>
</tr>
</table>
</div>

<!--accounts ledger Start-->
<div id="u<?=$row4->group_id?>" class="panel-collapse collapse" style="height: 0px;">
<div class="panel-body" style="padding: 0px;">
<table border="0" cellspacing="0" cellpadding="0" class="table sr-custom-table" style="margin-bottom: 0px;;">
<?
$select5 =  'select * from accounts_ledger where  ledger_group_id="'.$row4->group_id.'"';
$query5 = db_query($select5);
while($row5=mysqli_fetch_object($query5)){
?>
<tr>
<td style="width: 35%;" class="sr-ledger-name"><span style="font-size: 14px; font-weight: bold; letter-spacing: 5px;">----</span><?=$row5->ledger_name?></td>
<td style="width: 15%; text-align: right;">

<? if($opening_amt[$row5->ledger_id]>0) echo number_format($opening_amt[$row5->ledger_id],2).' (Dr)'; elseif($opening_amt[$row5->ledger_id]<0) echo number_format(((-1)*$opening_amt[$row5->ledger_id]),2).' (Cr)';else echo "0.00"; ?>

</td>
<td style="width: 15%; text-align: right;" class="sr-ledger-dr-amt"><?=$dr_amt[$row5->ledger_id]?></td>
<td style="width: 15%; text-align: right;" class="sr-ledger-cr-amt"><?=$cr_amt[$row5->ledger_id]?></td> 
<td style="width: 15%; text-align: right;">
<? if($closing_amt[$row5->ledger_id]>0) echo number_format($closing_amt[$row5->ledger_id],2).' (Dr)'; elseif($closing_amt[$row5->ledger_id]<0) echo number_format(((-1)*$closing_amt[$row5->ledger_id]),2).' (Cr)';else echo "0.00"; ?>
</td>
<td style="width: 5%;" class="sr-ledger-action"></td>
</tr>


<?  } ?>
</table>
</div>
</div>
<!--accounts ledger end-->

</div>


<?  } ?>
</div>
</div>
<!--accounts ledger group end-->


</div>


<?  } ?>
</div>
</div>
<!--account sub sub class end-->

</div>


<?  } ?>
</div>
</div>
<!--account sub class end-->

</div>





<? $grand_dr += $value_g_dr[$row->group_id]; $grand_cr += $value_g_cr[$row->group_id];   } ?>
 <!--<table class="table" style="margin: 0px; background: #82D8CF; color: black;">
<tr>
<th class="sr-ledger-name">Total : </th>
<th class="sr-ledger-dr-amt"><?=$grand_dr?></th>
<th  class="sr-ledger-cr-amt"><?=$grand_cr?></th>
<th  class="sr-ledger-action"> </th>
</tr>
<tr>
<th class="sr-ledger-name">Difference : </th>
<th class="sr-ledger-dr-amt" colspan="3" style="text-align:center;"><?=abs($grand_dr-$grand_cr)?></th>
</tr>
</table>--> 
</div>
<script src="bootstrap.min.js"></script>
</table> 
<br /><br />                          
</div></div>                            
</td>
</tr>
</table>
</div></td>
</tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>