<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	
	$sch_tbl = "workshop_schedule_tbl";

	$_SE['content_position'] = array("left"=>"LEFT","center"=>"CENTER","right"=>"RIGHT");
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
?>
<style>
	*{padding:0;margin:0;}
	body {
		font: 300 15px Roboto, Calibri;
	}

	.content {
		margin:50px auto 0;
		width:300px;
	}

	h2 {
		margin-bottom:10px;
	}

	h3 {
		float:left;
		margin:20px 0 10px;
	}

	.btn{
		margin-top:20px;
		padding:6px 14px 6px;
		background:#1abc9c;
		color:#fff;
		border:none;
		border-radius:100px;
		font:400 14px Roboto;
		cursor:pointer;
	}
	.pk-field{width:80%;}

</style>
<link rel="stylesheet" href="/script/pickout/dev/pickout.css">
<link rel="stylesheet" href="/script/pickout/dev/themes/pk-cricket.css">
<SCRIPT LANGUAGE="javascript" SRC="/script/spectrum.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="/script/spectrum.css" />

<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("Program 등록");
		re_height = $('.popupCon').outerHeight()+168;
		re_width = $('.popupCon').outerWidth()+17;
		
		if(re_height>1000){
			window.resizeTo(re_width,1000);	
		}else{
			window.resizeTo(re_width,re_height);
		}

		$('#ev_date').on('change',function(){
			var ev_key = $(this).val();
			$.ajaxSetup({ cache: false });
			$.ajaxSetup({ async:false });
			$("#session_area").load("load_session_list.php?ev_key="+ev_key);
		});
	});
