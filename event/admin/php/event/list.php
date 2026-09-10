<?
include $_SERVER['DOCUMENT_ROOT']."/admin/php/header.php";
?>

<?
$num_per_page2 = 5;
$num_per_page = 20;
if(empty($page)) $page = 0;

if(empty($tab)) $tab = 1;

$query="SELECT * FROM event_tbl where del='N' ";

if($_COOKIE['admin']!="admin"){
	$query .= "and admin='".$_COOKIE['admin']."'";
}

if($tab) {

	if($tab=="1"){
		$query .= "and eventdate>'".(time()-7*24*60*60)."'";
	} else if($tab=="2"){
		$query .= "and eventdate<'".(time()-7*24*60*60)."'";
	}

	$link_param_arr[] = "tab=$tab";
}

if($keyword) {
	$where .= "and ( name like '%$keyword%' or manager like '%$keyword%' or code like '%$keyword%' )";
	$query .= $where;

	$link_param_arr[] = "keyword=$keyword";
}

if($link_param_arr) {
	$link_param = implode("&", $link_param_arr);
}



$cnt_query = "SELECT count(*) cnt FROM event_tbl where del='N' and admin='".$_COOKIE['admin']."' $where";

if($tab=="1"){
	$cnt_query .= "and eventdate>'".(time()-7*24*60*60)."'";
}
if($tab=="2"){
	$cnt_query .= "and eventdate<'".(time()-7*24*60*60)."'";
}



$result = mysqli_query($conn, $cnt_query);
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

if($tab=="1"){
	$query.=" order by eventdate asc LIMIT ";
}
if($tab=="2"){
	$query.=" order by eventdate desc LIMIT ";
}
$query.=$page*$num_per_page.",".$num_per_page;


$result = mysqli_query($conn, $query);

?>
<div id="container" style="width:1200px;">
	
		<h2>행사 관리</h2>
		<div class="contents member">
			<p class="btn" style="top: -44px; right: 0px; position: absolute;"><a href="" onclick="javascript:add()" class="btnDef"><i class="fas fa-plus-circle"></i>행사등록</a></p>
			
			<p class="btn tooltipPoint" title="현재 진행중인 행사 목록 / 등록된 행사일로부터 5일이 지난 행사는 지난행사 목록으로 이동됩니다."  style="float:left;margin-right:20px"><a href="./list.php?tab=1&code=<?=$code?>" class="<?if($tab=="1"){?>btnDef<?}else{?>btnGrey<?}?>">행사리스트</a></p>

			<p class="btn tooltipPoint" title="지난 행사 목록" style="float:left;margin-right:20px"><a href="./list.php?tab=2&code=<?=$code?>" class="<?if($tab=="2"){?>btnDef<?}else{?>btnGrey<?}?>">지난행사</a></p>
			

	 
			
			<table class="tblList">
				<colgroup>
					<col style="width: 35%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
				</colgroup>
				<thead>
					<tr>
						<th>행사명</th>
						<th>담당자</th>
						<th>행사코드</th>
						<th>비밀번호</th>
						<th>행사일</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
				<tr class="<?=($d['code']==$_GET['code'])?"bg_sel":"bg"?>">
						<td style="padding-left:20px;text-align:left;" onclick="javascript:event_code('<?=$d['code']?>')"><?=$d['name']?></td>
						<td><?=$d['manager']?></td>
						<td><?=$d['code']?></td>
						<td><?=$d['password']?></td>
						<td><?=date("y.m.d",$d['eventdate'])?></td>
						
						<td>
							<a href="" onclick="javascript:modify('<?=$d['sid']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
							<a href="" onclick="javascript:del('<?=$d['sid']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
						</td>
						
					</tr>
				<?}?>
					
				</tbody>
			</table>
			<ul class="pager">

			<?
				$s = floor($page / $num_per_page2);
				$s = $s * $num_per_page2;
				$max = ceil($totalRecord / $num_per_page);
				if($max>$s+$num_per_page2){
					$e = $s+$num_per_page2;
				}else{
					$e = $max;
				}
			?>


			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=0&<?=$link_param?>"><i class="fas fa-angle-double-left"></i></a></li>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page-$num_per_page2>0){ echo $page-3;}else{echo "0";}?>&<?=$link_param?>"><i class="fas fa-angle-left"></i></a></li>
			<?

				for($i = $s; $i < $e ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?>&<?=$link_param?>"><?=$i+1?></a></li>
				<?}
			?>

			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page+$num_per_page2>$max-1){echo $max-1;}else{echo $page+$num_per_page2;}?>&<?=$link_param?>"><i class="fas fa-angle-right"></i></a></li>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$max-1?>&<?=$link_param?>"><i class="fas fa-angle-double-right"></i></a></li>
			</ul>

			<form id="searchForm">
			<input type="hidden" name="tab" value="<?=$tab?>">
			<table class="evnetSearch">
				<tr>
					<td><input type="text" name="keyword" value="<?=$keyword?>" placeholder="행사명,담당자명,행사코드를 입력하세요"/>
						<p class="btn">
							<input class="btnOrang" type="submit" style="width:auto" value="검색">
							<a class="btnGrey" href="<?=$PHP_SELF?>">초기화</a>
						</p>
					</td>
				</tr>
			</table>
			</form>

		</div>
		<!-- //contents -->
			
	<p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>	
    
    </div> <!-- //container -->
	
<script type="text/javascript">

function setCookie(name, value, exp) {
 
};


function agenda(code) {
	//alert(event);
	location.href="./agenda.php?code="+code;
}

function event_code(code) {
	location.href="./list.php?code="+code+"&<?=$link_param?>";
}

function add() {
	window.open("add.php","","width=800,height=900");
}

function modify(sid) {
	window.open("add.php?sid="+sid,"","width=850,height=900");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		window.open("del.php?sid="+sid,"","width=530,height=620");
	}
}

</script>

   
<?include "./../footer.php";?>