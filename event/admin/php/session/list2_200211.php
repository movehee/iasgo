<?include "./../header.php";?>

<?

$query="SELECT * FROM session_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);

$num_per_page = 200;
if(empty($page)) $page = 0;

if(empty($tab)){
	$result = mysqli_query($conn, "select sid from agenda_tbl where code='".$code."' and del='N' order by sid asc limit 1");
	$row = mysqli_fetch_array($result);
	$tab = $row['sid'];
}

$search = "&code=$code&tab=$tab&room=$room&category1=$category1";

$query = "SELECT * FROM session_tbl where code='".$code."' and type='1' and tab='".$tab."'";

if($room) {
	$query .= " and room='$room'";
}

if($category1) {
	$query .= " and category1='$category1'";
}

$result = mysqli_query($conn, $query);
$totalRecord = $result->num_rows;

$query.=" order by session_tbl.orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;


$result = mysqli_query($conn, "select max(orderby) maxs from session_tbl where code='".$code."' and type='1' and tab='".$tab."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$category_query="SELECT * FROM session_category_tbl WHERE code='".$code."' and del='N' order by orderby asc";
$category_result=mysqli_query($conn, $category_query);

$room_query="SELECT * FROM session_room_tbl WHERE code='".$code."' and tab='".$tab."' and del='N' order by orderby asc";
$room_result=mysqli_query($conn, $room_query);

$time_query="SELECT * FROM session_time_tbl WHERE code='".$code."' and del='N' and tab='".$tab."' order by orderby asc";
$time_result=mysqli_query($conn, $time_query);

if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	echo $query;
}

