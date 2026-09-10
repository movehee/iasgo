<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>

<?	
	$query = "select * from exam_tbl where day='$exam_day' and category='$category' and del='N' order by exam_num asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());	
?>
<?if($category=='A'){?>
<script>
	$(document).ready(function(){
		 Details = setInterval( function () {
		 	parent.location.href="/logout.php?off=Y";
		 }, 5000);
	});

</script>
<div class="popupWrap" id="popupQuiz">
    <h1 class="bg"><?if($category=='A'){?>Case of the Day<?}else{?>Live Diagnosis Challenge<?}?> - day <?=$exam_day?></h1>

	<div class="popupCon">

        <div class="formArea scrollArea" id="exam_content">
            <div style="text-align:center;font-size:30px;padding-top:50px;">
                Your submission has been completed.<br>
				The commentary book will be uploaded on the Download Center, <br />My Page after 17:30 KST.<br>
				The results will be made availalbe tomorrow at the E-poster Zone.

            </div>

            <div class="btn btnArea">
                <input type="button" value="Close" class="btnDef btnBig " onclick="parent.location.href='/logout.php?off=Y'">
            </div>
        </div>
    </div>
</div>

<!-- <script>
	alert("Participation in today's case of the day has been completed. Please come back tomorrow");
	parent.location.href='/logout.php';
</script> -->
<?exit;}?>
 <div class="popupWrap" id="popupQuiz">
    <h1 class="bg"><?if($category=='A'){?>Case of the Day<?}else{?>Live Diagnosis Challenge<?}?> - day <?=$exam_day?></h1>

	<div class="popupCon">

        <div class="formArea scrollArea" id="exam_content">
            <div style="text-align:center;font-size:30px;padding-top:50px;">
                Your submission has been completed.<br>
                The answers will be released after <?if($exam_day=='1'){?>15:50<?}else{?>14:00<?}?> KST.
            </div>

            <div class="btn btnArea">
                <input type="button" value="Close" class="btnDef btnBig color_close">
            </div>
        </div>
    </div>
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>