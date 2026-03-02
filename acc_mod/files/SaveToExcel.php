<?php
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
</head>
<body><?=$datatodisplay?>
</body>
</html>
