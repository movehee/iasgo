<?
if(!$_COOKIE['abs_font'])
{
	setcookie('abs_font', '1', 0, '/', "");
	$_COOKIE['abs_font']="1";
}
?>
<?include "./../header.php";?>

<?

$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
$abs_setting_result = mysqli_query($conn, $abs_setting_query);
$abs_setting_col = mysqli_fetch_array($abs_setting_result);

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
//echo $code;
?>

<div class="wrapper">
	<!-- container -->
	<div id="containerWrap">
		
<div class="titArea">
	<h2><?=$abs_setting_col['abstract_txt']?></h2>
	<p class="fixedBtn">
		<a onclick="javascript:history.back();" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>

<?
if($abs_setting_col['abs_top_menu']==1){
	$top_query = "SELECT * FROM abstract_category_tbl where code='".$code."' and del ='N' and parent='0' order by orderby asc";	
	$top_result = mysqli_query($conn, $top_query);
	$top_cnt=1;
	
	$top_all_query = "SELECT count(*) cnt FROM abstract_category_tbl where code='".$code."' and del ='N' and parent='0'";	
	$top_all_result = mysqli_query($conn, $top_all_query);
	$top_all_col = mysqli_fetch_array($top_all_result);

?>
<ul class="tabMenu">
<?while(is_array($top_col = mysqli_fetch_array($top_result))){
	$cnt_result = mysqli_query($conn, "SELECT count(*) cnt FROM abstract_category_tbl where code='".$code."' and parent='".$top_col['sid']."'");
	$cnt_row = mysqli_fetch_array($cnt_result);
?>
	<li class="menu<?if($tab==$top_cnt){echo " on";}?>" style="width:<?=100/$top_all_col['cnt']?>%"><a href="<?if($cnt_row['cnt']==0){?>./list.php<?}else{?>./category.php<?}?>?tab=<?=$top_cnt?>&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>&parent=<?=$top_col['sid']?>"><?=$top_col['info']?></a></li>
<?
$top_cnt++;
}?>
</ul>
<?}?>

<style>
	div.abstractCon dl.txtAlignJ {text-align:justify;}
	div.abstractCon dl.txtAlignL {text-align:left;}
</style>

<div class="session">

