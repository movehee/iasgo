<?	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";


	if($excel_type != "view") {
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename='".$_COOKIE['code']."_voting.xls'"); 
	header( "Content-Description: PHP4 Generated Data" ); 
	}
	
	//$query = "select * from voting_tbl where code='".$code."' and status='2' and del='N'";
	$query = "select * from voting_tbl where code='".$code."' and del='N'";
	
	if ( empty($lecture) == false ) {
		$query .= " and lecture = $lecture";
	}


	$result = mysqli_query($conn, $query);
	

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<table border="1"   border="1" style="text-align:center;border-collapse:collapse;">
	<tr>
		<td style="font-size: 14px;text-align:center;background-color:#a5d7ff;width:18%;  padding: 10px 5px;">Question</td>
        <td style="font-size: 14px;text-align:center;background-color:#dcdcdc;width:13%; padding: 10px 5px;">Answer1</td>
        <td style="font-size: 14px;text-align:center;background-color:#dcdcdc;width:13%; padding: 10px 5px;">Answer2</td>
		<td style="font-size: 14px;text-align:center;background-color:#dcdcdc;width:13%; padding: 10px 5px;">Answer3</td>
		<td style="font-size: 14px;text-align:center;background-color:#dcdcdc;width:13%; padding: 10px 5px;">Answer4</td>
		<td style="font-size: 14px;text-align:center;background-color:#dcdcdc;width:13%; padding: 10px 5px;">Answer5</td>
		<td style="font-size: 14px;text-align:center;background-color:#dcdcdc;width:13%; padding: 10px 5px;">Answer6</td>
		<td style="font-size: 14px;text-align:center;background-color:#fbdcff;width:6%; padding: 10px 5px;">SUM</td>
	</tr>
	<?

		while(is_array($col = mysqli_fetch_array($result))){
		$query="select (select count(*) from voting_result_tbl where val='1' and voting_sid=".$col['sid'].") val1, (select count(*) from voting_result_tbl where val='2' and voting_sid=".$col['sid'].") val2, (select count(*) from voting_result_tbl where val='3' and voting_sid=".$col['sid'].") val3, (select count(*) from voting_result_tbl where val='4' and voting_sid=".$col['sid'].") val4, (select count(*) from voting_result_tbl where val='5' and voting_sid=".$col['sid'].") val5, (select count(*) from voting_result_tbl where val='6' and voting_sid=".$col['sid'].") val6, (select count(*) from voting_result_tbl where voting_sid=".$col['sid'].") val;";



		$rresult = mysqli_query($conn, $query);
		$r = mysqli_fetch_array($rresult);				

	?>


	
		<tr style="text-align:center;">
			<td rowspan="2" style="text-align:center;"><?=$col['question']?><?if($col['image']){?><br><img src="http://ezv.kr/upload/<?=$col['image']?>" style="width:130px"><?}?>
			<?if($_SERVER['REMOTE_ADDR']=='218.235.94.225'){echo "<br><br>".$col['sid'];}?>
			</td>
			<td style="text-align:center;"><?=$col['answer1']?><?if($col['answer1_img']){?><br><img src="http://ezv.kr/upload/<?=$col['answer1_img']?>" style="width:130px"><?}?></td>
			<td style="text-align:center;"><?=$col['answer2']?><?if($col['answer2_img']){?><br><img src="http://ezv.kr/upload/<?=$col['answer2_img']?>" style="width:130px"><?}?></td>
			<td style="text-align:center;"><?=$col['answer3']?><?if($col['answer3_img']){?><br><img src="http://ezv.kr/upload/<?=$col['answer3_img']?>" style="width:130px"><?}?></td>
			<td style="text-align:center;"><?=$col['answer4']?><?if($col['answer4_img']){?><br><img src="http://ezv.kr/upload/<?=$col['answer4_img']?>" style="width:130px"><?}?></td>
			<td style="text-align:center;"><?=$col['answer5']?><?if($col['answer5_img']){?><br><img src="http://ezv.kr/upload/<?=$col['answer5_img']?>" style="width:130px"><?}?></td>
			<td style="text-align:center;"><?=$col['answer6']?><?if($col['answer6_img']){?><br><img src="http://ezv.kr/upload/<?=$col['answer6_img']?>" style="width:130px"><?}?></td>
			<td rowspan="2" style="text-align:center;"><?=$r['val']?></td>
		</tr>

		<tr style="text-align:center;">
			<td style="text-align:center;"><?=$r['val1']?>
			<br>(<?=($col['answer1']&&$r['val1'])?number_format($r['val1']/$r['val']*100,2)."%":"0%";?>)
			</td>
			<td style="text-align:center;"><?=$r['val2']?>
			<br>(<?=($col['answer2']&&$r['val2'])?number_format($r['val2']/$r['val']*100,2)."%":"0%";?>)
			</td>
			<td style="text-align:center;"><?=$r['val3']?>
			<br>(<?=($col['answer3']&&$r['val3'])?number_format($r['val3']/$r['val']*100,2)."%":"0%";?>)
			</td>
			<td style="text-align:center;"><?=$r['val4']?>
			<br>(<?=($col['answer4']&&$r['val4'])?number_format($r['val4']/$r['val']*100,2)."%":"0%";?>)
			</td>
			<td style="text-align:center;"><?=$r['val5']?>
			<br>(<?=($col['answer5']&&$r['val5'])?number_format($r['val5']/$r['val']*100,2)."%":"0%";?>)
			</td>
			<td style="text-align:center;"><?=$r['val6']?>
			<br>(<?=($col['answer6']&&$r['val6'])?number_format($r['val6']/$r['val']*100,2)."%":"0%";?>)
			</td>
		</tr>


	<?
	}		
	?>
</table>
