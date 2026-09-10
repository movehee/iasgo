<?include "./../header.php";


$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


$query = "SELECT * FROM bbs_tbl where sid='".$sid."'";	
$query .= " order by sid desc";


$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);

?>	
<div id="fixedTop">
	<div id="containerWrap">
		<div class="titArea">
			<h2><?=$setting_col['bbs_txt']?></h2>
			<p class="fixedBtn">
				<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
			</p>
		</div>
		<dl class="bbs">
			<dt><?=$col['subject']?></dt>
			<dd><?=$event_col['bbs_name']?>  <!-- <?=date("Y.m.d",$col['signdate'])?> --></dd>
		</dl>
	</div>
</div>
<div class="wrapper" style="padding-top: 40px;">
	<div class="contents">
		<div class="bbsCon">
			<?=nl2br($col['content'])?>
		</div>
		<!--
		<div id="fixedArea" class="btn fullBtn"><a href="#" class="btnGrey">목록</a></div>
		-->
	</div>
	<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
</div>
<?include "./../footer.php";?>