<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';
	
	$category_cnt = $conn->getOne("select count(*) from e_poster_category where del='N' and depth='1' ");
	
	$category_sql = "select * from e_poster_category where del='N' and depth='1' order by sort_num asc";
	$category_result=$conn->query($category_sql);
	if(DB::isError($category_result)) die($category_result->getMessage());
	
	$sort_n=1;
	while(is_array($e=$category_result->fetchRow(DB_FETCHMODE_ASSOC))){
		if($sort_n=='1'){
			$default_category = $e['sid'];
		}
		$category_sid[] = $e['sid'];
		$category_title[] = $e['title'];
		$sort_n++;
	}
	//if(!$category) $category = $default_category;
	if(!$category_sub){
		//$category_sub = $conn->getOne("select sid from e_poster_category where del='N' and depth='2' and psid='$category' order by sort_num asc limit 0,1");
	}
?>
<div class="contents" style="padding: 10px 0 30px;">
	
	<div class="eposter">	
		<ul class="sort">
			<li <?if(!$category){?>class="on"<?}?> ><a href="<?=$PHP_SELF?>">All</a></li>
			<?foreach($category_sid as $tkey=>$tval){?>
			<li <?if($category==$category_sid[$tkey]){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?category=<?=$category_sid[$tkey]?>"><?=$category_title[$tkey]?></a></li>
			<?}?>
		</ul>
		<div class="searchArea">
			<!-- <?
			$sub_cnt = $conn->getOne("select count(sid) from e_poster_category where psid='$category' and del='N'");
			if($sub_cnt>0){
				$category_subsql = "select * from e_poster_category where psid='$category' and del='N' order by sort_num asc";
				$category_subresult=$conn->query($category_subsql);
				if(DB::isError($category_subresult)) die($category_subresult->getMessage());
				
				
			?>
			<ul class="sort">
				<li <?if(!$category_sub){?>class="on"<?}?> ><a href="<?=$PHP_SELF?>?category=<?=$category?>">All</a></li>
				<?while(is_array($es=$category_subresult->fetchRow(DB_FETCHMODE_ASSOC))){?>
				<li <?if($category_sub==$es['sid']){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?category=<?=$category?>&category_sub=<?=$es['sid']?>"><?=$es['title']?></a></li>
				<?}?>
			</ul>
			<?}?> -->

			<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
			<input type="hidden" name="category" id="category" value="<?=$category?>">
			<input type="hidden" name="category_sub" id="category_sub" value="<?=$category_sub?>">
				<fieldset>
					<legend>Search</legend>
					<input type="text" name="search_keyword" id="search_keyword" value="<?=$search_keyword?>" placeholder="Please enter a keyword">
					<span class="btn"><input type="submit" value="Search"></span>
				</fieldset>
			</form>		
			<?
				$num_per_page = 10;

				if($search_keyword){
					$fsql = " and (subject like '%".$search_keyword."%' or poster_number like '%".$search_keyword."%' or presenter like '%".$search_keyword."%' or presenter_aff like '%".$search_keyword."%')";
				}

				$search_url = "&category=".$category."&category_sub=".$category_sub."&search_keyword=".$search_keyword;
				
				$query = "select count(*) from e_poster where del='N' and category!='2'" . $fsql;
				if($category){
					$query .= " and category='$category'";
				}
				if($category_sub){
					$query .= " and category_sub='$category_sub'";
				}
				$totalRecord=$conn->getOne($query);
				
				if(DB::isError($totalRecord)) die($totalRecord->getMessage());
				$pageNav=new Page($page,$totalRecord,$num_per_page);
				$totalPage = $pageNav->getTotalPage();
				$firstRecord = $pageNav->getFirstRecordInPage();
			?>
			<p class="count">* Total : <span><?=$totalRecord?></span></p>					
		</div>


		<ul class="eposterList">
			<?
				$query = "select * from e_poster where del='N' and category!='2'" . $fsql;
				if($category){
					$query .= " and category='$category'";
				}
				if($category_sub){
					$query .= " and category_sub='$category_sub'";
				}
				$query .= "  order by poster_number asc, cast(category as unsigned) asc, sort_num asc";
				$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());

				master_echo($query);

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

					//$view_chk = $conn->getOne("select count(*) from e_poster_view_tbl where psid='".$d['sid']."' and usid='".$_COOKIE['wmember_sid']."'");
			?>
			<li>
				<a <?if($d['withdraw']!='Y'){?>href="view.php?sid=<?=$d['sid']?>&category=<?=$category?>&category_sub=<?=$category_sub?>&cpage=<?=$page?>"<?}?> class="<?if($view_chk>0){?>view<?}?> <?if($d['withdraw']=='Y'){?>withdrawn<?}?>" >
					<span class="num"><?=stripslashes($d['poster_number'])?></span>
					<?if($d['award']){?><span class="sponLogo"><img src="/asset/layout/icon_award<?=$_Poster['award_code'][$d['award']]?>.png"></span><?}?>
					<span class="thumb">
						<?if($poster_file && $d['withdraw']!='Y'){?>
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

	
</div>