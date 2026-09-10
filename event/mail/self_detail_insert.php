<?
include $DOCUMENT_ROOT."popup/include.header.php";
include "config.php";
?>
<?=$_js_css?>
<script type="text/javascript">
	$(function(){
		$('#excel_frm').submit(function(){
			if(!$('#c_name').val()){
				alert("이름을 입력하세요");
				$('#c_name').focus();
				return false;
			}

			if(!$('#c_email').val()){
				alert("이메일을 입력하세요");
				$('#c_email').focus();
				return false;
			}
		});
	});
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
	if($_GET['mode'] == 'process'){
		if($mode_process == 'modify_process'){
			$query = "update tp_addgrinfo set c_name='${c_name}', c_email='${c_email}', c_pcs='${c_pcs}'";
			$query .= ", c_office='${c_office}', c_phone='${c_phone}' where c_index='${info_index}'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
			   die($result->getMessage());
			}

			PutMessageCloseOpenerReload("주소록에 수정이 완료되었습니다.");
		}else{

			$query = "insert into tp_addgrinfo set c_code='${c_index}', c_name='${c_name}', c_email='${c_email}', c_pcs='${c_pcs}'";
			$query .= ", c_office='${c_office}', c_phone='${c_phone}',  reg_dt=now()";
			//die($query);
			$result = $conn->query($query);
			if(DB::isError($result)) {
			   die($result->getMessage());
			}

			PutMessageCloseOpenerReload("주소록에 등록되었습니다.");
		}
	}


	if($_GET['mode'] == 'modify'){
		$query = "select * from tp_addgrinfo where c_index='${c_index}'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
		$d=$result->fetchRow(DB_FETCHMODE_ASSOC);
	}
?>
<form method="post" action="<?=$PHP_SELF?>?c_index=<?=$c_index?>&mode=process" name="excel_frm" id="excel_frm">
<? if($_GET['mode'] == 'modify'):?>
<input type="hidden" value="modify_process" name="mode_process"/>
<input type="hidden" value="<?=$c_index?>" name="info_index"/>
<? endif?>
<div class="popupWrap" style="padding:10px 0 0 10px;border:7px solid #616874;">
	<p style="font-size:15px;font-weight:bold;"><?=$mode=='modify'?'명단수정':'명단추가'?></p><br/>
	<table border="0" cellpadding="0" cellspacing="0" class="regist_tbl" style="width:97%;">
		<tr>
			<th class="th">이름</th>
			<td class="td"><input type="text" name="c_name" id="c_name" value="<?=$d['c_name']?>" size="15"/></td>
		</tr>
		<tr>
			<th class="th">이메일</th>
			<td class="td"><input type="text" name="c_email" id="c_email" value="<?=$d['c_email']?>" size="25" /></td>
		</tr>
		<tr>
			<th class="th">핸드폰</th>
			<td class="td"><input type="text" name="c_phone" id="c_phone" value="<?=$d['c_phone']?>" size="25" /></td>
		</tr>
	</table>
	<br/>
	<p align="center">
		<span class="btnAdmin medium blue"><button type="submit" >확인</button></span>
		<span class="btnAdmin medium gray"><button type="button" onclick="self.close();">닫기</button></span>
	</p>
	<br /><br /><br />
</div>
</form>
</body>
</html>