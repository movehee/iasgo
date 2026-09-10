<?	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

	if($excel_type=="down") {
	
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=".$_COOKIE['code']."_feedback.xls"); 
	header( "Content-Description: PHP4 Generated Data" ); 

	}

	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");


	$query = "select * from feedback_result_tbl where code='".$_COOKIE['code']."'";
	
	$result = mysqli_query($conn, $query);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<style>
table{ width:100%; font-size: 14px; border-collapse: collapse}
table tr th,
table tr td{padding: 5px 10px;text-align:center;}
table tr th{background-color: #ececec; padding: 15px 10px;}
</style>

<table border=1>
	<tr>
		<th>Send Time</th>
		<th>Name</th>
		<th>Office</th>
		<th>Mail</th>
		<th>License</th>
		<th>Tab</th>
		<th>Deviceid</th>
		<?for($i=1;$i<11;$i++){?>
			<th>memo<?=$i?></th>
		<?}?>
		<?for($i=1;$i<41;$i++){?>
			<th>answer<?=$i?></th>
		<?}?>

		<th>event</th>

	</tr>
	<?
		while(is_array($col = mysqli_fetch_array($result))){
			
			$rresult = mysqli_query($conn,"select * from regist_tbl where sid='".$col['deviceid']."'");
			$row = mysqli_fetch_array($rresult);
			
	?>
	
		<tr>
			<td><?=date("y/m/d H:i", $col['signdate'])?></td>
			<!-- <td><?=iconv("UTF-8", "EUC-KR", $col['name'])?></td>
			<td><?=iconv("UTF-8", "EUC-KR", $col['office'])?></td> -->
			<td><?=iconv("UTF-8", "EUC-KR", $row['info1'])?></td>
			<td><?=iconv("UTF-8", "EUC-KR", $row['info5'])?></td>
			
			<td><?=iconv("UTF-8", "EUC-KR", $col['email'])?></td>
			<td><?=iconv("UTF-8", "EUC-KR", $col['license'])?></td>
			<td><?=$col['tab']?></td>
			
			<td><?=$col['deviceid']?></td>

			<?for($i=1;$i<11;$i++){?>
				<td><?=iconv("UTF-8", "EUC-KR", $col['memo'.$i])?></td>
			<?}?>
			<?for($i=1;$i<41;$i++){?>
				<td><?=$col['answer'.$i]?></td>
			<?}?>

			<td><?=$col['event_yn']?></td>
			
		</tr>
	<?
	}		
	?>
</table>
