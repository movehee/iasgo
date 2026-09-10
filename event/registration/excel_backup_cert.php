<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Cert_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	

	$time_max_count=3; //총 세션의 갯수 정의

	if(!$ev_date) $ev_date = 1;
	
	
	$num_per_page = 10;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = "   order by day desc, first_date asc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;


	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	

	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='key'){
					$search_query[] = " usid = '".$tval."' ";
				}else if($tkey=='program_day1'){
					$day_query[] = " day ='1'";
				}else if($tkey=='program_day2'){
					$day_query[] = " day ='2'";
				}else if($tkey=='program_day3'){
					$day_query[] = " day ='3'";
				}else if($tkey=='program_day4'){
					$day_query[] = " day ='4'";
				}else if($tkey=='s1_sdate' || $tkey=='s1_edate' || $tkey=='s2_sdate' || $tkey=='s2_edate' || $tkey=='s3_sdate' || $tkey=='s3_edate' || $tkey=='s4_sdate' || $tkey=='s4_edate'){
					if($tval=='Y'){
						$search_query[] = " $tkey>0 ";
					}else if($tval=='N'){
						$search_query[] = " ($tkey='' or $tkey is null) ";
					}
				}else if($tkey=='s1_stime' || $tkey=='s2_stime' || $tkey=='s3_stime' || $tkey=='s4_stime' || $tkey=='s1_etime' || $tkey=='s2_etime' || $tkey=='s3_etime' || $tkey=='s4_etime'){
					if($tkey=='s1_stime' || $tkey=='s2_stime' || $tkey=='s3_stime' || $tkey=='s4_stime'){
						$search_query[] = " ".str_replace("_stime","_sdate",$tkey).">=unix_timestamp(concat(substr(from_unixtime(".str_replace("_stime","_sdate",$tkey)."),1,10),' ".$tval."'))";
					}else if($tkey=='s1_etime' || $tkey=='s2_etime' || $tkey=='s3_etime' || $tkey=='s4_etime'){
						$search_query[] = " ".str_replace("_etime","_edate",$tkey)."<=unix_timestamp(concat(substr(from_unixtime(".str_replace("_etime","_edate",$tkey)."),1,10),' ".$tval."'))";
					}
				}else if($tkey=='id'){
					$day_query[] = " $tkey like '%".$tval."%' ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
			}
			$search_url .= "&$tkey=".$tval;
		}
	}
	if($day_query){
		$search_query[] = " (".implode(" or ",$day_query).")";
	}
	if($inout_query){
		$search_query[] = " (".implode(" and ",$inout_query).")";
	}

	if($li_page) $search_url .= "&li_page=".$li_page;
	//$search_url .= "&result_code=".$result_code;
	
	$fsql = " where del='N' and member_level!='M' and classification not in ('M','X','Z') and reg_kind='A' and gubun1='4'  group by usid";//and t2.member_level!='M'
	

	
	
	//$query = "select count(*) from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;
	for($s=1;$s<=$time_max_count;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}
	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,license_number,id,aff_kor,email,classification,modify,member_level,chking,reg_kind,gubun1,gubun2";

	
	//$query = "select t1.*,t2.license_number,t2.name_kr,t2.sid as usid,t2.classification,t2.logout_day1,t2.logout_day2,t2.logout_day3,t2.logout_day4,t2.reg_kind,t2.gubun1,t2.gubun2 from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;

	$query = "select ".implode(",",$session_field). $add_field.",sid from (";
	$query .= "(select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	foreach($_CONFIG['Gkey'] as $tkey=>$tval){
		$query .= "union all ";
		$query .= "(select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl_".$tval." as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	}
	$query .= ") A " . $fsql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border=1>
	<tr>
		<th>No</th>
		<th>회원구분</th>
		<th>전문의구분</th>
		<th>근무부서</th>
		<th>성명</th>
		<th>면허번호 </th>
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
		<td><?=$_REG['gubun1'][$d['gubun1']]?></td>
		<td><?=$_REG['gubun2'][$d['gubun2']]?></td>
		<td><?=$d['name_kr']?></td>
		
		<td><?=$d['license_number']?></td>
	</tr>
	<?$n++;?>
	<?}?>
</table>