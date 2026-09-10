<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'did/include.header.php';
	$query = "SELECT * FROM e_poster WHERE sid='".$sid."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$filename = $conn->getOne("SELECT filename FROM e_poster_file WHERE psid='".$sid."'");
	$search_url = "depart=".$depart."&keyword=".$keyword."&page=".$set_page;

	$presenter_aff = $d['presenter_aff'] ? "(".$d['presenter_aff'].")" : "";
	$title = $conn->getOne("SELECT title FROM e_poster_category WHERE sid='".$d['category']."'");
?>
	<style>
		/* 하단 LIST 사용하지 않음, 좌측 상단 홈 버튼을 포스터 이미지 위에 겹침 */
		div.wrapper.eposterViewPage {
			overflow: hidden;
		}
		div.wrapper.eposterViewPage #eposterVeiw {
			position: relative;
		}
		div.wrapper.eposterViewPage .eposterCon {
			overflow: hidden;
		}
		a.eposterHome {
			position: absolute;
			top: 20px;
			left: 20px;
			z-index: 50;
			display: block;
			width: 110px;
			line-height: 0;
			text-decoration: none;
		}
		a.eposterHome img {
			display: block;
			width: 100%;
			height: auto;
			border-radius: 22px;
			-webkit-box-shadow: 0 4px 14px rgba(0,0,0,0.45);
			box-shadow: 0 4px 14px rgba(0,0,0,0.45);
		}
	</style>
	<div class="wrapper eposterViewPage">
		<div id="container">
			<div id="eposterVeiw">
				<a href="list.php?<?=htmlspecialchars($search_url, ENT_QUOTES, 'UTF-8')?>" class="eposterHome">
					<img src="/did/image/btn_home.png" alt="LIST">
				</a>
				<div class="eposterCon">
                    <?php if (!empty($filename)): ?>
                        <img src="https://eposter.iasgo-event.ezv.kr/upload/e_poster/<?=htmlspecialchars($filename, ENT_QUOTES, 'UTF-8')?>"
                             onerror="this.onerror=null; this.src='/did/image/IASGO2026_E-Poster_Default.PNG';"
                             alt="">
                    <?php else: ?>
                        <img src="/did/image/IASGO2026_E-Poster_Default.PNG" alt="">
                    <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'did/include.footer.php'; ?>
