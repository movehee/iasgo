<?include "./../header.php";?>


<?

$num_per_page = 100;
if(empty($page)) $page = 0;
$query="SELECT * FROM banner_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM banner_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);

?>
<div id="container">
	
		<h2>Banner 관리</h2>
		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right;">
				<a href="" onclick="javascript:add('<?=$code?>')" class="btnDef"><i class="fas fa-plus-circle"></i>Banner 등록</a>
			</span>
		</div>
		<div class="contents member">
			<table class="tblList">
				<colgroup>
					<col style="width: 8%;">
					<col style="width: 40%;">
					<col style="width: 12%;">
					<col style="width: 12%;">
					<col style="width: 12%;">
					<col style="width: 6%;">
					<col style="width: 8%;">
				</colgroup>
				<thead>
					<tr>
						<th>NO</th>
						<th>링크URL</th>
						<th>시작일</th>
						<th>종료일</th>
						<th>image</th>
						<th>타입</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
					<tr class="bg" id="<?=$d['sid']?>">
						<td><?=$d['orderby']?></td>
						<td><?=$d['linkurl']?></td>
						<td><?=date("y-m-d",$d['sdate'])?></td>
						<td><?=date("y-m-d",$d['edate'])?></td>
						<td><img src="/upload/banner/<?=$d['image']?>"></td>
						<td><?if($d['gubun']=="1"){?>배너<?}else{?>인트로<?}?></td>
						<td>
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
			
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">


$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			index = index+1;
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
});


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
	window.open("set.php?code="+code,"","width=700,height=950");
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

</script>

   
<?include "./../footer.php";?>