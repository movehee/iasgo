<?if($setting_col['selected_box']=="1"){
if($room){
	$temp_result = mysqli_query($conn, "SELECT name from session_room_tbl where del='N' and viewYN='Y' and sid='".$room."'");
	$temp_row = mysqli_fetch_array($temp_result);
	$room_info = $temp_row['name'];
}
?>
<div class="toggleMenu">
	<p><a href="#" class="trigger"><?if($room_info){echo $room_info;}else{?>Room Select<?}?> <i class="fas fa-angle-down"></i></a></p>
	<ul class="toggleCon">
	<?
		$room_query="SELECT * FROM session_room_tbl where code='".$code."' and del='N' and viewYN='Y' and name not in ('ALL','All','all') and tab='".$tab."' order by orderby asc";
		$room_result = mysqli_query($conn, $room_query);
		?><li><a href="./list.php?tab=<?=$tab?>&code=<?=$code?>&toptext=<?=$toptext?>">ALL</a></li><?	
		while(is_array($room_col = mysqli_fetch_array($room_result))){?>
			<li><a href="./list.php?tab=<?=$tab?>&code=<?=$code?>&room=<?=$room_col['sid']?>&toptext=<?=$toptext?>"><?=$room_col['name']?></a></li>
		<?}?>
		
	</ul>
</div>
<?}else if($setting_col['selected_box']=="2"){
if($category){
	$temp_result = mysqli_query($conn, "SELECT info from session_category_tbl where sid='".$category."' and select_category='Y'");
	$temp_row = mysqli_fetch_array($temp_result);
	$category_info = $temp_row['info'];
}

	$room_query="SELECT a.* FROM session_category_tbl a, session_tbl b where a.sid=b.category1 and a.code='".$code."' and b.tab='".$tab."' and a.del='N' and a.select_category='Y' group by a.sid order by a.orderby asc ";
	$room_result = mysqli_query($conn, $room_query);

	$romm_category_num = $room_result->num_rows;
?>
<div class="toggleMenu">
	<p><a href="#" class="trigger"><?if($category_info){echo $category_info;}else{?>Category Select<?}?> <i class="fas fa-angle-down"></i></a></p>
	<ul class="toggleCon" <?if($romm_category_num > 15){?>style="max-height:400px;overflow-y:scroll;-webkit-overflow-scrolling: touch;"<?}?>>
	<?
		
		?><li><a href="./list.php?tab=<?=$tab?>&code=<?=$code?>&toptext=<?=$toptext?>"><?=$string['search_box']?></a></li><?	
		while(is_array($room_col = mysqli_fetch_array($room_result))){?>
			<li><a href="./list.php?tab=<?=$tab?>&code=<?=$code?>&category=<?=$room_col['sid']?>&toptext=<?=$toptext?>"><?=$room_col['info']?></a></li>
		<?}?>
		
	</ul>
</div>



<?}else if($setting_col['selected_box']=="3"){

if($room){
	$temp_result = mysqli_query($conn, "SELECT name from session_room_tbl where del='N' and viewYN='Y' and sid='".$room."'");
	$temp_row = mysqli_fetch_array($temp_result);
	$room_info = $temp_row['name'];
}
?>
<div class="toggleMenu" style="width:50%;float:left">
	<p><a href="#" class="trigger"><?if($room_info){echo $room_info;}else{?>Room Select<?}?> <i class="fas fa-angle-down"></i></a></p>
	<ul class="toggleCon">
	<?
		$room_query="SELECT * FROM session_room_tbl where code='".$code."' and del='N' and viewYN='Y' and name not in ('ALL','All','all') and tab='".$tab."' order by orderby asc";
		$room_result = mysqli_query($conn, $room_query);
		?><li><a href="./list.php?tab=<?=$tab?>&code=<?=$code?>&toptext=<?=$toptext?>">ALL</a></li><?	
		while(is_array($room_col = mysqli_fetch_array($room_result))){?>
			<li><a href="./list.php?tab=<?=$tab?>&code=<?=$code?>&room=<?=$room_col['sid']?>&toptext=<?=$toptext?>&category=<?=$category?>"><?=$room_col['name']?></a></li>
		<?}?>
		
	</ul>
</div>
<?
if($category){
	$temp_result = mysqli_query($conn, "SELECT info from session_category_tbl where sid='".$category."' and select_category='Y'");
	$temp_row = mysqli_fetch_array($temp_result);
	$category_info = $temp_row['info'];
}

$room_query="SELECT a.* FROM session_category_tbl a, session_tbl b where a.sid=b.category1 and a.code='".$code."' and b.tab='".$tab."' and a.del='N' and a.select_category='Y' group by a.sid order by a.orderby asc ";
$room_result = mysqli_query($conn, $room_query);

$romm_category_num = $room_result->num_rows;
?>
<div class="toggleMenu" style="width:50%;float:left">
	<p><a href="#" class="trigger"><?if($category_info){echo $category_info;}else{?>Category Select<?}?> <i class="fas fa-angle-down"></i></a></p>
	<ul class="toggleCon" <?if($romm_category_num > 15){?>style="max-height:400px;overflow-y:scroll;-webkit-overflow-scrolling: touch;"<?}?>>
	<?
		
		?><li><a href="./list.php?tab=<?=$tab?>&code=<?=$code?>&toptext=<?=$toptext?>"><?=$string['search_box']?></a></li><?	
		while(is_array($room_col = mysqli_fetch_array($room_result))){?>
			<li><a href="./list.php?tab=<?=$tab?>&code=<?=$code?>&category=<?=$room_col['sid']?>&toptext=<?=$toptext?>&room=<?=$room?>"><?=$room_col['info']?></a></li>
		<?}?>
		
	</ul>
</div>
<?}?>