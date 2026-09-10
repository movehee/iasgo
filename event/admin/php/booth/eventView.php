<?
	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
	
	
	$query = "select * from booth_event_tbl where code = 'kses2019f' group by user_sid";
	$result = mysqli_query($conn, $query);
	
	$query = "select user_sid,count(*) as count from booth_event_tbl where code = 'kses2019f'group by user_sid having count >= 26";
	$count = mysqli_query($conn, $query);
	
	
	?>
	
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>
		<body>
			<table border=1>
				<tr>
					<td>현재 이벤트  참여자</td>
					<td>부스이벤트 추첨 가능자</td>
				</tr>
				<tr>
					<td align="center">
						<?=$result->num_rows?> 명
					</td>
					
					<td align="center">
						<?=$count->num_rows?> 명
					</td>
					
				</tr>
			</table>

		</body>
	</html>