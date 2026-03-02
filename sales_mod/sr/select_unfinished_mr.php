<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Unfinished Sales Requisition List';

$tr_type="Show";

$table = 'requisition_master_vision';

$unique = 'req_no';

$status = 'MANUAL';

$target_url = '../sr/mr_create.php';



if($_POST[$unique]>0)

{

$_SESSION[$unique] = $_POST[$unique];

header('location:'.$target_url);

}

$tr_from="Warehouse";

?>











  <div class="form-container_large">



    <form action="" method="post" name="codz" id="codz">



      <div class="container-fluid bg-form-titel">

        <div class="row">

          <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">

            <div class="form-group row m-0">

              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Unfinished MR List</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                <select name="<?=$unique?>" id="<?=$unique?>">

                  <? foreign_relation($table,$unique,$unique,$$unique,'warehouse_id='.$_SESSION['user']['depot'].' and (status="'.$status.'" or status="") ');?>

                </select>





              </div>

            </div>

          </div>



          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

            <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />

          </div>



        </div>

      </div>



    </form>

  </div>





























<?php /*?>

<div class="form-container_large">

  <form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>

    <td bgcolor="#FF9966"><strong>



      <select name="<?=$unique?>" id="<?=$unique?>">

        <? foreign_relation($table,$unique,$unique,$$unique,'warehouse_id='.$_SESSION['user']['depot'].' and (status="'.$status.'" or status="") ');?>

      </select>



    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />

    </strong></td>

  </tr>

</table>



</form>

</div>

 <?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>