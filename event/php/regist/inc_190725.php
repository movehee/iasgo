<?
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
?>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="/autocomplete/lib/jquery-1.11.2.min.js"></script>

<script src="/autocomplete/dist/jquery.easy-autocomplete.min.js" type="text/javascript" ></script>
<link href="/autocomplete/dist/easy-autocomplete.min.css" rel="stylesheet" type="text/css">

<div>
	<?=$setting_col['regist_top_text']?>
</div>
<div class="registrWrap">
<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post"> 
	<table class="registList">	
		
		<input type="hidden" name="code" id="code" value="<?=$code?>" />
		<?if(!empty($sid)){?>
		<input type="hidden" name="sid" id="sid" value="<?=$sid?>" />
		<?}?>
		<?
		if($d['pre_regist']){
			$pre_regist_val = $d['pre_regist'];
		}else if($setting_col['pre_regist_sdate']<time() && $setting_col['pre_regist_edate']>time()){
			$pre_regist_val = "1";		
		}else{
			$pre_regist_val = "2";
		}

		?>
		
		<tr <?if(!$isadmin){?>style="display:none"<?}?>>
			<th class="regist_th">사전여부</th>
			<td class="regist_td"><select name="pre_regist_val" id="pre_regist_val" >
				<option<?=$pre_regist_val=="1"?' selected="true"':''?> value="1">사전등록</option>
				<option<?=$pre_regist_val=="2"?' selected="true"':''?> value="2">현장등록</option>
			</select>
			</td>
		</tr>

		<?while(is_array($regist_d = mysqli_fetch_array($regist_result))){
		$cnt++;
		?>

		<?
		if($regist_d['parent'] && !$isadmin){?>
			<input type="hidden" name="parent_<?=$regist_d['parent']?>" id="parent_<?=$regist_d['sid']?>" value="<?=$regist_d['parent_val']?>" />	
		
		<?
			if(strpos($regist_d['parent_val'].",", $d['info'.$regist_d['parent']].",") !== false){
				$style_txt="display:none;";
			}else{
				if($d['info'.$regist_d['parent']]){
					$style_txt="";
				}else{
					$style_txt="display:none;";
				}
			}
		}else{
			$style_txt="";
		}
		if($regist_d['countrychk']=="3" && !$isadmin){
			$style_txt="display:none;";
		}?>

		
				
		<tr class="parent_<?=$regist_d['parent']?>_<?=$regist_d['sid']?>" id="<?if($regist_d['countrychk']=="1"){?>kor<?}else if($regist_d['countrychk']=="2"){?>eng<?}else if($regist_d['countrychk']=="3"){?>count_sel<?}?>" style="<?=$style_txt?>" <?if($regist_d['parent']){?>class="parent<?=$regist_d['parent']?> <?=$regist_d['parent_val']?>"<?}?>>
			<th class="regist_th"><?=$regist_d['info']?><?if($regist_d['necessary']=="Y"){?> <span class="necessary">*</span><?}?></th>
			<td class="regist_td <?if($regist_d['type']=="30"){?>small<?}?>">
				
				<?
				$readonly="";
				if($setting_col['reg_money']==$regist_d['sid'] && !$isadmin){
					$readonly="readonly"; 
				?><input type="hidden" name="money_info" id="money_info" value="<?=$regist_d['info_orderby']?>" /><?
				}?>

				<?
				$onchangechk = false;
				if($setting_col['regist_money_type1']==$regist_d['type']){
					$onchangechk = true; 
				?><input type="hidden" name="money_type1" id="money_type1" value="<?=$regist_d['info_orderby']?>" /><?
				}

				if($setting_col['regist_money_type2']==$regist_d['type']){
					$onchangechk = true; 
				?><input type="hidden" name="money_type2" id="money_type2" value="<?=$regist_d['info_orderby']?>" /><?
				}

				if($setting_col['regist_money_type3']==$regist_d['type']){
					$onchangechk = true; 
				?><input type="hidden" name="money_type3" id="money_type3" value="<?=$regist_d['info_orderby']?>" /><?
				}?>


				
				<?if($regist_d['type']=="10"){?>
					<!--기본-->
					<input <?=$readonly?> class="textW50" type="text" name="val_<?=$regist_d['info_orderby']?>" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$d['info'.$regist_d['info_orderby']]?>">
				<?}else if($regist_d['type']=="20"){?>
					<!--긴거-->
					<input <?=$readonly?> class="textW100"  type="text" name="val_<?=$regist_d['info_orderby']?>" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$d['info'.$regist_d['info_orderby']]?>" />
				<?}else if($regist_d['type']=="30"){?>
					<!--짧은거-->
					<input <?=$readonly?> class="textW30" type="text" name="val_<?=$regist_d['info_orderby']?>" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$d['info'.$regist_d['info_orderby']]?>" />
				<?}else if($regist_d['type']=="40"){?>
					<!--E-mail-->
				<?
					$email_array=null;
					if($d['info'.$regist_d['info_orderby']]){
						$email_array = split("@",$d['info'.$regist_d['info_orderby']]);
					}
				?>
					<input class="email" type="text" name="val_<?=$regist_d['info_orderby']?>[0]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$email_array['0']?>" />@
					<input class="email" type="text" name="val_<?=$regist_d['info_orderby']?>[1]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$email_array['1']?>" />
			
				<?}else if($regist_d['type']=="50"){?>
					<!--Phone-->

				<?
					$phone_array=null;
					if($d['info'.$regist_d['info_orderby']]){
						$phone_array = split("-",$d['info'.$regist_d['info_orderby']]);
					}
				?>
				
				<input class="phone" type="text" name="val_<?=$regist_d['info_orderby']?>[0]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$phone_array['0']?>" />-
				<input class="phone" type="text" name="val_<?=$regist_d['info_orderby']?>[1]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$phone_array['1']?>" />-
				<input class="phone" type="text" name="val_<?=$regist_d['info_orderby']?>[2]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$phone_array['2']?>" />

				<?}else if($regist_d['type']=="60"){?>
					<!--Mobile-->
				<?
					$phone_array=null;
					if($d['info'.$regist_d['info_orderby']]){
						$phone_array = split("-",$d['info'.$regist_d['info_orderby']]);
					}
				?>
					<input class="phone" type="text" name="val_<?=$regist_d['info_orderby']?>[0]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$phone_array['0']?>" />-
					<input class="phone" type="text" name="val_<?=$regist_d['info_orderby']?>[1]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$phone_array['1']?>" />-
					<input class="phone" type="text" name="val_<?=$regist_d['info_orderby']?>[2]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$phone_array['2']?>" />
				<?}else if($regist_d['type']=="70"){?>
					<!--ID-->
					<input  class="idW30" type="text" name="val_<?=$regist_d['info_orderby']?>" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$d['info'.$regist_d['info_orderby']]?>" />
				<?}else if($regist_d['type']=="80"){?>
					<!--Password-->
					<input class="passW30" type="password" name="val_<?=$regist_d['info_orderby']?>" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$d['info'.$regist_d['info_orderby']]?>" />
				<?}else if($regist_d['type']=="90"){?>
				<!--country-->
					<select class="selectW40" name="val_<?=$regist_d['info_orderby']?>" id="val_<?=$regist_d['info_orderby']?>" onchange="country_change(this)">
					<?
					$country_query="SELECT * FROM country_tbl order by orderby asc, name asc";
					$country_result = mysqli_query($conn, $country_query);	?>
					<option value="">Select</option>
					<?
					while(is_array($country_d = mysqli_fetch_array($country_result))){?>

						<option <?if($d['info'.$regist_d['info_orderby']]==$country_d['sid']){?>selected<?}?> value="<?=$country_d['sid']?>"><?=$country_d['name']?></option>
					<?}
					?>
					</select>
				<?}else if($regist_d['type']=="100"){?>
				<!--country-->
					<textarea name="val_<?=$regist_d['info_orderby']?>" id="val_<?=$regist_d['info_orderby']?>"><?=$d['info'.$regist_d['info_orderby']]?></textarea>
				<?}else if($regist_d['type']=="110"){

					$temp=null;
					if($d['info'.$regist_d['info_orderby']]){
						$temp = split("&&",$d['info'.$regist_d['info_orderby']]);
					}?>


					<input  class="idW30" type="text" name="val_<?=$regist_d['info_orderby']?>[0]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$temp['0']?>" />
					<span class='btn overlap' onclick="javascript:openDaumPostcode_office('<?=$regist_d['info_orderby']?>')">우편번호 검색</span>
					<input style="margin-top:10px" class="textW100"  type="text" name="val_<?=$regist_d['info_orderby']?>[1]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$temp['1']?>" />
					<input style="margin-top:10px" class="textW100"  type="text" name="val_<?=$regist_d['info_orderby']?>[2]" id="val_<?=$regist_d['info_orderby']?>"  value="<?=$temp['2']?>" />

					<div id="map_layer<?=$regist_d['info_orderby']?>" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
					<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode('<?=$regist_d['info_orderby']?>')" alt="닫기 버튼">
					</div>


				<?} else{?>
				<?
					$type_query="SELECT * FROM regist_type_tbl where sid='".$regist_d['type']."' and del='N'";
					$type_result = mysqli_query($conn, $type_query);
					$type_d = mysqli_fetch_array($type_result);
					$val_type = $type_d['val_type'];

					$type_query = "SELECT * FROM regist_type_sub_tbl where type_sid='".$regist_d['type']."' and del='N'";
					if($pre_regist_val=="1" && !$isadmin){
						$type_query .= " and pre_chk in ('1','2')";
					}else if($pre_regist_val=="2" && !$isadmin){
						$type_query .= " and pre_chk in ('1','3')";
					}
					$type_query .= " order by orderby asc";
					//echo $type_query;
					$type_result = mysqli_query($conn, $type_query);
					if($val_type=="3"){?>
						<select <?if($onchangechk){?>onchange="money_change('<?=$regist_d['info_orderby']?>')"<?}?> class="selectW<?=$type_d['val_type_class']?>" name="val_<?=$regist_d['info_orderby']?>" id="val_<?=$regist_d['info_orderby']?>">
						<option value="">Select</option>
					<?}?>
					<?$k=0;?>
					<?
					if(!$d['info'.$regist_d['info_orderby']]){
						$d['info'.$regist_d['info_orderby']] = $type_d['def_val'];
					}
					?>

					<?while(is_array($type_d = mysqli_fetch_array($type_result))){
						
					?>

					<?if($val_type=="1"){?>
					
						<input id="<?if($type_d['countrychk']=="1"){?>kor<?}else if($type_d['countrychk']=="2"){?>eng<?}?>" <?if($onchangechk){?>onchange="money_change('<?=$regist_d['info_orderby']?>')"<?}?> <?if($d['info'.$regist_d['info_orderby']]==$type_d['sid']){?>checked<?}?>  type='radio' name='val_<?=$regist_d['info_orderby']?>' value="<?=$type_d['sid']?>"/><span  id="<?if($type_d['countrychk']=="1"){?>kor<?}else if($type_d['countrychk']=="2"){?>eng<?}?>"><?=$type_d['info']?></span>
					<?}else if($val_type=="2"){
						$temp = split(",",$d['info'.$regist_d['info_orderby']]);

					?>
						
						<input id="<?if($type_d['countrychk']=="1"){?>kor<?}else if($type_d['countrychk']=="2"){?>eng<?}?>"  <?if($onchangechk){?>onchange="money_change('<?=$regist_d['info_orderby']?>')"<?}?> type='checkbox' name='val_<?=$regist_d['info_orderby']?>[]' value="<?=$type_d['sid']?>"  <?

						for($kk=0;$kk<count($temp);$kk++){
							if($temp[$kk]==$type_d['sid']){
								echo "checked";
							}
						}
						
					
						?>/><span  id="<?if($type_d['countrychk']=="1"){?>kor<?}else if($type_d['countrychk']=="2"){?>eng<?}?>"><?=$type_d['info']?></span>
					<?}else if($val_type=="3"){?>
						<option id="<?if($type_d['countrychk']=="1"){?>kor<?}else if($type_d['countrychk']=="2"){?>eng<?}?>"  <?if($d['info'.$regist_d['info_orderby']]==$type_d['sid']){?>selected<?}?> value="<?=$type_d['sid']?>"><?=$type_d['info']?></option>
					<?}
					$k++;
					}?>
					<?if($val_type=="3"){?>
						</select>
					<?}?>
				<?}?>
				<?if($regist_d['overlapchk']=="Y"){?>
					<span class='btn overlap' onclick="javascript:overlapchk('<?=$regist_d['info_orderby']?>','<?=$sid?>')">중복체크</span>
				<?}?>

				<input type="hidden" name="overlap_<?=$regist_d['info_orderby']?>" id="overlap_<?=$regist_d['info_orderby']?>"  value="<?=$regist_d['overlapchk']?>">

				<input type="hidden" name="overlapchk_<?=$regist_d['info_orderby']?>" id="overlapchk_<?=$regist_d['info_orderby']?>"  value="N">

				<input type="hidden" name="necessary_<?=$regist_d['info_orderby']?>" id="necessary_<?=$regist_d['info_orderby']?>"  value="<?=$regist_d['necessary']?>">
				<input type="hidden" name="type_<?=$regist_d['info_orderby']?>" id="type_<?=$regist_d['info_orderby']?>"  value="<?=$regist_d['type']?>">
				
				<?if($regist_d['memo']){?>
					<br><span class="inputMemo"><?=$regist_d['memo']?></span>
				<?}?>


				<?if($setting_col['reg_office']==$regist_d['sid']){?>
					<input type="hidden" onchange="javascript:reg_office_change(<?=$regist_d['info_orderby']?>)" name="reg_office" id="reg_office" value="<?=$regist_d['info_orderby']?>" />
					

				<?}else if($setting_col['reg_office_en']==$regist_d['sid']){?>
					<input type="hidden" name="reg_office_en" id="reg_office_en" value="<?=$regist_d['info_orderby']?>" />
				<?}else if($setting_col['reg_office_post']==$regist_d['sid']){?>
					<input type="hidden" name="reg_office_post" id="reg_office_post" value="<?=$regist_d['info_orderby']?>" />
				<?}?>


			</td>
		</tr>
		<?}?>

		<tr <?if(!$isadmin){?>style="display:none"<?}?>>
			<th class="regist_th">Memo</th>
			<td class="regist_td">
			<textarea name="memo" id="memo"><?=$d['memo']?></textarea>
			</td>
		</tr>
	
		<input type="hidden" name="regist_cnt" id="regist_cnt" value="<?=$cnt?>" />	
		
	</table>
	<div class="btn fullBtn" style="width:50%; margin:0 auto;">
		<input type="submit" value="등록" class="btnPoint" style="height: 50px; font-size: 17px;font-weight: bold;">
	</div>
	</form>
