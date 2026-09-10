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
	$cname="";
	for($j=1;$j<=$col['author_cnt']*1;$j++){$k=$j-1;
		$author_query = "select * from abstract_author where asb_num='".$col['sid']."' and orders='".$j."'";
		$author_result = $local_conn->query($author_query);
		if(DB::isError($author_result)) {
			die($author_result->getMessage().'author_query');
		}

		$author_col = $author_result->fetchRow(DB_FETCHMODE_ASSOC);		//  $row 배열에 입력시킨다.
		?>
		<!--<?=$j>1?', ':''?><?=$author_col['first_name'].' '.$author_col['last_name']?><sup><?=$author_col['affilation']?></sup>-->
		<?
		$author_type = explode(',',$author_col['type']);
		if(in_array('1',$author_type)){
			$pname=$author_col['first_name'].' '.$author_col['last_name'];
			//echo '<sup>*</sup>';
		}

		if(in_array('2',$author_type)){
			$cname=$author_col['first_name'].' '.$author_col['last_name'];
			//echo '<sup>†</sup>';
		}
		?>
	<?}
	

	$link_url = "./view.php?code=".$code."&deviceid=".$deviceid."&tab=".$tab."&sid=".$col['sid'];
	?>
	
	<li>
	<a href="<?=$link_url?>">
		<span class="sessionCode"><?if(strpos($col['abs_no'], "]")===false){?>[<?}?><?=$col['abs_no']?><?if(strpos($col['abs_no'], "]")===false){?>]<?}?></span><br>
		<span class="sessionTit"><?=!empty($col['title_eng'])?$col['title_eng']:$col['title_kor']?></span>
		<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$pname?></span>
		</a>
	</li>

	<?}?>
</ul>