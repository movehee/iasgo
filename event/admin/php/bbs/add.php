<?include "./../header2.php";?>
<script type="text/javascript" src="/func/naver_editor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">

	$(window).load(function () {
		var oEditors = [];
		nhn.husky.EZCreator.createInIFrame({
			oAppRef: oEditors,
			elPlaceHolder: "content",
			sSkinURI: "/func/naver_editor/SmartEditor2Skin.html",	
			htParams : {bUseToolbar : true,
				fOnBeforeUnload : function(){
					//alert("아싸!");	
				}
			}, //boolean
			fOnAppLoad : function(){
				//예제 코드
				//oEditors.getById["contents"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
			},
			fCreator: "createSEditor2"
		});	
			$("#registform").submit(function () {


			//if($("#status").val()=='Y'){ return true; }

			if(!$.trim($("#subject").val())){
				alert('제목을 입력하세요.');
				$("#subject").focus();
				return false;
			}

			
			oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
			if(!$.trim($('#content').val())){
				alert('내용을 입력해 주세요.');
				return false;
			}

			return true;
		});
		
	});

</script>

<?
if(!empty($sid))
{
	$query="SELECT * FROM bbs_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
} 	
?>

<div id="container" style="width:1000px">
	<div class="contents" style="width:1000px">
		<h2>공지사항 등록</h2><br><br>

		<div class="conArea" style="width:1000px">
			
			<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
			<input type="hidden" name="old_date" value="<?=$d['push_date']?>" /><br />
			<?if(!empty($sid)){?>
			<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
			<?}?>
			<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
				<fieldset>
				
					<table class="inputTbl">
						<colgroup>
							<col style="width: 20%;" />
							<col style="width: 40%;" />
							<col style="width: 40%;" />
						</colgroup>
						<tbody>
							
							<tr>
								<th><label for="" class="tooltipPoint" title="">제목</label></th>
								<td colspan="2"><input style="width:700px" type="text" name="subject" id="subject"  value="<?=$d['subject']?>" /></td>
							</tr>
							<tr>
								<th><label for="" class="tooltipPoint" title="공개여부 Y인 게시글만 APP > 공지사항 목록에 보여집니다">공개여부</label></th>
								<td colspan="2"><select name="showYN" id="showYN">
									<option <?if($d['showYN']=="Y"){?>selected<?}?> value="Y">공개</option>
									<option <?if($d['showYN']=="N"){?>selected<?}?> value="N">비공개</option>
									</select></td>
							</tr>
							<tr>
								<th><label for="" class="tooltipPoint" title="Noti여부를 사용 으로 할 경우 APP 공지사항 목록 상단에 고정됩니다.">Noti여부</label></th>
								<td colspan="2"><select name="notiYN" id="notiYN">
									<option <?if($d['notiYN']=="N"){?>selected<?}?> value="N">미사용</option>
									<option <?if($d['notiYN']=="Y"){?>selected<?}?> value="Y">사용</option>
									
									</select></td>
							</tr>

							<tr>
								<th><label for="" class="tooltipPoint" title="앱 푸시 예약발송 입니다. 예약발송 시간 단위는 10분 단위로 설정해야 합니다. 10분마다 서버에서 체크해서 예약된 건수가 있을 경우에만 발송합니다/ 예) 09:04분 으로 등록할 경우 발송이 안될 수 도 있습니다.">예약발송</label>
							</th>
				
								<td><input type="text" name="pushdate" id="pushdate" readonly  value="<?if($d['push_date']){?><?=date("y-m-d",$d['push_date'])?><?}?>" />
								<a onclick="$('#pushdate').val('');">[초기화]</a>
								</td>
								<td><input type="text" name="pushdate2" id="pushdate2"   value="<?if($d['push_date']){?><?=date("H:i",$d['push_date'])?><?}?>" placeholder="시간:분"/>	
								<p style="color:#ff1100">*예약발송 등록 시 10분 단위로만 등록 가능합니다.<br/> ex) 09:01분 으로 할 경우 발송안됨</p>
								</td>
							</tr>

							<tr>
								<td colspan=3><textarea name="content" id="content" style="display:none;"><?=$d['content']?></textarea></td>
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
		$('#pushdate').datepicker({dateFormat:"yy-mm-dd"});
	});

</script>
<?include "./../footer.php";?>