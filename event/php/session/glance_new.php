<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<title>Easy Voting System</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5, minimum-scale=0, user-scalable=yes, target-densityDpi=medium-dpi, viewport-fit=cover" />
<script type="text/javascript" src="/script/1.11.2.jquery.min.js"></script>

<style>
	body { margin: 0px; font-family:'나눔고딕',NanumGothic,Roboto,Helvetica,sans-serif !important;}
</style>
</head>
<body >
<?
include_once $_SERVER['DOCUMENT_ROOT']."data/class.glance.php";


$query="SELECT * FROM glance_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$d = mysqli_fetch_assoc($result);

if($tab) {
	$result = mysqli_query($conn, "SELECT day from agenda_tbl where sid='$tab'");
	$row = mysqli_fetch_array($result);
	$glance_day = $row['day'];
}

$item = $d['day'.$glance_day];

$item = str_replace("<?php","",$item);
$item = str_replace("?>","",$item);



if(!$item) {
	$item = '$glance = new Glance("'.$code.'", "'.$glance_day.'");';
	$item .= '$glance->make();';
}

?>

<?=eval($item)?>


<?if(!$include && $setting_col['glance_full']=="Y"){?>
<script>
jQuery(function($) {
	var zoomval = $(window).width() / $("div#glance_div").width() * 100;
	$("div#glance_div").css('zoom',zoomval+'%');
	$("td").css('-webkit-text-size-adjust',zoomval+'%');
	$("span").css('-webkit-text-size-adjust',zoomval+'%');
	$("div").css('-webkit-text-size-adjust',zoomval+'%');
	
});
</script>
<?}?>


</body>
</html>
