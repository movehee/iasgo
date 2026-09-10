<?php

require_once 'DB.php';

class Sms{
  var $hostName;
  var $userName;
  var $userPassword;
  var $dbName;
  var $sms_tbl = "smscli_tbl";
  var $nowBackup_smstbl = "smscli_tbl";
  var $prevBackup_smstbl;
  var $nowBackup_con = 'N';
  var $originNumber = "106003001000";
  var $send_cnt = 500;
  var $send_type = "B";
  var $send_overpay = array("A"=>25,"B"=>30);
  var $pay_day = 31;
  var $pay_query;
  var $payday_query_con = 'N';
  var $start_payday;
  var $end_payday;
  var $conn;
  var $code;
  var $col_reserveinfo;
  var $prev_cnt=0;
  var $prev_failcnt=0;
  var $siteurl = 'ezv.kr';
  var $group_seq_val;
  var $group_gubun;
  var $groupBy_query = '';
  var $prev_con = 'N';
  var $time_query = 'sendtime';

  //그룹 seq
  function group_seq($group_gubun) {
    if($this->nowBackup_con == 'Y'){ //현재 달의 백업 테이블이 존재 한다면
      $query = "
        select
              if (
                    if(max(t1.group_seq) is null, 1, max(t1.group_seq)+1)  >
                    if(max(t2.group_seq) is null, 1, max(t2.group_seq)+1)
              , if(max(t1.group_seq) is null, 1, max(t1.group_seq)+1), if(max(t2.group_seq) is null, 1, max(t2.group_seq)+1) ) as max
        from " . $this->sms_tbl . " as t1, " . $this->nowBackup_smstbl . " as t2
      ";
        $query = "
          select
            if(
              ifnull(max(t1.group_seq+1),1) > ifnull(max(t2.group_seq+1),1),
              ifnull(max(t1.group_seq+1),1),
              ifnull(max(t2.group_seq+1),1)
            ) as max
          from
            ".$this->sms_tbl." as t1,
            ".$this->nowBackup_smstbl." as t2
        ";
    }else{
      $query = "select  if(max(group_seq) is null, 1, max(group_seq)+1) as max from " . $this->sms_tbl;
    }

    //echo $query."<br>";exit;
    $this->group_seq_val = $this->conn->getOne($query);
    if(DB::isError($this->group_seq_val)) {
       die($cnt->getMessage());
    }

    //그룹 발송 여부
    $this->group_gubun = $group_gubun;
    //echo $this->group_seq_val."<br>";
  }

  //월별 사용 통계
  function sms_monthcnt($table_name) {
      //성공
      $query = "select count(seq) from " . $table_name . " where siteurl = '" . $this->siteurl . "' and status ='delivered'";
      $this->prev_cnt = $this->conn->getOne($query);
      if(DB::isError($this->prev_cnt)) {
         die($cnt->getMessage());
      }

      //실패
      $query = "select count(seq) from " . $table_name . " where siteurl = '" . $this->siteurl . "' and status !='delivered'";
      $this->prev_failcnt = $this->conn->getOne($query);

      if(DB::isError($this->prev_cnt)) {
         die($cnt->getMessage());
      }
  }

  //테이블 조사
  function sms_tablesearch($table_name) {
    $query = "Show tables like 'smscli_tbl%'";
    $search_con = 'N';
    $result = $this->conn->query($query);

    if(DB::isError($result)) {
       die($result->getMessage());
    }

    while (is_array($row = $result->fetchRow())) {
      if($table_name == $row[0]){
        $search_con = 'Y';
      }
    }
    //$this->sms_tbl = $table_name;
    //echo $search_con;
    return $search_con;
  }

  function flag_wherquery($reserve_flag) {

    switch($reserve_flag) {
    case 'N':
      return " and reserve_flag = '$reserve_flag' ";
    break;
    case 'Y':
      $this->time_query = 'reserve_date';
      $this->pay_query = " and substring(" . $this->time_query . ",1,10) BETWEEN " . $this->start_payday . " and " . $this->end_payday ;
      return " and reserve_flag = '$reserve_flag' ";
    break;
    default:
    case 'YN':
      return '';
    break;
    }
  }

