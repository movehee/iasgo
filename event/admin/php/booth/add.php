<?include "./../header2.php";

$query="SELECT * FROM session_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);

if(!empty($sid))
{
	$query="SELECT * FROM booth_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

} 	
?>

<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>부스 등록</h2>

			<div class="conArea" style="width:800px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:750px">
							<colgroup>
								<col style="width: 15%;" />
								<col style="width: 35%;" />
								<col style="width: 15%;" />
								<col style="width: 35%;" />
							</colgroup>
							<tbody>
								
							
								<tr>
									<th><label for="" class="tooltipPoint" title="구분값 사용 / 둘다 : 스폰서,부스 둘다 사용 / 스폰서 : 스폰서 메뉴에만사용 / 부스 : 부스메뉴에만 사용">구분</label></th>

									<td><select name="tab" id="tab">
									<option <?if($d['tab']=="1"){?>selected<?}?> value="1">둘다</option>
									<option <?if($d['tab']=="2"){?>selected<?}?> value="2">부스</option>
									<option <?if($d['tab']=="3"){?>selected<?}?> value="3">스폰서</option>
									</select></td>
							
									<th><label for="" class="tooltipPoint" title="setting에서 설정한 항목을 선택 / 등급 셋팅 먼저진행 후 등록해야함">VIP 등급</label></th>
									<td><select name="vip" id="vip">
									<option <?if($d['vip']=="1"){?>selected<?}?> value="1"><?=$s['vip_info1']?></option>
									<option <?if($d['vip']=="2"){?>selected<?}?> value="2"><?=$s['vip_info2']?></option>
									<option <?if($d['vip']=="3"){?>selected<?}?> value="3"><?=$s['vip_info3']?></option>
									<option <?if($d['vip']=="4"){?>selected<?}?> value="4"><?=$s['vip_info4']?></option>
									<option <?if($d['vip']=="5"){?>selected<?}?> value="5"><?=$s['vip_info5']?></option>
									<option <?if($d['vip']=="6"){?>selected<?}?> value="6"><?=$s['vip_info6']?></option>
									<option <?if($d['vip']=="7"){?>selected<?}?> value="7"><?=$s['vip_info7']?></option>
									<option <?if($d['vip']=="8"){?>selected<?}?> value="8"><?=$s['vip_info8']?></option>
									</select></td>
								</tr>
								<tr>
									<th><label for="" class="tooltipPoint" title="업체명 입력">업체명</label></th>
									<td><input style="width:205px" type="text" name="name" id="name"  value="<?=$d['name']?>" /></td>
 
									<th><label for="" class="tooltipPoint" title="업체명 영문입력 / ui type3일 경우 팝업 뷰에 표시됨">업체명(영문)</label></th>
									<td><input style="width:205px" type="text" name="name_en" id="name_en"  value="<?=$d['name_en']?>" /></td>
								
									
								</tr>

								<tr>

									<th><label for="" class="tooltipPoint" title="부스이벤트 진행시 업체앱 로그인에 사용">ID</label></th>
									<td><input style="width:205px" type="text" name="idea" id="idea"  value="<?=$d['id']?>" /></td>

									<th><label for="" class="tooltipPoint" title="부스이벤트 진행시 업체앱 로그인에 사용">Password</label></th>
									<td><input style="width:205px" type="text" name="password" id="password"  value="<?=$d['password']?>" /></td>
							
									
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="부스번호 입력 / ui type3 일 경우 리스트에표시, 부스이벤트 사용할 경우 노출 가능(setting에서 부스번호 노출 상태 설정해야 보여짐/ 부스번호는 {번호}, {번호}로 입력/,공백">부스번호</label></th>
									<td><input style="width:205px" type="text" name="booth_num" id="booth_num"  value="<?=$d['booth_num']?>" /></td>

									<th><label for="" class="tooltipPoint" title="ui type3 일 경우 목록에 부스번호가 보여짐, 해당 부스번호bg구분해야 할 경우 css에서 booth1~3 bg컬러 셋팅 후 부스등록 시 해당 타입으로 구분함">부스번호 구분</label></th>
									<td>
									<select name="booth_type" id="booth_type">
										<option <?if($d['booth_type']=="1"){?>selected<?}?> value="1">type1</option>
										<option <?if($d['booth_type']=="2"){?>selected<?}?> value="2">type2</option>
										<option <?if($d['booth_type']=="3"){?>selected<?}?> value="3">type3</option>
										<option <?if($d['booth_type']=="4"){?>selected<?}?> value="4">type4</option>
									</select></td>
								</tr>
								<tr>
									<th><label for="" class="tooltipPoint" title="로고 눌렀을 때 이동하는 링크 / ui type3일 경우 view페이지에 해당 링크 노출됨">linkurl</label></th>
									<td colspan="3"><input style="width:205px" type="text" name="linkurl" id="linkurl"  value="<?=$d['linkurl']?>" /></td>
								</tr>

								<tr>

									<th><label for="" class="tooltipPoint" title="업체 담당자명">담당자명</label></th>
									<td><input style="width:205px" type="text" name="manager" id="manager"  value="<?=$d['manager']?>" /></td>

									<th><label for="" class="tooltipPoint" title="업체 담당자 email">담당자 Email</label></th>
									<td><input style="width:205px" type="text" name="email" id="email"  value="<?=$d['email']?>" /></td>
							
									
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="기본 로고 이미지">Image</label></th>
									<td colspan="3"><input style="width:205px" type="file" name="image" id="image"/>
									<?if($d['image']){?>
									<a class="inputBtndel" onclick="javascript:del_file('image','<?=$d['sid']?>')">파일삭제</a><?}?></td>
								</tr>
								<tr>
									<th><label for="" class="tooltipPoint" title="앱단에 사용할 이미지 / 좌측, 메인하단 등 광고이미지에 사용할 경우 사이즈 조정 필요함(별도 등록된 이미지 없을 경우 기본 로고이미지 사용됨">APP Image<br>(없을경우 Image 사용)</label></th>
									<td colspan="3"><input style="width:205px" type="file" name="image2" id="image2"/>
									<?if($d['image2']){?>
									<a class="inputBtndel" onclick="javascript:del_file('image2','<?=$d['sid']?>')">파일삭제</a><?}?></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="UI type3일 경우 view페이지에 보여질 이미지 / pdf여러장 일 경우 이미지로 변환해서 이미지 합처서 올려야함">컨텐츠 이미지</label></th>
									<td colspan="3"><input style="width:205px" type="file" name="info_image" id="info_image"/>
									<?if($d['info_image']){?>
									<a class="inputBtndel" onclick="javascript:del_file('info_image','<?=$d['sid']?>')">파일삭제</a><?}?></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="UI type3일 경우 view페이지에서 버튼 생성 -> 누르면 해당 컨텐츠 pdf로 볼 수있음(PDF파일만 연결가능)">컨텐츠 PDF</label></th>
									<td colspan="3"><input style="width:205px" type="file" name="info_pdf" id="info_pdf"/>
									<?if($d['info_pdf']){?>
									<a class="inputBtndel" onclick="javascript:del_file('info_pdf','<?=$d['sid']?>')">파일삭제</a><?}?></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="UI type3일 경우 view페이지에 컨텐츠 텍스트로 보여져야 할 경우">컨텐츠</label></th>
									<td colspan='3'><textarea name="content" id="content"><?=$d['content']?></textarea></td>
								</tr>

								

								<tr>
									<th><label for="" class="tooltipPoint" title="앱단 좌측, 메인배너 등에 광고용으로 사용할 경우 사용">추가 홍보</label></th>

									<td><select name="add_booth_chk" id="add_booth_chk">
									<option <?if($d['add_booth_chk']=="1"){?>selected<?}?> value="1">사용</option>
									<option <?if($d['add_booth_chk']=="2"){?>selected<?}?> value="2">미사용</option>
									</select></td>
									<th><label for="" class="tooltipPoint" title="부스이벤트 사용여부(사용인 경우만 부스이벤트 미리보기에 보여지고 부스이벤트 진행 가능함">부스이벤트</label></th>

									<td><select name="event_YN" id="event_YN">
									<option <?if($d['event_YN']=="N"){?>selected<?}?> value="N">미사용</option>
									<option <?if($d['event_YN']=="Y"){?>selected<?}?> value="Y">사용</option>
									
									</select></td>
								</tr>
								<tr>
									<th><label for="" class="tooltipPoint" title="부스이벤트 중 필수참여 부스 필요할 경우 사용(정형 필수세션 참고)/예) vip이벤트 체크될 경우 부스이벤트 조건에 만족 해도 vip 이벤트 체크된 부스 방문 안하면 조건 성립 안됨">VIP이벤트</label></th>

									<td><select name="event2_YN" id="event2_YN">
									<option <?if($d['event2_YN']=="N"){?>selected<?}?> value="N">미사용</option>
									<option <?if($d['event2_YN']=="Y"){?>selected<?}?> value="Y">사용</option>
									
									</select></td>
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
		$('#sdate').datepicker({dateFormat:"yy-mm-dd"});
		$('#edate').datepicker({dateFormat:"yy-mm-dd"});
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