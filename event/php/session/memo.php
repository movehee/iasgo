<div class="popupWrap" id="popupMemo">
	<dl>
		<dt><i class="fas fas fa-edit"></i><?=$string['memo_info']?></dt>
		<dd>



			<form id="memoform" name="memoform" action="./set_memo.php" method="post" enctype="multipart/form-data">
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
						<li id='memo_imgli1'><a onclick="imageOpen('/upload/memo/<?=$memo_row['file1']?>')">
							<img id="memo_img1" src="/upload/memo/<?=$memo_row['file1']?>" alt=""></a>
							<i class="fas fa-times-circle" onclick="javascript:image_del('1')"></i>
						</li>
					<?}?>
					<?if($memo_row['file2']){?>
						<li id='memo_imgli2'><a onclick="imageOpen('/upload/memo/<?=$memo_row['file2']?>')">
							<img id="memo_img2" src="/upload/memo/<?=$memo_row['file2']?>" alt=""></a>
							<i class="fas fa-times-circle" onclick="javascript:image_del('2')"></i>
						</li>
					<?}?>
					<?if($memo_row['file3']){?>
						<li id='memo_imgli3'><a onclick="imageOpen('/upload/memo/<?=$memo_row['file3']?>')">
							<img id="memo_img3" src="/upload/memo/<?=$memo_row['file3']?>" alt=""></a>
							<i class="fas fa-times-circle" onclick="javascript:image_del('3')"></i>
						</li>
					<?}?>
					</ul>
					<?if($setting_col['memo_type']=="2"){?>
					<p class="photo"><i class="fas fa-camera" title="사진 선택하기"><input type="file" accept="image/*;capture=camera" name="userfile" id="userfile" onchange="loadFile(event)" class="opacity0" style="position: absolute;left: 0;top: 0;"></i></p>
					<?}?>
					<span class="btn">
					<a value="Save" class="btnDef" onclick="javascript:memo_add('<?=$code?>','<?=$deviceid?>','<?=$sid?>')">Save</a>
					<a value="Close" class="btnDef close" id="close">Close</a></span>


				</fieldset>



			</form>

		</dd>
	</dl>
</div>

<!--메모 > 이미지 팝업-->
<div class="popupWrap3" id="popupMemoImg">
	<div><img id="popup_img" src="/image/ing.png" /> </div>
	<p class="close btnBg"><a class="imageclose" href="#">팝업닫기</a></p>
</div>

<script>

	var formData = new FormData();
	var img_chk=0;
	var loadFile = function(event) {

		//alert(document.getElementById("userfile").files[0]);

		if(!document.getElementById("file1").value){
			$("#img_array").append("<li id='memo_imgli1'><a onclick='imageOpen(\""+URL.createObjectURL(event.target.files[0])+"\")'><img id='memo_img1' src='' alt=''><i class='fas fa-times-circle' onclick='javascript:image_del(1)'></i></a></li>");
			var output = document.getElementById('memo_img1');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file1").value="new";
			document.getElementById("userfile1").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile1");
			formData.append("userfile1", document.getElementById("userfile").files[0]);
		}else if(!document.getElementById("file2").value){
			$("#img_array").append("<li id='memo_imgli2'><a onclick='imageOpen(\""+URL.createObjectURL(event.target.files[0])+"\")'><img id='memo_img2' src='' alt=''><i class='fas fa-times-circle' onclick='javascript:image_del(2)'></i></a></li>");
			var output = document.getElementById('memo_img2');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file2").value="new";
			document.getElementById("userfile2").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile2");
			formData.append("userfile2", document.getElementById("userfile").files[0]);

		}else if(!document.getElementById("file3").value){
			$("#img_array").append("<li id='memo_imgli3'><a onclick='imageOpen(\""+URL.createObjectURL(event.target.files[0])+"\")'><img id='memo_img3' src='' alt=''><i class='fas fa-times-circle' onclick='javascript:image_del(3)'></i></a></li>");
			var output = document.getElementById('memo_img3');
			output.src = URL.createObjectURL(event.target.files[0]);
			document.getElementById("file3").value="new";
			document.getElementById("userfile3").files[0] = document.getElementById("userfile").files[0];
			formData.delete("userfile3");
			formData.append("userfile3", document.getElementById("userfile").files[0]);

		}else{
			alert("3개까지 등록 가능합니다.");
		}
	 };

	function imageOpen(url){
		//alert(url);
		$("div.popupWrap3").fadeIn();
		document.getElementById('popup_img').src=url;
	}

	function memo_add(code,deviceid,sid){
		$(':focus').blur();

		formData.delete("session_sid");
		formData.delete("deviceid");
		formData.delete("code");
		formData.delete("memo_txt");

		formData.append("session_sid", document.getElementById("session_sid").value);
		formData.append("deviceid", deviceid);
		formData.append("code", code);

		formData.append("file1", document.getElementById("file1").value);
		formData.append("file2", document.getElementById("file2").value);
		formData.append("file3", document.getElementById("file3").value);
		formData.append("memo_txt", document.getElementById("memo_txt").value);
		//alert(document.getElementById("memo_txt").value);
		//alert(document.getElementById("memo_txt").innerHTML);

		$.ajax({
			type:"POST",
			url:"./set_memo.php",
			data:formData,
			processData: false,
            contentType: false,
			success:function(msg){
				//alert(msg);
				$("div.wrapper").css({
					"overflow":"visible",
					"height":"auto"
				});

				$("div.popupWrap").hide();
				$("div.popupWrap2").hide();
				$("div.popupWrap3").hide();
				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});
	}

	function memo_click(sid,deviceid)
	{
		document.getElementById("session_sid").value = sid;
		$.ajax({
			type:"POST",
			url:"./get_memo.php",
			data:"session_sid="+sid+"&deviceid="+deviceid,
			success:function(msg){
				var temp = msg.split('||');
				document.getElementById("memo_txt").innerHTML = temp[0];
				document.getElementById("memo_txt").value = temp[0];

				
				$("#img_array").find("li").remove();
			
				if(temp[1].length>10){
					$("#img_array").append("<li id='memo_imgli1'><a onclick='imageOpen(\"/upload/memo/"+temp[1]+"\")'><img id='memo_img1' src='/upload/memo/"+temp[1]+"' alt=''></a></li>");
				}else{
					$("#memo_imgli1").remove();
				}

				if(temp[2].length>10){
					$("#img_array").append("<li id='memo_imgli2'><a onclick='imageOpen(\"/upload/memo/"+temp[2]+"\")'><img id='memo_img2' src='/upload/memo/"+temp[2]+"' alt=''></a></li>");
				}else{
					$("#memo_imgli2").remove();
				}
				
				if(temp[3].length>10){
					$("#img_array").append("<li id='memo_imgli3'><a onclick='imageOpen(\"/upload/memo/"+temp[3]+"\")'><img id='memo_img3' src='/upload/memo/"+temp[3]+"' alt=''></a></li>");
				}else{
					$("#memo_imgli3").remove();
				}
				
	
			}
		});

	}

	function image_del(sid){
		if(confirm("삭제하시겠습니까?")){
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
	}
</script>