<?php

require_once 'DB.php';
class Mms{
  var $mms_tbl = "MMS_MSG";
  var $nowBackup_mmstbl;
  var $hostName = '121.254.129.66';
  var $user_Name = 'sms';
  var $user_userPassword = 'kidc';
  var $dbName = 'sms';
  var $conn;
  var $siteurl = 'ezv.kr';
  var $user_id;
  var $pay = 50; // 건당 요금
  var $group_seq_val;
  var $group_query;
  var $ETC1_query;

  function Mms($user_id) {
    $this->user_id = $user_id;  //송신자 아이디

    ##### 데이터베이스에 연결한다.
    $dsn = "mysql://$this->user_Name:$this->user_userPassword@$this->hostName/$this->dbName";
    $this->conn = DB::connect($dsn);
    if(DB::isError($this->conn)) {
       die ($this->conn->getMessage());
    }

    //현재달의 백업 테이블이 있는지 검사
    $this->nowBackup_mmstbl = "MMS_LOG_" . date("Ym");
    $this->nowBackup_con = $this->mms_tablesearch($this->nowBackup_mmstbl);
  }//end fun Sms

                    //수신   발신      내용  예약여부 발신일(미래시간일 경우 예약 발송)
  function mms_send($PHONE, $CALLBACK, $MSG, $ETC1, $REQDATE, $ETC4) {
    //$MSG = $this->getValueForQuery($MSG);
	$MSG = iconv("utf-8","euc-kr",$MSG);
    $query = "INSERT INTO MMS_MSG
                (SUBJECT,PHONE,CALLBACK,STATUS,REQDATE,MSG,FILE_CNT,FILE_PATH1, EXPIRETIME, ETC1, ETC4, ID, ETC2) VALUES
                (concat(substring('".$MSG."', 1, 10), '...'),'".$PHONE."','".$CALLBACK."','0',".$REQDATE.", '".$MSG."',0,null,'43200', '".$ETC1."', '".$ETC4."', '".$this->user_id."', '".$this->siteurl."')";
    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }

  }//end fun mms_send


  //테이블 조사
  function mms_tablesearch($table_name) {
    $search_con = 'N';
    $query = "Show tables like '".$table_name."'";
    $result = $this->conn->query($query);

    if(DB::isError($result)) {
       die($result->getMessage());
    }

    while (is_array($row = $result->fetchRow())) {
      if($table_name == $row[0]){
        $search_con = 'Y';
      }
    }
    return $search_con;
  }//end fun sms_tablesearch

