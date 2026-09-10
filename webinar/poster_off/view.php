<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<?
	$query = "select * from e_poster where sid='".$sid."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}	
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	$category_title = $conn->getOne("select title from e_poster_category where sid='$d[category]'");

	$vchk = $conn->getOne("select count(sid) from e_poster_view_tbl where psid='$sid' and usid='".$_COOKIE['wmember_sid']."'");
	if($vchk==0){
		$vquery = "insert into e_poster_view_tbl set psid='$sid', usid='".$_COOKIE['wmember_sid']."'";
		$vresult = $conn->query($vquery);
		if(DB::isError($vresult)) {
			die($vresult->getMessage());
		}
	}
?>
<script>
	$(document).ready(function() {
		/*
		var poster_top = $("dd#poster_list > ul").find("li.on").position().top - 40;
		$("dd#poster_list").scrollTop(poster_top);
		*/
	});
</script>
<link rel="stylesheet" href="/script/fancybox/jquery.fancybox.min.css" />
<script src="/script/fancybox/jquery.fancybox.min.js?v=1"></script>
<link type="text/css" rel="stylesheet" href="/script/colorbox/example3/colorbox.css" />
<script type="text/javascript" src="/script/colorbox/jquery.colorbox.js"></script>
<div class="contents" style="padding: 10px 0 30px;">
	<?
		$poster_score = $conn->getOne("select score from e_poster_star_tbl where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
		$fchk = $conn->getOne("select count(sid) from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");

		$my_like = $conn->getOne("select count(*) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
		$total_like = $conn->getOne("select count(*) from e_poster_like where psid='".$d['sid']."'");
	?>		
	<div class="eposter">				

		<dl class="sessionBrief">
			<dt>
				<span class="num"><?=$d['poster_number']?></span>
				<?=$d['subject']?>
			</dt>
			<dd>
				<span class="name"><?=$d['presenter']?> (<?=$d['presenter_aff']?>, <?=$d['country']?>)</span>
				<?if($d['co_author']){?><span>Co-Author’s:</span> <?=eliminate_basic_tag($d['co_author'])?><br><?}?>
				<?if($d['affiliation']){?><span>Affiliation: </span><?=$d['affiliation']?><?}?>
			</dd>
			<dd class="util">
				<a href="/poster_off/?category=<?=$d['category']?>" class="list">List</a>
			</dd>
		</dl>


		<div class="sessionCon off" style="padding:0">

			<div class="posterCon">
				<?if($d['movie']){?>
				<iframe src="<?=$d['movie']?>&autoplay=1" width="100%" height="450" frameborder="0" allow="autoplay; fullscreen" allowfullscreen autoplay></iframe>
				<?}else{?>
				<div class="rollingArea">
					<ul>
						<?
						$file_cnt = $conn->getOne("select count(*) from e_poster_file where psid='".$d['sid']."'");
						$file_query = "select * from e_poster_file where psid='".$d['sid']."' order by sort_num asc";
						$file_result=$conn->query($file_query);
						if(DB::isError($file_result)) die($file_result->getMessage());
						while(is_array($f=$file_result->fetchRow(DB_FETCHMODE_ASSOC))){
						?>
						<li id="<?=$fn?>"><img src="<?=$_Azure['link']?>upload/e_poster/view/<?=$f['filename']?>" alt="" style="width:100%;"></li>
						<?$fn++;}?>	
					</ul>
				</div>
				<?}?>
				<div class="sessionUtil">
					<?if($file_cnt>1){?>
					<a href="#" class="prev" id="poster_prev_btn">Prev</a>
					<a href="#" class="next" id="poster_next_btn">Next</a>
					<?}?>
					<!-- 2022-05-23 주석 처리
					<a href="/poster_off/?category=<?=$d['category']?>&page=<?=$cpage?>" class="list">Poster List</a>
					<?if(!$d['movie']){?><a href="javascript:popup_call('poster/view','sid=<?=$d['sid']?>')" class="detail">View Detail</a><?}?>
					-->
				</div>
			</div>


<!-- 		
			<p class="listNoti">When you click on a star(<img src="/asset/layout/posterFav.png" alt="">),<br>it will appear as one of your favorites on My Page.</p>
			
			<dl class="list">
				<dt>E-Poster</dt>
				<dd id="poster_list">
					<ul class="List_poster">
						<?
							$equery = "select * from e_poster where del='N' " .$rquery;
							if($category){
								$equery .= " and category='$category' ";
							}
							if($category_sub){
								$equery .= " and category_sub='$category_sub'";
							}
							$equery .= " order by sort_num asc";
							$eresult=$conn->query($equery);
							if(DB::isError($eresult)) die($eresult->getMessage());
							while(is_array($e=$eresult->fetchRow(DB_FETCHMODE_ASSOC))){
								$on_check = $conn->getOne("select count(*) from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='".$e['sid']."'");
								$fir_img = $conn->getOne("select filename from e_poster_file where psid='".$e['sid']."' order by sort_num asc limit 0,1");
						?>
						<li id="tr_<?=$e['sid']?>" class="PList_<?=$e['sid']?><?if($sid==$e['sid']){?> on<?}?>">
							<a  href="<?=$PHP_SELF?>?sid=<?=$e['sid']?>&category=<?=$e['category']?>&category_sub=<?=$category_sub?>">
								<span class="thumb" >
								<?if($fir_img){?>
								<img src="<?=$_Azure['link']?>upload/e_poster/thumb/<?=$fir_img?>" width=108 alt="">
								<?}?>
								</span>
								<span class="code"><?=$e['poster_number']?></span>
								<?=$e['subject']?>
							</a>
						</li>
						<?}?>
					</ul>
				</dd>
		
				
			</dl> -->
		</div>

	</div>
	<!-- //eposter -->

	
</div>