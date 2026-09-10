<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	if($rsid){
		$query = "select * from registration_tbl where sid='$rsid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		  die($result->getMessage());
		}
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();

		if($d['ccode']=='78'){
			$regist_kind = "Kor";
			$user_name = $d['name_kr'];
		}else{
			$regist_kind = "Eng";
			$user_name = $d['first_name']." ".$d['last_name'];
		}
	}

	if(!$step) $step=1;
?>
<link rel="stylesheet" href="/css/pickout.css">
<style>
.pk-field{width:300px !important;border-color:red;}	
.pk-search{width:90%;}
.pk-modal{padding:0; margin:0;width:30%;}
</style>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);
	});
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:1000px;padding:20px;background:#fffff">
<form id="registF" name="registF" action="/registration/post.php" method="post">
<input type="hidden" name="step" id="step" value="<?=$step?>">
<input type="hidden" name="regist_kind" id="regist_kind" value="<?=$regist_kind?>">
<input type="hidden" name="rsid" id="rsid" value="<?=$d['sid']?>">
<input type="hidden" name="id_chking" id="id_chking" value="Y">
<input type="hidden" name="admin_yn" id="admin_yn" value="Y">
<?
	echo "<br><br>";
	include $_SERVER['DOCUMENT_ROOT'].'registration/postform_inc'.$step.'.php';
?>
<div class="btn ac tp10">
	<span class="btnPurple btnIcon">Submit <input type="submit" value="Cancel" class="opacity0" ></span>
	<span class="btnGrey btnIcon">Cancel <input type="button" value="Cancel" class="opacity0" onclick="self.close();"></span>
	
</div>
</div>
</div>

<script>
	$(function(){
		$('.category').triggerhandler("click");
	});
</script>

