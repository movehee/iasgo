<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	
	$sch_tbl = "workshop_session_detail_tbl";

	if($_POST['mode']=="save"){
		
		if($filedel=='Y'){
			$file_query = ", abs_file=''";
		}
		if($_FILES['abs_file']['name']){
			$ext = explode(".",$_FILES['abs_file']['name']);
			$len = sizeof($ext)-1;
			$extension = $ext[$len];

			$filename = "abs_".time() . "." . $extension;
			$realfilename = $_FILES['abs_file']['name'];
			
			if($_SERVER['REMOTE_ADDR']!="112.76.194.32"){
				if(floor(filesize($_FILES['abs_file']['tmp_name'])/1024)>10240){
					PutMessageBack("업로드 용량을 초과하였습니다. 10MB 이하로 올려주세요");
					exit;
				}
			}
			if(!copy($_FILES['abs_file']['tmp_name'],$_SERVER['DOCUMENT_ROOT'] . "upload/session/" . $filename)){
				PutMessageBack("업로드가 정상적으로 되지 않았습니다.");
				exit;
			}

			$file_query = ", abs_file='$filename'";
		}
		if($filedel2=='Y'){
			$file_query2 = ", cv_file=''";
		}
		if($_FILES['cv_file']['name']){
			$ext = explode(".",$_FILES['cv_file']['name']);
			$len = sizeof($ext)-1;
			$extension = $ext[$len];

			$filename = "cv_".time() . "." . $extension;
			$realfilename = $_FILES['cv_file']['name'];
			
			if($_SERVER['REMOTE_ADDR']!="112.76.194.32"){
				if(floor(filesize($_FILES['cv_file']['tmp_name'])/1024)>10240){
					PutMessageBack("업로드 용량을 초과하였습니다. 10MB 이하로 올려주세요");
					exit;
				}
			}
			if(!copy($_FILES['cv_file']['tmp_name'],$_SERVER['DOCUMENT_ROOT'] . "upload/session/" . $filename)){
				PutMessageBack("업로드가 정상적으로 되지 않았습니다.");
				exit;
			}

			$file_query2 = ", cv_file='$filename'";
		}

		$plan_intent = $_POST['mce_0'];
		
		$common_query = " pt_time='$pt_time'";
		$common_query .= ", code='$code'";
		$common_query .= ", title='".addslashes($title)."'";
		$common_query .= ", author='$author'";
		$common_query .= ", author_position='".addslashes($author_position)."'";
		$common_query .= ", author_co='$author_co'";
		$common_query .= ", author_position_co='".addslashes($author_position_co)."'";
		$common_query .= ", plan_intent='$plan_intent'";
		$common_query .= ", linkurl='$linkurl'";
		$common_query .= ", country='$country'";
		$common_query .= ", bg_color='$bg_color'";
		$common_query .= ", font_color='$font_color'";
		$common_query .= ", pre_num='$pre_num'";
		$common_query .= ", abs_num='$abs_num'";
		$common_query .= ", detail_time='$detail_time'";
		$common_query .= ", time_skip='$time_skip'";
		$common_query .= ", author2='$author2'";
		$common_query .= ", author3='$author3'";
		$common_query .= ", author4='$author4'";
		$common_query .= ", country2='$country2'";
		$common_query .= ", country3='$country3'";
		$common_query .= ", country4='$country4'";
		$common_query .= ", author_code='$author_code'";
		$common_query .= ", author_code2='$author_code2'";
		$common_query .= ", author_code3='$author_code3'";
		$common_query .= ", author_code4='$author_code4'";
		$common_query .= $file_query;
		$common_query .= $file_query2;

		if(!$sid){
			$sort_num = 1;
			$max_sid = $conn->getOne("select max(sort_num) from ". $sch_tbl. " where session_sid='$session_sid'");
			if($max_sid){
				$sort_num = ($max_sid)+1;
			}

			$query = "insert into ". $sch_tbl. " set " .$common_query;
			$query .= ", session_sid='$session_sid'";
			$query .= ", sort_num='$sort_num'";
			$result = $conn->query($query);
			
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}else{
			$query = "update ".$sch_tbl." set " .$common_query;
			$query .= " where sid='$sid'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}
		
		$session_stime = $conn->getOne("select stime from workshop_session_tbl where sid='$session_sid'");

		$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$session_sid."' and del='N' and IFNULL(time_skip,'')='' order by sort_num asc";
		$detail_query .= $sort_sql;
		$detail_result=$conn->query($detail_query);
		if(DB::isError($detail_result)) die($detail_result->getMessage());
		while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))){
			if($detail['pt_time'] && $detail['time_skip']!='Y'){
				$ex_pt = explode("/",$detail['pt_time']);
				$pt_total_time = $ex_pt[0]+$ex_pt[1];
				$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($session_stime)));
				
				$time_query = "update workshop_session_detail_tbl set detail_time='".date("H:i",strtotime($session_stime))."-".$set_start."' where sid='".$detail['sid']."'";
				$time_result = $conn->query($time_query);
				if(DB::isError($time_result)) {
					die($time_result->getMessage());
				}
				$session_stime = $set_start;
			}
		}

		PutMessageCloseOpenerReload("저장되었습니다.");
		exit;
	}
	
	$ev_query = "select * from workshop_manager";
	$ev_result = $conn->query($ev_query);
	$ev_result->fetchInto(&$ev,DB_FETCHMODE_ASSOC);
	$ev_result->free();

	if($ev['edate']){
		$chkdate = strtotime($ev['edate'])-strtotime($ev['sdate']);
		$date_count = date("d",$chkdate);
	}else{
		$date_count = 1;	
	}
	$ex_sdate_arr = explode(" ",$ev['sdate']);
	$ex_sdate = explode("-",$ex_sdate_arr[0]);
	
	if(!$ev_date) $ev_date="0";
	
