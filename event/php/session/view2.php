<?

//어디서 사용하는지 알수없음

if(!$_COOKIE['abs_font'])
{
	setcookie('abs_font', '1', 0, '/', "");
	$_COOKIE['abs_font']="1";
}
?>
<?include "./../header.php";?>


<?

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);




$query = "select * from session_tbl WHERE sid = '".$sid."'";
$result = mysqli_query($conn, $query);
$subcol = mysqli_fetch_array($result);

$query = "select * from session_tbl WHERE sid = '".$subcol['link_session']."'";
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);


$temp_result = mysqli_query($conn, "select count(*) cnt from session_favor_tbl WHERE session_sid='".$sid."' and deviceid='".$deviceid."'");
$temp_row = mysqli_fetch_array($temp_result);
$fav = $temp_row['cnt'];


$temp_result = mysqli_query($conn, "select count(*) cnt from session_like_tbl WHERE session_sid='".$sid."' and deviceid='".$deviceid."'");
$temp_row = mysqli_fetch_array($temp_result);
$mylike = $temp_row['cnt'];

$temp_result = mysqli_query($conn, "select count(*) cnt from session_like_tbl WHERE session_sid='".$sid."'");
$temp_row = mysqli_fetch_array($temp_result);
$like_cnt = $temp_row['cnt'];



$evaluation_result = mysqli_query($conn, "select * from session_evaluation_tbl WHERE session_sid='".$sid."' and deviceid='".$deviceid."'");
$evaluation_row = mysqli_fetch_array($evaluation_result);

$memo_result = mysqli_query($conn, "select * from session_memo_tbl WHERE session_sid='".$sid."' and deviceid='".$deviceid."'");
$memo_row = mysqli_fetch_array($memo_result);

?>

<div class="wrapper">
	<!-- container -->
	<div id="containerWrap">
		<?if($toptext){?>
		<div class="ws_titArea">
			<h2>2019년 춘계학술대회</h2>
			<p><a href="close.php">닫기</a></p>
		</div>
	<?}?>
<div class="titArea">
	<h2>Program</h2>
	<p class="fixedBtn">
		<a onclick="javascript:history.back();" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
	</p>
</div>


