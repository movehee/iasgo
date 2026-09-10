<?include "./../header.php";?>
<?
$setting_query = "SELECT * FROM session_set_tbl where code='".$code."'";
//echo $setting_query;
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
?>
<?
if(empty($sid)){
	$query="SELECT * FROM voting_tbl where code='".$code."' and status in ('1','3')";
}else{
	$query="SELECT * FROM voting_tbl where code='".$code."' and sid='".$sid."'";
}
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);
if($col){

?>
<body style="background-color: #3b4f69;">
<div class="wrapper">
<?if($col['image']){?>
<div class="imgArea">
	<img src="/upload/<?=$col['image']?>" alt="">
</div>
<?}?>
<dl class="question<?=$event_col['gubun_val']?$event_col['gubun_val']:"";?>">
	<?if($col['question']){?>
		<dt class="bm30"><?=$col['question']?></dt>
	<?}?>
	<dd>
		<ul class="optionList col<?=$col['ui']?>ea imgList">
			<?if($col['answer1']!="" || $col['answer1_img']!=""){?>
			<li id="answer1" <?if($col['status']=="3" && $col['correct']=="1"){?>class="on"<?}?> onclick="javascript:voting('<?=$code?>','<?=$col['sid']?>','<?=$id?>','1')"><a>
				
				<?if($col['answer1']){?>
				<span>① <?=$col['answer1']?></span>
				<?}?>
				<?if($col['answer1_img']){?>
				<img src="/upload/<?=$col['answer1_img']?>" alt="">
				<?}?>
			</a></li>
			<?}?>
			<?if($col['answer2']!="" || $col['answer2_img']!=""){?>
			<li id="answer2" <?if($col['status']=="3" && $col['correct']=="2"){?>class="on"<?}?> onclick="javascript:voting('<?=$code?>','<?=$col['sid']?>','<?=$id?>','2')"><a>
				
				<?if($col['answer2']){?>
				<span>② <?=$col['answer2']?></span>
				<?}?>
				<?if($col['answer2_img']){?>
				<img src="/upload/<?=$col['answer2_img']?>" alt="">
				<?}?>
			</a></li>
			<?}?>
			<?if($col['answer3']!="" || $col['answer3_img']!=""){?>
			<li id="answer3" <?if($col['status']=="3" && $col['correct']=="3"){?>class="on"<?}?> onclick="javascript:voting('<?=$code?>','<?=$col['sid']?>','<?=$id?>','3')"><a>
				
				<?if($col['answer3']){?>
				<span>③ <?=$col['answer3']?></span>
				<?}?>
				<?if($col['answer3_img']){?>
				<img src="/upload/<?=$col['answer3_img']?>" alt="">
				<?}?>
			</a></li>
			<?}?>
			<?if($col['answer4']!="" || $col['answer4_img']!=""){?>
			<li id="answer4" <?if($col['status']=="3" && $col['correct']=="4"){?>class="on"<?}?> onclick="javascript:voting('<?=$code?>','<?=$col['sid']?>','<?=$id?>','4')"><a>
				
				<?if($col['answer4']){?>
				<span>④ <?=$col['answer4']?></span>
				<?}?>
				<?if($col['answer4_img']){?>
				<img src="/upload/<?=$col['answer4_img']?>" alt="">
				<?}?>
			</a></li>
			<?}?>
			<?if($col['answer5']!="" || $col['answer5_img']!=""){?>
			<li id="answer5" <?if($col['status']=="3" && $col['correct']=="5"){?>class="on"<?}?> onclick="javascript:voting('<?=$code?>','<?=$col['sid']?>','<?=$id?>','5')"><a>
				
				<?if($col['answer5']){?>
				<span>⑤ <?=$col['answer5']?></span>
				<?}?>
				<?if($col['answer5_img']){?>
				<img src="/upload/<?=$col['answer5_img']?>" alt="">
				<?}?>
			</a></li>
			<?}?>
			<?if($col['answer6']!="" || $col['answer6_img']!=""){?>
			<li id="answer6" <?if($col['status']=="3" && $col['correct']=="6"){?>class="on"<?}?> onclick="javascript:voting('<?=$code?>','<?=$col['sid']?>','<?=$id?>','6')"><a>
				
				<?if($col['answer6']){?>
				<span>⑥ <?=$col['answer6']?></span>
				<?}?>
				<?if($col['answer6_img']){?>
				<img src="/upload/<?=$col['answer6_img']?>" alt="">
				<?}?>
			</a></li>
			<?}?>

			<?if($col['answer7']!="" || $col['answer7_img']!=""){?>
			<li id="answer7" <?if($col['status']=="3" && $col['correct']=="7"){?>class="on"<?}?> onclick="javascript:voting('<?=$code?>','<?=$col['sid']?>','<?=$id?>','7')"><a>
				
				<?if($col['answer7']){?>
				<span>⑥ <?=$col['answer7']?></span>
				<?}?>
				<?if($col['answer7_img']){?>
				<img src="/upload/<?=$col['answer7_img']?>" alt="">
				<?}?>
			</a></li>
			<?}?>

			<?if($col['answer8']!="" || $col['answer8_img']!=""){?>
			<li id="answer8" <?if($col['status']=="3" && $col['correct']=="8"){?>class="on"<?}?> onclick="javascript:voting('<?=$code?>','<?=$col['sid']?>','<?=$id?>','8')"><a>
				
				<?if($col['answer8']){?>
				<span>⑥ <?=$col['answer8']?></span>
				<?}?>
				<?if($col['answer8_img']){?>
				<img src="/upload/<?=$col['answer8_img']?>" alt="">
				<?}?>
			</a></li>
			<?}?>
		</ul>
	</dd>
</dl>
</body>
<?}else{?>
	<img src="/image/ing.png" style="margin-top:70px">
<?}?>

<script>
	var sid = "-1";
	
	function voting(code,sid,deviceid,val){

		for(i=1;i<=6;i++){
			if(document.getElementById("answer"+i)){
			if(i==val){
				document.getElementById("answer"+i).classList.add('on');
			}else{
				document.getElementById("answer"+i).classList.remove('on');
			}
			}
		}

		$.ajax({
			type:"POST",
			url:"./post.php",
			data:"code="+code+"&sid="+sid+"&deviceid="+deviceid+"&val="+val,
			
			success:function(msg){
				
				if(msg == "1"){
					alert("투표가 완료되었습니다.");
				}else if(msg == "2"){
					alert("투표가 수정되었습니다.");
				}else if(msg == "3"){
					alert("이미 종료된 보팅입니다.");
				}

			},error: function (xhr, ajaxOptions, thrownError) {
				alert("투표가 완료되었습니다..");
			}
			
		});
	}
	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	var code = getParameterByName("code");

setInterval(function() {
	
   //alert(code);
	$.ajax({
		type:"POST",
		url:"./get_voting.php",
		data:"code="+code,
		async : false,
		success:function(msg){
			if(sid=="-1"){
				sid = msg;
			}else if (sid!=msg)
			{
				location.reload();
			}
		}
	});
	
}, 1000);

</script>


<?include "./../footer2.php";?>