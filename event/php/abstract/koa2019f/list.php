<?php
include_once "config.php";
?>

<ul class="subjectList">
	<?
	$query = "SELECT * FROM ( SELECT a.*,u.first_name,u.last_name,u.kor_name,
	
	(CASE WHEN a.abs_no LIKE 'OPP%' THEN (RIGHT(a.abs_no,4)*1)+3000 WHEN a.abs_no LIKE 'OP%' THEN (RIGHT(a.abs_no,4)*1)+1000 WHEN a.abs_no LIKE 'PP%' THEN (RIGHT(a.abs_no,4)*1)+2000 WHEN a.abs_no LIKE 'VP%' THEN (RIGHT(a.abs_no,4)*1)+4000 ELSE (a.abs_no*1)+4000 END) AS chk_sort FROM abstract_tbl a LEFT JOIN user_binfo u ON a.user_sid=u.sid WHERE a.sid IS NOT NULL and a.del='N' and a.pass='Y'  ";
	
	$query .= " and a.field='".$parent."'";

	$query .= ") new_tbl ORDER BY chk_sort";	

	/*
	OP
	PP
	OPP
	VP
	나머지

	*/
	

	//echo $query;exit;
	$result=$local_conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	while(is_array($col=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
		
		
	##발표자 책임저자 등록
	$pname="";

	$p_author_query = "select * from abstract_author where asb_num='".$col['sid']."' and FIND_IN_SET(1, type)";
	$p_author_result = $local_conn->query($p_author_query);
	if(DB::isError($p_author_result)) {
		die($p_author_result->getMessage().'author_query');
	}

	$p_author_col = $p_author_result->fetchRow(DB_FETCHMODE_ASSOC);
	$pname = $p_author_col['first_name'].' '.$p_author_col['last_name'];
	$abs_no = $col['abs_no'];



	$info_query = "select a.link_session, a.time, b.language, r.name as room_name, r.photo, g.name as date_name from session_tbl a, session_tbl b, session_time_tbl t, session_room_tbl r, agenda_tbl g where a.link_session=b.sid and a.time=t.sid and b.room=r.sid and b.tab=g.sid and a.code='".$code."' and a.abs_no='".$abs_no."'";
	$info_result = mysqli_query($conn, $info_query);
	$info = mysqli_fetch_array($info_result);
	

	$link_url = "./view.php?code=".$code."&deviceid=".$deviceid."&tab=".$tab."&sid=".$col['sid'];
	?>
	
	<li>
		<a href="<?=$link_url?>">
			<span class="sessionCode"><?if(strpos($abs_no, "]")===false){?>[<?}?><?=$abs_no?><?if(strpos($abs_no, "]")===false){?>]<?}?></span><br>
			<span class="sessionTit"><?=!empty($col['title_eng'])?$col['title_eng']:$col['title_kor']?></span>
			<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$pname?></span>

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