  //그룹 쿼리 설정
  function groupby_wherequery($groupby_flag) {

    if($groupby_flag == 'Y'){
      $this->groupBy_query = ' group by group_seq ';
    }
  }

  ### sms 총 전송 카운트
  function Tsms_cnt($reserve_flag,$groupby_flag) {    //reserve_flag : Y(예약), N(즉시)

    $flag_query = $this->flag_wherquery($reserve_flag);

    //그룹 쿼리
    $this->groupby_wherequery($groupby_flag);

    $query = "(select seq from " . $this->sms_tbl . " where siteurl = '" . $this->siteurl . "' $flag_query $this->pay_query $this->groupBy_query)";

    if($this->nowBackup_con == 'Y'){ //현재 달의 백업 테이블이 존재 한다면
      $query .= "
        UNION ALL
        (select seq from " . $this->nowBackup_smstbl . " where siteurl = '" . $this->siteurl . "' $flag_query $this->pay_query $this->groupBy_query)
      ";
    }

    if($this->payday_query_con == 'O'){
      $query .= "
        UNION ALL
        (select seq from " . $this->prevBackup_smstbl . " where siteurl = '" . $this->siteurl . "' $flag_query $this->pay_query $this->groupBy_query)
      ";
    }

      //echo($query);

      if("112.76.194.13" == $_SERVER['REMOTE_ADDR']){
			echo $query."<br/>";
		}


      $result = $this->conn->query($query);
      if(DB::isError($result)) {
         die($result->getMessage());
      }
      $cnt = $result->numRows();

    return $cnt;
  }

  ### sms 리스트
  function sms_list($pageNav,$num_per_page,$reserve_flag) {  //reserve_flag : Y(예약), N(즉시)

    $flag_query = $this->flag_wherquery($reserve_flag);

    $query = "(select *,'now' from " . $this->sms_tbl . " where siteurl = '" . $this->siteurl . "' $flag_query $this->pay_query $this->groupBy_query)";

    if($this->nowBackup_con == 'Y'){ //현재 달의 백업 테이블이 존재 한다면
      $query .= "
        UNION ALL
        (select *,'bac' from " . $this->nowBackup_smstbl . " where siteurl = '" . $this->siteurl . "' $flag_query $this->pay_query $this->groupBy_query)
      ";
    }

    if($this->payday_query_con == 'O'){
      $query .= "
        UNION ALL
        (select *,'bac' from " . $this->prevBackup_smstbl . " where siteurl = '" . $this->siteurl . "' $flag_query $this->pay_query $this->groupBy_query)
      ";
    }

    $query .= " ORDER BY seq DESC LIMIT " . $pageNav->getFirstRecordInPage() . ", " . $num_per_page;


    //echo $query;

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }

