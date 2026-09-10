<?include "./../header2.php";

	$query="SELECT * FROM session_category_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>Category 등록</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./category_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" />
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" />
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								
								
								<tr>
									<th><label for="" class="tooltipPoint" title="프로그램 카테고리에 노출될 약어표시/ 예 SY, LS, WS, MTE등" >약어</label></th>
									<td><input style="width:205px" type="text" name="abb" id="abb"  value="<?=$d['abb']?>" /></td>
								</tr>
								<tr>
									<th><label for="" class="tooltipPoint" title="카테고리명 입력" >카테고리명</label></th>
									<td><input style="width:205px" type="text" name="info" id="info"  value="<?=$d['info']?>" /></td>
								</tr>
								<tr>
									<th><label for="" class="tooltipPoint" title="program 리스트에 보여질 카테고리 텍스트 컬러 or 카테고리 아이콘 bg 컬러/ 셋팅값에따라 아이콘, 텍스트 컬러값이 달라짐" >카테고리<br/>(텍스트) <br/>색상</label></th>
									<td><input style="width:205px" type="text" name="color" id="color"  value="<?=$d['color']?>" /></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="glance 노출타입 /NO:노출안함 / Icon : 아이콘으로 표시(아이콘bg color/ bgcolor: bg컬러로 표시" >glance_type</label></th>
									<td><select name="glance_type" id="glance_type">
									<option 
									<?if($d['glance_type']=="0"){?>selected<?}?> value="0">NO</option>
									<option 
									<?if($d['glance_type']=="1"){?>selected<?}?> value="1">Icon</option>
									<option <?if($d['glance_type']=="2"){?>selected<?}?> value="2">Bgcolor</option></td>
								</tr>
								<tr>
									<th><label for="" class="tooltipPoint" title="glance에 표시될 컬러/glance_type 설정방법에 따라 노출됨" >glance_color</label></th>
									<td><input style="width:205px" type="text" name="glance_color" id="glance_color"  value="<?=$d['glance_color']?>" /></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="보임 처리 된것만 program by session 에 보여짐" >program by session 노출여부</label></th>
									<td>
										<select name="select_category">
											<option value='Y' <?if($d['select_category']=='Y'){?>selected<?}?> >보임</option>
											<option value='N' <?if($d['select_category']=='N'){?>selected<?}?> >안보임</option>
										</select>
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
		</div>


<?include "./../footer.php";?>