<?
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	
	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
		$setting_result = mysqli_query($conn, $setting_query);
		$setting_col = mysqli_fetch_array($setting_result);

	if(!$session_sid){
		if(!$tab){
			$result = mysqli_query($conn, "SELECT sid from agenda_tbl where eventdate='".mktime(0, 0, 0, date("m"), date("d"), date("y"))."' and code='".$code."' and del='N'");
			$row = mysqli_fetch_array($result);
			$tab = $row['sid'];

			if(!$tab){
				$result = mysqli_query($conn, "SELECT sid from agenda_tbl where code='".$code."' and del='N' order by sid asc limit 1");
				$row = mysqli_fetch_array($result);
				$tab = $row['sid'];
			}
		}

		$time_query = "select * from session_time_tbl where tab='".$tab."' and del='N' order by orderby asc";
		$time_result = mysqli_query($conn, $time_query);

		$query = "select a.*,t.time time_info, r.name room_info from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.tab='".$tab."' and a.viewYN='Y' and a.qna_viewYN = 'Y'";

		if($setting_col['question_lecture_view']=="1") {

			$query .= " and a.time in ('0'";

			while(is_array($time_col = mysqli_fetch_array($time_result))){
					
					if ( strpos($time_col['time'], "~") ) {
							$time_temp = explode('~', $time_col['time']);
					} else if ( strpos($time_col['time'], "-") ) {
						$time_temp = explode('-', $time_col['time']);
					}
				
				
					$plusTime = strtotime("+10 minutes");
					$minusTime = strtotime("-10 minutes");
					
					$staTime = date("H:i",strtotime($time_temp[0]));
					$endTime = date("H:i",strtotime($time_temp[1]));
					
		
					if($staTime<date("H:i" ,$plusTime ) && $endTime >date("H:i" , $minusTime)){
						$query .=",'".$time_col['sid']."'";
					}
				}
				$query .= ")";
		}

		if($code=='katrd2019') {
			$query .= " order by time, room";
		}

		if($_SERVER['REMOTE_ADDR']=='218.235.94.227') {
		//echo $query."<br>";

		}


		$result = mysqli_query($conn, $query);

		while(is_array($col = mysqli_fetch_array($result))){

			$json2 = null;
			$subquery = "SELECT * FROM session_tbl ";
			$subquery .= "  WHERE type = '2' and sub_session='0' ";
			if($col['link_session']){
				$subquery .= " and link_session = '".$col['link_session']."' ";
			}else{
				$subquery .= " and link_session = '".$col['sid']."' ";
			}
			$subquery .= " order by orderby asc ";

			$totalquery = str_replace("SELECT * FROM", "SELECT count(*) cnt FROM", $subquery);

			$totalresult=mysqli_query($conn, $totalquery);
			$totalcol = mysqli_fetch_array($totalresult);

			if($totalcol['cnt']>0){

				$subresult=mysqli_query($conn, $subquery);

				while(is_array($subcol = mysqli_fetch_array($subresult))){
					if($setting_col['faculty_type']==1){

						$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$subcol['sid']."' order by a.sid asc";

						$faculty_result=mysqli_query($conn, $faculty_query);
						$chair="";
						$i = 0;
						while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
							if($i!=0){
								$chair = $chair . ", ";
							}

							if($setting_col['faculty_style']==1){
								
									$chair .= $faculty_d['name'];
									$chair .= " (".$faculty_d['office'].")";
								
							}else if( $setting_col['faculty_style']==2 ){
								
									$chair .= $faculty_d['name'];
									$chair .= "(".$faculty_d['office'].", ".$faculty_d['country'].")";									
								
							} else {
									$chair .= $faculty_d['name'];
							}
							$i++;
						}
						
			
						
						if($code=='kse2019') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else if($code=='smc2019') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						}  else if($code=='kses191130') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else {
							$json2 [] = array(
							'sid'=>$subcol['sid'],
							'title'=>strip_tags($subcol['title']),
							'speaker'=>$chair,
							'etc_speaker'=>strip_tags($subcol['etc_speaker'])

						);	
						}
						
					}else{
						
		
						if($code=='allergy2019s') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>strip_tags($subcol['speaker']),
								'speaker'=>strip_tags($subcol['speaker']),
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else if($code=='smc2019') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($subcol['speaker'] == "" ? "" : $subcol['speaker']." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else if($code=='kses191130') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else{

						$json2 [] = array(
							'sid'=>$subcol['sid'],
							'title'=>strip_tags($subcol['title']),
							'speaker'=>strip_tags($subcol['speaker']),
							'etc_speaker'=>strip_tags($subcol['etc_speaker'])

							);
						}
					}

				}

				if($code=='katrd2019') {
					$theme = $col['theme']. " - ". $col['sub_theme'];
				}
				else {
					$theme = $col['theme'];
				}
				
				$json [] = array(
				'sid'=>$col['sid'],
				'room'=>$col['room'],
				'theme'=>strip_tags($theme),
				'sub'=>$json2
			);
			}
		}
	}else{
		$query = "select a.*,t.time time_info, r.name room_info from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.sid='".$session_sid."'";
	
		$result = mysqli_query($conn, $query);

		while(is_array($col = mysqli_fetch_array($result))){
			$json2 = null;
			$subquery = "SELECT * FROM session_tbl ";
			$subquery .= "  WHERE type = '2' and sub_session='0' ";
			if($col['link_session']){
				$subquery .= " and link_session = '".$col['link_session']."' ";
			}else{
				$subquery .= " and link_session = '".$col['sid']."' ";
			}
			$subquery .= " order by orderby asc ";

			$totalquery = str_replace("SELECT * FROM", "SELECT count(*) cnt FROM", $subquery);
			$totalresult=mysqli_query($conn, $totalquery);
			$totalcol = mysqli_fetch_array($totalresult);

			if($totalcol['cnt']>0){

				$subresult=mysqli_query($conn, $subquery);
				
				while(is_array($subcol = mysqli_fetch_array($subresult))){
					if($setting_col['faculty_type']==1){
						

						$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$subcol['sid']."' order by a.sid asc";
						
						$faculty_result=mysqli_query($conn, $faculty_query);
						$chair="";
						$i = 0;
						while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
							if($i!=0){
								$chair = $chair . ", ";
							}

							if($setting_col['faculty_style']==1){
								
									$chair .= $faculty_d['name'];
									$chair .= " (".$faculty_d['office'].")";									
							
							
							}else if($setting_col['faculty_style']==2){
								
									$chair .= $faculty_d['name'];
									$chair .= "(".$faculty_d['office'].", ".$faculty_d['country'].")";
								
							} else {
								
									$chair .= $faculty_d['name'];	
								
							}
							$i++;
						}
						
						if($code=='smc2019') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>strip_tags($subcol['speaker']),
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else if($code=='kses191130') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else if($code=='katrd2019') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else {
							$json2 [] = array(
							'sid'=>$subcol['sid'],
							'title'=>strip_tags($subcol['title']),
							'speaker'=>$chair,
							'etc_speaker'=>strip_tags($subcol['etc_speaker'])
							);	
						}
						
					}else{

						if($code=='smc2019') {

							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=> (strip_tags($subcol['speaker']) == "" ? "" : strip_tags($subcol['speaker'])." - ").strip_tags($subcol['title']),
								'speaker'=>strip_tags($subcol['speaker']),
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						}  else if($code=='kses191130') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						} else if($code=='katrd2019') {
							$json2 [] = array(
								'sid'=>$subcol['sid'],
								'title'=>($chair == "" ? "" : $chair." - ").strip_tags($subcol['title']),
								'speaker'=>$chair,
								'etc_speaker'=>strip_tags($subcol['etc_speaker'])
								);
						}else{
						$json2 [] = array(
							'sid'=>$subcol['sid'],
							'title'=>strip_tags($subcol['title']),
							'speaker'=>strip_tags($subcol['speaker']),
							'etc_speaker'=>strip_tags($subcol['etc_speaker'])
							);
						}
					}
				}

				if($code=='katrd2019') {
					$theme = $col['theme']. " - ". $col['sub_theme'];
				}
				else {
					$theme = $col['theme'];
				}

				$json [] = array(
				'sid'=>$col['sid'],
				'room'=>$col['room'],
				'theme'=>strip_tags($theme),
				'sub'=>$json2
			);

			}

		}
	}

	echo json_encode($json);
?>
