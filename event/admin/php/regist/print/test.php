<?
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
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
	src:url('./font/UniversLTStd-BoldCn.woff') format('woff');
}
@font-face{
	font-family:'ftlight';
	src:url('./font/UniversLTStd-LightCn.woff') format('woff');
}

#paper {position:relative;width:210mm;height:297mm;border:1px solid;}
.obj{position:absolute;}

</style>
<!--
A4 210mm * 297mm
-->

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
				$office_size = 100 / sqrt(mb_strlen($office,"utf-8"));
				if($office_size<27){
					$office_size = 130 / sqrt(mb_strlen($office,"utf-8"));
				}
			}else{
				$office_size = 120 / sqrt(mb_strlen($office,"utf-8"));
				if($office_size<25){
					$office_size = 150 / sqrt(mb_strlen($office,"utf-8"));
				}
			}
			
		}

		
?>

<script>
//<![CDATA[
jQuery(function($) {
	$(".barcode<?=$ppp?>").barcode("<?=$d['sid']?>A", "code128",{barWidth:2, barHeight:60});
});
//]]>
</script>


<div id="paper">

	<!--이름 소속 바코드-->
	<div class="obj" style="width:100%;font-family:ft,sans-serif;color:#000000;letter-spacing:-2px;font-size:<?=$name_size?>px;top:51mm;">

		<div style="position:absolute;font-weight:bold;text-align:center;left:0;top:10mm;width:105mm;">
			<?=$name?>

			<div style="font-family:ftlight; font-size:<?=$office_size?>px;position:relative;top:10px;color:#000000;"><?=$office?>
			</div>
			<div style="position:relative;margin: 0 auto;height:80px" class="barcode<?=$ppp?> tm20 "></div>
		</div>

		<div style="position:absolute;font-weight:bold;text-align:center;left:105mm;top:10mm;width:105mm;">
			<?=$name?>

			<div style="font-family:ftlight; font-size:<?=$office_size?>px;position:relative;top:10px;color:#000000;"><?=$office?>
			</div>
			<div style="position:relative;margin: 0 auto;height:80px" class="barcode<?=$ppp?> tm20 "></div>
		</div>

	</div>
</div>

<?$ppp++;}?>
</body>
