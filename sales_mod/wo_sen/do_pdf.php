<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$file_name=$_GET['file_name'];
?>

<div class="container">
<div class="text-center" >
<center>
<embed src="../../../../files_doc/so/<?=$file_name?>" width="100%" height="100%" style="margin:0 auto;" />
</center>
</div>
</div>