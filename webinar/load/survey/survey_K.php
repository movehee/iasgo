
<script>
$(function() {
    $('#surveyForm').submit(function(){

        var chk_num = null;


        for(var i=1; i<=56; i++) {
            if( !$(":radio[name='answer"+i+"']:checked").length ) {
                chk_num = i;
                break;
            }
        }

        if(chk_num) {
			if($("#answer"+chk_num+"_1").length>0){
            alert("설문 항목을 선택해 주세요.");
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
   <div class="note">
KCR 2023 플랫폼 및 모바일 웹을 통해 학술대회 운영 전반에 대하여 평가를 요청드립니다.  여러분께서 내주신 의견은 다음 KCR 행사 진행에 도움이 됩니다.<br>
해당 설문조사에 참여하고, 상품 증정의 기회도 잡으세요! (추첨을 통해 상품 증정)<br> <br>

* 설문    참여    기간: 9월 25일(월요일) ~ 11월 1일(수) <br>
* (신세계   상품권   10만원   (1명), 신세계   상품권   5만원   (3명), 스타벅스    모바일   상품권   1만원   (96명))
</div> 
    <div class="formArea scrollArea">

        <form id="surveyForm" action="survey_proc.php" method="post">
            <input type="hidden" name="sid" value="<?=$d['sid']?>">
            <fieldset>
                <legend>Survey</legend>

                <h3 class="subTit">
                   대회   프로그램   만족도
                </h3>

                <h4>
                    학술대회 운영 만족도
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
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
                    Eco-friendly KCR 운영 만족도
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=15; $i<=18; $i++){ ?>
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
                    공식/사교 행사 및 대회 식음료 운영 만족도
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=19; $i<=23; $i++){ ?>
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
                    전시 참여 만족도
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=24; $i<=26; $i++){ ?>
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
                   현장 이벤트 만족도
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=28; $i<=30; $i++){ ?>
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


                <h4>기타</h4>
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



                <h3 class="subTit">Virtual Platform 프로그램 만족도</h3>

                <h4>Virtual Platform 기능 만족도</h4>
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=33; $i<=36; $i++){ ?>
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

                <h4>Quiz 만족도</h4>
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=37; $i<=40; $i++){ ?>
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

                <h4>온라인 플랫폼 전반 운영 만족도</h4>
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=41; $i<=43; $i++){ ?>
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

                <h4>Virtual Platform 관련 기타 의견이 있으실 경우, 말씀해 주시기 바랍니다</h4>
                <table class="inputTbl">
                    <?php $i = 2;?>
                    <tbody>
                        <tr>
                            <td class="al">										
                                <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <h3 class="subTit">공식 홈페이지(kcr4u.org) 서비스 만족도</h3>

                <h4>KCR 2023 공식 홈페이지 서비스 만족도</h4>
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
                            <th>내용</th>
                            <th>매우<br>만족</th>
                            <th>만족</th>
                            <th>보통</th>
                            <th>불만족</th>
                            <th>매우<br>불만족</th>
                            <th>모르겠다<span>(참석/이용 안함)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?for($i=44; $i<=45; $i++){ ?>
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
				
				<h4>공식 홈페이지 관련 기타 의견이 있으실 경우, 말씀해 주시기 바랍니다</h4>
				<table class="inputTbl ac">
                    <?php $i = 3;?>
                    <tbody>
                        <tr>
                            <td class="al" >										
                                <textarea name="memo<?=$i?>" id="memo<?=$i?>" cols="30" rows="10"><?=$d['memo'.$i]?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>




                <h3 class="subTit">KCR 2023 기타 만족도</h3>

                <h4>KCR 2023 기타 만족도</h4>
                <table class="inputTbl ac">
                    <tbody>
                        <?php $i = 4;?>
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
                    </tbody>
                </table>



                <h3 class="subTit">KCR 2024 설문조사 (개최일: 2024년 10월 02일(수) - 10월 05일(토))</h3>

                <h4>KCR 2024에 대한 의견 조사</h4>
                <table class="inputTbl ac">
                    <tbody>
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
					<?php $i = 9;?>
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


				
				<!-- <h4>KCR 2023 개최 방식에 대한 의견 조사</h4>
				<div class="noti">*비고: 온라인 평점 인정은 대한의사협회에서 내년도 평점 인정에 대해 아직 결정되지 않았음을 참고 부탁드립니다.</div>
				<table class="tblDef">
					<colgroup>
						<col style="width: 20%;">
						<col style="width: 20%;">
						<col style="width: 20%;">
						<col style="width: 20%;">
						<col style="width: 20%;">
					</colgroup>
					<thead>
						<tr>
							<th rowspan="2">구분<br>  (대한의사협회에서 온라인<br> 평점을 인정하는 경우)</th>
							<th rowspan="2">비용 (%)</th>
							<th colspan="3">제공 서비스</th>
						</tr>
						<tr>
							<th class="bdLeft">VOD(다시보기) 운영</th>
							<th>Live 온라인 송출</th>
							<th>온라인 평점 인정</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>옵션1</th>
							<td>100%</td>
							<td>(전체룸운영)</td>
							<td>X</td>
							<td>X</td>
						</tr>
						<tr>
							<th>옵션2</th>
							<td>195%</td>
							<td>(전체룸운영)</td>
							<td>(1층 중 3개룸 운영)</td>
							<td>O</td>
						</tr>
						<tr>
							<th>옵션3</th>
							<td>285%</td>
							<td>(전체룸운영)</td>
							<td>(1층 5개룸 전체 운영)</td>
							<td>O</td>
						</tr>
						<tr>
							<th>옵션4</th>
							<td>353%</td>
							<td>(전체룸운영)</td>
							<td>(전체 8개룸 운영)</td>
							<td>O</td>
						</tr>
					</tbody>
				</table>
				
				<dl class="survey">
					<dt class="tm20">대한의사협회에서 온라인 평점을 인정하는 경우 (위 표 참고)</dt>
					<dd>
						<? $i = 55; ?>
						<?for($ii=1; $ii<=4; $ii++){ ?>							
							<span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span><label for="answer<?=$i?>_<?=$ii?>">옵션 <?=$ii?></label>
						<?}?>
					</dd>
				</dl>

				<table class="tblDef">
					<colgroup>
						<col style="width: 20%;">
						<col style="width: 20%;">
						<col style="width: 20%;">
						<col style="width: 20%;">
						<col style="width: 20%;">
					</colgroup>
					<thead>
						<tr>
							<th rowspan="2">구분<br>(대한의사협회에서 온라인<br> 평점을 인정하지 않을 경우)</th>
							<th rowspan="2">비용 (%)</th>
							<th colspan="3">제공 서비스</th>
						</tr>
						<tr>
							<th class="bdLeft">VOD(다시보기) 운영</th>
							<th>Live 온라인 송출</th>
							<th>온라인 평점 인정</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>옵션1</th>
							<td>100%</td>
							<td>(전체룸운영)</td>
							<td>X</td>
							<td>X</td>
						</tr>
						<tr>
							<th>옵션2</th>
							<td>187%</td>
							<td>(전체룸운영)</td>
							<td>(1층 중 3개룸 운영)</td>
							<td>X</td>
						</tr>
						<tr>
							<th>옵션3</th>
							<td>245%</td>
							<td>(전체룸운영)</td>
							<td>(1층 5개룸 전체 운영)</td>
							<td>X</td>
						</tr>
						<tr>
							<th>옵션4</th>
							<td>332%</td>
							<td>(전체룸운영)</td>
							<td>(전체 8개룸 운영)</td>
							<td>X</td>
						</tr>
					</tbody>
				</table>
				<dl class="survey">
					<dt class="tm20">대한의사협회에서 온라인 평점을 인정하지 않을 경우 (위 표 참고)</dt>
					<dd>
						<? $i = 56; ?>
						<?for($ii=1; $ii<=4; $ii++){ ?>							
							<span class="inputR<?if($d['answer'.$i]==$ii){?> on<?}?>"><input type="radio" name="answer<?=$i?>" id="answer<?=$i?>_<?=$ii?>" value="<?=$ii?>" <?if($d['answer'.$i]==$ii){?>checked<?}?>></span><label for="answer<?=$i?>_<?=$ii?>">옵션 <?=$ii?></label>
						<?}?>
					</dd>
				</dl>
 -->



               
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