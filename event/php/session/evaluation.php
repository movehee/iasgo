<?if($setting_col['evaluation']=="Y"/* || $setting_col['session_evaluation']=="Y"*/){?><!--session 평가, 강의평가 팝업-->
	<div class="popupWrap2 evalute" id="popupEvaluation">
		
		<dl>
		
			<dt><i class="fas fas fa-edit"></i><?=$string['evaluation_info']?>
			<?if($code=='ksc2019'){?>
			<a class="close"><i class="far fa-times-circle fa-2x" style="position:absolute;right:10px;top:20px"></i></a>
			<?}?>
			</dt>
			<dd>
				<form id="" name="" action="./set_evaluation.php" method="post">
					<input type="hidden" name="code" value="<?=$code?>">
					<input type="hidden" name="deviceid" id="deviceid" value="<?=$deviceid?>">
					<input type="hidden" name="session_sid" id="session_sid" value="<?=$sid?>">
					<input type="hidden" name="score1" id="score1" value="<?=$evaluation_row['score']?>">
					<fieldset>
						<legend>Session Evaluation</legend>

						<dd>
						<ul id="stars">
							<li class='star' title='Poor'>
								<span class="changeBg inputR2_b a <?if($evaluation_row['score']>=1){?> on<?}?>" data-value='1'  id="star1_1"><input type="radio" onchange="score_change(1)" name="score" value="1" id="star1_1" <?if($evaluation_row['score']==1){?> checked<?}?>></span>
								<!-- <label for="">1</label> -->
							</li>
							<li class='star' title='Fair'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=2){?> on<?}?>" data-value='2'  id="star1_2"><input type="radio" onchange="score_change(2)" name="score"  value="2" id="star1_2" <?if($evaluation_row['score']==2){?> checked<?}?>></span>
								<!-- <label for="">2</label> -->
							</li>
							<li class='star' title='Good'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=3){?> on<?}?>" data-value='3'  id="star1_3"><input type="radio" onchange="score_change(3)" name="score" value="3" id="star1_3" <?if($evaluation_row['score']==3){?> checked<?}?>></span>
								<!-- <label for="">3</label> -->
							</li>
							<li class='star' title='Excellent'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=4){?> on<?}?>" data-value='4'  id="star1_4"><input type="radio" onchange="score_change(4)" name="score" value="4" id="star1_4" <?if($evaluation_row['score']==4){?> checked<?}?>></span>
								<!-- <label for="">4</label> -->
							</li>
							<li  class='star' title='WOW!!!'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=5){?> on<?}?>" data-value='5'  id="star1_5"><input type="radio" onchange="score_change(5)" name="score" value="5" id="star1_5" <?if($evaluation_row['score']==5){?> checked<?}?>></span>
								<!-- <label for="">5</label> -->
							</li>
						</ul>
						
					</dd>
						<textarea name="memo_txt2" id="memo_txt2" cols="30" rows="5"><?=$evaluation_row['memo']?></textarea>
						<span class="btn">
							<a value="Send" class="btnDef" onclick="javascript:evaluation_add('<?=$code?>','<?=$deviceid?>','<?=$sid?>','<?=$regist_sid?>')">Send</a>
							<a value="Close" class="btnDef close" id="close">Close</a>
						</span>
						<?if($code=="PRS2019"){?>
						<div style="padding:10px 5px";>
							좋은 의견을 주신 분들 중 추첨을 통해 소정의 상품을 드립니다.  
							(로그인 후 참여주세요.) 
						</div>
						<?}?>
					</fieldset>
				</form>

			</dd>
		</dl>
	</div>
	<script>

	function score_change(val){
		document.getElementById("score1").value=val;
		for(var i=1;i<=5;i++){
			if(i<=val){
				$('#star1_'+i).addClass("on");
			}else{
				$('#star1_'+i).removeClass("on");
			}
		}
	}

	function session_evaluation(sid,deviceid,code) {
		document.getElementById("session_sid").value = sid;
		$.ajax({
			type:"POST",
			url:"./get_evaluation.php",
			data:"session_sid="+sid+"&deviceid="+deviceid+"&code="+code,
			success:function(msg){
				var temp = msg.split('||');
				
				for(var i=1;i<=5;i++){
					if(i<=temp[0]){
						$('#star1_'+i).addClass("on");
					}else{
						$('#star1_'+i).removeClass("on");
					}
				}
				document.getElementById("score1").value=temp[0];

				document.getElementById("memo_txt2").value = temp[1];
				document.getElementById("memo_txt2").innerHTML = temp[1];


				
			}
		});
	}


	function evaluation_add(code,deviceid,sid,regist_sid){

		var comp_msg = "<?=$string['evaluation_comp_msg']?>";
		
		$(':focus').blur();
		$.ajax({
			type:"POST",
			url:"./set_evaluation.php",
			data:"session_sid="+document.getElementById("session_sid").value+"&deviceid="+deviceid+"&code="+code+"&regist_sid="+regist_sid+"&score="+document.getElementById("score1").value+"&memo_txt="+encodeURIComponent(document.getElementById("memo_txt2").value),
			success:function(msg){
				$("div.wrapper").css({
					"overflow":"visible",
					"height":"auto"
				});

				$("div.popupWrap").hide();
				$("div.popupWrap2").hide();
				$("div.popupWrap3").hide();

				alert(comp_msg);

			}
		});
	}


	</script>
