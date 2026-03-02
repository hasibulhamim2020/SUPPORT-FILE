<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Concern For Regular Sale Entry';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'UNCHECKED';
$target_url = '../po/po_checking.php';

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

$target_url = '../po/po_checking.php';

?>



<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
  <!--<table width="70%" border="0" align="center">
	
	
	
	
	
    <tr>
      <td width="30%">&nbsp;</td>
      <td colspan="10%">&nbsp;</td>
      <td width="30%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#249CF2" style="color: black"><strong>Date Interval :</strong></td>
      <td width="20%" bgcolor="#249CF2"><strong>
        <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=$_POST['fdate']?>" />
      </strong></td>
      <td width="7%" bgcolor="#249CF2" style="color:black;"><strong> -to- </strong></td>
      <td width="8%" bgcolor="#249CF2"><strong>
        <input type="text" name="tdate" id="tdate" style="width:80px; color: white" value="<?=$_POST['tdate']?>" />
      </strong></td>
      <td rowspan="2" bgcolor="#249CF2"><strong>
        <input type="submit" name="submitit2" id="submitit2" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
      </strong></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#249CF2" style="color: black;"><strong>Concern  :</strong></td>
      <td colspan="3" bgcolor="#249CF2">
	  <select name="group_for" id="group_for" style="width:240px;" >
            <option></option>
            <? foreign_relation('user_group','id','group_name',$_POST['group_for']);?>
          </select>	  </td>
      </tr>
  </table>-->
</form>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="12%">Concern ID</th>
  <th width="38%">Concern Name</th>
  <th width="29%">Action</th>
  </tr>


<? 




$res="SELECT  id as concern_id, group_name as concern_name FROM `user_group` where id not in(7)";
$query = db_query($res);
while($data = mysqli_fetch_object($query))

{
?>
<tr <?=($data->amount>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->concern_id;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->concern_id;?></td>
<td onClick="custom(<?=$data->concern_id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->concern_name;?></td>
<td>
<a style="display:inline-block; font-size:14px; font-weight:700; " href="do.php?concern=<?=$data->concern_id;?>">
<input name="" type="checkbox" value=""   style="width:20px;" />
</a></td>
</tr>
<?


}

?>

</tbody></table>
</div></td>
</tr>
</table>

</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>