<?php
include_once "config.php";
?>

<ul class="subjectList">
	<?

	$query = "SELECT * FROM abstract_tbl a where ifnull(a.deldate,'')='' and abyear='2019' and a.order_no > 0  ";

	if($parent == '1') {
		
	} else if($parent == '2') {

	}

	if($search) {
		$query .= " and (subject like '%$search%' OR body_content like '%$search%' OR concat(p_fname, ' ', p_lname) like '%$search%' OR concat(c_fname, ' ', c_lname) like '%$search%')";
	}

	$query .= " order by a.order_no";
	$abs_result=$local_conn->query($query);
	if(DB::isError($abs_result)) die($abs_result->getMessage());
	$abs_num = $abs_result->numRows();
	
	if($abs_num && $search) {
		echo '<h3 class="dayInfo2">Abstract</h3>';
	}

	while(is_array($col=$abs_result->fetchRow(DB_FETCHMODE_ASSOC))) {
		
	$cnt++;
	

	$link_url = "/php/abstract/view.php?code=".$code."&deviceid=".$deviceid."&sid=".$col['sid'];
	?>
	
	<li>
	<a href="<?=$link_url?>">
		<span class="sessionCode">[<?=$col['abstract_num']?>]</span><br>
		<span class="sessionTit"><?=$col['subject']?></span>
		<span style="letter-spacing: -1px; font-size: 14px; font-weight: 400; font-family: Roboto;"><?=$col['p_fname']?> <?=$col['p_lname']?></span>
		</a>
	</li>

	<?}?>
</ul>