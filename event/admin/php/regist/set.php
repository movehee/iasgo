<?include "./../header.php";?>


<?

$num_per_page = 100;
if(empty($page)) $page = 0;
$query="SELECT * FROM regist_set_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM regist_set_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);


$totalRecord = $row['cnt'];

$query.=" order by orderby LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, $query);

$type_query = "SELECT * FROM regist_type_tbl WHERE code='".$code."' and del='N' order by orderby asc";
$type_result = mysqli_query($conn, $type_query);


$temp_result = mysqli_query($conn, $query);


?>
<div id="container" style="width:1400px">
	
		<h2>등록 Setting</h2>
		<div class="contents member">
			
			<p class="btn" style="top: -44px; right: 150px; position: absolute;"><a href="" onclick="javascript:type_list('<?=$code?>')" class="btnDef">type관리</a></p>
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a href="" onclick="javascript:set_add('<?=$code?>')" class="btnDef">등록</a></p>

			<table class="tblList">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 12%;">
					<col style="width: 18%;">
					<col style="width: 8%;">

					<col style="width: 7%;">
					<col style="width: 7%;">
					<col style="width: 7%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 5%;">
					<col style="width: 5%;">
					<col style="width: 5%;">
					<col style="width: 5%;">
				</colgroup>
				<thead>
					<tr>
						<th>no</th>
						<th class="tooltipPoint" title="등록 항목 셋팅값 / 아이디,비밀번호, 이름,소속 등">필드명</th>
						<th class="tooltipPoint" title="해당 필드의 설명 추가 / ex) 이름필드 만들고 해당필드 memo에 (띄어쓰기 없이 입력해 주세요) 등의 문구를  축 할 수 있음">필드 설명 문구</th>
						<th class="tooltipPoint" title="input type 설정 / 성별:남/여 등의 타입은 type관리에서 직접 생성 가능">타입</th>
						<th class="tooltipPoint" title="필수여부가 필수 일 경우 등록시 해당항목 필수값으로 지정">필수여부</th>
						<th class="tooltipPoint" title="중복여부가 중복확인 일 경우 등록시 해당 항목 중복검사">중복여부</th>
						<th class="tooltipPoint" title="선택 국가에 따른 해당필드 노출여부 / 예) 국문소속을 한국으로 설정할 경우 국가선택값이 한국일 경우만 국문소속 필드 보여짐">국가여부</th>

						<th class="tooltipPoint">부모</th>
						<th class="tooltipPoint">부모값</th>


						<th class="tooltipPoint" title="체크된 필드만 목록에 보여집니다.">list노출</th>
						<th class="tooltipPoint" title="체크된 필드는 관리자만 보입니다. /현장등록(사용자) 화면에 노출되면 안되는 필드는 체크 /예) 메모, VIP구분 등">관리자</th>
						<th class="tooltipPoint" title="앱 로그인시 사용할 데이터 /예) 이름,면허번호에 체크할 경우 앱에서 로그인할때 해당 필드의 데이터로 로그인 가능">로그인<br>구분값</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
					<tr class="bg" id="<?=$d['sid']?>">
						<td><?=$d['orderby']?></td>
						<td><input onchange="changeVal(this,'info','<?=$d['sid']?>')" type="text" name="info" id="info"  value="<?=$d['info']?>" /></td>
						<td><input onchange="changeVal(this,'memo','<?=$d['sid']?>')" type="text" name="memo" id="memo"  value="<?=$d['memo']?>" /></td>

						<td><select name="type" id="type" onchange="changeVal(this,'type','<?=$d['sid']?>')">
						<? foreach($config['regist']['type'] as $tkey=>$tval){?>
							<option <?if($d['type']==$tkey){?>selected<?}?> value="<?=$tkey?>"><?=$tval?></option>
						<?}?>
						<?
							while(is_array($type_d = mysqli_fetch_array($type_result))){?>
								<option<?=$d['type']==$type_d['sid']?' selected="true"':''?> value="<?=$type_d['sid']?>"><?=$type_d['info']?></option>
							<?}
							mysqli_data_seek($type_result,0); 
							?>
						</select></td>

						


						<td><select name="necessary" id="necessary" onchange="changeVal(this,'necessary','<?=$d['sid']?>')">
							<option<?=$d['necessary']=="Y"?' selected="true"':''?> value="Y">필수</option>
							<option<?=$d['necessary']=="N"?' selected="true"':''?> value="N">미필수</option>
						</select></td>

						<td><select name="overlapchk" id="overlapchk" onchange="changeVal(this,'overlapchk','<?=$d['sid']?>')">
							<option<?=$d['overlapchk']=="Y"?' selected="true"':''?> value="Y">중복확인</option>
							<option<?=$d['overlapchk']=="N"?' selected="true"':''?> value="N">중복미확인</option>
						</select></td>

						<td><select name="countrychk" id="countrychk" onchange="changeVal(this,'countrychk','<?=$d['sid']?>')">
							<? foreach($config['regist']['countrychk'] as $tkey=>$tval){?>
							<option <?if($d['countrychk']==$tkey){?>selected<?}?> value="<?=$tkey?>"><?=$tval?></option>
							
							<?}?>
							
						</select></td>
						<td>
						<select onchange="changeVal(this,'parent','<?=$d['sid']?>')" name="parent" id="parent">
							<option value="">:: select ::</option>
							<?
							while(is_array($temp_d = mysqli_fetch_array($temp_result))){?>
								<option <?=$d['parent']==$temp_d['info_orderby']?' selected="true"':''?> value="<?=$temp_d['info_orderby']?>"><?=$temp_d['info']?></option>
							<?}
							mysqli_data_seek($temp_result,0);
							?>
						</select>
						</td>

						<td><input onchange="changeVal(this,'parent_val','<?=$d['sid']?>')" type="text" name="parent_val" id="parent_val"  value="<?=$d['parent_val']?>" /></td>


						<td>
							 <input onchange="changeVal3(this,'listchk','<?=$d['sid']?>')" type='checkbox' name='listchk' <?if($d['listchk']=="Y"){?>checked<?}?>/>
						</td>

						<td>
							 <input onchange="changeVal3(this,'adminchk','<?=$d['sid']?>')" type='checkbox' name='adminchk' <?if($d['adminchk']=="Y"){?>checked<?}?>/>
						</td>

						<td>
							 <input onchange="changeVal3(this,'loginchk','<?=$d['sid']?>')" type='checkbox' name='loginchk' <?if($d['loginchk']=="Y"){?>checked<?}?>/>
						</td>

						<td>
						<!--
							<a href="" onclick="javascript:modify('<?=$d['sid']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
						-->
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
			url:"./set_order.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){

			}
		});


    });
  }
});
});

function changeVal3(val,info,sid) {
	
	if(val.checked){
		value="Y";
	}else{
		value="N";
	}

	$.ajax({
		type:"POST",
		url:"./set_update.php",
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
		url:"./set_update.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){
			//alert(msg);
		},error : function(request, status, error ) {   
			alert("입력실패 : "+val.value);
		
		}
	});
}

function set_add(code) {
	$.ajax({
		type:"POST",
		url:"./set_add.php",
		data:"code="+code,
		success:function(msg){
			location.reload();
		}
	});
}


function type_list(code) {
	window.open("./type_list.php?code="+code,"");
}


function modify(sid) {

	window.open("set_add2.php?sid="+sid,"","width=630,height=650");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./set_del.php",
			data:"sid="+sid,
			success:function(msg){
				location.reload();
			}
		});
	}
}

</script>

   
<?include "./../footer.php";?>