<?php
session_start();
include "check.php";
require("../common/db_connect.php");
$proj_id = $_SESSION['proj_id'];


@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$po_no = $data[1];

$total_cr_amt = find_a_field('journal','sum(cr_amt)', 'tr_no="'.$po_no.'"');

$total_dr_amt = find_a_field('journal','sum(dr_amt)', 'po_no="'.$po_no.'"');

$due_balance = $total_cr_amt - $total_dr_amt;


?> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <input name="due_balance" type="due_balance" class="input3" id="due_balance"  style="width:55px;"  value="<?=$due_balance?>" readonly="readonly"/></td>
   
  </tr>
</table>

