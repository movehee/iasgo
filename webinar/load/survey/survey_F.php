
<script>
$(function() {
    $('#surveyForm').submit(function(){

        var chk_num = null;


        for(var i=1; i<=54; i++) {
            if( !$(":radio[name='answer"+i+"']:checked").length ) {
                chk_num = i;
                break;
            }
        }

        if(chk_num) {
			if($("#answer"+chk_num+"_1").length>0){
				alert("Please check all items.");
				$("#answer"+chk_num+"_1").focus();
				return false;
			}
        }



        var params = $("#surveyForm").serialize();

        jQuery.ajax({
            url: '/load/survey/survey_proc.php',
            type: 'POST',
            data:params,
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
            dataType: 'html',
            async: false,
            success: function (result) {
                var parse_data = JSON.parse(result);
                var status = parse_data.push;
                if(status=='O'){
                    alert("로그인이 끊겼습니다. 다시 로그인해주세요.");
                    location.href="/logout.php";
                }else if(status=='Y'){
                    alert("Your submission is complete.");
                    parent.$.colorbox.close();
                }
            }, error: function (request,status,error){
                alert('Error');
                return false;
            }
        });
        return false;
    });
});
</script>
<h1 class="bg">Survey</h1>
<div class="popupCon">
      <div class="note" style="padding: 10px;">
Please evaluate the congress using the KCR 2023 platform and mobile web. Your comments will 
contribute to improving the quality of the congress. <br>
Participate in the survey and seize the chance to get a prizes in the raffle!<br><br>

* Survey period: September 25(Mon) ~ November 1(Wed)   <br>
* The Prize-winner will be noticed after the survey participating period in person.<br>
<span style="font-size: 13px;"> (Amazon Coupon USD 100 (1 winner), Amazon Coupon USD 50 (3 winners), Amazon Coupon USD 10 (96 winners))</span>

