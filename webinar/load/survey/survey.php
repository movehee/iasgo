<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
// 대회 끝나도 열어달라는 요청 이광식 2023-10-19
//if($_COOKIE['wmember_level']!='M'){
//	if(strtotime("2023-09-25 00:00:00")>time()){
//		PutMessageParentReload("This is not a survey period.");
//	}
//	if(strtotime("2023-10-13 00:00:00")<time()){
//		PutMessageParentReload("This is not a survey period.");
//	}
//}
if(strtotime("2023-11-01 23:59:59")<time()){
	PutMessageParentReload("The survey period has ended.");
}
?>
<script>

	$(function() {
		
		$(".inputR").on("click", function() {

			if( $(this).parent().prop('nodeName') == "TD" ) {
				$(this).closest("tr").find("span.inputR").removeClass("on");
			} else {
				$(this).closest("dd").find("span.inputR").removeClass("on");
			}

			
			$(this).addClass("on");

		});

		$(".inputC").on("click", function() {
			$(this).toggleClass("on");

		});

	});

</script>
<style>
	input[type=radio] { margin:0 !important;}
</style>

<?php
$query = "select * from feedback_result_tbl where usid=" . $_COOKIE['wmember_sid'];

$result = $conn->query($query);
if(DB::isError($result)) {
  die($result->getMessage());
}

$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
$result->free();

if($_COOKIE['wmember_country'] == "K") $ccode = "K";
else $ccode = "F";



// if($_SERVER['REMOTE_ADDR']=='218.235.94.225') $ccode="F";
?>
<body>

	<div class="popupWrap" id="popupSurvey">

		<?include_once $_SERVER['DOCUMENT_ROOT'].'load/survey/survey_'.$ccode.'.php';?>

	</div>
	<!-- //popupWrap -->




</body>
</html>