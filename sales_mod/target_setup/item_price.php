<?php



require_once "../../../assets/template/layout.top.php";



$title='Individual Dealer Wise Price Setup';







do_calander('#odate');



//auto_complete_from_db('dealer_info','dealer_name_e','dealer_code','1 and canceled="Yes"','dealer'); //dealer_type="Distributor"  change by kamrul at 23-10-2021

auto_complete_from_db('dealer_info d,dealer_type t','concat(d.dealer_name_e," - ",t.dealer_type)','dealer_code','d.dealer_type=t.id','dealer'); //changed by alamin on 11-20-2021

$tr_type="show";

$tr_from="Sales";

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



	function auto_blank(id)



	{



	(document.getElementById('dis_'+id).value)='';







	}



	



	function set_price(id)



	{



		var discount=(document.getElementById('dis_'+id).value)*1;



		



		if(discount>0) 



			{



			var set=(((document.getElementById('mrp_'+id).value)*1)-((((document.getElementById('mrp_'+id).value)*1)*discount)/100));



			var set_price=set.toFixed(2);



			}



		else



			{



			var set_price=(document.getElementById('set_'+id).value)*1;



			}



	document.getElementById('set_'+id).value=set_price;



	}



	

function update_value(id){

var item_id=id;



var dealer_code=(document.getElementById('dealer_code').value)*1; 



//var discount=(document.getElementById('dis_'+id).value)*1;



var flag =(document.getElementById('flag_'+id).value)*1;





//if(discount>0) {
//
//
//
//var set=(((document.getElementById('mrp_'+id).value)*1)-((((document.getElementById('mrp_'+id).value)*1)*discount)/100));
//
//
//
//var set_price=set.toFixed(2);
//
//
//
//}else{



var set_price=(document.getElementById('set_'+id).value)*1;



//}



var strURL="item_price_ajax.php?item_id="+item_id+"&dealer_code="+dealer_code+"&set_price="+set_price+"&flag="+flag;







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



			req.open("GET", strURL, true);



			req.send(null);



		}	







}







</script>



<div class="form-container_large">



<form action="" method="post" name="codz" id="codz">





<div class="container-fluid bg-form-titel">

            <div class="row">

                

                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">

                    <div class="form-group row m-0">

                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer Name</label>

                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

                            <input name="dealer" type="text" id="dealer" value="<?=$_POST['dealer']?>" / class="form-control">



                        </div>

                    </div>

                </div>



                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

                    

                    <input type="submit" name="submitit" id="submitit" value="Set Price" class="btn1 btn1-submit-input"/ >

                </div>



            </div>

        </div>



<?php /*?><table width="80%" border="0" align="center">



  <tr>



    <td>&nbsp;</td>



    <td>&nbsp;</td>



    <td>&nbsp;</td>



  </tr>







  



  <tr>



    <td align="right" bgcolor="#FF9966"><strong> Dealer Name: </strong></td>



    <td bgcolor="#FF9966"><strong>



      <input name="dealer" type="text" id="dealer" value="<?=$_POST['dealer']?>" / class="form-control">



    </strong></td>



    <td bgcolor="#FF9966" style="text-align:center"><strong>



      <input type="submit" name="submitit" id="submitit" value="Set Price" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/ >



    </strong></td>



  </tr>



</table><?php */?>



<br /><br />



<?



