<?php


session_start();



 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


  $dealer_name=$data[0];
  //$do_no=$data[1];

 $dealer_found  = find_a_field('dealer_info','dealer_code','dealer_name_e="'.$dealer_name.'"');



?>

<input name="dealer_found" id="dealer_found" value="<?=$dealer_found;?>" type="hidden" />


<? if($dealer_found>0) {?>

								<tr>
                                  <td width="100%" colspan="2"><div class="box style2" style="width:100%;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#FF0000"> <div align="center">
                                         This customer has been exist.
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>


<? }?>
