<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<div class="popupWrap" id="popupComment" style="width:100%;">
	<h1>Comment</h1>
	<div class="comment">
		<?
		$_COMMENTCNF['page_name'] = "poster_view_qna";
		$_COMMENTCNF['page_code'] = "qna";
		##ex)게시판의 게시글 또는 탭메뉴(한 페이지 안에서 구분이 되는경우 EX. 게시판 안의 게시글)
		$_COMMENTCNF['_number'] = "s_".$sid;

		$_COMMENTCNF['place_holder'] = "Please leave your comment or questions here. They will be delivered to the speaker";

		##코멘트 API실제 연동
		include $_SERVER['DOCUMENT_ROOT']."/api_comment/index.php";
		?>
	</div>

	<!-- <div class="popupCon">
		<div class="scrollArea">
			<table class="tblDef">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 15%;">
					<col style="width: *">
				</colgroup>
				<thead>
					<tr>
						<th>1</th>
						<th>Name</th>
						<th>affiliation</th>
						<th>Comment</th>
					</tr>
				</thead>
				<tbody>
					<?
						$query = "select t1.*,t2.name_kr,t2.aff_kor from comment_tbl as t1 inner join registration_tbl as t2 on t1.id=t2.sid where t1.number='s_".$sid."' and t1.type='C'";
						$result=$conn->query($query);
						if(DB::isError($result)) die($result->getMessage());
						$n=1;
						while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

					?>
					<tr>
						<td><?=$n?></td>
						<td><?=$d['name_kr']?></td>
						<td><?=$d['aff_kor']?></td>
						<td><?=$d['content']?></td>
					</tr>
					<?
						$cquery = "select t1.*,t2.name_kr,t2.aff_kor from comment_tbl as t1 inner join registration_tbl as t2 on t1.id=t2.sid where t1.csid='".$d['sid']."'";
						$cresult = $conn->query($cquery);
						if(DB::isError($cresult)) {
						   die($cresult->getMessage());
						}
						
						while(is_array($rows=$cresult->fetchRow(DB_FETCHMODE_ASSOC))){
					?>
					<tr>
						<td>Re</td>
						<td><?=$rows['name_kr']?></td>
						<td><?=$rows['aff_kor']?></td>
						<td><?=$rows['content']?></td>
					</tr>
					<?}?>
					<?$n++;}?>
				</tbody>
			</table>
		</div>
	</div> -->
	<div class="close"><a class="color_close"><img src="/asset/layout/layerpopup_close.png" alt="닫기"></a></div>
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>