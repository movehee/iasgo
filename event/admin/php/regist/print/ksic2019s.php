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
    <meta http-equiv="content-type" content="text/html;charset=euc-kr">


<link type="text/css" rel="stylesheet" href="/registration_site/script/print_style.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script type="text/javascript" src="/admin/app/script/jquery-barcode.js"></script>
<script type="text/javascript" src="/admin/script/jquery-barcode.min.js"></script>

<style>


@font-face{
	font-family:'ft';
	src:url('./font/GillSans.ttc');
}


</style>

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

	//$query .= " and sid>752 and sid < 1381";
	$query .= " order by info10 asc, info1 asc";
	

	//$query .= " and info3='42'";
	

	//echo $query;

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


		$name = iconv("UTF-8", "EUC-KR", $d['info1']);
		$office = iconv("UTF-8", "EUC-KR", $d['info2']);
		$office =  str_replace(", ", ",<br>", $office); 


		//$name =$d['info1'];

		$name_size = "30";
		$office_size = "30";
		
		
		if($name){
			if(is_hangul_char($name)){
				$name_size = 110 / sqrt(mb_strlen($name,"utf-8"));
				if($name_size<27){
					$name_size = 150 / sqrt(mb_strlen($name,"utf-8"));
				}
			}else{
				$name_size = 150 / sqrt(mb_strlen($name,"utf-8"));
				if($name_size<25){
					$name_size = 200 / sqrt(mb_strlen($name,"utf-8"));
				}
			}
		}

		if($office){
			if(is_hangul_char($office)){
				$office_size = 120 / sqrt(mb_strlen($office,"utf-8"));
				if($office_size<27){
					$office_size = 140 / sqrt(mb_strlen($office,"utf-8"));
				}
			}else{
				$office_size = 160 / sqrt(mb_strlen($office,"utf-8"));
				if($office_size<25){
					$office_size = 200 / sqrt(mb_strlen($office,"utf-8"));
				}
			}
			
		}
		$name_size = 60;
		$office_size=32;

		$b_wid = "480";
		$btx = "color:#000000;font-weight:bold;";
		$bfs = "font-size:14px;";
		
?>

<script>
//<![CDATA[
jQuery(function($) {
	$(".barcode<?=$ppp?>").barcode("<?=$d['sid']?>A", "code128",{barWidth:2, barHeight:60});
});
//]]>
</script>


<div style="position:absolute;top:<?=$ppp?>00%;background-image:url('./<?=$code?>.png');background-size: 100% ;width:100%;height:100%" width="100%" height="100%">
	<div style="position:absolute;left:48px;top:200px;width:470px">


		<div style="font-family:ft,sans-serif;font-size:<?=$name_size?>px;color:#000000;text-align:center;letter-spacing:-2px; margin-top:10px;top:100px;"><?=$name?> </div>
	
		<div style="font-family:ftlight; font-size:<?=$office_size?>px;position:relative;top:40px;color:#000000;text-align:center;"><b><?=$office?></b>
		</div>

		<div style="position:relative;font-weight:bold;top:80px;left:130px;width:200px">
			<div style="margin: 0 auto;height:80px" class="barcode<?=$ppp?> tm10 ar"></div>
		</div>
	</div>

	<div style="position:absolute;left:558px;top:200px;width:470px">


		<div style="font-family:ft,sans-serif;font-size:<?=$name_size?>px;color:#000000;text-align:center;letter-spacing:-2px; margin-top:10px;top:100px;"><?=$name?> </div>
	
		<div style="font-family:ftlight; font-size:<?=$office_size?>px;position:relative;top:40px;color:#000000;text-align:center;"><b><?=$office?></b>
		</div>

		<div style="position:relative;font-weight:bold;top:80px;left:130px;width:200px">
			<div style="margin: 0 auto;height:80px" class="barcode<?=$ppp?> tm10 ar"></div>
		</div>
	</div>

	<div style="position:absolute;left:108px;top:685px;width:450px">


	
		<div style="font-size:<?=$bfs?>px;font-weight:bold;color:#000000;letter-spacing:0px;position:relative;top:96px;width:320px;left:-130px;text-align:right"><?=$name?></div>

		<div style="font-size:<?=$bfs?>px;font-weight:bold;color:#000000;letter-spacing:0px;position:relative;width:320px;top:114px;left:-130px;text-align:right"><?=$d['info13']?></div>
	


	
	</div>


</div>

<?$ppp++;}?>
</body>