    return $result;
  }

  ### sms 엑셀 저장 리스트
  function sms_excel_list($reserve_flag) {  //reserve_flag : Y(예약), N(즉시)

    $flag_query = $this->flag_wherquery($reserve_flag);

    $query .= "(select *,'now' from " . $this->sms_tbl . " where siteurl = '" . $this->siteurl . "' $flag_query $this->groupBy_query)";

    if($this->nowBackup_con == 'Y'){
      $query .= "
      UNION ALL
      (select *,'bac' from " . $this->nowBackup_smstbl . " where siteurl = '" . $this->siteurl . "' $flag_query $this->groupBy_query)
      ";
    }
    $query .= " ORDER BY seq ";

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    return $result;
  }


  ### sms 그룹 리스트
  function sms_group_list($pageNav,$num_per_page,$reserve_flag,$group_seq) {  //reserve_flag : Y(예약), N(즉시)

    $flag_query = $this->flag_wherquery($reserve_flag);

    $query = "(select *,'now' from " . $this->sms_tbl . " where siteurl = '" . $this->siteurl . "' $flag_query  and group_seq=$group_seq)";

    if($this->nowBackup_con == 'Y'){
      $query .= "
      UNION ALL
      (select *,'bac' from " . $this->nowBackup_smstbl . " where siteurl = '" . $this->siteurl . "' $flag_query  and group_seq=$group_seq)
      ";
    }

    $query .= " ORDER BY seq DESC LIMIT " . $pageNav->getFirstRecordInPage() . ", " . $num_per_page;

	if("112.76.194.13" == $_SERVER['REMOTE_ADDR']){
		echo $query."<br/>";
	}

    //echo $query;
    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    return $result;
  }

  ### sms 그룹 엑셀 백업 리스트
  function sms_group_excel_list($reserve_flag,$group_seq) {  //reserve_flag : Y(예약), N(즉시)

    $flag_query = $this->flag_wherquery($reserve_flag);

    $query = "(select *,'now' from " . $this->sms_tbl . " where siteurl = '" . $this->siteurl . "' $flag_query  and group_seq=$group_seq)";

    if($this->nowBackup_con == 'Y'){
      $query .= "
      UNION ALL
      (select *,'bac' from " . $this->nowBackup_smstbl . " where siteurl = '" . $this->siteurl . "' $flag_query  and group_seq=$group_seq)
      ";
    }
    $query .= " ORDER BY seq ";

    //echo $query;
    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    return $result;
  }

  ### sms 예약 상세정보
  function sms_reserveinfo($seq,$table_con) {
    $table_name = $this->sms_tbl;

    if($table_con == 'bac'){
      $table_name = $this->nowBackup_smstbl;
    }

    $query = "select * from " . $table_name . " where siteurl = '" . $this->siteurl . "' and seq = $seq";

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }

    $result->fetchInto(&$this->col_reserveinfo,DB_FETCHMODE_ASSOC);

    $this->group_gubun = $this->col_reserveinfo[group_gubun];
    $this->group_seq_val = $this->col_reserveinfo[group_seq];
  }

  ### sms 예약 업데이트
  function sms_reserveupdate($seq, $receive, $send, $reserve_date, $table_con) {
    $table_name = $this->sms_tbl;

    if($table_con == 'bac'){
      $table_name = $this->nowBackup_smstbl;
    }

    ####기존 정보 가져오기
    $this->sms_reserveinfo($seq,$table_con);
    $this->sms_send($receive,$this->col_reserveinfo["body"],$send,$this->col_reserveinfo["user_id"],'Y',$reserve_date);
    $this->sms_del($seq,$table_con);
  }

  ### sms 예약 삭제
  function sms_del($seq,$table_con) {
    $table_name = $this->sms_tbl;

    if($table_con == 'bac'){
      $table_name = $this->nowBackup_smstbl;
    }
    $query = "delete from " . $table_name . " where seq = $seq";
    //die($query);
     $result = $this->conn->query($query);
     if(DB::isError($result)) {
        die($result->getMessage());
     }
  }

  ### sms 그룹 카운트 체크 성공
  function sms_group_cnt($group_seq, $select_con,$reserve_flag){

    $flag_query = $this->flag_wherquery($reserve_flag);

    $group_query = " and status ='delivered' ";
    if($select_con == 'T'){
      $group_query = '';
    }

    $query = "(select seq from " . $this->sms_tbl . " where siteurl = '" . $this->siteurl . "' $flag_query $group_query and group_seq=$group_seq) ";

    if($this->nowBackup_con == 'Y'){
      $query .= "
      UNION ALL
      (select seq from " . $this->nowBackup_smstbl . " where siteurl = '" . $this->siteurl . "' $flag_query $group_query and group_seq=$group_seq)
      ";
    }

     //echo $query;
      //die();

      $result = $this->conn->query($query);
      if(DB::isError($result)) {
         die($result->getMessage());
      }
      $cnt = $result->numRows();

    return $cnt;
  }

  ### sms 카운트 체크 성공
  function sms_cnt(){

    $query = "(select seq from " . $this->sms_tbl . " where siteurl = '" . $this->siteurl . "' and status ='delivered' $this->pay_query)";

    if($this->nowBackup_con == 'Y'){ //현재 달의 백업 테이블이 존재 한다면
      $query .= "
        UNION ALL
        (select seq from " . $this->nowBackup_smstbl . " where siteurl = '" . $this->siteurl . "' and status ='delivered' $this->pay_query)
      ";
    }

    if($this->payday_query_con == 'O'){
      $query .= "
         UNION ALL
        (select seq from " . $this->prevBackup_smstbl . " where siteurl = '" . $this->siteurl . "' and status ='delivered' $this->pay_query)
      ";
    }

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }

    $cnt = $result->numRows();

