<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cheque Design</title>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    @page {
        size: A4;
        margin: 0;
    }

    html, body {
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
    }

    .chq-content {
        width: 252mm;
        height: 80mm;
        padding: 4mm;
        box-sizing: border-box;
        background-color: #f0f0f0;
        position: relative;
        transform: rotate(90deg);
        margin: auto;
		top:-190px;
    }

    .account-payee, .chq-date, .chq-pay-name, .bearer, .chq-inwords-n1, .chq-inwords-n2, .amount, .muri_amount {
        position: absolute;
        border: 1px solid #333;
        padding: 3px;
    }

    .account-payee {
        left: 5mm;
        top: 20mm;
        width: 50mm;
        height: 6mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
    }

    .chq-date {
        left: 199mm;
        top: 16mm;
        border: none;
        display: flex;
        justify-content: center;
    }

    .chq-date .latter {
        width: 5mm;
        height: 6mm;
        border: 1px solid #333;
        margin-left: 1mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
    }

    .chq-pay-name {
        left: 81mm;
        top: 29mm;
        width: 150mm;
        height: 8mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
    }

    .bearer {
        left: 5mm;
        top: 38mm;
        width: 60mm;
        height: 6mm;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .chq-inwords-n1 {
        left: 105mm;
        top: 43mm;
        width: 100mm;
        height: 9mm;
        line-height: 7mm;
        display: flex;
        justify-content: center;
        align-items: center;
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
        font-size: 15px;
    }

    .amount {
        left: 188mm;
        top: 39mm;
        width: 57mm;
        height: 13mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
    }

    .muri_amount {
        left: 5mm;
        top: 55mm;
        width: 60mm;
        height: 6mm;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
    }

    @media print {
        .chq-content {
            background: none !important;
        }

        .chq-date .latter, .account-payee, .chq-pay-name, .bearer, .chq-inwords-n1, .chq-inwords-n2, .amount, .muri_amount {
            border: none !important;
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
            <img src="../../../../public/assets/images/print.png" width="40" height="40" alt="Print"/>
        </button>
    </div>

    <div class="chq-content">
        <div class="chq-date">
            <div class="latter">0</div>
            <div class="latter">4</div>
            <div class="latter">0</div>
            <div class="latter">6</div>
            <div class="latter">2</div>
            <div class="latter">0</div>
            <div class="latter">2</div>
            <div class="latter">4</div>
        </div>
        <div class="chq-pay-name">Abul Hasan</div>
        <div class="chq-inwords-n1">Five Thousand Only</div>
        <div class="amount">**5,000**</div>
        <div class="account-payee">06-06-2024</div>
        <div class="bearer">Abul Hasan</div>
        <div class="muri_amount">5,000 /-</div>
    </div>
</body>
</html>