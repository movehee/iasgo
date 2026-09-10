<?	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";


	
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=".$code."_log.xls"); 
	header( "Content-Description: PHP4 Generated Data" ); 

	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");


	$query="SELECT info,count(*) cnt FROM log_tbl where code='".$code."' group by info order by count(*) desc";
	
	$result = mysqli_query($conn, $query);
?>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<table border=1>
	<tr>
		<td>info</td>
		<td>info2</td>
		<td>info3</td>
		<td>count</td>
	</tr>
	<?
		while(is_array($d = mysqli_fetch_array($result))){?>
	
			<tr>
			<td colspan='3'><?=iconv("UTF-8", "EUC-KR", $d['info'])?></td>
			<td><?=$d['cnt']?></td></tr>
			<?
				$sub_query = "SELECT info2, count(*) cnt FROM log_tbl where code='".$code."' and info='".$d['info']."' and info2 not in ('') group by info2 order by count(*) desc";
				$sub_result = mysqli_query($conn, $sub_query);

				while(is_array($sub_d = mysqli_fetch_array($sub_result))){?>
				<tr>
				<td></td><td colspan='2'><?=iconv("UTF-8", "EUC-KR", $sub_d['info2'])?></td>
				<td><?=$sub_d['cnt']?></td></tr>

				<?
				$sub2_query = "SELECT info3, count(*) cnt FROM log_tbl where code='".$code."' and info='".$d['info']."' and info2='".$sub_d['info2']."' and info3 not in ('') group by info3 order by count(*) desc";
				$sub2_result = mysqli_query($conn, $sub2_query);
				while(is_array($sub2_d = mysqli_fetch_array($sub2_result))){?>

				<tr>
				<td colspan='2'></td><td><?=iconv("UTF-8", "EUC-KR", $sub2_d['info3'])?></td>
				<td><?=$sub2_d['cnt']?></td></tr>
					
				
				<?}?>


				<?}
			?>
		</tr>
	<?
	}		
	?>
</table>
