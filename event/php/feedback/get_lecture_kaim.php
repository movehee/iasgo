<?
	header('Content-Type: text/html; charset=utf-8');
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

	//$code = "kaim5";
	
	$a_query = "select sid, FROM_UNIXTIME(eventdate) as event_date from agenda_tbl where del='N' and code='$code' order by day asc";
	$a_result = mysqli_query($conn, $a_query);

	//$now_date = "2019-12-06";
	$now_date = date('Y-m-d');

	while(is_array($a_col = mysqli_fetch_array($a_result))){

		if($now_date < $a_col['event_date']) {
			$tab = $a_col['sid'];
			break;
		}

		$ltab = $a_col['sid'];

	}

	if(!$tab) $tab = $ltab; //마지막행사일자가 지나게되면 마지막날이 나오게 하기위함



	$query = "select b.* from session_tbl a, session_tbl b where 
	a.sid=b.link_session and a.code='$code' and a.tab='$tab' and ifnull(b.speaker,'')!='' order by b.orderby";
	$result = mysqli_query($conn, $query);
	while(is_array($col = mysqli_fetch_array($result))){
		
		/*
		echo $col['speaker'];
		echo "<br/>";
		echo $col['title'];

		echo "<br/>";
		echo "<br/>";

		$json[] = array(
			'lecture'=>"[소화기] 김지현(인제의대)",
			'subject'=>"[소화기] 식도질환");

		*/
		
		$cut = explode("]", $col['title']);
		

		$json[] = array(
			'lecture'=>$cut[0]."]  ".$col['speaker'],
			'subject'=>$col['title']);
	}

	echo json_encode($json);