//echo $query;
    return $cnt;
  }

  ### sms 카운트 체크 실패
  function sms_failcnt(){

    $query = "(select seq from " . $this->sms_tbl . " where siteurl = '" . $this->siteurl . "' and status !='delivered')";

    if($this->nowBackup_con == 'Y'){
      $query .="
       UNION ALL
      (select seq from " . $this->nowBackup_smstbl . " where siteurl = '" . $this->siteurl . "' and status !='delivered')
      ";
    }

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    $cnt = $result->numRows();

    return $cnt;
  }

  ### 전송결과
  function sms_status($status) {
    switch($status) {
    case 'delivered':
      return '전송성공';
    break;
    case 'rejected' :
      return '실패-결번';
    break;
    case 'expired' :
      return '실패-타임아웃';
    break;

    case '28' :
      return '사전 미등록 발신번호 사용';
    break;

    default :
      return '전송대기';
    break;
    }
  }

  ### 현재 처리 상태
  function sms_procstatus($proc_status) {
    switch($proc_status){
      case '1' :
        return '전송 대기 상태';
      break;
      case '2' :
        return 'SMS 서버로 메시지 전송요청함';
      break;
      case '3' :
        return 'G/W로 부터 전송 요청상태';
      break;
      case '4' :
        return 'KIDC 서버로 부터 메시지 전송이 거부됨';
      break;
      case '6' :
        return '메시지 전송 완료';
      break;
    }
  }

  ### sms 카운트 메세지
  function cnt_msg($cnt){
    if($cnt > $this->send_cnt){
      return false;
    }else{
      return true;
    }
  }

  ### sms db 정보 설정
  function Sms($hostName,$user_Name,$user_userPassword,$dbName,$siteurl,$code,$reserve_flag="N") {

    $flag_query = $this->flag_wherquery($reserve_flag);

    $this->hostName = $hostName;
    $this->user_Name = $user_Name;
    $this->user_userPassword = $user_userPassword;
    $this->dbName = $dbName;

//    echo $this->siteurl;
    $this->code = $code;

    ##### 데이터베이스에 연결한다.
    $dsn = "mysql://$this->user_Name:$this->user_userPassword@$this->hostName/$this->dbName";
    $this->conn = DB::connect($dsn);
    if(DB::isError($this->conn)) {
       die ($this->conn->getMessage());
    }

    // 현재 달의 백업된 테이블이 있는지 검사
    $this->nowBackup_smstbl .= '_' . date("Ym");

    $this->nowBackup_con = $this->sms_tablesearch($this->nowBackup_smstbl);
    //echo $this->sms_tbl."<br>";

    $imsi_pay_day = $this->pay_day + 1;

    if($imsi_pay_day > 31){

      $this->start_payday = " '" . date("Y-m-d",mktime(0,0,0, date("m"), 1, date("Y"))) . "' ";
      $this->end_payday =  " '" . date("Y-m-d",mktime(0,0,0, date("m"), $this->pay_day, date("Y"))) . "' ";

    }else{

      if(date("d") > $this->pay_day){  //새로운 정산
        $this->start_payday = " '" . date("Y-m-d",mktime(0,0,0, date("m"), $this->pay_day+1, date("Y"))) . "' ";
      }else{
        $this->start_payday = " '" . date("Y-m-d",mktime(0,0,0, date("m")-1, $this->pay_day+1, date("Y"))) . "' ";
        $this->payday_query_con = 'O';
        $this->prevBackup_smstbl = $this->sms_tbl . '_' . date("Ym", mktime(0,0,0, date("m")-1, date("d"), date("Y")));
      }
      $this->end_payday = " '" . date("Y-m-d") . "' ";

    }
      $this->pay_query = " and substring(" . $this->time_query . ",1,10) BETWEEN " . $this->start_payday . " and " . $this->end_payday ;
//die($this->pay_query);

    //echo $this->prevBackup_smstbl;
  }

  ### sms send
   //수신번호, 내용, 발신번호, 발신자 아이디
  //$Sms-> sms_send($col[mobile], "[국민고혈압사업단] 온라인 상담게시판에 답변이 등록 되었습니다",$HTTP_COOKIE_VARS[member_mobile],$HTTP_COOKIE_VARS[member_id]);

