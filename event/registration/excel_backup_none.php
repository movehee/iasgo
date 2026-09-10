<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=loginNone_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	$sort_sql = " order by sid desc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;


	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','ev_date');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	

	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='s_sid'){
					$search_query[] = " society_sid = '".$tval."' ";
				}else if($tkey=='regist_gubunA' || $tkey=='regist_gubunB' || $tkey=='regist_gubunC' || $tkey=='regist_gubunD' || $tkey=='regist_gubunE' || $tkey=='regist_gubunP' || $tkey=='regist_gubunG'  || $tkey=='regist_gubunZ'){
					if($tkey=='regist_gubunA') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunP') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunB') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunD') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunE') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunG') $reg_gubun[] = $tval;
					if($tkey=='regist_gubunZ') $reg_gubun[] = $tval;
				}else if($tkey=='program_day1'){
					$search_query[] = " login1 like '%".$tval."%' ";
				}else if($tkey=='program_day2'){
					$search_query[] = " login2 like '%".$tval."%' ";
				}else if($tkey=='program_day3'){
					$search_query[] = " login3 like '%".$tval."%' ";
				}else if($tkey=='program_day4'){
					$search_query[] = " login4 like '%".$tval."%' ";
				}else if($tkey=='regist_kind'){
					$search_query[] = " reg_kind='".$tval."' ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
				
			}
			$search_url .= "&$tkey=".$tval;
		}
	}

	if($reg_gubun){
		$search_query[] = " FIND_IN_SET(reg_kind,'".implode(",",$reg_gubun)."')";
	}
	
	if($li_page) $search_url .= "&li_page=".$li_page;
	$search_url .= "&result_code=".$result_code;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and login".$ev_date."='Y' and login_day".$ev_date." is null and member_level!='M'";
	}else{
		$fsql = " where del='N' and login".$ev_date."='Y' and login_day".$ev_date." is null and member_level!='M'";
	}

	$query = "select * from registration_tbl " .$fsql;
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border=1>
	<tr>
		<th>No</th>
		<th>등록종류</th>
		<th>구분</th>
		<th>상세구분</th>
		<!-- <th>연차</th> -->
		<th>ID</th>
		<th>성명</th>
		<th>비밀번호</th>
		
		<th>면허번호</th>	
		<?for($date=1;$date<=$date_count;$date++){?>	
			<th><?=date("m.d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></th>
		<?}?>
		
		<!-- <th>평의원회</th>
		<th>평점</th>
		<th>이벤트</th> -->
		<th>소속</th>
		<th>E-mail</th>
		<th>연락처</th>
		<!-- <th>상세</th> -->
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$_REG['class_kind'][$d['classification']]?></td>
		<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
		<td><?=$_REG['gubun1'][$d['gubun1']]?><?if($d['gubun2']){?><br />(<?=$_REG['gubun2'][$d['gubun2']]?>)<?}?></td>
		<!-- <td><?=$d['major_year']?></td> -->
		<td><?=$d['id']?></td>
		<td><?=$d['name_kr']?></td>
		<td style="mso-number-format:'\@'"><?=$d['passwd']?></td>
		
		<td style="mso-number-format:'\@'"><?=$d['license_number']?></td>
		
		<?for($date=1;$date<=$date_count;$date++){?>	
			<td style="color:<?=$_REG['enter_color'][$d['login'.$date]]?>"><?=$_REG['enter'][$d['login'.$date]]?></td>
		<?}?>
		<!-- <td style="color:<?=$_REG['enter_color'][$d['councilor']]?>"><?=$_REG['enter'][$d['councilor']]?></td>
		<td style="color:<?=$_REG['enter_color'][$d['score_chk']]?>"><?=$_REG['enter'][$d['score_chk']]?></td>
		<td style="color:<?=$_REG['enter_color'][$d['event_chk']]?>"><?=$_REG['enter'][$d['event_chk']]?></td> -->
		<td><?=$d['aff_kor']?></td>
		<td style="mso-number-format:'\@'"><?=$d['email']?></td>
		<td style="mso-number-format:'\@'"><?=$d['cell']?></td>
		<!-- <td><span class="rBtnAdmin small darkPink"><button type="button" onclick="popup_call('registration/checkin_list','sid=<?=$d['usid']?>&day=<?=$day?>')">View</button></span></td> -->
	</tr>
	<?$n++;?>
	<?}?>
</table>