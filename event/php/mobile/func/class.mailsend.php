<?php
include_once 'DB.php';


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


  //Linux
  function conn(){
    ##### 데이터베이스에 연결한다.
    $dsn = "mssql://".$this->userName.":".$this->userPassword."@".$this->hostName."/".$this->dbName;
    $this->conn = DB::connect($dsn);
    if(DB::isError($this->conn)) {
       die ($this->conn->getMessage());
    }

  }

  //Window
  function connS(){
    ##### 데이터베이스에 연결한다.
    $dsn = "sqlsrv://".$this->userName.":".$this->userPassword."@".$this->hostName."/".$this->dbName;
    $this->conn = DB::connect($dsn);
    if(DB::isError($this->conn)) {
       die ($this->conn->getMessage());
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
  function send($d, $charset, $mail = '',$t='') {
    if($this->sendSel == 'wiseU'){
      $this->conn();
      $this->wiseU($d, $charset,$t);  
    }elseif($this->sendSel == 'sendmail'){
      $this->Sendmail($d, $mail);
    }
  }


  //대용량 메일로 발송
  function wiseU($d, $charset,$t=''){

    if(!$this->conn){
      $this->conn();
      echo $this->conn;
    } 
	
	if($charset == 'UTF-8' || $charset == 'utf-8'){
	  $this->convetEncoding($d, $charset);
      $d = $this->charsetConvertEucKr($d);
    }

    //메일 정보 셋팅
    $this->mailInfoSet($d);

    //수신자 이메일 있다면 발송
    if($this->RECEIVER){

      $SEQ = time() + $ECARE_NO + $this->kk . "_" . $this->ECARE_NO . "_" . $t;

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
                 '".$SEQ."',
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

      $result = $this->conn->query($query);if(DB::isError($result)) {die($result->getMessage()); }

      //메일 body
      $query = "
        insert into NVREALTIMEACCEPTDATA (
           SEQ, 
           DATA_SEQ,  
           ATTACH_YN, 
           DATA
        ) values (
           '".$SEQ."', /* SEQ: time()+1 / 메일 body 의 외래키 = SEQ */ 
           ".$this->kk.", /* DATA_SEQ: insert 시 초기값 1 설정 하고 1씩 증가 */
           'N', /* ATTACH_YN: 첨부파일 N */ 
           '".$this->DATA."' /* DATA: 메일 내용 */ 
        );
      ";

      $result = $this->conn->query($query);if(DB::isError($result)) {die($result->getMessage()); }

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
          $d[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = iconv('UTF-8', 'cp949',$_tmp['v1']);
      else{
		  $d[$_tmp['k']] = ${$_tmp['k']} = iconv('UTF-8', 'cp949',$_tmp['v']);
	  }   
    return $d;
  }
  function convetEncoding(&$d, $charset="UTF-8") {
    
    $d['mail_body']	=	$this->uni2html($d['mail_body']);
    if(strlen($d['from_name'])>27) $d['from_name'] = mb_strcut($d['from_name'],0, 24).'...';
    if(strlen($d['to_name'])>27)   $d['to_name'] = mb_strcut($d['to_name'],0, 24).'...';
    $d['from_name'] = "=?".$charset."?B?".base64_encode($d['from_name'])."?=\n";
    $d['to_name'] = "=?".$charset."?B?".base64_encode($d['to_name'])."?=\n";
    $d['subject']	=	"=?".$charset."?B?".base64_encode($d['subject'])."?=\n";
  }
  
  function uni2html($str) {
    $result = "";
    $len = strLen($str);
    for($i = 0; $i < $len; $i++) {
      $temp = $c = mb_subStr($str, $i, 1, "UTF-8");
      $h = ord($c{0});
      if (strlen($c) > 1) {
        if ($h <= 0xDF)
          $temp = ($h & 0x1F) << 6 | (ord($c{1}) & 0x3F);
        else if ($h <= 0xEF)
          $temp = ($h & 0x0F) << 12 | (ord($c{1}) & 0x3F) << 6 | (ord($c{2}) & 0x3F);
        else if ($h <= 0xF4)
          $temp = ($h & 0x0F) << 18 | (ord($c{1}) & 0x3F) << 12 | (ord($c{2}) & 0x3F) << 6 | (ord($c{3}) & 0x3F);
        
        $temp = "&#$temp;";
      }
      $result .= $temp;
    }
    return $result;
  }

  ### db 끊기
  function disconnect(){
    $this->conn->disconnect();
  }

}
?>