<?include "./../header.php";?>


<?

$num_per_page = 100;
if(empty($page)) $page = 0;
$query="SELECT * FROM agenda_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM agenda_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

$query.=" order by day asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);

?>
<div id="container">
	
		<h2>Agenda 관리</h2>
		<div class="contents member">
<!--
			<p class="btn" style="top: -44px; right: 160px; position: absolute;"><a href="" onclick="javascript:css('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>CSS 설정</a></p>
-->
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a href="" onclick="javascript:add('<?=$code?>')" class="btnDef">Agenda 등록</a></p>

			<table class="tblList">
				<colgroup>
					<col style="width: 20%;">
					<col style="width: 20%;">
					<col style="width: 30%;">
					<col style="width: 30%;">
				</colgroup>
				<thead>
					<tr>
						<th>NO</th>
						<th>이미지</th>
						<th>행사일</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
				<tr class="bg">
						<td><?=$d['day']?></td>
						<td><img src="/upload/agenda/<?=$d['image']?>"></td>
						<td><?=date("y.m.d",$d['eventdate'])?></td>
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

function css(code) {
	window.open("css.php?code="+code,"","width=530,height=700");
}

function add(code) {
	window.open("agenda_add.php?code="+code,"","width=1230,height=720");
}

function modify(code, sid) {

	window.open("agenda_add.php?code="+code+"&sid="+sid,"","width=1230,height=720");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		window.open("agenda_del.php?sid="+sid,"","width=930,height=720");
	}
}

</script>

   
<?include "./../footer.php";?>