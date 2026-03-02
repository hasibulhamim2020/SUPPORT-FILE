<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$datatodisplay=$_REQUEST['datatodisplay1'];

$datatodisplay=str_replace('tr style="display: none;"','tr',$datatodisplay);

$project_all=find_all_field('project_info','*','1');

$datatodisplay=str_replace('\"','',$datatodisplay);

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

<table width="100%" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td style="border:0px" width="10%">

			<?php /*?><? $path='../logo/'.$_SESSION['proj_id'].'.jpg';

			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?>	<?php */?>	
			
			<img  src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:100%;" />
            </td>

            <td style="border:0px" width="90%" align="right">
			
			<h2 style=" margin: 0px; padding: 0px; ">
				<?
				if($_SESSION['user']['group']>1)
				
				echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);
				
				else
				
				echo $_SESSION['proj_name'];
				?>
			</h2>
			
			<h5 style=" margin: 0px; padding: 0px; ">
				<?
				if($_SESSION['user']['group']>1)
				
				echo find_a_field('user_group','address',"id=".$_SESSION['user']['group']);
				
				else
				?>
				
				<?=$project_all->proj_address?>
				</h5>
				
				<h4 style=" margin: 0px; padding: 0px;"><?=$_REQUEST['page_title']?></h4>
			<p><?=$_REQUEST['report_detail']?></p>
			
			</td>

          </tr>

</table>

<br>

<?=$datatodisplay?></body>

</html>

