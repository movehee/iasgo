<?	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
	
	if($excel_type!='view') {
	
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=".$code."_like.xls"); 
	header( "Content-Description: PHP4 Generated Data" ); 

	}

	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");


	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
	$setting_result = mysqli_query($conn, $setting_query);
	$setting_col = mysqli_fetch_array($setting_result);


	$query = "select a.sid,a.title,a.speaker,count(*) cnt from session_tbl a, session_like_tbl b where b.session_sid=a.sid and a.code='".$code."' group by a.sid";
	$result = mysqli_query($conn, $query);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<table border=1>
	<tr>
		<td>title</td>
		<td>speaker</td>
		<td>like</td>
		<td>time</td>
	</tr>
	<?
		while(is_array($col = mysqli_fetch_array($result))){
		
			if($setting_col['faculty_type']==1){
				$faculty_query = "SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$col['sid']."' order by a.sid asc";
				$faculty_result = mysqli_query($conn, $faculty_query);
				$faculty_d = mysqli_fetch_array($faculty_result);
				$speaker= $faculty_d['name'];
			}else{
				$speaker= $col['speaker'];
			}

			?>
	
		<tr>
			<td><?if($col['title']){?><?=iconv("UTF-8", "EUC-KR", $col['title'])?><?}else{?><?=iconv("UTF-8", "EUC-KR", $col['theme'])?><?}?></td>

			<td><?=iconv("UTF-8", "EUC-KR", $speaker)?></td>


			<td><?=iconv("UTF-8", "EUC-KR", $col['cnt'])?></td>

			<td><?=$col['signdate']?date('Y-m-d H:i', $col['signdate']):""?></td>

		</tr>

	<?
	}		
	?>
</table>
