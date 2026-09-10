<?include "./../header.php";?>


<?

if(!$num_per_page) $num_per_page = 200;
if(empty($page)) $page = 0;
$query="SELECT * FROM faculty_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM faculty_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

$query.=" order by name asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);
$cnt = $totalRecord - $page*$num_per_page;
?>
<div id="container">
	
		<h2>Faculty 관리</h2>
		<div class="numPage">	
			<select onchange="location.href='list.php?num_per_page='+this.value">
				<option value="100" <?if($num_per_page==100)echo"selected";?>>100</option>
				<option value="200" <?if($num_per_page==200)echo"selected";?>>200</option>
				<option value="500" <?if($num_per_page==500)echo"selected";?>>500</option>
				<option value="1000" <?if($num_per_page==1000)echo"selected";?>>1000</option>
			</select>
			<b>개 씩보기</b>
		</div> 
		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right;">
				<?if($event_db['session_sync']=='Y') {?>
					<a href="" onclick="javascript:view_sync('<?=$_COOKIE['code']?>')" class="btnOrg"><i class="fas fa-eye"></i>미리보기</a>
				<?}else{?>
					<a href="" onclick="javascript:view('<?=$_COOKIE['code']?>')" class="btnDef"><i class="fas fa-eye"></i>미리보기</a>			
				<?}?>

				<a href="" onclick="javascript:set('<?=$_COOKIE['code']?>')" class="btnDef"><i class="fas fa-cog"></i>Setting</a>
				<a href="" onclick="javascript:add('<?=$code?>')" class="btnDef"><i class="fas fa-plus-circle"></i>Faculty 등록</a>
			</span>
		</div>

		<div class="contents member">
 
			<table class="tblList">
				<colgroup>
					<col style="width: 3%;">
					<col style="width: 15%;">
					<col style="width: 18%;">
					<col style="width: 15%;">
					<col style="width: 18%;">
					<col style="width: 6%;">
					<col style="width: 8%;">
					<col style="width: 10%;">
					<col style="width: 8%;">
				</colgroup>
				<thead>
					<tr>
						<th>NO</th>
						<th>성함(국문)</th>
						<th>성함(영문)</th>
						<th>소속(국문)</th>
						<th>소속(영문)</th>
						<th>앱 <br/>노출여부</th>
						<th>CV</th>
						<th>사진</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){
					
				?>
				<tr class="bg">
						<td><?=$cnt?></td>
						<td style="text-align:left;"><?=$d['name']?></td>
						<td style="text-align:left;"><?=$d['name_en']?></td>
						<td style="text-align:left;"><?=$d['office']?></td>
						<td style="text-align:left;"><?=$d['office_en']?></td>
						<td><?=$d['viewYN']?></td>
						<td><?if($d['cv_file']){?><a class="inputBtnveiw" target="_blank" href="/upload/faculty/<?=$d['cv_file']?>">CV 보기</a>
						<br><br>
						<a class="inputBtndel" onclick="javascript:del_cv('<?=$d['sid']?>')">CV 삭제</a>
						<?}?></td>

						<td><?if($d['photo']){?><img src="/upload/faculty/<?=$d['photo']?>"><br><br>
						<a class="inputBtndel" onclick="javascript:del_photo('<?=$d['sid']?>')">사진 삭제</a><?}?></td>
						<td>
							<a onclick="javascript:modify('<?=$code?>','<?=$d['sid']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
							<a onclick="javascript:del('<?=$d['sid']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
						</td>
					</tr>
				<?$cnt--;}?>
					
				</tbody>
			</table>

			<ul class="pager">
			<?
				for($i = 0 ; $i*$num_per_page < $totalRecord ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?>&num_per_page=<?=$num_per_page?><?if($search){?>&search=<?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>
			</ul>
		</div>
		<!-- //contents -->
			
		<p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
    
    </div> <!-- //container -->
	
<script type="text/javascript">

function set() {
	window.open("set.php","","width=950,height=1000");
}

function view(code) {
	window.open("/php/faculty/list.php?code="+code,"","width=530,height=800");
}
function view_sync(code) {
	window.open("/voting_sync/php/faculty/list.php?code="+code,"","width=530,height=800");
}

function add(code) {
	window.open("add.php?code="+code,"","width=1230,height=720");
}

function modify(code, sid) {

	window.open("add.php?code="+code+"&sid="+sid,"","width=1230,height=720");
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

function del_cv(sid) {
	if(confirm("삭제하시겠습니까?")){

		$.ajax({
			type:"POST",
			url:"./del_cv.php",
			data:"sid="+sid,
			success:function(msg){
				location.reload();
			}
		});


	}
}

function del_photo(sid) {
	if(confirm("삭제하시겠습니까?")){

		$.ajax({
			type:"POST",
			url:"./del_photo.php",
			data:"sid="+sid,
			success:function(msg){
				location.reload();
			}
		});


	}
}

</script>
   
<?include "./../footer.php";?>