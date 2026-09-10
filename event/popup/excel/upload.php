<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	procAdminLoginChk();

	//기본양식
	$popup_title = "등록 Sample";
	$columns = array("No","학교명","학교명2","학교명3","학교4명","학교5명2");
	$columns_val = array("No","학교명","학교명2","학교명3","학교4명","테스트");
	$columns_size = array("100","100","100","100","100","100");
	$w_size = 1300;

	if($kind=="poster"){
		$popup_title = "E-Poster 등록";
		//$columns = array("Category","Category Sub","ID","<b style=color:red>Poster No.</b>","제목","저자","공저자","소속","E-mail","연락처","Award","Invited","Country","Link");
		//$columns_val = array("Category", "Category Sub","ID","2020-001","포스터제목입니다.","홍길동","홍길동2","엠투","","","Y","Y","KOR","");


		// $columns = array("Category","Category Sub","<b style=color:red>Poster No.</b>","제목","연제번호","country","Field","email","발표자","발표자소속","발표자Depart","발표자E-mail","Co-Author","Author","Affiliation","Award");
		// $columns_val = array("","","","","","","","","","","","","","");
		// $columns_size = array("100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","100","60");
		$columns = array("Category","Category Sub","Abstract No","세션코드","Title","Country","email","발표자","발표자소속",
			"co_1", "co_no1",
			"co_2", "co_no2",
			"co_3", "co_no3",
			"co_4", "co_no4",
			"co_5", "co_no5",
			"co_6", "co_no6",
			"co_7", "co_no7",
			"co_8", "co_no8",
			"co_9", "co_no9",
			"co_10", "co_no10",
			"co_11", "co_no11",
			"aff1","aff2","aff3","aff4","aff5","aff6","aff7",
		);
		$columns_val = array("","","","","","","","","",
		"","","","","","","","","","","","","","","","","","","","","","",
		"","","","","","",
		);
		$columns_size = array("","","100","100","100","100","100","100","100",
		"","","","","","","","","","","","","","","","","","","","","","",
		"","","","","","",
		);

		$w_size = 2200;
	}else if($kind=="poster_category"){
		$popup_title = "E-Poster Category 등록";
		$columns = array("<b style=color:red>Category</b>","<b style=color:red>Sub Category</b>");
		$columns_val = array("Category명","Category명");
		$columns_size = array("300","300");
		$w_size = 1300;
	}else if($kind=="booth"){
		$popup_title = "E-Booth 등록";
		$columns = array("부스등급","<b style=color:red>부스명</b>","Company","Brochures","Movie","Survey","Guest Book","Stamp Event","담당자(ID)");
		$columns_val = array("Galaxy","엠투커뮤니티","Y","Y","Y","Y","Y","Y","");
		$columns_size = array("150","150","120","120","120","120","120","120","150");
		$w_size = 1300;
	}else if($kind=="booth_grade"){
		$popup_title = "E-Booth Category 등록";
		$columns = array("<b style=color:red>등급</b>");
		$columns_val = array("Galaxy");
		$columns_size = array("500");
		$w_size = 1300;
	}else if($kind=="sessions"){
		$popup_title = "Sessions 등록";
		$columns = array("<b style=color:red>날짜</b>","<b style=color:red>시간</b>","<b style=color:red>채널</b>","카테고리1","카테고리2","코드(약어)","코드(Full)","언어","난이도","<b style=color:red>세션제목</b>","좌장1","좌장1 code","좌장2","좌장2 code","좌장3","좌장3 code","좌장4","좌장4 code","설명");
		$columns_val = array("","","","","","","","K/E","","","","","","");
		$columns_size = array("100","100","70","100","100","100","70","70","70","300","100","100","100","100","100","100","100","100","100");
		$w_size = 2000;
	}else if($kind=="session_detail"){
		$popup_title = "Session Detail 등록";
		$columns = array("<b style=color:red>날짜</b>","<b style=color:red>시간</b>","<b style=color:red>장소</b>","<b style=color:red>세부시간</b>","강의제목","발표자","소속","초록번호","초청번호","발표번호");
		$columns_val = array("","","","","","","","","","");
		$columns_size = array("120","120","120","150","500","150","170","100","100","100");
		$w_size = 1800;
	}else if($kind=="registration"){
		$popup_title = "Registration 등록 (사전등록 엑셀)";
		$columns = array(
			"등록번호","ID(Email)","Password","Country(국가)","FullName(영문)","First Name","Last Name",
			"Affiliation","Mobile No.","Department","성명(국문)","의사면허 번호","그 외 소속 기관","소속 기관(국문)",
			"구분 선택","소속 선택","무료","등록유형","등록결제시기","등록비 금액",
			"결제상태","결제방법","결제일자","참석일수","사교행사","워크샵행사","관리자 메모","VIP","리본","DESK"
		);
		$columns_val = array(
			"R-0001","test@iasgo.org","1234","Korea","Gildong Hong","Gildong","Hong",
			"Severance Hospital","010-0000-0000","","홍길동","12345","","세브란스병원",
			"전문의","외과","","IASGO / KSGC / KSSO Member","사전등록","700000",
			"완료","카드","","3","","","","","",""
		);
		$columns_size = array(
			"80","140","80","100","120","100","100",
			"150","110","100","80","90","100","120",
			"80","80","50","200","90","80",
			"70","80","100","60","60","80","120","50","80","60"
		);
		$w_size = 2800;
	}else if($kind=="exam"){
		$popup_title = "시험문제 등록";
		$columns = array("문제","문항1","문항2","문항3","문항4","문항5","답","해설");
		$columns_val = array("문제","문항1","문항2","문항3","문항4","문항5","1","");
		$columns_size = array("300","150","150","150","150","150","50","100");
		$w_size = 1300;
	}else if($kind=="faculty_list"){
		$popup_title = "Faculty 등록";
		$columns = array("발표번호","이름","소속","Role","Country","Category1","Category2","Award","email");
		$columns_val = array("발표번호","이름","소속","Speaker","Korea","Invited","","","");
		$columns_size = array("100","100","200","100","150","150","120","120","150");
		$w_size = 1300;
	}

	foreach($columns as $tkey=>$tval){
		$field_arr[] = $tval;
		$field_size_arr[] = $columns_size[$tkey];
		$filed_values[] = $tkey." : '".$columns_val[$tkey]."'";
	}
	$field_txt = implode("','",$field_arr);
	$field_size = implode(",",$field_size_arr);
	$field_val = implode(",",$filed_values);
