<?
	include $_SERVER['DOCUMENT_ROOT']."/39th/lib.php";
	header('Content-Type: text/html; charset=utf-8');
?>
<link type="text/css" rel="stylesheet" href="/39th/css/TableGenerator.css" />
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/39th/script/jquery-ui.min.js"></script>
<script type="text/javascript" src="/39th/script/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/39th/script/user.js"></script>
<link type="text/css" rel="stylesheet" href="/39th/admin/button_package/button.css" />
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("Program 생성");
		window.resizeTo(1300,1000);
	});

	function confirm_tbl(){
		//alert("현재는 등록 할 수 없습니다.");
		//return;
		if(confirm("적용하시겠습니까?")){
			$('#TableGenderF').submit();
		}
	}
</script>
</head>
<body style="padding-top:120px;">
<div id="generator"  >
	<div id="ttg-header" >
		<div class="nav" >
			

			행<input class="value" type="number" name="row" value="3" min="1"> &times;
			열<input class="value" type="number" name="col" value="3" min="1">
			<div class="help">
				<i class="ico-hint">?</i>
				<div class="hint">
					값을 늘리거나 설정 합니다, 키보드 입력, 회전자을 클릭 하거나 마우스 휠을 돌려.				</div>
			</div>

			<ul class="button-group" >
				<li class="first">
					<button id="merge" title="여러 셀 병합" class="button">병합</button>
				</li>
				<li>
					<button id="split" title="병합 된 셀 분하시오" class="button">분할</button>
				</li>
				<!-- <li>
					<button id="replace" title="바꾸기 &lt; td &gt;와 &lt; 일 &gt; 서로" class="button">td &harr; th</button>
				</li> -->
				<!-- <li>
					<button id="chars" title="문자 입력" class="button">Characters</button>
				</li> -->
				<li>
					<button id="output-chars" title="출력 문자" class="button">출력</button>
				</li>
				<!-- <li class="last">
					<button id="class" title="클래스의 이름을 입력합니다" class="button">class</button>
				</li>
				<li class="last">
					<button id="output-class" title="출력 클래스의 이름" class="button">출력</button>
				</li> -->
			</ul>

			<button id="undo" title="실행 취소" disabled="disabled" class="button">←</button>
			<button id="redo" title="다시 실행" disabled="disabled" class="button">→</button>
			<button id="initialize" title="초기화" class="button">초기화</button>
		</div>

		<div class="message" >
			<p id="select-by-dragging" class="default">드래그 하 여 셀을 선택할 수 있습니다.</p>
			<p id="ent-chars">문자를 입력 해 주시기 바랍니다.</p>
			<p id="ent-class-names">클래스의 이름을 입력 하십시오.</p>
			<p id="cant-merge" class="alert">&times; 병합 &lt; td &gt;와 &lt; 일 &gt; 수는 없습니다.</p>
			<p id="cant-remerge" class="alert">&times; 다시 병합 된 셀을 병합할 수는 없습니다. 그들을 분할 하십시오.</p>
			<p id="ent-num" class="alert">&times; 숫자를 입력 하십시오.</p>
			<p id="ent-natural-num" class="alert">&times; 자연 수 (1,2,3...)를 입력 해 주시기 바랍니다.</p>
			<p id="select-cells" class="alert">&times; 드래그 하 여 운영 하는 셀을 선택 하십시오.</p>
		</div>
	</div>

	<div id="main">
		<div id="tag-wrapper"><table style="width:100%;"><tr><td></td></tr></table></div>
	</div>
</div><!-- /generator -->

<div class="code">
	<form name="TableGenderF" id="TableGenderF" method="post" action="TableGender_reg.php">
	<input type="hidden" name="code" id="code" value="<?=$code?>">
	<input type="hidden" name="msid" id="msid" value="<?=$msid?>">
	<input type="hidden" name="kind" id="kind" value="<?=$kind?>">
	<input type="hidden" name="chk_date" id="chk_date" value="<?=$chk_date?>">
		<div class="box">
			<div id="source" style="width:100% !important;display:none;">
				<h1>HTML</h1>
				<textarea name="source" rows="40" cols="40" style="width:100% !important;"></textarea>
			</div>
			<span class="btnAdmin xlarge blue"><button type="button" onclick="confirm_tbl()">적용</button></span>
		</div>
	</form>
	<div class="box" >
	<div id="style" style="width:100% !important;display:none;">
		<h1>CSS <span>(즉시 적용 됩니다.)</span></h1>
		<textarea name="style" rows="40" cols="40" style="width:100% !important;"></textarea>
	</div>
	</div>
</div><!-- /code -->
<script type="text/javascript" src="/39th/script/table_tag_generator.js"></script>
</body>
</html>