<div class="session">
	<p class="sessionSub_Brief">
		<?if($setting_col['abs_sid']=="Y" && $subcol['abs_sid']){?>
			<span class="sessionCode"><?=$subcol['abs_sid']?></span>
		<?}?>
		<?if($setting_col['abs_no']=="Y" && $subcol['abs_no']){?>
			<span class="sessionCode2"><?=$subcol['abs_no']?></span>
		<?}?>

		<?if($setting_col['title']=="Y" && $subcol['title']){?>
			<span class="sessionTit"><?=$subcol['title']?></span>
		<?}?>

		<?if($subcol['time']){?>
			<span class="speaker"><?=$subcol['time']?></span>
		<?}?>

		<?if($setting_col['speaker']){?>
		<?if($setting_col['faculty_type']==1){?>
			<?
			$faculty_query="SELECT b.name,b.name_en,b.office_en,b.office,b.cv_file,b.sid,b.country FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$subcol['sid']."' order by a.sid asc";
			$faculty_result=mysqli_query($conn, $faculty_query);
			$chair="";
			$i = 0;
			while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
				$speaker_sid = $faculty_d['sid'];
				$cv_file = $faculty_d['cv_file'];
				if($i!=0){
					$chair = $chair . ", ";
				}
				if($setting_col['faculty_style']==1){
					if($setting_col['faculty_style2']==1){
						$chair .= $faculty_d['name'];
						$chair .= " (".$faculty_d['office'].")";
					}else if($setting_col['faculty_style2']==2){
						$chair .= $faculty_d['name_en'];
						$chair .= " (".$faculty_d['office_en'].")";
					}else if($setting_col['faculty_style2']==3){
						if($col['language']==1){
							$chair .= $faculty_d['name_en'];
							$chair .= " (".$faculty_d['office_en'].")";
						}else{
							$chair .= $faculty_d['name'];
							$chair .= " (".$faculty_d['office'].")";
						}
					}
				}else if($setting_col['faculty_style']==2){

					if($setting_col['faculty_style2']==1){
						$chair .= $faculty_d['name'];
						$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
					}else if($setting_col['faculty_style2']==2){
						$chair .= $faculty_d['name_en'];
						$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
					}else if($setting_col['faculty_style2']==3){
						if($col['language']==1){
							$chair .= $faculty_d['name_en'];
							$chair .= "<i><br>(".$faculty_d['office_en'].", ".$faculty_d['country'].")</i>";
						}else{
							$chair .= $faculty_d['name'];
							$chair .= "<i><br>(".$faculty_d['office'].", ".$faculty_d['country'].")</i>";
						}
					}

				}


				
				$i++;
			}
			if($chair){?>
				<span class="speaker"><?=$setting_col['speaker']?> : <?=$chair?></span>	
			<?}}else if($subcol['speaker']){?>
				<span class="speaker"><?=$setting_col['speaker']?> : <?=$subcol['speaker']?></span>

			<?}?>
		<?}?>
		<?if($setting_col['etc_speaker']){?>
		<?if($subcol['etc_speaker']){?>
			<span class="etc_speaker"><?=$subcol['etc_speaker']?></span>

		<?}}?>
	</p>

	<ul class="sessionUtil">
		
		<?if($setting_col['sub_favor']=="Y"){?>
		<li>
			<a href="javascript:favor('<?=$subcol['sid']?>','<?=$deviceid?>')" id="favor" class="favorTxt <?if($fav){echo " on";}?>" title="즐겨찾기 추가하기"><i class="fas fa-star"></i> My Schedule</a>
		</li>
		<?}?>

		<?if($subcol['lecture_file']){?>
			<li><a href="/upload/session/<?=$subcol['lecture_file']?>" class="btnLect"><i class="fas fa-book"></i> Lecture</a></li>
		<?}?>

		<?if($subcol['abstract_file']){?>
			<li><a href="/upload/session/<?=$subcol['abstract_file']?>" class="btnAbs"><i class="fas fa-microphone"></i> abstract</a></li>
		<?}?>
		<?if($setting_col['faculty_type']==1){?>
		<!--
			<?if($cv_file){?>
			<li><a href="<?if($setting_col['cv_file']=="Y"){?>/upload/faculty/<?}?><?=$cv_file?>" class="btnCV"><i class="fas fa-book"></i> CV</a></li>
			<?}?>
		-->
			<li><a href="./list.php?tab=-5&code=<?=$code?>&sid=<?=$speaker_sid?>&deviceid=<?=$deviceid?>" class="btnCV"><i class="fas fa-user"></i> Speaker Info</a></li>

		<?}else{?>
		<?if($subcol['cv_file']){?>
			<li><a href="/upload/session/<?=$subcol['cv_file']?>" class="btnCV"><i class="fas fa-book"></i> CV</a></li>
		<?}}?>
		
		
		<?if($setting_col['memo']=="Y"){?>
			<li><a class="btnMemo"><i class="fas fa-edit"></i> Memo</a></li>
		<?}?>
		<?if($setting_col['evaluation']=="Y"){?>
			<li><a class="btnEvaluation"><i class="fas fa-star"></i>Session Evaluation</a></li>
		<?}?>

		<?if($setting_col['evaluation']=="Y"){?>
			<li><a class="btnLike <?if($mylike){echo "on";}?>" id="session_like" href="javascript:sessionlike('<?=$code?>','<?=$subcol['sid']?>','<?=$deviceid?>')"><i class="fas fa-heart"></i> <?=$like_cnt?> LIKE</a></li>
		<?}?>
		 
	</ul>
	<?if(($setting_col['abs_info']=="Y" && $subcol['abs_info']) || 
	($setting_col['purpose']=="Y" && $subcol['purpose']) ||
	($setting_col['methods']=="Y" && $subcol['methods']) ||
	($setting_col['results']=="Y" && $subcol['results']) ||
	($setting_col['conclusions']=="Y" && $subcol['conclusions']) ||
	($setting_col['keywords']=="Y" && $subcol['keywords'])){?>
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

		<dl>
		<?if($setting_col['abs_info']=="Y" && $subcol['abs_info']){?>
			<dd><?=$subcol['abs_info']?></dd>
		<?}?>
		<?if($setting_col['purpose']=="Y" && $subcol['purpose']){?>
			<dt class="absTit">Purpose</dt>
			<dd><?=$subcol['purpose']?></dd>
		<?}?>
		<?if($setting_col['methods']=="Y" && $subcol['methods']){?>
			<dt class="absTit">Methods</dt>
			<dd><?=$subcol['methods']?></dd>
		<?}?>
		<?if($setting_col['results']=="Y" && $subcol['results']){?>
			<dt class="absTit">Results</dt>
			<dd><?=$subcol['results']?></dd>
		<?}?>
		<?if($setting_col['conclusions']=="Y" && $subcol['conclusions']){?>
			<dt class="absTit">Conclusions</dt>
			<dd><?=$subcol['conclusions']?></dd>
		<?}?>
		<?if($setting_col['keywords']=="Y" && $subcol['keywords']){?>
			<dt class="absTit">Keywords</dt>
			<dd><?=$subcol['keywords']?></dd>
		<?}?>
		</dl>
	</div>
	<?}?>

