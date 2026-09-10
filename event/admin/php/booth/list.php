<?include "./../header.php";?>

<?
$query="SELECT * FROM session_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);


$num_per_page = 100;
if(empty($page)) $page = 0;
$query="SELECT * FROM booth_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM booth_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);

?>
<style>
	select {font-size:13px; height: 40px;}
</style>
<div id="container">
	
		<h2>부스 관리</h2>
		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right;">

				<?if($code=="koa2019f"){?>

				<select class="excel_proc" e-link="excel_all.php?code=<?=$code?>" style=" font-size:13px; height: 40px; ">
					<option value="">엑셀</option>
					<option value="view">엑셀보기</option>
					<option value="down">엑셀다운</option>
				</select>
				<?}?>
				<?if( $code == 'kses2019f' ){?>
				<a href="eventView.php" class=" btnDef" title="부스 참여자를 볼수있습니다" target="_blank"  ><i class="fas fa-eye"></i> 부스참여자</a>
				<?}?>
				<a href="" class=" btnDef" title="부스이벤트 사용할 경우 미리보기화면" onclick="javascript:view2('<?=$code?>')"  ><i class="fas fa-eye"></i> Booth Event</a>
				<a href="" class=" btnDef" title="미리보기화면" onclick="javascript:view('<?=$code?>')"  ><i class="fas fa-eye"></i>view</a>
				<a href="" class=" btnDef" title="부스 등록 전 setting먼저 진행해야함" onclick="javascript:set('<?=$code?>')" ><i class="fas fa-cog"></i> setting</a>
				<a href="" class=" btnDef" title="부스등록" onclick="javascript:add('<?=$code?>')" ><i class="fas fa-plus-circle"></i>부스 등록</a>
			</span>
		</div>
		<div class="contents member">
			<table class="tblList">
				<colgroup>
					<col style="width: 6%;">
					<col style="width: 20%;">
					<col style="width: 9%;">
					<col style="width: 9%;">
					<col style="width: 9%;">
					<col style="width: 9%;">
					<col style="width: 6%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 10%;">
				</colgroup>
				<thead>
					<tr>
						<th>NO</th>
						<th class="tooltipPoint" title="부스명(국문)">name</th>
						<th class="tooltipPoint" title="부스별 아이디(부스이벤트 사용일 경우 해당 아이디로 업체용앱 로그인">id</th>
						<th class="tooltipPoint" title="부스별 아이디(부스이벤트 사용일 경우 해당 비밀번호로 업체용앱 로그인">pw</th>
						<th class="tooltipPoint" title="업체별 등급구분 표시">vip등급</th>
						<th class="tooltipPoint" title="사용구분값 / 스폰서,부스,둘다">구분</th>
						<th class="tooltipPoint" title="앱부분에 배너 등으로 사용할 경우 해당기능 사용">추가홍보</th>
						<th class="tooltipPoint" title="로고이미지">image</th>
						<th class="tooltipPoint" title="부스이벤트 사용일 경우 엑셀다운 버튼 활성화">excel</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
					<tr class="bg" id="<?=$d['sid']?>">
						<td><?=$d['orderby']?></td>
						<td><?=$d['name']?></td>
						<td><?=$d['id']?></td>
						<td><?=$d['password']?></td>
						<td>
							<select class="status_change" f-name="vip">
							<?for($v=1;$v<=8;$v++) {?>
								<option value="<?=$v?>" <?if($d['vip']==$v){?>selected<?}?> ><?=$s['vip_info'.$v] ?></option>
							<?}?>
							</select>
						
						</td>

						<td>
							<select class="status_change" f-name="tab">
								<option <?if($d['tab']=="1"){?>selected<?}?> value="1">둘다</option>
								<option <?if($d['tab']=="2"){?>selected<?}?> value="2">부스</option>
								<option <?if($d['tab']=="3"){?>selected<?}?> value="3">스폰서</option>
							</select>
						</td>
					
						<td>						
							<select class="status_change" f-name="add_booth_chk">
								<option <?if($d['add_booth_chk']=="1"){?>selected<?}?> value="1">사용</option>
								<option <?if($d['add_booth_chk']=="2"){?>selected<?}?> value="2">미사용</option>
							</select>
						</td>

						<td><img src="/upload/booth/<?=$d['image']?>"></td>
						<td>
						<?if($d['event_YN']=="Y" || $d['event2_YN']=="Y"){?>
							<!-- <a class="inputBtndel" href="./excel.php?code=<?=$code?>&sid=<?=$d['sid']?>">Excel</a> -->

							<select class="excel_proc" e-link="excel.php?code=<?=$code?>&sid=<?=$d['sid']?>" >
								<option value="">엑셀</option>
								<option value="view">엑셀보기</option>
								<option value="down">엑셀다운</option>
							</select>
						<?}
						?>
						</td>
						<td>
							<?if($d['event_YN']=="Y" || $d['event2_YN']=="Y"){?>
							<a onclick="javascript:print('<?=$d['sid']?>')"> <img src="/admin/image/btn_print.png" alt="출력" /></a>
							<?}?>

							<a href="" onclick="javascript:modify('<?=$code?>','<?=$d['sid']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
							<a href="" onclick="javascript:del('<?=$d['sid']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
						</td>
					</tr>
				<?}?>
					
				</tbody>
			</table>

			<ul class="pager">
			<?
				for($i = 0 ; $i*$num_per_page < $totalRecord ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?><?if($search){?>&search=<?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>
			</ul>
		</div>
		<!-- //contents -->
			
		
  <p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>	  
    </div> <!-- //container -->
	
<script type="text/javascript">

$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			index = index+1;

			var page = "<?=$page?>";
			if(page > 0) {
				var num_per_page = "<?=$num_per_page?>"

				index = index + (page * num_per_page);
			}

			$.ajax({
			type:"POST",
			url:"./order.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){
				

			}
		});


    });
  }
});

	$(".status_change").change(function() {
		var sid = $(this).closest("tr").attr("id");
		var f_name = $(this).attr("f-name");
		var val = $(this).val();
		$.ajax({
			type:"POST",
			url:"./status_change.php",
			data: {sid:sid, f_name:f_name, val:val},
			success:function(msg){
				//alert(msg)
				location.reload();
			}
		});
	});
});

