<?php
include_once "config.php";
?>

<ul class="subjectList">
	<?
	$query = "SELECT * FROM abstract_tbl a where a.order_no > 0  ";
	
	$query .= " and a.s_category1='".$parent."' order by a.order_no ";
	

	//echo $query;exit;
	$result=$local_conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	while(is_array($col=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		
		
	
	

	$link_url = "./view.php?code=".$code."&deviceid=".$deviceid."&tab=".$tab."&sid=".$col['sid'];
	?>
	
	<li>
		<a href="<?=$link_url?>">
			<span class="sessionCode">[<?=$col['abstract_num']?>]</span><br>
			<span class="sessionTit"><?=$col['subject']?></span>
			<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$col['p_fname']?> <?=$col['p_lname']?></span>

			<?if($info){?>
			<div class="sessionInfo" style="padding-top:10px;font-size:14px;">
				<?=$info['date_name']?>&nbsp;
				<i class="far fa-clock" title="Time"></i> <?=$info['time']?>&nbsp;
				<i class="fas fa-map-marker-alt" title="Venue"></i> <?=$info['room_name']?>				
			</div>
			<?}?>
		</a>
	</li>

	<?}?>
</ul>