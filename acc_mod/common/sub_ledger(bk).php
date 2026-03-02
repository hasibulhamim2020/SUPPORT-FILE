<?php
	$r = db_query("SELECT sub_ledger FROM sub_ledger WHERE sub_ledger!='sub_ledger_initial' ORDER BY sub_ledger");
	//$arr = array("Asia", "Afganistan", "Arzentina", "Bahmas", "Brazil", "Bangladesh", "Canada", "China");
	//reset($arr);
	$i = 0;
?>

<script type="text/javascript">
	var sub_ledgers = [ <?php while ( $row = mysqli_fetch_array($r) ) { $i++; echo "'$row[sub_ledger]'"; if( $i < mysqli_num_rows($r) ) echo ", "; } ?> ];
</script>