$result = mysqli_query($conn, $query);
?>
<div id="container" style="width:1700px">
	
		<h2>Session 관리</h2>


		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right; margin-right:10px;">

				<select class="excel_proc" e-link="excel2.php" style=" font-size:13px; width: 140px;  height: 40px; ">
					<option value="">좋아요 엑셀</option>
					<option value="view">엑셀보기</option>
					<option value="down">엑셀다운</option>
				</select>


				<select class="excel_proc" e-link="excel.php" style=" font-size:13px; width: 140px;  height: 40px; ">
					<option value="">강의평가 엑셀</option>
					<option value="view">엑셀보기</option>
					<option value="down">엑셀다운</option>
				</select>

				

				

				

				<?if($event_db['session_sync']=='Y') {?>
					<a href=""title="glance 미리보기"  onclick="javascript:view_sync2('<?=$code?>','<?=$tab?>')" class="btnOrg"><i class="fas fa-eye"></i>Glance</a>
					<a href="" title="프로그램 전체 미리보기(app화면 동일)" onclick="javascript:view_sync('<?=$code?>')" class="btnOrg"><i class="fas fa-eye"></i>	미리보기</a>
				<?}else{?>
					<a href=""title="glance 미리보기"  onclick="javascript:view2('<?=$code?>','<?=$tab?>')" class="btnDef"><i class="fas fa-eye"></i>Glance</a>
					<a href="" title="프로그램 전체 미리보기(app화면 동일)" onclick="javascript:view('<?=$code?>')" class="btnDef"><i class="fas fa-eye"></i>미리보기</a>				
				<?}?>



				<a href=""  title="세션 카테고리를 설정합니다 / 카테고리 약어 / 카테고리 컬러 / glance 타입 / glacne 컬러 등을 설정할 수 있습니다 / ex) Symposium 약어 SY"  onclick="javascript:categoryset('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>Category 설정</a>
				<a href="" title="시간 설정 / 날짜별로 시간 셋팅 가능 / 보임 여부 는 설정 > setting > glance_time_type 이 시간설정 연동 일 경우 사용 됩니다 / " onclick="javascript:timeset('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>시간 설정</a>
				<a title="룸 설정 / 날짜별로 룸 셋팅 가능" href="" onclick="javascript:room('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>ROOM 설정</a>
				<a href=""  title="Setting / 기본적인 셋팅 후 세션등록을 진행해야 합니다." onclick="javascript:set('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>Setting</a>
				<!--
				<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a  onclick="javascript:add('<?=$tab?>')" class="btnDef"><i class="fas fa-plus-circle"></i>Session 등록</a></p>
				-->
				<input type="text" style=" cursor: text; height: 40px; width:45px;padding:0px;margin-right:5px" name="session_add_cnt" id="session_add_cnt"  value="" /><a  title="세션 등록 필드 수 입력 후 > Session 등록 버튼 누르면 필드 생성" onclick="javascript:add_session('<?=$code?>','<?=$tab?>')" class="btnDef "><i class="fas fa-plus-circle"></i> Session 등록</a> 	
			</span>
		</div>
		<div class="contents member">
			<?
			$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");
			$chk=false;
			while(is_array($tab_col = mysqli_fetch_array($tab_result))){
				$chk=true;
			?>

			<p class="btn" style="float:left;margin-right:20px"><a href="./list2.php?tab=<?=$tab_col['sid']?>&code=<?=$code?>" class="<?if($tab==$tab_col['sid']){?>btnDef<?}else{?>btnGrey<?}?>"><?=$tab_col['name']?></a></p>
			

			<?}?>
			<span style="float:left;">
				<select name="room" style=" font-size:13px; width: 140px;  height: 40px;"  onchange="location.href='list2.php?code=<?=$code?>&tab=<?=$tab?>&category1=<?=$category1?>&room='+this.value">
					<option value="">Room</option>
					<?
					while(is_array($room_d = mysqli_fetch_array($room_result))){?>
						<option<?=$room==$room_d['sid']?' selected="true"':''?> value="<?=$room_d['sid']?>"><?=$room_d['name']?>(<?=$room_d['sid']?>)</option>
					<?}
					mysqli_data_seek($room_result,0); 
					?>
				</select>
			</span>
			<?if($s['category1']=="Y"){?>
			<span style="float:left;padding-left:5px;">
				<select name="category1" style=" font-size:13px; width: 140px;  height: 40px;"  onchange="location.href='list2.php?code=<?=$code?>&tab=<?=$tab?>&room=<?=$room?>&category1='+this.value">
					<option value="">Category1</option>
					<?
					while(is_array($category_d = mysqli_fetch_array($category_result))){?>
						<option<?=$category1==$category_d['sid']?' selected="true"':''?> value="<?=$category_d['sid']?>"><?=$category_d['info']?></option>
					<?}
					mysqli_data_seek($category_result,0); 
					?>
				</select>
			</span>
			<?}?>

			<?if(!$chk){?>
			<script>
				alert("Agenda를 먼저 등록하세요");
				location.href="../agenda/agenda.php";
			</script>
			<?}?>
			<table class="tblList">
			
				<thead>
					<tr>
						<th>NO</th>
						<th>Room</th>
						<th>Time</th>

						<?if($s['chair']){?>
						<th>좌장</th>
						<?}?>
						<?if($s['panel']){?>
						<th>패널</th>
						<?}?>
						<?if($s['etc_faculty']!="N"){?>
						<th>기타패컬티</th>
						<?}?>
						<?if($s['discusser']){?>
						<th>지정토론</th>
						<?}?>
						<?if($s['theme']=="Y"){?>
						<th>세션제목</th>
						<?}?>
						<?if($s['sub_theme']=="Y"){?>
						<th>서브세션제목</th>
						<?}?>
						<?if($s['category1']=="Y"){?>
						<th>카테고리 1</th>
						<?}?>
						<?if($s['category2']=="Y"){?>
						<th>카테고리 2</th>
						<?}?>

						<?if($s['language']=="Y"){?>
						<th>kor/eng<br/>아이콘표시</th>
						<?}?>

						<th>sub</th>
						<th>관리</th>
					</tr>
				</thead>

				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){
			$sub_result = mysqli_query($conn, "SELECT count(*) cnt FROM session_tbl where type='2' and link_session='".$col['sid']."'");
			$sub_row = mysqli_fetch_array($sub_result);
				

				
				?>

				<tr class="bg" id="<?=$col['sid']?>">
					<td><?=$col['orderby']?></td>
					<td>
					<select onchange="changeVal(this,'room','<?=$col['sid']?>')" name="room" id="room">
						<option value="">:: select ::</option>
						<?
						while(is_array($room_d = mysqli_fetch_array($room_result))){?>
							<option<?=$col['room']==$room_d['sid']?' selected="true"':''?> value="<?=$room_d['sid']?>"><?=$room_d['name']?>(<?=$room_d['sid']?>)</option>
						<?}
						mysqli_data_seek($room_result,0); 
						?>
					</select>
					</td>
					<td>
					<select onchange="changeVal(this,'time','<?=$col['sid']?>')" name="time" id="time">
						<option value="">:: select ::</option>
						<?
						while(is_array($time_d = mysqli_fetch_array($time_result))){?>
							<option<?=$col['time']==$time_d['sid']?' selected="true"':''?> value="<?=$time_d['sid']?>"><?=$time_d['time']?></option>
						<?}
						mysqli_data_seek($time_result,0);
						?>
					</select>
					</td>

					<?if($s['chair']){?>
					<?if($s['faculty_type']==1){?>
					<?
					$faculty_query="SELECT b.name FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='chair' and a.session_sid='".$col['sid']."' order by a.sid asc";
					$faculty_result=mysqli_query($conn, $faculty_query);
					
					$chair="";
					$i = 0;
					while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
						if($i!=0){
							$chair = $chair . ", ";
						}

						$chair .= $faculty_d['name'];
						$i++;
					}
					?>
						<td><input onchange="changeVal2(this,'chair','<?=$col['sid']?>')" type="text" name="chair" id="chair"  value="<?=htmlspecialchars($chair)?>" /></td>
					<?}else{?>
						<td><input onchange="changeVal(this,'chair','<?=$col['sid']?>')" type="text" name="chair" id="chair"  value="<?=htmlspecialchars($col['chair'])?>" /></td>
					<?}?>
						
					<?}?>
					<?if($s['panel']){?>

					<?if($s['faculty_type']==1){?>
					<?
					$faculty_query="SELECT b.name FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='panel' and a.session_sid='".$col['sid']."' order by a.sid asc";
					$faculty_result=mysqli_query($conn, $faculty_query);
					
					$chair="";
					$i = 0;
					while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
						if($i!=0){
							$chair = $chair . ", ";
						}

						$chair .= $faculty_d['name'];
						$i++;
					}
					?>
						<td><input onchange="changeVal2(this,'panel','<?=$col['sid']?>')" type="text" name="panel" id="panel"  value="<?=htmlspecialchars($chair)?>" /></td>
					<?}else{?>
						<td><input onchange="changeVal(this,'panel','<?=$col['sid']?>')" type="text" name="panel" id="panel"  value="<?=htmlspecialchars($col['panel'])?>" /></td>
					<?}?>
					<?}?>
					<?if($s['etc_faculty']!="N"){?>
						<td><input onchange="changeVal(this,'etc_faculty','<?=$col['sid']?>')" type="text" name="etc_faculty" id="etc_faculty"  value="<?=htmlspecialchars($col['etc_faculty'])?>" /></td>
					<?}?>
					<?if($s['discusser']){?>

					<?if($s['faculty_type']==1){?>
					<?
					$faculty_query="SELECT b.name FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='discusser' and a.session_sid='".$col['sid']."' order by a.sid asc";
					$faculty_result=mysqli_query($conn, $faculty_query);
					
					$chair="";
					$i = 0;
					while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
						if($i!=0){
							$chair = $chair . ", ";
						}

						$chair .= $faculty_d['name'];
						$i++;
					}
					?>
						<td><input onchange="changeVal2(this,'discusser','<?=$col['sid']?>')" type="text" name="discusser" id="discusser"  value="<?=htmlspecialchars($chair)?>" /></td>
					<?}else{?>
						<td><input onchange="changeVal(this,'discusser','<?=$col['sid']?>')" type="text" name="discusser" id="discusser"  value="<?=htmlspecialchars($col['discusser'])?>" /></td>
					<?}?>

					<?}?>
					<?if($s['theme']=="Y"){?>
					<td><input onchange="changeVal(this,'theme','<?=$col['sid']?>')" type="text" name="theme" id="theme"  value="<?=htmlspecialchars($col['theme'])?>" /></td>
					<?}?>
					<?if($s['sub_theme']=="Y"){?>
					<td><input onchange="changeVal(this,'sub_theme','<?=$col['sid']?>')" type="text" name="sub_theme" id="sub_theme"  value="<?=htmlspecialchars($col['sub_theme'])?>" /></td>
					<?}?>
					<?if($s['category1']=="Y"){?>

					<td>
					<select style="max-width: 150px;" onchange="changeVal(this,'category1','<?=$col['sid']?>')" name="category1" id="category1">
						<option value="">:: select ::</option>
						<?
						while(is_array($category_d = mysqli_fetch_array($category_result))){?>
							<option<?=$col['category1']==$category_d['sid']?' selected="true"':''?> value="<?=$category_d['sid']?>"><?=$category_d['info']?></option>
						<?}
						mysqli_data_seek($category_result,0); 
						?>
					</select>
					</td>


					<?}?>
					<?if($s['category2']=="Y"){?>
					<td><input onchange="changeVal(this,'category2','<?=$col['sid']?>')" type="text" name="category2" id="category2"  value="<?=htmlspecialchars($col['category2'])?>" /></td>
					<?}?>


					<?if($s['language']=="Y"){?>
					<td>
					<select onchange="changeVal(this,'language','<?=$col['sid']?>')" name="language" id="language">
					<option <?if($col['language']=="0"){?>selected<?}?> value="0">No</option>
					<option <?if($col['language']=="1"){?>selected<?}?> value="1">Eng</option>
					<option <?if($col['language']=="2"){?>selected<?}?> value="2">Kor</option>
					<option <?if($col['language']=="3"){?>selected<?}?> value="3">E&K</option>
					<option <?if($col['language']=="4"){?>selected<?}?> value="4">K&E</option>
					</select>
					<?}?>



					<td><a onclick="javascript:sub_session('<?if($col['link_session']){?><?=$col['link_session']?><?}else{?><?=$col['sid']?><?}?>','<?=$col['code']?>')" class="icon ok">SUB<sub>(<?=$sub_row['cnt']?>)</sub></a></td>
					<td>

						<a href="" onclick="javascript:modify('<?=$col['sid']?>','<?=$tab?>','<?=$code?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
						<a href="" onclick="javascript:del('<?=$col['sid']?>','<?=$tab?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
					</td>
				</tr>
				<?}?>
					
				</tbody>
			</table>

			<ul class="pager">
			<?
				for($i = 0 ; $i*$num_per_page < $totalRecord ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?><?if($search){?><?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>
			</ul>


		 
		</div>
		<!-- //contents -->
			<p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">
//alert("정검중입니다. 작업중단해주세요.");


function changeVal3(val,info,sid) {
	
	if(val.checked){
		value="Y";
	}else{
		value="N";
	}

	$.ajax({
		type:"POST",
		url:"./update_session.php",
		data:"val="+value+"&info="+info+"&sid="+sid,
		success:function(msg){

		},error : function(request, status, error ) {  
			alert("입력실패");
		
		}
	});
}


function changeVal(val,info,sid) {


	$.ajax({
		type:"POST",
		url:"./update_session.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){

		},error : function(request, status, error ) {   
			alert("입력실패 : "+val.value);
		
		}
	});
}

function changeVal2(val,info,sid) {

	$.ajax({
		type:"POST",
		url:"./update_session2.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){
			if(msg){
				alert(msg+"님이 Faculty에 등록되어있지 않습니다.");
				location.reload();
			}
		},error : function(request, status, error ) { 
			alert("입력실패 : " + val.value);
		
		}
	});
}


