<?
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/admin/php/regist/print/print_header.php";


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>

    <title></title>
    <link rel="stylesheet" href="/include/style.css" type="text/css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="/print/font/NanumBarunGothic.css" />
<link type="text/css" rel="stylesheet" href="http://ezv.kr/registration_site/script/print_style.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script type="text/javascript" src="/admin/script/jquery-barcode.js"></script>
<script type="text/javascript" src="/admin/script/jquery-barcode.min.js"></script>

 
</head>

<body topmargin="0" leftmargin="0"  style="background-repeat:no-repeat;">

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


	while(is_array($d = mysqli_fetch_array($result))){


		$name = $d['info1']; //iconv("UTF-8", "EUC-KR", $d['info1']);
		$office = $d['info6'];//iconv("UTF-8", "EUC-KR", $d['info2']);
		
		
		/*
		$price_query="SELECT info FROM regist_type_sub_tbl where sid='".$d['info12']."'";
		$price_result = mysqli_query($conn, $price_query);
		$price_d = mysqli_fetch_array($price_result);

		$price = $price_d['info'];
		*/
		$price = $d['info12'];


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
			if(is_hangul_char($d['info6'])){
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

		$name_size = $name_size - 10;
		$b_wid = "480";
		$btx = "color:#000000;font-weight:bold;";
		$bfs = "font-size:14px;";
		
?>





<div style="position:absolute;top:<?=$ppp*100?>%" width="100%" height="100%">
	<div style="position:absolute;left:0px;top:125px;width:380px;height:250px;">

		<div style="font-size:18px;color:#000000; NanumBarunGothic;font-weight:bold;text-align:center;letter-spacing:0px; ">제6회 성공적인 개원 및 경영지원 세미나
		</div> 

		<div style="font-size:<?=$name_size?>px;color:#000000; NanumBarunGothic;font-weight:bold;text-align:center;padding-top:32px;letter-spacing:17px; "><?=$name?>
		</div> 
		<div style="font-size:<?=$office_size?>px;position:relative;font-weight:bold;NanumBarunGothic;padding-top:40px;color:#000000;text-align:center;"><?=$office?>
		</div> 
		<div id="barcode1" style="margin-top:30px;width: 100px;height: 100px;background: #FFFFFF;"></div>
		 
	</div>
		
	<!-- <div style="position:absolute;left:0px;top:485px;height:250px;">
		<div style="position:relative;color:#000000;top:27px;left:82px;font-weight:bold;NanumBarunGothic;font-size:12px;width:100px;">2019-10-18</div>
		<div style="position:relative;color:#000000;top:36px;left:57px;font-weight:bold;NanumBarunGothic;font-size:12px;"><?=$name?></div>
		<div style="position:relative;color:#000000;top:44px;left:107px;font-weight:bold;NanumBarunGothic;font-size:12px;"><?=$price?></div>
	</div>
	
	<div style="position:absolute;left:410px;top:485px;height:250px;">
		<div style="position:relative;color:#000000;top:27px;left:82px;font-weight:bold;NanumBarunGothic;font-size:12px;width:100px;">2019-10-18</div>
		<div style="position:relative;color:#000000;top:36px;left:57px;font-weight:bold;NanumBarunGothic;font-size:12px;"><?=$name?></div>
		<div style="position:relative;color:#000000;top:44px;left:107px;font-weight:bold;NanumBarunGothic;font-size:12px;"><?=$price?></div>
	</div> -->


</div>
<script>
//<![CDATA[
jQuery(function($) {
	$(".barcode1").barcode("<?=$d['sid']?>A", "code128",{barWidth:100, barHeight:30});
});
//]]>
</script>

<?$ppp++;}?>
</body>
