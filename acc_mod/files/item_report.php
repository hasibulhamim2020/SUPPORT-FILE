<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Search';





if(isset($_REQUEST['show'])||isset($_REQUEST['view']))

{

$sub_group_id 	= $_POST['sub_group_id'];

$item_name 		= $_POST['item_name'];



$sql="select * from item_info where 1";

}

$active='search';



?>

<script type="text/javascript">



function DoNav(theUrl)

{

	var URL = 'invoice_print_req.php?'+theUrl;

	popUp(URL);

}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}



function loadinparent(url)

{

	self.opener.location = url;

	self.blur(); 

}

</script>

<style type="text/css">

<!--

.style1 {

	color: #FF0000;

	font-size: 10px;

}

.style2 {color: #FF0000}

-->

</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td valign="top"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                                      <tr>

                                        <td align="right">Product Sub Group :</td>

                                        <td align="left">

<?php

$a2="select sub_group_id, sub_group_name from item_sub_group";

$a1=db_query($a2);

echo "<select name='sub_group_id' id='sub_group_id' style='text-align:left;width:200px;'>";

while($a=mysqli_fetch_row($a1))

{

if($a[0]==$sub_group_id)

echo "<option value='".$a[0]."' selected>".$a[1]."</option>";

else

echo "<option value='".$a[0]."'>".$a[1]."</option>";

}

echo "</select>";

?>

                                        </select></td>

                                      </tr>

                                      <tr>

                                        <td width="40%" align="right">Product Name : </td>

                                        <td width="60%" align="left"><label for="item_name"></label>

                                        <input type="text" name="item_name" id="item_name" style="width:200px;" value="<?=$item_name;?>" /></td>

                                      </tr>

                                     <!-- <tr>

                                        <td align="center"><span class="style1">* means mandetory </span></td>

                                        <td align="left"><input class="btn1" name="show" type="submit" id="show" value="Show" /></td>

                                      </tr>
-->
                                      

                                    </table>

								    </form></div></td>

						      </tr>

							  

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td>	  <?php if(isset($_REQUEST['view'])||isset($_REQUEST['show']))

	  {	  

	  ?>

									<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
									<thead>

							  <tr>

								<th>ID</th>

								<th>Req No</th>

								<th>Date</th>

								<th>Req For</th>

								<th>Note</th>

								<th>Warehouse</th>

								<th>Status</th>

							  </tr>
							  </thead>
							  <tbody>

        <?php

		$query=db_query($sql);		  

		while($vno=mysqli_fetch_row($query))

		{

			$v_type = $_REQUEST['v_type'];$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

							   <tr<?=$cls?>>

								<td><?php echo $vno[0] ?></td>

								<td><?php echo $vno[2] ?></td>

								<td><?php echo $vno[1] ?></td>

								<td><?php echo $vno[3] ?></td>

								<td><?php echo $vno[4] ?></td>

								<td><?php echo $vno[6] ?></td>

								<td><?php echo $vno[7] ?></td>

							  </tr>

	<?php }?>

						</tbody>	</table>

							<?php

    }

    ?>								</td>

								  </tr>

		</table>



							</div></td>

    

  </tr>

</table>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>