</div>
	<div class="popupWrap" id="popupMemo">
		<dl>
			<dt><i class="fas fas fa-edit"></i><?if($event_col['language']=="Kor"){?>메모를 작성해 주세요<?}else{?>Please write a Memo.<?}?></dt>
			<dd>
				<form id="memoform" name="memoform" action="./memo.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
					<input type="hidden" name="code" value="<?=$code?>">
					<input type="hidden" name="deviceid" id="deviceid" value="<?=$deviceid?>">
					<input type="hidden" name="session_sid" id="session_sid" value="<?=$sid?>">

					<input type="hidden" name="file1" id="file1" value="<?=$memo_row['file1']?>">
					<input type="hidden" name="file2" id="file2" value="<?=$memo_row['file2']?>">
					<input type="hidden" name="file3" id="file3" value="<?=$memo_row['file3']?>">

					<input type="file" accept="image/*" name="userfile1" id="userfile1" class="opacity0" style="position: absolute;left:0;top:0;width:0px;height:0px">
					<input type="file" accept="image/*" name="userfile2" id="userfile2" class="opacity0" style="position: absolute;left:0;top:0;width:0px;height:0px">
					<input type="file" accept="image/*" name="userfile3" id="userfile3" class="opacity0" style="position: absolute;left:0;top:0;width:0px;height:0px">

					<fieldset>
						<legend>Memo</legend>
						<textarea name="memo_txt" id="memo_txt" cols="30" rows="10"><?=$memo_row['memo']?></textarea>
						
						<ul class="img" id="img_array">
						<?if($memo_row['file1']){?>
							<li id='memo_imgli1'><a>
								<img id="memo_img1" src="/upload/memo/<?=$memo_row['file1']?>" alt="">
								<i class="fas fa-times-circle" onclick="javascript:image_del('1')"></i>
							</a></li>
						<?}?>
						<?if($memo_row['file2']){?>
							<li id='memo_imgli2'><a>
								<img id="memo_img2" src="/upload/memo/<?=$memo_row['file2']?>" alt="">
								<i class="fas fa-times-circle" onclick="javascript:image_del('2')"></i>
							</a></li>
						<?}?>
						<?if($memo_row['file3']){?>
							<li id='memo_imgli3'><a>
								<img id="memo_img3" src="/upload/memo/<?=$memo_row['file3']?>" alt="">
								<i class="fas fa-times-circle" onclick="javascript:image_del('3')"></i>
							</a></li>
						<?}?>
						</ul>

						<p class="photo"><i class="fas fa-camera" title="사진 선택하기"><input type="file" accept="image/*" name="userfile" id="userfile" onchange="loadFile(event)" class="opacity0" style="position: absolute;    left: 0;top: 0;"></i></p>


						<span class="btn"><input value="Save" class="btnDef"  onclick="javascript:memo_add('<?=$code?>','<?=$deviceid?>','<?=$sid?>')"><input value="Close" class="btnDef" id="close"></span>


					</fieldset>
					
					
					
				</form>

			</dd>
		</dl>
	</div>


	<div class="popupWrap2 evalute" id="popupEvaluation">
		<dl>
			<dt><i class="fas fas fa-edit"></i><?if($event_col['language']=="Kor"){?>강의평가<?}else{?>Please write a Session Evaluation.<?}?></dt>
			<dd>
				<form id="" name="" action="./evaluation.php" method="post">
					<input type="hidden" name="code" value="<?=$code?>">
					<input type="hidden" name="deviceid" id="deviceid" value="<?=$deviceid?>">
					<input type="hidden" name="session_sid" id="session_sid" value="<?=$sid?>">
					<fieldset>
						<legend>Session Evaluation</legend>

						<dd>
						<ul id="stars">
							<li class='star' title='Poor'>
								<span class="changeBg inputR2_b a <?if($evaluation_row['score']>=1){?> on<?}?>" data-value='1'  id="star1_1"><input type="radio" onchange="score_change(1)" name="score" value="1" id="star_1" <?if($evaluation_row['score']==1){?> checked<?}?>></span>
								<!-- <label for="">1</label> -->
							</li>
							<li class='star' title='Fair'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=2){?> on<?}?>" data-value='2'  id="star1_2"><input type="radio" onchange="score_change(2)" name="score"  value="2" id="star_2" <?if($evaluation_row['score']==2){?> checked<?}?>></span>
								<!-- <label for="">2</label> -->
							</li>
							<li class='star' title='Good'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=3){?> on<?}?>" data-value='3'  id="star1_3"><input type="radio" onchange="score_change(3)" name="score" value="3" id="star_3" <?if($evaluation_row['score']==3){?> checked<?}?>></span>
								<!-- <label for="">3</label> -->
							</li>
							<li class='star' title='Excellent'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=4){?> on<?}?>" data-value='4'  id="star1_4"><input type="radio" onchange="score_change(4)" name="score" value="4" id="star_4" <?if($evaluation_row['score']==4){?> checked<?}?>></span>
								<!-- <label for="">4</label> -->
							</li>
							<li  class='star' title='WOW!!!'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=5){?> on<?}?>" data-value='5'  id="star1_5"><input type="radio" onchange="score_change(5)" name="score" value="5" id="star_5" <?if($evaluation_row['score']==5){?> checked<?}?>></span>
								<!-- <label for="">5</label> -->
							</li>
						</ul>
					</dd>
						<textarea name="memo_txt" id="memo_txt" cols="30" rows="5"><?=$evaluation_row['memo']?></textarea>
						<span class="btn"><input value="SEND" class="btnDef" onclick="javascript:evaluation_add('<?=$code?>','<?=$deviceid?>','<?=$sid?>')"><input value="Close" class="btnDef" id="close"></span>
					</fieldset>
				</form>

			</dd>
		</dl>
	</div>

