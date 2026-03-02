<?

$tc_qty = 500;
$bundle_size = 40;

$full_pack_no = (int)($tc_qty/$bundle_size);
for($i=1;$i<=$full_pack_no;$i++)
{
echo $i.' - '.$bundle_size;
echo '<br>';
}
$last_pack_size = ($tc_qty%$bundle_size);
echo $i.' - '.$last_pack_size;
?>