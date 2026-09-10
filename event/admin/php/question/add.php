<?include "./../header2.php";

$name="";
$d = null;
$question="";
if(!empty($sid))
{
	$query="SELECT * FROM question_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
	$question = $d['question'];
}
?>



<div class="popupWrap" id="popupAdd">
	<h1><img src="/admin/image/popupBl_add.png" alt=""> Question 등록</h1>
	<div class="popupCon" style="padding:0;">
		<div class="bgArea">
				<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
				<?}?>
					<fieldset>
					
						<table class="inputTbl">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								<tr>
									<th><label for="">Question</label></th>
									<td><textarea type="text" name="question" id="question" style="width:300px;height:150px;"  value="<?=$question?>" ><?=$question?></textarea></td>
								</tr>
							</tbody>
						</table>


						<div class="btn">
							<input type="submit" value="저장" class="btnOrg btnBig" />
							<input type="reset" onclick="window.close()" value="취소" class="btnGrey btnBig" />
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>


	

<?include "./../footer.php";?>