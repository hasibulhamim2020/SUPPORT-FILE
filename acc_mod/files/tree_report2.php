<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Chart of Accounts';

$active='treere';

$separator=$_SESSION['separator'];

function ledger_sepe(){}

?>



<link href="../../../assets/css/sitemapstyler.css" rel="stylesheet" type="text/css" media="screen" />



<script type="text/javascript" src="../../../assets/js/sitemapstyler.js"></script>



<script type="text/javascript">



function changeBox(cbox) {



	box = eval(cbox);



	box.checked = !box.checked;



}



$(function() {



	$("#sitemap").treeview({



		collapsed: true,



		animated: "medium",



		control:"#sidetreecontrol",



		persist: "location"



	});



})



</script>



<script src="../../../assets/js/jquery.js" type="text/javascript"></script>



<script src="../../../assets/js/jquery.treeview.js" type="text/javascript"></script>



<style>

.selected {

background-color:#fff ;!important;

}

h1{



	font-size:140%;



	margin:0 20px;



	line-height:80px;	



}



p{	



	margin:0 auto;



	width:680px;



	padding:1em 0;



}

a.hover {

    color: #000 !important;

}


.selected{
	box-shadow: none !important;
}
.tabledesign td:hover{
background: white !important;
}
#sitemap li a{
	font-size: 12px !important;
}

</style>



<table>



	  <tr>



		<td align="right"><? include('PrintFormat.php');?></td>



	  </tr>



</table>



<table id="grp" class="tabledesign" cellspacing="0">



<tr><td>



<form id="form1" name="form1" method="get" action="">



	<div align="right">



	  <div id="sidetreecontrol">



	  <a href="#"><input class="btn btn-primary" type="button" name="Button" value="Collapse All" /></a> 



	  <a href="?#"><input class="btn btn-success" type="button" name="Button" value="Expand All" /></a></div> 



	</div>



	<div id="container">



	<div id="content">



		



	<ul id="sitemap">



<?





$sql='select * from acc_class where 1 order by id';



$query=db_query($sql);



if(mysqli_num_rows($query)>0){



while($grp=mysqli_fetch_object($query)){

$grp_id=(string)($grp->id*100000000);

?>



<!-- <li><label for="gid<?=$grp->id;?>"><a href="" onClick="changeBox('document.form1.gid<?=$grp->id;?>');return false;"><?=ledger_sepe($grp_id,$separator)?><?=' '.$grp->class_name;?></a><input name="gid" id="gid<?=$grp->id;?>" type="radio" value="<?=$grp->id;?>"  style="visibility:hidden;"/></label> -->
<li><label for="gid<?=$grp->id;?>"><a href="" onClick="changeBox('document.form1.gid<?=$grp->id;?>');return false;"><?=ledger_sepe($grp_id,$separator)?><?=' '.$grp->class_name;?></a><input name="gid" id="gid<?=$grp->id;?>" type="radio" value="<?=$grp->id;?>"  style="visibility:hidden;"/></label>







<?

 $sql3='select * from acc_sub_class where   acc_class='.$grp->id;

$query3=db_query($sql3);

if(mysqli_num_rows($query3)>0){

echo '<ul>';

while($sb_cls=mysqli_fetch_object($query3)){

?>



<li><label for="sid<?=$sb_cls->id;?>"><a href="" onClick="changeBox('document.form1.sid<?=$sb_cls->id;?>');return false;"><?=$sb_cls->id.' - '?><?=$sb_cls->sub_class_name;?></a><input name="sid" id="sid<?=$sb_cls->id;?>" type="radio" value="<?=$sb_cls->id;?>"  style="visibility:hidden;"/></label>





<?

 $sql4='select * from ledger_group where  acc_sub_class="'.$sb_cls->id.'" ';

$query4=db_query($sql4);

if(mysqli_num_rows($query4)>0){

echo '<ul>';

while($ldg_grp=mysqli_fetch_object($query4)){

?>



<li><label for="sid<?=$ldg_grp->group_id;?>"><a href="" style="padding: 0px;" onClick="changeBox('document.form1.sid<?=$ldg_grp->group_id;?>');return false;">

<a href="accounts_general_ledger_tree.php?group_id=<?=$ldg_grp->group_id;?>" target="_blank"><?=$ldg_grp->group_id.' - '?><?=$ldg_grp->group_name;?></a>

<input name="sid" id="sid<?=$ldg_grp->group_id;?>" type="radio" value="<?=$ldg_grp->group_id;?>"  style="visibility:hidden;"/></label>







<?

 $sql5='select * from accounts_ledger where  ledger_group_id="'.$ldg_grp->group_id.'" ';

$query5=db_query($sql5);

if(mysqli_num_rows($query5)>0){

echo '<ul>';

while($acc_ledger=mysqli_fetch_object($query5)){

?>



<li><label for="sid<?=$acc_ledger->ledger_id;?>"><a href="" style="padding:0px;" onClick="changeBox('document.form1.sid<?=$acc_ledger->ledger_id;?>');return false;"><?=$acc_ledger->ledger_id.' - '?><?=$acc_ledger->ledger_name;?></a><input name="sid" id="sid<?=$acc_ledger->ledger_id;?>" type="radio" value="<?=$acc_ledger->ledger_id;?>"  style="visibility:hidden;"/></label>









</li>



<? }?> 



<? echo '</ul>'; }?>











</li>



<? }?> 



<? echo '</ul>'; }?>









</li>



<? }?>



<? echo '</ul>'; }?>



</li>



<? }}?></ul>



</div>



</div>



</div>



</form>



</td>



</tr></table>







<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>