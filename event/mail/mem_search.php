<?
include $DOCUMENT_ROOT."popup/include.header.php";
include "config.php";
?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="./admin.css" />

<?=$_js_css?>
<script type="text/javascript">
	$(function(){
		$('#search_frm').submit(function(){
			if(!$('#search_field').val()){
				alert("검색조건을 선택하세요");
				$('#search_field').focus();
				return false;
			}
			
			if(!$('#search_value').val()){
				alert("검색할 내용을 입력하세요");
				$('#search_value').focus();
				return false;
			}			
		});
	});
	
	function selecte_this(kname,id,office,pcs,email,mobile){
		location.href="<?=$PHP_SELF?>?c_index=<?=$c_index?>&kname="+encodeURIComponent(kname)+"&id="+id+"&office="+encodeURIComponent(office)+"&pcs="+pcs+"&email="+email+"&mobile="+mobile+"&mode=insert";
	}
</script>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupWrap').outerHeight()+68;
		re_width = $('.popupWrap').outerWidth()+17;
		
		if(re_height>1000){
			window.resizeTo(re_width,1000);	
		}else{
			//window.resizeTo(re_width,re_height);
			window.resizeTo(re_width,re_height);
		}
	});
</script>
</head>
<body>
<?
	if($_GET['mode'] == 'insert'){
		$query = "insert into tp_addgrinfo set c_code='${c_index}', c_name='${kname}', c_email='${email}', c_pcs='${pcs}'";
		$query .= ", c_office='${office}', c_id='${id}', c_phone='${mobile}', reg_dt=now()";
		
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}				
		
		PutMessageCloseOpenerReload("주소록에 등록되었습니다.");
	}
?>
<div class="popupWrap" style="width:700px;border:7px solid #616874;padding:30px;">
<form name="form1" method="post" action="<?=$PHP_SELF?>?mode=process&c_index=<?=$c_index?>" id="search_frm">
<p align="left" style="font-size:15px;">
	<b>회원검색</b>
</p>
<center>
	<table border="0" cellpadding="0" cellspacing="0" class="search_tbl" style="width:100%;height:200px;" >
		<tr>
			<th class="th ac" style="padding:20px;">
				검색조건을 설정 후 해당 직책에 알맞은 회원을<br/>
				검색하여 '<span class="color_red">[선택]</span>'해 주십시요.			
			</th>
		</tr>
		<tr>
			<td class="th ac" align="center" style="padding:10px;">
				<select name="search_field" id="search_field" class="vertical_middle" style="height:24px;">
					<option value="">검색조건</option>
					<? foreach($_MEMBER['field1'] as $tkey=>$tval):?>
						<?
							$sel='';
							if($tkey == $search_field) $sel = 'selected';
						?>
						<option value="<?=$tkey?>" <?=$sel?>><?=$tval?></option>
					<? endforeach?>
				</select>
				<input type="text" name="search_value" id="search_value" value="<?=$search_value?>" class="vertical_middle" style="height:24px;width:250px;"/>
				<span class="btnAdmin small blue"><button type="submit">검색</button></span>
			</th>
		</tr>
		<? if($mode == 'process'):?>
		<tr>
			<?
				$query = "select * ";
				$query .= " from user_binfo as a where ";
				$query .= " ${search_field} like '%${search_value}%' order by name_kr asc";
				
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());					
			?>
			<th align="center" style="padding:5px;">
				<table border="0" cellpadding="0" cellspacing="0" class="list_tbl" style="width:95%">
					<colgroup>
						<col style="width:20%;" />
						<col style="width:20%;" />
						<col style="" />
						<col style="width:10%;" />
						
					</colgroup>
					<tr>
						<th class="th ac">아이디</th>
						<th class="th ac">성명</th>		
						<th class="th ac">이메일</th>						
						<th class="th ac">등록</th>						
					</tr>
					<? while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))):?>
					<tr bgcolor="ffffff">
						<td class="td ac"><?=$d['id']?></td>
						<td class="td ac"><?=$d['name_kr']?></td>
						<td class="td ac"><?=$d['email']?></td>
						<td class="td ac">
							<span class="btnAdmin small green"><button type="button" onclick="selecte_this('<?=$d['name_kr']?>','<?=$d['id']?>','<?=$d['office_name']?>','<?=$d['hp']?>','<?=$d['email']?>', '<?=$d['hp']?>')">등록</button></span>
						</td>
					</tr>
					<? endwhile?>
				</table>
			</th>
		</tr>
		<? endif?>
	</table>
	<div class="tp20"><span class="btnAdmin large darkGray"><button type="button" onclick="self.close();">닫 기</button></span></div>
</center>
</form>
</div>
</body>
</html>