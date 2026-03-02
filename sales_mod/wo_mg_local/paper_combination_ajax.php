<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $ply=$data[0];
   $do_no=$data[1];
   
   $do_all=find_all_field('sale_do_master','',"do_no=".$do_no);
   
   //$a= $do_all->dealer_code;
 //   $b= $do_all->buyer_code;
   
 
?>





<select  name="paper_combination_id" id="paper_combination_id"  style="width:200px; height:30px;" required="required" onchange="getData2('sqm_rate_ajax.php', 'sqm_filter', this.value, document.getElementById('paper_combination_id').value);"  >
    <option></option>
    <? foreign_relation('paper_combination','id','paper_combination',$paper_combination_id,'dealer_code="'.$do_all->dealer_code.'" and buyer_code="'.$do_all->buyer_code.'" and ply="'.$ply.'" and approval="Yes" order by paper_combination');?>
  </select>






 
		<?php /*?> <input list="paper_combination" name="combination" id="combination"  style="width:200px;  height:30px;"  onchange="getData2('sqm_rate_ajax.php', 'sqm_filter', this.value, document.getElementById('combination').value);"  autocomplete="off"  required  >
  <datalist id="paper_combination">

	  <? foreign_relation('paper_combination','CONCAT(id, "->", paper_combination)','paper_combination',$_POST['combination'],
	  'dealer_code="'.$do_all->dealer_code.'" and buyer_code="'.$do_all->buyer_code.'" and ply="'.$ply.'"  and approval="Yes" order by paper_combination');?>
  </datalist><?php */?>



