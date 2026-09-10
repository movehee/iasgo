<?include "./../header.php";?>


<?

$num_per_page = 9999;
if(empty($page)) $page = 0;
$query="SELECT * FROM bbs_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM bbs_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

$query.=" order by orderby asc, sid desc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);

?>
<div id="container">
	
		<h2>공지사항 관리</h2>

		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right;">
				<a href="" onclick="javascript:set('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i> Setting</a>
				<a href="" onclick="javascript:add('<?=$code?>')" class="btnDef">공지사항 등록</a>
			</span>
		</div>
		<div class="contents member">
			<table class="tblList">
				<colgroup>
					<col style="width: 6%;">
					<col style="width: 10%;">
					<col style="width: 52%;">
					<col style="width: 8%;">
					<col style="width: 8%;">
					<!-- <col style="width: 8%;"> -->
					<col style="width: 8%;">
				</colgroup>
				<thead>
					<tr>
						<th>No</th>
						<th>push예악일자</th>
						<th>Subject</th>
						<th>Noti여부</th>
						<th>공개여부</th>
						<!-- <th>Push</th> -->
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				
				<?while(is_array($d = mysqli_fetch_array($result))){
				
					$pushdate = "";
					if($d['push_date']) {

						$pushdate = date('y.m.d H:i', $d['push_date']);
					}
				?>
					<tr class="bg" id="<?=$d['sid']?>">
						<td><?=$d['orderby']?></td>
						<td><?=$pushdate?></td>
						<td style="overflow: hidden; max-width:700px; text-overflow: ellipsis;"><?=$d['subject']?></td>
						<td class="btn"><a onclick="javascript:notiYN('<?=$d['notiYN']?>','<?=$d['sid']?>')" class="btnBdDef <?if($d['notiYN']=="N"){?> ok<?}?>"><?if($d['notiYN']=="N"){?> 미<?}?>사용</a></td>
						<td class="btn"><a onclick="javascript:showYN('<?=$d['showYN']?>','<?=$d['sid']?>')" class="btnBdDef <?if($d['showYN']=="N"){?> ok<?}?>"><?if($d['showYN']=="N"){?> 미<?}?>공개</a></td>
						<!-- <td class="btn"><a onclick="javascript:push('<?=$d['code']?>','<?=$d['sid']?>')" class="btnBdDef">Push</a></td> -->
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
			
		
  <p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>  
    </div> <!-- //container -->
	
<script type="text/javascript">

$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			index = index+1;
			$.ajax({
			type:"POST",
			url:"./orderby.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){
				

			}
		});


    });
  }
});
});

function notiYN(val,sid) {
	$.ajax({
		type:"POST",
		url:"./noti.php",
		data:"noti="+val+"&sid="+sid,
		success:function(msg){
			location.reload();
		}
	});

	
	//window.open("show.php?show="+val+"&sid="+sid,"","width=530,height=500");
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
			url:"push.php",
			data:"sid="+sid+"&code="+code,
			success:function(msg){
				console.log(msg)
				alert(msg);
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