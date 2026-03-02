<?php 
$i = 0; 
?>

<script type="text/javascript">
	var sub_ledgers = [ 
		<?php 
			$a2="
				select ledger_id, 
					ledger_name 
				from 
					accounts_ledger 
				where 
					balance_type IN ('Debit','Both') AND
					1 
				order by 
					ledger_name";
		$a1	=	db_query($a2);
		while(	$a = mysqli_fetch_row($a1) )
			{
				$i++;
				//echo "<option value=\"".$a[0]." : ".$a[1]."\">".$a[1]."</option>";
				echo "'".$a[1]."'";
				if( $i < mysqli_num_rows($a1) ) 
					echo ", ";
				
				$b2="
					select 
						sub_ledger_id,
						sub_ledger 
					from 
						sub_ledger 
					where 
						ledger_id='$a[0]'";
				$b1 = db_query($b2);
				$c  = mysqli_num_rows($b1);
				
				if($c>0)
					{
						$j = 0;
						while($b=mysqli_fetch_row($b1))
							{
								$j++;
								echo "'".$a[1]."::".$b[1]."'";
								if( ($j < $c) || ($i < mysqli_num_rows($a1)) ) 
									echo ", ";
							}
					}
									
			}	 
		?> ];
</script>