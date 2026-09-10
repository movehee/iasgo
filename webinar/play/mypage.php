<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	$query1 = "select * from checkin_tbl where day='1' and usid='".$_COOKIE['wmember_sid']."'";
	$result1 = $conn->query($query1);
	$result1->fetchInto(&$d1,DB_FETCHMODE_ASSOC);
	$result1->free();

	$d1_mm1=0;
	$d1_mm2=0;
	$d1_mm3=0;
	$d1_mm4=0;
	
	
	$s1_sdate = "";
	$s1_edate = "";
	$s2_sdate = "";
	$s2_edate = "";
	$s3_sdate = "";
	$s3_edate = "";
	$s4_sdate = "";
	$s4_edate = "";

	$s1_sdate = $d1['s1_sdate'];
	$s1_edate = $d1['s1_edate'];
	if($d1['s1_sdate']){
		if(strtotime($_TIME['session'][1]['1'][0])>$d1['s1_sdate']){
			$s1_sdate = strtotime($_TIME['session'][1]['1'][0]);
		}
	}
	if($d1['s1_edate']){
		if(strtotime($_TIME['session'][1]['1'][1])<$d1['s1_edate']){
			$s1_edate = strtotime($_TIME['session'][1]['1'][1]);
		}
	}
	if($s1_sdate){
		$d1_s1_time = $s1_edate-$s1_sdate;
		$d1_mm1 = ($d1_s1_time/60);
	}
	
	$s2_sdate = $d1['s2_sdate'];
	$s2_edate = $d1['s2_edate'];
	if(strtotime($_TIME['session']['1']['2'][0])>$d1['s2_sdate']){
		$s2_sdate = strtotime($_TIME['session']['1']['2'][0]);
	}
	if(strtotime($_TIME['session']['1']['2'][1])<$d1['s2_edate']){
		$s2_edate = strtotime($_TIME['session']['1']['2'][1]);
	}
	
	if($s2_edate){
		$d1_s2_time = $s2_edate-$s2_sdate;
		$d1_mm2 = ($d1_s2_time/60);
	}
	$s3_sdate = $d1['s3_sdate'];
	$s3_edate = $d1['s3_edate'];
	if(strtotime($_TIME['session']['1']['3'][0])>$s3_sdate){
		$s3_sdate = strtotime($_TIME['session']['1']['3'][0]);
	}
	if(strtotime($_TIME['session']['1']['3'][1])<$s3_edate){
		$s3_edate = strtotime($_TIME['session']['1']['3'][1]);
	}
	if($s3_edate){
		$d1_s3_time = $s3_edate-$s3_sdate;
		$d1_mm3 = ($d1_s3_time/60);
	}
	
	$s4_sdate = $d1['s4_sdate'];
	$s4_edate = $d1['s4_edate'];
	if(strtotime($_TIME['session']['1']['4'][0])>$s4_sdate){
		$s4_sdate = strtotime($_TIME['session']['1']['4'][0]);
	}
	if(strtotime($_TIME['session']['1']['4'][1])<$s4_edate){
		$s4_edate = strtotime($_TIME['session']['1']['4'][1]);
	}
	if($s4_edate){
		$d1_s4_time = $s4_edate-$s4_sdate;
		$d1_mm4 = ($d1_s4_time/60);
	}
	

	unset($stay_hours);
	unset($stay_min);
	unset($score);
	unset($sum_score);

	$d1_sum_score = floor($d1_mm1+$d1_mm2+$d1_mm3+$d1_mm4);

	if($d1_sum_score>0){
		if($d1_sum_score>60){
			$d1_stay_hours = sprintf("%02d", floor($d1_sum_score/60));
			$d1_stay_min = sprintf("%02d", floor($d1_sum_score%60));
		}
		$d1_score = floor($d1_stay_hours);
		if($d1_score>6){
			$d1_score = 6;
		}
	}

	//////////////////////////////////////////////////////


	$query2 = "select * from checkin_tbl where day='2' and usid='".$_COOKIE['wmember_sid']."'";
	$result2 = $conn->query($query2);
	$result2->fetchInto(&$d2,DB_FETCHMODE_ASSOC);
	$result2->free();

	$d2_mm1=0;
	$d2_mm2=0;
	$d2_mm3=0;
	$d2_mm4=0;
	
	$s1_sdate = "";
	$s1_edate = "";
	$s2_sdate = "";
	$s2_edate = "";
	$s3_sdate = "";
	$s3_edate = "";
	$s4_sdate = "";
	$s4_edate = "";


	$s1_sdate = $d2['s1_sdate'];
	$s1_edate = $d2['s1_edate'];

	if(strtotime($_TIME['session']['2']['1'][0])>$s1_sdate){
		$s1_sdate = strtotime($_TIME['session']['2']['1'][0]);
	}
	if(strtotime($_TIME['session']['2']['1'][1])<$s1_edate){
		$s1_edate = strtotime($_TIME['session']['2']['1'][1]);
	}

	if($s1_edate){
		$d2_s1_time = $s1_edate-$s1_sdate;
		$d2_mm1 = ($d2_s1_time/60);
	}

	$s2_sdate = $d2['s2_sdate'];
	$s2_edate = $d2['s2_edate'];
	if(strtotime($_TIME['session']['2']['2'][0])>$s2_sdate){
		$s2_sdate = strtotime($_TIME['session']['2']['2'][0]);
	}
	if(strtotime($_TIME['session']['2']['2'][1])<$s2_edate){
		$s2_edate = strtotime($_TIME['session']['2']['2'][1]);
	}
	if($s2_edate){
		$d2_s2_time = $s2_edate-$s2_sdate;
		$d2_mm2 = ($d2_s2_time/60);
	}

	$s3_sdate = $d2['s3_sdate'];
	$s3_edate = $d2['s3_edate'];
	if(strtotime($_TIME['session']['2']['3'][0])>$s3_sdate){
		$s3_sdate = strtotime($_TIME['session']['2']['3'][0]);
	}
	if(strtotime($_TIME['session']['2']['3'][1])<$s3_edate){
		$s3_edate = strtotime($_TIME['session']['2']['3'][1]);
	}

	if($s3_edate){
		$d2_s3_time = $s3_edate-$s3_sdate;
		$d2_mm3 = ($d2_s3_time/60);
	}

	$s4_sdate = $d2['s4_sdate'];
	$s4_edate = $d2['s4_edate'];
	if(strtotime($_TIME['session']['2']['4'][0])>$s4_sdate){
		$s4_sdate = strtotime($_TIME['session']['2']['4'][0]);
	}
	if(strtotime($_TIME['session']['2']['4'][1])<$s4_edate){
		$s4_edate = strtotime($_TIME['session']['2']['4'][1]);
	}
	if($s4_edate){
		$d2_s4_time = $s4_edate-$s4_sdate;
		$d2_mm4 = ($d2_s4_time/60);
	}

	unset($stay_hours);
	unset($stay_min);
	unset($score);
	unset($sum_score);

	$d2_sum_score = floor($d2_mm1+$d2_mm2+$d2_mm3+$d2_mm4);

	if($d2_sum_score>0){
		if($d2_sum_score>60){
			$d2_stay_hours = sprintf("%02d", floor($d2_sum_score/60));
			$d2_stay_min = sprintf("%02d", floor($d2_sum_score%60));
		}
		$d2_score = floor($d2_stay_hours);
		if($d2_score>6){
			$d2_score = 6;
		}
	}




	//////////////////////////////////////////////////////


	$query3 = "select * from checkin_tbl where day='3' and usid='".$_COOKIE['wmember_sid']."'";
	$result3 = $conn->query($query3);
	$result3->fetchInto(&$d3,DB_FETCHMODE_ASSOC);
	$result3->free();

	$d3_mm1=0;
	$d3_mm2=0;
	$d3_mm3=0;
	$d3_mm4=0;

	$s1_sdate = "";
	$s1_edate = "";
	$s2_sdate = "";
	$s2_edate = "";
	$s3_sdate = "";
	$s3_edate = "";
	$s4_sdate = "";
	$s4_edate = "";

	$s1_sdate = $d3['s1_sdate'];
	$s1_edate = $d3['s1_edate'];

	if(strtotime($_TIME['session']['3']['1'][0])>$s1_sdate){
		$s1_sdate = strtotime($_TIME['session']['3']['1'][0]);
	}
	if(strtotime($_TIME['session']['3']['1'][1])<$s1_edate){
		$s1_edate = strtotime($_TIME['session']['3']['1'][1]);
	}
	if($s1_edate){
		$d3_s1_time = $s1_edate-$s1_sdate;
		$d3_mm1 = ($d3_s1_time/60);
	}

	$s2_sdate = $d3['s2_sdate'];
	$s2_edate = $d3['s2_edate'];
	if(strtotime($_TIME['session']['3']['2'][0])>$s2_sdate){
		$s2_sdate = strtotime($_TIME['session']['3']['2'][0]);
	}
	if(strtotime($_TIME['session']['3']['2'][1])<$s2_edate){
		$s2_edate = strtotime($_TIME['session']['3']['2'][1]);
	}
	if($s2_edate){
		$d3_s2_time = $s2_edate-$s2_sdate;
		$d3_mm2 = ($d3_s2_time/60);
	}

	$s3_sdate = $d3['s3_sdate'];
	$s3_edate = $d3['s3_edate'];
	if(strtotime($_TIME['session']['3']['3'][0])>$s3_sdate){
		$s3_sdate = strtotime($_TIME['session']['3']['3'][0]);
	}
	if(strtotime($_TIME['session']['3']['3'][1])<$s3_edate){
		$s3_edate = strtotime($_TIME['session']['3']['3'][1]);
	}
	if($s3_edate){
		$d3_s3_time = $s3_edate-$s3_sdate;
		$d3_mm3 = ($d3_s3_time/60);
	}

	$s4_sdate = $d3['s4_sdate'];
	$s4_edate = $d3['s4_edate'];
	if(strtotime($_TIME['session']['3']['4'][0])>$s4_sdate){
		$s4_sdate = strtotime($_TIME['session']['3']['4'][0]);
	}
	if(strtotime($_TIME['session']['3']['4'][1])<$s4_edate){
		$s4_edate = strtotime($_TIME['session']['3']['4'][1]);
	}
	if($s4_edate){
		$d3_s4_time = $s4_edate-$s4_sdate;
		$d3_mm4 = ($d3_s4_time/60);
	}

	unset($stay_hours);
	unset($stay_min);
	unset($score);
	unset($sum_score);

	$d3_sum_score = floor($d3_mm1+$d3_mm2+$d3_mm3+$d3_mm4);

	if($d3_sum_score>0){
		if($d3_sum_score>60){
			$d3_stay_hours = sprintf("%02d", floor($d3_sum_score/60));
			$d3_stay_min = sprintf("%02d", floor($d3_sum_score%60));
		}
		$d3_score = floor($d3_stay_hours);
		if($d3_score>6){
			$d3_score = 6;
		}
	}

	
