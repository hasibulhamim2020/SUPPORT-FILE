<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cheque Design :.</title>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    @page {
        size: A4;
        margin: 0px !important;
    }

    #pr {
        position: absolute;
        right: 10%;
    }

    html, body {
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .chq-content {
        width: 240mm;
        height: 87mm;
        padding: 4mm;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    .account-payee, .chq-date, .chq-pay-name, .bearer, .chq-inwords-n1, .chq-inwords-n2, .amount, .muri_amount {
        position: absolute !important;
        border: 1px solid #333;
        padding: 3px;
    }

    .account-payee {
        left: 20mm;
        top: 30mm;
        width: 50mm;
        height: 6mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }

    .chq-date {
        left: 194mm;
        top: 20mm;
        border: none;
        display: flex;
        justify-content: center;
    }

    .chq-date .latter1, .chq-date .latter2, .chq-date .latter3, .chq-date .latter4, .chq-date .latter5, .chq-date .latter6, .chq-date .latter7, .chq-date .latter8 {
        width: 5mm;
        height: 6mm;
        border: 1px solid #333;
        margin-left: 1mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }

    .chq-date .latter3, .chq-date .latter5 {
        margin-left: 1mm;
    }

    .chq-pay-name {
        left: 80mm;
        top: 31mm;
        width: 150mm;
        height: 8mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }

    .bearer {
        left: 20mm;
        top: 36mm;
        width: 60mm;
        height: 6mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }

    .chq-inwords-n1 {
        left: 96mm;
        top: 41mm;
        width: 100mm;
        height: 9mm;
        line-height: mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }

    .chq-inwords-n2 {
        left: 5mm;
        top: 46mm;
        width: 120mm;
        height: 8mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }

    .amount {
        left: 189mm;
        top: 41mm;
        width: 57mm;
        height: 13mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: px;
    }

    .muri_amount {
        left: 20mm;
        top: 48mm;
        width: 60mm;
        height: 6mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }

    @media print {
        .chq-content {
            background: none !important;
			overflow: visible; /* Ensure content isn't clipped */
			position: relative;
            transform: rotate(90deg);
            margin: auto;
            top: -190px;
        }

        .chq-date .latter1, .chq-date .latter2, .chq-date .latter3, .chq-date .latter4, .chq-date .latter5, .chq-date .latter6, .chq-date .latter7, .chq-date .latter8 {
            border: none !important;
        }

        .account-payee, .chq-date, .chq-pay-name, .bearer, .chq-inwords-n1, .chq-inwords-n2, .amount, .muri_amount {
            border: none !important;
        }

    

        html, body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

/*        .chq-content + .chq-content {
            page-break-before: always;
        }*/
		
		  .page-break {
			page-break-before: always; /* or page-break-after */
		  }
    }
</style>
<script type="text/javascript">
function hide() {
    document.getElementById("pr").style.display = "none";
}
</script>
</head>
<body>    
    <div id="pr" style="padding-top: 36mm;">
        <button name="button" type="button" onclick="hide(); window.print();" value="Print" style="width: 55px; cursor: pointer;">
            <img src="../../../../public/assets/images/print.png" width="40" height="40">
        </button>
    </div>

    <div class="chq-content">
        <div class="account-payee">29-07-2024</div>
        <div class="chq-date">
            <div class="latter1" style="text-align:center">0</div>
            <div class="latter2" style="text-align:center">7</div>
            <div class="latter3" style="text-align:center">0</div>
            <div class="latter4" style="text-align:center">6</div>
            <div class="latter5" style="text-align:center">2</div>
            <div class="latter6" style="text-align:center">0</div>
            <div class="latter7" style="text-align:center">2</div>
            <div class="latter8" style="text-align:center">4</div>
        </div>
        <div class="chq-pay-name">Chandan Enterprise Ltd</div>
        <div class="bearer">Chandan Enterprise Ltd</div>
        <div class="chq-inwords-n1">Five Thousand Only</div>
        <div class="amount">**5,000**</div>
        <div class="muri_amount">5,000 /-</div>
    </div>
	
	
<div class="page-break"></div>


    <div class="chq-content">
        <div class="account-payee">29-07-2024</div>
        <div class="chq-date">
            <div class="latter1" style="text-align:center">0</div>
            <div class="latter2" style="text-align:center">7</div>
            <div class="latter3" style="text-align:center">0</div>
            <div class="latter4" style="text-align:center">6</div>
            <div class="latter5" style="text-align:center">2</div>
            <div class="latter6" style="text-align:center">0</div>
            <div class="latter7" style="text-align:center">2</div>
            <div class="latter8" style="text-align:center">4</div>
        </div>
        <div class="chq-pay-name">Jobaraj Enterprise</div>
        <div class="bearer">Chandan Enterprise Ltd</div>
        <div class="chq-inwords-n1">Five Thousand Only</div>
        <div class="amount">**10,000**</div>
        <div class="muri_amount">10,000 /-</div>
    </div>
	
	
	
</body>
</html>
