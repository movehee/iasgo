<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query="SELECT * FROM event_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$event_col = mysqli_fetch_array($result);

include_once $_SERVER['DOCUMENT_ROOT']."/string.php";

$result = mysqli_query($conn, "select count(*) cnt from feedback_result_tbl where code='".$code."' and deviceid='".$deviceid."' and tab='".$tab."'");
$row = mysqli_fetch_array($result);


if($code == "ge0712") {

	if($answer6 == '2') {
		$memo3 = $answer7 = "";
	}
}

if($row['cnt']>0)
{
	$query = "update feedback_result_tbl SET ";
	$query .= "name='".$name."'";
	$query .= ",tab='".$tab."'";
	$query .= ",office='".$office."'";
	$query .= ",email='".$email."'";
	$query .= ",license='".$license."'";
	$query .= ",mobile='".$mobile."'";
	$query .= ",memo1='".$memo1."'";
	$query .= ",memo2='".$memo2."'";
	$query .= ",memo3='".$memo3."'";
	$query .= ",memo4='".$memo4."'";
	$query .= ",memo5='".$memo5."'";
	$query .= ",memo6='".$memo6."'";
	$query .= ",memo7='".$memo7."'";
	$query .= ",memo8='".$memo8."'";
	$query .= ",memo9='".$memo9."'";
	$query .= ",memo10='".$memo10."'";

	$query .= ",memo11='".$memo11."'";
	$query .= ",memo12='".$memo12."'";
	$query .= ",memo13='".$memo13."'";
	$query .= ",memo14='".$memo14."'";
	$query .= ",memo15='".$memo15."'";
	$query .= ",memo16='".$memo16."'";
	$query .= ",memo17='".$memo17."'";
	$query .= ",memo18='".$memo18."'";
	$query .= ",memo19='".$memo19."'";
	$query .= ",memo20='".$memo20."'";
	$query .= ",memo21='".$memo21."'";

	$query .= ",answer1='".$answer1."'";
	$query .= ",answer2='".$answer2."'";
	$query .= ",answer3='".$answer3."'";
	$query .= ",answer4='".$answer4."'";
	$query .= ",answer5='".$answer5."'";
	$query .= ",answer6='".$answer6."'";
	$query .= ",answer7='".$answer7."'";
	$query .= ",answer8='".$answer8."'";
	$query .= ",answer9='".$answer9."'";
	$query .= ",answer10='".$answer10."'";

	$query .= ",answer11='".$answer11."'";
	$query .= ",answer12='".$answer12."'";
	$query .= ",answer13='".$answer13."'";
	$query .= ",answer14='".$answer14."'";
	$query .= ",answer15='".$answer15."'";
	$query .= ",answer16='".$answer16."'";
	$query .= ",answer17='".$answer17."'";
	$query .= ",answer18='".$answer18."'";
	$query .= ",answer19='".$answer19."'";
	$query .= ",answer20='".$answer20."'";

	$query .= ",answer21='".$answer21."'";
	$query .= ",answer22='".$answer22."'";
	$query .= ",answer23='".$answer23."'";
	$query .= ",answer24='".$answer24."'";
	$query .= ",answer25='".$answer25."'";
	$query .= ",answer26='".$answer26."'";
	$query .= ",answer27='".$answer27."'";
	$query .= ",answer28='".$answer28."'";
	$query .= ",answer29='".$answer29."'";
	$query .= ",answer30='".$answer30."'";

	$query .= ",answer31='".$answer31."'";
	$query .= ",answer32='".$answer32."'";
	$query .= ",answer33='".$answer33."'";
	$query .= ",answer34='".$answer34."'";
	$query .= ",answer35='".$answer35."'";
	$query .= ",answer36='".$answer36."'";
	$query .= ",answer37='".$answer37."'";
	$query .= ",answer38='".$answer38."'";
	$query .= ",answer39='".$answer39."'";
	$query .= ",answer40='".$answer40."'";
	$query .= ",signdate='".time()."'";
	$query .= ",regip='".$_SERVER['REMOTE_ADDR']."'";
	$query .= " where code='".$code."' and deviceid='".$deviceid."' and tab='".$tab."'";

}
else
{

	$query = "INSERT INTO feedback_result_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ",regist_sid='".$regist_sid."'";
	$query .= ",name='".$name."'";
	$query .= ",office='".$office."'";
	$query .= ",email='".$email."'";
	$query .= ",license='".$license."'";
	$query .= ",mobile='".$mobile."'";
	$query .= ",deviceid='".$deviceid."'";
	$query .= ",memo1='".$memo1."'";
	$query .= ",memo2='".$memo2."'";
	$query .= ",memo3='".$memo3."'";
	$query .= ",memo4='".$memo4."'";
	$query .= ",memo5='".$memo5."'";
	$query .= ",memo6='".$memo6."'";
	$query .= ",memo7='".$memo7."'";
	$query .= ",memo8='".$memo8."'";
	$query .= ",memo9='".$memo9."'";
	$query .= ",memo10='".$memo10."'";

	$query .= ",memo11='".$memo11."'";
	$query .= ",memo12='".$memo12."'";
	$query .= ",memo13='".$memo13."'";
	$query .= ",memo14='".$memo14."'";
	$query .= ",memo15='".$memo15."'";
	$query .= ",memo16='".$memo16."'";
	$query .= ",memo17='".$memo17."'";
	$query .= ",memo18='".$memo18."'";
	$query .= ",memo19='".$memo19."'";
	$query .= ",memo20='".$memo20."'";
	$query .= ",memo21='".$memo21."'";

	$query .= ",tab='".$tab."'";
	$query .= ",answer1='".$answer1."'";
	$query .= ",answer2='".$answer2."'";
	$query .= ",answer3='".$answer3."'";
	$query .= ",answer4='".$answer4."'";
	$query .= ",answer5='".$answer5."'";
	$query .= ",answer6='".$answer6."'";
	$query .= ",answer7='".$answer7."'";
	$query .= ",answer8='".$answer8."'";
	$query .= ",answer9='".$answer9."'";
	$query .= ",answer10='".$answer10."'";

	$query .= ",answer11='".$answer11."'";
	$query .= ",answer12='".$answer12."'";
	$query .= ",answer13='".$answer13."'";
	$query .= ",answer14='".$answer14."'";
	$query .= ",answer15='".$answer15."'";
	$query .= ",answer16='".$answer16."'";
	$query .= ",answer17='".$answer17."'";
	$query .= ",answer18='".$answer18."'";
	$query .= ",answer19='".$answer19."'";
	$query .= ",answer20='".$answer20."'";

	$query .= ",answer21='".$answer21."'";
	$query .= ",answer22='".$answer22."'";
	$query .= ",answer23='".$answer23."'";
	$query .= ",answer24='".$answer24."'";
	$query .= ",answer25='".$answer25."'";
	$query .= ",answer26='".$answer26."'";
	$query .= ",answer27='".$answer27."'";
	$query .= ",answer28='".$answer28."'";
	$query .= ",answer29='".$answer29."'";
	$query .= ",answer30='".$answer30."'";

	$query .= ",answer31='".$answer31."'";
	$query .= ",answer32='".$answer32."'";
	$query .= ",answer33='".$answer33."'";
	$query .= ",answer34='".$answer34."'";
	$query .= ",answer35='".$answer35."'";
	$query .= ",answer36='".$answer36."'";
	$query .= ",answer37='".$answer37."'";
	$query .= ",answer38='".$answer38."'";
	$query .= ",answer39='".$answer39."'";
	$query .= ",answer40='".$answer40."'";
	$query .= ",signdate='".time()."'";
	$query .= ",regip='".$_SERVER['REMOTE_ADDR']."'";






	if($code == "koa2020s") {
		$p_num = 3;

		$f_result = mysqli_query($conn, "select sid from feedback_result_tbl where code='koa2020s'");
		$f_num = $f_result->num_rows;
		
		if(($f_num+1)%$p_num == 0) {
			$event_info = ($f_num+1) / $p_num;

			$query .= ",event_yn='Y',event_info='$event_info'";
		}

	}







}
//echo $query;
mysqli_query($conn, $query);
//"감사합니다. 모든 설문이 완료되었습니다."
//echo "./view.php?alert=Y&deviceid=$deviceid&code=$code";
//PutMessageRefreshURL($string['feedback_alert3'],"./view.php?code=$code&deviceid=$deviceid");


?>
<script>
	var alert_message = "<?php echo $string['feedback_alert3']?>";
	var url = "./view.php?code=<?php echo $code?>&deviceid=<?php echo $deviceid?>&title=<?=$title?>";

	alert(alert_message);
	//history.back();
	location.href=url;
	//alert(url);
</script>
