<?php include_once $_SERVER['DOCUMENT_ROOT'].'did/include.header.php'; ?>
<script>location.href="list.php"</script>
	<div id="wrap" class="intro">
		<header id="header">
            <h1>
				<img src="/did/css/img_intro_text.png" alt="IASGO 2026 / 일시 : 2026년 09월 09일(금)-11일(일) 08:30 - 17:30 / 장소 : 서울 스위스 그랜드호텔 컨벤션홀 2층">
			</h1>
        </header>
		<section id="container">
			<div class="intro_text">
				<h2>
					<span>E-poster</span>
				</h2>
			</div>          
            <div class="contents">
				<p>카테고리를 선택해 주세요.</p>
				<ul class="into_menu">
					<?php foreach($_DID['depart'] as $tkey=>$tval): ?>
						<li>
							<a href="list.php?depart=<?=$tkey?>">
								<span><?=$tval['title']?></span>
								<span><?=$tval['number']?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
            </div>
			<div class="footer">
				<img src="/did/css/footer_logo.png" alt="대한내과학회">
			</div>
        </section>
	</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'did/include.footer.php'; ?>