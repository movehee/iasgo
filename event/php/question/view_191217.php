<?include "./../header.php";?>
<?
$setting_query = "SELECT * FROM session_set_tbl where code='".$code."'";
//echo $setting_query;
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
?>

<!-- Question -->
<p class="toptit<?=$event_col['gubun_val']?$event_col['gubun_val']:"";?>"><!-- <img src="/image/t_question.png"> --><?=strtoupper($setting_col['Question_txt'])?></p>


<div class="wrapper" >
	<div id="containerWrap">
		<div class="contents">
		<div class="qnaArea">
		<form name="researchF" method="post" action="./post.php">
		<input type="hidden" name="code" value="<?=$code?>">
		<fieldset>
			<legend>질문하기</legend>
			<h2><?=$string['question_sub']?></h2>
			<div class="qnaCon">
				<p class="note">
				<?=$string['question_info']?>
				</p>

				<textarea name="question" id="question" cols="30" rows="10"></textarea>

				<p class="btn"><input class="resetBtn" type="image" src="/image/b_send.png" alt="SEND"></p>
			</div>

		</fieldset>
		</form>
		</div>
		</div>
	</div>
</div>


<?include "./../footer2.php";?>