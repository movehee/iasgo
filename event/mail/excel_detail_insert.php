<?
include $DOCUMENT_ROOT."popup/include.header.php";
include "config.php";
?>
<?=$_js_css?>
<script type="text/javascript">
	$(function(){
		$('#excel_frm').submit(function(){
			/*
			if(!document.getElementsByName("dot")[0].checked && !document.getElementsByName("dot")[1].checked){
				alert("점자여부를 선택하세요");
				document.getElementsByName("dot")[0].focus();
				return false;
			}
			*/
			if(!$('#excel_file').val()){
				alert("엑셀파일을 등록하세요");
				return false;
			}
		});
	});

</script>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupWrap').outerHeight()+68;
		re_width = $('.popupWrap').outerWidth()+17;
		
		if(re_height>1000){
			window.resizeTo(re_width,1000);	
		}else{
			//window.resizeTo(re_width,re_height);
			window.resizeTo(re_width,re_height);
		}
	});
</script>
</head>
<body>
<form method="post" action="excel_post.php?c_index=<?=$c_index?>" name="excel_frm" id="excel_frm" enctype="multipart/form-data">
<div class="popupWrap" style="width:800px;padding:10px 0 0 10px;border:7px solid #616874;">
	<p style="font-size:15px;font-weight:bold;">엑셀파일등록</p>
	<ul>
		<li>- 엑셀파일만 등록가능합니다. (파일 확장자가 xls 인 것만 등록.)</li>
		<li>- 엑셀의 첫행을 제외한 데이터가 등록됩니다. (항목 타이틀을 제외하기 위함.)</li>
		<li>- 엑셀 데이터는 아래의 양식으로 제작되어야 합니다.</li>
		<li>- 없는 항목의경우 빈셀로넣어서 아래의 내역은 모두 표시되어야 합니다.</li>
		<li>- 엑셀 데이터 작성 예)</li>
	</ul><br/>
	
	<table border="0" cellpadding="0" cellspacing="0" class="list_tbl"  style="width:98%;">
		<tr>
			<th class="th">성명</th>
			<th class="th">이메일</th>
		</tr>
		<tr>
			<td class="td" width="8%">홍길동</td>
			<td class="td" width="9%">hongildong@circulation.or.kr</td>
		</tr>
	</table>
	<br/>
	<div style="padding:0px;padding-bottom:5px;"><a href="sample_upload.xls"><img src="/image/icon/icon_xlsx.gif"> 샘플파일입니다. (다운로드받아 양식대로 올려주시면 됩니다.)</a></div>
	<table border="0" cellpadding="0" cellspacing="0" class="regist_tbl" style="width:98%;">
		<tr>
			<th class="th">엑셀파일</th>
			<td class="td"><input type="file" name="excel_file" id="excel_file"/></td>
		</tr>
	</table><br/>
	<p align="center">
		<span class="btnAdmin medium blue"><button type="submit" >등록</button></span>
		<span class="btnAdmin medium gray"><button type="button" onclick="self.close();">닫기</button></span>
	</p>
	<br /><br /><br />
</div>
</form>
</body>
</html>