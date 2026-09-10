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
	if(!$category) $category = $default_category;
	if(!$category_sub){
		//$category_sub = $conn->getOne("select sid from e_poster_category where del='N' and depth='2' and psid='$category' order by sort_num asc limit 0,1");
	}
?>
<div class="contents">
	
	<div class="eposter">	
		
		<ul class="subMenu">
			<!-- <li <?if(!$category){?>class="on"<?}?> ><a href="<?=$PHP_SELF?>">All</a></li> -->
			<?foreach($category_sid as $tkey=>$tval){?>
			<li <?if($category==$category_sid[$tkey]){?>class="on"<?}?>><a href="<?=$PHP_SELF?>?category=<?=$category_sid[$tkey]?>"><?=$category_title[$tkey]?></a></li>
			<?}?>
		</ul>

		<?
			$num_per_page = 10;

			if($search_keyword){
				$fsql = " and (subject like '%".$search_keyword."%' or poster_number like '%".$search_keyword."%' or presenter like '%".$search_keyword."%' or presenter_aff like '%".$search_keyword."%')";
			}

			$search_url = "&category=".$category."&category_sub=".$category_sub."&search_keyword=".$search_keyword;
			
			$query = "select count(*) from e_poster where del='N'" . $fsql;
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

		<ul class="eposterList">
		
			<?
			$query = "select * from e_poster where del='N'" . $fsql;
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
				$on_check = $conn->getOne("select count(sid) from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
				$my_like = $conn->getOne("select count(sid) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
				$total_like = $conn->getOne("select count(sid) from e_poster_like where psid='".$d['sid']."'");

				// $view_chk = $conn->getOne("select count(*) from e_poster_view_tbl where psid='".$d['sid']."' and usid='".$_COOKIE['wmember_sid']."'");
				$total_view =  $conn->getOne("select count(sid) from e_poster_view where psid='".$d['sid']."'");


				unset($author_temp);
				unset($author_arr);
				unset($author_aff_arr);

				for($i=1;$i<=7;$i++){
					if($d['author'.$i]){
						if($d['presenter']!=$d['author'.$i]){}
							$author_temp = stripslashes($d['author'.$i]);
							// if($d['author_aff'.$i]) $author_temp .= "<sup>".$d['author_aff'.$i]."</sup>";
							$author_temp .= "<sup>".$i."</sup>";
							if($author_temp){
								$author_arr[] = $author_temp;
							}						
					}
					if($d['author_aff'.$i]){
						$author_aff_arr[] = stripslashes($d['author_aff'.$i])."<sup>".$i."</sup>";
					}
				}
			?>

			<li>
				<a <?if($d['withdraw']!='Y'){?>href="view.php?sid=<?=$d['sid']?>&category=<?=$category?>&category_sub=<?=$category_sub?>&cpage=<?=$page?>"<?}?> class="<?=$award_class?>">
					
					<span class="num"><?=$d['poster_number']?></span>
					<span class="thumb">
						<?if($poster_file && $d['withdraw']!='Y'){?>
							<img src="<?=$_Azure['link']?>upload/e_poster/thumb/<?=$poster_file?>" alt="">
						<?}?>
					</span>
					<span class="tit"><?=stripslashes($d['subject'])?></span>


					<span><span>Presenting Author’s : </span><?=$d['presenter']?> <?if($d['presenter_aff']){?>(<?=stripslashes($d['presenter_aff'])?>)<?}?></span>
					<?if($author_arr){?>
					<span>
						<span>Co-Author’s : </span>
						<?=implode(", ",$author_arr)?>
					</span>
					<?}?>

					<?if($author_aff_arr){?>
					<span>
						<span>Affiliation : </span>
						<?=implode(", ",$author_aff_arr)?>
					</span>
					<?}?>

					<span class="hit">View : <?=number_format($total_view)?></span>
				</a>
				<span class="util">
					<a onclick="like_chk(<?=$d['sid']?>)" id="p_like_<?=$d['sid']?>" class="like<?if($my_like>0){?> on<?}?>">
						Like <span id="like_<?=$d['sid']?>_txt"><?=$total_like?></span>
					</a>
					
					<a href="javascript:favor_list_chk(<?=$d['sid']?>,'add')" id="favor_<?=$d['sid']?>" class="favor <?if($on_check>0){?>on<?}?>"> favorite</a>
				</span>
			</li>

			<?}?>

		</ul>
		<?include $_SERVER['DOCUMENT_ROOT']."include/include.page.php"?>

	</div>

	
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>