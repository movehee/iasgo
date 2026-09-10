<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.Template.php";
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.mailsend.php";


	/*$query = "insert into e_poster_view_tbl set psid='".$psid."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}*/

	$query = "select * from e_poster where sid='".$psid."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <style>
        /* 1. 브라우저 기본 여백 제거 및 전체 높이 확보 */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden; /* 팝업 자체 스크롤 방지 */
        }

        /* 2. iframe을 부모 크기에 맞춤 */
        .full-iframe {
            width: 100%;
            height: 100%;
            border: none;    /* 테두리 제거 */
            display: block;  /* 하단 미세 공백 방지 */
        }
    </style>
</head>
<body>

    <iframe src="<?=$d['movie']?>" class="full-iframe"></iframe>
	
</body>
</html>

<!-- <script>location.href="https://eposter.ksers-event.ezv.kr/upload/e_poster/<?=$fname?>";</script> -->