<?include "./../header.php";?>

<?

$num_per_page = 100;
if(empty($page)) $page = 0;



$query="SELECT * FROM session_tbl where code='".$code."' and type='2' and link_session='".$session."'";

$result = mysqli_query($conn, "SELECT count(*) cnt FROM session_tbl where code='".$code."' and type='2' and link_session='".$session."'");
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];

$query.=" order by session_tbl.orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;


$result = mysqli_query($conn, "select max(orderby) maxs from session_tbl where code='".$code."' and type='2' and link_session='".$session."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];





$result = mysqli_query($conn, $query);
?>
<div id="container">
	
		<h2>Session 관리</h2>
		<div class="contents member">
			

			<!--
			<p class="btn" style="top: -44px; right: 460px; position: absolute;"><a href="" onclick="javascript:css('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>CSS 설정</a></p>
			-->
			
		
			
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a  onclick="javascript:add('<?=$session?>')" class="btnDef"><i class="fas fa-plus-circle"></i>Session 등록</a></p>
			

			<table class="tblList">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 5%;">
					<col style="width: 5%;">
					<col style="width: 57%;">
					<col style="width: 20%;">
					<col style="width: 8%;">
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>NO</th>
						<th></th>
						<th>title</th>
						<th>speaker</th>
						<th>관리</th>
					</tr>
				</thead>

				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){?>

				<tr id="<?=$col['sid']?>">
					<td onclick="javascript:up('<?=$col['orderby']?>')">▲</td>
					<td><?=$col['orderby']?></td>
					<td onclick="javascript:down('<?=$col['orderby']?>','<?=$max?>')">▼</td>

					<td><?=$col['title']?></td>
					<td><?=$col['speaker']?></td>
					<td>

						<a href="" onclick="javascript:modify('<?=$col['sid']?>','<?=$session?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
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

function add(session) {
	window.open("sub_add.php?session="+session,"","width=900,height=1000");
}

function set() {
	window.open("set.php","","width=950,height=1000");
}


function room() {
	window.open("room.php","");
}

function timeset() {
	window.open("time.php","");
}


function css() {
	window.open("css.php","","width=530,height=700");
}
function view(code) {
	window.open("/php/feedback/view.php?code="+code,"","width=530,height=800");
}


function modify(sid,session) {
	window.open("sub_add.php?session="+session+"&sid="+sid,"","width=900,height=1000");
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