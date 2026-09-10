<?php
	$day_result = mysqli_query($conn, "select count(*) cnt from agenda_tbl where code='".$code."' and del='N'");
	$day_row = mysqli_fetch_array($day_result);
	$cnt = $day_row['cnt'];

	if($cnt>1) {

		$day_query="SELECT * FROM agenda_tbl where code='".$code."' and del='N' order by eventdate asc";
		$day_result = mysqli_query($conn, $day_query);
		while(is_array($day_col = mysqli_fetch_array($day_result))){
			if($day_col['sid']==$tab) $select_eventdate = $day_col['eventdate'];
		}
		mysqli_data_seek($day_result,0); 
		if($setting_col['day_type']=="1"){
		?>
			<ul class="tabMenu">
			<?while(is_array($day_col = mysqli_fetch_array($day_result))){?>
				<li class="menu<?if($tab==$day_col['sid']){echo " on";}?>" style="width:<?=100/$cnt?>%"><a href="<?=$_SERVER['PHP_SELF']?>?tab=<?=$day_col['sid']?>&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>&glance=<?=$glance?>"><?=$day_col['name']?></a></li>
			<?}?>
			</ul>
		<?}else if($setting_col['day_type']=="2"){
			//$cnt = mysqli_num_rows($day_result);
			
			$day_col = mysqli_fetch_assoc($day_result);
			mysqli_data_seek($day_result,0); 
		?>
			<dl class="period">
			<dt><?=date("M.",$select_eventdate)?></dt>
			<dd>
				<ul>
				<?if($cnt<4){?>
					<li>
						<span class="week"><?=date("D",$day_col['eventdate']-2*24*60*60)?></span>
						<span class="day"><?=date("d",$day_col['eventdate']-2*24*60*60)?></span>
					</li>
				<?}
				if($cnt<6){?>
					<li>
						<span class="week"><?=date("D",$day_col['eventdate']-1*24*60*60)?></span>
						<span class="day"><?=date("d",$day_col['eventdate']-1*24*60*60)?></span>
					</li>
					
				<?}?>
				<?while(is_array($day_col = mysqli_fetch_array($day_result))){
					$last_day = $day_col['eventdate'];
				?>
					<li class="event <?if($tab==$day_col['sid']){echo "on";}?>"><a href="<?=$_SERVER['PHP_SELF']?>?tab=<?=$day_col['sid']?>&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>&glance=<?=$glance?>">
						<span class="week"><?=date("D",$day_col['eventdate'])?></span>
						<span class="day"><?=date("d",$day_col['eventdate'])?></span>
					</a></li>
				<?}?>

				<?if($cnt<6){?>
					<li>
						<span class="week"><?=date("D",$last_day+1*24*60*60)?></span>
						<span class="day"><?=date("d",$last_day+1*24*60*60)?></span>
					</li>
					
				<?}?>
				<?if($cnt<4){?>
					<li>
						<span class="week"><?=date("D",$last_day+2*24*60*60)?></span>
						<span class="day"><?=date("d",$last_day+2*24*60*60)?></span>
					</li>
				
				<?}?>

				</ul>
			</dd>
		</dl>
		<?}else if($setting_col['day_type']=="3"){
			$yoil = array("일","월","화","수","목","금","토");

			$day_col = mysqli_fetch_assoc($day_result);
			mysqli_data_seek($day_result,0); 
		?>
			<dl class="period">
			<dt><?=date("n 월",$select_eventdate)?></dt>
			<dd>
				<ul>
				<?if($cnt<4){?>
					<li>
						<span class="week"><?=$yoil[date("w",$day_col['eventdate']-2*24*60*60)]?></span>
						<span class="day"><?=date("d",$day_col['eventdate']-2*24*60*60)?></span>
					</li>
				<?}
				if($cnt<6){?>
					<li>
						<span class="week"><?=$yoil[date("w",$day_col['eventdate']-1*24*60*60)]?></span>
						<span class="day"><?=date("d",$day_col['eventdate']-1*24*60*60)?></span>
					</li>
					
				<?}?>
				<?while(is_array($day_col = mysqli_fetch_array($day_result))){
					$last_day = $day_col['eventdate'];
				?>
					<li class="event <?if($tab==$day_col['sid']){echo "on";}?>"><a href="<?=$_SERVER['PHP_SELF']?>?tab=<?=$day_col['sid']?>&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>&glance=<?=$glance?>">
						<span class="week"><?=$yoil[date("w",$day_col['eventdate'])]?></span>
						<span class="day"><?=date("d",$day_col['eventdate'])?></span>
					</a></li>
				<?}?>

				<?if($cnt<6){?>
					<li>
						<span class="week"><?=$yoil[date("w",$last_day+1*24*60*60)]?></span>
						<span class="day"><?=date("d",$last_day+1*24*60*60)?></span>
					</li>
					
				<?}?>
				<?if($cnt<4){?>
					<li>
						<span class="week"><?=$yoil[date("w",$last_day+2*24*60*60)]?></span>
						<span class="day"><?=date("d",$last_day+2*24*60*60)?></span>
					</li>
				
				<?}?>

				</ul>
			</dd>
		</dl>

		<?}?>


	<?}?>
