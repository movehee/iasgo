<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,1100);
	});
</script>
<style>
div.selectFile {overflow:hidden;padding-right:10px;padding-left:10px;}
div.selectFile p {float:left;}
div.selectFile p input[type=text] {height: 23px;padding:2px 10px 3px;}
div.selectFile p.withIcon {position: relative;width:66px;height:30px;background-color:#393939;color: #fff;text-align: center;}
div.selectFile p.withIcon i {position: absolute;left: 50%;top: 50%;font-size: 1em;margin: -0.5em 0 0 -0.5em;color:#ffffff;}
div.selectFile p.withIcon input {position: absolute;left: 0;top: 0;width:100%;height:100%;padding: 0;border: 0 none;}
#product {
	counter-reset: rowNumber;
}
.numberic:after {
	counter-increment: rowNumber;
	content: counter(rowNumber);
}

</style>

<script>
function add_conference(sid,kind){
	$.ajaxSetup({ cache: false });
	$.ajaxSetup({ async:false });
	$.get( "/popup/booth/add.php?kind="+kind+"&sid="+sid, function( data ) {
		$("#product").append( data );
	});
	
}

</script>
<?
	$query = "select * from booth where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$booth_query = "select * from booth_grade where sid='$d[booth_sid]'";
	$booth_result = $conn->query($booth_query);
	if(DB::isError($booth_result)) {
	  die($booth_result->getMessage());
	}
	$booth_result->fetchInto(&$booth,DB_FETCHMODE_ASSOC);
	$booth_result->free();

	
	if($booth['b_type']=='A'){

		$filename_arr = array("booth_file","booth_ground_file","logo_file","front_file1","front_file2","front_file3","front_file4","stamp_file");
		$img_sample_arr = array("booth_sample.png","booth_ground.png","logo_sample.png","poster_left_sample.png","vod_sample.png","poster_right_sample.png","banner_sample.png","stamp.png");

		//$filename_arr = array("booth_file","stamp_file","booth_bottom_file");
		//$img_sample_arr = array("booth_sample4.png","stamp.png","stamp.png");

	}else if($booth['b_type']=='B'){
		$filename_arr = array("booth_file","stamp_file");
		$img_sample_arr = array("booth_sample2.png","stamp.png");	
	}else if($booth['b_type']=='C'){
		$filename_arr = array("booth_file","stamp_file","booth_bottom_file");
		$img_sample_arr = array("booth_sample4.png","stamp.png","stamp.png");
	}
	
	//$filename_arr = array("booth_file","stamp_file","booth_bottom_file");
	//$img_sample_arr = array("booth_sample4.png","stamp.png","stamp.png");


	$booth_title = "[".$booth['title']."] ".$d['title']." - " .$_Booth['type'][$booth['b_type']];
	
	
?>
<script>
	$(function(){
		$('#Popup_Title').html("<?=$booth_title?>");
		
	});
</script>
<SCRIPT LANGUAGE="javascript" SRC="/script/spectrum.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="/script/spectrum.css" />
<div class="popupCon" id="" style="width:1000px;padding:20px;background:#ffffff;">

<?if($booth['b_type']=='A'){?>
<div class="fcRed">※ Type이 부스형일 경우에만 사용가능합니다.</div>
<form name="colorF" id="colorF" method="post" action="booth_color.php">
<input type="hidden" name="sid" value="<?=$d['sid']?>">
<table class="tblDef tblList" style="width:100%;">
	<colgroup>
		<col style="width: 15%;">
		<col style="width: ;">
		<col style="width: 15%;">
		<col style="width: ;">
	</colgroup>
	<tbody>
		<tr>
			<th>좌측 메뉴바탕 색상</th>
			<td class="al">
				<input type='text' id="bg_color" class="color_select"/>
				<input type="TEXT" style="width:100px;" class="bg_color" name="bg_color" value="<?=$d['bg_color']?>">
			</td>
			<th>좌측 메뉴글씨 색상</th>
			<td class="al">
				<input type='text' id="font_color" class="color_select"/>
				<input type="TEXT" style="width:100px;" class="font_color" name="font_color" value="<?=$d['font_color']?>">

				
			</td>
		</tr>
	</tbody>
	
</table>
<div class="ac tp10"><span class="rBtnAdmin large navy"><button type="submit" onclick="">저장</button></span></div>
</form>
<br />
<?}?>


<form method="post" name="brocF" id="brocF" action="company_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="booth_sid" id="booth_sid" value="<?=$sid?>"/>
<input type="hidden" name="file_upload" id="file_upload" value="N">
	<table class="tblDef tblList sort_table" style="width:100%;">
		<colgroup>
			<col style="width: 7%;">
			<col style="width: ;">
			<col style="width: 11%;">
			<col style="width: 12%;">
			<col style="width: 5%;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>종류</th>
				<th>샘플</th>
				<th>이미지</th>
				<th>삭제</th>
			</tr>
		</thead>
		<tbody id="product">
			<?foreach($filename_arr as $tkey=>$tval){?>
			<tr>
				<td style="padding:0px !important;height:80px;"><span class="numberic"></span></td>
				<td class="al" >
					<?if($tval=='logo_file'){?>
						로고 이미지
					<?}else if($tval=='booth_file'){?>
						부스 대표 이미지 파일 (메인 노출이미지) <br><span class="fcRed">(부스형에 따라 이미지가 다릅니다. 샘플을 잘 보시기 바랍니다.)</span>
					<?}else if($tval=='front_file1'){?>
						좌측 포스터 이미지
					<?}else if($tval=='front_file2'){?>
						영상
					<?}else if($tval=='front_file3'){?>
						우측 포스터 이미지
					<?}else if($tval=='front_file4'){?>
						x배너 이미지
					<?}else if($tval=='booth_ground_file'){?>
						부스 배경이미지
					<?}else if($tval=='stamp_file'){?>
						부스 Stamp
					<?}else if($tval=='booth_bottom_file'){?>
						강의장 하단파일
					<?}?>
				</td>
				<td style="padding:0px !important;cursor:default;"><a id="fancyimg" href="/image/sample/<?=$img_sample_arr[$tkey]?>" data-fancybox="gallery" data-caption=""><img src="/image/sample/<?=$img_sample_arr[$tkey]?>" width=50></a></td>
				<td style="padding:0px !important;cursor:default;">
					<?
						$Fname = $tval."_".$d['sid'];
						$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/booth/" . $d[$tval]) . "&filename=" . base64_encode($d[$tval]);
					?>
					<div class="selectFile" id="<?=$Fname?>_Area" style="display:<?if($d[$tval]){?>none<?}?>;">
						<p><input name="" id="<?=$Fname?>_txt" value="Select File" type="text" style="width:0px;display:none;"  readonly></p>
						<p class="withIcon"><i class="fas fa-search"></i><input class="opacity0" name="<?=$Fname?>" id="<?=$Fname?>" onchange="document.getElementById('<?=$Fname?>_txt').value=this.value;file_upload_ajax(<?=$d['sid']?>,'<?=$Fname?>','<?=$tval?>')" type="file" ></p>
					</div>
					<div id="<?=$Fname?>_list">
						<?if($d[$tval]){?>
						<div class="f_<?=$d['sid']?>">
							<span class="btnAdmin small blue"><button type="button" id="fancyimg" href="/upload/booth/<?=$d[$tval]?>" data-fancybox="gallery<?=rand(1,9999)?>" data-caption="">미리보기</button></span>

							<img src="<?=IconType3($d[$tval])?>" onclick="location.href='/func/download.php?<?=$queryString?>'" class="hand" width=20 height=20>
						</div>
						<?}?>
					</div>
				</td>
				<td><img src="/image/icon/icon_del.png" onclick="common_delete_file('<?=$d['sid']?>','booth_image','<?=$tval?>')"></td>
			</tr>
			<?}?>
		</tbody>
	</table>
	
	<div class="btnArea btn">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
<iframe name="hiddenfrm" id="hiddenfrm"  style="width:500px;height:300px;border:1px solid red;display:none;"></iframe>
</div>
<??>
<?if($booth['b_type']=='A'){?>
<script>
	$(function(){
		var bg_color = "<?=$d['bg_color']?>";
		if(!bg_color) bg_color="#272B4B";

		var font_color = "<?=$d['font_color']?>";
		if(!font_color) font_color="#ffffff";
		
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
<?}?>