function add_session(code,tab) {
	value="1";
	if(document.getElementById("session_add_cnt").value>0){
		value = document.getElementById("session_add_cnt").value;
	}

	$.ajax({
		type:"POST",
		url:"./add_session.php",
		data:"code="+code+"&tab="+tab+"&value="+value,
		success:function(msg){
			location.reload();
		}
	});
}



function up(sid) {
	if(sid>1)
	{
		val2 = sid-1;
		window.open("order.php?val1="+sid+"&val2="+val2,"","width=530,height=770");
	}
}
function down(sid,max) {
	if(sid<max)
	{
		val2 = Number(sid)+Number(1);
		window.open("order.php?val1="+sid+"&val2="+val2,"","width=530,height=770");
	}
}


function showYN(val,sid) {
	window.open("show.php?show="+val+"&sid="+sid,"","width=530,height=500");
}

function add(tab) {
	window.open("add.php?tab="+tab,"","width=900,height=1000,top=50,left=100");
}

function sub_session(sid,code) {
	window.open("sub2.php?session="+sid+"&code="+code,"","width=1700,height=900,top=30,left=100");
}
function set(code) {
	window.open("set.php?code="+code,"","width=950,height=1000");
}

function view(code) {
	window.open("/php/session/list.php?code="+code,"","width=530,height=800");
}
function view_sync(code) {
	window.open("/voting_sync/php/session/list.php?code="+code,"","width=530,height=800");
}

