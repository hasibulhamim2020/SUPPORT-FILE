<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



if(isset($_POST['create']))

{

		  $sql = 'select * from zon where REGION_ID="'.$_POST['branch_id'].'" order by ZONE_NAME';

		  $query = db_query($sql);

		  $cols = mysqli_num_rows($query);

		  while($data=mysqli_fetch_object($query)){++$i;

		  $level['id'][$i] = $data->ZONE_CODE;

		  $level['name'][$i] = $data->ZONE_NAME;

		  }

		  $sql = 'select target,item_id,level_id from sale_target_setup s where level=11 and parent_id="'.$_POST['branch_id'].'" and grp="'.$_REQUEST['grp'].'" ';

		  $query = db_query($sql);

		  while($data=mysqli_fetch_object($query)){${'targets_'.$data->level_id.'_'.$data->item_id} = $data->target;}

}



?>



<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }



	function update_value(id,flag)



	{





var total_target=0;

var item_id=id;

<?

        	for($i=1;$i<=$cols;$i++)

			{

			?>

			var target_<?=$level['id'][$i]?>=(document.getElementById('target_'+item_id+'_<?=$level['id'][$i]?>').value)*1;

			total_target = (total_target)*1 + target_<?=$level['id'][$i]?>;

			<?

			}

?>

var strURL="target_setup_zone_ajax.php?grp=<?=$_POST['grp']?>&item_id="+item_id+"&parent=<?=$_POST['branch_id']?>&flag="+flag<?

        	for($i=1;$i<=$cols;$i++)

			{

			?>+"&target_<?=$level['id'][$i]?>="+target_<?=$level['id'][$i]?><?

			}

			

?>







		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {



			



				if (req.readyState == 4) {



					// only if "OK"



					if (req.status == 200) {						



						document.getElementById('divi_'+id).style.display='inline';



						document.getElementById('divi_'+id).innerHTML=req.responseText;						



					} else {



						alert("There was a problem while using XMLHTTP:\n" + req.statusText);



					}



				}				



			}



			



						

	if(total_target!=100){

	alert('100% Target is not assigned. Please Fulfill Clearly.');

	return false;}

	else{

			req.open("GET", strURL, true);}



			req.send(null);



		}	



}



	function cal_all(id)



	{

var item_id=id; // Rent

var total_target=0;

<?

        	for($i=1;$i<=$cols;$i++)

			{

				?>

				var target_<?=$level['id'][$i]?>=(document.getElementById('target_'+id+'_<?=$level['id'][$i]?>').value)*1;

				total_target = (total_target)*1 + target_<?=$level['id'][$i]?>;

				

				<? 

			}



?>

document.getElementById('total_target_'+id).value=total_target;

	}

	function recall_all(id)

	{

	cal_all(id);

	var total_target = (document.getElementById('total_target_'+id).value)*1;

	if(total_target!=100){

	alert('100% Target is not assigned. Please Fulfill Clearly.');

	return false;}

	return true;

	}

</script>

<form action=""  method="post">

<div class="oe_view_manager oe_view_manager_current">

        

        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

<table width="100%" border="0" class="oe_list_content"><thead>

<tr class="oe_list_header_columns">

  <th colspan="6"><span style="text-align: center; font-size:18px; color:#09F">Monthly House Wise Target Setup</span></th>
  </tr>

<tr class="oe_list_header_columns">

  <th colspan="6"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>

</thead><tfoot>

</tfoot><tbody>



  <tr  class="alt">

    <td align="right"><strong>Month :</strong></td>

    <td>
	
		<select name="month_id " style="width:160px;" id="month_id " required="required">

			<? foreign_relation('months','month_id','month_name',$_POST['month_id ']);?>
    	</select>	</td>

