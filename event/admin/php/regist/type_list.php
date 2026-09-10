<?include "./../header.php";?>


<?

$num_per_page = 100;
if(empty($page)) $page = 0;
$query="SELECT * FROM regist_type_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM regist_type_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

$query.=" order by orderby LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);

?>
<div id="container">
	
		<h2>등록 Type Setting</h2>
		<div class="contents member">
			
		
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a href="" onclick="javascript:add('<?=$code?>')" class="btnDef">등록</a></p>

			<table class="tblList">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 40%;">
					<col style="width: 10%;">
					<col style="width: 15%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
				</colgroup>
				<thead>
					<tr>
						<th>no</th>
						<th>필드명</th>
						<th>타입</th>
						<th>Select box 길이(%)</th>
						<th>기본설정값</th>
						<th>sub</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
					<tr class="bg" id="<?=$d['sid']?>">
						<td><?=$d['orderby']?></td>
						<td><input onchange="changeVal(this,'info','<?=$d['sid']?>')" type="text" name="info" id="info"  value="<?=$d['info']?>" /></td>
						
						<td><select name="val_type" id="val_type" onchange="changeVal(this,'val_type','<?=$d['sid']?>')">
							<? foreach($config['regist']['val_type'] as $tkey=>$tval){?>
							<option <?if($d['val_type']==$tkey){?>selected<?}?> value="<?=$tkey?>"><?=$tval?></option>
							
							<?}?>
							
						</select></td>

						<td><select name="type" id="type" onchange="changeVal(this,'val_type_class','<?=$d['sid']?>')">
						<? foreach($config['regist_class']['type'] as $tkey=>$tval){?>
							<option <?if($d['val_type_class']==$tkey){?>selected<?}?> value="<?=$tkey?>"><?=$tval?></option>
						<?}?>
						
						</select></td>
						<?
							$temp_query="SELECT * FROM regist_type_sub_tbl where code='".$code."' and type_sid='".$d['sid']."' and del='N'";
							$temp_query.=" order by orderby asc";
							$temp_result = mysqli_query($conn, $temp_query);
						?>
						<td><select name="type" id="type" onchange="changeVal(this,'def_val','<?=$d['sid']?>')">
							<option value="">select</option>
						<?while(is_array($sub_col = mysqli_fetch_array($temp_result))){?>
							<option <?if($sub_col['sid']==$d['def_val']){?>selected<?}?> value="<?=$sub_col['sid']?>"><?=$sub_col['info']?></option>

						<?}?>
						</select></td>


						<td><a onclick="javascript:sub_type('<?=$d['sid']?>','<?=$d['code']?>')" class="icon ok">SUB</a></td>
						
						<td>
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

$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {

			index = index+1;
			$.ajax({
			type:"POST",
			url:"./type_order.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){

			}
		});


    });
  }
});
});


function sub_type(sid, code) {
	window.open("type_sub_list.php?type_sid="+sid+"&code="+code,"","width=1230,height=950");
}

function changeVal(val,info,sid) {

	$.ajax({
		type:"POST",
		url:"./type_update.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){
			//alert(msg);
		},error : function(request, status, error ) {   
			alert("입력실패 : "+val.value);
		
		}
	});
}

function add(code) {
	$.ajax({
		type:"POST",
		url:"./type_add.php",
		data:"code="+code,
		success:function(msg){
			location.reload();
		}
	});
}




function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./type_del.php",
			data:"sid="+sid,
			success:function(msg){
				location.reload();
			}
		});
	}
}

</script>

   
<?include "./../footer.php";?>