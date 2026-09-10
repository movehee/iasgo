<?include "./../header.php";?>


<?

$num_per_page = 10;
if(empty($page)) $page = 0;
$query="SELECT a.*,(select count(sid) from voting_tbl b where b.del='N' and b.lecture=a.sid ) v_num FROM lecture_tbl a where a.code='".$_COOKIE['code']."' and a.del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM lecture_tbl where code='".$_COOKIE['code']."' and del='N'");
$row = mysqli_fetch_array($result);

$totalRecord = $row['cnt'];

$query.=" order by a.sid asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);

?>
<div id="container">
	
		<h2>연자 관리</h2>
		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right;">
				<a href="./excel.php" target="_blank"  class="btnDef tooltipPoint" title="전체보팅결과보기"><i class="far fa-chart-bar"></i> 결과보기</a>
				<a href="" onclick="javascript:add()" class="btnDef tooltipPoint" title="보팅문제 등록 시 연자,혹은강의명을 먼저 등록 후 보팅 문제를 등록한다"><i class="fas fa-plus-circle"></i> 연자등록</a>
			</span>
		</div>

		<div class="contents">
			<table class="tblList">
				<colgroup>
					<col style="width: 40%;">
					<col style="width: 15%;">
					<col style="width: 15%;">
				</colgroup>
				<thead>
					<tr>
						<th>연자 정보</th>
						<th>보팅</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
				<tr class="bg">
					<td><?=$d['name']?></td>
					<td><a href="#" onclick="javascript:voting('<?=$d['sid']?>')" class="icon ok tooltipPoint" title="해당 연자의 보팅문제 ">보팅 관리<?=$d['v_num']?"(".$d['v_num'].")":"";?></a></td>
					<td class="btn">
						<div class="util">
							<a href="#" class="btnGrey" onclick="javascript:modify('<?=$d['sid']?>')">수정</a>
							<a href="#" class="btnPoint" onclick="javascript:del('<?=$d['sid']?>')">삭제</a>
						</div>
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


function voting(sid) {
	location.href="./voting.php?lecture="+sid;
}


function add() {
	window.open("add.php","","width=530,height=335");
}

function modify(sid) {
	window.open("add.php?sid="+sid,"","width=530,height=520");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
	window.open("del.php?sid="+sid,"","width=530,height=520");
	}
}

</script>

   
<?include "./../footer.php";?>