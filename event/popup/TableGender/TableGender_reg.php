<?
	include $_SERVER['DOCUMENT_ROOT']."/39th/lib.php";
	
	procAdminLoginChk();
	
	$sch_tbl = "workshop_schedule_tbl";

	function Tbl_replace($content){
		$replace_arr = array(
		"<table>"=>"",
		"<tbody>"=>"",
		"<\/table>"=>"",
		"<\/tbody>"=>"",
		"<\/tr>"=>"",
		"<\/td>"=>""
		);
		foreach($replace_arr as $tkey=>$tval){
			$patterns[] = "/".$tkey."/";
			$replacements[] = $tval;
		}
		return preg_replace($patterns, $replacements, $content);
	}

	$html = str_replace("\\", "",Tbl_replace($source));
	

	$ex_tr = explode("<tr>",$html); //넘오온 값에서 <tr>로 구분하여 자릅니다.
	
	for($tr=1;$tr<count($ex_tr);$tr++){ //자른 TR의 카운트 만큼 for문이 실행됩니다.
		
		
		
		$ex_td = explode("<td",$ex_tr[$tr]); // 잘라낸 TR안에서 <TD 로 구분하여 갯수를 알아옵니다.
		
		$td_number = 1;
		$row_txt="";
		for($td=1;$td<count($ex_td);$td++){ //카운트 된 TD가 돌아갑니다.
			
			$row_txt = $ex_td[$td];
			if(strpos($row_txt,"colspan")!==false){
				preg_match_all('/colspan=\"([^"]+)"/i', $ex_td[$td], $cols);
				$colspan =  $cols[1][0];
			}else{
				$colspan=1;
			}
			if(strpos($row_txt,"rowspan")!==false){
				preg_match_all('/rowspan=\"([^"]+)"/i', $ex_td[$td], $rows);
				$rowspan =  $rows[1][0];
			}else{
				$rowspan=1;
			}
			

			$query = "select sid from ".$sch_tbl." where code='$code' and td='$td_number' and tr<$tr and rowspan>1 and bsid='$chk_date' order by tr asc";
			$result = $conn->query($query);
			if(!$result) {die($conn->error);}
			
			while(is_array($d=$result->fetch_assoc())){
				
				$row_query = "select * from ".$sch_tbl." where sid='$d[sid]'";
				$row_result = $conn->query($row_query);
				if(!$row_result) {die($conn->error);}
				$row = $row_result->fetch_assoc();

				

				$row_cur = $row['tr']+($row['rowspan']-1); //검색된 데이터의 현재 위치와 rowspan 한 값

				if($row_cur>=$tr){ //위 조건으로 계산된 TR의 값이 등록하려는 TR의 값과 동일하거나 크다면 
					
					$re_chk = GetOne("select count(*) from ".$sch_tbl." where code='$code' and td='$td_number' and tr<$tr and rowspan>1 and bsid='$chk_date' order by tr desc limit 0,1");
				
					do {
						$re_chk = GetOne("select count(*) from ".$sch_tbl." where code='$code' and td='$td_number' and tr<$tr and rowspan>1 and bsid='$chk_date' order by tr desc limit 0,1");
						$row_re_chk = GetOne("select rowspan from ".$sch_tbl." where code='$code' and td='$td_number' and tr<$tr and rowspan>1 and bsid='$chk_date' order by tr desc limit 0,1");
						$tr_re_chk = GetOne("select tr from ".$sch_tbl." where code='$code' and td='$td_number' and tr<$tr and rowspan>1 and bsid='$chk_date' order by tr desc limit 0,1");

						$row_cur_re = $tr_re_chk+($row_re_chk-1); //검색된 데이터의 현재 위치와 rowspan 한 값

						
						if($re_chk==0 || ($tr>$row_cur_re)){
							break;
						}else{
							$re_cols = GetOne("select colspan from ".$sch_tbl." where code='$code' and td='$td_number' and tr<$tr and rowspan>1 and bsid='$chk_date' order by tr desc limit 0,1");
							$td_number = $td_number+$re_cols;
						}
					} while ($re_chk <> 0);

				}
				
			}
			

			$query = "insert into ".$sch_tbl." set code='$code', bsid='$chk_date', tr='$tr', td='$td_number', colspan='".$colspan."', rowspan='".$rowspan."', content='$content'";
			$result = $conn->query($query);
			if(!$result) {die($conn->error);}

			if($colspan>1){
				$td_number = $td_number+($colspan-1);
			}

			$td_number++;
		}
		
	}

	$conn->disconnect();
	PutMessageCloseOpenerReload("생성 되었습니다.");
?>