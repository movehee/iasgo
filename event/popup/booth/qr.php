<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KCR 2023</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/css/webinar.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/script/jquery.qrcode.js"></script>
<script type="text/javascript" src="/script/qrcode.js"></script>
<style>
    div.boothQR {padding-bottom: 90px;}
    div.boothQR h1 {margin-bottom: 50px; margin:0; text-align: center;background-color: #f3f4f9;}
    div.boothQR dt {margin-top: 100px;text-align: center;padding: 0 25px;}
    div.boothQR dd {margin-top: 70px;padding: 0 24px 0 15px;text-align: center;margin-right: 20px;}
    div.boothQR dd span {display: inline-block;padding: 22px;box-sizing:border-box;border: 20px solid;}

    div.boothQR dd span.platinum {border-image: linear-gradient(to right, #3869ae, #a2a8f1, #173561); border-image-slice: 1;}
    div.boothQR dd span.gold  {border-image: linear-gradient(to right, #c48226, #e9b741, #ecd57f); border-image-slice: 1;}
    div.boothQR dd span.silver  {border-image: linear-gradient(to right, #e6e7eb, #868589, #aeafbb); border-image-slice: 1;}
    div.boothQR dd span.bronze  {border-image: linear-gradient(to right, #884936, #c2af94, #ba957b); border-image-slice: 1;}
	div.boothQR dd span.exhibition  {border-image: linear-gradient(to right, #368867, #94c2a6, #7bba80); border-image-slice: 1;}
</style>
<body style="margin:0;" onload="window.print();">
<?
$query = "select * from booth where sid='$sid'";
$result = $conn->query($query);
if(DB::isError($result)) {
  die($result->getMessage());
}
$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
$result->free();
if($d['booth_sid'] == "1") $b_class = "platinum";
else if($d['booth_sid'] == "2") $b_class = "gold";
else if($d['booth_sid'] == "3") $b_class = "silver";
else if($d['booth_sid'] == "4") $b_class = "bronze";
else if($d['booth_sid'] == "6") $b_class = "exhibition";
?>
<div class="boothQR">
	<h1><img src="/asset/layout/QR_header2023_new.png" alt="KCR 2023"></h1>
	<dl>
		<dt><img src="<?=$_Azure['link']?>upload/booth/<?=$d['booth_ground_file']?>" alt="" -style="height:70px;"></a></dt>
		<dd>
			<span class="<?=$b_class?>">
                <div id="gcDiv" class="qrborder"></div>
			</span>
		</dd>
	</dl>
</div>
<!-- ///boothQR -->

<script>
    window.resizeTo(1100,1300);
    jQuery("#gcDiv").qrcode({   //qrcode 시작
        render : "canvas",      //table, canvas 형식 두 종류가 있다. 
        width : 550,            //넓이 조절
        height : 550,           //높이 조절
        text   : "<?=$sid?>A"     //QR코드에 실릴 문자열
    });
</script>



</body>
</html>
