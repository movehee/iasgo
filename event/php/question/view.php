<?include "./../header.php";?>
<?
$setting_query = "SELECT * FROM session_set_tbl where code='".$code."'";
//echo $setting_query;
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
?>

<!-- Question -->
<p class="toptit<?=$event_col['gubun_val']?$event_col['gubun_val']:"";?>"><!-- <img src="/image/t_question.png"> --><?=strtoupper($setting_col['Question_txt'])?></p>


<script>
	$(function() {
		
		<?if($code == "data2019f"){?>
		$("#question_form").on("submit", function() {

			if(!$("select#session_select").val()) {
				alert("프로그램을 선택해주세요.");
				return false;
			}

			if(!$("select#lecture_select").val()) {
				alert("강의를 선택해주세요.");
				return false;
			}
		});
		<?}?>

		$("select#session_select").on("change", function() {
			$session_sid = $(this).val();
			if($session_sid) {
				jQuery.ajax({

				type:"GET",
				url:"/php/session/get_session.php?code=<?=$code?>&session_sid="+$session_sid,
				dataType:"JSON", // 옵션이므로 JSON으로 받을게 아니면 안써도 됨
				success : function(json) {
					var json_data = json[0];					
					
					$('#lecture_select option').not("[value='']").remove();
					$.each(json_data.sub, function(i, value) {
						$('#lecture_select').append($('<option>').text(value.title).attr('value', value.sid));
					});

					$("#session").val(json_data.sid)
					$("#room").val(json_data.room)
				},

				complete : function(data) {
					$("#lecture_area").show();
				},

				error : function(xhr, status, error) {
				}

				});


			}
			else {
				$('#lecture_select option').not("[value='']").remove();
				$("#lecture_area").hide();
			}
		});

		$("select#lecture_select").on("change", function() {
			if($(this).val()) {
				$("#lecture").val($(this).find('option:selected').text());
				$("#sub").val($(this).val());
			}
		});
	});
</script>


<div class="wrapper" >
	<div id="containerWrap">
		<div class="contents">
		<div class="qnaArea">
		<form id="question_form" method="post" action="./post.php">
		<input type="hidden" name="code" value="<?=$code?>">
		<fieldset>
			<legend>질문하기</legend>
			<h2><?=$string['question_sub']?></h2>
			<div class="qnaCon">
				
				<p class="note"><?=$string['question_info']?><?if($code == "data2019f"){?><br>(Q&A는 한라룸에서만 진행합니다)<?}?></p>
				
				<select id="session_select">
					<option value="">프로그램 선택</option>
					<?
						$query = "select * from session_tbl a join 
						(
						SELECT link_session FROM session_tbl where code='data2019f' and type='2' group by link_session
						) b on a.sid=b.link_session where a.room=616";
						$result = mysqli_query($conn, $query);
						while(is_array($col = mysqli_fetch_array($result))){
					?>
					<option value="<?=$col['sid']?>"><?=$col['theme']?></option>

					<?}?>
				</select>
				<span id="lecture_area" style="display:none;">
					<select id="lecture_select">
						<option value="">강의선택</option>
					</select>
				</span>

				<input type="hidden" name="lecture" id="lecture">
				<input type="hidden" name="session" id="session">
				<input type="hidden" name="sub" id="sub">
				<input type="hidden" name="room" id="room">

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