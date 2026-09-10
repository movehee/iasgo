<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<!-- $(document).ready(function(){
parent.$.colorbox.resize({width:800,height:1000});
}); -->
<?
	$query = "select * from w_notice_tbl ";
	if(!$notice_sid){
		$query .= " where use_yn='Y' and del='N' order by top desc, sort_num asc limit 0,1";
	}else{
		$query .= " where use_yn='Y' and del='N' and sid='$notice_sid'";
	}
	
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}

	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$content_sid = $d['sid'];


	$vchk = $conn->getOne("select count(sid) from w_notice_view_tbl where nsid='$content_sid' and usid='".$_COOKIE['wmember_sid']."'");
	if($vchk==0){
		$vquery = "insert into w_notice_view_tbl set nsid='$content_sid', usid='".$_COOKIE['wmember_sid']."', signdate=". time();
		$vresult = $conn->query($vquery);
		if(DB::isError($vresult)) {
			die($vresult->getMessage());
		}
	}
?>
<div class="popupWrap" id="popupBbs">
	<div class="popupCon">
		<dl class="bbsCon">
			<dt>
				<?=$d['subject']?>
			</dt>
			<dd class="scrollArea">
				<dl class="notice">
					<dd>
						<?=$d['content']?>
					</dd>
				</dl>
			</dd>
		</dl>
		<?
			$Notice_cnt = $conn->getOne("select count(sid) from w_notice_tbl where use_yn='Y' and del='N' ");
		?>
		<div class="bbsList">
			<p class="count">Total <span><?=$Notice_cnt?></span></p>
			<ul>
	<!-- 			<li class="faq readed">
					<a href="helpdesk.php">FAQ</a>
				</li> -->
				<?
					$query = "select * from w_notice_tbl where use_yn='Y' and del='N' order by top desc,sort_num asc";
					$result=$conn->query($query);
					if(DB::isError($result)) die($result->getMessage());
					$n=1;
					while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {

					$vchk = $conn->getOne("select count(sid) from w_notice_view_tbl where nsid='".$d['sid']."' and usid='".$_COOKIE['wmember_sid']."'");
				?>
					<?if($d['top']=='Y'){?>
						<li class="notice<?if($vchk){?> readed<?}?>">
							<a href="<?=$PHP_SELF?>?notice_sid=<?=$d['sid']?>">
								<span class="tit"><?=$d['subject']?></span>
							</a>
						</li>
					<?}else{?>
						<li class="<?if($notice_sid==$d['sid']){?>on<?}?><?if($vchk){?> readed<?}?>">
							<a href="<?=$PHP_SELF?>?notice_sid=<?=$d['sid']?>"><span class="tit"><?=$d['subject']?></span></a>
						</li>
					<?}?>
				<?}?>
			</ul>
		</div>
	</div>
	<!-- //popupCon -->
	<div class="close"><a class="color_close"></a></div>
</div>
<script>
	$(document).on("click",".color_close",function(){
		parent.$.colorbox.close();
	});
</script>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>