?>
<script type="text/javascript" src="/script/handsontable.full.min.js"></script>
<link type="text/css" rel="stylesheet" href="/script/handsontable.full.min.css">

<script>
	$('#Popup_Title').html('<?=$popup_title?>');
	$(function(){
		re_height = $('.popupWrap').outerHeight()+68;
		re_width = $('.popupWrap').outerWidth()+17;
		
		if(re_height>1000){
			window.resizeTo(re_width,1000);	
		}else{
			//window.resizeTo(re_width,re_height);
			window.resizeTo(re_width,1000);
		}
	});
	document.addEventListener("DOMContentLoaded", function() {
		var data = [{
			<?=$field_val?>
		}],
		container,
		hot;	
		var example1 = document.getElementById('example1');
		  
		var hot = new Handsontable(example1, {
			data: data,
			//data: Handsontable.helper.createSpreadsheetData(1, 3),
			//colHeaders: true,
			colHeaders: ['<?=$field_txt?>'],
			colWidths: [<?=$field_size?>],
			licenseKey: 'non-commercial-and-evaluation',
			rowHeaders: "✚"
		});
	  
		var buttons = {
			string: document.getElementById('export-string'),
			stringRange: document.getElementById('export-string-range'),
			blob: document.getElementById('export-blob'),
			file: document.getElementById('export-file')
		};
	  
		var exportPlugin = hot.getPlugin('exportFile');
		var resultTextarea = document.getElementById('result');
	  
		buttons.string.addEventListener('click', function() {
			resultTextarea.value = exportPlugin.exportAsString('csv');
			console.log(resultTextarea.value);
		});

		buttons.stringRange.addEventListener('click', function() {
			resultTextarea.value = exportPlugin.exportAsString('csv', {
				exportHiddenRows: true,     // default false, exports the hidden rows
				exportHiddenColumns: true,  // default false, exports the hidden columns
				columnHeaders: false,        // default false, exports the column headers
				rowHeaders: true,           // default false, exports the row headers
				columnDelimiter: '|::|',       // default ',', the data delimiter
				//range: [0, 0, 3, 3]         // data range in format: [startRow, endRow, startColumn, endColumn]
			});
			//console.log(resultTextarea.value);
		});
		buttons.blob.addEventListener('click', function() {
			var blob = exportPlugin.exportAsBlob('csv');
			resultTextarea.value = blob;
			//console.log(blob);
		});
		buttons.file.addEventListener('click', function() {
			exportPlugin.downloadFile('csv', {filename: 'MyFile'});
		});
	});

	function selfdel(obj){
		$(this).parent().parent().remove();
		alert(1)
		//var tr = $(obj).parent().parent().parent().parent();
		//tr.remove();
	}
</script>
<div class="popupWrap" id="pMembeSearch" style="width:<?=$w_size?>px;padding:10px;height:<?=$h_size?>px">
<form method='post' action="upload_reg.php">
<input type="hidden" name="kind" value="<?=$kind?>">
<input type="hidden" name="code" value="<?=$code?>">
<input type="hidden" name="society_sid" value="<?=$_COOKIE['society_sid']?>">
<input type="hidden" name="exam_year" value="<?=$_COOKIE['Set_year']?>">
<input type="hidden" name="chkday" value="<?=$chkday?>">
<input type="hidden" name="category" value="<?=$category?>">
<div class="tp10 bp10">
	<ul>
		<li><b style='color:red;font-size:13px;'>* 아래 형식에 맞게 엑셀내용을 복사하여 붙여넣기 해주시기 바랍니다. (아래 한칸은 예시입니다.)</b> </li>
		<li><b style='color:red;font-size:13px;'>* 항목에 붉은색으로 표시되어있는 부분은 키값으로 사용됩니다. 해당 항목이 일치할 경우에는 업데이트가 되며, 일치하지 않으면 새로저장이 됩니다.</b> </li>
	</ul>
</div>
<div style="width:<?=$w_size?>px;" >
  <div id="example1" class="hot handsontable htRowHeaders htColumnHeaders" ></div>
</div>
<table class="tblDef inputTbl ac" style="display:none;">
	<tr style="display:none;">
		<td>
			<button id="export-string" class="intext-btn" type="button">Export as a String</button>
			<button id="export-blob" class="intext-btn">Export as a blob</button>
			<button id="export-file" class="intext-btn">Export as a file</button>
		</td>
	</tr>
	<tr>
		<td colspan=6 style="padding:0px;">
		<textarea name="result" id="result" style="height: 100px; min-width: 400px;font-size: 0.813em;border: 1px solid #C5C5C5;"></textarea>
		</td>
	</tr>
</table>
<div class="ac tp20">
	<span  class="rBtnAdmin large blue "><button id="export-string-range" class="intext-btn btnDef btnBig" >등록</button></span>
	<span class="rBtnAdmin large black"><input type="button" value="닫기" onclick="self.close()" /></span>
</div>
<br /><br /><br />
</form>
</div>
