<?php
require_once 'DB.php';


class M2mail{
  var $conn;
  var $hostName = "121.254.129.73";
  var $userName = "wiseu";
  var $userPassword = "wiseu";
  var $dbName = "wiseU";
  var $kk = 1;
  var $SENDER_NM;
  var $SENDER;
  var $DATA;
  var $SUBJECT;
  var $ECARE_NO;
  var $RECEIVER;
  var $RECEIVER_NM;
  var $sendSel;
  var $err_qry;
  var $code;
  var $mail_codes = array();
  var $tseq;
  var $sseq;

  //Linux
  function conn(){
    ##### 데이터베이스에 연결한다.
    $dsn = "mssql://".$this->userName.":".$this->userPassword."@".$this->hostName."/".$this->dbName;
    $this->conn = DB::connect($dsn);
    if(DB::isError($this->conn)) {
       die ("ms1".$this->conn->getMessage());
    }

  }

  //Window
  function connS(){
    ##### 데이터베이스에 연결한다.
    $dsn = "sqlsrv://".$this->userName.":".$this->userPassword."@".$this->hostName."/".$this->dbName;
    $this->conn = DB::connect($dsn);
    if(DB::isError($this->conn)) {
       die ("ms2".$this->conn->getMessage());
    }

  }

  //메일 정보 셋팅
  function M2mail($senSel){
    $this->sendSel = $senSel;
  }

  //sendmail 로 발송
  function Sendmail($d, $mail, $charset = false) {
    $this->mailInfoSet($d);
    $mail->send($this->RECEIVER_NM, $this->RECEIVER, $this->SENDER_NM ,$this->SENDER,$this->SUBJECT);
  }


  //메일 선택 발송
  function send($d, $charset, $mail = '') {
    if($this->sendSel == 'wiseU'){
      $this->conn();
      $this->wiseU($d, $charset);  
    }elseif($this->sendSel == 'sendmail'){
      $this->Sendmail($d, $mail);
    }
  }


  //대용량 메일로 발송
  function wiseU($d, $charset){

    if(!$this->conn){
      $this->conn();
      //echo $this->conn;
    } 

    if($charset == 'UTF-8' || $charset == 'utf-8'){
      $d = $this->charsetConvertEucKr($d);
    }

    //메일 정보 셋팅
    $this->mailInfoSet($d);

    //수신자 이메일 있다면 발송
    if($this->RECEIVER){

      $SEQ = time().$this->kk;
      $this->tseq = $SEQ;

      //sseq값의 앞자리(10자리(time)+2자리(rand)+3자리(ecare_no)=15자리)가 현재 보내는 메일의 공통된 값으로 설정된다.
      //tseq값이 sseq + 순번 5자리를 포함하여 총 20자리의 값으로 만들어진다.
      if( !$this->sseq ) $this->sseq = time().rand(11, 99).sprintf("%03s",$d['ecare_no']);
      $this->tseq = $this->sseq.sprintf("%05s", $this->kk);
      $SEQ =  $this->tseq;

//      echo $this->tseq."<BR>";


      //인터페이스 테이블
      $query = "
        insert into nvrealtimeaccept(
                ECARE_NO,
                RECEIVER_ID,
                CHANNEL,
                SEQ,
                REQ_DT,
                REQ_TM,
                TMPL_TYPE,
                RECEIVER_NM,
                RECEIVER,
                SENDER_NM,
                SENDER,
                SUBJECT,
                SEND_FG,
                DATA_CNT        
        ) values (
                 ".$this->ECARE_NO.",
                 '".$SEQ."',
                 'M', 
                 ".$SEQ.",
                 ".date("Ymd").",
                 ".date("His").",
                 'T',
                 '".$this->RECEIVER_NM."',
                 '".$this->RECEIVER."',
                 '".$this->SENDER_NM."',
                 '".$this->SENDER."',
                 '".$this->SUBJECT."',
                 'R',
                 1 
        ); 
      ";
//      header('Content-Type: text/html; charset=euc-kr'); 
//      die( "<pre>" . $query . "</pre>");
//echo $query;
      $result = $this->conn->query($query);if(DB::isError($result)) {die("ms3".$result->getMessage()); }
      //메일 body
      $query = "
        insert into NVREALTIMEACCEPTDATA (
           SEQ, 
           DATA_SEQ,  
           ATTACH_YN, 
           DATA
        ) values (
           ".$SEQ.",
           ".$this->kk.",
           'N',
           '".$this->DATA."'
        );
      ";

      $result = $this->conn->query($query);if(DB::isError($result)) {die("ms4".$result->getMessage()); }

      $this->kk++;

    }// end if
  }


