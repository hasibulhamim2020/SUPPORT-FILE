<? session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

echo $_REQUEST['chalan_no'];
echo $_REQUEST['chalan_no']=17030201001;
echo $memo_no=find_a_field('sale_do_chalan','max(memo_no)+1',' 1');
if($memo_no==0)
$memo_no=4300;

if($_REQUEST['chalan_no']>0)
echo sql='update sale_do_chalan set memo_no='.$memo_no.' where chalan_no='.$_REQUEST['chalan_no'];

echo 'Success!';
?>