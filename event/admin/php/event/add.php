<? include $_SERVER['DOCUMENT_ROOT']."/admin/php/header2.php";

$code="";
$name="";
$password="";
$eventdate="";
$d = null;
if(!empty($sid))
{
	$query="SELECT * FROM event_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

	$code = $d['code'];
	$eventdate = date("Y-m-d",$d['eventdate']);
	$name = $d['name'];
	$password = $d['password'];

}

$event_query="SELECT * FROM event_tbl WHERE del='N' order by name, sid desc";
$event_result=mysqli_query($conn, $event_query);


?>

<div class="popupWrap" id="popupAdd">
	<h1  class="tooltipPoint" title=""><img src="/admin/image/popupBl_add.png" alt=""> 행사 등록</h1>
	<div class="popupCon">
		<div class="bgArea" style="padding: 5px;">
		
		<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
		<?if(!empty($sid)){?>
		<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
		<?}?>
			<fieldset>
			
				<table class="inputTbl" style="width:700px">
					<colgroup>
						<col style="width: 20%;" />
						<col style="width: 30%;" />
						<col style="width: 0%;" />
						<col style="width: 30%;" />
					</colgroup>
					<tbody>
						<tr>
							<th><label class="tooltipPoint" title="행사명 입력" for="">행사명</label></th>
							<td><input style="width:230px" type="text" name="name" id="name"  value="<?=$name?>" /></td>
							
							<th><label class="tooltipPoint" title="해당 행사일자 입력" for="">행사일</label></th>
							<td><input style="width:230px" type="text" name="eventdate" id="eventdate" readonly value="<?=$eventdate?>" /></td>
						</tr>
						<tr>
							<th><label class="tooltipPoint" title="행사코드 입력/ 해당코드는 중복되면 안됨 / 아이패드 행사일 경우 아이패드 관리자 코드로도 사용함 / 관리자 페이지 아이디로도 사용됨" for="">행사코드</label></th>
							<td><input style="width:230px" type="text" name="code" id="code" maxlength="20" value="<?=$code?>" /></td>
					
							<th><label class="tooltipPoint" title="관리자 로그인 시 사용됨" for="">비밀번호</label></th>
							<td><input style="width:230px" type="text" name="password" id="password"  value="<?=$password?>" /></td>
						</tr>
					
						<tr>
							<th><label class="tooltipPoint" title="alert창, 문구 등 국문/영문 설정값으로 표시 " for="">언어설정</label></th>
							<td>
							<select name="language" id="language" value="<?=$d['language']?>">
							<option <?if ($d['language']=="Kor"){?> selected<?}?> value="Kor">Kor</option>
							<option <?if ($d['language']=="Eng"){?> selected<?}?> value="Eng">Eng</option>
							</select>
							</td>

							<th  class="tooltipPoint" title="담당자명"><label for="">담당자</label></th>
							<td><input style="width:230px" type="text" name="manager" id="manager"  value="<?=$d['manager']?>" /></td>

						</tr>

						<tr>
							<th><label class="tooltipPoint" title="설정값을 불러올 경우 해당 설정값이 모두 복사되어 해당 행사에 입력됩니다. 설정이후 해당 설정값으로 불러올 경우 이미 설정한 값도 해당 행사의 값으로 변경되오니 최초 세팅에서만 사용하시길 바랍니다." for="">다른행사<br/>설정값<br/>불러오기</label></th>

							<td>
							<select name="set_def" id="set_def">
							<option value="">:: select ::</option>
							<?
							while(is_array($event_d = mysqli_fetch_array($event_result))){?>
								<option value="<?=$event_d['code']?>"><?=$event_d['name']?></option>
							<?}?>
							</select>
							</td>
							 
							<th class="tooltipPoint" title="web/app 셋팅값 구분 / web일 경우 사용메뉴 설정에 체크된 메뉴가 하단에 보여짐 /web으로 선택 할 경우 실제 App에서도 하단 영역 보여짐"><label for="">사용방법<br/>(Web/App)</label></th>
							<td>
							<select name="gubun" id="gubun" value="<?=$d['gubun']?>" style="width:100px;">
							<option <?if ($d['gubun']=="WEB"){?> selected<?}?> value="WEB">WEB</option>
							<option <?if ($d['gubun']=="APP"){?> selected<?}?> value="APP">APP</option>
							</select>
							<select name="gubun_val" id="gubun_val" value="<?=$d['gubun_val']?>" style="width:100px;">
							<option <?if ($d['gubun_val']=="0"){?> selected<?}?> value="0">하단메뉴</option>
							<option <?if ($d['gubun_val']=="1"){?> selected<?}?> value="1">상단메뉴</option>
							</select>
							</td>
		
						</tr>
							<th colspan='3'><label class="tooltipPoint" title="반드시 외부 세션 프로그램을 사용할경우에만 선택." for="">외부 세션프로그램 연동</label></th>
							<td><input type="checkbox" name="session_sync" value="Y" <?if($d['session_sync']=='Y'){?>checked<?}?> >
							</td>
						<tr>
						</tr>
							<th colspan='3'><label class="tooltipPoint" title="http://ezv.kr/php/agenda/view.php?code=<?=$code?> 에서 사용" for="">아젠다 페이지에서 세션연동 표시</label></th>
							<td><input type="checkbox" name="agenda_session" value="Y" <?if($d['agenda_session']=='Y'){?>checked<?}?> >
							</td>
						<tr>

						</tr>
						<tr>
							<th><label class="tooltipPoint" title="사용 메뉴 선택 / 체크된 메뉴만 관리자에 표시" for="">사용메뉴<br/>설정</label></th>
								<td colspan="3">
								<input type="checkbox" id="agendaYN" name="agendaYN" value="Y" <?if($d['agendaYN']=="Y"){?> checked<?}?>/><label for="agendaYN" >Agenda</label>
								<input type="checkbox" id="votingYN" name="votingYN" value="Y" <?if($d['votingYN']=="Y"){?> checked<?}?>/><label for="votingYN" >Voting</label>
								<input type="checkbox" id="questionYN" name="questionYN" value="Y" <?if($d['questionYN']=="Y"){?> checked<?}?>/><label for="questionYN" >Question</label>
								<input type="checkbox" id="feedbackYN" name="feedbackYN" value="Y" <?if($d['feedbackYN']=="Y"){?> checked<?}?>/><label for="feedbackYN" >Feedback</label>
								<input type="checkbox" id="sessionYN" name="sessionYN" value="Y" <?if($d['sessionYN']=="Y"){?> checked<?}?>/><label for="sessionYN" >Session</label>
								<br/>
								<Br>
								<input type="checkbox" id="registrationYN" name="registrationYN" value="Y" <?if($d['registrationYN']=="Y"){?> checked<?}?>/><label for="registrationYN" >registration(이거는 반드시 등록기능만 사용시 체크)</label>
							</td>
						</tr>
						
						<tr>
							<th ><label class="tooltipPoint" title="사용방법을 web으로 할 경우 보여지는 인트로 이미지" for="">인트로<br/>이미지</label></th>
							<td colspan="3"><input style="width:205px" type="file" name="logo" id="logo"/><?if($d['logo']){?><a class="inputBtndel" onclick="javascript:del_file('logo','<?=$d['sid']?>')" class="inputBtndel">파일삭제</a><?}?></td>
						</tr>
						<tr>
							<th ><label class="tooltipPoint" title="보팅 이미지" for="">보팅<br/>이미지</label></th>
							<td colspan="3"><input style="width:205px" type="file" name="login_img" id="login_img"/><?if($d['login_img']){?><a class="inputBtndel" onclick="javascript:del_file('login_img','<?=$d['sid']?>')" class="inputBtndel">파일삭제</a><?}?></td>
						</tr>
						<tr>
							<th class="tooltipPoint" title="정보수집 항목 / ex)피드백, 웹 설문조사 등에 사용/feedback활용 선택 시 피드백등록 후 해당 부분을 정보수집 항목으로 사용 / feedback 활용 선택 할 경우 성명,소속,email등은 선택하면 안됨 / feedback 활용 선택 후 DB 접속 후 > feedback_tbl > tab 값을 999로 변경해야 함"><label for="" >정보수집</label></th>
							<td colspan="3">
								<input type="checkbox" id="nameYN" name="nameYN" value="Y"  <?if($d['nameYN']=="Y"){?> checked<?}?>/><label for="nameYN" >성명</label>
								<input type="checkbox" id="officeYN" name="officeYN" value="Y" <?if($d['officeYN']=="Y"){?> checked<?}?>/><label for="officeYN" >소속</label>
								<input type="checkbox" id="emailYN" name="emailYN" value="Y" <?if($d['emailYN']=="Y"){?> checked<?}?>/><label for="emailYN" >email</label>
								<input type="checkbox" id="licenseYN" name="licenseYN" value="Y"  <?if($d['licenseYN']=="Y"){?> checked<?}?>/><label for="licenseYN" >면허번호</label>
								<input type="checkbox" id="mobileYN" name="mobileYN" value="Y"  <?if($d['mobileYN']=="Y"){?> checked<?}?>/><label for="mobileYN" >휴대폰</label>

								<input type="checkbox" id="login_feedbackYN" name="login_feedbackYN" value="Y"  <?if($d['login_feedbackYN']=="Y"){?> checked<?}?>/><label for="login_feedbackYN" >Feedback 활용</label>
								<br/><br/>
								<input type="checkbox" id="agreeYN" name="agreeYN" value="Y"  <?if($d['agreeYN']=="Y"){?> checked<?}?>/><label for="agreeYN" >정보수집여부 표기</label>
							</td>
						</tr>

						<tr>
							<th><label for="" class="tooltipPoint" title="로그인시 정보수집 동의 문구(미입력시 동의 체크란이 안생김)">정보수집<br>동의문구</label></th>
							<td colspan="3">
								<textarea name="agree_message" id="agree_message" style="width:600px;height:150px"><?=$d['agree_message']?></textarea>
							</td>
						</tr>
						
						<tr>
							<th><label for="" class="tooltipPoint" title="로그인시 정보수집 동의 문구(미입력시 동의 체크란이 안생김)">SMS<br>발신번호</label></th>
							<td colspan="3">
								<input type="text" name="sms_number" value="<?=$d['sms_number']?>" placeholder="010-0000-0000"/>
								<span class="fcRed fwBold" style="position:relative;top:-8px; left:5px;">※ 사용자들에게 URL 전달을 위해 발신 번호 등록</span>
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
	</div>
</div>

	
<script type="text/javascript">

	$( function(){
		$('#eventdate').datepicker({dateFormat:"yy-mm-dd"});

		$("#registform").on("submit", function() {
			
			if($("#code").val()) {
				var regexp = /^[0-9]*$/

				var $firct_code = $("#code").val().substr(0);

				if(regexp.test($firct_code) ) {
					alert("행사코드 첫글자로 숫자대신 문자를 입력해주세요.");
					return false;
				}

			}
		});
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