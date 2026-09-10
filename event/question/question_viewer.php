<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="kor" xml:lang="kor"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>관리자 | <?=$_Site['Name']?></title>	
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link type="text/css" rel="stylesheet" href="/admin/css/common_v3.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/sub.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/admin_v2.css" />
<link type="text/css" rel="stylesheet" href="/css/webinar.css" />
<link type="text/css" rel="stylesheet" href="/admin/button_package/button.css" />

<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script type="text/javascript" src="/admin/script/user_admin.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {

});
//]]>
</script>
<!-- <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script> -->
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script type="text/javascript" src="/script/jquery-ui.min.js"></script>
<link rel='stylesheet' type='text/css' href='/admin/mail/conf/jquery-flick.css'/>
<SCRIPT LANGUAGE="javascript" SRC="/admin/script/jquery.ui-jalert.js"></SCRIPT>
<script type="text/javascript" src="/admin/script/jquery.popupoverlay.js"></script>
<link rel="stylesheet" href="/admin/script/jquery.ui.timepicker.css">
<script src='/admin/script/jquery.ui.timepicker.js'></script>
<script type="text/javascript" src="/script/webinar.js"></script>
<link rel="stylesheet" href="/script/colorbox/example1/colorbox.css" />
<script src="/script/colorbox/jquery.colorbox.js"></script>
<script>
	var day = "<?=$day?>";
	var room = "<?=$room?>";
	$(function(){
		var notice = setInterval( function () {
			//긴급공지
			$.ajax({
				type : 'POST',
				url : 'question_chk.php',
				data:"room="+room+"&day="+day,
				success : function(data) {
					$('#question_area').html(data)
				}
			});
		}, 1000);
	});
</script>
<?

	$query = "select * from question_tbl where push='Y' and room='$room' and day='$day' order by sid desc limit 0,1";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>
<div style="width:100%;height:100%">
	<table style="width:80%;height:100%" align="center">
		<tr>
			<td align="center" style="font-size:90px;font-weight:bold;"><div id="question_area"><?=nl2br($d['question'])?></div></td>
		</tr>
	</table>
</div>
