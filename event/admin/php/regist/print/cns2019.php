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

<script type="text/javascript" src="/admin/script/jquery.qrcode.min.js"></script>

<style>


/* @font-face{
	font-family:'ft';
	src:url('./font/GillSans.ttc');
} */


</style>

<script>
$(document).ready(function() {
	print();
});
</script>

</head>

<body topmargin="0" leftmargin="0" style="background-repeat:no-repeat;">

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
	$query .= " order by info1 asc";
	

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
		
		
		if($d['info4'] == "314") $year_price = "50000";
		else $year_price = "-";


		if($d['info5'] == "" || $d['info5'] == "0") $regist_price = "-";
		else $regist_price = $d['info5'];
?>

<script>
//<![CDATA[
jQuery(function($) {
	//$(".barcode<?=$ppp?>").barcode("<?=$d['sid']?>A", "code128",{barWidth:2, barHeight:60});

	$('.barcode<?=$ppp?>').qrcode({width: 70,height: 70,text: "<?=$d[sid]?>A"});
});
//]]>
</script>


<div style="position:absolute;top:<?=$ppp*100?>%;width:100%;height:100%;page-break-before: always;" width="100%" height="100%">
	<div style="position:absolute;left:0px;top:130px;width:510px">

		<div style="position:relative;top:5px;height:55px;padding-right:35px;text-align:right;">
			<div class="barcode<?=$ppp?>"></div>
		</div>

		<div style="font-family:ft,sans-serif;font-size:<?=$name_size?>px;color:#000000;text-align:center;letter-spacing:2px; margin-top:10px;top:80px;font-weight: bold;"><?=$name?> </div>
	
		<div style="font-family:ftlight; font-size:<?=$office_size?>px;padding-top:45px;color:#000000;text-align:center;letter-spacing: -2px;"><font><?=$office?></font>
		</div>

		
	</div>

	<div style="position:absolute;left:510px;top:130px;width:510px;">
		
		<div style="position:relative;top:5px;height:55px;padding-right:45px;text-align:right;">
			<div class="barcode<?=$ppp?>"></div>
		</div>

		<div style="font-family:ft,sans-serif;font-size:<?=$name_size?>px;color:#000000;text-align:center;letter-spacing:2px;margin-top:10px;top:80px;font-weight: bold;"><?=$name?> </div>
	
		<div style="font-family:ftlight;font-size:<?=$office_size?>px;padding-top:45px;color:#000000;text-align:center;letter-spacing:-2px;"><font><?=$office?></font>
		</div>

	</div>

	<div style="position:absolute;left:0px;top:752px;width:510px;">
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:110px;padding-top:70px;"><?=$name?></div>
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:110px;padding-top:8px;"><?=$office?></div>
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:110px;padding-top:8px;"><?=$regist_price?></div>
	</div>

	<div style="position:absolute;left:510px;top:752px;width:510px">
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:145px;padding-top:70px;"><?=$name?></div>
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:145px;padding-top:8px;"><?=$office?></div>
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:145px;padding-top:8px;"><?=$year_price?></div>
	</div>


	<div style="position:absolute;left:0px;top:1100px;width:510px">
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:120px;padding-top:75px;"><?=$name?></div>
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:120px;padding-top:8px;"><?=$office?></div>
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:120px;padding-top:8px;"><?=$regist_price?></div>
	</div>

	<div style="position:absolute;left:510px;top:1100px;width:510px">
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:150px;padding-top:80px;"><?=$name?></div>
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:150px;padding-top:8px;"><?=$office?></div>
		<div style="font-size:<?=$bfs?>px;color:#000000;letter-spacing:0px;padding-left:150px;padding-top:8px;"><?=$year_price?></div>
	</div>


</div>
<?$ppp++;}?>
</body>