?>
<script type="text/javascript" src="/func/tinymce_ver5/js/tinymce/tinymce.js"></script>
<script type="text/javascript" src="/script/tiny.js"></script>
<SCRIPT LANGUAGE="javascript" SRC="/script/spectrum.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="/script/spectrum.css" />
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('Session Detail');
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
		$('#time_skip').on('click',function(){
			if($('#time_skip').is(':checked')==true){
				$('#pt_time').attr('disabled',true);
				$('#pt_time').val("");
			}else{
				$('#pt_time').attr('disabled',false);
			}
		});
	});
</script>
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


	if($d['session_sid']){
		$session_sid = $d['session_sid'];
	}

?>
<div class="popupCon" id="" style="width:1000px;padding:20px;background:#fffff">
	<form name="session_DeF" id="session_DeF" method="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data">
	<input type="hidden" name="sid" value="<?=$sid?>">
	<input type="hidden" name="session_sid" value="<?=$session_sid?>">
	<input type="hidden" name="sort_num" value="<?=$d['sort_num']?>">
	<input type="hidden" name="mode" value="save">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 12%;">
			<col style="width: 38%;">
			<col style="width: 12%;">
			<col style="width: 38%;">
		</colgroup>
		<tbody> 
			<tr>
				<th>Time Skip</th>
				<td class="al" colspan=3>
					<input type="checkbox" name="time_skip" id="time_skip" value="Y" <?if($d['time_skip']=='Y'){?>checked<?}?> style="width:20px;height:20px;">
					<label for="time_skip" class="fcRed">선택하시는 경우 시간이 계산되지 않습니다.</label>
				</td>
			</tr>
			<tr>
				<th>시간</th>
				<td class="al" colspan=3>
					<input type="text" name="detail_time" id="detail_time" value="<?=$d['detail_time']?>" style="width:120px;">
					<label class="fcRed">Time Skip 하였을때만 나타나는 시간표기입니다.</label>
				</td>
			</tr>
			<tr>
				<th>발표시간</th>
				<td class="al"><input type="text" name="pt_time" id="pt_time" value="<?=$d['pt_time']?>" style="width:120px;"> 분</td>
				<th>약어</th>
				<td class="al" ><input type="text" name="code" id="code" value="<?=$d['code']?>" style="width:120px;"></td>
			</tr>
			<tr>
				<th>발표번호</th>
				<td class="al"><input type="text" name="pre_num" id="pre_num" value="<?=$d['pre_num']?>" style="width:120px;"></td>
				<th>초록번호</th>
				<td class="al" ><input type="text" name="abs_num" id="abs_num" value="<?=$d['abs_num']?>" style="width:120px;"></td>
			</tr>
			
			<tr>
				<th>강의제목</th>
				<td colspan=3 class="al">
					<input type="text" name="title" id="title" value="<?=stripslashes($d['title'])?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>발표자 or 좌장</th>
				<td class="al" colspan=3>
					<div>
						<input type="text" name="author_code" id="author_code" value="<?=$d['author_code']?>" style="width:15%;" placeholder="CODE">
						<input type="text" name="author" id="author" value="<?=$d['author']?>" style="width:50%;" placeholder="이름(소속)">
						<input type="text" name="country" id="country" value="<?=$d['country']?>" style="width:30%;" placeholder="Country">
					</div>
					<div class="tp5">
						<input type="text" name="author_code2" id="author_code2" value="<?=$d['author_code2']?>" style="width:15%;" placeholder="CODE">
						<input type="text" name="author2" id="author2" value="<?=$d['author2']?>" style="width:50%;" placeholder="이름(소속)">
						<input type="text" name="country2" id="country2" value="<?=$d['country2']?>" style="width:30%;" placeholder="Country">
					</div>
					<div class="tp5">
						<input type="text" name="author_code3" id="author_code3" value="<?=$d['author_code3']?>" style="width:15%;" placeholder="CODE">
						<input type="text" name="author3" id="author3" value="<?=$d['author3']?>" style="width:50%;" placeholder="이름(소속)">
						<input type="text" name="country3" id="country3" value="<?=$d['country3']?>" style="width:30%;" placeholder="Country">
					</div>
					<div class="tp5">
						<input type="text" name="author_code4" id="author_code4" value="<?=$d['author_code4']?>" style="width:15%;" placeholder="CODE">
						<input type="text" name="author4" id="author4" value="<?=$d['author4']?>" style="width:50%;" placeholder="이름(소속)">
						<input type="text" name="country4" id="country4" value="<?=$d['country4']?>" style="width:30%;" placeholder="Country">
					</div>
				</td>
			</tr>	
			<!-- <tr>
				<th>공저자</th>
				<td colspan=3 class="al">
					<textarea name="author_co" id="author_co" style="height:65px;width:98%;"><?=$d['author_co']?></textarea>
				</td>
			</tr>
			<tr>
				<th>소속</th>
				<td colspan=3 class="al">
					<textarea name="author_position_co" style="height:65px;width:98%;"><?=stripslashes($d['author_position_co'])?></textarea>
				</td>
			</tr> -->
			<tr>
				<th>내용</th>
				<td colspan=3 class="al">
					<div class="dfree-body mce-content-body" contenteditable="true" style="position: relative;border:1px solid gray;height:100px;width:95%;" spellcheck="false"><?=stripslashes($d['plan_intent'])?></div>
					<!-- <textarea name="plan_intent" id="plan_intent"><?=$d['plan_intent']?></textarea> -->
				</td>
			</tr>
			<tr>
				<th>CV</th>
				<td class="al">	
					<div class="selectFile" style="float:left;">
						<p style="margin:0px;padding:0px;"><input name="" id="file_txt" value="선택" type="text" style="width:200px;height:30px;" readonly=""></p>
						<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="cv_file" id="cv_file" onchange="document.getElementById('file_txt').value=this.value;" type="file"></p>
					</div>
					<?
					if($d['cv_file']){
					$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/session/" . $d['cv_file']) . "&filename=" . base64_encode($d['cv_file']);
					?>
					<div style="clear:both;"><a href="/func/download.php?<?=$queryString?>"><?=IconType2($d['cv_file'])?>다운로드</a><input type="checkbox" name="filedel2" value="Y"> <label for="">파일삭제를 원하시면 체크해주세요.</label></div>
					<?}?>
				</td>
				<th>Abstract</th>
				<td class="al">	
					<div class="selectFile" style="float:left;">
						<p style="margin:0px;padding:0px;"><input name="" id="file_txt2" value="선택" type="text" style="width:200px;height:30px;" readonly=""></p>
						<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="abs_file" id="abs_file" onchange="document.getElementById('file_txt2').value=this.value;" type="file"></p>
					</div>
					<?
					if($d['abs_file']){
					$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/session/" . $d['abs_file']) . "&filename=" . base64_encode($d['abs_file']);
					?>
					<div style="clear:both;"><a href="/func/download.php?<?=$queryString?>"><?=IconType2($d['abs_file'])?>다운로드</a><input type="checkbox" name="filedel" value="Y"> <label for="">파일삭제를 원하시면 체크해주세요.</label></div>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>VOD LINK</th>
				<td colspan=3 class="al">
					<input type="text" name="linkurl" id="linkurl" value="<?=$d['linkurl']?>" style="width:90%;">
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