<?}?>
<?if($setting_col['evaluation']=="Y2"){?>
	<div class="" id="KoaEvalute">
		<div class="evalwrap">
			<h3 class="evaltit"><?=$string['evaluation_info']?></h3>
			<form id="" name="" action="./set_evaluation.php" method="post">
				<input type="hidden" name="code" value="<?=$code?>">
				<input type="hidden" name="deviceid" id="deviceid" value="<?=$deviceid?>">
				<input type="hidden" name="session_sid" id="session_sid" value="<?=$sid?>">
				<input type="hidden" name="score2" id="score2" value="<?=$evaluation_row['score']?>">
				<fieldset>
					<legend>강의평가</legend>

					<dd>
					<ul class="changeBg">
						<li style="width:20%">
							<a id="star5" <?if($evaluation_row['score']=="5"){?>class="on"<?}?> onclick="score_change2(5)" ><i class="fas fa-check" style="line-height: 37px;padding-top:3px"></i></a>
							<label <?if(strpos($string['evaluation_txt1'], "<br>") !== false) {?> class="towline"<?}?> for=""><?=$string['evaluation_txt1']?></label>
						</li>

						<li style="width:20%">
							<a id="star4" <?if($evaluation_row['score']=="4"){?>class="on"<?}?> onclick="score_change2(4)" ><i class="fas fa-check" style="line-height: 37px;padding-top:3px"></i></a>
							<label <?if(strpos($string['evaluation_txt2'], "<br>") !== false) {?> class="towline"<?}?>  for=""><?=$string['evaluation_txt2']?></label>
						</li>

						<li style="width:20%">
							<a id="star3" <?if($evaluation_row['score']=="3"){?>class="on"<?}?> onclick="score_change2(3)" ><i class="fas fa-check" style="line-height: 37px;padding-top:3px"></i></a>
							<label  <?if(strpos($string['evaluation_txt3'], "<br>") !== false) {?> class="towline"<?}?> for=""><?=$string['evaluation_txt3']?></label>
						</li>
						<li style="width:20%">
							<a id="star2" <?if($evaluation_row['score']=="2"){?>class="on"<?}?> onclick="score_change2(2)" >
							 <i class="fas fa-check" style="line-height: 37px;padding-top:3px"></i></a>
							<label  <?if(strpos($string['evaluation_txt4'], "<br>") !== false) {?> class="towline"<?}?> for=""><?=$string['evaluation_txt4']?></label>
						</li>
		
						<li style="width:20%">
							<a id="star1" <?if($evaluation_row['score']=="1"){?>class="on"<?}?> onclick="score_change2(1)" ><i class="fas fa-check" style="line-height: 37px;padding-top:3px"></i></a>
							<label  <?if(strpos($string['evaluation_txt5'], "<br>") !== false) {?> class="towline"<?}?> for=""><?=$string['evaluation_txt5']?></label>
						</li>
					</ul>
				</dd>
					<textarea name="memo_txt3" id="memo_txt3" cols="30" rows="5"><?=$evaluation_row['memo']?></textarea>
					<span class="btn">
						<a value="Send" class="btnDef" onclick="javascript:evaluation_add2('<?=$code?>','<?=$deviceid?>','<?=$sid?>','<?=$regist_sid?>')"><?=$string['evaluation_send']?></a>
					</span>
				</fieldset>
			</form>
		</div>
	</div>

	<script>

	function score_change2(val){
		//alert(val);
		for(var i=1;i<=5;i++){
			if(i==val){
				$('#star'+i).addClass("on");
			}else{
				$('#star'+i).removeClass("on");
			}
		}
		document.getElementById("score2").value=val;
	}

	function evaluation_add2(code,deviceid,sid,regist_sid){
		
		var comp_msg = "<?=$string['evaluation_comp_msg']?>";

		$(':focus').blur();
		$.ajax({
			type:"POST",
			url:"./set_evaluation.php",
			data:"session_sid="+sid+"&deviceid="+deviceid+"&code="+code+"&regist_sid="+regist_sid+"&score="+document.getElementById("score2").value+"&memo_txt="+encodeURIComponent(document.getElementById("memo_txt3").value),
			success:function(msg){
				alert(comp_msg);
			}
		});
	}


	</script>
<?}else if($setting_col['evaluation']=="Y3"){?><!--하단 별-->
	<div class="evalute" id="Evalute3">
		<div class="evalwrap">
		<h3 class="evaltit"><?=$string['evaluation_info']?></h3>
			<dl>
				<form id="" name="" action="./set_evaluation.php" method="post">
					<input type="hidden" name="code" value="<?=$code?>">
					<input type="hidden" name="deviceid" id="deviceid" value="<?=$deviceid?>">
					<input type="hidden" name="session_sid" id="session_sid" value="<?=$sid?>">
					<input type="hidden" name="score1" id="score1" value="<?=$evaluation_row['score']?>">
					<fieldset>
						<legend>Session Evaluation</legend>

						<dd>
						<ul id="stars">
							<li class='star' title='Poor'>
								<span class="changeBg inputR2_b a <?if($evaluation_row['score']>=1){?> on<?}?>" data-value='1'  id="star1_1"><input type="radio" onchange="score_change(1)" name="score" value="1" id="star1_1" <?if($evaluation_row['score']==1){?> checked<?}?>></span>
								<!-- <label for="">1</label> -->
							</li>
							<li class='star' title='Fair'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=2){?> on<?}?>" data-value='2'  id="star1_2"><input type="radio" onchange="score_change(2)" name="score"  value="2" id="star1_2" <?if($evaluation_row['score']==2){?> checked<?}?>></span>
								<!-- <label for="">2</label> -->
							</li>
							<li class='star' title='Good'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=3){?> on<?}?>" data-value='3'  id="star1_3"><input type="radio" onchange="score_change(3)" name="score" value="3" id="star1_3" <?if($evaluation_row['score']==3){?> checked<?}?>></span>
								<!-- <label for="">3</label> -->
							</li>
							<li class='star' title='Excellent'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=4){?> on<?}?>" data-value='4'  id="star1_4"><input type="radio" onchange="score_change(4)" name="score" value="4" id="star1_4" <?if($evaluation_row['score']==4){?> checked<?}?>></span>
								<!-- <label for="">4</label> -->
							</li>
							<li  class='star' title='WOW!!!'>
								<span class="changeBg inputR2_b a<?if($evaluation_row['score']>=5){?> on<?}?>" data-value='5'  id="star1_5"><input type="radio" onchange="score_change(5)" name="score" value="5" id="star1_5" <?if($evaluation_row['score']==5){?> checked<?}?>></span>
								<!-- <label for="">5</label> -->
							</li>
						</ul>
					</dd>
						<textarea name="memo_txt3" id="memo_txt3" cols="30" rows="5"><?=$evaluation_row['memo']?></textarea>
						<span class="btn">
							<a value="Send" class="btnDef" onclick="javascript:evaluation_add('<?=$code?>','<?=$deviceid?>','<?=$sid?>','<?=$regist_sid?>')"><?=$string['evaluation_send']?></a>
						</span>
					</fieldset>
				</form>

			</dl>
		</div>
	</div>

	<script>

	function score_change(val){
		document.getElementById("score1").value=val;
		for(var i=1;i<=5;i++){
			if(i<=val){
				$('#star1_'+i).addClass("on");
			}else{
				$('#star1_'+i).removeClass("on");
			}
		}
	}
