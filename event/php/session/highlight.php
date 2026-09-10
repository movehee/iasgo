<?include "./../header.php";?>
<script type="text/javascript" src="/script/jquery.bxslider.min.js?<?=time()?>"></script>
<script>
jQuery(function($) {
	var product = $("div.productBnr");
	if (product.length) {

		var productBnr = $("div.productBnr li");
		if (productBnr.length > 1) {
			$("div.productBnr ul").bxSlider({
				mode 'fade' 
			});
		}
	}
});


</script>

<style>
div.productBnr {}

div.productBnr li img {display: block;width: 100%;}
div.productBnr div.bx-controls {padding: 7px 10px 5px;}

div.productBnr div.bx-pager {overflow: hidden;height: 20px;} div.productBnr div.bx-pager-item {float: left;width: 20px;height: 20px;padding-left: 5px;} div.productBnr div.bx-pager-item:first-child {padding-left: 0;} div.productBnr div.bx-pager-item a {display: block;width: 100%;height: 100%;text-indent: -10000px;background: url('/image/page_off.png') center center no-repeat;background-size: 16px;} div.productBnr div.bx-pager-item a.active {background-image: url('/image/page_on.png');}

div.productBrief {border-bottom: 2px solid #ededed;}
div.productBrief h3 {position: relative;padding: 10px;border-bottom: 2px solid #ededed;color: #000;font-size: 1.4em;line-height: 1.2;font-weight: bold;}
div.productBrief h3 img {position: absolute;right: 10px;top: 50%;height: 58px;margin-top: -29px;}

div.productBrief dl {overflow: hidden;padding: 10px 10px 10px;}
div.productBrief dl dt,
div.productBrief dl dd {float: left;width: 75%;padding-top: 5px;line-height: 1.4;}
div.productBrief dl dt {width: 25%;color: #808080;}

div.productBrief p.btn {padding: 0 10px 15px;}
div.productBrief p.btn a {display: block;padding: 10px;border-radius:0;text-align: center;}


dl.productInfo dt,
dl.productInfo dd {padding: 10px;}
dl.productInfo dt {color: #808080;}
dl.productInfo dd {min-height:1.5em;padding-top: 0;border-bottom: 2px solid #ededed;}
</style>

<?



$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$title=$setting_col['highlight_txt'];

$query = "select a.*,t.time time_info, r.name room_info, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.viewYN='Y' and highlight='1'";
$query .= " order by a.tab asc, a.orderby asc";
$result = mysqli_query($conn, $query);

?>
<div id="fixedTop">
<div class="titArea">
	<h2><?=$title?></h2>
	<p class="fixedBtn">
		<a href="./back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>
</div>
<div class="wrapper">

<div class="productBnr">
	<ul>
	<?
	while(is_array($col = mysqli_fetch_array($result))){
		?>
		<li onclick="javscript:location.href='./glance_sub.php?glance=<?=$col['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>&title=<?=$title?>'"><img src="/upload/session/<?=$col['highlight_image']?>" alt="" /></li>
	<?}?>
	</ul>
</div>
<!--

<ul class="subjectList">
	<?while(is_array($col = mysqli_fetch_array($result))){?>
		<li><a href="./list.php?category=<?=$col['sid']?>&tab=-7&code=<?=$code?>"><?=$col['info']?></a></li>
	<?}?>
</ul>
-->

</body>
</html>