<?php
include_once "config.php";
?>

<ul class="subjectList">
	<?
	/*
	$query =  "
	select * from (
		select 'A' as type, receipt_num, pt_order_info, position, author, announcer, exchange_author, gubun, subject, purpose, method, effect, conclusion, section_category, section_gubun, pt_order_info as orderby from korl_abstract_tbl_type_i a, section_info b where a.section_code=b.section_code and ifnull(pt_order_info,'')!='' and code='25'
		union
		select 'B' as type, receipt_num, pt_order_info, position, author, announcer, exchange_author, gubun, subject, purpose, method, effect, conclusion, section_category, section_gubun_mobile as section_gubun, concat('Z', pt_order_info) as orderby from korl_abstract_tbl_type_i_sub a, section_info2 b where a.section_code=b.section_code and ifnull(pt_order_info,'')!='' and code='25' 
	) a ";
	*/

	$query =  "
	select * from (
		select 'A' as type, receipt_num, pt_order_info, position, author, announcer, exchange_author, gubun, subject, purpose, method, effect, conclusion, section_category, section_gubun_mobile, pt_order_info as orderby from korl_abstract_tbl_type_i a, section_info b where a.section_code=b.section_code and ifnull(pt_order_info,'')!='' and code='25'
		union
		select 'B' as type, receipt_num, pt_order_info, position, author, announcer, exchange_author, gubun, subject, purpose, method, effect, conclusion, section_category, section_gubun_mobile, concat('Z', pt_order_info) as orderby from korl_abstract_tbl_type_i_sub a, section_info2 b where a.section_code=b.section_code and ifnull(pt_order_info,'')!='' and code='25' 
	) a ";

	if($parent == '1') {
		//$query .= " where section_gubun='$tab'";
		$query .= " where section_gubun_mobile='$tab'";
	} else if($parent == '2') {
		$query .= " where section_category='$tab'";
	}

	if($search) {
		$query .= " where (subject like '%$search%' OR author like '%$search%' OR announcer like '%$search%' OR exchange_author like '%$search%')";
	}

	$query .= " order by orderby";

	//echo $query;
	$abs_result = mysqli_query($local_conn, $query);
	$abs_num = $abs_result->num_rows;
	
	if($abs_num && $search) {
		echo '<h3 class="dayInfo2">Abstract</h3>';
	}

	while(is_array($col = mysqli_fetch_assoc($abs_result))) {
		
	$cnt++;
	

	$link_url = "/php/abstract/view.php?code=".$code."&deviceid=".$deviceid."&receipt_num=".$col['receipt_num']."&pt_order_info=".$col['pt_order_info'];
	?>
	
	<li>
	<a href="<?=$link_url?>">
	<?if($col['type']=='A'){?>
		<span class="sessionCode">[<?=$col['pt_order_info']?>]</span><br>
	<?}?>
		<span class="sessionTit"><?=$col['subject']?></span>
		<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$col['announcer']?></span>
		</a>
	</li>

	<?}?>
</ul>