function view2(code,tab) {
	window.open("/php/session/glance.php?code="+code+"&tab="+tab,"");
}
function view_sync2(code,tab) {
	window.open("/voting_sync/php/session/glance.php?code="+code,"");
}



function room(code) {
	window.open("room.php?code="+code,"");
}

function timeset(code) {
	window.open("time.php?code="+code,"");
}

function categoryset(code) {
	window.open("category.php?code="+code,"");
}


function css() {
	window.open("css.php","","width=530,height=700");
}



function modify(sid,tab,code) {
	window.open("add.php?tab="+tab+"&sid="+sid+"&code="+code,"","width=900,height=1000");
}	

function del(sid,tab) {
	if(confirm("삭제하시겠습니까?")){

		$.ajax({
		type:"POST",
		url:"./del.php",
		data:"sid="+sid+"&tab="+tab,
		success:function(msg){
			location.reload();
		}
	});
	}
}

$(function() {
	$(".tblList tbody").sortable( {
		
		update: function( event, ui ) {
			
			<?if($room || $category1){?>
			alert("검색 상태에서 불가");
			return false;
			<?}?>
			$(this).children().each(function(index) {

					index = index+1;
					$.ajax({
					type:"POST",
					url:"./session_order2.php",
					data:"sid="+$(this).attr('id')+"&orderby="+index,
					success:function(msg){

					}
				});


			});
		}
	});



});
</script>

   
<?include "./../footer.php";?>