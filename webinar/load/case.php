<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>

<?
	//$exam_day = 2;
	if(!$exam_day) $exam_day = $day;
	
	$_Time['ing'] = time();

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	
	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($exam_day-1), $ex_sdate[0]));
	
	$manager_query = "select * from exam_manager_tbl where day='$exam_day' and category='$category'";
	$manager_result = $conn->query($manager_query);
	$manager_result->fetchInto(&$manager,DB_FETCHMODE_ASSOC);
	$manager_result->free();
	//echo $manager_query;

     if($_SERVER['REMOTE_ADDR']=='218.235.94.212') {
	 	//$manager['sdate'] = "2023-09-15 10:00";   //테스트기준 현재시간
	 }

	 //$manager['sdate'] = "2023-09-15 13:00";
	 //$manager['edate'] = "2023-09-15 22:29";

	$timelimit = $manager['time_limit']; //제한시간
	//echo $timelimit;
	//echo $manager['time_limit'];

	$Tnum = $conn->getOne("select count(*) from exam_tbl where day='".$exam_day."' and category='$category' and del='N'"); //총 문제수
	$my_max = $conn->getOne("select count(*) from exam_result_each_tbl where day='".$exam_day."' and usid='".$_COOKIE['wmember_sid']."' and kind='$category'"); //내가 푼 마지막 문제번호
	
	if($Tnum<=$my_max){ //문제 다 푼 상태면...
		PutLocation("case_end.php?exam_day=".$exam_day."&category=".$category);
	}else{
		if(!$exam_num && $category=='A') $exam_num = $my_max+1;
	}

	//$manager['sdate'] = "2021-08-28 17:20"; //시험 시작시간을 강제로 지정함.
	
	if(!$exam_num) $exam_num=1;
    
	if($category=='B'){
		$time_query = "select * from exam_tbl where day='$exam_day' and category='$category' and del='N' order by exam_num asc";
		
		$time_result=$conn->query($time_query);
		if(DB::isError($time_result)) die($time_result->getMessage());
		while(is_array($t=$time_result->fetchRow(DB_FETCHMODE_ASSOC))){
			$timechk = strtotime($manager['sdate']."+ ".($timelimit*$t['exam_num'])." seconds");
			
			//echo date("Y.m.d H:i:s",$timechk).'<br>';
			if($_Time['ing']<$timechk){
				$exam_num = $t['exam_num']; 
				$timelimit = $timechk-$_Time['ing'];
				break;
			}
		}
	}
	
	//echo date("Y.m.d H:i:s",$_Time['ing']);
	// $timelimit = 5; //테스트
    
	$query = "select * from exam_tbl where day='$exam_day' and exam_num='$exam_num' and category='$category' and del='N'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	
	$my_result = $conn->getOne("select exam_answer from exam_result_each_tbl where usid='".$_COOKIE['wmember_sid']."' and exam_num='$exam_num' and kind='$category' and day='$exam_day'");
	
?>

<script>
	var timelimit = "<?=$timelimit?>";
