<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/func/class.Block.php';
	
	$category_cnt = $conn->getOne("select count(*) from e_poster_category where del='N' and depth='2' and psid='34'");
	
	$category_sql = "select * from e_poster_category where del='N' and depth='2' and psid='34' order by sort_num asc";
	$category_result=$conn->query($category_sql);
	if(DB::isError($category_result)) die($category_result->getMessage());
	
	$sort_n=1;
	while(is_array($e=$category_result->fetchRow(DB_FETCHMODE_ASSOC))){
		if($sort_n=='1'){
			$default_category = $e['sid'];
		}
		$category_sid[] = $e['sid'];
		$category_title[$e['sid']] = $e['title'];
		$sort_n++;
	}
?>
<script>
	function pdf_views(sid){
		
		window.open('pop_view.php?psid='+sid,"A","width=1500, height=1000, scrollbars=auto");

	}
</script>
<!-- s:contents -->
<div class="contents">
    <?
        $num_per_page = 20;

        if($search_keyword){
            $fsql = " and (subject like '%".$search_keyword."%' or poster_number like '%".$search_keyword."%' or presenter like '%".$search_keyword."%' or presenter_aff like '%".$search_keyword."%' or author like '%".$search_keyword."%' or affiliation like '%".$search_keyword."%' or code like '%".$search_keyword."%')";
        }

        $search_url = "&category=".$category."&category_sub=".$category_sub."&search_keyword=".$search_keyword;
        
        $query = "select count(*) from e_poster where del='N' and withdraw='N'" . $fsql;
        $query .= " and category='34'";
        if($category_sub){
            $query .= " and category_sub='$category_sub'";
        }
		
        $totalRecord=$conn->getOne($query);


        if($totalRecord==0){
            PutMessageBack("There is no submitted e-poster for this topic.");
            exit;
        }
        
        if(DB::isError($totalRecord)) die($totalRecord->getMessage());
        $pageNav=new Page($page,$totalRecord,$num_per_page);
        $totalPage = $pageNav->getTotalPage();
        $firstRecord = $pageNav->getFirstRecordInPage();
    ?>	
    <ul class="poster-list">
        <?
            $query = "select * from e_poster where del='N' and withdraw='N'" . $fsql;
            $query .= " and category='34'";
          
            if($category_sub){
                $query .= " and category_sub='$category_sub'";
            }
            //$query .= "  order by poster_number asc, cast(category as unsigned) asc, sort_num asc";
			$query .= " order by CAST(REPLACE(poster_number, 'VE', '') AS UNSIGNED) ASC, CAST(SUBSTRING_INDEX(poster_number, '-', -1) AS UNSIGNED) ASC";
            $query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;

            $result=$conn->query($query);
            if(DB::isError($result)) die($result->getMessage());

            //master_echo($query);

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
				unset($link);
                if($d['presenter_aff']) $aff_info[] = stripslashes($d['presenter_aff']);
                if($d['country'])  $aff_info[] = ($d['country']);
                
                $poster_file = $conn->getOne("select filename from e_poster_file where psid='".$d['sid']."' order by sort_num asc limit 0,1");
                $on_check = $conn->getOne("select count(sid) from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
                $my_like = $conn->getOne("select count(sid) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$d['sid']."'");
                $total_like = $conn->getOne("select count(sid) from e_poster_like where psid='".$d['sid']."'");
                
                $total_view =  $conn->getOne("select count(sid) from e_poster_view_tbl where psid='".$d['sid']."'");


                unset($author_temp);
                unset($author_arr);
                unset($author_aff_arr);

                unset($award_class);
                if($poster_file){
					$link = "https://eposter.ksers-event.ezv.kr/upload/e_poster/".$poster_file;
				}
				
            ?>
            <li>
                <a <?if($d['movie']){?>href="javascript:pdf_views(<?=$d['sid']?>)"<?}?>>
                    <div class="cate-wrap">
                        <p class="cate"><span class="num"><?=$d['poster_number']?></span> <?=$category_title[$d['category_sub']]?> </p>
                        <span class="cnt">View : <?=$total_view?></span>
                    </div>
                    <strong class="tit">
                        <?=str_ireplace($search_keyword,"<span class='search_cls'>$search_keyword</span>",stripslashes($d['subject']))?>
                    </strong>
                    <?if($d['presenter']){?>
                        <div class="info">
                            <p class="author"><strong>Presenting Author</strong> : <?=str_ireplace($search_keyword,"<span class='search_cls'>$search_keyword</span>",stripslashes($d['presenter']))?> <?if($d['presenter_aff']){?>(<?=str_replace($search_keyword,"<span class='search_cls'>$search_keyword</span>",stripslashes($d['presenter_aff']))?>)<?}?></p>
                            <?if($poster_file){?><button type="button" class="btn btn-pdf"><img src="/assets/image/ic_pdf.png" alt=""> PDF VIEW</button><?}?>
                        </div>
                    <?}?>
                </a>
            </li>
        <?}?>
    </ul>
    <?include $_SERVER['DOCUMENT_ROOT']."include/include.page.php"?>
</div>
<!-- //e:contents -->

<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>