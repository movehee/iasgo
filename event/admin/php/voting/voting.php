<?include "./../header.php";?>

<?

$num_per_page = 10;
if(empty($page)) $page = 0;


$result = mysqli_query($conn, "select * from lecture_tbl where code='".$_COOKIE['code']."' and del='N' and sid='".$lecture."'");
$lec_row = mysqli_fetch_array($result);


$query="SELECT * FROM voting_tbl where code='".$_COOKIE['code']."' and lecture='".$lecture."' and del='N'";


$result = mysqli_query($conn, "select max(orderby) maxs from voting_tbl where code='".$_COOKIE['code']."' and del='N' and lecture='".$lecture."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$result = mysqli_query($conn, "SELECT count(*) cnt FROM voting_tbl where code='".$_COOKIE['code']."' and lecture='".$lecture."' and del='N'");
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];

$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;


$result = mysqli_query($conn, $query);





?>
<div id="container">
		<h2>Voting 관리</h2>
		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right;">
				<a href="list.php?code=<?=$code?>" class="btnDef tooltipPont" title="연자목록"><i class="fas fa-users"></i>연자목록</a>
				<!-- 
				  <p class="btn" style="top: -44px; right: 410px; position: absolute; "><a onclick=" "  class="btnDef tooltipPont" title="보팅 결과초기화"><i class="fas fa-trash-alt"></i> 보팅결과 초기화</a></p>	 -->  	
				<!--<a onclick="javascript:excel('<?=$_COOKIE['code']?>','<?=$lecture?>')"  class="btnDef tooltipPont" title="해당 연자별 보팅 결과보기"><i class="far fa-chart-bar"></i> 결과보기</a>-->

				<select class="excel_proc tooltipPont" e-link="excel.php?code=<?=$_COOKIE['code']?>&lecture=<?=$lecture?>" style=" font-size:13px; width: 140px;  height: 40px; " title="해당 연자별 보팅 결과보기">
					<option value="">결과보기</option>
					<option value="view">엑셀보기</option>
					<option value="down">엑셀다운</option>
				</select>

				<a  onclick="javascript:add(<?=$lecture?>)" class="btnDef tooltipPont" title="보팅 문제 등록"><i class="fas fa-plus-circle"></i>Voting 등록</a>
				<a  onclick="javascript:add_sub(<?=$lecture?>)" class="btnDef tooltipPont" title="예비 문제 등록 "><i class="fas fa-plus-circle"></i>예비문제 등록</a>

			
				<select id="all_delay"  style=" font-size:13px; width: 140px;  height: 40px; ">
					<option value="">카운트 일괄변경</option>
				<? foreach($config['delay'] as $tkey=>$tval){?>
					<option value="<?=$tkey?>"><?=$tval?></option>
				<?}?>
				</select>
				<a onclick="all_delay_chg()" class="btnDef tooltipPoint" title="시간이 변경되고 시작 타입이 카운트다운이 됩니다.">변경</a>
			</span>
		</div>
		<div class="contents">
			<div><h3 class="speaker"><?=$lec_row['name']?></h3></div>
			
				<?while(is_array($col = mysqli_fetch_array($result))){?>
				<div class="voting">

			<table class="tblDef">
				<colgroup>
					<col style="width: 168px;">
					<col style="width: 145px;">
					<col style="width: 145px;">
					<col style="width: 145px;">
					<col style="width: 145px;">
					<col style="width: 145px;">
					<col style="width: *;">
				</colgroup>
		
				<tbody>
				<tr>
					<th>

					
						<span class="btn" style=""><a  onclick="javascript:up('<?=$col['orderby']?>','<?=$lecture?>')">▲</a></span>
						<span class="btn"><a  onclick="javascript:down('<?=$col['orderby']?>','<?=$max?>','<?=$lecture?>')">▼</a></span>
						<span><br>질문</span>
						<!--
						<span class="btn folding"><a href="#">접기</a></span>
						-->
						
					</th>
					<td colspan="5" class="tit"><?=$col['question']?></td>
					<td>
					<?if($col['image']){?>
						<img src="/upload/<?=$col['image']?>" alt="Thumbnail">
					<?}else{?>
						<img src="/admin/image/thumb_noImg.png" alt="Thumbnail">
					<?}?>
					</td>
				</tr>

				<tr class="foldingArea">
					<th><span>답변</span></th>
					<td colspan="5" class="type0<?=$col['ui']?>">
						<div>
	
						<?if($col['answer1'] || $col['answer1_img']){?>
						<dl class="voting">
							<dt><?=$col['answer1']?></dt>
							<dd>
								<div class="img">
									<img src="/upload/<?=$col['answer1_img']?>" alt="">
								</div>
							</dd>
						</dl>
						<?}?>

						<?if($col['answer2'] || $col['answer2_img']){?>
						<dl class="voting">
							<dt><?=$col['answer2']?></dt>
							<dd>
								<div class="img">
									<img src="/upload/<?=$col['answer2_img']?>" alt="">
								</div>
							</dd>
							</dl>
						<?}?>

						<?if($col['answer3'] || $col['answer3_img']){?>
						<dl class="voting">
							<dt><?=$col['answer3']?></dt>
							<dd>
								<div class="img">
									<img src="/upload/<?=$col['answer3_img']?>" alt="">
								</div>
							</dd>
							</dl>
						<?}?>

						<?if($col['answer4'] || $col['answer4_img']){?>
						<dl class="voting">
							<dt><?=$col['answer4']?></dt>
							<dd>
								<div class="img">
									<img src="/upload/<?=$col['answer4_img']?>" alt="">
								</div>
							</dd>
							</dl>
						<?}?>

						<?if($col['answer5'] || $col['answer5_img']){?>
						<dl class="voting">
							<dt><?=$col['answer5']?></dt>
							<dd>
								<div class="img">
									<img src="/upload/<?=$col['answer5_img']?>" alt="">
								</div>
							</dd>
							</dl>
						<?}?>

						<?if($col['answer6'] || $col['answer6_img']){?>
						<dl class="voting">
							<dt><?=$col['answer6']?></dt>
							<dd>
								<div class="img">
									<img src="/upload/<?=$col['answer6_img']?>" alt="">
								</div>
							</dd>
							</dl>
						<?}?>

						<?if($col['answer7'] || $col['answer7_img']){?>
						<dl class="voting">
							<dt><?=$col['answer7']?></dt>
							<dd>
								<div class="img">
									<img src="/upload/<?=$col['answer7_img']?>" alt="">
								</div>
							</dd>
							</dl>
						<?}?>

						<?if($col['answer8'] || $col['answer8_img']){?>
						<dl class="voting">
							<dt><?=$col['answer8']?></dt>
							<dd>
								<div class="img">
									<img src="/upload/<?=$col['answer8_img']?>" alt="">
								</div>
							</dd>
							</dl>
						<?}?>
						
						</dl>
						</div>
					</td>
					<td class="btn">
					<!--
						<a href="#" class="fullScreen"><img src="/admin/image/icon_fullScreen.png" alt="전체화면"></a>
						<a href="#" class="votingReset"><img src="/admin/image/icon_votingReset.png" alt="VOTING 결과 초기화"></a>
					-->
						<a  onclick="javascript:view(<?=$col['sid']?>)" class="btnDef tooltipPoint" title="보팅APP 미리보기"><i class="fas fa-mobile-alt"></i>보팅 사용자화면</a><br><br>

						<a  onclick="javascript:screen('<?=$col['lecture']?>','<?=$col['orderby']?>')" class="btnDef tooltipPoint" title="보팅 스크린화면"><i class="fas fa-eye"></i>보팅 스크린화면</a>
						<?if($col['status']=="2"){?>
						<br><br>
						<a  onclick="javascript:reset('<?=$col['sid']?>')" class="btnDef "><i class="fas fa-eye"></i>초기화</a>
						<?}?>

					</td>
				</tr>

				<tr class="foldingArea">
					<th>시간</th>
					<td><?=$col['delay']?>초</td>
					<th>보팅타입</th>
					<td>기본</td>
					<th>UI 타입</th>
					<td><?=$col['ui']?>열</td>
					<td class="btn">
						<div class="util">
							<a onclick="javascript:modify('<?=$lecture?>','<?=$col['sid']?>')" class="btnGrey">수정</a>
							<a onclick="javascript:del('<?=$lecture?>','<?=$col['sid']?>')" class="btnPoint">삭제</a>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
				<?}?>
					
				
			</div>

			<ul class="pager">
			<?
				for($i=0; $i*$num_per_page < $totalRecord ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?>&lecture=<?=$lecture?><?if($search){?>&search=<?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>
			</ul>
		</div>
		<!-- //contents -->
    </div> <!-- //container -->
    <p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
	
<script type="text/javascript">
	
	var votingDel = function () {
				
	}

function reset(sid) {

	$.ajax({
		type:"POST",
		url:"./reset.php",
		data:"sid="+sid,
		success:function(msg){
			location.reload();
		}
	});
}


function up(sid,lecture) {
	if(sid>1)
	{
		val2 = sid-1;
		window.open("order.php?val1="+sid+"&val2="+val2+"&lecture="+lecture,"","width=530,height=770");
	}
}
function down(sid,max,lecture) {
	if(Number(sid)<Number(max))
	{
		val2 = Number(sid)+Number(1);
		window.open("order.php?val1="+sid+"&val2="+val2+"&lecture="+lecture,"","width=530,height=770");
	}
}

function voting(sid) {
	location.href="./voting.php?lecture="+sid;
}
function screen(lecture,orderby) {
	window.open("./screen.php?lecture="+lecture+"&orderby="+orderby);
}

function excel(code , lecture) {
	window.open("./excel.php?code="+code+"&lecture="+lecture);
}


function view(sid) {
	window.open("/php/voting/view.php?sid="+sid,"","width=500,height=900");
}

function add(lecture) {
	window.open("voting_add.php?lecture="+lecture,"","width=1300,height=900");
}

function add_sub(lecture) {
	window.open("post_sub.php?lecture="+lecture,"","width=530,height=770");
}

function modify(lecture,sid) {
	window.open("voting_add.php?lecture="+lecture+"&sid="+sid,"","width=1300,height=900");
}	

function del(lecture,sid) {
	if(confirm("삭제하시겠습니까?")){
	window.open("voting_del.php?lecture="+lecture+"&sid="+sid,"","width=530,height=520");
	}
}

function all_delay_chg() {

	var val = $("#all_delay").val();

	if(!val) {
		alert("시간을 선택해주세요");
		$("#all_delay").focus();
		return;
	}

	if(confirm("변경하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./voting_all_delay_chg.php",
			data:"delay="+val+"&code=<?=$code?>&lecture=<?=$lecture?>",
			success:function(msg){
				location.reload();
			}
		});
	}
}

$(function() {
	/*
 $("tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
		index ++;
			$.ajax({
			type:"POST",
			url:"./voting_order2.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){
				

			}
		});


    });
  }
  */


	$(".excel_proc").change(function(){
		
		var val = $(this).val();
		var link = $(this).attr("e-link");

		if(val == 'view') {
			window.open(link+"&excel_type="+val,"","width=1300,height=800");

		}
		else if(val == 'down'){
			location.href = link+"&excel_type="+val;
		}

		
	});
});

</script>

   
<?include "./../footer.php";?>