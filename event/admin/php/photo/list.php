<?include "./../header.php";?>


<?



$num_per_page = 100;
if(empty($page)) $page = 0;

if(empty($tab)){
	$result = mysqli_query($conn, "select sid from agenda_tbl where code='".$_COOKIE['code']."' and del='N' order by sid asc limit 1");
	$row = mysqli_fetch_array($result);
	$tab = $row['sid'];
}


$query="SELECT * FROM photo_tbl where code='".$_COOKIE['code']."' and del='N'";
$query.=" and tab='".$tab."'";
$query.=" order by sid asc";
$result = mysqli_query($conn, $query);

?>
<div id="container">
	
		<h2>Photo 관리</h2>
		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right;">
				<a href="" onclick="javascript:view('<?=$_COOKIE['code']?>','<?=$tab?>')" class="btnDef"><i class="fas fa-eye"></i>미리보기</a>
				<a href="" onclick="javascript:set('<?=$_COOKIE['code']?>')" class="btnDef"><i class="fas fa-cog"></i>Setting</a>
				<a  onclick="javascript:add('<?=$code?>','<?=$tab?>')" class="btnDef"><i class="fas fa-plus-circle"></i>등록</a>
			</span>
		</div>
		<div class="contents member">
			<?
			$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$_COOKIE['code']."' and del='N' order by sid asc");
			while(is_array($tab_col = mysqli_fetch_array($tab_result))){
			?>

			<p class="btn" style="float:left;margin-right:20px"><a href="./list.php?tab=<?=$tab_col['sid']?>" class="<?if($tab==$tab_col['sid']){?>btnDef<?}else{?>btnGrey<?}?>"><?=$tab_col['name']?></a></p>



			<?}?>

			<p class="btn" style="float:left;margin-right:20px"><a href="./list.php?tab=-1" class="<?if($tab=="-1"){?>btnDef<?}else{?>btnGrey<?}?>">사용자 업로드</a></p>
			<p class="btn" style="float:left;margin-right:20px"><a href="./list.php?tab=-2" class="<?if($tab=="-2"){?>btnDef<?}else{?>btnGrey<?}?>">포토존</a></p>

			<p class="btn" style="float:left;margin-right:20px"><a onclick="javascript:delALL('<?=$tab?>','<?=$code?>')" class="btnGrey" style="background-color:#ff0000">전체 삭제</a></p>

			<br><br><br><br>
			<ul id="photoList">
			<?while(is_array($col = mysqli_fetch_array($result))){?>
				<li><a href="#">
					<img src="/upload/photo/<?=$col['url']?>" alt="" />
					<span onclick="javascript:del('<?=$col['sid']?>')" class="count">삭제</span>
				</a></li>
			<?}?>
			</ul>


		</div>
		<!-- //contents -->
			<p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">

function view(code,tab) {
	window.open("/php/photo/list.php?code="+code+"&tab="+tab,"","width=530,height=800");
}

function set() {
	window.open("set.php","","width=950,height=1000");
}
function add(code,tab) {
	window.open("add.php?code="+code+"&tab="+tab,"","width=1230,height=950");
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

function delALL(sid,code) {
	if(confirm("전체삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./delALL.php",
			data:"sid="+sid+"&code="+code,
			success:function(msg){
				location.reload();
			}
		});
	}
}

</script>

   
<?include "./../footer.php";?>