if($_POST['dealer']>0){



?>





<div class="container-fluid bg-form-titel">

            <div class="row">

                

                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">

                    <div class="form-group row m-0">

                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer Name</label>

                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

                             <?=(find_a_field('dealer_info','concat(dealer_name_e,"-",dealer_code)','dealer_code='.$_POST['dealer']))?>



      &nbsp;



      <input name="dealer_code" id="dealer_code" type="text" size="10" maxlength="10" value="<? echo $_POST['dealer'];?>" />



                        </div>

                    </div>

                </div>



                



            </div>

        </div>

<!--<div class="tabledesign2" style="width:100%"><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">-->



  <?php /*?><tr>



    <td bgcolor="#6699CC"><strong>Dealer Name: </strong></td>



    <td bgcolor="#6699CC"><strong>



      <?=(find_a_field('dealer_info','concat(dealer_name_e,"-",dealer_code)','dealer_code='.$_POST['dealer']))?>



      &nbsp;



      <input name="dealer_code" id="dealer_code" type="text" size="10" maxlength="10" value="<? echo $_POST['dealer'];?>" style="width:60px;" />&nbsp;&nbsp;&nbsp;



    </strong></td>



  </tr><?php */?>



<!--</table>-->







<div class="form-container_large">

        <div class="container-fluid pt-5 p-0 ">

            

            <table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">



					<th>Item Name </th>

				

					<th>Item Category </th>

				

					<th>Sub Group</th>

				

					<th>Unit</th>

				

					<th>MRP</th>

				

					<th>Set Rate</th>

				

					<th>Action</th>

                </tr>

                </thead>



                <tbody class="tbody1">

				

				<?



  $sql = "select i.*,s.sub_group_name,g.group_name from item_info i, item_sub_group s,item_group g  where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and s.group_id in(300000000,400000000,500000000,600000000,900000000,1000000000) order by i.item_name";



  $query = mysql_query($sql);



  while($data=mysql_fetch_object($query)){$i++;



  ?>

				

                <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">






    <td style="text-align:left"><?=$data->item_name?></td>



    <td style="text-align:left"><?=$data->sub_group_name?></td>



    <td style="text-align:left"><?=$data->group_name?></td>



    <td><?=$data->unit_name?></td>



    <td><?=$data->d_price?></td>






	<input name="mrp_<?=$data->item_id?>" id="mrp_<?=$data->item_id?>" type="hidden" value="<?=$data->m_price?>" />







    <td><input name="set_<?=$data->item_id?>" id="set_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<? echo $set_price = find_a_field('sales_price_dealer','set_price','dealer_code="'.$_POST['dealer'].'" and item_id= "'.$data->item_id.'"');?>"  onblur="auto_blank(<?=$data->item_id?>)" />      </td>



    <td><span id="divi_<?=$data->item_id?>">



            <? 



			  if($set_price!='')



			  {?>



			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />



			  <input type="button" name="Button" value="Re-Set" class="btn1 btn1-bg-update"  onclick="update_value(<?=$data->item_id?>)" /><?



			  }



			  else



			  {



			  ?>



			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />



			  <input type="button" name="Button" value="Set"  class="btn1 btn1-bg-submit" onclick="update_value(<?=$data->item_id?>)"/><? }?>



          </span>&nbsp;</td>



  </tr>

  

  <? } ?>



                </tbody>

            </table>





        </div>

</div>







<?php /*?><table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">



  <tr>



    <th><div align="center">Item Code </div></th>



    <th><div align="center">Item Name </div></th>



    <th>Brand</th>



    <th>Group</th>



    <th>Unit</th>



    <th>MRP</th>



    <th>%Dis</th>



    <th><div align="center">Set Rate</div></th>



    <th><div align="center">Action</div></th>



  </tr>







  <?



  $sql = "select i.* from item_info i, item_sub_group s  where i.sub_group_id=s.sub_group_id and i.product_nature in ('Salable','Both') order by finish_goods_code";



  $query = mysql_query($sql);



  while($data=mysql_fetch_object($query)){$i++;



  ?>







  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">



    <td><?=($data->finish_goods_code>0)?$data->finish_goods_code:'';?></td>



    <td><?=$data->item_name?></td>



    <td><?=$data->item_brand?></td>



    <td><?=$data->sales_item_type?></td>



    <td><?=$data->unit_name?></td>



    <td><?=$data->m_price?></td>



    <td>



	<input name="mrp_<?=$data->item_id?>" id="mrp_<?=$data->item_id?>" type="hidden" value="<?=$data->m_price?>" />



	<input name="dis_<?=$data->item_id?>" id="dis_<?=$data->item_id?>" type="text" size="5" maxlength="5" value="<? echo $set_price = find_a_field('sales_price_dealer','discount','dealer_code="'.$_POST['dealer'].'" and item_id= "'.$data->item_id.'"');?>" style="width:30px;" onchange="set_price(<?=$data->item_id?>)" /></td>



    <td><input name="set_<?=$data->item_id?>" id="set_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<? echo $set_price = find_a_field('sales_price_dealer','set_price','dealer_code="'.$_POST['dealer'].'" and item_id= "'.$data->item_id.'"');?>" style="width:50px;" onblur="auto_blank(<?=$data->item_id?>)" />      </td>



    <td><span id="divi_<?=$data->item_id?>">



            <? 



			  if($set_price!='')



			  {?>



			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />



			  <input type="button" name="Button" value="Re-Set"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px; background-color:#FF3366"/><?



			  }



			  else



			  {



			  ?>



			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />



			  <input type="button" name="Button" value="Set"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:20px;background-color:#66CC66"/><? }?>



          </span>&nbsp;</td>



  </tr>



  <? }?>



</table>

<?php */?>

</div>



<? }?>



<p>&nbsp;</p>



</form>



</div>







<?



require_once "../../../assets/template/layout.bottom.php";



?>