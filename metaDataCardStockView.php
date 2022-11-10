<!--
// todos los parametros que puede recibir por variable
//$information
//$symbol
//$last_refreshed
//$out_size
//$time_zone
//$key_id[]
//$daily[]
//$open[]
//$high[]
//$low[]
//$close[]
//$volume[] 
-->

<?php
date_default_timezone_set($time_zone);
$i = 0;
$maxValueOpen = 0;
$minValueOpen = 0;
?>
<div class="card">
	<h1 class="entry-header"><?php echo strtoupper($symbol);?></h1>
	<div class="container">
		<h2 class="entry-header"><?php echo $symbol;?></h2>
		<span id="daily"> <?php echo'daily';?></span> <?php echo $daily[$i];?><br>
		<span><?php echo'open';?></span> <?php echo $open[$i];?><br>
		<span>high</span> <?php echo $high[$i];?><br>
		<span>low</span> <?php echo $low[$i];?><br>
		<span>close</span> <?php echo $close[$i];?><br>
		<span>volume</span> <?php echo $volume[$i];?><br>
		<div class="wp-block-button">
			<a class="wp-block-button__link" href="https://nascor01.md360.es/wordpress/web-service/web-service/';
<?php echo $last_refreshed;?>"><?=date('m/d/y');?></a>
		</div>
		<?php
	if ($open[$i] > $maxValueOpen){
		$maxValueOpen = $open[$i];
	}
				if ($low[$i] > $minValueOpen){
					$minValueOpen = $low[$i];
				}
		?>
		<label for="file">Posición a fecha : </label><?php echo $last_refreshed;?><br>
		<label for="open">Status bar :</label>
		<progress id="open" value="<?php echo $minValueOpen;?>" max="<?php echo $maxValueOpen; ?>"> 32% </progress><br>
	</div>
	

</div>



