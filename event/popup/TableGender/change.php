<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	$sch_tbl = "workshop_schedule_tbl";

	$_SE['content_position'] = array("left"=>"LEFT","center"=>"CENTER","right"=>"RIGHT");
	
?>
<SCRIPT LANGUAGE="javascript" SRC="/script/spectrum.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="/script/spectrum.css" />
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("Program 일괄변경");
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
<div class="popupCon" id="" style="width:800px;padding:20px;background:#fffff">
	<form name="session_tblF" id="session_tblF" method="post" action="change_reg.php">
	<input type="hidden" name="chksid" id="chksid" value="<?=implode(",",$chk_sid)?>">
	<input type="hidden" name="ev_date" id="ev_date" value="<?=$ev_date?>">
	
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 15%;">
			<col style="width: 35%;">
			<col style="width: 15%;">
			<col style="width: 35%;">
		</colgroup>
		<tbody> 
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
					<input type="radio" name="bold" id="boldY" value="Y" > <label for="boldY">Y</label>
					<input type="radio" name="bold" id="boldN" value="N" > <label for="boldN">N</label>
				</td>
				<th>Italic</th>
				<td class="al">
					<input type="radio" name="italic" id="italicY" value="Y" > <label for="italicY">Y</label>
					<input type="radio" name="italic" id="italicN" value="N" > <label for="italicN">N</label>
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
					<input type="radio" name="vertical_RL" id="vertical_RLY" value="Y" > <label for="vertical_RLY">Y</label>
					<input type="radio" name="vertical_RL" id="vertical_RLN" value="N" > <label for="vertical_RLN">N</label>
					<span class="fcRed">(내용)</span>
				</td>
			</tr>
			<tr>
				<th>TR(Class)</th>
				<td class="al">
					<input type='text' id="tr_class" name="tr_class" style="width:100px;" />
				</td>
				<th>TD(Class)</th>
				<td class="al">
					<input type='text' id="td_class" name="td_class" style="width:100px;" />
				</td>
			</tr>
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