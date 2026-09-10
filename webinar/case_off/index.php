<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<?	

	$query = "select * from exam_manager_tbl where day='$day' and category='A'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	$exam_start = "N";
	if(strtotime($d['sdate'])<=$_Time['ing']){ // && strtotime($d['edate'])>=$_Time['ing'] //종료일은 계산안하도록 수정
		$exam_start = "Y";	
	}

	$exam_cnt = $conn->getOne("select count(*) from exam_tbl where day='$day' and del='N'");
	
	unset($start_day1);
	unset($start_day2);
	unset($start_day3);
	unset($start_day4);

	if($exam_start=='Y' && $exam_cnt>0){
		${'start_day'.$day} = "Y";
	}
	
?>
<div class="contents">

     <h3 class="subTit">Case of the Day</h3>
         <p style="letter-spacing:-1px;">
        Case of the Day is a video quiz program open to all participants. The winners will be given a small prize.<br>
      * Case of the Day total Commentary Book will be available to check at My Page – <a href="#" style="color: #3f51b5;
         text-decoration: underline;">Download Center.</a>
         </p>
     
         <ul class="quiz">
     
        <?for($i=1;$i<=3;$i++){?>
     		<?
     			$event_times = $conn->getOne("select concat(substr(sdate,11,6),'-',substr(edate,11,6)) from exam_manager_tbl where day='$i' and category='A'");
     		?>
     		<li <?if($day>=$i){?>class="on"<?}?>>
            <a <?if(${"start_day".$i}=='Y' || $day>$i){?>href="/load/case_info.php?exam_day=<?=$i?>&category=A" class="Load_Base_R" Wsize="1105" Hsize="800" 
     			Tsize="20"<?}else{?>href="javascript:alert('This is not an ongoing event')"<?}?>>
                <span class="day"><?=$i?><sup><?if($i==1){?>st<?}else if($i==2){?>nd<?}else if($i==3){?>rd<?}else if($i==4){?>th<?}?></sup> Day</span>
                <?=$event_times?>
            </a>
        </li>
     		<?}?>
     	</ul>
 


    <?
		$query = "select * from exam_manager_tbl where day='$day' and category='B'";
		$result = $conn->query($query);
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();
		
		$exam_start = "N";

		// if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
		// 	$d['sdate'] = "2022-09-20 12:35";
		// }
		
		if(strtotime($d['sdate']."-10 minute")<=$_Time['ing']){ // && strtotime($d['edate'])>=$_Time['ing']
			$exam_start = "Y";	
		}
		
		$exam_cnt = $conn->getOne("select count(*) from exam_tbl where day='$day' and del='N'");
		
		unset($start_day1);
		unset($start_day2);
		unset($start_day3);
		unset($start_day4);

		if($exam_start=='Y' && $exam_cnt>0){
			${'start_day'.$day} = "Y";
		}

		
	?>

    <!-- <h3 class="subTit">Live Diagnosis Challenge</h3>
    <p style="letter-spacing:-1px;">
        Live Diagnosis Challenge is a quiz program where participants solve case quizzes submitted by participants themselves.<br>
       * Live Diagnosis Challenge total Commentary Book will be available to check at My Page – <a -href="https://virtual.aocr2022.org/mypage/index.php?kind=down" style="color: #3f51b5;
    text-decoration: underline;">Download Center.</a>

    </p>

    <ul class="quiz live">

        <?for($i=1;$i<=4;$i++){?>
		<?	
			$event_times = $conn->getOne("select concat(substr(sdate,11,6),'-',substr(edate,11,6)) from exam_manager_tbl where day='$i' and category='B'");
		?>
		<li <?if(${"start_day".$i}=='Y' || $day>$i){?>class="on"<?}?>>
			<a <?if(${"start_day".$i}=='Y' || $day>$i){?>href="/load/case_info.php?exam_day=<?=$i?>&category=B" class="Load_Base_R" Wsize="1105" Hsize="900" Tsize="20"<?}else{?>href="javascript:alert('This is not an ongoing event\nYou can enter from 10 minutes before.')"<?}?>>
			<span class="day"><?=$i?><sup><?if($i==1){?>st<?}else if($i==2){?>nd<?}else if($i==3){?>rd<?}else{?>th<?}?></sup> Day</span>
			<span class="time" data-time="<?=$event_times?>">
				<?if($i==1){?>9/20 (Wed)
                <?}else if($i==2){?>9/21 (Thu)
                <?}else if($i==3){?>9/22 (Fri)
                <?}else if($i==4){?>9/23 (Sat)
                <?}else{?>9/24 (Sat)<?}?>
			</span>

			<span class="quizTime"><span>Event Time:<?=$event_times?></span></span>
		</a></li>
		<?}?>

        
    </ul> -->

    
</div>
<?if($_COOKIE['offline']!='Y'){?>
<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>
<?}?>