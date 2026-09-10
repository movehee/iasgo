<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	$ex_result =  explode("✚",$result);

	$fail_cnt = 0;

	if($kind=="poster"){
		$field_arr = array("category","category_sub","poster_number","code","subject","country","presenter_email","presenter","presenter_aff",
			"co"
		);
		$fail_tr = array("번호","제목","이유"); //실패 목록

		for($i=1;$i<count($ex_result);$i++){
			$ex_name = explode("|::|",$ex_result[$i]);

			for($n=1;$n<count($ex_name);$n++){
				$field_names[$n] = $field_arr[$n-1];
				// echo $field_names[$n]."<br>";
			}
			
			
			
			if(trim($ex_name[3])){ //포스터번호 없으면 저장안되도록
				$ssid = $conn->getOne("select sid from e_poster where del='N' and REPLACE(replace(LOWER(poster_number),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[3]))."'"); //포스터넘버가 있는지 검사
				if($ssid){ //있으면 업데이트
					$query = "update e_poster set del='N'";
				}else{ //없으면 신규등록
					$query = "insert into e_poster set del='N'";
				}


				$author_arr = $aff_arr = array();

				for($n=1;$n<count($field_arr)+1;$n++){			
					
					if($field_names[$n]=="category"){ //등록하려는 카테고리가 이미 있는지 확인
						$category_sid = $conn->getOne("select sid from e_poster_category where del='N' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[$n]))."'");
						if($category_sid){
							$field_val = $category_sid;
						}else{
							$max_num = $conn->getOne("select max(sort_num) from e_poster_category where depth='1'  and del='N'");
							if(!$max_num){
								$max_num=1;
							}else{
								$max_num=$max_num+1;
							}
							$c_query = "insert into e_poster_category set title='$ex_name[$n]', depth='1', sort_num=($max_num)";
							$c_result = $conn->query($c_query);
							
							$field_val = $conn->getOne("select sid from e_poster_category where del='N' and depth='1' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[$n]))."'");
							$category_sid = $field_val;
						}
						$query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
					}else if($field_names[$n]=="category_sub"){
						$category_sid = $conn->getOne("select sid from e_poster_category where del='N' and depth='1' and sid='".$category_sid."'");
						$category_sub_sid = $conn->getOne("select sid from e_poster_category where del='N' and depth='2' and psid='$category_sid' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[$n]))."'");

						if($category_sub_sid){
							$field_val = $category_sub_sid;
						}else{
							$max_num_sub = $conn->getOne("select max(sort_num) from e_poster_category where psid='$category_sid' and depth='2' and del='N'");
							
							if(!$max_num_sub){
								$max_num_sub=1;
							}else{
								$max_num_sub=$max_num_sub+1;
							}
							$c2_query = "insert into e_poster_category set title='$ex_name[$n]', psid='$category_sid', depth='2', sort_num=($max_num_sub)";
							$c2_result = $conn->query($c2_query);
							//echo $c2_query."<br>";
							
							$field_val = $conn->getOne("select sid from e_poster_category where del='N' and depth='2' and psid='$category_sid' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[$n]))."'");
						}

						$query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";

					} else if($field_names[$n]=="co") {
						
						for($nn=0; $nn<11; $nn++) { //nn : author 숫자
							
							$co_no = $n+($nn*2);
							if(trim($ex_name[$co_no])) {
								$author_arr[] = addslashes(trim(str_replace('\"',"",$ex_name[$co_no]))) . "<sup>" . $ex_name[$co_no+1] . "</sup>";	
							}

						}

						$af_start_no = $n + ($nn*2);

						for($nn=0; $nn<6; $nn++) { //nn : author 숫자
							
							$af_no = $af_start_no+$nn;

							if(trim($ex_name[$af_no])) {
								$aff_arr[] = addslashes(trim(str_replace('\"',"",$ex_name[$af_no]))) . "<sup>" . ($nn+1) . "</sup>";
							}
						}

						if(count($author_arr))	$query .= ", author='".implode(", ", $author_arr)."'";
						if(count($aff_arr))	$query .= ", affiliation='".implode(", ", $aff_arr)."'";


						// $query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
					} else {
						$field_val = $ex_name[$n];
						$query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
					}


					
				}
				if($ssid){
					$query .= " where sid='$ssid'";
				}


				
				$result = $conn->query($query);
				if(DB::isError($result)) {
					die($result->getMessage());
				}
			}else{
				$fail_cnt++;
				$fail_td1[] = $fail_cnt; 
				$fail_td2[] = $ex_name[4];
				$fail_td3[] = "포스터 번호가 누락되었습니다.";
			}
		}
	
	}else if($kind=="poster_category"){
		$field_arr = array("title","sub_category");
		$fail_tr = array("번호","이유"); //실패 목록

		for($i=1;$i<count($ex_result);$i++){
			$ex_name = explode("|::|",$ex_result[$i]);

			for($n=1;$n<count($ex_name);$n++){
				$field_names[$n] = $field_arr[$n-1];
				//echo $field_names[$n]."<br>";
			}
			
			if(trim($ex_name[1])){ //메인 카테고리 없으면 등록안됨.
				
				$category_sid = $conn->getOne("select sid from e_poster_category where del='N' and depth='1' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'");
				
				if($category_sid){
					$category = $category_sid;
				}else{
					$max_num = $conn->getOne("select max(sort_num) from e_poster_category where depth='1' and del='N'");
					if(!$max_num){
						$max_num=1;
					}else{
						$max_num=$max_num+1;
					}

					$query = "insert into e_poster_category set title='".addslashes(trim(str_replace('\"',"",$ex_name[1])))."', depth='1', sort_num='$max_num'";
					$result = $conn->query($query);
					$category_sid = mysql_insert_id();
				}

				$category_sid_sub = $conn->getOne("select sid from e_poster_category where del='N' and depth='2' and psid='$category_sid' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[2]))."'");

				if(!$category_sid_sub){

					$max_num_sub = $conn->getOne("select max(sort_num) from e_poster_category where psid='$category_sid' and depth='2' and del='N'");	
					if(!$max_num_sub){
						$max_num_sub=1;
					}else{
						$max_num_sub=$max_num_sub+1;
					}

					$query2 = "insert into e_poster_category set psid='$category_sid'";
					$query2 .= ", depth='2'";
					$query2 .= ", sort_num='$max_num_sub'";
					$query2 .= ", title='".addslashes(trim(str_replace('\"',"",$ex_name[2])))."'";
					$result2 = $conn->query($query2);
				}
			}

		}
	}else if($kind=="booth"){
	
		$field_arr = array("booth_sid","title","op1","op2","op3","op4","op5","op6","id");
		$fail_tr = array("번호","부스명","이유"); //실패 목록

		for($i=1;$i<count($ex_result);$i++){
			$ex_name = explode("|::|",$ex_result[$i]);

			for($n=1;$n<count($ex_name);$n++){
				$field_names[$n] = $field_arr[$n-1];
				//echo $field_names[$n]."<br>";
			}


			if(trim($ex_name[2])){ //부스명 없으면 저장안되도록
				$ssid = $conn->getOne("select sid from booth where del='N' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[2]))."'"); //부스명 있는지 검사
				if($ssid){ //있으면 업데이트
					$query = "update booth set del='N'";
				}else{ //없으면 신규등록
					$query = "insert into booth set del='N'";
				}
				for($n=1;$n<count($ex_name);$n++){
					if($field_names[$n]=="booth_sid"){ //등록하려는 등급이 이미 있는지 확인
						$booth_sid = $conn->getOne("select sid from booth_grade where del='N' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[$n]))."'");
						if($booth_sid){
							$field_val = $booth_sid;
						}else{
							$max_num = $conn->getOne("select max(sort_num) from booth_grade where del='N'");
							if(!$max_num){
								$max_num=1;
							}else{
								$max_num=$max_num+1;
							}
							$c_query = "insert into booth_grade set title='$ex_name[$n]', sort_num=($max_num)";
							$c_result = $conn->query($c_query);

							$booth_sid = mysql_insert_id();
							$field_val = $booth_sid;
						}
					}else{
						$field_val = $ex_name[$n];
					}
					$query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
				}
				if($ssid){
					$query .= " where sid='$ssid'";
				}
				$result = $conn->query($query);
				if(DB::isError($result)) {
					die($result->getMessage());
				}
			}else{
				$fail_cnt++;
				$fail_td1[] = $fail_cnt; 
				$fail_td2[] = "";
				$fail_td3[] = "부스명이 누락되었습니다.";
			}

		}


	}else if($kind=="booth_grade"){
		$field_arr = array("title");
		$fail_tr = array("번호","등급","이유"); //실패 목록
		for($i=1;$i<count($ex_result);$i++){
			$ex_name = explode("|::|",$ex_result[$i]);

			for($n=1;$n<count($ex_name);$n++){
				$field_names[$n] = $field_arr[$n-1];
				//echo $field_names[$n]."<br>";
			}
			
			
			
			if(trim($ex_name[1])){ //등급명 없으면 등록안됨.
				$ssid = $conn->getOne("select sid from booth_grade where del='N' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'"); //포스터넘버가 있는지 검사
				if(!$ssid){
					$query = "insert into booth_grade set del='N'";
					for($n=1;$n<count($ex_name);$n++){
						$field_val = $ex_name[$n];
						$query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
					}
					$result = $conn->query($query);
					if(DB::isError($result)) {
						die($result->getMessage());
					}
				}else{
					$fail_cnt++;
					$fail_td1[] = $fail_cnt; 
					$fail_td2[] = $ex_name[1];
					$fail_td3[] = "이미 등록되어있는 등급입니다.";
				}
			}
		}
	}else if($kind=="sessions"){
		
		$field_arr = array("ev_date","times","room","part","part2","code","code_title","lang","difficulty","title","chair","chair_code","chair2","chair_code2","chair3","chair_code3","chair4","chair_code4","info");

		$fail_tr = array("번호","부스명","이유"); //실패 목록

		$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
		$date_count = date("d",$chkdate);
		$ex_sdate = explode("-",$_Webinar['sdate']);

		
		for($dd=0;$dd<$date_count;$dd++){
			$ev_key[] = date("Y-m-d",strtotime("+".$dd." day",strtotime($_Webinar['sdate'])));
		}

		for($i=1;$i<count($ex_result);$i++){
			
			$ex_name = explode("|::|",$ex_result[$i]);
			for($n=1;$n<count($ex_name);$n++){
				$field_names[$n] = $field_arr[$n-1];
			}

			
			
			if(trim($ex_name[10])){ //세션명이 없으면 저장안되도록
				
				if(strpos($ex_name[2],"-")){
					$ex_time = explode("-",preg_replace("/\s+/", "",$ex_name[2]));
				}else if(strpos($ex_name[$n],"~")){
					$ex_time = explode("~",preg_replace("/\s+/", "",$ex_name[2]));
				}
				$ssid = $conn->getOne("select sid from workshop_session_tbl where REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[10]))."' and REPLACE(replace(LOWER(ev_date),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."' and REPLACE(replace(LOWER(stime),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_time[0]))."' and REPLACE(replace(LOWER(etime),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_time[1]))."' and REPLACE(replace(LOWER(room),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_time[3]))."' and del='N'");

				
				
				if($ssid){
					$query = "update workshop_session_tbl set del='N'";
				}else{
					$query = "insert into workshop_session_tbl set sort_num='$i'";
				}
				

				for($n=1;$n<count($ex_name);$n++){
					if($field_names[$n]=="room"){
					
						$room_sid = $conn->getOne("select sid from workshop_session_category where kind='P' /*and del='N'*/ and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[$n]))."'");
						if($room_sid){
							$field_val = $room_sid;
						}else{
							$room_query = "insert into workshop_session_category set kind='P', title='$ex_name[$n]'";
							$room_result = $conn->query($room_query);
							if(!$room_result) {die($conn->error);}
							//$field_val = mysqli_insert_id($conn);
							$field_val = $conn->getOne("select sid from workshop_session_category where kind='P' and del='N' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[$n]))."'");
						}
					}else if($field_names[$n]=="ev_date"){
						$field_val = array_search($ex_name[$n],$ev_key)+1;
					}else if($field_names[$n]=="times"){
						if(strpos($ex_name[$n],"-")){
							$ex_time = explode("-",preg_replace("/\s+/", "",$ex_name[$n]));
						}else if(strpos($ex_name[$n],"~")){
							$ex_time = explode("~",preg_replace("/\s+/", "",$ex_name[$n]));
						}
					}else{
						$field_val = $ex_name[$n];
					}


					if($field_names[$n]=="times"){
						$query .= ", stime='".addslashes($ex_time[0])."', etime='".addslashes($ex_time[1])."'";
					}else{
						$query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
					}
				}
				if($ssid){
					$query .= " where sid='$ssid' and del='N'";
				}
				$result = $conn->query($query);
				if(DB::isError($result)) {
					die($result->getMessage());
				}
			}
		}
	}else if($kind=="session_detail"){
		
		$field_arr = array("ev_date","detail_time","room","pt_time","title","author","author_position_co","abs_num","invited_num","pre_num");


		$fail_tr = array("번호","부스명","이유"); //실패 목록

		$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
		$date_count = date("d",$chkdate);
		$ex_sdate = explode("-",$_Webinar['sdate']);


		
		
		for($dd=0;$dd<$date_count;$dd++){
			$ev_key[] = date("Y-m-d",strtotime("+".$dd." day",strtotime($_Webinar['sdate'])));
		}

		
		
		for($i=1;$i<count($ex_result);$i++){
			
			$ex_name = explode("|::|",$ex_result[$i]);
			for($n=1;$n<count($ex_name);$n++){
				$field_names[$n] = $field_arr[$n-1];
			}
			
			unset($sub_query);

			for($n=1;$n<count($ex_name);$n++){
				
				if($n==1){
					$session_date = array_search($ex_name[1],$ev_key)+1; //행사일 키값 구함.
					//대 세션에 등록된 시간과 동일한 값이 있는 확인하기 위해서 explode.
					if(strpos($ex_name[2],"-")){
						$ex_time = explode("-",preg_replace("/\s+/", "",$ex_name[2]));
					}else if(strpos($ex_name[2],"~")){
						$ex_time = explode("~",preg_replace("/\s+/", "",$ex_name[2]));
					}
					/*echo $ex_name[2].'<<<br>';
					echo $ex_time[0].'<br>';
					echo $ex_time[1].'<br>';*/
					//장소의 sid 값 구해옴.
					$room_sid = $conn->getOne("select sid from workshop_session_category where kind='P' /*and del='N'*/ and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[3]))."'");
					
					//위에서 구한, 행사일, 시간, 방정보를 가지고 현재 등록된 세션의 key값을 구해옴.
					$session_chk = "select sid from workshop_session_tbl where ev_date='$session_date' and del='N' ";
					$session_chk .= " and REPLACE(replace(LOWER(stime),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_time[0]))."'";
					$session_chk .= " and REPLACE(replace(LOWER(etime),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_time[1]))."'";
					$session_chk .= " and room='$room_sid'";
					$session_sid = $conn->getOne($session_chk);
				}
		
				//echo $session_chk.'<br>';
				//echo $session_sid.'<br>';
				
				
				if($field_names[$n]!="room" && $field_names[$n]!="detail_time"){
					if($field_names[$n]=="ev_date"){
						$session_evdate = $ex_name[$n];
						$session_date = array_search($ex_name[$n],$ev_key);
						$sub_query .= ", session_sid='$session_sid'";
					}else if($field_names[$n]=="pt_time"){
						
						unset($ex_pt_time);
						unset($min_gab);
						unset($min);
						
						if(strpos($ex_name[$n],"-")){
							$ex_pt_time = explode("-",preg_replace("/\s+/", "",$ex_name[$n]));
						}else if(strpos($ex_name[$n],"~")){
							$ex_pt_time = explode("~",preg_replace("/\s+/", "",$ex_name[$n]));
						}
						$detail_time = $ex_name[$n];
						$detail_stime = $session_evdate." ".$ex_pt_time[0];
						$detail_etime = $session_evdate." ".$ex_pt_time[1];
						$min_gab = strtotime($detail_etime)-strtotime($detail_stime);
						$min = ($min_gab/60);
						$sub_query .= ", detail_time='".$ex_name[$n]."', pt_time='".$min."'";

					}else if($field_names[$n]=="part"){
						$part1 = addslashes(trim(str_replace(" "," ",str_replace('\"',"",$ex_name[$n]))));
					}else if($field_names[$n]=="part2"){
						$part2 = addslashes(trim(str_replace(" "," ",str_replace('\"',"",$ex_name[$n]))));
					}else if($field_names[$n]=="title"){
						$lec_title = addslashes(trim(str_replace(" "," ",str_replace('\"',"",author_replace($ex_name[$n])))));
						$sub_query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$ex_name[$n])))."'";
					}else if($field_names[$n]=="author" || $field_names[$n]=="author_co" || $field_names[$n]=="author_position_co"){
						$sub_query .= ", $field_names[$n]='".author_replace(addslashes(trim(str_replace('\"',"",$ex_name[$n]))))."'";
					}else{
						$sub_query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$ex_name[$n])))."'";
					}
				}
			}


			

			$chking = "select sid from workshop_session_detail_tbl where del='N' ";
			$chking .= " and session_sid='$session_sid'";
			$chking .= " and REPLACE(replace(LOWER(detail_time),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($detail_time))."'";
			$chksid = $conn->getOne($chking);

			if(!$chksid){
				$query = "insert into workshop_session_detail_tbl set sort_num='$i'" .$sub_query;
			}else{
				$detail_sid = $conn->getOne("select sid from workshop_session_detail_tbl where session_sid='$session_sid' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($lec_title))."' and del='N'");

				$query = "update workshop_session_detail_tbl set sort_num='$i'" .$sub_query;
				$query .= " where sid='$chksid'";
			}
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($query);
			}
		}

	}else if($kind=="registration"){
		include_once dirname(__FILE__).'/lib.registration_import.php';

		$fail_tr = array("번호","ID(Email)","성명","이유");
		$fail_td1 = array();
		$fail_td2 = array();
		$fail_td3 = array();
		$fail_td4 = array();

		// upload.php column order (1-based after row header)
		// 1등록번호 2ID(Email) 3Password 4Country 5FullName 6First 7Last
		// 8Affiliation 9Mobile 10Department 11성명국문 12면허 13그외소속 14소속국문
		// 15구분 16소속선택 17무료 18등록유형 19등록결제시기 20등록비
		// 21결제상태 22결제방법 23결제일자 24참석일수 25사교행사 26워크샵 27메모 28VIP 29리본 30DESK

		for ($i = 1; $i < count($ex_result); $i++) {
			$ex_name = explode('|::|', $ex_result[$i]);

			$email = isset($ex_name[2]) ? preg_replace('/\s+/', '', trim($ex_name[2])) : '';
			$nameKr = isset($ex_name[11]) ? trim($ex_name[11]) : '';
			$nameEng = isset($ex_name[5]) ? trim($ex_name[5]) : '';
			$firstName = isset($ex_name[6]) ? trim($ex_name[6]) : '';
			$lastName = isset($ex_name[7]) ? trim($ex_name[7]) : '';
			if ($nameEng == '' && ($firstName != '' || $lastName != '')) {
				$nameEng = trim($firstName.' '.$lastName);
			}

			if ($email == '') {
				$fail_cnt++;
				$fail_td1[] = $fail_cnt;
				$fail_td2[] = '';
				$fail_td3[] = $nameKr != '' ? $nameKr : $nameEng;
				$fail_td4[] = 'ID(Email)이 없습니다.';
				continue;
			}
			if ($nameKr == '' && $nameEng == '') {
				$fail_cnt++;
				$fail_td1[] = $fail_cnt;
				$fail_td2[] = $email;
				$fail_td3[] = '';
				$fail_td4[] = '성명(국문/영문)이 없습니다.';
				continue;
			}

			$isoCode = '';
			$countryInfo = regImportCountry(isset($ex_name[4]) ? $ex_name[4] : '', $isoCode);
			$country = $countryInfo['country'];
			$countryName = $countryInfo['name'];
			$isDomestic = ($country == 'K');

			$gubun1Info = regImportGubun(
				isset($ex_name[15]) ? $ex_name[15] : '',
				isset($_ONSITE['gubun1']) ? $_ONSITE['gubun1'] : array()
			);
			$gubun2Map = $isDomestic
				? (isset($_ONSITE['gubun2_kor']) ? $_ONSITE['gubun2_kor'] : array())
				: (isset($_ONSITE['gubun2_eng']) ? $_ONSITE['gubun2_eng'] : array());
			$gubun2Info = regImportGubun(isset($ex_name[16]) ? $ex_name[16] : '', $gubun2Map);

			$title = regImportFeeCode(isset($ex_name[18]) ? $ex_name[18] : '', $isDomestic);
			$classification = regImportClassification(isset($ex_name[19]) ? $ex_name[19] : '');
			$regFee = regImportFeeNumber(isset($ex_name[20]) ? $ex_name[20] : '');
			$freeYn = regImportYn(isset($ex_name[17]) ? $ex_name[17] : '');
			if ($freeYn == '' && $regFee !== '' && (float)$regFee == 0) {
				$freeYn = 'Y';
			}

			$payStatus = regImportPayStatus(isset($ex_name[21]) ? $ex_name[21] : '');
			$payMethod = regImportPayMethod(isset($ex_name[22]) ? $ex_name[22] : '');
			$payDate = isset($ex_name[23]) ? trim($ex_name[23]) : '';

			$attend = regImportAttendDays(isset($ex_name[24]) ? $ex_name[24] : '');
			$banquet = regImportBanquet(isset($ex_name[25]) ? $ex_name[25] : '');
			$lunch = regImportLunch(isset($ex_name[26]) ? $ex_name[26] : '');

			$rowData = array(
				'etc_field2' => isset($ex_name[1]) ? trim($ex_name[1]) : '',
				'id' => $email,
				'email' => $email,
				'passwd' => isset($ex_name[3]) ? trim($ex_name[3]) : '',
				'country' => $country,
				'group_key' => $country,
				'etc_field1' => $countryName,
				'etc_field4' => $isoCode,
				'name_eng' => $nameEng,
				'first_name' => $firstName,
				'last_name' => $lastName,
				'aff_eng' => isset($ex_name[8]) ? trim($ex_name[8]) : '',
				'cell' => isset($ex_name[9]) ? trim($ex_name[9]) : '',
				'depart_eng' => isset($ex_name[10]) ? trim($ex_name[10]) : '',
				'name_kr' => $nameKr,
				'license_number' => isset($ex_name[12]) ? trim($ex_name[12]) : '',
				'aff_kor_etc' => isset($ex_name[13]) ? trim($ex_name[13]) : '',
				'aff_kor' => isset($ex_name[14]) ? trim($ex_name[14]) : '',
				'gubun1' => $gubun1Info[0],
				'etc_field3' => $gubun1Info[1],
				'gubun2' => $gubun2Info[0],
				'title_sub' => $gubun2Info[1],
				'free_yn' => $freeYn,
				'title' => $title,
				'classification' => $classification,
				'reg_fee' => $regFee,
				'pay_status' => $payStatus,
				'etc_field5' => $payMethod,
				'pay_date' => $payDate,
				'login1' => $attend[0],
				'login2' => $attend[1],
				'login3' => $attend[2],
				'banquet' => $banquet,
				'lunch' => $lunch,
				'memo' => isset($ex_name[27]) ? trim($ex_name[27]) : '',
				'etc_field8' => regImportYn(isset($ex_name[28]) ? $ex_name[28] : ''),
				'etc_field6' => isset($ex_name[29]) ? trim($ex_name[29]) : '',
				'etc_field7' => regImportDesk(isset($ex_name[30]) ? $ex_name[30] : '')
			);

			$existRow = $conn->getRow(
				"SELECT * FROM registration_tbl WHERE del = 'N' AND (id = ? OR email = ?) ORDER BY sid DESC LIMIT 1",
				array($email, $email),
				DB_FETCHMODE_ASSOC
			);
			if (DB::isError($existRow)) {
				error_log('[ExcelReg] select failed: '.$existRow->getMessage());
				die($existRow->getMessage());
			}
			$existSid = ($existRow && isset($existRow['sid'])) ? (int)$existRow['sid'] : 0;

			if ($existSid) {
				$setParts = array();
				$params = array();
				$diffParts = array();
				foreach ($rowData as $col => $val) {
					if ($val === '' || $val === null) {
						continue;
					}
					// 비밀번호는 로그에 남기지 않음
					if ($col != 'passwd') {
						$oldVal = isset($existRow[$col]) ? (string)$existRow[$col] : '';
						if ($oldVal !== (string)$val) {
							$diffParts[] = $col.': '.$oldVal.'→'.$val;
						}
					}
					$setParts[] = $col.' = ?';
					$params[] = $val;
				}
				if ($setParts) {
					$params[] = $existSid;
					$query = 'UPDATE registration_tbl SET '.implode(', ', $setParts).' WHERE sid = ?';
					$result = $conn->query($query, $params);
					if (DB::isError($result)) {
						error_log('[ExcelReg] update failed: sid='.$existSid.' '.$result->getMessage());
						die($result->getMessage());
					}
					if ($diffParts) {
						$summary = implode('; ', $diffParts);
						if (strlen($summary) > 500) {
							$summary = substr($summary, 0, 500).'...';
						}
						regLogWrite($existSid, 'update', 'excel', array(
							'(excel)' => array('', $summary)
						));
					}
				}
			} else {
				$rowData['del'] = 'N';
				$rowData['status'] = 'Y';
				$rowData['etc_field9'] = 'PRE';
				if ($rowData['pay_status'] == '') {
					$rowData['pay_status'] = 'N';
				}
				if ($rowData['classification'] == '') {
					$rowData['classification'] = 'B';
				}
				if ($rowData['free_yn'] == '') {
					$rowData['free_yn'] = ($rowData['reg_fee'] !== '' && (float)$rowData['reg_fee'] == 0) ? 'Y' : 'N';
				}

				$cols = array();
				$placeholders = array();
				$params = array();
				foreach ($rowData as $col => $val) {
					$cols[] = $col;
					$placeholders[] = '?';
					$params[] = $val;
				}
				$query = 'INSERT INTO registration_tbl ('.implode(', ', $cols).') VALUES ('.implode(', ', $placeholders).')';
				$result = $conn->query($query, $params);
				if (DB::isError($result)) {
					error_log('[ExcelReg] insert failed: email='.$email.' '.$result->getMessage());
					die($result->getMessage());
				}
				$newSid = (int)mysql_insert_id();
				if ($newSid > 0) {
					$newLabel = $nameKr != '' ? $nameKr : $nameEng;
					if ($newLabel == '') {
						$newLabel = $email;
					}
					regLogWrite($newSid, 'insert', 'excel', array(
						'(excel)' => array('', $newLabel)
					));
				}
			}
		}

	}else if($kind=="exam"){
		
		$field_arr = array("question","que1","que2","que3","que4","que5","answer","commentary");
		$fail_tr = array("번호","name_kr","license_number","이유"); //실패 목록

		$exam_num=1;
		$max_num = $conn->getOne("select max(exam_num) from exam_tbl where day='$chkday' and del='N'");
		if($max_num){
			$exam_num=$max_num+1;
		}

		for($i=1;$i<count($ex_result);$i++){
			$ex_name = explode("|::|",$ex_result[$i]);

			for($n=1;$n<count($ex_name);$n++){
				$field_names[$n] = $field_arr[$n-1];
				//echo $field_names[$n]."<br>";
			}

			if(strlen($ex_name[7])>1){
				$exam_kind = "K";
			}else{
				$exam_kind = "A";
			}

			
			$query = "insert into exam_tbl set kind='$chkkind', exam_kind='$exam_kind', day='$chkday', exam_num='$exam_num',category='$category'";
			if(trim($ex_name[1])){ 
				for($n=1;$n<count($ex_name);$n++){
					$field_val = $ex_name[$n];
					$query .= ", $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
				}
			}
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}

			$exam_num++;
			
		}
		
	}else if($kind=="faculty_list"){
		
		$field_arr = array("pnum","faculty_name","faculty_aff","faculty_kind","faculty_country","category","category_sub","award","faculty_email");
		
		for($i=1;$i<count($ex_result);$i++){
			$ex_name = explode("|::|",$ex_result[$i]);
			for($n=1;$n<count($ex_name);$n++){
				$field_names[$n] = $field_arr[$n-1];
			}
			
			unset($query_arr);
			
			$insert_sid = $conn->getOne("select sid from faculty_tbl where REPLACE(replace(LOWER(faculty_name),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[2]))."' and REPLACE(replace(LOWER(faculty_aff),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[3]))."'");
			
			if(!$insert_sid){
				$query = "insert into faculty_tbl set ";
				for($n=1;$n<count($ex_name);$n++){
					if($field_names[$n]!="faculty_kind" && $field_names[$n]!="faculty_kind" && $field_names[$n]!="category" && $field_names[$n]!="category_sub"){
						if($field_names[$n]=="faculty_kind"){
							$field_val = array_search(trim(strtolower($ex_name[4])),array_map('strtolower',$_Faculty['role']));
							$query_arr[] = " $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
						}else if($field_names[$n]=="pnum"){
							$field_val = $ex_name[$n];
							$query_arr[] = " faculty_code='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
						}else if($field_names[$n]=="award"){
							$field_val = array_search(trim(strtolower($ex_name[8])),array_map('strtolower',$_Faculty['award']));
							if(!$field_val) $field_val = addslashes($ex_name[8]);
							$query_arr[] = " award_kind='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
							if($field_val){
								$query_arr[] = " award='Y'";
							}
						}else{
							$field_val = $ex_name[$n];
							$query_arr[] = " $field_names[$n]='".addslashes(trim(str_replace('\"',"",$field_val)))."'";
						}
					}

				}
				$submit_query = $query.implode(",",$query_arr);
				$submit_result = $conn->query($submit_query);
				
				if(DB::isError($submit_result)) {
					die($submit_result->getMessage());
				}
				$insert_sid = mysql_insert_id();
			} else {

				$query = "update faculty_tbl set faculty_code = concat(faculty_code, ',', '".$ex_name[1]."') where sid=" . $insert_sid;
				$conn->query($query);
			}


			for($n=1;$n<count($ex_name);$n++){
				if($field_names[$n]=="pnum"){
					unset($category_sid);
					unset($category_sub_sid);

					if(trim($ex_name[4])){ 
						$role_chk = $conn->getOne("select sid from faculty_role_tbl where REPLACE(replace(LOWER(role_title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[4]))."'");
						if($role_chk){
							$role_val = $role_chk;
						}else{
							$r_query = "insert into faculty_role_tbl set role_title='".$ex_name[4]."'";
							// echo $r_query;
							// echo "<br>";
							// print_r($ex_name);
							// exit;
							$r_result = $conn->query($r_query);
							$role_val = mysql_insert_id();
						}
					}
					if(trim($ex_name[6])){ //category
						$category_sid = $conn->getOne("select sid from faculty_category where del='N' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[6]))."'");
						if(!$category_sid){

							// echo "select sid from faculty_category where del='N' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[6]))."'";
							// echo "<br>";
							// print_r($ex_name);
							// exit;
							$max_num = $conn->getOne("select max(sort_num) from faculty_category where depth='1'  and del='N'");
							if(!$max_num){
								$max_num=1;
							}else{
								$max_num=$max_num+1;
							}
							$c_query = "insert into faculty_category set title='".trim($ex_name[6])."', depth='1', sort_num='$max_num'";
							$c_result = $conn->query($c_query);
							$category_sid = mysql_insert_id();
						}
					}
					if(trim($ex_name[7])){ //category_sub
						$category_sub_sid = $conn->getOne("select sid from faculty_category where del='N' and depth='2' and psid='$category_sid' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[7]))."'");

						//echo "select sid from faculty_category where del='N' and depth='2' and psid='$category_sid' and REPLACE(replace(LOWER(title),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[7]))."'<br>";
						//echo $ex_name[7].'!!!!!<br>';
						
						if(!$category_sub_sid){
							$max_num_sub = $conn->getOne("select max(sort_num) from faculty_category where psid='$category_sid' and depth='2' and del='N'");
							if(!$max_num_sub){
								$max_num_sub=1;
							}else{
								$max_num_sub=$max_num_sub+1;
							}
							$c2_query = "insert into faculty_category set title='".trim($ex_name[7])."', psid='$category_sid', depth='2', sort_num='$max_num_sub'";
							$c2_result = $conn->query($c2_query);
							$category_sub_sid = mysql_insert_id();
						}

					}
					

					//$role_val = array_search(trim(strtolower($ex_name[4])),array_map('strtolower',$_Faculty['role']));
					
					if($ex_name[1]){
						$session_query = "select sid,session_sid from workshop_session_detail_tbl where REPLACE(replace(LOWER(pre_num),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'";
						$session_query .= " or REPLACE(replace(LOWER(author_code),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'";
						$session_query .= " or REPLACE(replace(LOWER(author_code2),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'";
						$session_result = $conn->query($session_query);
						$session_result->fetchInto(&$ss,DB_FETCHMODE_ASSOC);
						$session_result->free();
						
						if(!$ss['sid']){
							$session_query = "select sid from workshop_session_tbl where REPLACE(replace(LOWER(chair_code),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'";
							$session_query .= " or REPLACE(replace(LOWER(chair_code2),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'";
							$session_query .= " or REPLACE(replace(LOWER(chair_code3),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'";
							$session_query .= " or REPLACE(replace(LOWER(chair_code4),' ',''),'\r\n','')='".preg_replace("/\s+/", "",strtolower($ex_name[1]))."'";
							$session_result = $conn->query($session_query);
							$session_result->fetchInto(&$ss,DB_FETCHMODE_ASSOC);
							$session_result->free();

							$ss['session_sid'] = $ss['sid'];
							unset($ss['sid']);
						}

					}else{
						unset($ss['session_sid']);
						unset($ss['sid']);
					}
					
					$query2 = "insert into faculty_matching set faculty_sid='$insert_sid'";
					$query2 .= ", session_sid='".$ss['session_sid']."'";
					$query2 .= ", session_detail_sid='".$ss['sid']."'";
					$query2 .= ", faculty_kind='".$role_val."'";
					$query2 .= ", category='".$category_sid."'";
					$query2 .= ", category_sub='".$category_sub_sid."'";
					
					
					$result2 = $conn->query($query2);
					if(DB::isError($result2)) {
						die($result2->getMessage());
					}

				}
			}
		}
	}

	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//exit;
	}

	$conn->disconnect();

	if($fail_cnt==0){
		PutMessageCloseOpenerReload("등록되었습니다.");
	}
?>
<?if($fail_cnt>0){?>
<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<table class="tblDef tblList">
	<tbody>
		<tr>
			<?foreach($fail_tr as $tkey=>$tval){?>
			<th><?=$tval?></th>
			<?}?>
		</tr>
		<?foreach($fail_td1 as $tkey=>$tval){?>
		<tr>
			<?foreach($fail_tr as $tskey=>$tsval){?>
			<td><?=${"fail_td".($tskey+1)}[$tkey]?></td>
			<?}?>
		</tr>
		<?}?>
	</tbody>
</table>
<?}?>