<?
	if($abs_setting_col['abs_sync']=='Y') {
		$view_from = "abstract";
		include "./$code/view.php";
	}
	else
	{
	
	$query = "select * from abstract_tbl WHERE sid = '".$sid."'";
	$result = mysqli_query($conn, $query);
	$subcol = mysqli_fetch_array($result);



	$query = "select * from session_tbl WHERE code='$code' and abs_no = '".$subcol['abs_no']."'";
	$result = mysqli_query($conn, $query);
	$col = mysqli_fetch_array($result);


?>

	<p class="sessionSub_Brief">
		<?if($setting_col['abs_sid']=="Y" && $subcol['abs_sid']){?>
			<span class="sessionCode">[<?=$subcol['abs_sid']?>]</span>
		<?}?>
		<?if($setting_col['abs_no']=="Y" && $subcol['abs_no']){?>
			<span class="sessionCode2">[<?=$subcol['abs_no']?>]</span>
		<?}?>


		<span class="sessionTit"><?=$subcol['title']?></span>

		<span class="speaker"><?if($subcol['speaker']){?> </span>
		<font class="absSpeaker">Speaker</font> : <font class="absOffice"><?=$subcol['speaker']?>

		<?}else if($col['session_speaker']){?>
		 <?=$col['session_speaker']?> 
		<?}?>
		<?if($subcol['speaker_office']){?>
			(<?=$subcol['speaker_office']?>)
		<?}?></font> 
		
	</p>

	<ul class="sessionUtil">
	
	<?
		$info_query = "select a.sid, g.name as date_name, r.name as room_name, r.photo from session_tbl a, session_time_tbl t, session_room_tbl r, agenda_tbl g where a.time=t.sid and a.room=r.sid and g.sid=a.tab and a.code='".$code."' and a.sid='".$col['link_session']."'";
		$info_result = mysqli_query($conn, $info_query);
		$info = mysqli_fetch_array($info_result);
	?>

	<?
	if($abs_setting_col['abs_favor']) {
		$favor_chk = "select sid from abstract_favor_tbl where code='$code' and deviceid='$deviceid' and abstract_sid='".$subcol['sid']."'";
		$favor_chk_result = mysqli_query($conn, $favor_chk);
	?>
		<li>
			<a href="javascript:abs_favor('<?=$subcol['sid']?>','<?=$info['sid']?>','<?=$deviceid?>')" id="favor" class="favorTxt <?if($favor_chk_result->num_rows){?>on<?}?>" title="즐겨찾기 추가하기"><i class="fas fa-star"></i></a>
		</li>
	<?}?>


	<?
	if($abs_setting_col['abs_detail_top_info']) {
	?>
		<li style="padding:0px 3px 0;line-height:30px;">
			<?=$info['date_name']?>
		</li>
		
		<?if($col['time']){?>
		<li style="padding:0px 3px 0;line-height:30px;"><i class="far fa-clock" title="Time"></i>  <?=$col['time']?></li>
		<?}?>
		
		<?if($info['room_name']){?>
		<li style="padding:0px 3px 0;line-height:30px;"><?if($info['photo']){?></a><a href="/upload/room/<?=$info['photo']?>"><?}?><i class="fas fa-map-marker-alt" title="Venue"></i> <?=$info['room_name']?><?if($info['photo']){?></a><?}?></li>
		<?}?>

	<?}?>

		
		<?if($subcol['abstract_file']){?>
			<li><a href="/upload/session/<?=$subcol['abstract_file']?>" class="btnAbs"><i class="fas fa-book"></i> <?=$abs_setting_col['abstract_btn_txt']?></a></li>
		<?}?>

		<?if($col['abstract_file']){?>
			<li><a href="/upload/session/<?=$col['abstract_file']?>" class="btnAbs"><i class="fas fa-book"></i> <?=$abs_setting_col['abstract_btn_txt']?></a></li>
		<?}?>
		
	
		<?if(file_exists("../../upload/code/".$code."/".str_replace("]","",str_replace("[","",$subcol['abs_no'])).".pdf")){?>
			<li><a href="/upload/code/<?=$code?>/<?=str_replace("]","",str_replace("[","",$subcol['abs_no']))?>.pdf" class="btnAbs"><i class="fas fa-book"></i> <?=$abs_setting_col['abstract_btn_txt']?></a></li>
		<?}?>
		
	</ul>
	
	


	<?if($subcol['info1']){?>
	<div class="abstractCon plus<?=$_COOKIE['abs_font']?>" id="abstractCon">
		<dl class="fontUtil">
			<dt><a href="#" class="trigger"><span class="font01">A</span> A</a></dt>
			<dd class="toggleCon">
				<ul>
					<li <?if($_COOKIE['abs_font']=="1"){?>class="on" <?}?> id="font1"><a href="javascript:font_size(1)" class="font01">A</a></li>
					<li <?if($_COOKIE['abs_font']=="2"){?>class="on" <?}?> id="font2"><a href="javascript:font_size(2)" class="font02">A</a></li>
					<li <?if($_COOKIE['abs_font']=="3"){?>class="on" <?}?> id="font3"><a href="javascript:font_size(3)" class="font03">A</a></li>
				</ul>
			</dd>
		</dl>

		<dl class="justify <?if($abs_setting_col['abs_align']=="1"){?>txtAlignJ<?}else{?>txtAlignL<?}?>">
		<?if($abs_setting_col['abs_info1'] && $subcol['info1']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info1']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info1'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info2'] && $subcol['info2']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info2']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info2'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info3'] && $subcol['info3']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info3']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info3'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info4'] && $subcol['info4']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info4']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info4'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info5'] && $subcol['info5']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info5']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info5'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info6'] && $subcol['info6']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info6']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info6'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info7'] && $subcol['info7']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info7']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info7'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info8'] && $subcol['info8']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info8']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info8'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info9'] && $subcol['info9']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info9']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info9'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info10'] && $subcol['info10']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info10']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info10'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info11'] && $subcol['info11']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info11']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info11'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info12'] && $subcol['info12']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info12']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info12'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info13'] && $subcol['info13']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info13']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info13'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info14'] && $subcol['info14']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info14']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info14'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info15'] && $subcol['info15']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info15']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info15'])?></dd>
		<?}?>
		<?if($abs_setting_col['abs_info16'] && $subcol['info16']){?>
			<dt class="absTit"><?=$abs_setting_col['abs_info16']?></dt>
			<dd><?=str_replace("\n","<br>",$subcol['info16'])?></dd>
		<?}?>


		
		</dl>
	</div>
	<?}?>

	<?
		$photo_cnt_query = "select count(*) cnt from abstract_file_tbl WHERE abstract_sid = '".$subcol['sid']."'";
		$photo_cnt_result = mysqli_query($conn, $photo_cnt_query);
		$photo_cnt_col = mysqli_fetch_array($photo_cnt_result);
		if($photo_cnt_col['cnt']>0){
	?>
	<div style="margin: 10px;">
		<ul class="thumbnailwrap">
		<?
		$photo_query = "select * from abstract_file_tbl WHERE abstract_sid = '".$subcol['sid']."'";
			//echo $photo_query;
		$photo_result = mysqli_query($conn, $photo_query);
		
		while(is_array($photo_col = mysqli_fetch_array($photo_result))){?>
			<li><a href="/upload/abstract/thumbnail/<?=$photo_col['file']?>"><!-- <span class="thumbTit">타이틀</span> --><img  src="/upload/abstract/thumbnail/<?=$photo_col['file']?>"></a>
		</li>
		<?}?>
		</ul>
	</div>
	<?}?>



	<?}?>

	<!--메모 > 이미지 팝업-->
