<?include "./../header2.php";

$d = null;
if(!empty($sid))
{
	$query="SELECT * FROM feedback_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
	if(empty($type))
		$type = $d['type'];
}else {
	$sid="";
}
if(empty($type))
	$type="0";

?>

<div id="container" style="width:700px">
<div class="contents" style="width:700px">
			<h2>Feedback 등록</h2>

			<div class="conArea" style="width:700px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
				<?}?>
						
					<fieldset>
					
						<table class="inputTbl" style="width:680px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								
							
								<tr>
									<th><label class="tooltipPoint" title="피드백 타입 설정" for="">타입</label></th>
									
									<td>
									<select class="feedSelect" name="type" id="type" onchange="type_selected(this.value,'<?=$_COOKIE['code']?>','<?=$sid?>')">
									<? foreach($config['feedback_main'] as $tkey=>$tval){?>
										<option <?if($type==$tkey){?>selected<?}?> value="<?=$tkey?>"><?=$tval?></option>
									<?}?>
									</select>
									</td>
									
								</tr>
								<?if($config['feedback'][$type]['val1']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">val1</label></th>
									<td><input style="width:460px" type="text" name="val1" id="val1"  value="<?=str_replace('"','&quot;',$d['val1'])?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['val2']){?>
								<tr>
									<th><label  class="tooltipPoint" title=""for="">val2</label></th>
									<td><input style="width:460px" type="text" name="val2" id="val2"  value="<?=str_replace('"','&quot;',$d['val2'])?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['max']){?>
								<tr>
									<th><label class="tooltipPoint" title="피드백 선택항목 최대 개수 선택 할 때 사용 / sub항목 수와 입력한 최대 개수가 일치해야 함/해당개수 이상 체크시 얼럿문구(최대N개까지만 선택 가능합니다.)" for="">최대개수</label></th>
									<td><input style="width:460px" type="text" name="max" id="max"  value="<?=$d['max']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub1']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub1</label></th>
									<td><input style="width:460px" type="text" name="sub1" id="sub1" value="<?if($type=="32" && !$d['sub1']){?><?=$_COOKIE['sub1']?><?}else{?><?=$d['sub1']?><?}?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub2']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub2</label></th>
									<td><input style="width:460px" type="text" name="sub2" id="sub2"  value="<?if($type=="32" && !$d['sub2']){?><?=$_COOKIE['sub2']?><?}else{?><?=$d['sub2']?><?}?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub3']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub3</label></th>
									<td><input style="width:460px" type="text" name="sub3" id="sub3"  value="<?if($type=="32" && !$d['sub3']){?><?=$_COOKIE['sub3']?><?}else{?><?=$d['sub3']?><?}?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub4']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub4</label></th>
									<td><input style="width:460px" type="text" name="sub4" id="sub4"  value="<?if($type=="32" && !$d['sub4']){?><?=$_COOKIE['sub4']?><?}else{?><?=$d['sub4']?><?}?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub5']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub5</label></th>
									<td><input style="width:460px" type="text" name="sub5" id="sub5"  value="<?if($type=="32" && !$d['sub5']){?><?=$_COOKIE['sub5']?><?}else{?><?=$d['sub5']?><?}?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub6']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub6</label></th>
									<td><input style="width:460px" type="text" name="sub6" id="sub6"  value="<?if($type=="32" && !$d['sub6']){?><?=$_COOKIE['sub6']?><?}else{?><?=$d['sub6']?><?}?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub7']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub7</label></th>
									<td><input style="width:460px" type="text" name="sub7" id="sub7"  value="<?=$d['sub7']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub8']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub8</label></th>
									<td><input style="width:460px" type="text" name="sub8" id="sub8"  value="<?=$d['sub8']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub9']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub9</label></th>
									<td><input style="width:460px" type="text" name="sub9" id="sub9"  value="<?=$d['sub9']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub10']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub10</label></th>
									<td><input style="width:460px" type="text" name="sub10" id="sub10"  value="<?=$d['sub10']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub11']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub11</label></th>
									<td><input style="width:460px" type="text" name="sub11" id="sub11"  value="<?=$d['sub11']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub12']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub12</label></th>
									<td><input style="width:460px" type="text" name="sub12" id="sub12"  value="<?=$d['sub12']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub13']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub13</label></th>
									<td><input style="width:460px" type="text" name="sub13" id="sub13"  value="<?=$d['sub13']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub14']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub14</label></th>
									<td><input style="width:460px" type="text" name="sub14" id="sub14"  value="<?=$d['sub14']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub15']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub15</label></th>
									<td><input style="width:460px" type="text" name="sub15" id="sub15"  value="<?=$d['sub15']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub16']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub16</label></th>
									<td><input style="width:460px" type="text" name="sub16" id="sub16"  value="<?=$d['sub16']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub17']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub17</label></th>
									<td><input style="width:460px" type="text" name="sub17" id="sub17"  value="<?=$d['sub17']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub18']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub18</label></th>
									<td><input style="width:460px" type="text" name="sub18" id="sub18"  value="<?=$d['sub18']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub19']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub19</label></th>
									<td><input style="width:460px" type="text" name="sub19" id="sub19"  value="<?=$d['sub19']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['sub20']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">sub20</label></th>
									<td><input style="width:460px" type="text" name="sub20" id="sub20"  value="<?=$d['sub20']?>" /></td>
								</tr>
								<?}?>


								<?if($config['feedback'][$type]['img']){?>
								<tr>
									<th><label class="tooltipPoint" title="" for="">img</label></th>
									<td><input style="width:460px" type="file" name="image" id="image"  value="<?=$d['image']?>" /></td>
								</tr>
								<?}?>

								<?if($config['feedback'][$type]['necessary']){?>
								<tr>
									<th><label class="tooltipPoint" title="필수여부 사용일 경우 해당 문항은 필수항목으로 체크" for="">필수여부</label></th>
									<td>
									<select name="necessary" id="necessary" onchange="necessary_change(this.value)">
										<option <?if($d['necessary']=="N"){?>selected<?}?> value="N">미사용</option>
										<option <?if($d['necessary']=="Y"){?>selected<?}?> value="Y">사용</option>
									</select>
									</td>
								</tr>

								<tr id="necessary_tr" <?if($d['necessary']=="N" || !$d['necessary']){?>style="display:none"<?}?>>
									<th><label class="tooltipPoint" title="필수여부 Y일 경우, 해당항목 체크하지않고 send할 경우 보여질 문구/예)Q1항목을 체크해 주세요/" for="">필수 문구</label></th>
									<td><input style="width:460px" type="text" name="necessary_txt" id="necessary_txt"  value="<?if($d['necessary_txt']){?><?=$d['necessary_txt']?><?}else{?><?=$_COOKIE['necessary_txt']?><?}?>" /></td>
								</tr>
								<?}?>

								<tr>
									<th><label class="tooltipPoint" title="특정 문항 체크했을 때에 다음 필드 활성화 되어야 할 경우 사용 / 활성화 되야 할 필드의 상위 필드를 부모로 선택 / 사용예) 1~5번항목 중 5번(기타) 선택시에만 의견(텍스트 입력)필드가 보여저야 할 경우/ " for="">부모</label></th>
									<td>
									<select name="parent" id="parent">
									<option value="">:: select ::</option>
									<?
									$parent_query="SELECT * FROM feedback_tbl WHERE code='".$code."' and del='N'  order by orderby asc";
									$parent_result=mysqli_query($conn, $parent_query);

									while(is_array($parent_d = mysqli_fetch_array($parent_result))){?>
										<option<?=$d['parent']==$parent_d['sid']?' selected="true"':''?> value="<?=$parent_d['sid']?>"><?=$parent_d['type']?>
										
										<?if($parent_d['type']=="0"){?>
										<?=$parent_d['val1']?> <?=$parent_d['val2']?>
										<?}?>

										<?if($parent_d['type']=="1"){?>
											<?=$parent_d['val1']?>
										<?}?>

										<?if($parent_d['type']=="2"){?>
											<?=$parent_d['val1']?>
										<?}?>

										<?if($parent_d['type']=="3"){?>
											<?=$parent_d['val1']?>
										<?}?>

										<?if($parent_d['type']=="11"){?>
											한줄로 선택
										<?}?>
										<?if($parent_d['type']=="12"){?>
											한문항당 한줄
										<?}?>
										<?if($parent_d['type']=="21"){?>
											selected
										<?}?>

										<?if($parent_d['type']=="31"){?>
											점수판 type1
										<?}?>
										<?if($parent_d['type']=="32"){?>
											점수판 type2
										<?}?>
										<?if($parent_d['type']=="41"){?>
											의견접수란
										<?}?>
										
										</option>
									<?}
									mysqli_data_seek($time_result,0);
									?>
									</select>
									</td>
								</tr>

								<tr>
									<th><label class="tooltipPoint" title="부모 문항이 1~3개일 경우 해당 문항을 선택했을 때 다음 필드 활성화 시킬 수 있음 / 예) 보기가 1.만족 2.불만족 3.기타 일 경우 3번 기타를 선택했을 때 다음 필득 활성화 되게 할 경우 부모값에 3을 입력 /  " for="">부모값</label></th>
									<td><input style="width:460px" type="text" name="parent_val" id="parent_val"  value="<?=$d['parent_val']?>" /></td>
								</tr>
								
								<tr>
									<th><label class="answer_field" title="사용자 답 필드" for="">사용자 답 필드</label></th>
									<td><input style="width:460px" type="text" name="answer_field" id="answer_field"  value="<?=$d['answer_field']?>" /></td>
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
		</div>

	
<script type="text/javascript">
	$( function(){
		$('#eventdate').datepicker({dateFormat:"yy-mm-dd"});
	});

	function type_selected(val,code,sid) {
		location.href="./add.php?code="+code+"&sid="+sid+"&type="+val;
	}	

	function necessary_change(val) {
		if(val=="Y"){
			document.getElementById("necessary_tr").style.display = 'table-row';
		}else{
			document.getElementById("necessary_tr").style.display = 'none';
		}
	}	
</script>

<?include "./../footer.php";?>