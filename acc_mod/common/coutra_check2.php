<?php 
$count = $_REQUEST['count'];

$type 		= $_REQUEST['a'];
$ledger_id	= $_REQUEST['b'];
$cur_bal 	= $_REQUEST['c'];
$debit 		= $_REQUEST['d'];
$credit 	= $_REQUEST['e'];
$c_date 	= $_REQUEST['c_date'];
$c_no 	= $_REQUEST['c_no'];
?>
<style>
.datagtable
{
	border-bottom:1px solid #CCC;
}
.datagtable td
{
	border-left:1px solid #CCC;
}
.datagtable input
{
	border:0;	
}
.editable
{
	background:#FF9;
}

.editable input
{
	border:1px solid #CCC;
	background:#FFF;
}
.deleted, .deleted input
{
	background:#F00;
	color:#FFF;
}
img
{
border:0px;
}
</style>
<table width='100%' border="0"  style="background-color:#FFFFFF;" style="border-collapse:collapse" class="datagtable">
	<tr align="left" id="rowid<?php echo $count;?>" height="30">
        <td width="5%">
        	<input name="type<?php echo $count;?>" id="type<?php echo $count;?>" type="text" readonly="true" value="<?php echo $type ?>" size="10" />        </td>
        <td>
        	<input name="ledger_id<?php echo $count;?>" id="ledger_id<?php echo $count;?>" type="text" readonly="true" value="<?php echo $ledger_id; ?>" style="width:425px;" />
            <input name="cur_bal<?php echo $count;?>" id="cur_bal<?php echo $count;?>" type="hidden" readonly="true" value="<?php echo $cur_bal; ?>" size="10" />
            <input name="c_no<?php echo $count;?>" id="c_no<?php echo $count;?>" type="hidden" value="<?php echo $c_no; ?>" size="10" />
			<input name="c_date<?php echo $count;?>" id="c_date<?php echo $count;?>" type="hidden" value="<?php echo $c_date; ?>" size="10" />        </td>
        <td width="12.5%">
        	<input name="debit<?php echo $count;?>" id="debit<?php echo $count;?>" type="text" value="<?php echo $debit; ?>" onblur="editamount<?php echo $count;?>();" readonly="true" size="10" />        </td>
        <td width="12.5%">
        	<input name="credit<?php echo $count;?>" id="credit<?php echo $count;?>" type="text" value="<?php echo $credit; ?>" onblur="editamount<?php echo $count;?>();" readonly="true" size="10" />        </td>
        <td width="2%">
            <a href="#" onclick="editfield<?php echo $count;?>(); return false;">
                <img src="../images/edit.png" width="16" height="16" />            </a>        </td>
        <td width="4%">
            <a href="#" onclick="deletethis<?php echo $count;?>();">
                <img src="../images/delete.png" width="16" height="16" />            </a>        </td>
    </tr>
</table>
<style>
.datagtable
{
	border-bottom:1px solid #CCC;
}
.datagtable td
{
	border-left:1px solid #CCC;
}
.datagtable input
{
	border:0;	
}
.editable
{
	background:#FF9;
}

.editable input
{
	border:1px solid #CCC;
	background:#FFF;
}
.deleted, .deleted input
{
	background:#F00;
	color:#FFF;
}
</style>

<input name="deleted<?php echo $count;?>" id="deleted<?php echo $count;?>" type="hidden" value="no" />
<script type="text/javascript">

function deletethis<?php echo $count;?>()
{
	document.getElementById('rowid<?php echo $count;?>').className='deleted';
	document.getElementById('t_d_amt').value = (document.getElementById('t_d_amt').value) - (document.getElementById('debit<?php echo $count;?>').value);
	document.getElementById('t_c_amt').value = (document.getElementById('t_c_amt').value) - (document.getElementById('credit<?php echo $count;?>').value);
	document.getElementById('deleted<?php echo $count;?>').value='yes';
	document.getElementById('rowid<?php echo $count;?>').style.display='none';
}

function editfield<?php echo $count;?>()
{
	document.getElementById('rowid<?php echo $count;?>').className='editable';
	
	if(document.getElementById('type<?php echo $count;?>').value == 'Debit')
	{
		document.getElementById('debit<?php echo $count;?>').readOnly = false;
	}
	else
	{
		document.getElementById('credit<?php echo $count;?>').readOnly = false;
	}
}

function editamount<?php echo $count;?>()
{
	var i=0;
	var last = document.getElementById('count').value;

	var t_d_amnt = 0;
	var t_c_amnt = 0;
	for (i=1;i<=last;i++)
	{
		if(isNaN(document.getElementById('debit'+i).value) || isNaN(document.getElementById('credit'+i).value))
		{
			alert('Invalid number on ('+ i +') number row.');
		}
		else
		{
			t_d_amnt = +t_d_amnt + (+document.getElementById('debit'+i).value);
			t_c_amnt = +t_c_amnt + (+document.getElementById('credit'+i).value);
		}
	}
	document.getElementById('t_d_amt').value = t_d_amnt;
	document.getElementById('t_c_amt').value = t_c_amnt;
}
</script>