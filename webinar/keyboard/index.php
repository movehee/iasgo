<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>PC Full Keyboard + Numpad</title>

<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<link type="text/css" rel="stylesheet" href="keyboard.css">
<script src="key.js"></script>
<script>
	$(function(){
		$('#keyboardForm').submit(function(){
			if(!$('#display').val()){
				alert("검색하실 내용을 입력해주세요.");
				return false;
			}
			alert("처리 페이지를 만들어 줍시다...");
			location.reload();
			return false;
		})
	});
</script>
</head>
<body>
<div>
	<form action="submit.php" method="POST" id="keyboardForm">
	<textarea id="display" name="keyword" placeholder="여기에 입력됩니다" style="font-family: 'Paperlogy', 'Pretendard', sans-serif;"></textarea>
	<div style="text-align:right;padding-bottom:10px;color:#FF0080;font-weight:bold;">※ 쌍자음(ㄲ, ㄸ, ㅃ, ㅆ, ㅉ) 기호는 같은 문자를 2번 클릭하면 변환됩니다.</div>

	<div class="keyboard-wrap">
		<div class="left" id="leftKeyboard"></div>
		<div class="numpad" id="numpad"></div>
	</div>
	<div style="text-align:center;width:100%;padding:10px;">
		<button type="submit" style="margin-top:20px;width:200px;height:55px;font-size:20px;border-radius:10px;background:#4a90e2;border:none;color:white;cursor:pointer;width:100%;">Submit</button>
	</div>
	</form>
</div>

<script src="keyboard.js"></script>
</body>
</html>
