<?include "./../header2.php";

$delay = 5;
$type = 1;
$ui = 1;
$d = null;
if(!empty($sid))
{
	$query="SELECT * FROM voting_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
	$delay = $d['delay'];
	$type = $d['type'];
	$ui = $d['ui'];
}
else {
	$d['start_type'] = 1;
}
?>

<div id="container">
	<h2>Voting 등록</h2>
	<div class="contents">
			

	
		<form enctype="multipart/form-data" name="registform" id="registform" action="./voting_post.php" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
		<?if(!empty($sid)){?>
		<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
		<?}?>
		<input type="hidden" name="lecture" id="lecture" value="<?=$lecture?>" /><br /> 
			<fieldset>
				<legend>Voting 등록</legend>
				<table class="inputTbl">
					<colgroup>
							<col style="width: 10%;">
							<col style="width: *%;">
						</colgroup>
					<tbody>
						<tr>
							<th><label for="" class="tooltipPoint" title="보팅 질문영역">질문</label></th>
							<td><input style="width:900px" type="text" name="question" id="question"  value="<?=$d['question']?>" /></td>
						</tr>

						<tr>
							<th><label for="" class="tooltipPoint" title="질문부분에 이미지가 보여질 경우 등록한다">질문이미지</label></th>
							<td><input style="width:205px" type="file" name="image" id="image"  value="<?=$d['image']?>" />
							<?if($d['image']){?>
							<a class="inputBtndel" onclick="javascript:del_file('image','<?=$d['sid']?>')">파일삭제</a><?}?>
									
									</td>
						</tr>

						<tr>
							<th><label for="" class="tooltipPoint" title="보팅시작했을때">시작 설정</label></th>
							<td class="multi">
								<input type="radio" name="start_type" id="start_type1" value="1" <?if($d['start_type']=='1'){?>checked<?}?> >
								<label for="start_type1">시간 카운트</label>
								<select name="delay" id="delay"  style="width: auto;">
								<? foreach($config['delay'] as $tkey=>$tval){?>
									<option <?if($delay==$tkey){?>selected<?}?> value="<?=$tkey?>"><?=$tval?></option>
								<?}?>
								</select>


								<input type="radio" name="start_type" id="start_type2" value="2" <?if($d['start_type']=='2'){?>checked<?}?> >
								<label for="start_type2">안내멘트</label>
								<input type="text" name="start_txt" id="start_txt" value="<?=$d['start_txt']?>" maxlength="8">
							</td>
						</tr>

						<tr>
							<th><label for="" class="tooltipPoint" title="">UI타입</label></th>
							<td class="multi"><input type="radio" id="ui1" name="ui" value="1" <?if($ui=='1'){?>checked<?}?>/><label for="">1열 <img src="/admin/image/icon_uiType_01.png" alt=""></label><input type="radio" id="ui2" name="ui" value="2" <?if($ui=='2'){?>checked<?}?>/><label for="">2열 <img src="/admin/image/icon_uiType_02.png" alt=""></label><input type="radio" id="ui3" name="ui" value="3" <?if($ui=='3'){?>checked<?}?>/><label for="">3열 <img src="/admin/image/icon_uiType_03.png" alt=""></label></td>
						</tr>

						<tr>
							<th><label for="" class="tooltipPoint" title="보팅 사용자 앱에 보여질 ui타입/default는 1열">보팅타입</label></th>
							<td class="multi"><input type="radio" id="type1" name="type" value="1" <?if($type=='1'){?>checked<?}?>/><label for="type1">VOTING(기본)</label><!--<input type="radio" id="type2" name="type"  value="2" <?if($d['type']=='2'){?>checked<?}?>/><label for="">순위</label><input type="radio" id="type3" name="type"  value="3" <?if($d['type']=='3'){?>checked<?}?>/><label for="">비교</label>--></td>
							
						</tr>

						<tr>
							<th ><label for="" class="tooltipPoint" title="문항 입력 부분 6번까지 가능/보기에 이미지가 들어갈 경우 이미지 등록/문항옆 체크박스는 정답 체크부분 / 정답 체크 할 경우 보팅 결과보기에 정답이 표시된다">보기<br/><span style="font-weight:normal">보팅문항 옆 체크박스 선택 시 결과보기에 정답 표시 됨</span></label></th>
							<td>
								<div>1 : 
								<input style="width:400px" type="text" name="answer1" id="answer1"  value="<?=$d['answer1']?>" placeholder="보기 문구를 입력해주세요"/>
								<input type="checkbox" id="correct1" name="correct" value="1" <?if($d['correct']=='1'){?>checked<?}?>/>
								<input style="width:200px" type="file" name="answer1_img" id="answer1_img"  value="<?=$d['answer1_img']?>" />
								<?if($d['answer1_img']){?>
								<a class="inputBtndel" onclick="javascript:del_file('answer1_img','<?=$d['sid']?>')">파일삭제</a><?}?>
								</div>

								<div>2 : 
								<input style="width:400px" type="text" name="answer2" id="answer2"  value="<?=$d['answer2']?>" placeholder="보기 문구를 입력해주세요"/>
								<input type="checkbox" id="correct2" name="correct" value="2"  <?if($d['correct']=='2'){?>checked<?}?>/>
								<input style="width:200px" type="file" name="answer2_img" id="answer2_img"  value="<?=$d['answer2_img']?>" />
								<?if($d['answer2_img']){?>
								<a class="inputBtndel" onclick="javascript:del_file('answer2_img','<?=$d['sid']?>')">파일삭제</a><?}?>
								</div>

								<div>3 : 
								<input style="width:400px" type="text" name="answer3" id="answer3"  value="<?=$d['answer3']?>" placeholder="보기 문구를 입력해주세요"/>
								<input type="checkbox" id="correct3" name="correct" value="3"  <?if($d['correct']=='3'){?>checked<?}?>/>
								<input style="width:200px" type="file" name="answer3_img" id="answer3_img"  value="<?=$d['answer3_img']?>" />
								<?if($d['answer3_img']){?>
								<a class="inputBtndel" onclick="javascript:del_file('answer3_img','<?=$d['sid']?>')">파일삭제</a><?}?>
								</div>

								<div>4 : 
								<input style="width:400px" type="text" name="answer4" id="answer4"  value="<?=$d['answer4']?>" placeholder="보기 문구를 입력해주세요"/>
								<input type="checkbox" id="correct4" name="correct" value="4"  <?if($d['correct']=='4'){?>checked<?}?>/>
								<input style="width:200px" type="file" name="answer4_img" id="answer4_img"  value="<?=$d['answer4_img']?>" />
								<?if($d['answer4_img']){?>
								<a class="inputBtndel" onclick="javascript:del_file('answer4_img','<?=$d['sid']?>')">파일삭제</a><?}?>
								</div>

								<div>5 : 
								<input style="width:400px" type="text" name="answer5" id="answer5"  value="<?=$d['answer5']?>" placeholder="보기 문구를 입력해주세요"/>
								<input type="checkbox" id="correct5" name="correct"  value="5" <?if($d['correct']=='5'){?>checked<?}?>/>
								<input style="width:200px" type="file" name="answer5_img" id="answer5_img"  value="<?=$d['answer5_img']?>" />
								<?if($d['answer5_img']){?>
								<a class="inputBtndel" onclick="javascript:del_file('answer5_img','<?=$d['sid']?>')">파일삭제</a><?}?>
								</div>

								<div>6 : 
								<input style="width:400px" type="text" name="answer6" id="answer6"  value="<?=$d['answer6']?>" placeholder="보기 문구를 입력해주세요"/>
								<input type="checkbox" id="correct6" name="correct"  value="6" <?if($d['correct']=='6'){?>checked<?}?>/>
								<input style="width:200px" type="file" name="answer6_img" id="answer6_img"  value="<?=$d['answer6_img']?>" />
								<?if($d['answer6_img']){?>
								<a class="inputBtndel" onclick="javascript:del_file('answer6_img','<?=$d['sid']?>')">파일삭제</a><?}?>
								</div>

								<div>7 : 
								<input style="width:400px" type="text" name="answer7" id="answer7"  value="<?=$d['answer7']?>" placeholder="보기 문구를 입력해주세요"/>
								<input type="checkbox" id="correct7" name="correct"  value="6" <?if($d['correct']=='7'){?>checked<?}?>/>
								<input style="width:200px" type="file" name="answer7_img" id="answer7_img"  value="<?=$d['answer7_img']?>" />
								<?if($d['answer7_img']){?>
								<a class="inputBtndel" onclick="javascript:del_file('answer7_img','<?=$d['sid']?>')">파일삭제</a><?}?>
								</div>


								<div>8 : 
								<input style="width:400px" type="text" name="answer8" id="answer8"  value="<?=$d['answer8']?>" placeholder="보기 문구를 입력해주세요"/>
								<input type="checkbox" id="correct8" name="correct"  value="8" <?if($d['correct']=='8'){?>checked<?}?>/>
								<input style="width:200px" type="file" name="answer8_img" id="answer8_img"  value="<?=$d['answer8_img']?>" />
								<?if($d['answer8_img']){?>
								<a class="inputBtndel" onclick="javascript:del_file('answer8_img','<?=$d['sid']?>')">파일삭제</a><?}?>
								</div>



							
							</td>
						</tr>

					</tbody>
				</table>

			
				<div class="btnArea btn">
					
					<input type="submit" value="저장" class="btnDef btnBig" />
					<input type="reset" onclick="window.close()" value="취소" class="btnGrey btnBig" />
				</div>
			</fieldset>
		</form>

	</div>
	<!--  //conArea -->

</div>	


	
<script type="text/javascript">

	$( function(){
		$('#eventdate').datepicker({dateFormat:"yy-mm-dd"});
	});

	function del_file(val,sid) {
		if(confirm("삭제하시겠습니까?")){
	
			$.ajax({
				type:"POST",
				url:"./del_file.php",
				data:"sid="+sid+"&val="+val,
				success:function(msg){
					alert(msg);
				}
			});


		}
	}


</script>
<?include "./../footer.php";?>