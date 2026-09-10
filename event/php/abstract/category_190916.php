<?include "./../header.php";?>

<?

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
if($parent){
	$query = "SELECT * FROM abstract_category_tbl where code='".$code."' and del ='N' and parent='".$parent."' order by orderby asc";	
}else {
	$query = "SELECT * FROM abstract_category_tbl where code='".$code."' and del ='N' and parent='0' order by orderby asc";	
}

$result = mysqli_query($conn, $query);

?>

<div class="titArea">
	<h2><?=$setting_col['abstract_txt']?></h2>
	<p class="fixedBtn">
		<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>
<?
if($setting_col['abs_top_menu']==1){
	$top_query = "SELECT * FROM abstract_category_tbl where code='".$code."' and del ='N' and parent='0' order by orderby asc";	
	$top_result = mysqli_query($conn, $top_query);
	$top_cnt=1;
	
	$top_all_query = "SELECT count(*) cnt FROM abstract_category_tbl where code='".$code."' and del ='N' and parent='0'";	
	$top_all_result = mysqli_query($conn, $top_all_query);
	$top_all_col = mysqli_fetch_array($top_all_result);

?>
<ul class="tabMenu">
<?while(is_array($top_col = mysqli_fetch_array($top_result))){
	$cnt_result = mysqli_query($conn, "SELECT count(*) cnt FROM abstract_category_tbl where code='".$code."' and parent='".$top_col['sid']."'");
	$cnt_row = mysqli_fetch_array($cnt_result);
?>
	<li class="menu<?if($tab==$top_cnt){echo " on";}?>" style="width:<?=100/$top_all_col['cnt']?>%"><a href="<?if($cnt_row['cnt']==0){?>./list.php<?}else{?>./category.php<?}?>?tab=<?=$top_cnt?>&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>&parent=<?=$top_col['sid']?>"><?=$top_col['info']?></a></li>
<?
$top_cnt++;
}?>
</ul>
<?}?>
<ul class="subjectList">
	<?
	while (is_array($col = mysqli_fetch_array($result))) {
		$cnt_result = mysqli_query($conn, "SELECT count(*) cnt FROM abstract_category_tbl where code='".$code."' and parent='".$col['sid']."'");
		$cnt_row = mysqli_fetch_array($cnt_result);
	if($cnt_row['cnt']==0){
	?>	
		<li><a href="./list.php?code=<?=$code?>&parent=<?=$col['sid']?>&tab=<?=$tab?>"><?=$col['info']?></a></li>
	<?}else{?>
		<li><a href="./category.php?code=<?=$code?>&parent=<?=$col['sid']?>&tab=<?=$tab?>"><?=$col['info']?></a></li>
	<?}}?>
	
</ul>
<p id="goTop" style="display: block;"><a href="#" onclick="javascript:window.scrollTo(0,0);"><img src="/image/goTop.png" alt="Top"></a></p>

<?if($code=='koa2019s'){?>
	<!-- //치어럽스메디 -->
		<div class="ad">
			<a href="http://www.cherubsmedi.com/default/" target="_blank"><img src="http://www.koa.or.kr/new_workshop/201901/app/image/ad/ad_cherubsmedi.png"></a>
		</div>
	
	<!-- //오픈엠 FnA메디컬   -->
		<div class="ad">
			<a href="http://openm.com/" target="_blank"><img src="http://www.koa.or.kr/new_workshop/201901/app/image/ad/ad_OPENCAST.png"></a>
		</div>
	<!-- //㈜파마리서치프로덕트   -->
		<div class="ad">
			<a href="http://pr-products.co.kr/kor/" target="_blank"><img src="http://www.koa.or.kr/new_workshop/201901/app/image/ad/ad_pm.gif"></a>
		</div>

	<!-- //부광약품   -->
		<div class="ad">
			<a href="https://www.bukwang.co.kr/hepatitis-and-gastrointestinal" target="_blank"><img src="http://www.koa.or.kr/new_workshop/201901/app/image/ad/ad_bukwang.png"></a>
		</div>
	<!-- //미쓰비시다나베파마코리아   -->
		<div class="ad">
			<a href="" target="_blank"><img src="http://www.koa.or.kr/new_workshop/201901/app/image/ad/ad_aglandin.png"></a>
		</div>

	<!--2019 추계 초록 광고-->
<?}else if($code=='koa2019f'){?>
	<!-- //치어럽스메디 
		<div class="ad">
			<a href="http://www.cherubsmedi.com/default/" target="_blank"><img src="http://www.koa.or.kr/new_workshop/201901/app/image/ad/ad_cherubsmedi.png"></a>
		</div>
	-->
	<!-- //오픈엠 FnA메디컬   
		<div class="ad">
			<a href="http://openm.com/" target="_blank"><img src="http://www.koa.or.kr/new_workshop/201901/app/image/ad/ad_OPENCAST.png"></a>
		</div>
	-->


<?}else if($code=='knpa2019f'){?>

<?}?>

<?include "./../footer.php";?>