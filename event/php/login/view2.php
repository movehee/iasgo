<?include "./../header.php";?>

<?

/*
if ($code == "ksecho38") {
	$title = "feedback";
	}
*/

$setting_query = "SELECT * FROM session_set_tbl where code='".$code."'";
//echo $setting_query;
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

if(!$id) {
	$id= $deviceid;
}
$query="SELECT * FROM feedback_tbl where code='".$code."' and  del='N'  and tab='999'";

$query.=" order by orderby asc";
$result = mysqli_query($conn, $query);

$d = null;
$sub_result = mysqli_query($conn, "SELECT count(*) cnt FROM feedback_result_tbl where code='".$code."' and deviceid='".$id."' and tab='999'");
$row = mysqli_fetch_array($sub_result);

if($row['cnt']>0){
$feedback_query = "SELECT * FROM feedback_result_tbl where code='".$code."' and deviceid='".$id."' and tab='999'";
//echo $feedback_query;
$feedback_result = mysqli_query($conn, $feedback_query);
$d = mysqli_fetch_array($feedback_result);
}

$j=1;
$q=1;
?>


<div class="wrapper">

	

	</div>




	<div class="feedbackArea">
	<form name="researchF" id="researchF" method="post" action="./post2.php">
	<input type="hidden" name="code" id="code" value="<?=$code?>">
	<input type="hidden" name="deviceid" id="deviceid" value="<?=$id?>">
	<input type="hidden" name="name" value="<?=$name?>">
	<input type="hidden" name="email" value="<?=$email?>">
	<input type="hidden" name="license" value="<?=$license?>">
	<input type="hidden" name="tab" value="999">
	<input type="hidden" name="office" value="<?=$office?>">
	<input type="hidden" name="all_chk" id="all_chk" value="<?=$setting_col['feedback_all_chk']?>">
	<input type="hidden" name="min_chk" id="min_chk" value="<?=$setting_col['feedback_min_chk']?>">
	<!--

	<input type="hidden" name="hospital" value="<?=$hospital?>">
	-->
	<legend>FEEDBACK</legend>
	<fieldset style="border:1px solid <?=$css_col['feedback_bg']?>">
		
		<?while(is_array($col = mysqli_fetch_array($result))){
			$val_list[$col['sid']] = $d['answer'.$j];
		?>

			<?if($col['type']=="0"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<h2 class="subTitBg"><span><b><?=$col['val1']?></b></span><?=$col['val2']?></h2>
			<div>
			<?}?>


			<?if($col['type']=="1"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<h2 class="subTitBg" style="padding: 10px 15px 10px 15px;"><?=$col['val1']?></h2>
			</div>
			<?}?>
			
			<?if($col['type']=="2"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<dl class='feedbackItem'>
					<dt class="subTit2"><?=$col['val1']?></dt>
				</dl>
			</div>
			<?}?>

			<?if($col['type']=="3"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<dl class='feedbackItem'>
					<dt class="subTit"><b>ㆍ</b><?=$col['val1']?></dt>
				</dl>
			</div>
			<?}?>


			<?if($col['type']=="11"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<dl class='feedbackItem'>
					<dd class="multi">
					<?for($i=1;$i<=$col['cnt'];$i++){?>
						
						<span class="changeBg inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>,<?=$col['sid']?>)">
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>
					<?}?>

					<input type="hidden" name="parent<?=$j?>" id="parent<?=$j?>" value="<?=$col['parent']?>">
					<input type="hidden" name="parent_val<?=$j?>" id="parent_val<?=$j?>" value="<?=$col['parent_val']?>">

					<input type="hidden" name="answers<?=$col['sid']?>" id="answers<?=$col['sid']?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer_necessary<?=$j?>" id="answer_necessary<?=$j?>" value="<?=$col['necessary']?>">
					<input type="hidden" name="answer_necessary_txt<?=$j?>" id="answer_necessary_txt<?=$j?>" value="<?=$col['necessary_txt']?>">
					<?$j++;?>
					</dd>
				</dl>
			</div>
			<?}?>

			<?if($col['type']=="12"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<ul class='feedbackItem'>

					<?for($i=1;$i<=$col['cnt'];$i++){?>
						<li onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>,<?=$col['sid']?>)">
						<span class="changeBg inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" >
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>
					<?}?>
					<input type="hidden" name="parent<?=$j?>" id="parent<?=$j?>" value="<?=$col['parent']?>">
					<input type="hidden" name="parent_val<?=$j?>" id="parent_val<?=$j?>" value="<?=$col['parent_val']?>">
					<input type="hidden" name="answers<?=$col['sid']?>" id="answers<?=$col['sid']?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer_necessary<?=$j?>" id="answer_necessary<?=$j?>" value="<?=$col['necessary']?>">
					<input type="hidden" name="answer_necessary_txt<?=$j?>" id="answer_necessary_txt<?=$j?>" value="<?=$col['necessary_txt']?>">
					<?$j++;?>

				</ul>
			</div>
			<?}?>

			<?if($col['type']=="13"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<ul class='feedbackItem'>

					<?for($i=1;$i<=$col['cnt'];$i++){?>
						<li onclick="chk_qu2(<?=$j?>,<?=$i?>,<?=$col['cnt']?>,<?=$col['max']?>)">
						<span class="changeBg inputR 
						
						<?
						$split =explode(',',$d['answer'.$j]);
						for($ll = 0 ; $ll < count($split) ; $ll++){
							if($split[$ll]==$i){
								echo " on";
							}
						}?>"
						id="q<?=$j?>_<?=$i?>" >
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>
					<?}?>
					<input type="hidden" name="parent<?=$j?>" id="parent<?=$j?>" value="<?=$col['parent']?>">
					<input type="hidden" name="parent_val<?=$j?>" id="parent_val<?=$j?>" value="<?=$col['parent_val']?>">
					<input type="hidden" name="answers<?=$col['sid']?>" id="answers<?=$col['sid']?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer_necessary<?=$j?>" id="answer_necessary<?=$j?>" value="<?=$col['necessary']?>">
					<input type="hidden" name="answer_necessary_txt<?=$j?>" id="answer_necessary_txt<?=$j?>" value="<?=$col['necessary_txt']?>">
					<?$j++;?>

				</ul>
			</div>
			<?}?>

			<?if($col['type']=="14"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<dl class='feedbackItem'>
					<dd class="multi">
					<?for($i=1;$i<=$col['cnt'];$i++){?>
						
						<span class="changeBg2 inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)">
						<i class="fas fa-check"></i></span><label onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>,<?=$col['sid']?>)" for="q<?=$j?>_<?=$i?>"><?=$col['sub'.$i]?></label>
					<?}?>
					<input type="hidden" name="parent<?=$j?>" id="parent<?=$j?>" value="<?=$col['parent']?>">
					<input type="hidden" name="parent_val<?=$j?>" id="parent_val<?=$j?>" value="<?=$col['parent_val']?>">
					<input type="hidden" name="answers<?=$col['sid']?>" id="answers<?=$col['sid']?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer_necessary<?=$j?>" id="answer_necessary<?=$j?>" value="<?=$col['necessary']?>">
					<input type="hidden" name="answer_necessary_txt<?=$j?>" id="answer_necessary_txt<?=$j?>" value="<?=$col['necessary_txt']?>">
					<?$j++;?>
					</dd>
				</dl>
			</div>
			<?}?>


			<?if($col['type']=="21"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<dl class='feedbackItem'>
				<dd>
					<input type="hidden" name="parent<?=$j?>" id="parent<?=$j?>" value="<?=$col['parent']?>">
					<input type="hidden" name="parent_val<?=$j?>" id="parent_val<?=$j?>" value="<?=$col['parent_val']?>">
					<input type="hidden" name="answers<?=$col['sid']?>" id="answers<?=$col['sid']?>" value="<?=$d['answer'.$j]?>">
					<input type="hidden" name="answer_necessary<?=$j?>" id="answer_necessary<?=$j?>" value="<?=$col['necessary']?>">
					<input type="hidden" name="answer_necessary_txt<?=$j?>" id="answer_necessary_txt<?=$j?>" value="<?=$col['necessary_txt']?>">
					<select name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">

					<?for($i=1;$i<=$col['cnt'];$i++){?>

						<option <?if ($d['answer'.$j]==$i){?> selected<?}?> value="<?=$i?>"><?=$col['sub'.$i]?></option>

					<?}?>
					<?$j++;?>
					</select>
				</dd>
				</dl>
			</div>
			<?}?>

			<?if($col['type']=="31"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
			<dl class='feedbackItem'>
				<dd>
				<dl>
					<dd>
						<ul class="changeBg">

							<?for($i=1;$i<=5;$i++){?>

							<li><a id="q<?=$j?>_<?=$i?>" class="<?if ($d['answer'.$j]==$i){?> on<?}?>" onclick="chk_qu(<?=$j?>,<?=$i?>,'5',<?=$col['sid']?>)"><?=$i?></a></li>
							<?}?>
							<input type="hidden" name="parent<?=$j?>" id="parent<?=$j?>" value="<?=$col['parent']?>">
							<input type="hidden" name="parent_val<?=$j?>" id="parent_val<?=$j?>" value="<?=$col['parent_val']?>">
							<input type="hidden" name="answers<?=$col['sid']?>" id="answers<?=$col['sid']?>" value="<?=$d['answer'.$j]?>">
							<input type="hidden" name="answer_necessary<?=$j?>" id="answer_necessary<?=$j?>" value="<?=$col['necessary']?>">
							<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
							<input type="hidden" name="answer_necessary_txt<?=$j?>" id="answer_necessary_txt<?=$j?>" value="<?=$col['necessary_txt']?>">
							<?$j++;?>
						</ul>
					</dd>
				</dl>
				</dd>
			</dl>
			</div>
			<?}?>

			<?if($col['type']=="32"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
			<dl class='feedbackItem'>
				<dd>
				<dl>
					<dd>
						<ul class="changeBg">

						<?for($i=1;$i<=$col['cnt'];$i++){?>

							<li onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>,<?=$col['sid']?>)" style="width:<?=100/$col['cnt']?>%">
							
							<a id="q<?=$j?>_<?=$i?>" class="<?if ($d['answer'.$j]==$i){?> on<?}?>" ><i class="fas fa-check" style="line-height: 37px;padding-top:3px"></i></a>

							<label style="margin-top:5px" for=""><?=$col['sub'.$i]?></label>
							</li>


<!--
							<li onclick="chk_qu(<?=$j?>,<?=$i?>,<?=$col['cnt']?>)">
						<span class="changeBg inputR <?if ($d['answer'.$j]==$i){?> on<?}?>" id="q<?=$j?>_<?=$i?>" >
						<i class="fas fa-check"></i></span><label for=""><?=$col['sub'.$i]?></label>

-->

						<?}?>
						<input type="hidden" name="parent<?=$j?>" id="parent<?=$j?>" value="<?=$col['parent']?>">
						<input type="hidden" name="parent_val<?=$j?>" id="parent_val<?=$j?>" value="<?=$col['parent_val']?>">
						<input type="hidden" name="answers<?=$col['sid']?>" id="answers<?=$col['sid']?>" value="<?=$d['answer'.$j]?>">
						<input type="hidden" name="answer_necessary<?=$j?>" id="answer_necessary<?=$j?>" value="<?=$col['necessary']?>">
						<input type="hidden" name="answer<?=$j?>" id="answer<?=$j?>" value="<?=$d['answer'.$j]?>">
						<input type="hidden" name="answer_necessary_txt<?=$j?>" id="answer_necessary_txt<?=$j?>" value="<?=$col['necessary_txt']?>">
						<?$j++;?>
						</ul>
					</dd>
				</dl>
				</dd>
			</dl>
			</div>
			<?}?>

			<?if($col['type']=="41"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<p class="border"><textarea  name="memo<?=$q?>"  placeholder="내용을 입력해 주세요." id="memo<?=$q?>" cols="30" rows="10"><?=$d['memo'.$q]?></textarea></p>
				<?$q++;?>
			</div>
				
			<?}?>
			<?if($col['type']=="99"){?>
			</fieldset>
				<img src="/upload/feedback/<?=$col['image']?>" style="margin-top:-2px;">
				<fieldset style="border:1px solid <?=$css_col['feedback_bg']?>;">
			<?}?>

			<?if($col['type']=="999"){?>
			<div id="div_<?=$col['parent']?>_<?=$col['parent_val']?>" <?if($col['parent'] && $val_list[$col['parent']] != $col['parent_val']){?>style="display:none"<?}?>>
				<?=$col['val1']?>
			</div>
			<?}?>
		<?}?>
	</fieldset>
	<input type="hidden" name="answer_cnt" id="answer_cnt" value="<?=$j?>">



	<div class="btn fullBtn"><input type="submit" value="START" class="btnPoint"></div>
	</form>
	</div>
	