/*
	$receive = str_replace("-","",$receive);
	$query = "INSERT INTO ". $sms_tbl . " (destination, body, originator, callback,siteurl,user_id) VALUES (";
	$query .= "'".$receive."',";
	$query .= "'".$msg."',";
	$query .= "'".$originNumber."',";
	$query .= "'".$send."',";
	$query .= "'".$siteurl."',";
	$query .= "'".$writer."'";
	$query .= ")";
*/
  function sms_send($receive, $msg, $send, $writer, $reserve_flag, $reserve_date){
    $receive = str_replace("-","",$receive);
    $send = str_replace("-","",$send);
	$msg = iconv("utf-8","euc-kr",$msg);

    $query = "INSERT INTO ". $this->sms_tbl . " (destination, body, originator, callback, siteurl, user_id, code, reserve_flag, group_gubun,  reserve_date,group_seq) VALUES (";
    $query .= "'".$receive."',";
    $query .= "'".$msg."',";
    $query .= "'".$this->originNumber."',";
    $query .= "'".$send."',";
    $query .= "'".$this->siteurl."',";
    $query .= "'".$writer."',";
    $query .= "'".$this->code."',";
    $query .= "'".$reserve_flag."',";
    $query .= "'".$this->group_gubun."',";
    $query .= "'".$reserve_date."',";
    $query .= "'" . $this->group_seq_val . "'";
    $query .= ")";

//echo $query . "<br>";

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }

  }

  function prev_con($con,$prev_y,$prev_m) {

    //현재 달은 필요 없고...
    $this->nowBackup_con = 'N';

    $imsi_pay_day = $this->pay_day + 1;

    if($imsi_pay_day > 31){

      $this->start_payday = " '" . date("Y-m-d",mktime(0,0,0, $prev_m, 1, $prev_y)) . "' ";
      $this->end_payday = " '$prev_y-$prev_m-$this->pay_day' ";

    }else{
      $imsi_month = date("m",mktime(0,0,0, $prev_m + 1, $this->pay_day+1, $prev_y));

      $this->start_payday = " '" . date("Y-m-d",mktime(0,0,0, $prev_m-1, $this->pay_day+1, $prev_y)) . "' ";
      $this->end_payday = " '" . date("Y-m-d",mktime(0,0,0, $prev_m, $this->pay_day, date("Y"))) . "' ";

    }//

    $this->prevBackup_smstbl = $this->sms_tbl . '_' . date("Ym", mktime(0,0,0, $prev_m-1, date("d"), $prev_y));

    $this->pay_query = " and substring(" . $this->time_query . ",1,10) BETWEEN " . $this->start_payday . " and " . $this->end_payday ;
//echo $this->pay_query."<br>";
  }

  ### sms db 끊기
  function sms_disconnect(){
    $this->conn->disconnect();
  }

}//
?>