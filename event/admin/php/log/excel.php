<?	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";


	
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=".$code."_log.xls"); 
	header( "Content-Description: PHP4 Generated Data" ); 

	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");


	$query = "select * from log_tbl where code='".$code."'";
	
	$result = mysqli_query($conn, $query);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<table border=1>
	<tr>
		<td>info</td>
		<td>info2</td>
		<td>info3</td>
		<td>deviceid</td>
	</tr>
	<?
		while(is_array($col = mysqli_fetch_array($result))){?>
	
		<tr>
			<td><?=iconv("UTF-8", "EUC-KR", $col['info'])?></td>
			<td><?=iconv("UTF-8", "EUC-KR", $col['info2'])?></td>
			<td><?=iconv("UTF-8", "EUC-KR", $col['info3'])?></td>
	
			<td><?=$col['deviceid']?></td>
		</tr>
	<?
	}		
	?>
</table>