function view(code,tab) {
	window.open("/php/booth/list.php?code="+code,"","width=530,height=800");
}

function view(code,tab) {
	window.open("/php/booth/list.php?code="+code,"","width=530,height=800");
}

function view2(code,tab) {
	window.open("/php/booth/event.php?code="+code,"","width=530,height=800");
}


function showYN(val,sid) {

	$.ajax({
		type:"POST",
		url:"./show.php",
		data:"show="+val+"&sid="+sid,
		success:function(msg){
			location.reload();
		}
	});

	
	//window.open("show.php?show="+val+"&sid="+sid,"","width=530,height=500");
}

function push(code, sid) {
	
	//window.open("push.php?sid="+sid+"&code="+code,"","width=700,height=950");
	if(confirm("Push하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./push.php",
			data:"sid="+sid+"&code="+code,
			success:function(msg){
			}
		});
	}


	/*
	if(confirm("Push하시겠습니까?")){
		//window.open("agenda_del.php?sid="+sid,"","width=930,height=720");
	}
	*/
}
function set(code) {
	window.open("set.php?code="+code,"","width=1230,height=950");
}
function add(code) {
	window.open("add.php?code="+code,"","width=1230,height=950");
}

function modify(code, sid) {

	window.open("add.php?code="+code+"&sid="+sid,"","width=1230,height=950");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./del.php",
			data:"sid="+sid,
			success:function(msg){
				location.reload();
			}
		});
	}
}

function print(sid) {
	window.open("print.php?sid="+sid,"","width=600,height=800");
}

</script>

   
<?include "./../footer.php";?>