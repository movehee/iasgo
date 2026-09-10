<?include "./../header.php";?>


<?

$num_per_page = 30;
if(empty($page)) $page = 0;
if($room){
	$room_query .= " and room='".$room."'";
}

$query="SELECT * FROM question_tbl where del='N' and code='".$_COOKIE['code']."'" .$room_query;


//echo "SELECT count(*) cnt FROM question_tbl where del='N' and code='".$_COOKIE['code']."'";
$result = mysqli_query($conn, "SELECT count(*) cnt FROM question_tbl where del='N' and code='".$_COOKIE['code']."'" .$room_query);
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];


$query.=" order by sid desc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);

?>


<?
if($event_db['session_sync']=='Y') {

	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/voting_sync/config/'.$code.'.php')) {
		include_once $_SERVER['DOCUMENT_ROOT']."/voting_sync/config/".$code.".php";
	}
	
	$sync_url = $_URL['qna'];
	//echo $sync_url;
	$json_string = file_get_contents($sync_url);
	$session_arr = json_decode($json_string, true);
	//print_r($session_arr);

}

?>
<div id="container" style="width:1600px;">
	
		<h2>Question 관리</h2>

		<div class="btnArea" style="width:100%;">
			
			<span class="btn" style="float:right;">
				<select id="all_show" style=" font-size:13px; width: 140px;  height: 40px; ">
					<option value="">사용여부 일괄변경</option>
					<option value="Y">사용</option>
					<option value="N">미사용</option>
				</select>
				<a onclick="all_show_chg()" class="btnDef tooltipPoint" title="좌장석에 보여지는 질문 리스트 일괄변경기능 / select box에서 사용,미사용 선택 후 변경 버튼을 눌러 변경 ">변경</a>
			</span>

			<span class="btn" style="float:right; margin-right:10px;">
				<!--<a href="./excel.php" class="btnDef tooltipPoint" title="보팅결과 엑셀디운"><i class="far fa-chart-bar"></i>결과보기(엑셀다운)</a>-->

				<select class="excel_proc" e-link="excel.php" style=" font-size:13px; width: 140px;  height: 40px; ">
					<option value="">결과보기</option>
					<option value="view">엑셀보기</option>
					<option value="down">엑셀다운</option>
				</select>

				<a onclick="javascript:set('<?=$_COOKIE['code']?>')" class="btnDef tooltipPoint" title="q&a진행 전 셋팅 먼저 해야함"><i class="fas fa-cog"></i>Setting</a>

				<a href="./view2.php?code=<?=$_COOKIE['code']?>" class="btnDef tooltipPoint" target="_blank" title="Question 스크린 화면(콘솔용)/좌장모드에서 보임 으로 선택 한 질문만 보여짐 / 보임 으로 된 질문 없을 경우는 Q&A 문구 보여짐"> <i class="fas fa-eye"></i>콘솔용</a>

				<a href="./view.php?code=<?=$_COOKIE['code']?>" class="btnDef tooltipPoint" target="_blank" title="좌장용 질문 선택화면/Question 리스트에서 사용인 질문만 좌장화면에 보여짐/질문 업데이트를 위해 5초마다 갱신됨, (새로고침 체크박스 풀면 해당기능 사용x / 룸별로 Q&A 진행할 경우 룸별 조회 가능 "> <i class="fas fa-eye"></i>좌장용</a>

				<a href="" onclick="javascript:add()" class="btnDef tooltipPoint" title="관리자 페이지에서도 질문임의로 등록 가능"><i class="fas fa-plus-circle"></i>Question 등록</a>
				
			</span>
		</div>
	<div class="contents">
			<!--
			<p class="btn" style="top: -44px; right: 470px; position: absolute;"><a href="./excel.php" class="btnDef tooltipPoint" title="보팅결과 엑셀디운"><i class="far fa-chart-bar"></i>결과보기(엑셀다운)</a></p>

			<p class="btn" style="top: -44px; right:360px; position: absolute;"><a onclick="javascript:set('<?=$_COOKIE['code']?>')" class="btnDef tooltipPoint" title="q&a진행 전 셋팅 먼저 해야함"><i class="fas fa-cog"></i>Setting</a></p>

		 
			<p class="btn" style=" top: -44px; right: 255px; position: absolute;"><a href="./view2.php?code=<?=$_COOKIE['code']?>" class="btnDef tooltipPoint" target="_blank" title="Question 스크린 화면(콘솔용)/좌장모드에서 보임 으로 선택 한 질문만 보여짐 / 보임 으로 된 질문 없을 경우는 Q&A 문구 보여짐"> <i class="fas fa-eye"></i>콘솔용</a></p>

			<p class="btn " style="top: -44px; right: 150px; position: absolute;"><a href="./view.php?code=<?=$_COOKIE['code']?>" class="btnDef tooltipPoint" target="_blank" title="좌장용 질문 선택화면/Question 리스트에서 사용인 질문만 좌장화면에 보여짐/질문 업데이트를 위해 5초마다 갱신됨"> <i class="fas fa-eye"></i>좌장용</a></p>
 
			<p class="btn" class="tooltipPoint" title="" style="top: -44px; right: 0px; position: absolute;" ><a href="" onclick="javascript:add()" class="btnDef tooltipPoint" title="관리자 페이지에서도 질문임의로 등록 가능"><i class="fas fa-plus-circle"></i>Question 등록</a></p>
			-->

			<div class="al">
				<span class="btn" style="margin-bottom:10px;">
					<a href="<?=$PHP_SELF?>?code=<?=$code?>"  <?if(!$room){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">전체</a>
					<a href="<?=$PHP_SELF?>?code=<?=$code?>&room=1"  <?if($room=='1'){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">Room 1</a>
					<a href="<?=$PHP_SELF?>?code=<?=$code?>&room=2"  <?if($room=='2'){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">Room 2</a>
					<a href="<?=$PHP_SELF?>?code=<?=$code?>&room=3"  <?if($room=='3'){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">Room 3</a>
					<a href="<?=$PHP_SELF?>?code=<?=$code?>&room=4"  <?if($room=='4'){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">Room 4</a>
					<a href="<?=$PHP_SELF?>?code=<?=$code?>&room=5"  <?if($room=='5'){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">Room 5</a>
					<a href="<?=$PHP_SELF?>?code=<?=$code?>&room=6"  <?if($room=='6'){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">Room 6</a>
					<a href="<?=$PHP_SELF?>?code=<?=$code?>&room=7"  <?if($room=='7'){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">Room 7</a>
					<a href="<?=$PHP_SELF?>?code=<?=$code?>&room=8"  <?if($room=='8'){?>class="btnDef"<?}?> title="관리자 페이지에서도 질문임의로 등록 가능">Room 8</a>
				</span>
			</div>

			<table class="tblList">
				<colgroup>
					<col style="width: 3%;">
					<col style="width: 13%;">

					<col style="width: 12%;">
					<col style="width: 11%;">
					<col style="width: *;">
					<col style="width: 8%;">

<!-- 					<col style="width: 8%;"> -->
					<col style="width: 8%;">
				</colgroup>
				<thead>
					<tr>
						<th>No</th>
						 
						<th class="tooltipPoint" title="해당강의 시간">강의시간</th>
						<th class="tooltipPoint" title="룸 이름">룸</th>
						<th class="tooltipPoint" title="세션명 표시">세션명</th>
						<th class="tooltipPoint" title="Q&A 질문 내용">질문내용</th>
					<!-- 	<th>강의명</th> -->
						<th class="tooltipPoint" title="사용인 질문만 좌장석에 보여짐">사용여부</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?
				$no = $totalRecord - ($page * $num_per_page);
				while(is_array($d = mysqli_fetch_array($result))){
					
					$session_col = $sub_col = "";
					
					if($d['name2']){
						$d['name'] = $d['name2'];
					}
					if($d['office2']){
						$d['office'] = $d['office2'];
					}

					if($d['session']){
						
						if($event_db['session_sync'] == 'Y') {
							$session_col = $session_arr[$d['session']];
						}
						else {
							/*$session_query = "SELECT a.*,t.time time_info, r.name room_info, r.photo room_photo FROM session_tbl a, session_room_tbl r, session_time_tbl t ";
							$session_query .= "  WHERE a.time=t.sid and a.room=r.sid and a.sid='".$d['session']."'";

							$session_result = mysqli_query($conn, $session_query);
							$session_col = mysqli_fetch_array($session_result);*/
						}

					}
					
					/*
					if($d['sub']){
						$sub_query = "SELECT * FROM session_tbl WHERE sid='".$d['sub']."'";
						$sub_result = mysqli_query($conn, $sub_query);
						$sub_col = mysqli_fetch_array($sub_result);
					}*/
				?>
				<tr class="bg">
					<td><?=$no?></td>
					 
					<td>
					<?
					if($d['lecture_time']){
						$ex_time = explode("~",$d['lecture_time']);
						echo substr($ex_time[0],0,10);
						echo substr($ex_time[0],10,6).' ~ ';
						echo substr($ex_time[1],10,6);
					}
					?>
					</td>
					<td>
					<?
						echo $d['room'];
					?>
					</td>
					<td><?=$d['session']?></td>
					<td class="al"><?=nl2br($d['question'])?></td> 
					<!-- <td><?=$sub_col['title']?></td> -->
					<td class="btn"><a onclick="javascript:showYN('<?=$d['show']?>','<?=$d['sid']?>')" class="btnBdDef <?if($d['show']=="N"){?> ok<?}?>"><?if($d['show']=="N"){?> 미<?}?>사용</a></td>
					<td class="btn">
						<div class="util">
							<a href="#" class="btnGrey" onclick="javascript:modify('<?=$d['sid']?>')">수정</a>
							<a href="#" class="btnPoint" onclick="javascript:del('<?=$d['sid']?>')">삭제</a>
						</div>
					</td>
				</tr>
				<?$no--;}?>
					
				</tbody>
			</table>

			<ul class="pager">
			<?
				for($i = 0 ; $i*$num_per_page < $totalRecord ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?>&room=<?=$room?><?if($search){?>&search=<?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>
			</ul>
	</div>
		<!-- //contents -->
			
	<p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>	
    
</div> <!-- //container -->
	
<script type="text/javascript">



function showYN(val,sid) {

	$.ajax({
		type:"POST",
		url:"./show.php",
		data:"show="+val+"&sid="+sid+"&code=<?=$code?>",
		success:function(msg){
			location.reload();
		}
	});

	
	//window.open("show.php?show="+val+"&sid="+sid,"","width=530,height=500");
}
function set() {
	window.open("set.php","","width=950,height=1000");
}
function add() {
	window.open("add.php","","width=530,height=375");
}

function modify(sid) {
	window.open("add.php?sid="+sid,"","width=530,height=500");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		window.open("del.php?sid="+sid,"","width=530,height=520");
	}
}

function all_show_chg() {

	var val = $("#all_show").val();

	if(!val) {
		alert("사용여부를 선택해주세요");
		$("#all_show").focus();
		return;
	}

	if(confirm("변경하시겠습니까?")){
		r_val = val=='Y'?'N':'Y';
		showYN(r_val,'all')
	}
}

</script>

   
<?include "./../footer.php";?>