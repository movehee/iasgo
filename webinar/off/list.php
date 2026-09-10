<?include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IMKASID 2022</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script type="text/javascript" src="/script/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
});
//]]>
</script>
</head>
<body>
<div class="wrapper">

	<div id="headerWrap">

		<dl id="skipNavi">
			<dt>Skip Navigation</dt>
			<dd><a href="#container">Skip to contents</a></dd>
		</dl>

		<div class="header">
			<h1><a href="/enter/"><img src="/asset/layout/header_logo.png" alt="IMKASID 2022"></a></h1>
		</div>
	</div>
	<!-- //headerWrap -->
	

	<?
		require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
		require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';

		$num_per_page = 10;

		if($search_keyword){
			$fsql = " and (subject like '%".$search_keyword."%' or poster_number like '%".$search_keyword."%' or presenter like '%".$search_keyword."%' )";
		}

		$search_url = "&category=".$category."&category_sub=".$category_sub."&search_keyword=".$search_keyword;
		
		$query = "select count(*) from e_poster where del='N' and category!='2'" . $fsql;
		
		if($category_sub){
			$query .= " and category_sub='$category_sub'";
		}
		$totalRecord=$conn->getOne($query);
		
		if(DB::isError($totalRecord)) die($totalRecord->getMessage());
		$pageNav=new Page($page,$totalRecord,$num_per_page);
		$totalPage = $pageNav->getTotalPage();
		$firstRecord = $pageNav->getFirstRecordInPage();
	?>

	<div id="container">
		<h2 class="pageTit">IMKASID 2022 E-Poster List</h2>

		<div class="contents">
			<div class="util">
				<a href="category.php"><img src="/asset/poster/icon_list.png" alt="">List</a>
				<a href="<?=$PHP_SELF?>?category_sub=<?=$category_sub?>"><img src="/asset/poster/icon_refresh.png" alt="">Refresh</a>
			</div>
			<div class="searchArea">
				<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
				<input type="hidden" name="category" id="category" value="<?=$category?>">
				<input type="hidden" name="category_sub" id="category_sub" value="<?=$category_sub?>">
					<fieldset>
						<legend>Search</legend>
						<input type="text" name="search_keyword" id="search_keyword" value="<?=$search_keyword?>" placeholder="Abstract No./ Title/ Presenting Author">
						<span class="btn"><input type="submit" value="Search"></span>
						<span class="btn"><input type="button" value="Clear Search" onclick="$('#search_keyword').val('');$('#search_keyword').focus();"></span>
					</fieldset>
				</form>		
			</div>
			<!-- //searchArea -->

			<div class="posterView">
				<?if($category_sub){?>
				<h3 class="posterTit"><?=$conn->getOne("select title from e_poster_category where sid='$category_sub'")?></h3>
				<?}else{?>
				<h3 class="posterTit">ALL</h3>
				<?}?>
				<ul class="eposterList">
					<?
					$query = "select * from e_poster where del='N' and category='27'" . $fsql;
					if($category_sub){
						$query .= " and category_sub='$category_sub'";
					}
					$query .= "  order by cast(category as unsigned) asc, sort_num asc";
					$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
					$result=$conn->query($query);
					if(DB::isError($result)) die($result->getMessage());

					$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);
					
					# 블럭단위 계산
					$blockNav = new Block("", $totalPage, $page_per_block);
					$totalBlock = $blockNav->getTotalBlock();
					$blockNav->setBlock($page);
					$block = $blockNav->getBlock();
					$firstPageInBlock = $blockNav->getFirstPageInBlock();
					$lastPageInBlock = $blockNav->getLastPageInBlock();
					if($block >= $totalBlock) $lastPageInBlock = $totalPage;

					while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
						unset($aff_info);
						if($d['presenter_aff']) $aff_info[] = stripslashes($d['presenter_aff']);
						if($d['country'])  $aff_info[] = ($d['country']);
						
						$poster_file = $conn->getOne("select filename from e_poster_file where psid='".$d['sid']."' order by sort_num asc limit 0,1");
						$on_check = $conn->getOne("select count(*) from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
						$my_like = $conn->getOne("select count(*) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
						$total_like = $conn->getOne("select count(*) from e_poster_like where psid='".$d['sid']."'");

						$view_chk = $conn->getOne("select count(*) from e_poster_view_tbl where psid='".$d['sid']."' and usid='".$_COOKIE['wmember_sid']."'");	
					?>
					<li>
						<a href="view.php?sid=<?=$d['sid']?>&category=<?=$d['category']?>&category_sub=<?=$d['category_sub']?>&cpage=<?=$page?>" <?if($view_chk>0){?>class="view"<?}?>>
							<span class="num"><?=stripslashes($d['poster_number'])?></span>
							<?if($d['award']){?><span class="sponLogo"><img src="/asset/layout/icon_award<?=$_Poster['award_code'][$d['award']]?>.png"></span><?}?>
							<span class="thumb">
								<?if($poster_file){?>
									<img src="<?=$_Azure['link']?>upload/e_poster/thumb/<?=$poster_file?>" alt="">
								<?}?>
							</span>
							<span class="tit"><?=stripslashes($d['subject'])?></span>
							<span class="writer"><?=stripslashes($d['presenter'])?> <?if(count($aff_info)>0){?>(<?=implode(", ",$aff_info)?>)<?}?></span>
						</a>

					</li>
					<?}?>
				</ul>

				<?include $_SERVER['DOCUMENT_ROOT']."include/include.page.php"?>
				
			</div>
			<!-- //posterView -->

			
		</div>
		<!-- //contents -->
	</div>
	<!-- //container -->

</div>	
</body>

</html>