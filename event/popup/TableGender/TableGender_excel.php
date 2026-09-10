<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?

	//기본양식
	$popup_title = "등록 Sample";
	$columns = array("A","B","C","D","E");


	foreach($columns as $tkey=>$tval){
		$field_arr[] = $tval;
		$field_size_arr[] = $columns_size[$tkey];
		$filed_values[] = $tkey." : '".$columns_val[$tkey]."'";
	}
	$field_txt = implode("','",$field_arr);
	$field_size = implode(",",$field_size_arr);
	$field_val = implode(",",$filed_values);
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("Program At a Glance");
		re_height = $('.popupWrap').outerHeight()+28;
		re_width = $('.popupWrap').outerWidth()+40;
		window.resizeTo(1000,1000);
	});
	
</script>
<script type="text/javascript" src="/script/handsontable.full.min.js"></script>
<link type="text/css" rel="stylesheet" href="/script/handsontable.full.min.css">
<script>
	document.addEventListener("DOMContentLoaded", function() {
		var data = [{
			<?=$field_val?>
		}],
		container,
		hot;	
		var example1 = document.getElementById('example1');
		  
		var hot = new Handsontable(example1, {
			data: data,
			data: Handsontable.helper.createSpreadsheetData(1, 3),
			colHeaders: true,
			colHeaders: ['<?=$field_txt?>'],
			colWidths: [120,120,120],
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
</script>
<div class="popupWrap" id="popupPeriod" style="width:1000px;padding:10px;">
	<div class="formArea">
		<div class="agreeCon2">
			<ul>
				<li><b style='color:red'>* 엑셀내용을 복사하여 붙여넣기해주세요.</b> </li>
			</ul>
		</div>
		<br />
		<form method='post' action="TableGender_excel_reg.php">
		<input type="hidden" name="code" id="code" value="<?=$code?>">
		<input type="hidden" name="chk_date" id="chk_date" value="<?=$ev_date?>">
		<div style="width:<?=$width_size?>;" >
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
	
		<div class="btn btnArea">
			<button id="export-string-range" class="intext-btn btnDef btnBig" >등록</button>
			<input type="button" value="닫기" class="btnGray btnBig" onclick="self.close();">
		</div>
		</form>
	</div>
</div>