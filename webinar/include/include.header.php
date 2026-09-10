<?include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
    if($ex_url[1]!='booth'){
        //procLoginChk();
    }
    
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
		$category_title[$e['sid']] = $e['title'];
		$sort_n++;
	}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes,viewport-fit=cover">
<meta name="format-detection" content="telephone=no, address=no, email=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="Author" content="<?=$_CONFIG['Name']?>">
<meta name="Keywords" content="<?=$_CONFIG['Name']?>">
<meta name="description" content="<?=$_CONFIG['Name']?>">
<title><?=$_CONFIG['Name']?></title>
<link rel="icon" href="/assets/image/favicon.ico">
<link type="text/css" rel="stylesheet" href="/assets/css/slick.css">
<link type="text/css" rel="stylesheet" href="/assets/css/jquery-ui.min.css">
<link type="text/css" rel="stylesheet" href="/assets/css/common.css">
<!-- intro css -->
<link type="text/css" rel="stylesheet" href="/assets/css/intro.css">
<script type="text/javascript" src="/assets/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/js/slick.min.js"></script>
<script type="text/javascript" src="/assets/js/common.js"></script>

<!-- original source -->
<script type="text/javascript" src="/script/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>
<script type="text/javascript" src="/script/webinar.js?v=0.1"></script>
<link type="text/css" rel="stylesheet" href="/script/colorbox/example3/colorbox.css" />
<script type="text/javascript" src="/script/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
});

//]]>
$(document).ready(function(){
	load_Times = setInterval( function () {
		var curTime = new Date();   
		var hours = ('0' + curTime.getHours()).slice(-2); 
		var minutes = ('0' + curTime.getMinutes()).slice(-2);
		$('.CurTimes').html(hours+' '+minutes);
	}, 5000);
});
function logout(){
	location.href="/logout.php";
}
</script>
</head>
<body oncontextmenu='return false' onselectstart='return true' ondragstart='return true'>
    <div class="wrap poster">
        <header id="header">
            <div class="header-wrap">
                <h1 class="header-logo">
                    <a href="/poster"><img src="/assets/image/h1_logo_video.png" alt="KSERS 2026 Video"></a>
                </h1>
                <div class="sch-wrap">
                    <form id="searchF" name="searchF" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                        <input type="hidden" name="category" id="category" value="<?=$category?>">
                        <input type="hidden" name="category_sub" id="category_sub" value="<?=$category_sub?>">
                        <fieldset>
                            <legend class="hide">검색</legend>
                            <div class="form-group">
                                <input type="text" name="search_keyword" id="search_keyword" value="<?=$search_keyword?>" placeholder="Please enter a keyword" class="form-item sch-key">
                                <button type="submit" class="btn btn-sch"><span class="hide">검색</span></button>
                                <!-- <a href="/poster/index.php" class=" clear">Search Clear</a> -->
                            </div>
                        </fieldset>
                    </form>
                </div>

                <nav id="gnb">
                    <ul class="gnb js-gnb">
                        <li <?if(!$category){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>">ALL</a></li>
						<?
						$category_sql = "select * from e_poster_category where del='N' and depth='2' and psid='34' order by sort_num asc";
						$category_result=$conn->query($category_sql);
						if(DB::isError($category_result)) die($category_result->getMessage());

						$sort_n=1;
						while(is_array($e=$category_result->fetchRow(DB_FETCHMODE_ASSOC))){

							$category2_cnt = $conn->getOne("select count(*) from e_poster_category where del='N' and depth='2' and psid='".$e['sid']."'");

						?>
						<li <?if($category==$e['sid']){?>class="on"<?}?>>
                            <a href="<?=$_SERVER['PHP_SELF']?>?category_sub=<?=$e['sid']?>"><?=$e['title']?></a>
							<?if($category2_cnt>0){?>
							
							<ul>
							<?
							$category_sql2 = "select * from e_poster_category where del='N' and depth='2' and psid='".$e['sid']."' order by sort_num asc";
							$category_result2=$conn->query($category_sql2);
							if(DB::isError($category_result2)) die($category_result2->getMessage());

					
							while(is_array($e2=$category_result2->fetchRow(DB_FETCHMODE_ASSOC))){
							?>
                            <li <?if($e2['sid']==$category_sub){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?category=<?=$e['sid']?>&category_sub=<?=$e2['sid']?>"><?=$e2['title']?></a></li>
							<?}?>
							</ul>
							<?}?>
                        </li>

						<?}?>
                    </ul>
                </nav>
            </div>
        </header>
        <section id="container">