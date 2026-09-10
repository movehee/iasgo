<?include "./../header2.php";

$name="";
$d = null;
if(!empty($sid))
{
	$query="SELECT * FROM lecture_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
	$name = $d['name'];
}
?>

<div class="popupWrap" id="popupAdd">
	<h1><img src="/admin/image/popupBl_add.png" alt=""> 연자 등록</h1>
	<div class="popupCon">
		<div class="bgArea">
			<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
			<?if(!empty($sid)){?>
			<input type="hidden" name="sid" id="sid" value="<?=$sid?>" />
			<?}?>
				<fieldset>
					<legend>등록</legend>				
					<table class="inputTbl">
						<colgroup>
							<col style="width: 30%;" />
							<col style="width: 70%;" />
						</colgroup>
						<tbody>
							<tr>
								<th><label for="">연자명</label></th>
								<td><input style="" type="text" name="name" id="name"  value="<?=$name?>" /></td>
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


	
<script type="text/javascript">

	$( function(){
		$('#eventdate').datepicker({dateFormat:"yy-mm-dd"});
	});

</script>
<?include "./../footer.php";?>