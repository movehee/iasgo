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


	<div id="container">
		<h2 class="pageTit">IMKASID 2022 E-Poster List</h2>

		<div class="contents">
			<div class="util" style="top:-73px">
				<a href="javascript:history.back()"><img src="/asset/poster/icon_list.png" alt="">List</a>
				<a href="<?=$PHP_SELF?>?sid=<?=$sid?>"><img src="/asset/poster/icon_refresh.png" alt="">Refresh</a>
			</div>
			<?
				$query = "select * from e_poster where sid='".$sid."'";
				$result = $conn->query($query);
				if(DB::isError($result)) {
				  die($result->getMessage());
				}	
				$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
				$result->free();
			?>
		<!-- 	<div class="searchArea">
				<form id="searchF" name="searchF" action="list.php" method="post">
					<fieldset>
						<legend>Search</legend>
						<input type="text" name="search_keyword" id="search_keyword" placeholder="Abstract No./ Title/ Presenting Author">
						<span class="btn"><input type="submit" value="Search"></span>
						<span class="btn"><input type="reset" value="Clear Search"></span>
					</fieldset>
				</form>			
			</div> -->
			<!-- //searchArea -->

			<div class="posterView">
				<h3 class="posterTit"><?=$conn->getOne("select title from e_poster_category where sid='".$d['category_sub']."'")?></h3>

				


				<?$file_cnt = $conn->getOne("select count(*) from e_poster_file where psid='".$d['sid']."'");?>
				<div class="posterCon">
					
					 
					<div class="rollingArea">
						<ul>
							<?
							
							$file_query = "select * from e_poster_file where psid='".$d['sid']."' order by sort_num asc";
							$file_result=$conn->query($file_query);
							if(DB::isError($file_result)) die($file_result->getMessage());
							while(is_array($f=$file_result->fetchRow(DB_FETCHMODE_ASSOC))){
							?>
							<li id="<?=$fn?>"><img src="<?=$_Azure['link']?>upload/e_poster/view/<?=$f['filename']?>" alt="" style="width:100%;"></li>
							<?$fn++;}?>	
						</ul>
					</div>

					<div class="sessionUtil">
						<?if($file_cnt>1){?>
						<a href="#" class="prev" id="poster_prev_btn">Prev</a>
						<a href="#" class="next" id="poster_next_btn">Next</a>
						<?}?>

						<a href="javascript:history.back()" class="list">Poster List</a>
					</div>
				</div>
				<dl class="sessionBrief">
					<dt>
						<span class="num"><?=$d['poster_number']?></span>
						<?=$d['subject']?>
					</dt>
					<dd>
						<span class="name"><?=$d['presenter']?> (<?=$d['presenter_aff']?>, <?=$d['country']?>)</span>
						<?if($d['co_author']){?><span>Co-Author’s:</span> <?=eliminate_basic_tag($d['co_author'])?><br><?}?>
						<?if($d['affiliation']){?><span>Affiliation: </span><?=$d['affiliation']?><?}?>
					</dd>
				</dl>
				
			</div>

			
		</div>
		<!-- //contents -->
	</div>
	<!-- //container -->

</div>	
</body>

</html>