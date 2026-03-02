<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Opening Balance';



do_calander('#odate');

auto_complete_from_db('dealer_info','dealer_name_e','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer');

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

	

	function update_value(id)

	{



var item_id=id;

var dealer_code=(document.getElementById('dealer_code').value)*1; 

var discount=(document.getElementById('dis_'+id).value)*1;

var flag =(document.getElementById('flag_'+id).value)*1;



if(flag==0) {

var set=(((document.getElementById('mrp_'+id).value)*1)-((((document.getElementById('mrp_'+id).value)*1)*discount)/100));

var set_price=set.toFixed(2);

}else

{

var set_price=(document.getElementById('set_'+id).value)*1;



}



var strURL="item_price_ajax.php?item_id="+item_id+"&dealer_code="+dealer_code+"&discount="+discount+"&set_price="+set_price+"&flag="+flag;



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

<form action="master_report.php?report=1" method="get" name="codz" id="codz" target="_blank">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>



  

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Corporate Dealer: </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input name="dealer" type="text" id="dealer" value="<?=$_POST['dealer']?>" />

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Show Price" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

      <input type="hidden" name="report" value="1" />

    </strong></td>

  </tr>

</table>

<br /><br />



<p>&nbsp;</p>

</form>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>