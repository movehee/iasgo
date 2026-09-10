<?
//ini_set( "display_errors", 1 );
//echo "<pre>";

require_once "./config.php";
require_once "./conf/class.mailsend.php";

if(!isAdminLogined())
{
  echo '접근권한이 없습니다.';
  exit;
}

set_time_limit(0); //대기시간 무한대

$mid = $_POST['mid'];
$id = $_POST['sid'];
$n = $_POST['n'];
$M2mail = new M2mail('wiseU');

//echo "mid : $mid sid : $sid n : $n"; exit;

if( $n == "2" )
{
  $query = "select count(*) from $mail_list_tbl where mail_sid = $id ";
  $count_seq = $conn->getOne($query); //메일의 개수
  
  	## 성공인건 건너뛴다.
	$query = "select * from $mail_list_tbl where mail_sid = '$id' and (code ='' or code is null)";
	$result = $conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	$i=1;
	
	$coerce_chk = 1;
	 
	while(is_array($d = $result->fetchRow(DB_FETCHMODE_ASSOC))){
		$code = $M2mail->get_rcode( $_ECARE_NO, $d['seq'], $count_seq, $coerce_chk);
		if($code){
			$query = "update $mail_list_tbl set code = '".$code."' where mail_sid = '".$id."' and seq = '".$d['seq']."' ";
			$rlt= $conn->query( $query );
			if(DB::isError($rlt)) die("2".$rlt->getMessage());
			
		}
	}
	
	echo "갱신이 완료되었습니다.";

/*
  $query = "select substring(seq, 1, 15) from $mail_list_tbl where mail_sid = $id limit 1";
  $key_seq = $conn->getOne($query); //

  //하루가 지나도 갱신이 안될경우, ecare_send_log가 제대로 다 쌓이지 않았어도 강제로 값을 받아오게 하는 부분
  if( time() - substr($key_seq, 0, 10) > 60*60*4 ) $coerce_chk = 1;

  if( $marr = $M2mail->get_rcode( $_ECARE_NO, $key_seq, $count_seq, $coerce_chk) )
  {
    foreach( $marr as $tkey=>$tval )
    {     
      $query = "update $mail_list_tbl set code = '".$tval."' where mail_sid = '".$id."' and seq = '".$tkey."' ";
      $rlt= $conn->query( $query );
      if(DB::isError($rlt)) die("2".$rlt->getMessage());
    }
    echo "갱신이 완료되었습니다.";
  }
  else
  {
    echo "아직 발송되지 않은 메일 목록이 있습니다. \r\n잠시뒤에 다시 갱신을 해주세요.";
  }
*/
}

$M2mail->disconnect();
$conn->disconnect();

?>