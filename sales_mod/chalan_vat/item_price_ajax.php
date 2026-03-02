<?

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$chalan_no=$_REQUEST['item_id'];

$memo_no=find_a_field('sale_do_chalan','max(memo_no)+1',' 1');
if($memo_no<4300) $memo_no=4300;
$sql='update sale_do_chalan set memo_no='.$memo_no.' , vat_approval="Yes" where chalan_no='.$chalan_no;



db_query($sql);

echo 'Success!';

?>