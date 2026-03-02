<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='User Activity';
$proj_id=$_SESSION['proj_id'];


if(isset($_REQUEST['show']))
{


}
?>
<script type="text/javascript">
$(document).ready(function(){
        
        $(function() {
                $("#fdate").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                });
        });
                $(function() {
                $("#tdate").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                });
        });

});
</script>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                  <tr>
                                                                    <td><div class="box_report"><form id="form1" name="form1" method="get" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="22%" align="right">
										Period :</td>
                                        <td align="left">
<input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php if($_REQUEST['fdate']=='') echo date('Y-m-d'); else echo $_REQUEST['fdate'];?>" /> 
                                         -TO- 
<input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php if($_REQUEST['tdate']=='') echo date('Y-m-d'); else echo $_REQUEST['tdate'];?>"/> 
<span class="hints">(Ex: Date Format:'31-12-10') </span></td>
                                      </tr>
                                      
                                     
                                      <tr>
                                        <td align="right">User Name : </td>
                                        <td align="left">
										<select name="user_id" id="user_id">
										<option value="%"></option>
										<?
										$sql='select user_id,username from user_activity_management';
										$query=db_query($sql);
										if(mysqli_num_rows($query)>0)
										{
										while($info=mysqli_fetch_row($query))
										{
										if($info[0]==$_REQUEST['user_id'])
										echo '<option value="'.$info[0].'" selected>'.$info[1].'</option>';
										else
										echo '<option value="'.$info[0].'">'.$info[1].'</option>';
										}
										}
										?>
                                        </select>
                                        <span class="hints">(Ex: Blank field means 'Show All Available Data') </span></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
									</form></div></td>
									</tr>
									<tr>
									<td align="right"><? include('PrintFormat.php');?></td>
									</tr>
									<tr>
									<td>
									<div id="reporting">
									<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
									<tr>
									<th>S/L</th>
									<th>User Id </th>
									<th>User Name </th>
									<th>Activity Date </th>
									<th>Page Name </th>
									<th>Detail</th>
									</tr>
<?php
        if(isset($_REQUEST['show'])){
$fdate=$_REQUEST["fdate"]. " 00:00:00";
$tdate=$_REQUEST['tdate']. " 23:59:59";


$p="SELECT a.`user_id`, b.`username`, a.`access_time`, a.`page_name`,a.`access_detail` FROM `user_activity_log` a, user_activity_management b WHERE a.`user_id`=b.`user_id`
and a.user_id like '".$_REQUEST['user_id']."' and a.`access_time` between '$fdate' and '$tdate'";


        $report = db_query($p);
        $i=0;
        while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';
        ?>
								   <tr<?=$cls?>>
										<td><?=$i;?></td>
										<td><?=$rp[0];?></td>
										<td><?=$rp[1];?></td>
										<td><?=$rp[2];?></td>
										<td><?=$rp[3];?></td>
										<td><?=$rp[4];?></td>
								  </tr>
        <?php }?>
									
									<?
									}?>
									</table>
									</div>
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