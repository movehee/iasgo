
<ul class="pdfList">
		<!-- 초록집 -->
     <li> 
	  <a href="<?=$_Azure['link']?>upload/download/abstract.pdf" target="_blank"> 
	   <img src="https://kcr4u-event.ezv.kr/upload/download/abstract.png" alt="">
	  			<span>Abstract Book</span>
	          </a>
	      </li>  
	<!-- 프로그램북 -->
    <li>
        <!-- <a href="<?=$_Azure['link']?>upload/download/program.pdf" target="_blank"> -->
		<a href="<?=$_Azure['link']?>upload/download/KCR 2023_Program Book.pdf" target="_blank">
            <img src="<?=$_Azure['link']?>upload/download/program.png" alt="">
			<span>Program Book</span>
        </a>
    </li>
	<!-- 사용 가이드라인 kor -->
    <li>
	<!--
      <a href="<?=$_Azure['link']?>upload/download/Guideline_kor.pdf" target="_blank"> -->
         <a href="<?=$_Azure['link']?>upload/download/KCR 2023_Guideline_kor.pdf" target="_blank">
            <img src="<?=$_Azure['link']?>upload/download/Guideline_kor.png" alt="">
			<span>Virtual Platform Guideline (KOR)</span>
        </a>
    </li>

<!-- 사용 가이드라인 eng -->
    <li> 
	 <!--  <a href="<?=$_Azure['link']?>upload/download/Guideline_eng.pdf" target="_blank"> -->
		  <a href="<?=$_Azure['link']?>upload/download/KCR 2023_Guideline_eng.pdf" target="_blank">
            <img src="<?=$_Azure['link']?>upload/download/Guideline_eng.png" alt="">
			<span>Virtual Platform Guideline (ENG)</span>	
        </a>
    </li>

	<!--LDC 퀴즈 정답지 _day1 ★(Day 1: 9월 20일(수)  15:50시 이후부터 확인 가능★ -->
    <?php if(strtotime("2023-09-20 15:50:00") <= $_Time['ing']) :?>
    <li style="clear: both; ">
         <a href="<?=$_Azure['link']?>upload/download/ldc1.pdf" target="_blank"> 
         		 <a href="<?=$_Azure['link']?>upload/download/ldc1.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/ldc1.png" alt="">
		   <span>Live Diagnosis Challenge commentary Book_Day 1</span>
        </a>
    </li>
    <?php endif;?>

	<!--LDC 퀴즈 정답지 _day2 ★ (Day 2: 9월 21일(목)  14:00시 이후부터확인 가능★ -->
    <?php if(strtotime("2023-09-21 14:00:00") <= $_Time['ing']) :?>
    <li>
        <!--  <a href="<?=$_Azure['link']?>upload/download/ldc2.pdf" target="_blank">
         		 --> 
         <a href="<?=$_Azure['link']?>upload/download/ldc2.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/ldc2.png" alt="">
		   <span>Live Diagnosis Challenge commentary Book_Day 2</span>
        </a>
    </li>
    <?php endif;?>

	<!--LDC 퀴즈 정답지 _day3 ★(Day 3: 9월 22일(금)  14:00이후부터 확인 가능★ -->
    <?php if(strtotime("2023-09-22 14:00:00") <= $_Time['ing']) :?>
    <li>
       <!--   <a href="<?=$_Azure['link']?>upload/download/ldc3.pdf" target="_blank">
	   -->
	   <a href="<?=$_Azure['link']?>upload/download/ldc3.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/ldc3.png" alt="">
		   <span>Live Diagnosis Challenge commentary Book_Day 3</span>
        </a>
    </li>
    <?php endif;?>

	<!--LDC 퀴즈 정답지 _day4 ★(Day 4: 9월 23일(토)  14:00 이후부터 확인 가능 //  마지막날은 통합해설지★ -->
    <?php if(strtotime("2023-09-23 14:00:00") <= $_Time['ing']) :?>
    <li><!-- 
         <a href="<?=$_Azure['link']?>upload/download/ldc4.pdf" target="_blank"> -->
		   <a href="<?=$_Azure['link']?>upload/download/ldc4.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/ldc4.png" alt="">
		   <span>Live Diagnosis Challenge commentary Book_Day 4</span>
        </a>
    </li>
    <?php endif;?>

		<!--LDC 퀴즈 정답지 _All ★(Day 4: 9월 23일(토)  14:00 이후부터 확인 가능 //  마지막날은 통합해설지★ -->
    <?php if(strtotime("2023-09-23 14:00:00") <= $_Time['ing']) :?>
    <li><!-- 
         <a href="<?=$_Azure['link']?>upload/download/ldc4.pdf" target="_blank"> -->
		   <a href="<?=$_Azure['link']?>upload/download/ldc.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/ldc.png" alt="">
		   <span>Live Diagnosis Challenge total<br>commentary Book</span>
        </a>
    </li>
    <?php endif;?>



	<!--	Case of the day _day1 ★9월20일(수) 17:30시 이후부터 확인 가능★ -->
    <?php if(strtotime("2023-09-20 17:30:00") <= $_Time['ing']) :?>
    <li style="clear: both; "><!-- 
    		 <a href="<?=$_Azure['link']?>upload/download/case1.pdf" target="_blank"> -->
         <a href="<?=$_Azure['link']?>upload/download/case1.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/case1.png" alt="">
		   <span>Case of the Day commentary Book_Day 1</span>
        </a>
    </li>
    <?php endif;?>

		<!--	Case of the day_day2 ★9월21일(목) 17:30시 이후부터 확인 가능★ -->
    <?php if(strtotime("2023-09-21 17:30:00") <= $_Time['ing']) :?>
    <li><!-- 
    		 <a href="<?=$_Azure['link']?>upload/download/case2.pdf" target="_blank"> -->
         <a href="<?=$_Azure['link']?>upload/download/case2.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/case2.png" alt="">
		   <span>Case of the Day commentary Book_Day 2</span>
        </a>
    </li>
    <?php endif;?>

		<!--	Case of the day_day3 ★9월22일(금) 17:30시 이후부터 확인 가능★ -->
    <?php if(strtotime("2023-09-22 17:30:00") <= $_Time['ing']) :?>
    <li><!-- 
    		 <a href="<?=$_Azure['link']?>upload/download/case3.pdf" target="_blank"> -->
         <a href="<?=$_Azure['link']?>upload/download/case3.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/case3.png" alt="">
		   <span>Case of the Day commentary Book_Day 3</span>
        </a>
    </li>
    <?php endif;?>

		<!--	Case of the day_day All ★9월22일(금) 17:30 이후부터 확인 가능★ -->
    <?php if(strtotime("2023-09-22 17:30:00") <= $_Time['ing']) :?>
    <li><!-- 
    		 <a href="<?=$_Azure['link']?>upload/download/case.pdf" target="_blank"> -->
         <a href="<?=$_Azure['link']?>upload/download/case.pdf" target="_blank">
           <img src="<?=$_Azure['link']?>upload/download/case.png" alt="">
		   <span>Case of the Day total<br> commentary Book</span>
        </a>
    </li>
    <?php endif;?>


	<!--Image Interpretation Session commentary book ★9월 20일(수)15 30시 이후부터 오픈★ -->
    <?php if(strtotime("2023-09-20 15:30:00") <= $_Time['ing']) :?>
	<li>
<!-- <a href="<?=$_Azure['link']?>upload/download/case.pdf" target="_blank"> -->
            <a href="<?=$_Azure['link']?>upload/download/Answers for Image Interpretation Session.pdf" target="_blank">
			 <img src="<?=$_Azure['link']?>upload/download/iis.png" alt="">
        </a>
			<span>Answers for Image <BR>Interpretation Session</span>
    </li>
    <?php endif;?>


</ul>

 