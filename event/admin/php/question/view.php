<?
include $DOCUMENT_ROOT . 'func/include.function.php';
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

if(empty($code))
{
	RefreshURL("/admin/php/login.php");
}else{

	$result = mysqli_query($conn, "SELECT * FROM event_tbl where code='".$code."'");
	$event_db = mysqli_fetch_array($result);

}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="kor" xml:lang="kor"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<title><?=$event_db['name']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/admin/css/common_v2.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/voting.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/feedback.css" />
<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->

<link href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-1.11.1.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

</head>
<body>

<div class="">

<?
	$query = "";
if ( $code == "korl2019" ) {
	$query="SELECT * FROM question_tbl where del='N' and question_tbl.show='Y' and lecture = '' and code='".$code."'";
} else {
	$query="SELECT * FROM question_tbl where del='N' and question_tbl.show='Y' and code='".$code."'";	
}


if($room) {
	$query .= " and room='$room'";
}

$query.=" order by sid desc";
$result = mysqli_query($conn, $query);
?>
<div id="container">
	
		<h2>Question List </h2>
		<div class="contents">
			<div style="top: -44px; right: 350px; position: absolute;">
			<input type="checkbox" name="reload" id="reload" value="Y" <?if($reload=='Y'){?>checked<?}?> ><label for="reload">새로고침<label>
			</div>
			<select name="room" id="room" style="top: -44px; right: 0px; position: absolute;width:300px;">
				<option value="">All</option>
				<?if($event_db['session_sync']=='Y') {
				
				
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/voting_sync/config/'.$code.'.php')) {
					include_once $_SERVER['DOCUMENT_ROOT']."/voting_sync/config/".$code.".php";
				}
				
				$sync_url = $_URL['room'];

				if($url_param) {
					$sync_url .= "?".implode("&", $url_param);
				}

				$json_string = file_get_contents($sync_url);
				$room_arr = json_decode($json_string, true);
			

			foreach($room_arr as $room_key => $room_col) {?>
				<option value="<?=$room_key?>" <?if($room==$room_key){?>selected<?}?>> <?=$room_col['name']?> (<?=$room_key?>)</option>
			<?}


				} else {
					$r_query = "select b.sid,b.name as room_name,c.name agenda_name from session_tbl a, session_room_tbl b, agenda_tbl c where a.room=b.sid and b.tab=c.sid and b.del='N' and a.code='".$code."' and a.type='1' and a.qna_viewYN='Y' group by a.room  order by b.tab, b.orderby;";

					$r_result = mysqli_query($conn, $r_query);
					while(is_array($r = mysqli_fetch_array($r_result))){
				?>
				<option value="<?=$r['sid']?>" <?if($room==$r['sid']){?>selected<?}?>><?=$r['agenda_name']?> <?=$r['room_name']?> (<?=$r['sid']?>)</option>
				<?}?>
				<?}?>
			</select> 
			

			<table class="tblList question">
				<colgroup>
					<col style="width: *;">
					<col style="width: 10%;">
				</colgroup>
				<thead>
					<tr>
						<th>Question</th>
						<th>선택여부</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
				<tr>
					<td class="al">
						<p class="question_title"><strong><?=$d['lecture']?></strong></p>
						<p class="question_con"><?=nl2br($d['question'])?></p>
					</td>
					<td class="btn"><a href="#" onclick="javascript:viewYN('<?=$d['view']?>','<?=$d['sid']?>','<?=$code?>')" class="btnBdDef <?if($d['view']=="N"){?> ok<?}?>"><?if($d['view']=="N"){?> 미<?}?>선택</a></td>
				
				</tr>
				<?}?>
					
				</tbody>
			</table>

		</div>
		<!-- //contents -->
			
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">
	var reload=false;

	$(function() {
		$("#room").on("change", function(){
			location.href = '<?=$_SERVER[PHP_SELF]?>?code=<?=$code?>&room=' + $(this).val();
		});


		$("#reload").on("click", function(){
			if($(this).is(":checked")) {
				
				reload = setInterval(function() {
					location.href = '<?=$_SERVER[PHP_SELF]?>?code=<?=$code?>&room=<?=$room?>&reload=Y'
				}, 5000);
			}
			else {
				clearInterval(reload);
			}
		});

		if($("#reload").is(":checked")) {
			reload = setInterval(function() {
				location.href = '<?=$_SERVER[PHP_SELF]?>?code=<?=$code?>&room=<?=$room?>&reload=Y'
			}, 5000);
		}
	});

	function viewYN(val,sid,code) {
		window.open("./viewYN.php?view="+val+"&sid="+sid+"&code="+code,"","width=1,height=1");
	}

</script>

   
<?include "./../footer.php";?>