</div>
<script>
	var office_sid;

    function closeDaumPostcode(sid) {
        // iframe을 넣은 element를 안보이게 한다.

		var element_layer = document.getElementById('map_layer'+sid);
        element_layer.style.display = 'none';
    }

    function openDaumPostcode_office(sid) {
		var element_layer = document.getElementById('map_layer'+sid);
		office_sid = sid;
        new daum.Postcode({
            oncomplete: function(data) {
               if(data.buildingName!=""){
					bulid = "("+data.buildingName+")";
				}else{
					bulid = "";
				}

				var fullAddr = ''; // 최종 주소 변수
				var extraAddr = ''; // 조합형 주소 변수

				// 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
				if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
					fullAddr = data.roadAddress;

				} else { // 사용자가 지번 주소를 선택했을 경우(J)
					fullAddr = data.jibunAddress;
				}

				// 사용자가 선택한 주소가 도로명 타입일때 조합한다.
				if(data.userSelectedType === 'R'){
					//법정동명이 있을 경우 추가한다.
					if(data.bname !== ''){
						extraAddr += data.bname;
					}
					// 건물명이 있을 경우 추가한다.
					if(data.buildingName !== ''){
						extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
					}
					// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
					fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');

				}
				$("input[name='val_"+office_sid+"[0]']").val(data.zonecode);
				$("input[name='val_"+office_sid+"[1]']").val(fullAddr);
				document.getElementById('map_layer'+office_sid).style.display = 'none';
            },
            width : '100%',
            height : '100%',
            maxSuggestItems : 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

		var width = 900; //우편번호서비스가 들어갈 element의 width
        var height = 800; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 5; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';

    }


	var options = {
		url: "/affiliation.json",
		getValue: "label",

		list: {
			match: {
			  enabled: true
			},
			onClickEvent: function() {
				if(document.getElementById("reg_office_en")){
					var value = $("#val_"+document.getElementById('reg_office').value).getSelectedItemData().value;
					$("#val_"+document.getElementById('reg_office_en').value).val(value);
				}
				
				var zipcode = $("#val_"+document.getElementById('reg_office').value).getSelectedItemData().zipcode;
				$("input[name='val_"+document.getElementById('reg_office_post').value+"[0]']").val(zipcode);

				var addr = $("#val_"+document.getElementById('reg_office').value).getSelectedItemData().addr;
				$("input[name='val_"+document.getElementById('reg_office_post').value+"[1]']").val(addr);

			},
			onSelectItemEvent: function() {

				if(document.getElementById("reg_office_en")){
					var value = $("#val_"+document.getElementById('reg_office').value).getSelectedItemData().value;
					$("#val_"+document.getElementById('reg_office_en').value).val(value);
				}
				
				var zipcode = $("#val_"+document.getElementById('reg_office').value).getSelectedItemData().zipcode;
				$("input[name='val_"+document.getElementById('reg_office_post').value+"[0]']").val(zipcode);

				var addr = $("#val_"+document.getElementById('reg_office').value).getSelectedItemData().addr;
				$("input[name='val_"+document.getElementById('reg_office_post').value+"[1]']").val(addr);

			}

		}
	};



	$("#val_"+document.getElementById('reg_office').value).easyAutocomplete(options);
	


	
	

</script>