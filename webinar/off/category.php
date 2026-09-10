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
<?
	$query = "select * from e_poster_category where depth='2' and psid='27' order by sort_num asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<div class="wrapper">

	<div id="headerWrap">

		<dl id="skipNavi">
			<dt>Skip Navigation</dt>
			<dd><a href="#container">Skip to contents</a></dd>
		</dl>

		<div class="header">
			<h1><a href="#"><img src="/asset/layout/header_logo.png" alt="IMKASID 2022"></a></h1>
		</div>
	</div>
	<!-- //headerWrap -->


	<div id="container">
		<h2 class="pageTit">IMKASID 2022 E-Poster Zone</h2>

		<div class="contents">
			<div class="util">
				<a href="/off/"><img src="/asset/poster/icon_home.png" alt="">Home</a>
				<a href="<?=$PHP_SELF?>"><img src="/asset/poster/icon_refresh.png" alt="">Refresh</a>
			</div>

			<div class="searchArea">
				<form id="searchF" name="searchF" action="list.php" method="post">
					<fieldset>
						<legend>Search</legend>
						<input type="text" name="search_keyword" id="search_keyword" placeholder="Abstract No./ Title/ Presenting Author">
						<span class="btn"><input type="submit" value="Search"></span>
						<span class="btn"><input type="button" value="Clear Search" onclick="$('#search_keyword').val('')"></span>
					</fieldset>
				</form>		
			</div>
			<!-- //searchArea -->

			<div class="posterView">
				
				<ul class="posterView_list">
					<?
						$i=1;
						while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
					?>
					<li><a href="list.php?category_sub=<?=$d['sid']?>"><span><?=$d['title']?></span></a></li>
					<?
					if($i=='3'){
						echo "</ul><ul class=\"posterView_list\">";
					}
					$i++;
					}
					?>
				</ul>
				
			</div>
			<!-- //posterView -->

			
		</div>
		<!-- //contents -->
	</div>
	<!-- //container -->

</div>	
</body>

</html>