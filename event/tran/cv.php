<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
        
    $path = "./file";
    $files = array_diff(scandir($path), array('.', '..'));

    foreach ($files as $file) {

        $pre_num = str_replace(".pdf", "", $file);



        $query = "select * from workshop_session_detail_tbl where del='N' and pre_num='".$pre_num."'";
        $result = $conn->query($query);
        $result->fetchInto(&$d, DB_FETCHMODE_ASSOC);
        $result->free();

        $cv_file = "cv_". $file;

        if($d) {
            copy($_SERVER['DOCUMENT_ROOT']."/tran/file/".$file, $_SERVER['DOCUMENT_ROOT']."/upload/session/".$cv_file);
            unlink($_SERVER['DOCUMENT_ROOT']."/tran/file/".$file);

            $conn->query("update workshop_session_detail_tbl set cv_file='".$cv_file."' where sid=".$d['sid']);

        }

    }

    echo "END";