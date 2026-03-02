<?php
require_once "../../../assets/template/layout.top.php";
require_once ('../../common/class.numbertoword.php');
 $tr_no = isset($_GET['tr_no']) ? $_GET['tr_no'] : [];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>.: Cheque Design :..</title>
   
    <script type="text/javascript">
    function hide() {
        document.getElementById("pr").style.display = "none";
    }
    </script>
    
	<style>
/*        .cheque-wrapper {*/
/*            position: relative;*/
/*             width: 210mm; */
/*            height: 297mm; */
/*            page-break-after: always;*/
/*        }*/

/*        .chq-content {*/
/*            position: absolute;*/
/*            top: 0;*/
/*            left: 0;*/
/*            width: 100%;*/
/*            height: 100%;*/
/*        }*/
/*@media print {*/
/*            .cheque-wrapper {*/
/*                page-break-after: always;*/
/*            }*/
/*            .chq-content {*/
/*                page-break-inside: avoid;*/
/*            }*/
/*            #pr {*/
/*                display: none;*/
/*            }*/
/*        }*/
    </style>
    
</head>

<body>
<div id="pr" style="padding-top: 36mm;">
        <button name="button" type="button" onclick="hide(); window.print();" value="Print" style="width: 55px; cursor: pointer;">
            <img src="print.png" width="40" height="40">
        </button>
    </div>
 <?php foreach ($tr_no as $tr):
        $master = find_all_field('vendor_payment_info', '*', 'id=' . $tr);
        $style_css = $master->bank_sub_ledger;
        $payee_name = find_a_field('general_sub_ledger', 'sub_ledger_name', 'sub_ledger_id="' . $master->vendor_sub_ledger . '"');
        $data2 = "select s.sub_ledger_name from general_sub_ledger s where s.sub_ledger_id='" . $master->bank_sub_ledger . "'";
        $qry = mysql_query($data2);
        $data = mysql_fetch_object($qry);
		include("pay_cheq_print.php");
		echo '<br>';
		endforeach;
    ?>
</body>
</html>
