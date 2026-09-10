<form name="stampF" id="stampF" method="post" action="stamp_reg.php">
	<input type="hidden" name="booth_sid" value="<?=$booth_sid?>">
</form>
<!-- Stamp Event -->
<div class="tabCon stamp" style="display:block">				
	<h3> Booth Event</h3>
	<p class="img">
		<img src="/asset/ebooth/eventInfo.png" alt="행사 종료 후 설문조사와 함께 문자발송이 될 예정이며, 스탬프투어+설문지 완료하신 분 중 추첨을 통해 “KSBMR의 명품향을 선물 드립니다.!”">
	</p>
	<?
		$booth_cnt = $conn->getOne("select count(*) from booth as t1 left join booth_grade as t2 on t1.booth_sid=t2.sid where t1.op6='Y' and t1.del='N' and stamp_file!=''");
	?>
	<p class="count"><span id="Mycnt">1</span> / <?=$booth_cnt?></p>
	
	<?
		$complete_stamp = $conn->getOne("select count(*) from booth_stamp where usid='".$_COOKIE['wmember_sid']."' and booth_sid='".$booth_sid."'");

		$query = "select t1.* from booth as t1 left join booth_grade as t2 on t1.booth_sid=t2.sid where t1.op6='Y' and t1.del='N' ";
		$query .= "order by t2.sort_num asc, t1.sort_num asc";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	?>
	<div class="bg" >

		<ul class="stamp scrollArea">
			<?
			$mycnt=0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
			if($d['stamp_file']){	
				$my_stamp = $conn->getOne("select count(*) from booth_stamp where usid='".$_COOKIE['wmember_sid']."' and booth_sid='".$d['sid']."'");
				if($my_stamp>0){
					$mycnt++;
				}
			?>
			<li <?if($my_stamp>0){?>class="visit"<?}?>>
			<a href="#"><img src="<?=$_Azure['link']?>upload/booth/<?=$d['stamp_file']?>" alt="Medtronic"></a>
			</li>
			<?}}?>
		</ul>
	</div>
	<div class="btn">
		<?if($complete_stamp>0){?>
			<a href="#" class="comp"><img src="/asset/layout/btnCompelted.png" alt="Copleted"></a>
		<?}else{?>
			<a href="#" class="visit"><img src="/asset/layout/btnVisit.png" alt="Visit Booth" onclick="document.stampF.submit();"></a>
		<?}?>
	</div>
</div>
<script>
	$(function(){
		$('#Mycnt').html("<?=$mycnt?>");
	})
</script>