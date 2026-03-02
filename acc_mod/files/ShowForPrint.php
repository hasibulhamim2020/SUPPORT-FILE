<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$datatodisplay=$_REQUEST['datatodisplay1'];

$datatodisplay=str_replace('tr style="display: none;"','tr',$datatodisplay);

$project_all=find_all_field('project_info','*','1');

$datatodisplay=str_replace('\"','',$datatodisplay);

$tr_type="Show";

?>

<html>

<head>

<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet"/>

<style type="text/css">

<!--

.style1 {

	font-size: 18px;

	font-weight: bold;

}

-->

</style>

</head>

<body onLoad="window.print()">

<table width="90%" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td style="border:0px" width="1%">

			<?php /*?><? $path='../logo/'.$_SESSION['proj_id'].'.jpg';

			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?>	<?php */?>	
			
			<img  src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style=" height:50px; width:auto;" />
            </td>

            <td style="border:0px" >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td style="border:0px; font-size: 25px; font-weight: bold; line-height: 30px;"  align="center" class="title">&nbsp;

								<?

if($_SESSION['user']['group']>1)

echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);

else

echo $_SESSION['proj_name'];

				?>

                &nbsp;</td>

              </tr>

              <tr>

                <td align="center" style="border:0px; padding-left:25px;"><?=$project_all->proj_address?></td>

              </tr>

              

            </table></td>

          </tr>

          <tr>

            <td colspan="2" align="center" style="border:0px">

            <?=$_REQUEST['page_title']?>

            </span>

			<span class="style1"><?=$_REQUEST['report_detail']?> </span></td>

          </tr>

</table>

<br>

<?=$datatodisplay?></body>

</html>

<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>