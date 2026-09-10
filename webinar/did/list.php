<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'did/include.header.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';

	$depart = '';
	if (isset($_POST['depart'])) {
		$depart = $_POST['depart'];
	} else if (isset($_GET['depart'])) {
		$depart = $_GET['depart'];
	}

	$keyword = '';
	if (isset($_POST['keyword'])) {
		$keyword = trim($_POST['keyword']);
	} else if (isset($_GET['keyword'])) {
		$keyword = trim($_GET['keyword']);
	}

	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	if ($page < 1) {
		$page = 1;
	}

	$num_per_page = 15;
	if (!empty($li_page)) {
		$num_per_page = $li_page;
	}

	$categorySql = "SELECT sid, title FROM e_poster_category WHERE del = ? AND depth = ? ORDER BY sort_num ASC";
	$categoryResult = $conn->query($categorySql, array('N', '1'));
	if (DB::isError($categoryResult)) {
		error_log('[DID list] category query failed: '.$categoryResult->getMessage());
		die($categoryResult->getMessage());
	}

	$category_sid = array();
	$category_title = array();
	while (is_array($e = $categoryResult->fetchRow(DB_FETCHMODE_ASSOC))) {
		$category_sid[] = $e['sid'];
		$category_title[$e['sid']] = $e['title'];
	}

	$whereSql = '';
	$params = array();
	if ($depart) {
		$whereSql .= ' AND category = ?';
		$params[] = $depart;
	}
	if ($keyword != '') {
		$likeKeyword = '%'.$keyword.'%';
		$whereSql .= ' AND (subject LIKE ? OR presenter LIKE ? OR presenter_aff LIKE ? OR poster_number LIKE ?)';
		$params[] = $likeKeyword;
		$params[] = $likeKeyword;
		$params[] = $likeKeyword;
		$params[] = $likeKeyword;
	}

	$countQuery = "SELECT COUNT(*) FROM e_poster WHERE del = ?".$whereSql;
	$countParams = array_merge(array('N'), $params);
	$totalRecord = $conn->getOne($countQuery, $countParams);
	if (DB::isError($totalRecord)) {
		error_log('[DID list] count query failed: '.$totalRecord->getMessage());
		die($totalRecord->getMessage());
	}

	$pageNav = new Page($page, $totalRecord, $num_per_page);
	$totalPage = $pageNav->getTotalPage();

	$listQuery = "SELECT * FROM e_poster WHERE del = ?".$whereSql;
	$listQuery .= " ORDER BY CAST(REPLACE(poster_number, 'EP', '') AS UNSIGNED) ASC, CAST(SUBSTRING_INDEX(poster_number, '-', -1) AS UNSIGNED) ASC";
	$listQuery .= " LIMIT ".$pageNav->getFirstRecordInPage().",".$num_per_page;

	$listParams = array_merge(array('N'), $params);
	$result = $conn->query($listQuery, $listParams);
	if (DB::isError($result)) {
		error_log('[DID list] list query failed: '.$result->getMessage());
		die($result->getMessage());
	}

	$posterList = array();
	while (is_array($d = $result->fetchRow(DB_FETCHMODE_ASSOC))) {
		$posterList[] = $d;
	}

	$blockNav = new Block("", $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if ($block >= $totalBlock) {
		$lastPageInBlock = $totalPage;
	}

	$search_url = "&depart=".$depart."&keyword=".urlencode($keyword);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/css/index.css">
<script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.js"></script>
<script>
	$(document).ready(function(){

		let Keyboard = window.SimpleKeyboard.default;

		let keyboard = new Keyboard({
		  onChange: input => onChange(input),
		  onKeyPress: button => onKeyPress(button)
		});

		/**
		 * Update simple-keyboard when input is changed directly
		 */
		document.querySelector("#keyword").addEventListener("input", event => {
		  keyboard.setInput(event.target.value);
		});

		function onChange(input) {
		  document.querySelector("#keyword").value = input;
		}

		function onKeyPress(button) {
		  /**
		   * If you want to handle the shift and caps lock buttons
		   */
		  if (button === "{shift}" || button === "{lock}") handleShift();

		  if( button === "{enter}" ){
			$("form").eq(0).submit();
		  }

		}

		function handleShift() {
		  let currentLayout = keyboard.options.layoutName;
		  let shiftToggle = currentLayout === "default" ? "shift" : "default";

		  keyboard.setOptions({
			layoutName: shiftToggle
		  });
		}

		// DID 키보드 팝업 위치/크기 — 키 모양은 /load/keyboard/ 유지
		// function getKbVar(name, fallback) {
		// 	let value = $.trim(window.getComputedStyle(document.documentElement).getPropertyValue(name));
		// 	if (value) {
		// 		return value;
		// 	}
		// 	return fallback;
		// }

		// function applyDidKeyboardSize() {
		// 	let $input = $('#keyword');
		// 	let topOverride = getKbVar('--did-kb-top', 'auto');
		// 	let top = topOverride;
		// 	if (topOverride == 'auto') {
		// 		let $sch = $('.sch-wrap');
		// 		let gap = parseFloat(getKbVar('--did-kb-gap', '12')) || 12;
		// 		top = ($sch.offset().top - $(window).scrollTop() + $sch.outerHeight() + gap) + 'px';
		// 	}
		// 	$input.attr('Wsize', getKbVar('--did-kb-width', '90%'));
		// 	$input.attr('Hsize', getKbVar('--did-kb-height', '500'));
		// 	$input.attr('Tsize', top);
		// }
		
		// applyDidKeyboardSize();
		// $('#keyword').on('mousedown touchstart', applyDidKeyboardSize);
		// $(window).on('resize', applyDidKeyboardSize);
		// DID 키보드 팝업 위치/크기 — 키 모양은 /load/keyboard/ 유지 END

		/*$("#keyword").click(function(){
			$(".layerPopup").fadeIn();
		});*/

	});
</script>
	<div class="wrapper">
		<div id="headerWrap">
			<h1>
				<img src="/did/css/topVisual.png" alt="IASGO 2026 E-poster">
			</h1>
		</div>
		<div class="sch-wrap">
			<form action="list.php" method="post" id="searchF">
			<input type="hidden" name="depart" value="<?=$depart?>">
				<fieldset>
					<legend class="hide">검색</legend>
					<div class="form-group">
						<input type="text" name="keyword" id="keyword" value="<?=$keyword?>" autocomplete="off"  class="form-item Load_Base_fix" href="/load/keyboard/"  Wsize="90%" Hsize="500" Tsize="25%" placeholder="Please enter a keyword" inputmode="search">
						<button type="submit" class="btn btn-sch">Search</button>
						<button type="button" class="btn btn-reset" onclick="location.href='list.php?depart=<?=$depart?>'">Clear Search</button>
					</div>
				</fieldset>
			</form>
		</div>
		<div id="container">
			<div class="sub-tab-wrap">
				<button type="button" class="btn-tab-menu js-btn-tab-menu">ALL</button>
				<ul class="sort">
					<li class="<?=!$depart ? 'on' : ''?>">
						<a href="list.php">ALL</a>
					</li>
					<?php foreach ($category_sid as $tval): ?>
						<li class="<?=$depart == $tval ? 'on' : ''?>">
							<a href="list.php?depart=<?=$tval?>"><?=$category_title[$tval]?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="eposterWrap">
				<ul class="eposterList">
					<?php foreach ($posterList as $d): ?>
						<li>
							<a href="view.php?sid=<?=$d['sid']?>&depart=<?=$depart?>&keyword=<?=urlencode($keyword)?>&set_page=<?=$page?>">
								<span class="num"><?=$d['poster_number']?></span>
								<span class="cate"><?=$conn->getOne("SELECT title FROM e_poster_category WHERE sid = ?", array($d['category']))?></span>
								<span class="tit"><?=$d['subject']?></span>
								<span class="name"><strong><?=$d['presenter']?></strong><?php if ($d['presenter_aff']) { ?> (<?=$d['presenter_aff']?>)<?php } ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php include_once "include.page.php"; ?>
			</div>
			<!-- <div id="fixedArea">
				<a href="index.php" class="btnList">Home</a>
			</div> -->
		</div>
	</div>
<link type="text/css" rel="stylesheet" href="/asset/webinar2.css">
<div class="layerPopup" style="display: none;">
	<div class="popupWrap" id="popupEvent">
		<h1>Touch Keypad</h1>
		<div class="popupCon">
			<div class="simple-keyboard"></div>
		</div>
		<div class="close"><a href="#" onclick="$('div.layerPopup').fadeOut();return false;">Close</a></div>
	</div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'did/include.footer.php'; ?>
