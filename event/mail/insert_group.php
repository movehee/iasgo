<?include $DOCUMENT_ROOT."popup/include.header.php";?>
<?
include "config.php";
?>
<?=$_js_css?>
<script type="text/javascript">
	$(function(){
		$('#group_frm').submit(function(){
			if(!$('#c_grname').val()){
				alert("그룹 명칭을 입력하세요");
				$('#c_grname').focus();
				return false;
			}
		});
	});
</script>
</head>
<body>
<?
	if($_GET['mode'] == 'process'){
		
		if($c_index){
			$query = "update tp_addgrcode set c_grname='${c_grname}' where c_index='${c_index}'";				
		}else{
			$query = "insert into tp_addgrcode set c_grname='${c_grname}'";		
		}

		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());			
		
		if($c_index){
			PutMessageCloseOpenerReload("그룹이 수정되었습니다.");		
		}else{
			PutMessageCloseOpenerReload("그룹이 추가되었습니다.");
		}
	}
	
	if($c_index){
		$query = "select c_grname from tp_addgrcode where c_index='${c_index}'";
		$c_grname=$conn->getOne($query);
		if(DB::isError($$c_grname)) die($c_grname->getMessage());				
	}
?>
<div style="padding:10px 0 0 10px;">
	<p style="font-size:15px;font-weight:bold;">주소록 <?=$c_index?'수정':'추가'?></p>
	<form method="post" action="<?=$PHP_SELF?>?mode=process&c_index=<?=$c_index?>" id="group_frm" name="group_frm">
	<div class="center">
		주소록 그룹 명칭 : <input type="text" name="c_grname" id="c_grname" value="<?=$c_grname?>"/>
	</div>
	<br/>
	<div class="ac">

		<span class="btnAdmin medium blue"><button type="submit" ><?=$c_index?'수정':'추가'?></button></span>
		<span class="btnAdmin medium gray"><button type="button" onclick="self.close();">닫기</button></span>
	</div>
	</form>
</div>
</body>
</html>