?>
<div class="popupCon">
	<dl class="eduTime" style="padding:10px 0px 0 10px !important;">
		<table cellpadding=0 cellspacing=0 width="100%" style="border-top:2px solid #D4482D;">
			<tr>
				<td colspan=3 style="background:#FBEBEB;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;height:30px;width:33.3%">9.17</td>
				<td colspan=3 style="background:#FBEBEB;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;width:33.3%">9.18</td>
				<td colspan=3 style="background:#FBEBEB;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;width:33.3%">9.19</td>
			</tr>
			<tr>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;height:30px;">시간</td>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;width:50px;">입장</td>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;width:50px;">퇴장</td>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">시간</td>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;width:50px;">입장</td>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;width:50px;">퇴장</td>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">시간</td>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;width:50px;">입장</td>
				<td style="background:#F7F7F7;text-align:center;font-weight:bold;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;width:50px;">퇴장</td>
			</tr>
			<tr>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;height:30px;">
					Session 1 (<?=substr($_TIME['session']['1'][1][0],11,5)."~".substr($_TIME['session']['1'][1][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					<?if($d1['s1_sdate']>0){?><?=date("H:i",$d1['s1_sdate'])?><?}?>
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					<?if($d1['s1_edate']>0){?><?=date("H:i",$d1['s1_edate'])?><?}?>
				</td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					Session 1 (<?=substr($_TIME['session']['2'][1][0],11,5)."~".substr($_TIME['session']['2'][1][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d2['s1_sdate']>0){?><?=date("H:i",$d2['s1_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d2['s1_edate']>0){?><?=date("H:i",$d2['s1_edate'])?><?}?></td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					Session 1 (<?=substr($_TIME['session']['3'][1][0],11,5)."~".substr($_TIME['session']['3'][1][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d3['s1_sdate']>0){?><?=date("H:i",$d3['s1_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d3['s1_edate']>0){?><?=date("H:i",$d3['s1_edate'])?><?}?></td>
			</tr>
			<tr>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;height:30px;">
					Session 2 (<?=substr($_TIME['session']['1'][2][0],11,5)."~".substr($_TIME['session']['1'][2][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d1['s2_sdate']>0){?><?=date("H:i",$d1['s2_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d1['s2_edate']>0){?><?=date("H:i",$d1['s2_edate'])?><?}?></td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					Session 2 (<?=substr($_TIME['session']['2'][2][0],11,5)."~".substr($_TIME['session']['2'][2][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d2['s2_sdate']>0){?><?=date("H:i",$d2['s2_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d2['s2_edate']>0){?><?=date("H:i",$d2['s2_edate'])?><?}?></td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					Session 2 (<?=substr($_TIME['session']['3'][2][0],11,5)."~".substr($_TIME['session']['3'][2][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d3['s2_sdate']>0){?><?=date("H:i",$d3['s2_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d3['s2_edate']>0){?><?=date("H:i",$d3['s2_edate'])?><?}?></td>
			</tr>
			<tr>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;height:30px;">
					Session 3 (<?=substr($_TIME['session']['1'][3][0],11,5)."~".substr($_TIME['session']['1'][3][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d1['s3_sdate']>0){?><?=date("H:i",$d1['s3_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d1['s3_edate']>0){?><?=date("H:i",$d1['s3_edate'])?><?}?></td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					Session 3 (<?=substr($_TIME['session']['2'][3][0],11,5)."~".substr($_TIME['session']['2'][3][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d2['s3_sdate']>0){?><?=date("H:i",$d2['s3_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d2['s3_edate']>0){?><?=date("H:i",$d2['s3_edate'])?><?}?></td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					Session 3 (<?=substr($_TIME['session']['3'][3][0],11,5)."~".substr($_TIME['session']['3'][3][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d3['s3_sdate']>0){?><?=date("H:i",$d3['s3_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d3['s3_edate']>0){?><?=date("H:i",$d3['s3_edate'])?><?}?></td>
			</tr>
			<tr>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;height:30px;">
					Session 4 (<?=substr($_TIME['session']['1'][4][0],11,5)."~".substr($_TIME['session']['1'][4][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d1['s4_sdate']>0){?><?=date("H:i",$d1['s4_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d1['s4_edate']>0){?><?=date("H:i",$d1['s4_edate'])?><?}?></td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					Session 4 (<?=substr($_TIME['session']['2'][4][0],11,5)."~".substr($_TIME['session']['2'][4][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d2['s4_sdate']>0){?><?=date("H:i",$d2['s4_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d2['s4_edate']>0){?><?=date("H:i",$d2['s4_edate'])?><?}?></td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">
					Session 4 (<?=substr($_TIME['session']['3'][4][0],11,5)."~".substr($_TIME['session']['3'][4][1],11,5)?>)
				</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d3['s4_sdate']>0){?><?=date("H:i",$d3['s4_sdate'])?><?}?></td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;"><?if($d3['s4_edate']>0){?><?=date("H:i",$d3['s4_edate'])?><?}?></td>
			</tr>
			<tr>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;height:30px;">체류시간 / 평점</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;" colspan=2><?=$d1_stay_hours.":".$d1_stay_min?> / <?=$d1_score?>점</td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">체류시간 / 평점</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;" colspan=2><?=$d2_stay_hours.":".$d2_stay_min?> / <?=$d2_score?>점</td>
				<td style="background:#F8FAFF;text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;">체류시간 / 평점</td>
				<td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;" colspan=2>
					<?
						echo $d3_stay_hours.":".$d3_stay_min." / ";
						echo "<span style='color:blue;'>".$d3_score."점(<span style='color:red;'>필수:".number_format($d3['nec_score'])."점</span>)</span>";
					?>
				</td>
				<!-- <td style="text-align:center;border-bottom:1px solid #D4D1D1;border-left:1px solid #D4D1D1;" colspan=2><?=$d3['nec_score']?></td> -->
			</tr>
		</table>
	</dl>
	<div style="padding-left:20px;padding-bottom:5px;color:red;">* 위 평점은 온라인 세션 수강 시간 기준으로만 계산되며, 연사, 좌장, 발표자 등 현장 참석하신 분들의 현장 취득 평점은 메일로 안내드릴 예정입니다.</div>
	
	
	<div class="note" >
		<dl style="padding-left:20px;width:900px;padding-top:5px;height:250px;">
			<div style="width:350px;position:absolute;">
				<dt>취득 가능 평점</dt>
				<dd>
					1일 6평점, 3일 총 18평점 <br>
					(필수 평점교육을 수강하실 경우 필수 평점최대 2평점, <br>일반 평점 최대 4평점 취득 가능)
				</dd>

				<dt style="padding-top:10px;">출석 체크 방식</dt>
				<dd>
					<ul class="listBar">
						<li>각 세션별 입실 및 퇴실 버튼 클릭</li>
						<li>세션 시작 전에 입장 시에도 <strong class="fcPoint">세션 시간 기준</strong>으로만<br> 평점 이수 반영</li>
					</ul>
				</dd>
			</div>
			<div style="width:500px;position:absolute;left:430px;padding-top:0px;">
				<dt><b>*필수평점교육 안내*</b></dt>
				<dd style="font-size:14px;">
					<div>필수평점 교육 시간: 9월 19일(토) 14:30-16:30 (2시간)</div>
					<div style="padding-top:5px;">
					1. 세션 별 입/퇴장 버튼 반드시 클릭하시기 바랍니다.<br />
					2. 필수평점은 1시간 기준 1평점, 최대 2평점 이수 가능<br />
					&nbsp;&nbsp;&nbsp; <b>※ 필수평점교육 수강 시</b><br />
					&nbsp;&nbsp;&nbsp; - 일반평점 최대 4평점 + 필수평점 최대 2평점 =1일 최대 6평점 이수 가능<br />

					&nbsp;&nbsp;&nbsp; <b>※ 필수평점교육 비수강 시</b><br />
					&nbsp;&nbsp;&nbsp; - 1일 최대 일반평점 6평점 이수 가능<br />
					3. 필수평점교육을 수강한 시간은 대회 종료 후 확인 가능하오니 참고 부탁드립니다.<br />
					<b style="color:red;">※관련 문의사항이 있으실 경우,  사무국(<a href="mailto:ask@kcr4u.org">ask@kcr4u.org</a>)으로 연락 주시기 바라며, <br /><span style="padding-left:15px;">순차적으로 조속히 답변 드리도록 하겠습니다.</b>
					</div>
				</dd>
			</div>
		</dl>


		<dl>
			<dt>평점 지급기준</dt>
			<dd>
				1시간 이상 ~ 2시간 미만  →  1평점<br>
				2시간 이상 ~ 3시간 미만  →  2평점<br>
				3시간 이상 ~ 4시간 미만  →  3평점<br>
				4시간 이상 ~ 5시간 미만  →  4평점<br>
				5시간 이상 ~ 6시간 미만  →  5평점<br>
				6시간 이상  →  6평점 
			</dd>
		</dl>
	</div>
	
</div>	