<?
if($code=='kingca2019'){
$sub_view = true;
$query = "select a.*,t.time time_info, r.name room_info, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.viewYN='Y' ";
$query .= " and a.sid='".$subcol['link_session']."' ";
$query .= " order by a.tab asc, a.orderby asc";
$result = mysqli_query($conn, $query);
include "./info.php";
}?>


<script>

	var formData = new FormData(); 

	var img_chk=0;
	var loadFile = function(event) {
		
		//alert(document.getElementById("userfile").files[0]);

		if(!document.getElementById("file1").value){
			$("#img_array").append("<li id='memo_imgli1'><a><img id='memo_img1' src='' alt=''><i class='fas fa-times-circle' onclick='javascript:image_del(1)'></i></a></li>");
			var output = document.getElementById('memo_img1');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file1").value="new";
			document.getElementById("userfile1").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile1");
			formData.append("userfile1", document.getElementById("userfile").files[0]);
		}else if(!document.getElementById("file2").value){
			$("#img_array").append("<li id='memo_imgli2'><a><img id='memo_img2' src='' alt=''><i class='fas fa-times-circle' onclick='javascript:image_del(2)'></i></a></li>");
			var output = document.getElementById('memo_img2');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file2").value="new";
			document.getElementById("userfile2").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile2");
			formData.append("userfile2", document.getElementById("userfile").files[0]);
			
		}else if(!document.getElementById("file3").value){
			$("#img_array").append("<li id='memo_imgli3'><a><img id='memo_img3' src='' alt=''><i class='fas fa-times-circle' onclick='javascript:image_del(3)'></i></a></li>");
			var output = document.getElementById('memo_img3');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file3").value="new";
			document.getElementById("userfile3").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile3");
			formData.append("userfile3", document.getElementById("userfile").files[0]);
			
		}else{
			alert("3개까지 등록 가능합니다.");
		}
		/*
		if(document.getElementById("file3").value){
			alert("3개까지 등록 가능합니다.");
		}
		else if(document.getElementById("file2").value){
			$("#img_array").append("<li><a><img id='memo_img3' src='' alt=''><i class='fas fa-times-circle'></i></a></li>");
			var output = document.getElementById('memo_img3');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file3").value="new";
			document.getElementById("userfile3").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile3");
			formData.append("userfile3", document.getElementById("userfile").files[0]);
			
		}
		else if(document.getElementById("file1").value){
			$("#img_array").append("<li><a><img id='memo_img2' src='' alt=''><i class='fas fa-times-circle'></i></a></li>");
			var output = document.getElementById('memo_img2');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file2").value="new";
			document.getElementById("userfile2").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile2");
			formData.append("userfile2", document.getElementById("userfile").files[0]);
			
		}else{
			$("#img_array").append("<li><a><img id='memo_img1' src='' alt=''><i class='fas fa-times-circle'></i></a></li>");
			var output = document.getElementById('memo_img1');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file1").value="new";
			document.getElementById("userfile1").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile1");
			formData.append("userfile1", document.getElementById("userfile").files[0]);
		}
		*/
		//alert($(this).attr('name'));
		//alert(URL.createObjectURL(event.target.files[0]));
		

		/*
		if(value.files && value.files[0]) 
		{
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#memo_img1').attr('src', e.target.result);
			}
		
			reader.readAsDataURL(value.files[0]);
		}
		*/
	 };

	function sessionlike(code, sid, deviceid){
		
		$.ajax({
			type:"POST",
			url:"./like.php",
			data:"code="+code+"&session_sid="+sid+"&deviceid="+deviceid,
			success:function(msg){
				var temp = msg.split("|");
				if(temp[0] == "Y"){
					$('#session_like').addClass("on");
				}else{
					$('#session_like').removeClass("on");
				}

				document.getElementById("session_like").innerHTML="<i class='fas fa-heart'></i> "+temp[1];

				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});
		
	}

	function image_del(sid){

		if(sid=="1"){
			document.getElementById("file1").value="";
			$("#memo_imgli1").remove();
		}else if(sid=="2"){
			document.getElementById("file2").value="";
			$("#memo_imgli2").remove();
		}else if(sid=="3"){
			document.getElementById("file3").value="";
			$("#memo_imgli3").remove();
		}
	
	}



	function evaluation_add(code,deviceid,sid){
		$(':focus').blur();  

		var option = {
			url : url,
			type : "post",
			data : $("#memoform").serialize(),
			success : function(data) {
			 alert(data);
			}
		   };
		  $("#memoform").ajaxSubmit(option);

		/*
		memoform
		$.ajax({
			type:"POST",
			data:"session_sid="+sid+"&deviceid="+deviceid+"&code="+code+"&score="+document.getElementsByName("score")+"&memo_txt="+encodeURIComponent(document.getElementById("memo_txt").value),
			success:function(msg){
				$("div.wrapper").css({
					"overflow":"visible",
					"height":"auto"
				});

				$("div.popupWrap").hide();
				$("div.popupWrap2").hide();
				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});
		*/
	}


	function memo_add(code,deviceid,sid){
		$(':focus').blur();  
		
		formData.delete("session_sid");
		formData.delete("deviceid");
		formData.delete("code");
		formData.delete("memo_txt");

		formData.append("session_sid", sid); 
		formData.append("deviceid", deviceid); 
		formData.append("code", code);

		formData.append("file1", document.getElementById("file1").value);
		formData.append("file2", document.getElementById("file2").value);
		formData.append("file3", document.getElementById("file3").value);
		formData.append("memo_txt", document.getElementById("memo_txt").value);
		
	
		$.ajax({
			type:"POST",
			url:"./memo.php",
			data:formData,
			processData: false,
            contentType: false,
			success:function(msg){
				alert(msg);
				$("div.wrapper").css({
					"overflow":"visible",
					"height":"auto"
				});

				$("div.popupWrap").hide();
				$("div.popupWrap2").hide();
				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});
		
		
		/*
		var option = {
			url : "./memo.php",
			type : "post",
			data : $("#memoform").serialize(),
			success : function(data) {
			 alert(data);
			}
		   };
		  $("#memoform").ajaxSubmit(option);
		  */
		  /*
		$.ajax({
			type:"POST",
			url:"./memo.php",
			data:"session_sid="+sid+"&deviceid="+deviceid+"&code="+code+"&memo_txt="+encodeURIComponent(document.getElementById("memo_txt").value),
			success:function(msg){
				alert(msg);
				$("div.wrapper").css({
					"overflow":"visible",
					"height":"auto"
				});

				$("div.popupWrap").hide();
				$("div.popupWrap2").hide();
				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});
		*/
	}

	function score_change(val){
		//alert(val);
		for(var i=1;i<=5;i++){
			if(i<=val){
				$('#star1_'+i).addClass("on");
			}else{
				$('#star1_'+i).removeClass("on");
			}
		}
	}

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

