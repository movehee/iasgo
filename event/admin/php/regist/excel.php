<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$query="SELECT * FROM regist_tbl where code='".$code."' and del='N'";
$result = mysqli_query($conn, $query);

$reg_set_query="SELECT * FROM regist_set_tbl where code='".$code."' and del='N'";
$reg_set_query.=" order by orderby asc";
$reg_set_result = mysqli_query($conn, $reg_set_query);

$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");

/*
$result_ss_chk = mysqli_query($conn, "SELECT score_settingYN FROM event_tbl where code='".$code."' ");
$result_ss_chk_row = mysqli_fetch_array($result_ss_chk);
$score_setting_yn = $result_ss_chk_row['score_settingYN'];
*/

$score_set_arr = array();
$score_set_result = mysqli_query($conn, "SELECT agenda_sid FROM score_set_tbl where del='N' and code='".$code."' group by agenda_sid");
while(is_array($score_set_col = mysqli_fetch_assoc($score_set_result))){
	$score_set_arr[] = $score_set_col['agenda_sid'];
}


if($excel_type!='view') {
header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=".$code."_registList.xls"); 
header( "Content-Description: PHP4 Generated Data" ); 
}

$break_array = array();
?>
<style>
table{ width:100%; font-size: 14px; border-collapse: collapse;}
table tr th,
table tr td{padding: 5px 10px;text-align:center;}
table tr th{background-color: #ececec; padding: 15px 10px;}
</style>

<table class="tblList" border='1'>
	<thead>
		<tr>
		<?while(is_array($reg_set_d = mysqli_fetch_array($reg_set_result))){?>

				<?if($reg_set_d['type']>1000){
					$reg_type_set_query = "SELECT * FROM regist_type_sub_tbl where type_sid in (".$reg_set_d['type'].")";
					//echo $reg_type_set_query;
					$reg_type_set_result = mysqli_query($conn, $reg_type_set_query);
					while(is_array($reg_type_set_d = mysqli_fetch_array($reg_type_set_result))){
						$type[$reg_set_d['type']][$reg_type_set_d['sid']] = $reg_type_set_d['info'];
					}


				}?>

			<th style="min-width:100px;max-width:500px"><?=$reg_set_d['info']?></th>
		<?}mysqli_data_seek($reg_set_result,0);?>
		<?
		while(is_array($tab_col = mysqli_fetch_array($tab_result))){
			
			for($i=1;$i<6;$i++){
				if($tab_col['break_time'.$i]){
					$temp = split("-",$tab_col['break_time'.$i]);

					$temp1 = split(":",$temp[0]);
					$temp2 = split(":",$temp[1]);

					$break_array[$tab_col['sid']][$i] = array($tab_col['eventdate'] + $temp1[0] * 60 * 60 +  $temp1[1] * 60,$tab_col['eventdate'] + $temp2[0] * 60 * 60 +  $temp2[1] * 60);
				}
			}
		?>
			<th><?=$tab_col['name']?> 입실</th>
			<th><?=$tab_col['name']?> 퇴실</th>
			<th><?=$tab_col['name']?> 전체 체류시간</th>
			<th><?=$tab_col['name']?> 계산 시간</th>
			<th><?=$tab_col['name']?> 평점</th>
		<?}
		mysqli_data_seek($tab_result,0); 
		?>

			<th>메모</th>
		</tr>
	</thead>
	<tbody>
	<?while(is_array($d = mysqli_fetch_array($result))){?>
		<tr class="bg" id="<?=$d['sid']?>">

		
			<?while(is_array($reg_set_d = mysqli_fetch_array($reg_set_result))){?>
				<?if($reg_set_d['type']>1000){?>
					<td style="min-width:10%;max-width:40%">
					<?
					$temp = split(",",$d['info'.$reg_set_d['info_orderby']]);
					for($kk=0;$kk<count($temp);$kk++){
						if($kk>0){
							echo ", ";
						}
						$temp_arr = explode("&&", $temp[$kk]);
						if($temp_arr[1]) {
							echo $temp_arr[1];
						}
						else {
							echo $type[$reg_set_d['type']][$temp_arr[0]];
						}
					}
					?>
					
					
					</td>
				<?}else if($reg_set_d['type']==90){
					$country_result = mysqli_query($conn, "select * from country_tbl where sid=".$d['info'.$reg_set_d['info_orderby']]);
					$country_d = "";
					if($country_result) {
						$country_d = mysqli_fetch_array($country_result);
					}
				
				?>
					<td style="min-width:10%;max-width:40%"><?=$country_d['name']?></td>
				<?}else if($reg_set_d['type']==120){?>
					<td><?=str_replace("&&"," ",$d['info'.$reg_set_d['info_orderby']])?></td>
				
				<?}else{?>
					<td <?if($reg_set_d['type']==100){?>class="tdMemo"<?}?> style="min-width:10%;max-width:40%"><?=$d['info'.$reg_set_d['info_orderby']]?></td>
				<?}?>
			<?}mysqli_data_seek($reg_set_result,0);?>

			<?
			while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
				<td><?if($d['check_in'.$tab_col['day']]){?><?=date("H:i",$d['check_in'.$tab_col['day']])?><?}?></td>
				<td><?if($d['check_out'.$tab_col['day']]){?><?=date("H:i",$d['check_out'.$tab_col['day']])?><?}?></td>
				
				
				
				
				<?if($d['check_out'.$tab_col['day']] && $d['check_in'.$tab_col['day']]){?>
				
				<td>
					<?
					$someTime = $d['check_out'.$tab_col['day']] - $d['check_in'.$tab_col['day']];
					?>
					<?=gmdate("H:i", $someTime)?>
				</td>

				<td>
					<?

						if($tab_col['start_time']){
							$temp = split(":",$tab_col['start_time']);
							$start_time = $tab_col['eventdate'] + $temp[0] * 60 * 60 +  $temp[1] * 60;
						}

						if($tab_col['end_time']){
							$temp = split(":",$tab_col['end_time']);
							$end_time = $tab_col['eventdate'] + $temp[0] * 60 * 60 +  $temp[1] * 60;
						}

						if (  $d['check_in'.$tab_col['day']] <  $start_time ) {
							$d['check_in'.$tab_col['day']] = $start_time;
						}
						
						//나간시간이 등록된 시간보다 크면 등록된 시간으로 변경 -190703 YC
						if ( $d['check_out'.$tab_col['day']]  > $end_time  ) {
							$d['check_out'.$tab_col['day']] = $end_time;
						}

						$someTime = $d['check_out'.$tab_col['day']] - $d['check_in'.$tab_col['day']];

						if($break_array[$tab_col['sid']]){
							foreach($break_array[$tab_col['sid']] as $key=>$val){
								if($d['check_in'.$tab_col['day']] < $val[0])
								{
									if($d['check_out'.$tab_col['day']] > $val[1]) {
										$someTime += $val[0]-$val[1];
									} else if($d['check_out'.$tab_col['day']] < $val[0]) {

									} else {
										$someTime += $val[0]-$d['check_out'.$tab_col['day']];
									}
								}else if($d['check_in'.$tab_col['day']] < $val[1]) {
									if($d['check_out'.$tab_col['day']] > $val[1]) {
										$someTime += $d['check_in'.$tab_col['day']]-$val[1];
									} else if($d['check_out'.$tab_col['day']] < $val[0]) {

									} else {
										$someTime += $d['check_in'.$tab_col['day']]-$d['check_out'.$tab_col['day']];
									}
								}
							}
						}
					?>
					<?if($someTime < 0){?>
					00:00
					<?}else{?>
					<?=gmdate("H:i", $someTime)?>
					<?}?>
				</td>

				<?

				$aReturnValue['d'] = floor($someTime/60/60/24); //일
				$aReturnValue['H'] = sprintf("%02d", ($someTime/60/60)%24); //시간
				$aReturnValue['i'] = sprintf("%02d", ($someTime/60)%60); //분
				$aReturnValue['s'] = sprintf("%02d", ($someTime%60)); //초

				$score2 = 0;
				if($tab_col['score']){

					if(in_array($tab_col['sid'], $score_set_arr)) {
						$time_n = 60*60;
						
						$score_set_result = mysqli_query($conn, "select * from score_set_tbl where code='".$code."' and agenda_sid='$tab_col[sid]' and del='N' order by time asc");
						while(is_array($ss_col = mysqli_fetch_array($score_set_result))){
							if($ss_col['ine']=='1') {
								if($someTime >= $time_n*$ss_col['time']) {
									$score2 = $ss_col['score'];
								}

							}
							else if($ss_col['ine']=='2') {
								if($someTime > $time_n*$ss_col['time']) {
									$score2 = $ss_col['score'];
								}
							}
						}

						mysqli_data_seek($score_set_result,0);	
										
					}
					else { //기존방식
						if($aReturnValue['H']>=5)
							$score2 = 6;
						else if($aReturnValue['H']>=4)
							$score2 = 5;
						else if($aReturnValue['H']>=3)
							$score2 = 4;
						else if($aReturnValue['H']>=2)
							$score2 = 3;
						if($tab_col['score']<$score2){
							$score2 = $tab_col['score'];
						}
					}
					
				}?>
				

				<td>
					<?=$score2?>
				</td>
				

				<?}else{?>
				
				<td></td>
				<td></td>
				<td></td>
				<?}?>

			<?}
			mysqli_data_seek($tab_result,0); 
			?>
				<td><?=$d['memo']?></td>
		</tr>
	<?
			}?>
		
	</tbody>
</table>
   

<?include "./../footer.php";?>