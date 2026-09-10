<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
	//$exam_day = 2;
	//$day = 2;
		
	if(!$exam_day) $exam_day = $day;

	$_Time['ing'] = time();

	$total_cnt = $conn->getOne("select count(*) from exam_tbl where category='".$category."' and day='".$exam_day."' and del='N'");

	$query = "select * from exam_manager_tbl where day='$exam_day' and category='$category'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	 if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	 	//$d['sdate'] = "2022-08-18 14:25";
	 }
	//$d['edate'] = "2023-09-21 18:00";
	
	//$d['sdate'] = "2023-09-15 10:00";
	//$d['edate'] = "2023-09-15 22:29";


	$Tnum = $conn->getOne("select count(*) from exam_tbl where day='".$exam_day."' and category='$category' and del='N'"); //총 문제수
	$my_max = $conn->getOne("select count(*) from exam_result_each_tbl where day='".$exam_day."' and usid='".$_COOKIE['wmember_sid']."' and kind='$category'"); //내가 푼 마지막 문제번호
	

	if($my_max>0){ //문제를 푼게 있고, 시험 시간이 종료된 이후 결과 페이지로 이동함.
		if(strtotime($d['edate'])<$_Time['ing']){
			PutLocation("case_result.php?exam_day=".$exam_day."&category=".$category);
			exit;
		}
	}
	
	if($Tnum<=$my_max){ //문제 다 푼 상태면...
		PutLocation("case_end.php?exam_day=".$exam_day."&category=".$category);
		exit;
	}


	$time_limit = $d['time_limit'];
	
	if(strtotime($d['sdate']."-10 minute")<=$_Time['ing'] && strtotime($d['edate'])>=$_Time['ing']){
		$exam_start = "Y";	
	}
	

	if(strtotime($d['sdate'])>$_Time['ing']){
		$ready_time = strtotime($d['sdate'])-$_Time['ing'];
	}	
	
	
?>
<script>
	var timelimit = "<?=$ready_time?>";
	var exam_day = "<?=$exam_day?>";
	var category = "<?=$category?>";
</script>
<link rel="stylesheet" href="/script/timer/css/jquery.countdown.timer.css" type="text/css" />
<script src="/script/timer/js/jquery.timeout.interval.idle.js?v=<?=rand(1,99999)?>" type="text/javascript"></script> 
<script src="/script/timer/js/jquery.countdown.counter.js?v=<?=rand(1,99999)?>" type="text/javascript"></script> 


<div class="popupWrap" id="popupQuiz">
	<h1 class="bg"><?if($category=='A'){?>Case of the Day<?}else{?>Live Diagnosis Challenge<?}?> - Day <?=$exam_day?></h1>
    

	<div class="popupCon" >
		<?if($category=='A'){?>

            <div class="quizIntro">
                There are <mark>5 questions</mark> in Case of the Day<br>
                Once you solve all the questions and submit it, <mark>you can not revise your answers.</mark><br>
                You can modify your answers several times while solving the questions.<br>
                The results will release <mark>after 19:00</mark><br>

                <?if($my_max>0){?>
                <p class="fcRed" style="font-size:20px;">Please solve them all</p>
                <center>
                <table class="ac">
                    <tr>
                        <?for($i=1;$i<=$Tnum;$i++){?>
                        <?
                            $mychk = $conn->getOne("select count(*) from exam_result_each_tbl where day='".$exam_day."' and usid='".$_COOKIE['wmember_sid']."' and kind='$category' and exam_num='$i'");
                        ?>
                        <td style="cursor:pointer;padding:20px;width:50px;border:1px solid #252731;background:<?if($mychk>0){?>#EBF3FA<?}else{?>#F9E6FA<?}?>" onclick="location.href='/load/case.php?exam_day=<?=$exam_day?>&category=<?=$category?>&exam_num=<?=$i?>'"><?=$i?></td>
                        <?}?>
                    </tr>
                </table>
                </center>
                <?}?>
                <?if(strtotime($d['edate'])>$_Time['ing']){?>
                    <div class="btnArea btn"><a href="# return false;" class="btnDef" onclick="location.href='/load/case.php?exam_day=<?=$exam_day?>&category=<?=$category?>'">START</a></div>	
                <?}else{?>
                    <mark>END</mark>
                <?}?>
            </div>

		

		<?}else if($category=='B'){?>
		<div class="quizIntro">
            <p>
                Live Diagnosis Challenge consists of a total of <?=$exam_day==5?'11':'13'?> questions.<br>
                <mark>You have 90 seconds to solve each questions.</mark><br>
                You cannot solve a problem that you already solved again.
            </p>
            <p class="bg">
                You can solve the quizzes only at <?=substr($d['sdate'],10,6)."-".substr($d['edate'],10,6)?> in Korean time.<br>
                If you start midway through the challenge, the previous questions<br>
                will be counted as being incorrect.
            </p>
            <p>Winners will be announced after 19:00 (Korea time).</p>

			<?if($ready_time>0){?>
            
                <div class="timeRemain">Time left until quiz <!--<span>6:50</span>-->

                    <span>
						<div id="counter_item1" class="counter_item">
							<div class="front"></div>
							<div class="digit digit0"></div>
						</div>
						<div id="counter_item2" class="counter_item">
							<div class="front"></div>
							<div class="digit digit0"></div>
						</div>
						<div id="counter_item3" class="counter_item">
							<div class="front"></div>
							<div class="digit digit_colon"></div>
						</div>
						<div id="counter_item4" class="counter_item">
							<div class="front"></div>
							<div class="digit digit0"></div>
						</div>
						<div id="counter_item5" class="counter_item">
							<div class="front"></div>
							<div class="digit digit0"></div>
						</div>
					</span>
            
                </div>

				
			<?}else{?>
					
				<?if(strtotime($d['edate'])>$_Time['ing']){?>
                    <div class="btnArea btn"><a href="# return false;" class="btnDef" onclick="location.href='/load/case.php?exam_day=<?=$exam_day?>&category=<?=$category?>'">START</a></div>	
				<?}else{?>
					<mark>END</mark>
				<?}?>
			<?}?>
		</div>
		<?}?>


	</div>
	<div class="close"><a href="# return false;" class="color_close"></div>
</div>
<?if($ready_time>0){?>
<script>
CounterInit(timelimit); //타이머
function next_exam(){
	location.href="/load/case.php?exam_day="+exam_day+"&category="+category;
}
</script>
<?}?>
<script>
$(function(){
	$('.color_close').on('click',function(){ //강제종료
		parent.$.colorbox.close();
	});
});
</script>