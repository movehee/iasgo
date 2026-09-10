<?include "./../header.php";?>

<?

$query="SELECT * FROM session_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);

$num_per_page = 300;
if(empty($page)) $page = 0;



$query="SELECT * FROM abstract_tbl where code='".$code."'";

$result = mysqli_query($conn, "SELECT count(*) cnt FROM abstract_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];

$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;
//$query.=" order by abs_sid";

$result = mysqli_query($conn, "select max(orderby) maxs from abstract_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$category_query="SELECT * FROM abstract_category_tbl WHERE code='".$code."' and sid not in (select parent from abstract_category_tbl) and del='N' order by orderby asc";
$category_result=mysqli_query($conn, $category_query);

//echo $category_query;
/*


$room_query="SELECT * FROM session_room_tbl WHERE code='".$code."' and del='N' order by orderby asc";
$room_result=mysqli_query($conn, $room_query);

$time_query="SELECT * FROM session_time_tbl WHERE code='".$code."' and del='N' and tab='".$tab."' order by orderby asc";
$time_result=mysqli_query($conn, $time_query);
*/
$result = mysqli_query($conn, $query);
?>
<div id="container" style="width:1700px">
	<h2>Abstract 관리</h2>
		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right;">
				<a class="btnDef tooltipPoint" title="초록 미리보기" href="" onclick="javascript:view('<?=$code?>')"  ><i class="fas fa-eye"></i>미리보기</a>
				<a  class="btnDef tooltipPoint" title="초록 카테고리 설정" href="" onclick="javascript:categoryset('<?=$code?>')"  ><i class="fas fa-cog"></i>Category 설정</a>
				<a class="btnDef tooltipPoint" title="초록 셋팅" href="" onclick="javascript:set('<?=$code?>')"  ><i class="fas fa-cog"></i>Setting</a>
				<input type="text" style="height:40px; cursor:text; width:45px;padding:0px; margin-left: 5px;" name="abstract_add_cnt" id="abstract_add_cnt"  value="" />
				<a title="초록 등록 필드 수 입력 후 > Abstract 등록 버튼 누르면 필드 생성" onclick="javascript:add_abstract('<?=$code?>')" class="btnDef">Abstract 등록</a>
			</span>
		</div>
		<div class="contents member">
			<table class="tblList">
			
				<thead>
					<tr>
						<th>NO</th>

						<?if($s['abs_sid']!="N"){?>
						<th>abs_sid</th>
						<?}?>
						<?if($s['abs_no']!="N"){?>
						<th>abs_no</th>
						<?}?>
						<th>title</th>
						<th>category</th>

						<?if($s['abs_info1']){?>
						<th><?=$s['abs_info1']?></th>
						<?}?>
						<?if($s['abs_info2']){?>
						<th><?=$s['abs_info2']?></th>
						<?}?>
						<?if($s['abs_info3']){?>
						<th><?=$s['abs_info3']?></th>
						<?}?>
						<?if($s['abs_info4']){?>
						<th><?=$s['abs_info4']?></th>
						<?}?>
						<?if($s['abs_info5']){?>
						<th><?=$s['abs_info5']?></th>
						<?}?>
						<?if($s['abs_info6']){?>
						<th><?=$s['abs_info6']?></th>
						<?}?>
						<?if($s['abs_info7']){?>
						<th><?=$s['abs_info7']?></th>
						<?}?>
						<?if($s['abs_info8']){?>
						<th><?=$s['abs_info8']?></th>
						<?}?>
						<?if($s['abs_info9']){?>
						<th><?=$s['abs_info9']?></th>
						<?}?>
						<?if($s['abs_info10']){?>
						<th><?=$s['abs_info10']?></th>
						<?}?>
						<?if($s['abs_info11']){?>
						<th><?=$s['abs_info11']?></th>
						<?}?>
						<?if($s['abs_info12']){?>
						<th><?=$s['abs_info12']?></th>
						<?}?>
						<?if($s['abs_info13']){?>
						<th><?=$s['abs_info13']?></th>
						<?}?>
						<?if($s['abs_info14']){?>
						<th><?=$s['abs_info14']?></th>
						<?}?>
						<?if($s['abs_info15']){?>
						<th><?=$s['abs_info15']?></th>
						<?}?>
						<?if($s['abs_info16']){?>
						<th><?=$s['abs_info16']?></th>
						<?}?>
						<th width="5%">관리</th>
					</tr>
				</thead>

				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){
				
				
				?>

				<tr class="bg" id="<?=$col['sid']?>">
					<td><?=$col['orderby']?></td>
					<?if($s['abs_sid']!="N"){?>
					<td><input onchange="changeVal(this,'abs_sid','<?=$col['sid']?>')" type="text" name="abs_sid" id="abs_sid"  value="<?=$col['abs_sid']?>" /></td>
					<?}?>
				
					
					<?if($s['abs_no']!="N"){?>
					<td><input onchange="changeVal(this,'abs_no','<?=$col['sid']?>')" type="text" name="abs_no" id="abs_no"  value="<?=$col['abs_no']?>" /></td>
					<?}?>
					<td><input onchange="changeVal(this,'title','<?=$col['sid']?>')" type="text" name="title" id="title"  value="<?=$col['title']?>" /></td>
					<td>
					<select onchange="changeVal(this,'category','<?=$col['sid']?>')" name="category" id="category">
						<option value="">:: select ::</option>
						<?
						while(is_array($category_d = mysqli_fetch_array($category_result))){?>
							<option<?=$col['category']==$category_d['sid']?' selected="true"':''?> value="<?=$category_d['sid']?>"><?=$category_d['info']?></option>
						<?}
						mysqli_data_seek($category_result,0); 
						?>
					</select>
					</td>

					<?if($s['abs_info1']){?>
						<td><input onchange="changeVal(this,'info1','<?=$col['sid']?>')" type="text" name="info1" id="info1"  value="<?=$col['info1']?>" /></td>
					<?}?>
					<?if($s['abs_info2']){?>
						<td><input onchange="changeVal(this,'info2','<?=$col['sid']?>')" type="text" name="info2" id="info2"  value="<?=htmlspecialchars($col['info2'])?>" /></td>
					<?}?>
					<?if($s['abs_info3']){?>
						<td><input onchange="changeVal(this,'info3','<?=$col['sid']?>')" type="text" name="info3" id="info3"  value="<?=htmlspecialchars($col['info3'])?>" /></td>
					<?}?>
					<?if($s['abs_info4']){?>
						<td><input onchange="changeVal(this,'info4','<?=$col['sid']?>')" type="text" name="info4" id="info4"  value="<?=$col['info4']?>" /></td>
					<?}?>
					<?if($s['abs_info5']){?>
						<td><input onchange="changeVal(this,'info5','<?=$col['sid']?>')" type="text" name="info5" id="info5"  value="<?=$col['info5']?>" /></td>
					<?}?>
					<?if($s['abs_info6']){?>
						<td><input onchange="changeVal(this,'info6','<?=$col['sid']?>')" type="text" name="info6" id="info6"  value="<?=$col['info6']?>" /></td>
					<?}?>
					<?if($s['abs_info7']){?>
						<td><input onchange="changeVal(this,'info7','<?=$col['sid']?>')" type="text" name="info7" id="info7"  value="<?=htmlspecialchars($col['info7'])?>" /></td>
					<?}?>
					<?if($s['abs_info8']){?>
						<td><input onchange="changeVal(this,'info8','<?=$col['sid']?>')" type="text" name="info8" id="info8"  value="<?=htmlspecialchars($col['info8'])?>" /></td>
					<?}?>
					<?if($s['abs_info9']){?>
						<td><input onchange="changeVal(this,'info9','<?=$col['sid']?>')" type="text" name="info9" id="info9"  value="<?=$col['info9']?>" /></td>
					<?}?>
					<?if($s['abs_info10']){?>
						<td><input onchange="changeVal(this,'info10','<?=$col['sid']?>')" type="text" name="info10" id="info10"  value="<?=$col['info10']?>" /></td>
					<?}?>
					<?if($s['abs_info11']){?>
						<td><input onchange="changeVal(this,'info11','<?=$col['sid']?>')" type="text" name="info11" id="info11"  value="<?=$col['info11']?>" /></td>
					<?}?>
					<?if($s['abs_info12']){?>
						<td><input onchange="changeVal(this,'info12','<?=$col['sid']?>')" type="text" name="info12" id="info12"  value="<?=$col['info12']?>" /></td>
					<?}?>
					<?if($s['abs_info13']){?>
						<td><input onchange="changeVal(this,'info13','<?=$col['sid']?>')" type="text" name="info13" id="info13"  value="<?=$col['info13']?>" /></td>
					<?}?>
					<?if($s['abs_info14']){?>
						<td><input onchange="changeVal(this,'info14','<?=$col['sid']?>')" type="text" name="info14" id="info14"  value="<?=$col['info14']?>" /></td>
					<?}?>
					<?if($s['abs_info15']){?>
						<td><input onchange="changeVal(this,'info15','<?=$col['sid']?>')" type="text" name="info15" id="info15"  value="<?=$col['info15']?>" /></td>
					<?}?>
					<?if($s['abs_info16']){?>
						<td><input onchange="changeVal(this,'info16','<?=$col['sid']?>')" type="text" name="info16" id="info16"  value="<?=$col['info16']?>" /></td>
					<?}?>
					

					<td width="5%">
						<!--
						<a href="" onclick="javascript:modify('<?=$col['sid']?>','<?=$tab?>','<?=$code?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
						-->
						<a onclick="javascript:photo_add('<?=$col['sid']?>','<?=$code?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
						<a onclick="javascript:del('<?=$col['sid']?>','<?=$code?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
						
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

function photo_add(sid,code) {
	window.open("photo_add.php?sid="+sid+"&code="+code,"","width=630,height=700");
}	

function changeVal3(val,info,sid) {
	
	if(val.checked){
		value="Y";
	}else{
		value="N";
	}

	$.ajax({
		type:"POST",
		url:"./update_abstract.php",
		data:"val="+value+"&info="+info+"&sid="+sid,
		success:function(msg){

		},error : function(request, status, error ) {  
			alert("입력실패");
		
		}
	});
}


function changeVal(val,info,sid) {

	$.ajax({
		type:"POST",
		url:"./update_abstract.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){

		},error : function(request, status, error ) {   
			alert("입력실패 : "+val.value);
		
		}
	});
}

function changeVal2(val,info,sid) {

	$.ajax({
		type:"POST",
		url:"./update_abstract.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){
			if(msg){
				alert(msg+"님이 Faculty에 등록되어있지 않습니다.");
				location.reload();
			}
		},error : function(request, status, error ) { 
			alert("입력실패 : " + val.value);
		
		}
	});
}