</div> 
    <div class="formArea scrollArea">

        <form id="surveyForm" action="survey_proc.php" method="post">
            <input type="hidden" name="sid" value="<?=$d['sid']?>">
            <fieldset>
                <legend>Survey</legend>

                <h3 class="subTit">
                    Onsite Program
                </h3>

                <h4>
                    Onsite Program
                </h4>
                <table class="inputTbl ac">
                    <colgroup>
                        <col style="width: *;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                    </colgroup>
                    <thead>
					  <tr>
						<th>Question</th>
						<th>Excellent </th>
						<th>Good</th>
						<th>Fair</th>
						<th>Not Good </th>
						<th>Poor</th>
						<th>No Opinion<br> (or Did Not Use)</th>
					</tr>
                    </thead>
                    <tbody>
                        <?for($i=1; $i<=11; $i++){ ?>
                        <tr>
                            <td class="al"><?=$_SURVEY['question_m_'.$ccode][$i]?></td>
                            <?for($ii=1; $ii<=6; $ii++){ ?>
                                <td>
                                    <span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span>
                                </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>

                <h4>
                    Eco-friendly KCR
                </h4>
                <table class="inputTbl ac">
                    <colgroup>
                        <col style="width: *;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                    </colgroup>
                    <thead>
                         <tr>
                            <th>Question</th>
                            <th>Excellent </th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Not Good </th>
                            <th>Poor</th>
                            <th>No Opinion<br> (or Did Not Use)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=12; $i<=15; $i++){ ?>
                        <tr>
                            <td class="al"><?=$_SURVEY['question_m_'.$ccode][$i]?></td>
                            <?for($ii=1; $ii<=6; $ii++){ ?>
                                <td>
                                    <span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span>
                                </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>

                <h4>
                    Official Programs
                </h4>
                <table class="inputTbl ac">
                    <colgroup>
                        <col style="width: *;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                    </colgroup>
                    <thead>
                          <tr>
                            <th>Question</th>
                            <th>Excellent </th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Not Good </th>
                            <th>Poor</th>
                            <th>No Opinion<br> (or Did Not Use)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=16; $i<=20; $i++){ ?>
                        <tr>
                            <td class="al"><?=$_SURVEY['question_m_'.$ccode][$i]?></td>
                            <?for($ii=1; $ii<=6; $ii++){ ?>
                                <td>
                                    <span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span>
                                </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>

                <h4>
                    Technical Exhibition Hall
                </h4>
                <table class="inputTbl ac">
                    <colgroup>
                        <col style="width: *;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                    </colgroup>
                    <thead>
                          <tr>
                            <th>Question</th>
                            <th>Excellent </th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Not Good </th>
                            <th>Poor</th>
                            <th>No Opinion<br> (or Did Not Use)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=21; $i<=23; $i++){ ?>
                        <tr>
                            <td class="al"><?=$_SURVEY['question_m_'.$ccode][$i]?></td>
                            <?for($ii=1; $ii<=6; $ii++){ ?>
                                <td>
                                    <span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span>
                                </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>

                <h4>Comments</h4>
                <table class="inputTbl">
                    <?php $i = 1;?>
                    <thead>
                        <tr>
                            <th class="al"><label for=""><?=$_SURVEY['question_s_'.$ccode][$i]?></label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="al">										
                                <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>



                <h3 class="subTit">Virtual Platform Program</h3>

                <h4>Functional Operations</h4>
                <table class="inputTbl ac">
                    <colgroup>
                        <col style="width: *;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Excellent </th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Not Good </th>
                            <th>Poor</th>
                            <th>No Opinion<br> (or Did Not Use)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=24; $i<=27; $i++){ ?>
                        <tr>
                            <td class="al"><?=$_SURVEY['question_m_'.$ccode][$i]?></td>
                            <?for($ii=1; $ii<=6; $ii++){ ?>
                                <td>
                                    <span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span>
                                </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>

                <h4>KCR Quiz</h4>
                <table class="inputTbl ac">
                    <colgroup>
                        <col style="width: *;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                    </colgroup>
                    <thead>
                         <tr>
                            <th>Question</th>
                            <th>Excellent </th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Not Good </th>
                            <th>Poor</th>
                            <th>No Opinion<br> (or Did Not Use)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=28; $i<=31; $i++){ ?>
                        <tr>
                            <td class="al"><?=$_SURVEY['question_m_'.$ccode][$i]?></td>
                            <?for($ii=1; $ii<=6; $ii++){ ?>
                                <td>
                                    <span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span>
                                </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>

                <h4>Overall Satifaction</h4>
                <table class="inputTbl ac">
                    <colgroup>
                        <col style="width: *;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                    </colgroup>
                    <thead>
                         <tr>
                            <th>Question</th>
                            <th>Excellent </th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Not Good </th>
                            <th>Poor</th>
                            <th>No Opinion<br> (or Did Not Use)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=32; $i<=34; $i++){ ?>
                        <tr>
                            <td class="al"><?=$_SURVEY['question_m_'.$ccode][$i]?></td>
                            <?for($ii=1; $ii<=6; $ii++){ ?>
                                <td>
                                    <span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span>
                                </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>
				<h4>Comments</h4>
                <table class="inputTbl">
                    <?php $i = 2;?>
                    <thead>
                        <tr>
                            <th class="al"><label for=""><?=$_SURVEY['question_s_'.$ccode][$i]?></label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="al">										
                                <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
				
				<h3 class="subTit">Website (kcr4u.org)</h3>
                <h4>Overall Satisfaction</h4>
                <table class="inputTbl ac">
                    <colgroup>
                        <col style="width: *;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                        <col style="width: 9%;">
                    </colgroup>
                    <thead>
                          <tr>
                            <th>Question</th>
                            <th>Excellent </th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Not Good </th>
                            <th>Poor</th>
                            <th>No Opinion<br> (or Did Not Use)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=35; $i<=37; $i++){ ?>
                        <tr>
                            <td class="al"><?=$_SURVEY['question_m_'.$ccode][$i]?></td>
                            <?for($ii=1; $ii<=6; $ii++){ ?>
                                <td>
                                    <span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span>
                                </td>
                            <?}?>
                        </tr>
                        <?}?>
                    </tbody>
                </table>

               <h3 class="subTit">Overall Impressions and Suggestions for KCR 2023</h3>
                <h4>What impressed you during KCR 2023?</h4>
				<table class="inputTbl ac">
                    <?php $i = 3;?>
                    <thead>
                        <tr>
                            <th class="al" colspan="7"><label for=""><?=$_SURVEY['question_s_'.$ccode][$i]?></label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="al" colspan="7">										
                                <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                            </td>
                        </tr>
                    </tbody>
					<?php $i = 4;?>
                    <thead>
                        <tr>
                            <th class="al" colspan="7"><label for=""><?=$_SURVEY['question_s_'.$ccode][$i]?></label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="al" colspan="7">										
                                <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>




                <h3 class="subTit">Expectations for KCR 2024 (October 2 (Wed) –5 (Sat), 2024)</h3>

                <h4>KCR 2024</h4>
                <table class="inputTbl ac">
                    <tbody>
                        <?php $i = 5;?>
                        <thead>
                            <tr>
                                <th class="al"><label for=""><?=$_SURVEY['question_s_'.$ccode][$i]?></label></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="al">										
                                    <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                                </td>
                            </tr>
                        </tbody>
                        <?php $i = 6;?>
                        <thead>
                            <tr>
                                <th class="al"><label for=""><?=$_SURVEY['question_s_'.$ccode][$i]?></label></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="al">										
                                    <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                                </td>
                            </tr>
                        </tbody>
						<?php $i = 7;?>
                        <thead>
                            <tr>
                                <th class="al"><label for=""><?=$_SURVEY['question_s_'.$ccode][$i]?></label></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="al">										
                                    <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                                </td>
                            </tr>
                        </tbody>
						<?php $i = 8;?>
                        <thead>
                            <tr>
                                <th class="al"><label for=""><?=$_SURVEY['question_s_'.$ccode][$i]?></label></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="al">										
                                    <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </tbody>
                </table>

                
    </div>
<div class="btn btnArea">
                    <input type="submit" value="SUBMIT" class="btnBig">
                </div>
            </fieldset>
        </form>
    <?if($direct=='Y'){?>
		<div class="close"><a href="/enter/" class="color_close"></div>
	<?}else{?>
		<div class="close"><a href="# return false;" class="color_close"></div>
	<?}?>
</div>