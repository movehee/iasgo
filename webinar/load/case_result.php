<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>


<?
	if($_COOKIE['wmember_level']!='M'){
		$_Time['ing'] = time();
	}

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	
	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($exam_day-1), $ex_sdate[0]));
	
	$manager_query = "select * from exam_manager_tbl where day='$exam_day' and category='$category'";
	$manager_result = $conn->query($manager_query);
	$manager_result->fetchInto(&$manager,DB_FETCHMODE_ASSOC);
	$manager_result->free();

	
	if(!$exam_num) $exam_num=1;
	
	$query = "select * from exam_tbl where day='$exam_day' and exam_num='$exam_num' and category='$category' and del='N'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$my_result = $conn->getOne("select exam_answer from exam_result_each_tbl where usid='".$_COOKIE['wmember_sid']."' and exam_num='$exam_num' and kind='$category' and day='$exam_day'");
?>
<link rel="stylesheet" href="/script/timer/css/jquery.countdown.timer.css" type="text/css" />
<script src="/script/timer/js/jquery.timeout.interval.idle.js" type="text/javascript"></script> 
<script src="/script/timer/js/jquery.countdown.counter.js" type="text/javascript"></script> 
<script>
$(function(){
	
});

</script>
<div class="popupWrap" id="popupQuiz">
	<h1 class="bg"><?if($category=='A'){?>Case of the Day<?}else{?>Live Diagnosis Challenge<?}?> - Day <?=$exam_day?> (Question <?=$exam_num?>)</h1>
	<div class="popupCon" >
		<?

			//echo '타임 : '.date("Y.m.d H:i:s",$timechk).'<br>';
			//echo '문제번호 : '.$exam_num.'<br>';
			//echo '남은시간 : '.$timelimit.'<br>';		
		?>
		<form id="exam_eachF" name="exam_eachF" action="case_reg.php" method="post">
		<input type="hidden" name="Enum" id="Enum" value="<?=$d['exam_num']?>">
		<input type="hidden" name="Eday" id="Eday" value="<?=$exam_day?>">
		<input type="hidden" name="answer" id="answer" value="<?=$d['answer']?>">
		<input type="hidden" name="kind" id="kind" value="send">
		<input type="hidden" name="category" id="category" value="<?=$category?>">
		<div class="formArea scrollArea" id="exam_content" style="height:700px;">
			
			<fieldset>
				<legend></legend>
				<?=str_replace("../../",$_Azure['link'],$d['question'])?> 

				<dl class="quiz">
					<dt>What is your diagnosis? <?if($d['score']>0){?>(<?=$d['score']?> Point)<?}?></dt>
					<dd>
						<ul class="optionA">
						<?
						for($i=1;$i<=5;$i++){
							if(!$d['que'.$i]) continue;
						?>
							<?if(strlen($d['answer'])>1){?>
							<li <?if(eregi($i,$d['answer'])>0){?>class="correct"<?}else if(eregi($i,$my_result)>0 && !eregi($i,$d['answer'])){?>class="incorrect"<?}?>>
								<span class="inputC <?if(eregi($i,$my_result)>0){?>on<?}?>"><input type="checkbox" name="exam_answer[]" class="exam_answer" id="que<?=$i?>" value="<?=$i?>" <?if(eregi($i,$my_result)>0){?>checked<?}?>></span>
								<label for="que<?=$i?>"><?=$d['que'.$i]?><?if(eregi($i,$my_result)>0){?>&nbsp;&nbsp;&nbsp;[This is your selected answer.]<?}?></label>
							</li>
							<?}else{?>
							<li <?if($i==$d['answer']){?>class="correct"<?}else if($my_result==$i && $i!=$d['answer']){?>class="incorrect"<?}?>>
								<span class="inputR"><input type="radio" name="exam_answer" class="exam_answer" id="que<?=$i?>" value="<?=$i?>" <?if($my_result==$i){?>checked<?}?>></span>
								<label for="que<?=$i?>"><?=$d['que'.$i]?><?if($my_result==$i){?>&nbsp;&nbsp;&nbsp;[This is your selected answer.]<?}?></label>
							</li>
							<?}?>
						<?}?>
						</ul>
					</dd>
				</dl>
				<?
					$prev_sid = $conn->getOne("select exam_num from exam_tbl where exam_num='".($d['exam_num']-1)."' and day='$exam_day' and category='$category' and del='N' ");
					$next_sid = $conn->getOne("select exam_num from exam_tbl where exam_num='".($d['exam_num']+1)."' and day='$exam_day' and category='$category'  and del='N'");
				?>
			</fieldset>
			
			
		</div>
		
		<div class="btn btnArea">
			<?php if($category == "A"):?>
				<?php if(strtotime("2023-09-20 17:30:00") <= $_Time['ing']) :?>
					<input type="submit" value="Commentary" onclick="translate_open(1,'<?=$category?>'); return false;" class="btnDef btnBig">
				<?php endif;?>

				<?php if(strtotime("2023-09-21 17:30:00") <= $_Time['ing']) :?>
					<input type="submit" value="Commentary" onclick="translate_open(2,'<?=$category?>'); return false;" class="btnDef btnBig">
				<?php endif;?>

				<?php if(strtotime("2023-09-22 17:30:00") <= $_Time['ing']) :?>
					<input type="submit" value="Commentary" onclick="translate_open(3,'<?=$category?>'); return false;" class="btnDef btnBig">
				<?php endif;?>

				<?php if(strtotime("2023-09-23 17:30:00") <= $_Time['ing']) :?>
					<input type="submit" value="Commentary" onclick="translate_open(4,'<?=$category?>'); return false;" class="btnDef btnBig">
				<?php endif;?>

			<?php else:?>			
			
				<?if($exam_day=='1'){?>
					<?php if(strtotime("2023-09-20 15:50:00") <= $_Time['ing']) :?>
						<input type="submit" value="Commentary" onclick="translate_open(1,'<?=$category?>'); return false;" class="btnDef btnBig">
					<?php endif;?>
				<?}else if($exam_day=='2'){?>
					<?php if(strtotime("2023-09-21 14:00:00") <= $_Time['ing']) :?>
						<input type="submit" value="Commentary" onclick="translate_open(2,'<?=$category?>'); return false;" class="btnDef btnBig">
					<?php endif;?>
				<?}else if($exam_day=='3'){?>
					<?php if(strtotime("2023-09-22 14:00:00") <= $_Time['ing']) :?>
						<input type="submit" value="Commentary" onclick="translate_open(3,'<?=$category?>'); return false;" class="btnDef btnBig">
					<?php endif;?>
				<?}else if($exam_day=='4'){?>
					<?php if(strtotime("2023-09-23 14:00:00") <= $_Time['ing']) :?>
						<input type="submit" value="Commentary" onclick="translate_open(4,'<?=$category?>'); return false;" class="btnDef btnBig">
					<?php endif;?>
				<?}?>
			<?php endif;?>

			<?if($prev_sid){?><a href='case_result.php?exam_num=<?=$prev_sid?>&category=<?=$category?>&exam_day=<?=$exam_day?>' class="prev"><img src="/asset/quiz/quiz_prev.png" alt="Previous"></a><?}?>
			<?if($next_sid){?><a href='case_result.php?exam_num=<?=$next_sid?>&category=<?=$category?>&exam_day=<?=$exam_day?>' class="next"><img src="/asset/quiz/quiz_next.png" alt="Next"></a><?}?>
		</div>
	</div>
	</form>

	<div class="close"><a href="# return false;" class="color_close"></div>
</div>
		<!-- <div class="close"><a class="color_close"></a></div> -->
<script>
	function translate_open(str,cate){
	
		if(cate=='A'){
			//CASE
			alert('준비중');
			return false;
			window.open("<?=$_Azure['link']?>upload/download/KCR-Case of the Day.pdf","","width=900,height=900");			
		}else{
			//LIVE
			if(str=='1'){
				window.open("<?=$_Azure['link']?>upload/download/ldc1.pdf","","width=900,height=900");
			}else if(str=='2'){
				window.open("<?=$_Azure['link']?>upload/download/ldc2.pdf","","width=900,height=900");
			}else if(str=='3'){
				window.open("<?=$_Azure['link']?>upload/download/ldc3.pdf","","width=900,height=900");
			}else if(str=='4'){
				window.open("<?=$_Azure['link']?>upload/download/ldc4.pdf","","width=900,height=900");
			}else if(str=='5'){
				window.open("<?=$_Azure['link']?>upload/download/LDC_Day5일차.pdf","","width=900,height=900");
			}
		}
	}
</script>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>