</script>
<script type="text/javascript" src="/func/tinymce_ver5/js/tinymce/tinymce.js"></script>
<script type="text/javascript" src="/script/tiny.js"></script>
<style>
.tblDef td{background:#ffffff;padding:5px 0px 5px 10px !important;margin:0px;}
.pk-modal{padding:0; margin:0;width:80%;}
.form-group {padding-right: 30px;}
.pk-option-group{color:#ffffff!important;font-size:16px;background:#9398A6;}
.pk-form{width:97%;}
</style> 

<?
	$query = "select * from ".$sch_tbl." where sid='$sid'";

	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>
<div class="popupCon" id="" style="width:1100px;height:700px;padding:20px;background:#fffff">
	<form name="session_tblF" id="session_tblF" method="post" action="post.php" enctype="multipart/form-data">
	<input type="hidden" name="sid" value="<?=$sid?>">
	<input type="hidden" name="code" id="code" value="<?=$code?>">
	<input type="hidden" name="kind" id="kind" value="<?=$kind?>">
	<input type="hidden" name="msid" id="msid" value="<?=$msid?>">
	<input type="hidden" name="ev_date" id="ev_date" value="<?=$d['bsid']?>">
	<input type="hidden" name="popup_yn" id="popup_yn" value="Y">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: 30%;">
			<col style="width: 20%;">
			<col style="width: 30%;">
		</colgroup>
		<tbody> 
			<tr>
				<th>일자</th>
				<td colspan=3 class="al">
					<?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['bsid']-1), $ex_sdate[0]));?>
				</td>
			</tr>
			<tr>
				<th>Session</th>
				<td class="al" colspan=3>
					<div class="pk-form">
						<select name="session_sid" id="session_sid" class="session_sid pickout" placeholder="세션을 선택해주세요" >
							<option value="">세션을 선택해주세요</option>
							<?
								$room_query = "select t1.sid,t1.title from workshop_session_category as t1 inner join workshop_session_tbl as t2 on t1.sid=t2.room  ";
								$room_query .= " where t2.ev_date='".$d['bsid']."' and t1.del='N' and t1.kind='P' group by t1.sid";
								$room_result=$conn->query($room_query);
								if(DB::isError($room_result)) die($room_result->getMessage());

								while(is_array($room=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
									$session_title = str_replace(" ","&nbsp;",$room['title']);

									$session_query = "select * from workshop_session_tbl where ev_date='".$d['bsid']."' and room='".$room['sid']."' and del='N' order by stime asc";
									//$session_query = "select if(t1.sid is null,t2.sid,t1.sid) as Fsid,t2.sid as Ssid,t2.stime,t2.etime,t2.part,t2.title as S_title,t1.* from workshop_session_detail_tbl as t1 right outer join workshop_session_tbl as t2 on t1.session_sid=t2.sid where t2.ev_date='".$d['bsid']."' and t2.room='".$room['sid']."' and t2.del='N' order by t2.stime asc, t1.sort_num asc";
							
									$session_result=$conn->query($session_query);
									if(DB::isError($session_result)) die($session_result->getMessage());
							?>
							<optgroup label="-&nbsp;<?=$session_title?>">
								<?
									while(is_array($session=$session_result->fetchRow(DB_FETCHMODE_ASSOC))){
								?>
								<option value="<?=$session['sid']?>" <?if($d['code2']==$session['sid']){?>selected<?}?>>
									<strong>[<?=$session['stime']?> ~ <?=$session['etime']?>]&nbsp;&nbsp;</strong>
									<?if($session['part']){?>[<?=stripslashes($session['part'])?>]&nbsp;&nbsp;<?}?>
									<?if($session['title']){?>
										<?=stripslashes($session['title'])?>
									<?}?>
									<?if($session['S_title']){?>
										<?=stripslashes($session['S_title'])?>
									<?}?>
									
									
								</option>
								<?}?>						
							</optgroup>

							<?}?>
						</select>
					</div>
				</td>
			</tr>
			
			<tr>
				<th>내용(상단)</th>
				<td colspan=3 class="al">

					<div class="dfree-body mce-content-body" contenteditable="true" style="position: relative;border:1px solid gray;height:100px;width:95%;" spellcheck="false"><?=stripslashes($d['content'])?></div>
					
				</td>
			</tr>
			<tr>
				<th>정렬</th>
				<td class="al">
					<?foreach($_SE['content_position'] as $tkey=>$tval){?>
						<input type="radio" name="content_position" id="content_<?=$tkey?>" value="<?=$tkey?>" <?if($d['content_position']==$tkey){?>checked<?}?>> <label for="content_<?=$tkey?>"><?=$tval?></label>
					<?}?>
				</td>
				<th>세로출력</th>
				<td class="al">
					<input type="radio" name="vertical_RL" id="vertical_RLY" <?if($d['vertical_RL']=="Y"){?>checked<?}?> value="Y" > <label for="vertical_RLY">Y</label>
					<input type="radio" name="vertical_RL" id="vertical_RLN" <?if($d['vertical_RL']=="N"){?>checked<?}?> value="N" > <label for="vertical_RLN">N</label>
				</td>
			</tr>
			<tr>
				<th>바탕색</th>
				<td class="al">
					<input type='text' id="bg_color" class="color_select"/>
					<input type="TEXT" style="width:100px;" class="bg_color" name="bg_color" value="<?=$d['bg_color']?>">
				</td>
				<th>글색상</th>
				<td class="al">
					<input type='text' id="font_color" class="color_select"/>
					<input type="TEXT" style="width:100px;" class="font_color" name="font_color" value="<?=$d['font_color']?>">
				</td>
			</tr>
			<tr>
				<th>가로넓이</th>
				<td class="al">
					<input type='text' id="w_size" name="w_size" style="width:50px;" class="OnlyNum" value="<?=$d['w_size']?>"/> px
				</td>
				<th>세로높이</th>
				<td class="al">
					<input type='text' id="h_size" name="h_size" style="width:50px;" class="OnlyNum" value="<?=$d['h_size']?>"/> px
				</td>
			</tr>
			<tr>
				<th>Bold</th>
				<td class="al">
					<input type="checkbox" name="bold" id="bold" value="Y" <?if($d['bold']=="Y"){?>checked<?}?>> <label for="bold">Bold</label>
				</td>
				<th>Italic</th>
				<td class="al">
					<input type="checkbox" name="italic" id="italic" value="Y" <?if($d['italic']=="Y"){?>checked<?}?>> <label for="italic">Italic</label>
				</td>
			</tr>
			<!-- <tr>
				<th>CheckBox 버튼사용</th>
				<td colspan=3>
					<input type="checkbox" name="radio" id="radio" value="Y" <?if($d['radio']=="Y"){?>checked<?}?>> <label for="radio">CheckBox (체크시 해당항목에 CheckBox가 활성화됩니다.)</label>
				</td>
			</tr>
			<tr class="radio_area" style="display:<?if($d['radio']!="Y"){?>none<?}?>;">
				<th>Class Name</th>
				<td colspan=3>
					<input type="text" name="class_name" id="class_name" value="<?=$d['class_name']?>" style="width:120px;">
					<div style="padding-top:5px;color:red;font-size:11px;line-height:130%;">* Checkbox를 사용시 클래스명을 같게 설정해주면 같은 클래스명 중 하나만 선택됩니다.<br />* 다른 Checkbox를 사용하는 항목과 중복허용을 하지 않을때만 지정해주세요.</div>
				</td>
			</tr> -->
			<tr>
				<th>Link</th>
				<td colspan=3 class="al">
					<input type='text' id="linkurl" name="linkurl" style="width:80%;" value="<?=$d['linkurl']?>"/>
					<div style="padding-top:5px;color:red;font-size:11px;line-height:130%;">* 링크 설정 시 해당 영역을 클릭하면 새창으로 연결됩니다.</div>
				</td>
			</tr>
			<tr>
				<th>파일</th>
				<td class="al" colspan="3">
					<div class="selectFile" style="float:left;">
						<p style="margin:0px;padding:0px;"><input name="" id="file_txt" value="선택" type="text" style="width:400px;height:30px;"  readonly></p>
						<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="program_file" id="program_file" onchange="document.getElementById('file_txt').value=this.value;" type="file" ></p>
					</div>
					<?if($d['program_file']){?>
						<div style="float:left;margin-top:5px;margin-left:10px;">
							<?=IconType2($d['program_file'])?>
							<span class="btnAdmin small lightBlue"><button type="button" id="fancyimg" href="/upload/program/<?=$d['program_file']?>" data-fancybox="gallery<?=rand(1,9999)?>" >보기</button></span>
							<input type="checkbox" name="program_filedel" id="program_filedel" value="Y"> <label for="program_filedel">삭제를 원하시는 경우 체크해주세요.</label>
							<!-- <span class="btnAdmin small red"><button type="button" class="company_filedel" kind="program_file">삭제</button></span> -->
						</div>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>TR(Class)</th>
				<td class="al">
					<input type='text' id="tr_class" name="tr_class" value="<?=$d['tr_class']?>" style="width:100px;" />
				</td>
				<th>TD(Class)</th>
				<td class="al">
					<input type='text' id="td_class" name="td_class" value="<?=$d['td_class']?>" style="width:100px;" />
				</td>
			</tr>
			<tr>
				<th>Border</th>
				<td class="al" colspan="3" style="font-size:17px;">
					<input type="checkbox" name="border_top" id="border_top" value="Y" <?if($d['border_top']=='Y'){?>checked<?}?>><label for="border_top">Top</label>
					<input type="checkbox" name="border_bottom" id="border_bottom" value="Y" <?if($d['border_bottom']=='Y'){?>checked<?}?>><label for="border_bottom">Bottom</label>
					<input type="checkbox" name="border_left" id="border_left" value="Y" <?if($d['border_left']=='Y'){?>checked<?}?>><label for="border_left">Left</label>
					<input type="checkbox" name="border_right" id="border_right" value="Y" <?if($d['border_right']=='Y'){?>checked<?}?>><label for="border_right">Right</label>
				</td>
			</tr>
			<?if($kind=="workshop" && $category=="F"){?>
			<tr>
				<th>세션 시간</th>
				<td colspan=3><input type="text" name="session_total_time" id="session_total_time" value="<?=$d['session_total_time']?>" style="width:80%;"></td>
			</tr>
			<tr>
				<th>좌장</th>
				<td colspan=3><input type="text" name="session_chair" id="session_chair" value="<?=$d['session_chair']?>" style="width:80%;"></td>
			</tr>
			
			<?}?>
		</tbody>
	</table>
	<div class="tp20 ac">
		<span class="btnAdmin large blue"><button type="submit">확인</button></span>
		<span class="btnAdmin large darkGray"><button type="button" onclick="self.close();">취소</button></span>
	</div>
</div>
<script>
	$(function(){
		var bg_color = "<?=$d['bg_color']?>";
		if(!bg_color) bg_color="#ffffff";

		var font_color = "<?=$d['font_color']?>";
		if(!font_color) font_color="#000000";
		
		$("#bg_color").spectrum({
			color: bg_color,
			showInput: true,
			className: "full-spectrum",
			showInitial: true,
			showPalette: true,
			showSelectionPalette: true,
			maxSelectionSize: 10,
			preferredFormat: "hex",
			localStorageKey: "spectrum.demo",
			move: function (color) {
				$("."+$(this).attr("id")).val(color.toHexString());
				
			},
			change: function(color) {
				$('.bg_color').val(color);
			},
			palette: [
				["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
				"rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
				["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
				"rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
				["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
				"rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
				"rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
				"rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
				"rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
				"rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
				"rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
				"rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
				"rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
				"rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
			]
		});

		$("#font_color").spectrum({
			color: font_color,
			showInput: true,
			className: "full-spectrum",
			showInitial: true,
			showPalette: true,
			showSelectionPalette: true,
			maxSelectionSize: 10,
			preferredFormat: "hex",
			localStorageKey: "spectrum.demo",
			move: function (color) {
				$("."+$(this).attr("id")).val(color.toHexString());
				//alert(color.toHexString())
				
			},
			change: function(color) {
				$('.font_color').val(color);
			},
			palette: [
				["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
				"rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
				["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
				"rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
				["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
				"rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
				"rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
				"rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
				"rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
				"rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
				"rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
				"rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
				"rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
				"rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
			]
		});

		//$('#program1').triggerHandler('change');
	});
</script>
<script src="/script/pickout.js"></script>
<script>
	// With Search
	pickout.to({
		el:'.pickout',
		search: true,
		theme: 'cricket',
		txtBtnMultiple: 'CONFIRMAR SELECIONADAS'
	});
	pickout.updated('.session_sid');
</script>