/*
	function session_evaluation(sid,deviceid,code) {
		document.getElementById("session_sid").value = sid;
		$.ajax({
			type:"POST",
			url:"./get_evaluation.php",
			data:"session_sid="+sid+"&deviceid="+deviceid+"&code="+code,
			success:function(msg){
				var temp = msg.split('||');
				
				for(var i=1;i<=5;i++){
					if(i<=temp[0]){
						$('#star1_'+i).addClass("on");
					}else{
						$('#star1_'+i).removeClass("on");
					}
				}
				document.getElementById("score1").value=temp[0];

				document.getElementById("memo_txt2").value = temp[1];
				document.getElementById("memo_txt2").innerHTML = temp[1];


				
			}
		});
	}
	*/

	function evaluation_add(code,deviceid,sid,regist_sid){
		var comp_msg = "<?=$string['evaluation_comp_msg']?>";
		
		$(':focus').blur();
		$.ajax({
			type:"POST",
			url:"./set_evaluation.php",
			data:"session_sid="+document.getElementById("session_sid").value+"&deviceid="+deviceid+"&code="+code+"&regist_sid="+regist_sid+"&score="+document.getElementById("score1").value+"&memo_txt="+encodeURIComponent(document.getElementById("memo_txt3").value),
			success:function(msg){
				alert(comp_msg);
			}
		});
	}


	</script>
<?}?>