  //메일 정보 셋팅
  function mailInfoSet($d) {
    //발신자 명
    $this->SENDER_NM = ereg_replace("'", "''", $d['from_name']);

    //발신자 이메일
    $this->SENDER = ereg_replace("'", "''", $d['from_email']);

    //메일 내용
    $this->DATA = ereg_replace("'", "''", $d['mail_body']);

    //메일 제목
    $this->SUBJECT = ereg_replace("'", "''", $d['subject']);

    //이케어 번호
    $this->ECARE_NO = $d['ecare_no'];

    //수신자 이메일 처리
    $this->RECEIVER  = ereg_replace("'", "''", trim($d['to_email']));

    //수신자 성명
    $this->RECEIVER_NM  = ereg_replace("'", "''", trim($d['to_name']));

    //수신자 성명이 없다면 메일로 대체
    if(!$this->RECEIVER_NM){
      $this->RECEIVER_NM = $this->RECEIVER;
    } 

  }

  //메일 정보 euc-kr로 변경
  function charsetConvertEucKr($d) {
    foreach($d as $_tmp['k'] => $_tmp['v'])
      if (is_array($d[$_tmp['k']]))
        foreach($d[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1'])
          $d[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = iconv('UTF-8', 'EUC-KR',$_tmp['v1']);
      else $d[$_tmp['k']] = ${$_tmp['k']} = iconv('UTF-8', 'EUC-KR',$_tmp['v']);
    
    
    
    
    return $d;
  }

  //해당 customer_key의 메일 코드값을 가지고 온다.
  function get_codes(){
      if(!$this->conn){
      $this->conn();
    } 
    $this->err_qry = "SELECT [ERROR_CD], [ERROR_DESC] FROM [wiseU].[dbo].[NVSENDERR] ";

    $result= $this->conn->query( $this->err_qry );
    if(DB::isError($result)) die("ms5".$result->getMessage());
    while($data = $result->fetchRow(DB_FETCHMODE_ASSOC)) $this->mail_codes[$data['ERROR_CD']] =  iconv('EUC-KR', 'UTF-8', $data['ERROR_DESC']);

    return $this->mail_codes;
  }

  //해당 SEQ값을 기준으로 해당 CODE 정보를 뽑아온다.
  function get_rcode( $ecare_no, $key, $count )
  { 
    if(!$this->conn) $this->conn(); 

    $query = "select count(*) from dbo.NVECARESENDLOG where ECARE_NO = ".$ecare_no." and CUSTOMER_KEY like '".$key."%' ";
    $rcount = $this->conn->getOne( $query );

    if( $rcount != $count )
    {
      return false; // 두값이 같지 않으면 아직 발송이 완료되지 않은것.
    }
    else
    {
      $cds = array();
      $query = "select ERROR_CD, CUSTOMER_KEY from dbo.NVECARESENDLOG where ECARE_NO = ".$ecare_no." and CUSTOMER_KEY like '".$key."%' ";
      $result= $this->conn->query($query);
      if(DB::isError($result)) die("rm3".$result->getMessage());
      while(is_array($c = $result->fetchRow(DB_FETCHMODE_ASSOC))) $cds[$c['CUSTOMER_KEY']] = $c['ERROR_CD'];

      return $cds; //코드 목록을 배열로 저장해서 반환
    }
  }


  ### db 끊기
  function disconnect(){
    if( $this->conn ) $this->conn->disconnect();
  }

  
}


/*
121.254.129.73
administrator / hpdl380

select * from dbo.NVECARESENDLOG where
(ECARE_NO = '18'  or ECARE_NO = '11')
and 
(CUSTOMER_EMAIL = 'dyhan0131@naver.com' or CUSTOMER_EMAIL = 'juban@hanmai.net')
and customer_key ='1334644181'




select * from nvrealtimeaccept where 
(ECARE_NO = '18'  or ECARE_NO = '11')
and 
(receiver = 'dyhan0131@naver.com'or receiver = 'juban@hanmai.net')
and seq = '1334644181'

select 
t2.ECARE_NO, t2.CUSTOMER_EMAIL, t2.CUSTOMER_NM,
t2.SEND_DOMAIN, t2.SEND_DT, t2.SEND_TM, t2.ERROR_CD
from nvrealtimeaccept as t1, NVECARESENDLOG as t2
where 
(t1.ECARE_NO = '18'  or t1.ECARE_NO = '11')
and t1.ECARE_NO = t2.ECARE_NO

and t1.receiver = 'dyhan0131@naver.com'
and t1.receiver = t2.CUSTOMER_EMAIL
and t1.SEQ = '1334644181'
and t1.seq = t2.customer_key
and t1.result_seq = t2.result_seq

*/
?>