<script type="text/javascript">
	var sub_ledgers = [ 
		<?php 
			$a2="select 
					ledger_id, 
					ledger_name 
				from 
					accounts_ledger 
				where 
					balance_type IN ('Credit','Both') AND
					1 
				order by 
					ledger_name";
		$a1	=	db_query($a2);
		$i = 0; 
		while(	$a = mysqli_fetch_row($a1) )
			{
				if( $i == 0 ) 	echo   "'".$a[1]."'";
				else 			echo ", '".$a[1]."'";
				$i++;
				
				$b2="select 
						sub_ledger_id,
						sub_ledger 
					from 
						sub_ledger 
					where 
						ledger_id='$a[0]'";
				$b1 = db_query($b2);
				$c  = mysqli_num_rows($b1);
				
				if($c>0)
					{ $j = 0;
						while($b=mysqli_fetch_row($b1))
							{
							if($j == 0 ) 	echo   "'".$a[1]."::".$b[1]."'";
							else 			echo ", '".$a[1]."::".$b[1]."'";
							$j++;
							}
					}
									
			}	 
		?> ];
</script>