<div class="popupWrap3" id="popupMemoImg">
	<div><img id="popup_img" src="/image/ing.png" /> </div>
	<p class="close btnBg"><a class="imageclose" href="#">팝업닫기</a></p>
</div>


	
</div>





	<div class="popupWrap" id="popupMemo">
		<dl>
			<dt><img src="/app/2018fall/image/btn/icon_memo.png" alt=""> 메모를 작성해 주세요</dt>
			<dd>
				<form id="" name="" action="./memo.php" method="post">
					<input type="hidden" name="code" value="<?=$code?>">
					<input type="hidden" name="id" id="id" value="<?=$id?>">
					<input type="hidden" name="session_sid" id="session_sid" value="<?=$sid?>">
					<fieldset>
						<legend>Memo</legend>
						<textarea name="memo_txt" id="memo_txt" cols="30" rows="10"></textarea>
						<span class="btn"><input value="저장" class="btnDef" type="submit"></span>
					</fieldset>
				</form>

				<p class="close btnBg"><a href="#">팝업닫기</a></p>
			</dd>
		</dl>
	</div>
<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
<script>

	var abs = document.getElementById("abstractCon");


	abs.addEventListener('touchstart', function(event){
        //alert(2);
    });


	function favor(sid, deviceid){
		
		$.ajax({
			type:"POST",
			url:"./favor.php",
			data:"session_sid="+sid+"&deviceid="+deviceid,
			success:function(msg){
				if(msg == "Y"){
					$('#favor').addClass("on");
				}else{
					$('#favor').removeClass("on");
				}
				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});
		
	}

	function abs_favor(sid, session_sid, deviceid){

		$.ajax({
			type:"POST",
			url:"./abs_favor.php",
			data:"abstract_sid="+sid+"&session_sid="+session_sid+"&deviceid="+deviceid+"&code=<?=$code?>",
			success:function(msg){
				if(msg == "Y"){
					$('#favor').addClass("on");
				}else{
					$('#favor').removeClass("on");
				}

				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});
		
	}

	function imageOpen(url){
		//alert(url);
		$("div.popupWrap3").fadeIn();
		document.getElementById('popup_img').src=url;
	}


	function font_size(font){

		var setCookie = function(name, value, exp) {
			  var date = new Date();
			  date.setTime(date.getTime() + exp*24*60*60*1000);
			  document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
			};
			setCookie('abs_font', font, 7);


		if(font=="1"){
			$('#abstractCon').addClass("plus1");
			$('#abstractCon').removeClass("plus2");
			$('#abstractCon').removeClass("plus3");
			$('#font1').addClass("on");
			$('#font2').removeClass("on");
			$('#font3').removeClass("on");
			

		}else if(font=="2"){
			$('#abstractCon').removeClass("plus1");
			$('#abstractCon').addClass("plus2");
			$('#abstractCon').removeClass("plus3");
			$('#font1').removeClass("on");
			$('#font2').addClass("on");
			$('#font3').removeClass("on");

		}else if(font=="3"){
			$('#abstractCon').removeClass("plus1");
			$('#abstractCon').removeClass("plus2");
			$('#abstractCon').addClass("plus3");
			$('#font1').removeClass("on");
			$('#font2').removeClass("on");
			$('#font3').addClass("on");

		}
	}

</script>


</body>
</html>

