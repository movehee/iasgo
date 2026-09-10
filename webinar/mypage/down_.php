
<ul class="pdfList">
		<!-- 초록집 -->
    <li>
     <a href="<?=$_Azure['link']?>upload/download/AOCR-KCR 2022_ABSTRAC.pdf" target="_blank">
            <img src="https://aocr2022-event.ezv.kr/upload/download/abstract.png" alt="">
			<span>Abstract Book</span>
        </a>
    </li>
	<!-- 프로그램북 -->
    <li>
        <a href="<?=$_Azure['link']?>upload/download/AOCR_KCR 2022_ProgramBook.pdf" target="_blank">
            <img src="https://aocr2022-event.ezv.kr/upload/download/program.png" alt="">
			<span>Program Book</span>
        </a>
    </li>
	<!-- 사용 가이드라인 kor -->
    <li>
        <a href="<?=$_Azure['link']?>upload/download/AOCR 2022 & KCR 2022_Virtual Platform Guideline_v.1.0_kor.pdf" target="_blank">
            <img src="https://aocr2022-event.ezv.kr/upload/download/Guideline_kor.png" alt="">
			<span>Virtual Platform Guideline (KOR)</span>
        </a>
    </li>

<!-- 사용 가이드라인 eng -->
    <li>
        <a href="<?=$_Azure['link']?>upload/download/AOCR 2022 & KCR 2022_Virtual Platform Guideline_v.1.0_ENG.pdf" target="_blank">
            <img src="https://aocr2022-event.ezv.kr/upload/download/Guideline_eng.png" alt="">
			<span>Virtual Platform Guideline (ENG)</span>	
        </a>
    </li>

	<!--LDC 퀴즈 정답지 _day1 ★(DAY별 오후 4시 이후부터 확인 가능★ -->
    <?php if(strtotime("2022-09-20 16:00:00") <= $_Time['ing']) :?>
    <li>
         <a href="<?=$_Azure['link']?>upload/download/LDC_Day1일차.pdf" target="_blank">
           <img src="https://aocr2022-event.ezv.kr/upload/download/ldc_1.png" alt="">
		   <span>Live Diagnosis Challenge total commentary Book_Day 1</span>
        </a>
    </li>
    <?php endif;?>

	<!--LDC 퀴즈 정답지 _day2 ★ (DAY별 오후 4시 이후부터 확인 가능★ -->
    <?php if(strtotime("2022-09-21 16:00:00") <= $_Time['ing']) :?>
    <li>
         <a href="<?=$_Azure['link']?>upload/download/LDC_Day2일차.pdf" target="_blank">
           <img src="https://aocr2022-event.ezv.kr/upload/download/ldc_2.png" alt="">
		   <span>Live Diagnosis Challenge total commentary Book_Day 2</span>
        </a>
    </li>
    <?php endif;?>

	<!--LDC 퀴즈 정답지 _day3 ★(DAY별 오후 4시 이후부터 확인 가능★ -->
    <?php if(strtotime("2022-09-22 16:00:00") <= $_Time['ing']) :?>
    <li>
         <a href="<?=$_Azure['link']?>upload/download/LDC_Day3일차.pdf" target="_blank">
           <img src="https://aocr2022-event.ezv.kr/upload/download/ldc_3.png" alt="">
		   <span>Live Diagnosis Challenge total commentary Book_Day 3</span>
        </a>
    </li>
    <?php endif;?>

	<!--LDC 퀴즈 정답지 _day4 ★(DAY별 오후 4시 이후부터 확인 가능★ -->
    <?php if(strtotime("2022-09-23 16:00:00") <= $_Time['ing']) :?>
    <li>
         <a href="<?=$_Azure['link']?>upload/download/LDC_Day4일차.pdf" target="_blank">
           <img src="https://aocr2022-event.ezv.kr/upload/download/ldc_4.png" alt="">
		   <span>Live Diagnosis Challenge total commentary Book_Day 4</span>
        </a>
    </li>
    <?php endif;?>

	<!--LDC 퀴즈 정답지 _day5 ★(DAY별 오후 4시 이후부터 확인 가능★ -->
    <?php if(strtotime("2022-09-24 16:00:00") <= $_Time['ing']) :?>
    <li>
         <a href="<?=$_Azure['link']?>upload/download/LDC_Day5일차.pdf" target="_blank">
           <img src="https://aocr2022-event.ezv.kr/upload/download/ldc_5.png" alt="">
		   <span>Live Diagnosis Challenge total commentary Book_Day 5</span>
        </a>
    </li>
    <?php endif;?>

	<!--	Case of the day ★9월23일(금) 오후 8시 이후부터 확인 가능★ -->
    <?php if(strtotime("2022-09-23 20:00:00") <= $_Time['ing']) :?>
    <li>
         <a href="<?=$_Azure['link']?>upload/download/KCR-Case of the Day.pdf" target="_blank">
           <img src="https://aocr2022-event.ezv.kr/upload/download/case.png" alt="">
		   <span>Case of the Day total commentary Book</span>
        </a>
    </li>
    <?php endif;?>

	<!--Image Interpretation Session commentary book ★9월 22일(목) 오후 4시 이후부터 오픈★ -->
    <?php if(strtotime("2022-09-22 16:00:00") <= $_Time['ing']) :?>
	<li>
         <a href="<?=$_Azure['link']?>upload/download/AOCR-KCR 2022_Answers for IImage Interpretation Session.pdf" target="_blank">
             <img src="https://aocr2022-event.ezv.kr/upload/download/imgae.png" alt="">
        </a>
		<span>Image Interpretation Session</span>
    </li>
    <?php endif;?>
</ul>

 