<td align="right">&nbsp;</td>

    <td></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Year : </strong></td>
    <td><select name="year" style="width:160px;" id="year" required="required">

        <option <?=($_REQUEST['year']=='2017')?'selected':''?>>2017</option>

        <option <?=($_REQUEST['year']=='2018')?'selected':''?>>2018</option>

        <option <?=($_REQUEST['year']=='2019')?'selected':''?>>2019</option>

        <option <?=($_REQUEST['year']=='2020')?'selected':''?>>2020</option>

    </select></td>
    <td align="right">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr  class="alt">

    <td align="right"><strong> House :</strong></td>

    <td><select name="warehouse_id " style="width:160px;" id="warehouse_id " required="required">

	<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'], 'use_type="SD"');?>

    </select></td>

    <td align="right">&nbsp;</td>

    <td colspan="3">&nbsp;</td>
  </tr>

  <tr  class="alt">

    <td align="right">&nbsp;</td>

    <td>&nbsp;</td>

    <td align="right">&nbsp;</td>

    <td colspan="3">&nbsp;</td>
  </tr>

  

  </tbody></table>

<br /><div style="text-align:center">

<table width="100%" class="oe_list_content">

  <thead>

<tr class="oe_list_header_columns">

  <th colspan="4"><input name="create" type="submit" id="create" value="Open Setup Sheet" /></th>

  </tr>

  </thead>

  <tfoot>

  </tfoot>

  <tbody>

    </tbody>

</table>

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">

          <? if(isset($_POST['create'])){



		  ?>

		<table width="100%" class="oe_list_content"><thead><tr class="oe_list_header_columns" style="font-size:10px;padding:3px;">

        <th>FG</th>

        <th>Item Name</th>

        <th>Brand</th>

        <?

        	for($i=1;$i<=$cols;$i++)

			{

				echo '<th>'.$level['name'][$i].'</th>';

			}

		?>

        <th>Total</th>

        <th>&nbsp;</th>

        </tr>

		</thead>

        <tbody>

        <? 

		$sql = 'select * from item_info where sales_item_type like "%'.$_POST['grp'].'%" and finish_goods_code>0 and finish_goods_code not between 5000 and 6000 and sub_group_id=1096000900010000 order by finish_goods_code';

		$query = db_query($sql);

		while($info=mysqli_fetch_object($query)){++$i;

		  

		?>

        <tr><td><?=$info->finish_goods_code?>



</td><td><?=$info->item_name?></td><td><?=$info->item_brand?></td>

         <?

        	$total_target = 0;

			for($i=1;$i<=$cols;$i++)

			{

				?>

                <td><input name="target_<?=$info->item_id?>_<?=$level['id'][$i]?>" type="text" id="target_<?=$info->item_id?>_<?=$level['id'][$i]?>" style=" width:50px; min-width:20px;" value="<?=${'targets_'.$level['id'][$i].'_'.$info->item_id}?>" onchange="cal_all(<?=$info->item_id?>)" /></td>

                <?

			$total_target = $total_target + ${'targets_'.$level['id'][$i].'_'.$info->item_id};

			}

		?>

          <td align="center"><input readonly="readonly" name="total_target_<?=$info->item_id?>" type="text" id="total_target_<?=$info->item_id?>" style=" width:50px; min-width:20px;" value="<?=$total_target;?>" /></td>

          <td align="center"><span id="divi_<?=$info->item_id?>">

            <? 

			  if($total_target>0)

			  {?><input type="button" name="Button" value="Edit"  onclick="update_value(<?=$info->item_id?>,1)" style="font-size:10px;"/><?

			  }

			  else

			  {

			  ?><input type="button" name="Button" value="Save"  onclick="update_value(<?=$info->item_id?>,0)" style="font-size:10px;"/><? }?>

          </span>&nbsp;</td>

          </tr>

        <?

		}

		?>

        </tbody>

        

        <tfoot>

        <tr><td></td><td></td><td></td><td></td>

          <td></td>

          <td></td>

          <td></td>

          <td></td>

          <td></td>

          <td></td>

          <td></td>

          <td></td>

          <td></td>

          <td></td>

          <td></td>

          </tr>

        </tfoot>

        </table>    <?

		}

		?>  </div></div>

          </div>

    </div>

<p>

  <input name="save" type="submit" id="save" value="SAVE" />

</p>

  </div></div></div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

  </div>

</form>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>