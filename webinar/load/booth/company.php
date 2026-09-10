<?
	$query = "select * from booth_company where booth_sid='$booth_sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$Broshures_stamp = 0;
	$Broshures_stamp = $conn->getOne("select count(*) from booth_brochures where booth_sid='$booth_sid' and stamp='Y'");
	if($d['vod_stamp']=='Y'){
		$Broshures_stamp += 1;
	}
?>
<link rel="stylesheet" type="text/css" href="/script/flowplayer/skin.css">
<script src="/script/flowplayer/flowplayer.js"></script>
<script src="/script/flowplayer.inlinevideo.js"></script>

<div class="tabCon company" style="display:block">
	<div class="bizCon">
		<div class="scrollArea">
			<?if($booth['logo_file']){?>
				<h3><img src="<?=$_Azure['link']?>upload/booth/<?=$booth['logo_file']?>" alt="<?=$booth['title']?>"></h3>
			<?}?>
			<dl>
				<?if($d['vod_link']){?>
				<dt class="tit">VOD <?if($d['vod_stamp']=='Y'){?><a class="vod company_vod" key="<?=$booth['sid']?>">VOD View <i class="fas fa-stamp"></i></a><?}?></dt>
				<dd>
					<div class="vodArea">
						<iframe src="<?=$d['vod_link']?>&autoplay=1" width="100%" height="320" frameborder="0" allow="autoplay; fullscreen" allowfullscreen autoplay></iframe>
						<!-- <div class="flowplayer" data-ratio="0.4167" data-key="$238996279069523" style="height:508px;">
							<video>
								<source type="video/mp4" src="<?=$d['vod_link']?>">
							</video>
						</div> -->
					</div>
					
				</dd>
				<?}else{?>
					<?if($d['vod_stamp']=='Y'){?>
						<dt class="tit">VOD <?if($d['vod_stamp']=='Y'){?><a class="vod company_vod" key="<?=$booth['sid']?>">VOD View <i class="fas fa-stamp"></i></a><?}?></dt>
					<?}?>
					<?if($d['brochures']){?><div class="ac"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['brochures']?>"></div><?}?>
				<?}?>
			</dl>
			
			<!-- <?
			$bro_cnt = $conn->getOne("select count(sid) from booth_brochures where booth_sid='$booth_sid'");
			if($bro_cnt>0){
				$query_bro = "select * from booth_brochures where booth_sid='$booth_sid'";
				$query_bro .= " order by sort_num asc, sid asc";
				$result_bro=$conn->query($query_bro);
				if(DB::isError($result_bro)) die($result_bro->getMessage());
			?>
			<dl>
				<dt class="tit">Brochures</dt>
					<dd>
						<ul class="download">
							<?
							while(is_array($b=$result_bro->fetchRow(DB_FETCHMODE_ASSOC))) {
								$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/booth/" . $b["broc_file"]) . "&filename=" . base64_encode($b["broc_file"]);
							?>
							<li>
								<img src="<?=$_Azure['link']?>upload/booth/<?=$b["cover_file"]?>" alt="">
								<?if($b['stamp']=='Y'){?>
								<a href="javascript:popup_call('Azure','sid=<?=$b['sid']?>&kind=booth_brochures')">PDF Download <i class="fas fa-stamp"></i></a>
								<?}else{?>
								<a href="javascript:popup_call('Azure','sid=<?=$b['sid']?>&kind=booth_brochures')">PDF Download <i class="fas fa-download f_w"></i></a>
								<?}?>
							</li>
							<?}?>
						</ul>
					</dd>
				</dl>
			<dl>
			<?}?> -->
			<dt class="tit">Company Introduction</dt>
			<dd class="company">
				<?=str_replace("../../",$_Azure['link'],$d['content'])?>
			</dd>
		</div>
		<!-- //scorllArea -->
	</div>
	<!-- //bizCon -->
	
	<div class="bizInfo">
		<?
		$bro_cnt = $conn->getOne("select count(sid) from booth_brochures where booth_sid='$booth_sid'");
		if($bro_cnt>0){
			$query_bro = "select * from booth_brochures where booth_sid='$booth_sid'";
			$query_bro .= " order by sort_num asc, sid asc";
			$result_bro=$conn->query($query_bro);
			if(DB::isError($result_bro)) die($result_bro->getMessage());
		?>
		<dl class="brochure">
			<dt>Brochures</dt>
			<dd>
				<ul>
					<?
					while(is_array($b=$result_bro->fetchRow(DB_FETCHMODE_ASSOC))) {
						$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/booth/" . $b["broc_file"]) . "&filename=" . base64_encode($b["broc_file"]);
					?>
					<li>
						<a href="javascript:popup_call('Azure','sid=<?=$b['sid']?>&kind=booth_brochures')"><img src="<?=$_Azure['link']?>upload/booth/<?=$b["cover_file"]?>" alt=""></a>
						<a href="javascript:popup_call('Azure','sid=<?=$b['sid']?>&kind=booth_brochures')" class="download">PDF Download</a>
					</li>
					
					<?}?>
				</ul>
			</dd>
		</dl>
		<?}?>
		<?if($d['homepage']){?><div class="btn"><a href="<?=$d['homepage']?>" target="_blank">Website</a></div><?}?>
		
		<dl class="info">
			<dt>Contact Information</dt>
			<dd>
				<div>
					<p><?=$booth['title']?></p>
					<p class="name"><?=$d['name_kr']?></p>
					<ul>
						<?if($d['address']){?><li><span>A.</span><?=$d['address']?></li><?}?>
						<?if($d['cell']){?><li><span>T.</span><?=$d['cell']?></li><?}?>
						<?if($d['email']){?><li><span>E.</span><a href="mailto:<?=$d['email']?>"><?=$d['email']?></a></li><?}?>
					</ul>
				</div>
			</dd>
		</dl>
	
		
		<!-- <?if($d['booth_link']){?><div class="btn tm10"><a href="<?=$d['booth_link']?>" target="_blank"><img src="/asset/ebooth/btn_goBooth.png" alt="Webiste"></a></div><?}?>
	
		<dl class="draw">
			<dt>Join the Lucky Draw Event!</dt>
			<dd class="title">Collect all stamps, get the Apple Watch 7 (2 People)</dd>
			<dd>
				If you collect all 29 Stamps, you will automatically apply for the Exhibition Stamp Event. Check the information with the stamp image (<i class="fas fa-stamp"></i>).
				You can acquire a total of <span style="border-bottom: 1px solid #eff438;padding: 0 3px;color:#eff438;font-size:16px;"><?=$Broshures_stamp?></span> stamps pieces on this page.
			</dd>
		</dl> -->
	</div>
	<!-- //bizInfo -->
</div>
