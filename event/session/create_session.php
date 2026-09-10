<?
	include_once $_SERVER['DOCUMENT_ROOT']."lib.php";
	procAdminLoginChk();
	
	$content = "<?\n";


	$gquery = "select  ev_date,room from workshop_session_tbl where del='N' group by ev_date,room order by ev_date asc, room asc, stime asc";
	$gresult=$conn->query($gquery);
	if(DB::isError($gresult)) die($gresult->getMessage());
	
	while ($g = $gresult->fetchRow(DB_FETCHMODE_ASSOC)) {
		$content .= "/*[ev_date][room] => Gnum*/\n";
		$content .= "\$_DATE['date".$g['ev_date']."'][".$g['room']."] = array(\n";
			$query = "select * from workshop_session_tbl where del='N' and ev_date='".$g['ev_date']."' and room='".$g['room']."' order by stime asc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			$Gnum = 1;

			$sub_content="";
			while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$content .= "'".$Gnum."' => array(";
				$content .= "'session_sid'=>'".$d['sid']."', ";
				$content .= "'session_room'=>'".$g['room']."', ";
				$content .= "'session_stime'=>'".$d['stime']."', ";
				$content .= "'session_etime'=>'".$d['etime']."' ,";
				$content .= "'title'=>'".addslashes($d['title'])."',";
				$content .= "'code'=>'".$d['code']."',";
				$content .= "'code_title'=>'".addslashes($d['code_title'])."',";
				$content .= "'part'=>'".addslashes($d['part'])."',";
				$content .= "'part2'=>'".addslashes($d['part2'])."',";
				$content .= "'difficulty'=>'".$d['difficulty']."',";
				$content .= "'lang'=>'".$d['lang']."',";
				$content .= "'chair'=>'".addslashes($d['chair'])."',";
				$content .= "'chair2'=>'".addslashes($d['chair2'])."',";
				$content .= "'chair3'=>'".addslashes($d['chair3'])."',";
				$content .= "'absolute_room'=>'".$d['absolute_room']."'";
				$content .= "),\n";
				

				$sub_content .= "/*[ev_date][room][Gnum]*/\n";
				$sub_content .= "\$_DATE['date".$g['ev_date']."_detail'][".$g['room']."][".$Gnum."] = array(\n";
				
				$query2 = "select * from  workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N' and hiding_room!='Y' order by sort_num asc, detail_time asc";
				$result2=$conn->query($query2);
				if(DB::isError($result2)) die($result2->getMessage());
				$Dnum=1;

				$set_time = $d['stime'];

				while ($col = $result2->fetchRow(DB_FETCHMODE_ASSOC)) {
					unset($pt_total_time);
					if($col['pt_time']){
						$ex_pt = explode("/",$col['pt_time']);
						$pt_total_time = $ex_pt[0]+$ex_pt[1];
						$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
					}

					$fquery = "select t2.sid,t2.faculty_cv,t2.faculty_abs,t2.faculty_name,t2.faculty_aff,t2.faculty_country from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid ";
					$fquery .= " where t1.session_sid='".$col['session_sid']."' and t1.session_detail_sid='".$col['sid']."' limit 0,1";
					$fresult = $conn->query($fquery);
					$fresult->fetchInto(&$fac,DB_FETCHMODE_ASSOC);
					$fresult->free();

					unset($detail_cv);
					unset($detail_abs);

					unset($faculty_sid);
					unset($faculty_cv);
					unset($faculty_abs);
					unset($faculty_name_arr);

					
					if($fac['sid']){
						$faculty_sid = $fac['sid'];	
						if($fac['faculty_cv']) $faculty_cv = $fac['faculty_cv'];
						if($fac['faculty_abs']) $faculty_abs = $fac['faculty_abs'];

						$faculty_name = $fac['faculty_name'];
						if($fac['faculty_aff']){
							$faculty_name .= "(".addslashes($fac['faculty_aff']);
							if($fac['faculty_country']){
								$faculty_name .= ", ".$fac['faculty_country'];
							}
							$faculty_name .= ")";
						}
						$faculty_name_arr[] = addslashes($faculty_name);
					}else{
						$faculty_name_arr[] = addslashes($col['author']);
					}
					$sub_content .= "'".$Dnum."' => array(";
					//$sub_content .= "'detail_time'=>'".$col['detail_time']."', ";
					$sub_content .= "'detail_key'=>'".$col['sid']."', ";
					$sub_content .= "'detail_time'=>'".date("H:i",strtotime($set_time)).'-'.$set_start."', ";
					$sub_content .= "'detail_title'=>'".addslashes($col['title'])."' ,";
					$sub_content .= "'detail_author'=>'".implode(", ",$faculty_name_arr)."',";
					$sub_content .= "'detail_author_position'=>'".addslashes($col['author_position'])."',";
					$sub_content .= "'detail_kor'=>'".$col['only_kor']."',";
					$sub_content .= "'detail_country'=>'".addslashes($col['country'])."',";
					$sub_content .= "'faculty_sid'=>'".$faculty_sid."',";
					$sub_content .= "'faculty_cv'=>'".$faculty_cv."',";
					$sub_content .= "'faculty_abs'=>'".$faculty_abs."',";
					$sub_content .= "'detail_abs'=>'".$col['abs_file']."',";
					$sub_content .= "'detail_cv'=>'".$col['cv_file']."'";
					$sub_content .= "),\n";
					$Dnum++;

					if($col['pt_time']){
						$set_time = $set_start;
					}

				}
				$sub_content .= ");\n\n";
				$Gnum++;

			}
			
		$content .= ");\n\n";
		
		$content .= $sub_content;
		
	}
	
	
	/*$query = "select t1.title,t1.author,t1.author_position_co,t1.detail_time,t2.*";
	$query .= " from workshop_session_detail_tbl as t1 left outer join workshop_session_tbl as t2 on t1.session_sid=t2.sid where t1.del='N' and t2.del='N'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		
	}*/
	
	
	//$file = fopen($_SERVER['DOCUMENT_ROOT']."../webinar/load/days/program.day".$program_day.".php","w");
	$file = fopen($_SERVER['DOCUMENT_ROOT']."/func/config_detail_times.php","w");
	$file2 = fopen($_SERVER['DOCUMENT_ROOT']."../webinar/func/config_detail_times.php","w");
	$file3 = fopen($_SERVER['DOCUMENT_ROOT']."../mobile/func/config_detail_times.php","w");


	$content .= "?>";
	fwrite($file,$content);
	fclose($file);

	fwrite($file2,$content);
	fclose($file2);

	fwrite($file3,$content);
	fclose($file3);

	PutLocation("/session/");
?>