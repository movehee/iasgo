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
    <meta http-equiv="content-type" content="text/html;charset=utf-8">


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
<?
	$query="SELECT * FROM booth_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
?>
</head>

<body topmargin="0" leftmargin="0" onload="print()" style="background-repeat:no-repeat;">
<div style="width:100%;">
	
	<div style="font-weight:bold;padding-top:400px;">
		<div style="text-align:center;line-height:100px;font-size:40px;"><?=$d['name']?></div>
		<div style="margin: 0 auto;height:120px" class="barcode<?=$ppp?>"></div>
	</div>
</div>
</body>

<script>
//<![CDATA[
jQuery(function($) {
	$(".barcode<?=$ppp?>").barcode("<?=$sid?>A", "code128",{barWidth:3, barHeight:90});
});
//]]>
</script>
</html>