<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=export.xls");
// Fix for crappy IE bug in download.
header("Pragma: ");
header("Cache-Control: ");

$datatodisplay=$_REQUEST['datatodisplay'];
$datatodisplay=str_replace('tr style="display: none;"','tr',$datatodisplay);
?>
<html>
<head>

<link href="../../../assets/css/report.css" type="text/css" rel="stylesheet"/>

<style type="text/css">

<!--

.style1 {

	font-size: 18px;

	font-weight: bold;

}

-->

</style>

</head>
<body>
    <table width="90%" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td style="border:0px" width="1%">

			<?php /*?><? $path='../logo/'.$_SESSION['proj_id'].'.jpg';

			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?>	<?php */?>	
			
			<img  src="../../../logo/<?=$_SESSION['proj_id']?>.png" style=" height:50px; width:auto;" />
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

                <td align="center" style="border:0px; padding-left:25px;">House: 102(2nd Floor),Road# Northern, West Side D.O.H.S Baridhara, Dhaka-1206, Bangladesh.</td>

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
    <?=$datatodisplay?>
</body>
</html>
