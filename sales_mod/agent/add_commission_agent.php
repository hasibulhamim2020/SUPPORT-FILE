<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='Commission Agent Setup';

$page="add_commission_agent.php";
$input_page="add_commission_input.php"; $add_button_bar = 'Mhafuz';



$table='sales_commission_agent';

$unique='ca_id';

$shown='ca_name';











if(isset($_GET['proj_code'])){ $proj_code=$_GET[$proj_code]; }



$crud      =new crud($table);



$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();



		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['entry_by']=$_SESSION['user']['id'];

$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($unique);

}









if(isset($_POST['update']))

{

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}





if(isset($_POST['delete']))

{		$condition=$unique."=".$unique;		$crud->delete($condition);

		unset($unique);

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($unique))

{

$condition=$unique."=".$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $key=$value;}

}


if (!isset($unique)) {
    $unique = db_last_insert_id($table, 'unique'); 
}

if($_POST['gf']==999) 

{unset($_SESSION['gf']);

unset($_POST['gf']);

}

?>



<script type="text/javascript"> function DoNav(lk){
window.open('../../pages/agent<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk ,"_blank" );

}




</script>

<form id="form2" name="form2" method="post" action="">

									  <table class="table table-bordered">
									     <tbody class="background-color:aqua;">
                                      
                                        <tr>

                                          <td>Concern Group: </td>

                                          <td><select name="gf" id="gf" class="form-control" style="height:35px;">

                                              <option value="999">All</option>

                                              <?	$sql="select * from user_group where status!=1 order by group_name";

											$query=db_query($sql);

											while($datas=mysqli_fetch_object ($query))

										{

										?>

					  <option <? if($datas->id==$_POST['gf']){ echo 'Selected ';} ?> value="<?=$datas->id?>">

					  <?=$datas->group_name?>

					  </option>
					  
					  

                                              <? } ?>

                                          </select></td>

                                          <td>
                                              <label></label>

                                            <input class="form-control" type="submit" name="show" value="GO" style=" height:41px;" />

                                            

                                          </td>

                                        </tr>
                                        </tbody>

                                      </table>

                                                                        </form>

									</td>

								  </tr>

								  <tr>

                                    <td>

									<div class="tabledesign">

                                        <? 	 



$res='select a.'.$unique.', a.'.$unique.' as agent_id, a.'.$shown.' as agent_name, w.warehouse_name as depot_name from '.$table.' a, warehouse w where a.warehouse_id = w.warehouse_id order by a.ca_id';

											echo $crud->link_report($res,$link);?>

                                    </div></td>

						      </tr>

								</table>



							</div></td>

    

 

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>