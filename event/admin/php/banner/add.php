<?include "./../header2.php";
$day = 1;
$d=null;
if(!empty($sid))
{
	$query="SELECT * FROM banner_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
	$day = $d['day'];
} 	
?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>배너 등록</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								
							
								<tr>
									<th><label class="tooltipPoint" title="배너 누르면 연결될 URL" for="">link URL</label></th>
									<td><input style="width:205px" type="text" name="linkurl" id="linkurl"  value="<?=$d['linkurl']?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="안드로이드용 이미지 " for="">Image1<br>(and)</label></th>
									<td><input style="width:205px" type="file" name="image" id="image"/>
									<?if($d['image']){?>
									<a class="inputBtndel" onclick="javascript:del_file('image','<?=$d['sid']?>')">사진삭제</a><?}?></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="아이폰용 이미지(ios X용) " for="">Image2<br>(ios X)</label></th>
									<td><input style="width:205px" type="file" name="image2" id="image2"/>
									<?if($d['image2']){?>
									<a class="inputBtndel"  onclick="javascript:del_file('image2','<?=$d['sid']?>')">사진삭제</a><?}?></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="아이폰용 이미지(ios ) " for="">Image3<br>(ios)</label></th>
									<td><input style="width:205px" type="file" name="image3" id="image3"/>
									<?if($d['image3']){?>
									<a class="inputBtndel" onclick="javascript:del_file('image3','<?=$d['sid']?>')">사진삭제</a><?}?></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="배너 및 인트로 이미지 노출 시작일 /ex)행사별로 다른이미지 보여저여 할 경우 " for="">시작일</label></th>
									<td><input style="width:205px" type="text" name="sdate" id="sdate"   value="<?if($d['sdate']){?><?=date("y-m-d",$d['sdate'])?><?}?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="배너 및 인트로 이미지 노출 종료일 / 선택 안할경우 계속 노출 " for="">종료일</label></th>
									<td><input style="width:205px" type="text" name="edate" id="edate"   value="<?if($d['edate']){?><?=date("y-m-d",$d['edate'])?><?}?>" /></td>
								</tr>

								<tr>
									<th><label class="tooltipPoint" title="인트로:앱 실행후 보여지는 인트로 이미지 / 배너: 메인 배너 " for="">구분</label></th>

									<td><select name="gubun" id="gubun">
									<option <?if($d['gubun']=="1"){?>selected<?}?> value="1">배너</option>
									<option <?if($d['gubun']=="2"){?>selected<?}?> value="2">인트로</option>
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