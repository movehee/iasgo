<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<?
	$category_sql = "select * from e_poster_category where del='N' and depth='1' order by sort_num asc";
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

	$query = "select * from e_poster where sid='".$sid."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}	
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	$category_title = $conn->getOne("select title from e_poster_category where sid='$d[category]'");

	// $vchk = $conn->getOne("select count(sid) from e_poster_view_tbl where psid='$sid' and usid='".$_COOKIE['wmember_sid']."'");
	//중복 허용
	$vchk = 0;
	if($vchk==0){
		$vquery = "insert into e_poster_view_tbl set psid='$sid', usid='".$_COOKIE['wmember_sid']."'";
		$vresult = $conn->query($vquery);
		if(DB::isError($vresult)) {
			die($vresult->getMessage());
		}
	}

	$total_view =  $conn->getOne("select count(sid) from e_poster_view_tbl where psid='".$d['sid']."'");
?>

<link rel="stylesheet" href="/script/fancybox/jquery.fancybox.min.css" />
<script src="/script/fancybox/jquery.fancybox.min.js?v=1"></script>
<link type="text/css" rel="stylesheet" href="/script/colorbox/example3/colorbox.css" />
<script type="text/javascript" src="/script/colorbox/jquery.colorbox.js"></script>

<div class="contents">
	<div class="poster-view">
        <div class="view-contop">
            <div class="cate-wrap">
                <p class="cate"><span class="num"><?=$d['poster_number']?></span> <?=$category_title?></p>
                <span class="cnt">View : <?=$total_view?></span>
            </div>
            <strong class="tit">
                <?=$d['subject']?>
            </strong>
            <div class="info">
                <?if($d['presenter']){?>
                    <p class="author"><strong>Presenting Author</strong> : <?=$d['presenter']?> <?if($d['presenter_aff']||$d['country']){?>(<?=$d['presenter_aff']?><?=$d['country']?>)<?}?></p>
                <?}?>
            </div>
            <div class="btn-wrap text-right">
                <a href="/poster/?category=<?=$category?>&page=<?=$cpage?>&search_keyword=<?=$search_keyword?>" class="btn btn-list"><img src="/assets/image/ic_list.png" alt="">List</a>
            </div>
        </div>
        <div class="view-contents">
            <?if(file_exists($_SERVER['DOCUMENT_ROOT'].'upload/poster/ppt/'.$d['code'].'/index.html')){?>
                <script> document.domain="https://virtual.kcr4u.org/"; </script>
                <iframe src="/upload/poster/ppt/<?=$d['code']?>/index.html" style="min-height: 750px;min-width: 1420px;" frameborder=0></iframe>
            <?}else{?>
                <iframe src="/asset/image/dummy.png" style="width: 100%;height: 760px;" frameborder="0"></iframe>
            <?}?>
        </div>
        <div class="btn-wrap text-right">
            <a href="/poster/?category=<?=$category?>&page=<?=$cpage?>&search_keyword=<?=$search_keyword?>" class="btn btn-type1 color-type1 btn-list"><img src="/assets/image/ic_arrow_left.png" alt="">List</a>
        </div>
	</div>
</div>
<?if(stristr($_SERVER['REMOTE_ADDR'], '218.235.94')){?>
	내부확인용: /upload/poster/ppt/<?=$d['code']?>/index.html
<?}?>
<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>