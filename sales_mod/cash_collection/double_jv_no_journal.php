<?php
session_start();
require_once "../../support/inc.all.php";


$sql = 'SELECT jv_no , count(distinct tr_no) as tr_count,tr_no,tr_from
FROM `journal`
WHERE  `jv_no` LIKE "%" group by jv_no';

$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
	if($data->tr_count>1)
	{
	$date_format = substr($data->jv_no,0,8);
	$new_jv_no = next_journal_voucher_id2($date_format);
	$x++;
	$data->jv_no.'  '.$date_format.'  '.$new_jv_no .'  '.'  '.$data->tr_no.'<br>';
	echo $update_sql = 'update journal set jv_no = "'.number_format($new_jv_no, 0, '.', '').'"  where jv_no = "'.$data->jv_no.'" and tr_from="'.$data->tr_from.'" and tr_no="'.$data->tr_no.'" ';
	$update = db_query($update_sql);
	echo ' -OK<br>';
	}
}
//$tr_from = 'Journal_info';
//$tr_no = 1602002877;
//voucher_double_id_check($tr_no,$tr_from);
echo 'TOTAL FOUND: '.$x;
?>