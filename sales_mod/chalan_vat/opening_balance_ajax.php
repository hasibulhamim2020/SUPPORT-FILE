<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'On');


$memo_no=find_a_field('sale_do_chalan','max(memo_no)+1',' 1');
if($memo_no==0){
$memo_no=4300;
}else{
$memo_no=$memo_no;
}
if($_REQUEST['item_id']>0)
sql='update sale_do_chalan set memo_no='.$memo_no.', memo_no="'.$_REQUEST['oqty'].'" where chalan_no='.$_REQUEST['item_id'];


echo 'Success!';
?>