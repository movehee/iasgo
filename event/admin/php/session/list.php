<?include "./../header.php";?>

<?

$num_per_page = 100;
if(empty($page)) $page = 0;

if(empty($tab)){
	$result = mysqli_query($conn, "select sid from agenda_tbl where code='".$_COOKIE['code']."' and del='N' order by sid asc limit 1");
	$row = mysqli_fetch_array($result);
	$tab = $row['sid'];
}

$query="SELECT * FROM session_tbl where code='".$_COOKIE['code']."' and type='1' and tab='".$tab."'";

$result = mysqli_query($conn, "SELECT count(*) cnt FROM session_tbl where code='".$_COOKIE['code']."' and type='1' and tab='".$tab."'");
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];

$query.=" order by session_tbl.orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;


$result = mysqli_query($conn, "select max(orderby) maxs from session_tbl where code='".$_COOKIE['code']."' and type='1' and tab='".$tab."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];





$result = mysqli_query($conn, $query);
?>
<div id="container">
	
		<h2>Session 관리</h2>
		<div class="contents member">
			

			<!--
			<p class="btn" style="top: -44px; right: 460px; position: absolute;"><a href="" onclick="javascript:css('<?=$_COOKIE['code']?>')" class="btnDef"><i class="fas fa-cog"></i>CSS 설정</a></p>
			-->
			
			<p class="btn" style="top: -44px; right: 440px; position: absolute;"><a href="" onclick="javascript:timeset()" class="btnDef"><i class="fas fa-cog"></i>시간 설정</a></p>
			
			<p class="btn" style="top: -44px; right: 295px; position: absolute;"><a href="" onclick="javascript:room()" class="btnDef"><i class="fas fa-cog"></i>ROOM 설정</a></p>


			<p class="btn" style="top: -44px; right: 180px; position: absolute;"><a href="" onclick="javascript:set('<?=$_COOKIE['code']?>')" class="btnDef"><i class="fas fa-cog"></i>Setting</a></p>
			
		
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a  onclick="javascript:add('<?=$tab?>')" class="btnDef"><i class="fas fa-plus-circle"></i>Session 등록</a></p>
			
			
			<?
			$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$_COOKIE['code']."' and del='N' order by sid asc");
			while(is_array($tab_col = mysqli_fetch_array($tab_result))){
			?>

			<p class="btn" style="float:left;margin-right:20px"><a href="./list.php?tab=<?=$tab_col['sid']?>" class="<?if($tab==$tab_col['sid']){?>btnDef<?}else{?>btnGrey<?}?>"><?=$tab_col['name']?></a></p>



			<?}?>


			<table class="tblList">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 5%;">
					<col style="width: 5%;">
					<col style="width: 50%;">
					<col style="width: 20%;">
					<col style="width: 7%;">
					<col style="width: 8%;">
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>NO</th>
						<th></th>
						<th>theme</th>
						<th>chair</th>
						<th>sub</th>
						<th>관리</th>
					</tr>
				</thead>

				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){?>

				<tr id="<?=$col['sid']?>">
					<td onclick="javascript:up('<?=$col['orderby']?>')">▲</td>
					<td><?=$col['orderby']?></td>
					<td onclick="javascript:down('<?=$col['orderby']?>','<?=$max?>')">▼</td>

					<td><?=$col['theme']?></td>
					<td><?=$col['chair']?></td>
					
					<td><a onclick="javascript:sub_session('<?=$col['sid']?>')" class="icon ok">SUB</a></td>
					<td>

						<a href="" onclick="javascript:modify('<?=$col['sid']?>','<?=$tab?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
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
			
		<p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
    
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

function add(tab) {
	window.open("add.php?tab="+tab,"","width=530,height=1000");
}

function sub_session(sid) {
	window.open("sub.php?session="+sid,"","width=1300,height=800");
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


function modify(sid,tab) {
	window.open("add.php?tab="+tab+"&sid="+sid,"","width=530,height=1000");
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