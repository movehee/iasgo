<?
	/********************************************************************/
	/******* 이 스탬프 페이지는 조건에 의해서 자동으로 찍히는 로직이 돌아갑니다.*********/
	/******* 조건 : 스탬프 가능한 브로셔 클릭 수 + 회사소개 VOD 클릭(설정가능) *******/
	/*******************************************************************/
?>
<form name="stampF" id="stampF" method="post" action="stamp_reg.php">
	<input type="hidden" name="booth_sid" value="<?=$booth_sid?>">
</form>
<div class="tabCon stamp" style="display:block">
	<h3>Exhibition Tour Event</h3>
	<p>
		<img src="/asset/ebooth/eventInfo.png" alt="Prize iPad Air 64GB(3 People) / 1.Participate (Log-in) every day of the congress. / 2.Collect all the exhibition stamps by vising all the sponsor’s E-booths and viewing their presentations. / - The number of stamps vary by grade. / - Diamond-3, Platinum-2, Bronze-2, Exhibition Booth / -2 If you collect 29 Stamps, you will automatically apply for the Events! /  3.Complete these steps and you are a candidate for the Lucky Draw! 4. The drawing will be held at the closing ceremony.">
	</p>
	<?
		$booth_cnt = $conn->getOne("select count(*) from booth as t1 left join booth_grade as t2 on t1.booth_sid=t2.sid where t1.op6='Y' and t1.del='N' and stamp_file!=''");
		
		$join_stamp = $conn->getOne("select count(*) from booth_stamp_ind where usid='".$_COOKIE['wmember_sid']."' ");

		$query = "select t1.* from booth as t1 left join booth_grade as t2 on t1.booth_sid=t2.sid where t1.op6='Y' and t1.del='N' order by t2.sort_num asc, t1.sort_num asc";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	?>
	<div class="bg">
		<p class="count"><?=$join_stamp?> / <span id="Acnt"></span></p>
		<ul class="stamp scrollArea">
			<?
			$All_stamp = 0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {

			if(!$d['stamp_file']) continue;
			$company_vod = $conn->getOne("select count(sid) from booth_company where booth_sid='".$d['sid']."' and vod_stamp='Y'"); //회사소개에 vod 이벤트가 있는지확인
		
			if($company_vod>0){
				$All_stamp++;
				$vod_chk = $conn->getOne("select count(sid) from booth_stamp_ind where kind='vod' and booth_sid='".$d['sid']."'");
			?>
			<li <?if($vod_chk>0){?>class="visit"<?}?>><a ><img src="<?=$_Azure['link']?>upload/booth/<?=$d['stamp_file']?>" alt=""></a></li>
			<?}?>
			
			<?
				$stamp_query = "select * from booth_brochures where booth_sid='".$d['sid']."' and stamp='Y'";
				$stamp_result=$conn->query($stamp_query);
				if(DB::isError($stamp_result)) die($stamp_result->getMessage());

				while(is_array($st=$stamp_result->fetchRow(DB_FETCHMODE_ASSOC))) {
				$my_stamp = $conn->getOne("select count(*) from booth_stamp_ind where usid='".$_COOKIE['wmember_sid']."' and booth_sid='".$d['sid']."' and kind='".$st['sid']."'");
			?>
			<li <?if($my_stamp>0){?>class="visit"<?}?>><a ><img src="<?=$_Azure['link']?>upload/booth/<?=$d['stamp_file']?>" alt=""></a></li>
			<?$All_stamp++;}?>
			<?}?>
		</ul>
	</div>
</div>
<script>
	$(function(){
		$('#Acnt').html("<?=$All_stamp?>");
	});
</script>
<!-- <div class="btn"><a href="javascript:document.stampF.submit();" class="visit"><img src="/asset/layout/btnVisit.png" alt="Visit Booth"></a></div> -->