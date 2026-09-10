<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>

<script style="text/javascript">
	$(function(){
		window.resizeTo(1218,880);
	});
</script>
<style>
/* 팝업 > Technical Support */
div#popupTech {width: 500px;background-color: #fff;}
div.layerPopup > div#popupTech {transform:translate(-50%, -50%);}

div#popupTech div.popupCon {padding: 15px 15px 0;}
div#popupTech div.note {padding-bottom: 15px;font-size: 15px;line-height: 20px;color: #000;font-family: 'NotoSansKR DemiLight', sans-serif;}


div#popupTech h3 {margin: 20px 0 0;font-weight: normal;font-size: 15px;line-height: 20px;color: #d41414;font-family: 'NotoSansKR Bold', sans-serif;}
div#popupTech h3:first-child {margin-top: 0;}


div#popupTech p, div#popupTech dl, div#popupTech dt, div#popupTech dd {margin: 0;}
div#popupTech dl {}
div#popupTech dt {padding-top: 10px;}
div#popupTech dt:first-child {padding-top: 0;}

div#popupTech a.download {display: inline-block;margin-top: 30px;padding: 1px 10px 5px;border: 1px solid #c5c5c5;border-radius:4px;background-color: #ececec;vertical-align: top;color: #7b7b7b;text-decoration: none;}
div#popupTech a.download img {display: inline-block;padding: 7px 0 0 5px;vertical-align: top;}

div#popupTech textarea {width: 100%;height: 130px;padding: 5px;border: 1px solid #ccc;color: #111;box-sizing:border-box;font-family: 'NotoSansKR DemiLight', sans-serif;background-color: #fff;}
div#popupTech textarea::placeholder {color: #000;}


div#popupTech input[type=submit],
div#popupTech input[type=button] {display: block;width: auto;height: 100%;  margin: 0px auto;padding: 10px 60px; margin-top: 15px;text-align: center;color: #fff;background-color: #17284e;border:1px solid #17284e;font-size: 16px;font-family: 'NotoSansKR Regular', sans-serif;}
</style>

<?
	//$query = "select * from workshop_session_tbl where sid='".$session_sid."'";
	$query = "select * from workshop_session_detail_tbl where sid='".$session_sid."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$d['vod'] = $d['linkurl'];

	$in_query = "insert into vod_view_tbl set usid='".$_COOKIE['wmember_sid']."', session_sid='".$session_sid."', signdate='".date("Y-m-d")."'";
	$in_result = $conn->query($in_query);
	if(DB::isError($in_result)) {
		die($in_result->getMessage());
	}

?>
<div class="layerPopup" id="popupTech" style="display: block;margin:0px;padding:0px;width:1200px;height:800px;">
	<div class="popupWrap" id="popupSurvey" style="border:0px;padding:0px;margin:0px;width:1200px;height:800px;">
		<h1><?=$d['title']?></h1>
		<div class="popupCon" style="padding:0px;margin:0px;">
			<iframe width="100%" height="716" src="<?=$d['vod']?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>			
		</div>
		<!-- <div class="close"><a class="color_close"></a></div> -->
	</div>
	<!-- //popupWrap -->

</div>	
</body>
</html>