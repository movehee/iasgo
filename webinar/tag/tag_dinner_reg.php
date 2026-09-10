<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if(!$tag_number){
		PutMessageLocation("정상적인 접근이 아닙니다.",'dinner.php');
		exit;
	}
	$len = mb_strlen($tag_number, "UTF-8")-1;
	$last_txt = mb_substr($tag_number,$len,1, "UTF-8");
	if($last_txt=='A' || $last_txt=='ㅁ'){
		$tag_number = mb_substr($tag_number,0,$len, "UTF-8");
	}else{
		PutMessageLocation("정상적인 접근이 아닙니다.",'dinner.php');
		exit;
	}
	//if(stristr($_SERVER['REMOTE_ADDR'],'218.235.94')==false){
		$attent = $conn->getOne("select etc_field11 from registration_tbl where sid='".$tag_number."'");
		if($attent=='127'){
			//PutMessageLocation("이미 참여하였습니다.",'dinner.php');
			//exit;
			$reject = "Y";
		}else{
			
		}
	//}
	
	
?>
<form name="tagF" id="tagF" method="post" action="tag_dinner_result.php">
	<input type="hidden" name="tag_number" value="<?=$tag_number?>">
	<input type="hidden" name="kind" value="<?=$kind?>">
	<input type="hidden" name="reject" value="<?=$reject?>">
</form>
<script>
	document.tagF.submit();
</script>