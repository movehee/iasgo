<?include "./../header2.php";?>

<?

$num_per_page = 100;
if(empty($page)) $page = 0;

$query="SELECT * FROM session_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);


$query="SELECT * FROM regist_type_sub_tbl where code='".$code."' and type_sid='".$type_sid."' and del='N'";


$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;


$result = mysqli_query($conn, "select max(orderby) maxs from regist_type_sub_tbl where code='".$code."' and type_sid='".$type_sid."' and del='N'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$theme_result = mysqli_query($conn, "select * from regist_type_tbl where code='".$code."' and sid='".$type_sid."'");
$theme_row = mysqli_fetch_array($theme_result);

$result = mysqli_query($conn, $query);
?>
<div id="container" style="width:1000px">
	
		<h2><?=$theme_row['info']?></h2>
		<div class="contents member">
			

			<!--
			<p class="btn" style="top: -44px; right: 460px; position: absolute;"><a href="" onclick="javascript:css('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>CSS 설정</a></p>
			-->
			
		
			
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a  onclick="javascript:add_sub_type('<?=$type_sid?>','<?=$code?>')" class="btnDef"><i class="fas fa-plus-circle"></i>ADD</a></p>
			

			<table class="tblList">
				<thead>

					<colgroup>
						<col style="width: 5%;">
						<col style="">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<col style="width: 10%;">
						<?if($theme_row['val_type']=='1'){?>
						<col style="width: 10%;">
						<?}?>
						<col style="width: 10%;">
					</colgroup>

					<tr>
						<th>NO</th>
						<th>Info</th>
						<th>사전/현장</th>
						<th>국가여부</th>
						<?if($theme_row['val_type']=='1'){?>
						<th>기타입력</th>
						<?}?>
						<th>관리</th>
					</tr>
				</thead>

				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){?>
				<tr id="<?=$col['sid']?>">
					<td><?=$col['orderby']?></td>
					<td><input onchange="changeVal(this,'info','<?=$col['sid']?>')" type="text" name="info" id="info"  value="<?=$col['info']?>" /></td>

					<td><select name="pre_chk" id="pre_chk" onchange="changeVal(this,'pre_chk','<?=$col['sid']?>')">
						<option <?if($col['pre_chk']=="1"){?>selected<?}?> value="1">모두</option>
						<option <?if($col['pre_chk']=="2"){?>selected<?}?> value="2">사전</option>
						<option <?if($col['pre_chk']=="3"){?>selected<?}?> value="3">현장</option>
					</select></td>

					<td><select name="countrychk" id="countrychk" onchange="changeVal(this,'countrychk','<?=$col['sid']?>')">
						<option <?if($col['countrychk']=="0"){?>selected<?}?> value="0">모두</option>
						<option <?if($col['countrychk']=="1"){?>selected<?}?> value="1">한국</option>
						<option <?if($col['countrychk']=="2"){?>selected<?}?> value="2">외국</option>
					</select></td>

					<?if($theme_row['val_type']=='1'){ //radio 타입일경우에만?>
					<td>
						<select name="etc" id="etc" onchange="changeVal(this,'etc','<?=$col['sid']?>')">
							<option <?if($col['etc']=="N"){?>selected<?}?> value="N">N</option>
							<option <?if($col['etc']=="Y"){?>selected<?}?> value="Y">Y</option>
						</select>
					</td>
					<?}?>

					<td>
						<a href="" onclick="javascript:del('<?=$col['sid']?>','<?=$type_sid?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
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
			url:"./type_sub_order.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){

			}
		});


    });
  }
});
});

function add_sub_type(type_sid,code) {
	//alert(val.value);
	$.ajax({
		type:"POST",
		url:"./type_sub_add.php",
		data:"code="+code+"&type_sid="+type_sid,
		success:function(msg){
			location.reload();
		}
	});
}


function changeVal(val,info,sid) {
	//alert(val.value);
	$.ajax({
		type:"POST",
		url:"./type_sub_update.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){
			
		},error : function(request, status, error ) {   // 오류가 발생했을 때 호출된다. 
			alert("입력실패 : " + val.value);
		}
	});
}


function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./type_sub_del.php",
			data:"sid="+sid,
			success:function(msg){
				location.reload();
			}
		});
	}
}



</script>

   
<?include "./../footer.php";?>