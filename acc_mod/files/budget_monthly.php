<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Budget Assign';
$proj_id=$_SESSION['proj_id'];
if(isset($_POST['budget'])){
$b_type=$_REQUEST['b_type'];
$f_year=$_REQUEST['f_year'];
}
?>
<link href="../common/budget.css" rel="stylesheet" type="text/css" />
<script src="../common/budget_monthly.js"></script>

<div id="report">
  <div align="right">
    <form id="form1" name="form1" method="post" action="">
      <table style="width:40%; margin-bottom:10px; border:1px solid #006699; border-collapse:collapse;" border="1" align="center" class="style2">
        
        <tr>
          <td align="left" style="background:url(../images/bg_header.jpg) repeat-x; width:50%; padding:7px; color:#000000;">Fiscal Year: </td>
          <td width="45%" align="left">            
		  <select name="f_year" id="f_year">
		  <?php if(isset($f_year)){
		 echo "<option selected value=\"".$_REQUEST['f_year']."\">".$_REQUEST['f_year']."</option>";
		   }?>
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
           <td align="left" style="background:url(../images/bg_header.jpg) repeat-x; padding:7px; color:#000000;">Budget Type : </td>
           <td align="left" valign="top">
		  <select name="b_type" id="b_type">
		  <?php if($b_type==1)
		 echo "<option selected value=\"1\">Monthly</option>";
		 if($b_type==2)
		 echo "<option selected value=\"2\">Yearly</option>";
		 ?>
		  <option value="1">Monthly</option>
		  <option value="2">Yearly</option>
            </select>		  </td>
        </tr>
      </table>

      <div align="center" style="margin:5px;">
        <input name="budget" type="submit" id="budget" value="Show Budget" />
      </div>


      <span id="show"><div align="center"></div></span>
      <table border="1" align="center" style="width:100%; padding:2px; border:1px solid #a8c5c1; border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; margin-top:5px;" cellpadding="0" cellspacing="0">
        <tr style="background:url(../images/bg_header.jpg) repeat-x; color:#37535a; font-size:11px;">
          <td height="22" align="center">Ledger Name </td>
          <td align="center">Jan</td>
          <td align="center">Feb</td>
          <td align="center">Mar</td>
          <td align="center">Apr</td>
          <td align="center">May</td>
          <td align="center">Jun</td>
          <td align="center">Jul</td>
          <td align="center">Aug</td>
          <td align="center">Sep</td>
          <td align="center">Oct</td>
          <td align="center">Nov</td>
          <td align="center">Dec</td>
          <td align="center">Yearly</td>
          <td align="center">Update</td>
        </tr>
		<?php if(isset($_POST['budget'])){
		$sql="select a.ledger_name,b.jan,b.feb,b.mar,b.apr,b.may,b.jun,b.jul,b.aug,b.sep,b.oct,b.nov,b.dec,b.total_amt,b.ledger_id from accounts_ledger a, monthly_budget b where a.ledger_id=b.ledger_id and 1 and b.b_type='$b_type' and b.f_year='$f_year'";
		//echo $sql;
		$query=db_query($sql);
		while($data=mysqli_fetch_row($query)){
		?>
<tr>
<td height="22" align="center"><?php echo $data[0];?></td>
<td align="center"><input id="<?php echo $data[14]."_1";?>" name="<?php echo $data[14]."_1";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[1];?>"/></td>
<td align="center"><input id="<?php echo $data[14]."_2";?>" name="<?php echo $data[14]."_2";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[2];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_3";?>" name="<?php echo $data[14]."_3";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[3];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_4";?>" name="<?php echo $data[14]."_4";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[4];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_5";?>" name="<?php echo $data[14]."_5";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[5];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_6";?>" name="<?php echo $data[14]."_6";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[6];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_7";?>" name="<?php echo $data[14]."_7";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[7];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_8";?>" name="<?php echo $data[14]."_8";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[8];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_9";?>" name="<?php echo $data[14]."_9";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[9];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_10";?>" name="<?php echo $data[14]."_10";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[10];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_11";?>" name="<?php echo $data[14]."_11";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[11];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_12";?>" name="<?php echo $data[14]."_12";?>" type="text" style="width:40px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[12];?>" /></td>
<td align="center"><input id="<?php echo $data[14]."_13";?>" name="<?php echo $data[14]."_13";?>" type="text" style="width:50px; font-size:9px; border:1px solid #c1dad7;" value="<?php echo $data[13];?>" /></td>
<td align="center"><input name="<?php echo $data[14];?>" type="button" id="update" value="go" onclick="updat(this.name);"/></td>
</tr><?php }}?>
</table>
</form>
  </div>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>