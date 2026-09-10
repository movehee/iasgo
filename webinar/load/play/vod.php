<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
	
	if($sid=='99999'){
		$link = "https://player.vimeo.com/video/535707574";
	}else{
		
		$part = $conn->getOne("select t2.part from workshop_session_detail_tbl as t1 inner join workshop_session_tbl as t2 on t1.session_sid=t2.sid where t1.sid='$sid'");
		if($kind=='session'){
			$query = "select * from workshop_session_tbl where sid='$sid'";
			$result = $conn->query($query);
			$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
			$result->free();
			
			//$title = $d['part']." ".$d['title'];
			$title = $d['part'];
			$link = $d['vod'];

			$vquery = "insert into vod_view_tbl set usid='".$_COOKIE['wmember_sid']."'";
			$vquery .= ", session_sid='".$d['session_sid']."'";
			$vquery .= ", signdate='".date("Y-m-d")."'";
			$vresult = $conn->query($vquery);
			if(DB::isError($vresult)) {
				die($vresult->getMessage());
			}
		}else{
			$query = "select * from workshop_session_detail_tbl where sid='$sid'";
			$result = $conn->query($query);
			$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
			$result->free();
			
			$title = $d['title'];
			$link = $d['linkurl'];

			$vquery = "insert into vod_view_tbl set usid='".$_COOKIE['wmember_sid']."'";
			$vquery .= ", session_sid='".$d['session_sid']."'";
			$vquery .= ", detail_sid='".$d['sid']."'";
			$vquery .= ", signdate='".date("Y-m-d")."'";
			$vresult = $conn->query($vquery);
			if(DB::isError($vresult)) {
				die($vresult->getMessage());
			}
		}
		
		
	}

	
?>
<div class="popupWrap" style="height:792px;margin:0px;">

<div style="font-size:18px;font-weight:bold;padding:10px 20px 10px 20px ;background:#2478B2;color:#ffffff;height:75px;width:96.5%;">
	<?if($d['sid']){?>
	<div style="float:left;padding-right:40px;color: #ffeb3b;    line-height: 20px; "><?=$title?></div><br>
	<div style="float:leftfloat:left;font-size:18px;padding-right:100px;"><?=$d['author']?></div>
	<?}else{?>
	<div style="float:left;"></div>
	<?}?>
	<div class="close" style="top: 44px;"><a class="color_close"><img src="/asset/layout/layerpopup_close.png" alt="닫기" ></a></div>
</div>
<iframe src="<?=$link?>&autoplay=1" width="100%" height="700" frameborder="0" allow="autoplay; fullscreen" allowfullscreen autoplay></iframe>
</div>