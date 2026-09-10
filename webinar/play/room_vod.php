<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procLoginChk();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>대한내과학회</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/player.css">
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/player.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
});
//]]>
</script>
</head>
<body>
<div class="wrapper">


<div class="layerPopup" id="popupRoom" style="display: block;">

	<div class="koreaTime">
		18:33
	</div>

	<div class="popupCon">

		<h1>내과전공의 초음파교육</h1>

		<div class="room">
			
			<dl class="vodInfo">
				<dt>
					<span>수강기간</span>
					2021년 4월 24일(토) 18:00 ~ 4월 25일(일) 24:00
				</dt>
				<dd>
					<ul class="vodItem">
						<?
							$progress_query = "select * from vod_result_tbl where vsid='1' and usid='".$_COOKIE['wmember_sid']."'";
							$progress_result = $conn->query($progress_query);
							$progress_result->fetchInto(&$p,DB_FETCHMODE_ASSOC);
							$progress_result->free();
							unset($progress);
							if($p['sid']){
								if($p['c_time']>0){
									$progress = round(($p['c_time']/$p['r_time'])*100);
								}
							}else{
								$progress = 0;
							}
						?>
						<li>
							<span>복부초음파 <?if($p['confirm']=='Y'){?><b style='color:red;'>- [완료]</b><?}?></span>
							배규환 (속튼튼내과) / 인정건수 5건
							<span class="graph" data-num="<?=$progress?>%">
								<span class="graphBar" style="width: <?=$progress?>%;"></span>
							</span>
							<a href="index_vod.php?vsid=1">입장하기</a>
						</li>
						<?
							$progress_query = "select * from vod_result_tbl where vsid='2' and usid='".$_COOKIE['wmember_sid']."'";
							$progress_result = $conn->query($progress_query);
							$progress_result->fetchInto(&$p,DB_FETCHMODE_ASSOC);
							$progress_result->free();
							unset($progress);
							if($p['sid']){
								if($p['c_time']>0){
									$progress = round(($p['c_time']/$p['r_time'])*100);
								}
							}else{
								$progress = 0;
							}
						?>
						<li>
							<span>갑상선초음파 <?if($p['confirm']=='Y'){?><b style='color:red;'>- [완료]</b><?}?></span>
							조관훈 (가톨릭의대) / 인정건수 5건
							<span class="graph" data-num="<?=$progress?>%">
								<span class="graphBar" style="width: <?=$progress?>%;"></span>
							</span>
							<a href="index_vod.php?vsid=2">입장하기</a>
						</li>
						<?
							$progress_query = "select * from vod_result_tbl where vsid='3' and usid='".$_COOKIE['wmember_sid']."'";
							$progress_result = $conn->query($progress_query);
							$progress_result->fetchInto(&$p,DB_FETCHMODE_ASSOC);
							$progress_result->free();
							unset($progress);
							if($p['sid']){
								if($p['c_time']>0){
									$progress = round(($p['c_time']/$p['r_time'])*100);
								}
							}else{
								$progress = 0;
							}
						?>
						<li>
							<span>근골격계초음파 <?if($p['confirm']=='Y'){?><b style='color:red;'>- [완료]</b><?}?></span>
							이주하 (가톨릭의대) / 인정건수 5건
							<span class="graph" data-num="<?=$progress?>%">
								<span class="graphBar" style="width: <?=$progress?>%;"></span>
							</span>
							<a href="index_vod.php?vsid=3">입장하기</a>
						</li>
						<?
							$progress_query = "select * from vod_result_tbl where vsid='4' and usid='".$_COOKIE['wmember_sid']."'";
							$progress_result = $conn->query($progress_query);
							$progress_result->fetchInto(&$p,DB_FETCHMODE_ASSOC);
							$progress_result->free();
							unset($progress);
							if($p['sid']){
								if($p['c_time']>0){
									$progress = round(($p['c_time']/$p['r_time'])*100);
								}
							}else{
								$progress = 0;
							}
						?>
						<li>
							<span>심초음파 <?if($p['confirm']=='Y'){?><b style='color:red;'>- [완료]</b><?}?></span>
							조인정 (이화의대) / 인정건수 5건
							<span class="graph" data-num="<?=$progress?>%">
								<span class="graphBar" style="width: <?=$progress?>%;"></span>
							</span>
							<a href="index_vod.php?vsid=4">입장하기</a>
						</li>
					</ul>
				</dd>
			</dl>

		</div>


	</div>	
	<!-- //popupRoom -->


</div>	
</body>

</html>