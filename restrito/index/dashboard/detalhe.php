<?php 
	require_once("funcoes.php");
	
	function getHeader($var) {
		$ret = "";
		foreach($var as $x => $x_value) {
			$ret .= "<th>$x</th>";
		}	
		
		echo $ret;
	}
	
?>

<div class="boll-table">
	<table class="table">
		 <thead>
			<tr>
				<?php getHeader($ret); ?>
			</tr>
		</thead>
	
		<?php echo getSolResDir(); ?>
	
	</table>
</div>