function add_abstract(code) {

	value="1";
	if(document.getElementById("abstract_add_cnt").value>0){
		value = document.getElementById("abstract_add_cnt").value;
	}


	$.ajax({
		type:"POST",
		url:"./add_abstract.php",
		data:"code="+code+"&value="+value,
		success:function(msg){
			location.reload();
		}
	});
}



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
	window.open("add.php?tab="+tab,"","width=530,height=1000,top=50,left=100");
}

function sub_session(sid,code) {
	window.open("sub2.php?session="+sid+"&code="+code,"","width=1700,height=900,top=30,left=100");
}
function set(code) {
	window.open("set.php?code="+code,"","width=950,height=1000");
}

function view(code) {
	window.open("/php/abstract/category.php?code="+code,"","width=530,height=800");
}
function view2(code,tab) {
	window.open("/php/session/glance.php?code="+code+"&tab="+tab,"");;
}

function room(code) {
	window.open("room.php?code="+code,"");
}

function timeset(code) {
	window.open("time.php?code="+code,"");
}

function categoryset(code) {
	window.open("category.php?code="+code,"");
}


function css() {
	window.open("css.php","","width=530,height=700");
}



function modify(sid,tab,code) {
	window.open("add.php?tab="+tab+"&sid="+sid+"&code="+code,"","width=530,height=1000");
}	

function del(sid,code) {
	if(confirm("삭제하시겠습니까?")){

		$.ajax({
		type:"POST",
		url:"./del.php",
		data:"sid="+sid+"&code="+code,
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

		var page = "<?=$page?>";
		if(page > 0) {
			var num_per_page = "<?=$num_per_page?>"

			index = index + (page * num_per_page);
		}

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
</script>

   
<?include "./../footer.php";?>