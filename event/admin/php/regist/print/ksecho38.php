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
<link type="text/css" rel="stylesheet" href="/registration_site/script/print_style.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script type="text/javascript" src="/admin/app/script/jquery-barcode.js"></script>
<script type="text/javascript" src="/admin/script/jquery-barcode.min.js"></script>

 
</head>

<body topmargin="0" leftmargin="0" onload="" style="background-repeat:no-repeat;">

<?

	$ppp=0;
	$query="SELECT * FROM regist_tbl where del='N'";

	if($code){
		$query .= " and code='".$code."'";
	}
	if($sid){
		$query .= " and sid in (".substr($sid , 0, -1).")";
	}

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
		
		

		$price_query="SELECT info FROM regist_type_sub_tbl where sid='".$d['info12']."'";
		$price_result = mysqli_query($conn, $price_query);
		$price_d = mysqli_fetch_array($price_result);

		$price = $price_d['info'];


		$name_size = "30";
		$office_size = "30";
		
		
		if($name){

			if(is_hangul_char($d['info1'])){
				//한글일 경우
				$name_size = 140 / sqrt(mb_strlen($name,"utf-8"));
				if($name_size<50){
					$name_size = 170 / sqrt(mb_strlen($name,"utf-8"));
				}
			}else{
				//영어일 경우
				$name_size = 160 / sqrt(mb_strlen($name,"utf-8"));
				if($name_size<50){
					$name_size = 200 / sqrt(mb_strlen($name,"utf-8"));
				}
			}
		}

		if($office){
			if(is_hangul_char($d['info2'])){
				$office_size = 110 / sqrt(mb_strlen($office,"utf-8"));
				if($office_size<50){
					$office_size = 130 / sqrt(mb_strlen($office,"utf-8"));
				}
			}else{
				$office_size = 130 / sqrt(mb_strlen($office,"utf-8"));
				if($office_size<50){
					$office_size = 180 / sqrt(mb_strlen($office,"utf-8"));
				}
			}
			
		}

		$b_wid = "480";
		$btx = "color:#000000;font-weight:bold;";
		$bfs = "font-size:14px;";
		
?>

<script>
//<![CDATA[
jQuery(function($) {
	$(".barcode<?=$ppp?>").barcode("<?=$d['sid']?>A", "code93",{barWidth:2, barHeight:50});
});
//]]>
</script>


<div style="position:absolute;top:<?=$ppp*100?>%" width="100%" height="100%">
	<div style="position:absolute;left:348px;top:270px;width:500px">
		<div style="font-size:<?=$name_size?>px;color:#000000; NanumBarunGothic;font-weight:bold;text-align:center;letter-spacing:15px; margin-left:15px;"><?=$name?>
		</div> 
		<div style="font-size:<?=$office_size?>px;position:relative;font-weight:bold;NanumBarunGothic;top:30px;color:#000000;text-align:center;"><?=$office?>
		</div> 
		<div style="position:relative;top:60px;left:150px;width:200px;font-weight:bold;">
			<div style="margin: 0 auto;height:100px" class="barcode<?=$ppp?> tm10 ar"></div>
		</div> 
	</div>

	<div style="position:absolute;left:450px;top:765px;width:500">
	<div style="position:relative;color:#000000;top:23px;left:300px;font-size=15px;font-weight:bold;NanumBarunGothic;">2019.07.06</div>
		<div style="position:relative;color:#000000;top:104px;font-size=20px;font-weight:bold;NanumBarunGothic;"><?=$name?></div>
		<div style="position:relative;color:#000000;top:128px;font-size=20px;font-weight:bold;NanumBarunGothic;"><?if($price=="10000"){echo "일 만";}else if($price=="20000"){echo "이 만";}else if($price=="30000"){echo "삼 만";}else if($price=="40000"){echo "사 만";}?>&nbsp;</div>
		<div style="position:relative;color:#000000;top:113px;left:250px;font-weight:bold;NanumBarunGothic;font-size=16px;"><?=$price?></div>
	</div>
		
	<div style="position:absolute;left:390px;top:1264px;width:472">
	<div style="position:relative;color:#000000;left:360px;font-size=15px;font-weight:bold;NanumBarunGothic;">2019.07.06</div>
		<div style="position:relative;color:#000000;top:77px;left:90px;font-size=16px;font-weight:bold;NanumBarunGothic;"><?=$name?></div>
		<div style="position:relative;color:#000000;top:100px;left:90px;font-size=16px;font-weight:bold;NanumBarunGothic;"><?=$office?></div>
		<div style="position:relative;color:#000000;top:123px;left:90px;font-size=16px;font-weight:bold;NanumBarunGothic;"><?if($d['info4']){?><?=$d['info4']?><?}else{?>-<?}?></div>
		<div style="position:relative;color:#000000;top:163px;left:95px;font-size=14px;font-weight:bold;NanumBarunGothic;">38</div>
	</div>
</div>

<?$ppp++;}?>
</body>
