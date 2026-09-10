<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>PC Full Keyboard + Numpad</title>

<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<link type="text/css" rel="stylesheet" href="keyboard.css?v=<?=rand(1,999)?>">

<script src="key.js?v=<?=rand(1,999)?>"></script>
<script>
	$(function(){
		$('#keyboardForm').submit(function(){
			if(!$('#display').val()){
				alert("Please enter what you want to search for..");
				return false;
			}
			parent.$('#keyword').val($('#display').val());
			parent.$('#searchF').submit();
			
			return false;
		})
	});
</script>
</head>
<body>
<div style="width:100%; zoom:0.65;">
	<form action="submit.php" method="POST" id="keyboardForm">
	<textarea id="display" name="keyword" placeholder="It is entered here." style="font-family: 'Paperlogy', 'Pretendard', sans-serif;"></textarea>
	<div style="text-align:right;padding-bottom:10px;color:#FF0080;font-weight:bold;">※
Korean only 쌍자음(ㄲ, ㄸ, ㅃ, ㅆ, ㅉ) 기호는 같은 문자를 두 번 터치하면 입력됩니다.</div>

	<div class="keyboard-wrap">
		<div class="left" id="leftKeyboard"></div>
		<div class="numpad" id="numpad"></div>
	</div>
	<div style="text-align:center;width:100%;padding:10px;">
		<button type="submit" style="margin-top:20px;width:200px;height:55px;font-size:20px;border-radius:10px;background:#4a90e2;border:none;color:white;cursor:pointer;width:100%;">ENTER</button>
	</div>
	</form>
</div>

<script src="keyboard.js"></script>

</body>
</html>
