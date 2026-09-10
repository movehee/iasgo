<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'func/config/flag.php';
?>
<script>
$(document).ready(function(){	
	//parent.$.colorbox.resize({width:1245,height:830});
});
</script>
<div class="popupWrap" id="popupAwards">
	<h1>Award</h1>
	<div class="popupCon">

	<div class="awards">
		<div><img src="/asset/awards/popup_tit.png" alt="Congratulations to Awardees! We have total 60 awardees with outstanding abstracts from 16 countries! Thank you all for your contributions."></div>
		<?
			$count_award = $conn->getOne("select count(sid) from faculty_tbl where award='Y'");
		?>
		<!-- <h3><span><?=$count_award?> Investigator Awards</span></h3> -->

		<?foreach($_Faculty['award'] as $tkey=>$tval){?>

		<h3><span><?=$tval?></span></h3>
		<ul class="awardee">
			<?
			
				$query = "select * from faculty_tbl where award='Y' and award_kind='$tkey' order by award_sort_num asc, faculty_name asc";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
					if($d['faculty_photo']){
						$fac_image = $_Azure['link'].'/upload/faculty/'.$d['faculty_photo'];
					}else{
						$fac_image = "/asset/layout/session_thumb.png";
					}
					//$Resize_img = imgResize($fac_image,82,82);
					if($d['faculty_none']=='Y'){
						$pquery = "select sid,category,category_sub from e_poster where poster_number='".$d['faculty_code']."'";
						$presult = $conn->query($pquery);
						$presult->fetchInto(&$p,DB_FETCHMODE_ASSOC);
						$presult->free();
					}
			?>
			<li>
				<?if($d['faculty_none']=='Y'){?>
					<?if($p['sid']){?>
						<a href="javascript:parent.location.href='/poster/view.php?sid=<?=$p['sid']?>&category=<?=$p['category']?>&category_sub=<?=$p['category_sub']?>'" >
					<?}else{?>
						<a href="javascript:alert('등록되어있는 포스터가 없습니다.')" >
					<?}?>
				<?}else{?>
					<a href="/load/faculty_session_list.php?faculty_sid=<?=$d['sid']?>&prev=award" class="Load_session_list">
				<?}?>
				<img src="<?=$fac_image?>" alt="" style="width:135px;height:148px;">
				<span>
					<?if($_Flag['country'][$d['faculty_country']]){?><img src="<?=$_Azure['link']?>upload/flag/thumb/<?=$_Flag['country'][$d['faculty_country']]?>.png" style='width:35px;'><?}?>
					<span><?=$d['faculty_country']?></span>
					<?=$d['faculty_name']?>
				</span>
			</a></li>
			<?}?>
		</ul>
		<?}?>
	</div>
	<!-- //awards -->
	<div class="close"><a class="color_close"><img src="/asset/layout/layerpopup_close_p.png" alt="닫기"></a></div>
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>
