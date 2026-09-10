<?
include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PPTC 2026</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>

<link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/flatly/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="./countdown/dist/css/autorefresher.min.css">
<style>
body { overflow: hidden; height: 100vh; background: #fafafa; }
h1 { margin-bottom: 50px; font-family: 'Quicksand'; }
.container { margin: 150px auto; }
</style>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	
	$('#tag_number').focus();

});
</script>
<?
	$day=1;
	if(date("Y-m-d")=='2026-06-19'){
		$day=2;
	}

	if($tag_key=='4'){
		//$day=2;
		//$tag_key = 962;
	}

	$query = "select * from registration_tbl  where sid='".$tag_number."'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();


	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//echo $query;
	}

	if($d['name_eng']){
		$tag_name = $d['name_eng'];
	}else{
		$tag_name = $d['name_kr'];
	}
	if($d['aff_eng']){
		$tag_aff = $d['aff_eng'];
	}else{
		$tag_aff = $d['aff_kor'];
	}
	
	
	
	if($d['kind']=='score'){
		$link = "dinner.php";
	}else{
		$link = "dinner.php";
		//$link = "index2.php";
	}
	if($d['etc_field11']=='127'){
		if($reject!="Y"){
			/*$update_query = "update registration_tbl set etc_field5='117',ready_date1='".time()."' where sid='".$tag_number."'";
			$update_result = $conn->query($update_query);
			if(DB::isError($update_result)) {
				die($update_result->getMessage());
			}*/
		}
	}
?>
</head>
<body  onclick="$('#tag_number').focus();">
<div class="wrapper attendance">
	<div class="auto-refresher mt-auto mb-auto"></div>
	<div class="sub-visual">
		서브비쥬얼
	</div>

	<form id="tagF" name="tagF" action="tag_dinner_reg.php" method="post" autocomplete="off" >
	<input type="hidden" name="day" id="day" value="<?=$day?>" >
	<input type="hidden" name="kind" id="kind" value="<?=$kind?>" >
	
	<div class="contents">
		
		

		<div id="container">
            <div class="contents">
                <div class="table-wrap">
                    <table class="cst-table type2">
                        <caption class="hide">PPTC Registration Rates</caption>
                        <colgroup>
                            <col style="width: 40%;">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td><?=$tag_name?></td>
                            </tr>
                            <tr>
                                <th>Affiliation</th>
                                <td><?=$tag_aff?></td>
                            </tr>
                            <tr>
                                <th>Dinner</th>
                                <td>
									<?if($d['etc_field11']=='127'){?>
										<span style="color:#CA0C5D;">You are not the target.</span>
									<?}else{?>
										<?if($d['etc_field5']=='117'){?>
											<span style="">I have already participated.</span>
										<?}else{?>
											Attend
										<?}?>
									<?}?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
	<?
	if($reject!='Y'){
		$query = "update registration_tbl set etc_field5='117' where sid='".$tag_number."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	?>
	<div style="position:absolute;top:0px;z-index:-1;">
		<input type="text" name="tag_number" id="tag_number" value="<?=$tag_number?>" >
	</div>
	</form>
	<!-- //contents -->
</div>	
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="./countdown/dist/js/autorefresher.js"></script>
	<?if($_SERVER['REMOTE_ADDR']!='218.235.94.2220'){?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.auto-refresher').autoRefresher({
                seconds: 2,
                callback: function () {
                   location.href="<?=$link?>";
                },
                progressBarHeight: '0px',
                showControls: false,
                //stopButtonClass: 'btn btn-sm btn-outline-secondary m-1',
                //stopButtonInner: '<i class="fas fa-stop"></i>',
                //startButtonClass: 'btn btn-sm btn-outline-secondary m-1',
                //startButtonInner: '<i class="fas fa-play"></i>',
            });
        })
    </script>
	<?}?>
</body>
</html>