</script>
<link rel="stylesheet" href="/script/timer/css/jquery.countdown.timer.css" type="text/css" />
<script src="/script/timer/js/jquery.timeout.interval.idle.js" type="text/javascript"></script> 
<script src="/script/timer/js/jquery.countdown.counter.js" type="text/javascript"></script> 
<script>
$(function(){
	
});
</script>

    <div class="popupWrap" id="popupQuiz">
        <h1 class="bg"><?if($category=='A'){?>Case of the Day<?}else{?>Live Diagnosis Challenge<?}?> - day <?=$exam_day?> (Question <?=$exam_num?>)</h1>

        
        
		<div class="popupCon">


			<div class="formArea scrollArea">
                <form id="exam_eachF" name="exam_eachF" action="case_reg.php" method="post">
                    <input type="hidden" name="Enum" id="Enum" value="<?=$d['exam_num']?>">
                    <input type="hidden" name="Eday" id="Eday" value="<?=$exam_day?>">
                    <input type="hidden" name="answer" id="answer" value="<?=$d['answer']?>">
                    <input type="hidden" name="kind" id="kind" value="send">
                    <input type="hidden" name="category" id="category" value="<?=$category?>">
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
                                        <li>
                                            <span class="inputC <?if(eregi($i,$my_result)>0){?>on<?}?>"><input type="checkbox" name="exam_answer[]" class="exam_answer" id="que<?=$i?>" value="<?=$i?>" <?if(eregi($i,$my_result)>0){?>checked<?}?>></span>
                                            <label for="que<?=$i?>"><?=$d['que'.$i]?></label>
                                        </li>
                                        <?}else{?>
                                        <li>
                                            <span class="inputR <?if($my_result==$i){?>on<?}?>"><input type="radio" name="exam_answer" class="exam_answer" id="que<?=$i?>" value="<?=$i?>" <?if($my_result==$i){?>checked<?}?>></span>
                                            <label for="que<?=$i?>"><?=$d['que'.$i]?></label>
                                        </li>
                                        <?}?>
                                    <?}?>
                                </ul>
							</dd>
						</dl>

                        <?if($category=='B'){?>
                        <div id="answer_fin" class="ac" style="padding: 15px 10px;;font-size:20px;font-weight:bold;color:navy;display:<?if(!$my_result){?>none<?}?>;">Your answer submission is complete.<br />Please wait until the next question.</div>
                        <?}?>
                        <?
                            $btn_txt = "Submit Answer";
                            if($Tnum==$d['exam_num']){
                                $btn_txt = "Submit Answer";
                            }
                            if($category=='B'){
                                if($my_result){
                                    $btn_txt = "Change Answer";
                                }
                            }
                            if($category=='A'){
                                $prev_sid = $conn->getOne("select exam_num from exam_tbl where exam_num='".($d['exam_num']-1)."' and day='$exam_day' and category='$category' and del='N' ");
                                $next_sid = $conn->getOne("select exam_num from exam_tbl where exam_num='".($d['exam_num']+1)."' and day='$exam_day' and category='$category'  and del='N'");
                            }
                        ?>

						<div class="btn btnArea">

                            <?if($category=='A'){?>
                                <input type="submit" value="<?=$btn_txt?>" class="btnDef btnBig">
                                <?if($prev_sid){?><a href='case.php?exam_num=<?=$prev_sid?>&category=A&exam_day=<?=$exam_day?>' class="prev"><img src="/asset/quiz/quiz_prev.png" alt="Previous"></a><?}?>
							    <?if($next_sid){?><a href='case.php?exam_num=<?=$next_sid?>&category=A&exam_day=<?=$exam_day?>' class="next"><img src="/asset/quiz/quiz_next.png" alt="Next"></a><?}?>
                            <?}else{?>
                                <input type="submit" id="btn_txt" value="<?=$btn_txt?>" class="btnDef btnBig">
                            <?}?>
							
						</div>

					</fieldset>
				</form>
			</div>



            <?if($category=='B'){?>
            <div class="timeRemain">Time remaining : <!-- <span>15 sec</span> -->
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
            <?}?>
		</div>
        
        <div class="close"><a href="# return false;" class="color_close"></div>
	</div>
	<!-- //popupWrap -->

    <script>
        CounterInit(timelimit); //타이머
        var Enum = "<?=$exam_num?>";
        var Exam_day = "<?=$exam_day?>";
        var category = "<?=$category?>";
        function next_exam(){
            if(category=='B'){
                $.ajax({
                    type:"POST",
                    url:"/load/case_reg.php",
                    data:"Enum="+Enum+"&Eday="+Exam_day+"&kind=pass&category="+category,
                    async:false,
                    success:function(msg){
                        var parse_data = JSON.parse(msg);
                        if(parse_data.push=='P'){
                            var Next_Num = parse_data.exam_num;
                            if(Next_Num!='N'){
                                //alert("Timeout and move on to the next question"+Next_Num);
                                location.href="case.php?exam_num="+Next_Num+"&exam_day="+Exam_day+"&category="+category;
                            }else{
                                alert("completed the Live Diagnosis Challenge");
                                parent.$.colorbox.close();
                                //return false;
                            }
                        }
                    }
                });
            }

        }

        $(function(){
            $('.color_close').on('click',function(){ //강제종료
                parent.$.colorbox.close();
                //$('#exam_content').hide();
                if(category=='B'){
                    setTimeout( function () {
                        /*if(confirm("종료하시는 경우 현재문제는 더이상 진행이 불가능합니다. 그래도 종료하시겠습니까?")){
                            $.ajax({
                                type:"POST",
                                url:"/load/case_reg.php",
                                data:"Enum="+Enum+"&Eday="+Exam_day+"&kind=end&category="+category,
                                async:false,
                                success:function(msg){
                                    var parse_data = JSON.parse(msg);
                                    if(parse_data.push=='E'){
                                        parent.$.colorbox.close();
                                    }
                                }
                            });
                        }else{
                            $('#exam_content').show();
                        }*/
                        
                    },200)
                }else{
                    parent.$.colorbox.close();
                }
            });

            $('#exam_eachF').submit(function(){
                
                if($('.exam_answer').is(':checked')==false){
                    alert("Please select an answer");
                    return false;
                }
                if($('#answer').val().length>1){
                    if($('.exam_answer:checked').length<2){
                        alert("Questions with more than one answer. Please select one or more correct answers");
                        return false;
                    }
                }
                
                var params = $("#exam_eachF").serialize();
                jQuery.ajax({
                    url: '/load/case_reg.php',
                    type: 'POST',
                    data:params,
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
                    dataType: 'html',
                    async: false,
                    success: function (result) {
                        
                        var parse_data = JSON.parse(result);
                        var Next_Num = parse_data.exam_num;
                        console.log(Next_Num);
                        if(Next_Num=='N'){
                            //location.href="case_end.php?exam_day="+Exam_day+"&category="+category;
                            location.href="case_info.php?exam_day="+Exam_day+"&category="+category;
                        }else{
                            if(category=='A'){
                                location.href="case.php?exam_num="+Next_Num+"&exam_day="+Exam_day+"&category="+category;
                            }else{
                                $('#btn_txt').val("Change Answer");
                                $('#answer_fin').show();
                            }
                        }
                    }, error: function (request,status,error){
                        alert('');
                        return false;
                    }
                });
                return false;

            });

            $(":radio").on("click", function() {
                $(this).closest("ul.optionA").find("span").removeClass("on");
                $(this).closest("span").addClass("on");
            });

            $(":checkbox").on("click", function() {
                if($(this).is(':checked')==true){
                    $(this).closest("span").addClass("on");
                }else{
                    $(this).closest("span").removeClass("on");
                }
                
            });
        });
        </script>
    <?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>