<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Damage Chalan Varification';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');

auto_complete_from_db('dealer_info','dealer_name_e','dealer_code','dealer_type="SuperShop" and canceled="Yes"','dealer');
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

	function update_value(id)

	{

var item_id=id; // Rent
var ra=(document.getElementById('ra_'+id).value)*1;
var flag=(document.getElementById('flag_'+id).value); 
if(ra>0){
var strURL="received_amt_ajax.php?item_id="+item_id+"&ra="+ra+"&flag="+flag;}
else
{
alert('Receive Amount Must be Greater Than Zero.');
document.getElementById('ra_'+id).value = '';
document.getElementById('ra_'+id).focus();
return false;
}

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
<form action="../../sales_mod/pages/ido/master_report.php?report=1" method="get" name="codz" id="codz" target="_blank">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td><table width="50%" border="0" align="center" cellpadding="5" cellspacing="0" style="background-color:#FF9999;">
              
              <tr>
                <td><div align="right"><strong>Dealer : </strong></div></td>
                <td colspan="3"><div align="left"><strong>
                  <input name="dealer" type="text" id="dealer" value="<?=$_POST['dealer']?>" />
                </strong></div></td>
                <td><label>
				<input type="hidden" name="report" value="1" />
                  <input type="submit" name="submitit" id="submitit" value="View Price" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
                </label></td>
              </tr>
              
            </table></td>
	    </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td>
      		  
  </td>
	    </tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>
		<div>
                    
		<table width="100%" border="0" cellspacing="0" cellpadding="0">		
		<tr>		
		<td>
		<div style="width:380px;"></div></td>
		</tr>
		</table>
	        </div>
		</td>
		</tr>
      </table></td></tr>
</table>
</form>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>
