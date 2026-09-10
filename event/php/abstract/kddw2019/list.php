<?php
include_once "config.php";

if($session_sid) 
{
	$query_cat = "select * from session_tbl where link_session='$session_sid'";
	$result_cat = mysqli_query($conn, $query_cat);
	while(is_array($cat = mysqli_fetch_array($result_cat))){
		$abs_no_arr[] = $cat['abs_no'];
	}
	
	if($abs_no_arr) {

		$abs_no = implode("','", $abs_no_arr);


		$query = "SELECT a.* FROM abstract_tbl a WHERE a.ab_num in ('".$abs_no."') ";
		$result=$local_conn->query($query);
		if(DB::isError($result)) die($result->getMessage());	
		
?>

</div>
	<ul class="subjectList">
		<?
		while(is_array($abs=$result->fetchRow(DB_FETCHMODE_ASSOC))){

		$link_url = "./view.php?code=".$code."&deviceid=".$deviceid."&sid=".$abs['sid'];
		?>
		<li><a href="<?=$link_url?>">
			<span class="sessionCode" style="margin-bottom:3px; display:block;">
				<?=$abs['ab_num']?>
			</span>
			


			<span class="sessionTit"><?=$abs['subject']?></span> 
			<span class="speaker">
				<span class="absSpeaker"> <?=$abs['first_name'].' '.(!empty($abs['middle_name'])?$abs['middle_name'].' ':'').$abs['last_name']?></span>
			</span>
			
			</a>
		</li>
		<?}?>
	</ul>

<?
	}
}
else
{
$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.viewYN='Y' and a.category1='$category1' order by a.tab, t.orderby";
$result = mysqli_query($conn, $query);
?>

<?
include_once $_SERVER['DOCUMENT_ROOT']."/php/session/info.php";
}
?>