</div>

<script type="text/javascript">
	var feedback_alert2 = "<?php echo $string['feedback_alert2']?>";
jQuery(function($) {
	
	var feedback_alert1 = "<?php echo $string['feedback_alert1']?>";

	$(window).ready(function(){
	
		if ($("div#fixedTop2").length) {
			var re_pTop = $("div#fixedTop2").outerHeight();

			$("div.feedbackArea").css({
				"padding-top":re_pTop
				//"min-height":$(window).height() - re_pTop
			});
		}


	});

	$(window).resize(function(){
		//alert("1");
		if ($("div#fixedTop2").length) {
			var re_pTop = $("div#fixedTop2").outerHeight();

			$("div.feedbackArea").css({
				"padding-top":re_pTop
				//"min-height":$(window).height() - re_pTop
			});
		}

	});

	$('#researchF').submit(function() {
		//alert($("#code").val());
		if($("#all_chk").val()=="1"){
			for(i=1;i<=$("#answer_cnt").val();i++)
			{
				//alert(document.getElementById("answer"+i).value);
				if(!document.getElementById("answer"+i).value){
					alert(feedback_alert1);
					return false;
				}
			}
		}
		
		var chk_cnt=0;
		
		for(i=1;i<$("#answer_cnt").val();i++)
		{
			//alert(document.getElementById("answer"+i).value);
			if(document.getElementById("answer"+i).value){
				chk_cnt++;
				//alert(chk_cnt);
			}
			//alert(document.getElementById("answer_necessary"+i).value);
			if(!document.getElementById("answer"+i).value && document.getElementById("answer_necessary"+i).value=="Y"){
				//alert(document.getElementById("answer_necessary"+i).value);
				//alert(document.getElementById("answer"+i).value);
				
				
				if(document.getElementById("parent"+i).value>0){
	
					if(document.getElementById("answers"+document.getElementById("parent"+i).value).value==document.getElementById("parent_val"+i).value){
						alert(document.getElementById("answer_necessary_txt"+i).value);
						return false;
					}
				}else{
					alert(document.getElementById("answer_necessary_txt"+i).value);
					return false;
				}
				
				//alert(document.getElementById("answer_necessary_txt"+i).value);
				//return false;
			}

		}
		
		//alert(document.getElementById("min_chk").value);
		//alert(chk_cnt);
		if(document.getElementById("min_chk").value > chk_cnt){
			alert(document.getElementById("min_chk").value+"개 이상의 문항을 입력해주세요");
			return false;
		}


		
	});


});


	function chk_qu2(str,str2,str3,max){

		var jbSplit = document.getElementById("answer"+str).value.split(',');
		
		var chkj=0;
		var check=false;
		for (var j in jbSplit ) {
			if(jbSplit[j]==""){
				jbSplit.splice(j,1);
			}
			if(jbSplit[j]==str2){
				check=true;
				chkj = j;
			}
		}
		if(check==true){
			jbSplit.splice(chkj, 1);
			document.getElementById("q"+str+"_"+str2).classList.remove('on');
		}else{
			if(jbSplit.length<max){
				jbSplit.push(str2);
				document.getElementById("q"+str+"_"+str2).classList.add('on');
			}else{
				alert("최대"+max+"개까지만 선택이 가능합니다.");
			}
		}
		//alert(check);
		var value = "";
		for (var k in jbSplit ) {
			//alert(k);
			if(k>0){
				value += ",";
			}
			value += jbSplit[k];
			
		}
		document.getElementById("answer"+str).value=value;
	}



	function chk_qu(str,str2,str3,str4){

		if(document.getElementById("answer"+str).value==str2){
			document.getElementById("answer"+str).value="";
			document.getElementById("answers"+str4).value="";
			document.getElementById("q"+str+"_"+str2).classList.remove('on');

			for(i=1;i<=str3;i++){
				$("div#div_"+str4+"_"+i).css({"display":"none"});
				//document.getElementById("div_"+str4+"_"+i).style.display = 'none';
			}
		}else{
			for(i=1;i<=str3;i++){
				
				if(i==str2){
					document.getElementById("q"+str+"_"+i).classList.add('on');
					$("div#div_"+str4+"_"+i).css({"display":"block"});
				}else{
					document.getElementById("q"+str+"_"+i).classList.remove('on');
					$("div#div_"+str4+"_"+i).css({"display":"none"});
				}
			}

			document.getElementById("answer"+str).value=str2;
			document.getElementById("answers"+str4).value=str2;
			
		}
	}



</script>

