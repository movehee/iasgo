<?
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/admin/php/regist/print/print_header.php";

Function getConvertNumberToKorean($_number)
{
	// 0부터 9까지의 한글 배열
	$number_arr = array('','일','이','삼','사','오','육','칠','팔','구');

	// 천자리 이하 자리 수의 한글 배열
	$unit_arr1 = array('','십','백','천');

	// 만자리 이상 자리 수의 한글 배열
	$unit_arr2 = array('','만','억','조','경','해');

	// 결과 배열 초기화
	$result = array();

	// 인자값을 역순으로 배열한 후, 4자리 기준으로 나눔
	$reverse_arr = str_split(strrev($_number), 4);

	foreach($reverse_arr as $reverse_idx=>$reverse_number){
		// 1자리씩 나눔
		$convert_arr = str_split($reverse_number);
		$convert_idx = 0;

		foreach($convert_arr as $split_idx=>$split_number){
			// 해당 숫자가 0일 경우 처리되지 않음
			if(!empty($number_arr[$split_number])){	
				// 0부터 9까지 한글 배열과 천자리 이하 자리 수의 한글 배열을 조합하여 글자 생성
				$result[$result_idx] = $number_arr[$split_number].$unit_arr1[$split_idx];

				// 반복문의 첫번째에서는 만자리 이상 자리 수의 한글 배열을 앞 전 배열에 연결하여 조합
				if(empty($convert_idx)) $result[$result_idx] .= $unit_arr2[$reverse_idx];	
				++$convert_idx;
			}

			++$result_idx;
		}
	}

	// 배열 역순으로 재정렬 후 합침
	$result = implode('', array_reverse($result));

	// 결과 리턴
	return $result;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>

    <title></title>
    <link rel="stylesheet" href="/include/style.css" type="text/css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="/print/font/NanumBarunGothic.css" />
<link type="text/css" rel="stylesheet" href="/registration_site/script/print_style.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script type="text/javascript" src="/admin/app/script/jquery-barcode.js"></script>
<script type="text/javascript" src="/admin/script/jquery-barcode.min.js"></script>

 
</head>

<body topmargin="0" leftmargin="0" onload="print()" style="background-repeat:no-repeat;">

<?

	$ppp=0;
	$query="SELECT * FROM regist_tbl where del='N'";

	if($code){
		$query .= " and code='".$code."'";
	}
	if($sid){
		$query .= " and sid in (".substr($sid , 0, -1).")";
	}

	$query .= " order by info1 asc";

	$result = mysqli_query($conn, $query);

	$update_query = "update regist_tbl set print_date='".time()."'";
	$update_query .= "where del='N'";
	if($code){
		$update_query .= " and code='".$code."'";
	}
	if($sid){
		$update_query .= " and sid in (".substr($sid , 0, -1).")";
	}
	mysqli_query($conn, $update_query);



	//echo $query;

	

	while(is_array($d = mysqli_fetch_array($result))){


		$name = $d['info1']; //iconv("UTF-8", "EUC-KR", $d['info1']);
		$office = $d['info2'];//iconv("UTF-8", "EUC-KR", $d['info2']);
		
		
		/*
		$price_query="SELECT info FROM regist_type_sub_tbl where sid='".$d['info12']."'";
		$price_result = mysqli_query($conn, $price_query);
		$price_d = mysqli_fetch_array($price_result);

		$price = $price_d['info'];
		*/
		$price = $d['info6'];


		$name_size = "30";
		$office_size = "30";
		
		
		if($name){

			if(is_hangul_char($d['info1'])){
				//한글일 경우
				$name_size = 100 / sqrt(mb_strlen($name,"utf-8"));
				/*if($name_size<50){
					$name_size = 170 / sqrt(mb_strlen($name,"utf-8"));
				}*/
			}else{
				//영어일 경우
				$name_size = 160 / sqrt(mb_strlen($name,"utf-8"));
				/*
				if($name_size<50){
					$name_size = 200 / sqrt(mb_strlen($name,"utf-8"));
				}*/
			}
		}

		if($office){
			if(is_hangul_char($d['info2'])){
				$office_size = 80 / sqrt(mb_strlen($office,"utf-8"));
				/*
				if($office_size<50){
					$office_size = 130 / sqrt(mb_strlen($office,"utf-8"));
				}*/
			}else{
				$office_size = 130 / sqrt(mb_strlen($office,"utf-8"));
				if($office_size<50){
					$office_size = 180 / sqrt(mb_strlen($office,"utf-8"));
				}
			}
			
		}

		//echo $name_size;

		$b_wid = "480";
		$btx = "color:#000000;font-weight:bold;";
		$bfs = "font-size:14px;";
		
?>

<script>
//<![CDATA[
jQuery(function($) {
	$(".barcode<?=$ppp?>").barcode("<?=$d['sid']?>A", "code93",{barWidth:1, barHeight:30});
});
//]]>
</script>

<div style="position:absolute;top:<?=$ppp*100?>%" width="100%" height="100%">
	<div style="position:absolute;left:0px;top:130px;width:380px;height:250px;">
		<div style="font-size:<?=$name_size?>px;color:#000000; NanumBarunGothic;font-weight:bold;text-align:center;letter-spacing:15px; margin-left:15px;"><?=$name?>
		</div> 
		<div style="font-size:<?=$office_size?>px;position:relative;font-weight:bold;NanumBarunGothic;top:20px;color:#000000;text-align:center;"><?=$office?>
		</div> 
		<div style="position:relative;top:35px;left:90px;width:200px;font-weight:bold;">
			<div style="margin: 0 auto;height:50px" class="barcode<?=$ppp?> tm10 ar"></div>
		</div> 
	</div>
		
	<div style="position:absolute;left:0px;top:485px;height:250px;">
		<div style="position:relative;color:#000000;top:27px;left:82px;font-weight:bold;NanumBarunGothic;font-size:12px;width:100px;">2019-10-18</div>
		<div style="position:relative;color:#000000;top:36px;left:57px;font-weight:bold;NanumBarunGothic;font-size:12px;"><?=$name?></div>
		<div style="position:relative;color:#000000;top:44px;left:107px;font-weight:bold;NanumBarunGothic;font-size:12px;"><?=$price?></div>
	</div>

	<div style="position:absolute;left:410px;top:485px;height:250px;">
		<div style="position:relative;color:#000000;top:27px;left:82px;font-weight:bold;NanumBarunGothic;font-size:12px;width:100px;">2019-10-18</div>
		<div style="position:relative;color:#000000;top:36px;left:57px;font-weight:bold;NanumBarunGothic;font-size:12px;"><?=$name?></div>
		<div style="position:relative;color:#000000;top:44px;left:107px;font-weight:bold;NanumBarunGothic;font-size:12px;"><?=$price?></div>
	</div>


</div>

<?$ppp++;}?>
</body>