/*
  //그룹 seq
  function group_seq() {
    if($this->nowBackup_con == 'Y'){ //현재 달의 백업 테이블이 존재 한다면
      $query = "
        select
              if (
                    if(max(t1.ETC4) is null, 1, max(t1.ETC4)+1)  >
                    if(max(t2.ETC4) is null, 1, max(t2.ETC4)+1)
              , if(max(t1.ETC4) is null, 1, max(t1.ETC4)+1), if(max(t2.ETC4) is null, 1, max(t2.ETC4)+1) ) as max
        from " . $this->mms_tbl . " as t1, " . $this->nowBackup_mmstbl . " as t2
      ";
    }else{
      $query = "select  if(max(ETC4) is null, 1, max(ETC4)+1) as max from " . $this->mms_tbl;
    }

    $this->group_seq_val = $this->conn->getOne($query);
    if(DB::isError($this->group_seq_val)) {
       die($cnt->getMessage());
    }

  }
*/

  //그룹 seq
  function group_seq() {
    if($this->nowBackup_con == 'Y'){ //현재 달의 백업 테이블이 존재 한다면
      /*
      $query = "
        select
              if (
                    if(max(t1.ETC4) is null, 1, max(t1.ETC4)+1)  >
                    if(max(t2.ETC4) is null, 1, max(t2.ETC4)+1)
              , if(max(t1.ETC4) is null, 1, max(t1.ETC4)+1), if(max(t2.ETC4) is null, 1, max(t2.ETC4)+1) ) as max
        from " . $this->mms_tbl . " as t1, " . $this->nowBackup_mmstbl . " as t2
      ";
      */

      $query = "SELECT ifnull(max(ETC4)+1, 1) from " . $this->mms_tbl;
      $imsi_1 = $this->conn->getOne($query);
      if(DB::isError($imsi_1)) {die($imsi_1->getMessage());}

      $query = "SELECT ifnull(max(ETC4)+1, 1) from " . $this->nowBackup_mmstbl;
      $imsi_2 = $this->conn->getOne($query);
      if(DB::isError($imsi_2)) {die($imsi_2->getMessage());}

      $this->group_seq_val = $imsi_1;
      if($imsi_1 < $imsi_2){
        $this->group_seq_val = $imsi_2;
      }

    }else{
      /*
      $query = "select  if(max(ETC4) is null, 1, max(ETC4)+1) as max from " . $this->mms_tbl;
      $this->group_seq_val = $this->conn->getOne($query);
      if(DB::isError($this->group_seq_val)) {die($cnt->getMessage()); }
      */
      $query = "select  if(max(ETC4) is null, 1, max(ETC4)+1) as max from " . $this->mms_tbl;
      $imsi_1 = $this->conn->getOne($query);
      if(DB::isError($imsi_1)) {die($imsi_1->getMessage());}

      $pp_log_tbl = "MM_LOG_" . date("Ym",mktime (0,0,0,date("m")-1,1,  date("Y")));
      $query = "select  if(max(ETC4) is null, 1, max(ETC4)+1) as max from " . $pp_log_tbl;
      $imsi_2 = $this->conn->getOne($query);
      if(DB::isError($imsi_2)) {die($imsi_2->getMessage());}

      $this->group_seq_val = $imsi_1;
      if($imsi_1 < $imsi_2){
        $this->group_seq_val = $imsi_2;
      }

    }


  }


  //
  function mms_query($table_name) {

	echo $table_name;
	exit;
    if($table_name){  //테이블 명이 있으면.. 이전달 검사
      $search_con = $this->mms_tablesearch($table_name);
      if($search_con == 'N'){
        PutMessageBack('해달 연월의 백업 DB가 없습니다!!');
      }
      $query = "select * from " . $table_name . " where ETC2 = '" . $this->siteurl . "' and ID = '" . $this->user_id . "' " . $this->group_query . $this->ETC1_query;

    }else{  //현재달 검사.. 현재달의 백업이 있다면
      $search_con_now = $this->mms_tablesearch($this->nowBackup_mmstbl);

      $query = "(select * from " . $this->mms_tbl . " where ETC2 = '" . $this->siteurl . "' and ID = '" . $this->user_id . "' ". $this->ETC1_query . $this->group_query . " ) ";
      if($search_con_now == 'Y'){
        $query .= "
        UNION ALL
        (select * from " . $this->nowBackup_mmstbl . " where ETC2 = '" . $this->siteurl . "' and ID = '" . $this->user_id . "' ". $this->ETC1_query . $this->group_query . ")
        ";
      }//end if search_con_now

    }//

    return $query;

  }//end fun


  function Tmms_cnt($table_name, $ETC1_query = NULL) {
    $this->set_group('', '');
    $this->ETC1_query = $ETC1_query;

    $query = $this->mms_query($table_name);

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    $cnt = $result->numRows();

    return $cnt;
  }


  function mms_cnt($table_name) {
    $this->set_group('', 'A');

    $query = $this->mms_query($table_name);

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    $cnt = $result->numRows();

    return $cnt;
  }

  function mms_failcnt($table_name) {
    $this->set_group('', 'F');

    $query = $this->mms_query($table_name);

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    $cnt = $result->numRows();

    return $cnt;
  }


  function mms_list($table_name) {
    global $pageNav,$num_per_page;

    $this->set_group('', '');

    $query = $this->mms_query($table_name);

    $query .= " ORDER BY MSGKEY DESC LIMIT " . $pageNav->getFirstRecordInPage() . ", " . $num_per_page;

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    return $result;

  }

  function mms_group_list($table_name, $group_seq) {
    global $pageNav,$num_per_page;

    $this->set_group($group_seq, 'T');

    $query = $this->mms_query($table_name);

    $query .= " ORDER BY MSGKEY DESC LIMIT " . $pageNav->getFirstRecordInPage() . ", " . $num_per_page;

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    return $result;

  }

  ### sms 그룹 카운트 체크 성공
  function mms_group_cnt($table_name, $group_seq, $select_con){
    $this->set_group($group_seq, $select_con);

    $query = $this->mms_query($table_name);


    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }
    $cnt = $result->numRows();

    return $cnt;
  }

  function set_group($group_seq, $select_con) {
    $this->group_query = " group by ETC4 ";

    if($select_con == 'T'){
      $this->group_query = " and ETC4 = '".$group_seq."' ";
    }elseif($select_con == 'D'){
      $this->group_query = " and ETC4 = '".$group_seq."' and (STATUS = '2' or STATUS = '3') and RSLT = '1000' ";
    }elseif($select_con == 'S'){
      $this->group_query = " and MSGKEY = '".$group_seq."' ";
    }elseif($select_con == 'A'){
      $this->group_query = "";
    }elseif($select_con == 'F'){
      $this->group_query = " and (STATUS = '2' or STATUS = '3') and RSLT != '1000' ";
    }

  }


  //1row 정보
  function mms_info($seq, $table_name) {
    $this->set_group($seq, 'S');
    $query = $this->mms_query($table_name);

    $result = $this->conn->query($query);
    if(DB::isError($result)) {
       die($result->getMessage());
    }

    $result->fetchInto(&$col, DB_FETCHMODE_ASSOC);

    return $col;

  }

  //update
  function mms_update($MSGKEY,$PHONE,$CALLBACK,$REQDATE,$table_name) {
    $table_name = $table_name !='' ? $table_name : $this->mms_tbl;
    $query = "update " . $table_name . " set PHONE = '".$PHONE."', CALLBACK = '".$CALLBACK."', REQDATE = '".$REQDATE."' where MSGKEY = '".$MSGKEY."' ";

     $result = $this->conn->query($query);
     if(DB::isError($result)) {
        die($result->getMessage());
     }

  }

  ### mms 삭제
  function mms_del($MSGKEY,$table_name) {
    $table_name = $table_name !='' ? $table_name : $this->mms_tbl;

    $query = "delete from " . $table_name . " where MSGKEY = $MSGKEY";

     $result = $this->conn->query($query);
     if(DB::isError($result)) {
        die($result->getMessage());
     }
    //die($query);
  }


  ### 전송결과
  function mms_status($col) {
    $status = $col['STATUS'];
    $etc1 = $col['ETC1'];
    $rslt = $col['RSLT'];

    $result = '';

    if($status == '0' && $etc1 == 'Y' && $rslt == ''){  //예약 전송대기
      $result = '예약 전송대기';
    }elseif($status == '1'){
      $result = '송신중';
    }elseif($status == '2' || $status == '3'){
      $result = $this->rslt_status($rslt);
    }elseif($status == '0'){
      $result = '전송대기';
    }

    return $result;
  }

  function rslt_status($status) {
    switch($status){
      case '1000' : $result = '성공'; break;
      case '2000' : $result = '포맷 관련 알 수 없는 오류 발생'; break;
      case '2001' : $result = '주소(포맷) 에러'; break;
      case '2002' : $result = 'Content-length 오류'; break;
      case '2003' : $result = '형식 오류'; break;
      case '2004' : $result = 'Message ID 오류 (중복, 부재)'; break;
      case '2005' : $result = 'Head 내 각 필드의 부적절'; break;
      case '2006' : $result = 'Body 내 각 필드의 부적절'; break;
      case '2007' : $result = '지원하지 않는 미디어 존재'; break;
      case '3000' : $result = 'MMS를 미 지원 단말'; break;
      case '3001' : $result = '단말 수신용량 초과'; break;
      case '3002' : $result = '전송 시간 초과'; break;
      case '3003' : $result = '읽기 확인 미 지원 단말'; break;
      case '3004' : $result = '전원 꺼짐'; break;
      case '3005' : $result = '음영지역'; break;
      case '3006' : $result = '기타'; break;
      case '4000' : $result = '서버실패(프로세스 또는 시스템 에러)'; break;
      case '4001' : $result = '인증실패'; break;
      case '4002' : $result = '네트워크 에러 발생'; break;
      case '4003' : $result = '서비스의 일시적인 에러'; break;
      case '5000' : $result = '번호이동에러'; break;
      case '5001' : $result = '선불발급 발송건수 초과'; break;
      case '9001' : $result = '유효시간 초과'; break;
      case '9002' : $result = '폰 넘버 에러'; break;
      case '9003' : $result = '스팸 번호(스팸 테이블 사용시)'; break;
      case '9004' : $result = '이통사에서 응답 없음'; break;
      case '9005' : $result = '파일크기 오류'; break;
      case '9006' : $result = '지원되지 않는 파일'; break;
      case '9007' : $result = '파일오류'; break;
    }
    return $result;
  }


  function ETC1_set($ETC1_query) {
    $this->ETC1_query = $ETC1_query;
  }



  //역슬래쉬
  function getValueForQuery($value) {
    if(!get_magic_quotes_gpc()) $value = addslashes($value);
    return $value;
  }

  ### sms db 끊기
  function mms_disconnect(){
    $this->conn->disconnect();
  }

}

?>