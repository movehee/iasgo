<?
include "./../../header2.php";
?>

<div id="container" style="width:1000px;">
	<h2 class="tooltipPoint">SMS 미리보기</h2>
	
	
	<div class="contents">

		<table class="tblList">
			<colgroup>
				<col style="width: 15%;">
				<col style="width: 75%;">
			</colgroup>
			<thead>
				<tr>
					<th>수신번호</th>
					<th>내용</th>
				</tr>
			</thead>

			<?
			$query = "select * from event_tbl where code='".$code."'";
			$result = mysqli_query($conn, $query);
			$e = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			

			$query = "SELECT * FROM session_set_tbl where code='".$code."' ";
			$result = mysqli_query($conn, $query);
			$setting_d = mysqli_fetch_assoc($result);
			mysqli_free_result($result);

			$query = "SELECT * FROM regist_set_tbl where code='".$code."' ";
			$result = mysqli_query($conn, $query);
			while(is_array($reg_set_d = mysqli_fetch_array($result))){
				$reg_set[$reg_set_d['sid']] = $reg_set_d;
			}
			mysqli_free_result($result);

			foreach( $chk_sid as $key => $val ){
		
				$query = "select * from regist_tbl where sid='".$val."' and code='".$e['code']."' and del='N'";
				$result = mysqli_query($conn, $query);
				$d = mysqli_fetch_assoc($result);
				mysqli_free_result($result);

				if($setting_d['reg_hp']) {
					$info_field = "info".$reg_set[$setting_d['reg_hp']]['info_orderby'];
					$receive_number = $d[$info_field];
				}

				$msg = str_replace("{reg_sid}", $d['sid'], $msg);

				if($setting_d['reg_name_en']) {
					$info_field = "info".$reg_set[$setting_d['reg_name_en']]['info_orderby'];
					$msg = str_replace("{reg_name_en}", str_replace("&&", " ", $d[$info_field]), $msg);
				}

				if($setting_d['reg_office']) {
					$info_field = "info".$reg_set[$setting_d['reg_office']]['info_orderby'];
					$msg = str_replace("{reg_office}", $d[$info_field], $msg);
				}

				if($setting_d['reg_license']) {
					$info_field = "info".$reg_set[$setting_d['reg_license']]['info_orderby'];
					$msg = str_replace("{reg_license}", $d[$info_field], $msg);
				}
		?>
			
				<tr>
					<td><?=$receive_number?></td>
					<td style="text-align:left;"><?=nl2br($msg)?></td>
				</tr>

	<?
		}
	?>
		</table>
	</div>

</div>