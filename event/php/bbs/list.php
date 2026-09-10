<?include "./../header.php";?>

<?

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


?>
<!--  
	<div class="titArea">
		<h2>Notice</h2>
		<p class="fixBtn">
			<a href="back.php" class="back"> </a>
		</p>
	</div> -->
<div id="fixedTop">
	<div id="containerWrap">
		<div class="titArea">
			<h2><?=$setting_col['bbs_txt']?></h2>
			<p class="fixedBtn">
			<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		</p>
		</div>
	</div>
</div>

<?

?>
<div class="wrapper" style="padding-top: 40px;">
	<div class="contents">
		<ul class="bbsList">
			<?
			$query = "SELECT * FROM bbs_tbl where code='".$code."' and del ='N' and showYN='Y' ";	
			$query .= " order by notiYN asc, sid desc";
			$result = mysqli_query($conn, $query);
			while(is_array($col = mysqli_fetch_array($result))){
			?>
				<li <?if($col['notiYN']=='Y'){?>class='notice'<?}?>><a href="./view.php?sid=<?=$col['sid']?>&code=<?=$col['code']?>">
				<span class="tit"><?=$col['subject']?></span>
				<span class="info"><?=$event_col['bbs_name']?> <!-- <?=date("Y.m.d",$col['signdate'])?> --></span>
			</a></li>
			<?}?>
		</ul>
	</div>
</div>
<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
<?include "./../footer.php";?>