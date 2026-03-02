<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Budget Format';
$proj_id=$_SESSION['proj_id'];

if(isset($_POST['create'])){
$type=$_REQUEST['b_type'];

$f_year=$_REQUEST['f_year'];
$sql="select a.ledger_id from accounts_ledger a where a.ledger_id NOT IN (select ledger_id from monthly_budget where f_year='$f_year' and b_type='$type')";
$query=db_query($sql);
while($data=mysqli_fetch_row($query)){
if($_POST[$data[0]] == "on")
{
$insert="INSERT INTO `monthly_budget` (
`proj_id` ,`f_year` ,`ledger_id` ,`jan` ,`feb` ,`mar` ,`apr` ,`may` ,`jun` ,`jul` ,`aug` ,`sep` ,`oct` ,`nov` ,`dec` ,`total_amt` ,
`entry_date` ,`b_type` )
VALUES ('$proj_id', '$f_year', '$data[0]', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '$type')";
$insert2=db_query($insert);
}}}
?>
<script src="common/budget_create.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	  $('#tbl tr')
		 .filter(':has(:checkbox:checked)')
		 .addClass('selected')
		 .end()
		  .click(function(event) {
			 if (event.target.type !== 'checkbox') {
			   $(':checkbox', this).trigger('click');
			 }
		  })
		 .find(':checkbox')
		 .click(function(event) {
		   $(this).parents('tr:first').toggleClass('selected');
	 });
});
</script>

<style type="text/css">
<!--
.style1 {font-size: 18px}
.style2 {font-size: 10px}
.style5 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<div id="report">
  <div align="right">
    <form id="form1" name="form1" method="post" action="">
      <table  style="width:35%; margin-bottom:10px; border:1px solid #006699; border-collapse:collapse;" border="1" align="center" class="style2">
        
        <tr>
          <td align="left" style="background:url(../images/bg_header.jpg) repeat-x; width:50%; padding:7px; color:#000">Fiscal Year: </td>
          <td align="left" style="width:40%;">            
		  <select name="f_year" id="f_year" onChange="check1(this.value)" style="width:120px; font-size:10px;">
<? if(isset($_POST['f_year'])) echo '<option>'.$_POST['f_year'].'</option>';?>
										<option>2007</option>
										<option>2008</option>
										<option>2009</option>
										<option>2010</option>
										<option>2011</option>
										<option>2012</option>
										<option>2013</option>
										<option>2014</option>
										<option>2015</option>
										<option>2016</option>
										<option>2017</option>
            </select>			</td>
        </tr>
        <tr>
          <td align="left" style="background:url(../images/bg_header.jpg) repeat-x; padding:7px; color:#000000;">Budget Typ : </td>
          <td align="left" valign="top">
		  <select name="b_type" id="b_type" style="width:120px; font-size:10px;">
		  
		  <option value="1">Monthly</option>
		  <option value="2">Yearly</option>
            </select>		  </td>
        </tr>
      </table>
      
<span id="show">
        <table  style="width:90%; vertical-align:middle; border:1px solid #006699;" border="1" align="center" bordercolor="#006699" class="style2" id="tbl">
          <tr style="background:url(../images/bg_header.jpg) repeat-x; color:#000000; font-size:11px; font-weight:bold;">
            <td height="22" align="center">Ledger Group </td>
            <td width="40%" height="22" align="center">Ledger ID</td>
            <td width="20%" height="22" align="center">Select</td>
          </tr>

          <?php $sql="select a.ledger_name,b.group_name,a.ledger_id,a.budget_enable from accounts_ledger a, ledger_group b where a.ledger_group_id=b.group_id and a.ledger_id NOT IN (select ledger_id from monthly_budget where 1 and f_year='2008') and 1 order by a.ledger_name";
		  $query=db_query($sql);
		  while($data=mysqli_fetch_row($query)){
		  ?>
		  <tr>
            <td align="center" valign="top"><?php echo $data[0];?></td>
            <td align="center" valign="top"><?php echo $data[1];?></td>
            <td align="center" valign="top">              
			<input name="<?php echo $data[2];?>" type="checkbox" value="on" <? if($data[3]=='YES') echo 'checked';?>/>  </td>
          </tr>
		  <?php }?>

      </table>
	  </span>
      <p align="center">

        <input name="create" type="submit" id="create" value="Create Budget"/>

      </p>
    </form>
  </div>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>