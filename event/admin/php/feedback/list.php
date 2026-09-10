<?include "./../header.php";?>

<?

$num_per_page = 100;
if(empty($page)) $page = 0;
$query="SELECT * FROM feedback_tbl where code='".$_COOKIE['code']."' and  del='N'";

$result = mysqli_query($conn, "SELECT count(*) cnt FROM feedback_tbl where code='".$_COOKIE['code']."' and  del='N'");
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];

$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;


$result = mysqli_query($conn, "select max(orderby) maxs from feedback_tbl where code='".$_COOKIE['code']."' and del='N'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$result = mysqli_query($conn, $query);
?>
<div id="container">
	
		<h2>Feedback 관리</h2>
			<div class="btnArea" style="width:100%;">
				<span class="btn" style="float:right;">
					<a href="" onclick="javascript:set('<?=$code?>')" class="btnDef" title="피드백 설정/send버튼 텍스트는 DB set_tbl 에서 수정가능/bg/font color은 css설정에서 수정가능"><i class="fas fa-cog"></i>Setting</a>
					<a onclick="javascript:view2('<?=$_COOKIE['code']?>')" class="btnDef " title="피드백 통계(실시간으로 항목 별 통계)"><i class="far fa-chart-bar"></i>통계보기</a>
					<select class="excel_proc" e-link="excel.php" style=" font-size:13px; width: 140px;  height: 40px; ">
						<option value="">결과보기</option>
						<option value="view">엑셀보기</option>
						<option value="down">엑셀다운</option>
					</select>
					<a href="" onclick="javascript:view('<?=$_COOKIE['code']?>')" class="btnDef " title="미리보기"><i class="fas fa-eye"></i>미리보기</a>
					<a href="" onclick="javascript:add('<?=$_COOKIE['code']?>')" class="btnDef " title="피드백 등록"><i class="fas fa-plus-circle"></i>Feedback 등록</a>
				</span>
			</div>
		<div class="contents member">
			<table class="tblList">
				<colgroup>
					<col style="width:10px;">
					<col style="width:20px;">
					<col style="width:10px;">
					<col style="width:600px;">
					<col style="width:60px;">
					<col>
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>NO</th>
						<th></th>
						<th>정보</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){?>

				<tr class="bg" id="<?=$col['sid']?>">
						<td onclick="javascript:up('<?=$col['orderby']?>')">▲</td>
						<td><?=$col['orderby']?></td>
						<td onclick="javascript:down('<?=$col['orderby']?>','<?=$max?>')">▼</td>


						<td>
						<?=$col['type']?> : 
						<?if($col['type']=="0"){?>
							<?=$col['val1']?> <?=$col['val2']?>
						<?}?>

						<?if($col['type']=="1"){?>
							<?=$col['val1']?>
						<?}?>

						<?if($col['type']=="2"){?>
							<?=$col['val1']?>
						<?}?>

						<?if($col['type']=="3"){?>
							<?=$col['val1']?>
						<?}?>

						<?if($col['type']=="11"){?>
							한줄로 선택
						<?}?>
						<?if($col['type']=="12"){?>
							한문항당 한줄
						<?}?>
						<?if($col['type']=="21"){?>
							selected
						<?}?>

						<?if($col['type']=="31"){?>
							점수판 type1
						<?}?>
						<?if($col['type']=="32"){?>
							점수판 type2
						<?}?>
						<?if($col['type']=="41"){?>
							의견접수란
						<?}?>
						
						</td>
				
						<td>
							<a href="" onclick="javascript:modify('<?=$col['sid']?>','<?=$_COOKIE['code']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
							<a href="" onclick="javascript:del('<?=$col['sid']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
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
		
		<?if($code == 'ksoug2019f'){?>
		<div style="text-align:right">
		<select class="excel_proc" e-link="ksoug2019f.php" style=" font-size:13px; width: 140px;  height: 40px; ">
			<option value="">번호별</option>
			<option value="view">엑셀보기</option>
			<option value="down">엑셀다운</option>
		</select>

		<select class="excel_proc" e-link="ksoug2019f.php?order=s3" style=" font-size:13px; width: 140px;  height: 40px; ">
			<option value="">순위별</option>
			<option value="view">엑셀보기</option>
			<option value="down">엑셀다운</option>
		</select>
		</div>
		<?}?>
    
    </div> <!-- //container -->
	
<script type="text/javascript">

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

function set(code) {
	window.open("set.php?code="+code,"","width=950,height=1000");
}



function add(code) {
	window.open("add.php?code="+code,"","width=800,height=1000");
}

function css() {
	window.open("css.php","","width=530,height=700");
}
function view(code) {
	window.open("/php/feedback/view.php?code="+code,"","width=530,height=800");
}
function view2(code) {
	window.open("/php/feedback/view2.php?code="+code,"","width=530,height=800");
}


function modify(sid,code) {
	window.open("add.php?sid="+sid+"&code="+code,"","width=800,height=1000");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		window.open("del.php?sid="+sid,"","width=530,height=520");
	}
}

$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			index = index+1;
			$.ajax({
			type:"POST",
			url:"./voting_order2.php",
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