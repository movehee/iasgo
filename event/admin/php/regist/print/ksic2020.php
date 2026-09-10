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



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/gh/moonspam/NanumSquare@1.0/nanumsquare.css" />

<script type="text/javascript" src="/admin/app/script/jquery-barcode.js"></script>
<script type="text/javascript" src="/admin/script/jquery-barcode.min.js"></script>

<style>


body {
    font-family: 'NanumSquare', sans-serif;
     }



</style>

</head>

<body topmargin="0" leftmargin="0" onload="print()" style="background-repeat:no-repeat;">

<?

	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

	$ppp=0;
	$query="SELECT * FROM regist_tbl where del='N'";

	if($code){
		$query .= " and code='".$code."'";
	}
	if($sid){
		$query .= " and sid in (".substr($sid , 0, -1).")";
	}


	if($reg_vip_gubun){

		//VIP Type
		$temp_vip_query = "select * from regist_set_tbl where sid='".$setting_col['reg_vip']."'";
		$temp_vip_result = mysqli_query($conn, $temp_vip_query);
		$temp_vip_d = mysqli_fetch_array($temp_vip_result);
		$reg_vip_gubun_type = $temp_vip_d['type'];
		$reg_vip_gubun_orderby = $temp_vip_d['info_orderby'];


		if($reg_vip_gubun == '-1') {
			$query .= " and ifnull(info".$reg_vip_gubun_orderby.",'')!=''";
		}
		else if($reg_vip_gubun == '-2') {
			$query .= " and ifnull(info".$reg_vip_gubun_orderby.",'')=''";
		}
		else {
			$query .= " and info".$reg_vip_gubun_orderby." = '".$reg_vip_gubun."'";
		}

	}

	//$query .= " and sid>752 and sid < 1381";
	$query .= " order by info11 asc, info1 asc";
	

	//$query .= " and info3='42'";
	

	//echo $query;exit;

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


		$name = str_replace("&&"," ", iconv("UTF-8", "EUC-KR", $d['info1']));
		$office = iconv("UTF-8", "EUC-KR", $d['info5']);
		$office =  str_replace(", ", ",<br>", $office); 


		//$name =$d['info1'];

		
		
		

		$name_size = 45;
		$office_size = 21;

		if(strlen($name)>=16) {
			$name_size = 40;
			$office_size = 20;
		}
		else if(strlen($name)>=15) {
			$name_size = 42;
			$office_size = 20;
		}
		//if($16)

		$b_wid = "480";
		$bfs = "13";
		$bfs2 = "12";
		
?>

<script>
//<![CDATA[
jQuery(function($) {
	$(".barcode<?=$ppp?>").barcode("<?=$d['sid']?>A", "code128",{barWidth:1, barHeight:45});
});
//]]>
</script>


<div style="position:absolute;top:<?=$ppp?>00%;background-image:url('./<?=$code?>.png');background-size: 100% ;width:100%;height:100%" width="100%" height="100%">

	<div style="position:absolute;left:29px;top:165px;width:350px">
		<div style="font-size:<?=$name_size?>px;font-weight:bold;color:#000000;text-align:center;letter-spacing:-2px; margin-top:10px;top:100px;"><?=$name?> </div>
		<div style=" font-size:<?=$office_size?>px;font-weight:bold;position:relative;top:15px;color:#000000;text-align:center;"><?=$office?>
		</div>

		<div style="position:relative;font-weight:bold;top:60px;left:123px;width:100px">
			<div style="margin: 0 auto;height:80px" class="barcode<?=$ppp?> tm10 ar"></div>
		</div>
	</div>


	<div style="position:absolute;left:410px;top:165px;width:350px">
		<div style="font-size:<?=$name_size?>px;font-weight:bold;color:#000000;text-align:center;letter-spacing:-2px; margin-top:10px;top:100px;"><?=$name?> </div>
	
		<div style=" font-size:<?=$office_size?>px;font-weight:bold;position:relative;top:15px;color:#000000;text-align:center;"><?=$office?>
		</div>
		<div style="position:relative;font-weight:bold;top:60px;left:123px;width:100px">
			<div style="margin: 0 auto;height:80px" class="barcode<?=$ppp?> tm10 ar"></div>
		</div>
	</div>




	

	
	<div style="position:absolute;left:70px;top:490px;width:350px">
		<div style="font-size:<?=$bfs?>px;font-weight:bold;color:#000000;letter-spacing:0px;position:relative;top:82px;width:320px;left:-160px;text-align:right"><?=iconv("UTF-8", "EUC-KR", $d['info11'])?></div>

		<div style="font-size:<?=$bfs?>px;font-weight:bold;color:#000000;letter-spacing:0px;position:relative;width:320px;top:93px;left:-160px;text-align:right"><?=$d['info13']?></div>
	</div>







	<div style="position:absolute;left:0px;top:898px;width:255px">
		<div style="font-size:<?=$bfs2?>px;font-weight:bold;color:#000000;letter-spacing:0px;position:relative;top:20px;left:97px;text-align:left"><?=$name?></div>

		<div style="font-size:<?=$bfs2?>px;font-weight:bold;color:#000000;letter-spacing:0px;position:relative;top:30px;left:97px;text-align:left"><?=$office?></div>
	</div>


	<div style="position:absolute;left:390px;top:898px;width:255px">
		<div style="font-size:<?=$bfs2?>px;font-weight:bold;color:#000000;letter-spacing:0px;position:relative;top:20px;left:92px;text-align:left"><?=$name?></div>

		<div style="font-size:<?=$bfs2?>px;font-weight:bold;color:#000000;letter-spacing:0px;position:relative;top:30px;left:92px;text-align:left"><?=$office?></div>
	</div>


</div>

<?$ppp++;}?>
</body>
