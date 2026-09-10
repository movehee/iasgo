<?
##### 환경파일 include
include "config.php";

procLoginChk();

include "./conf/class.FileUpload.php";


//member_gubun 값이 초기화되서 재정의 해준다.
if($to_name_group == "1"){
	$_POST['member_gubun'] = $_POST['member_gubun1'];
}else if($to_name_group == "3"){
	$_POST['member_gubun'] = $_POST['member_gubun3'];
}

$member_gubun = $_POST['member_gubun'];

/*
echo "<pre>";
print_r($_POST);
echo "</pre>";	
*/


######### 업로드 시키기#########
$isUploaded = "false";

$saveDir_mail = $DOCUMENT_ROOT . 'upload/group_mail/';


$file_query = "";
for($i = ($file_total_count-1); $i < 10; $i++){

	$formname = "userfile" . ($i+1);
	$userfile_name = time().'_'.${$formname . "_name"};
	$original_name = ${$formname . "_name"};
	$userfile_type = ${$formname . "_type"};
	$userfile_size = ${$formname . "_size"};
	$tmpfile = ${$formname};

	if($userfile_size > 0){
		$db_userfile_name[$i] = $userfile_name;
		$uploadedFile = new FileUpload($formname,$userfile_name,$userfile_type,$userfile_size);
		$uploadedFile->setProhibitedExtByArray($prohibitedExt);

		if($uploadedFile->isUploaded($formname)) {
			$isUploaded = "true";
			if(!filetype($saveDir_mail)) {
				if(!@mkdir($saveDir_mail,0777)) {
					PutMessageBack("파일을 업로드할 디렉토리를 생성하지 못했습니다.\\n퍼미션을 확인하시기 바랍니다.");
				}
			}

			if(!$uploadedFile->isUploadable($formname)) {
				PutMessageBack("업로드 할 수 없는 파일 입니다.");
			}

			if($uploadedFile->isDuplicate($formname,$saveDir_mail)) {
				for($j = 0; $j < $i; $j++) {
					$fileNameToDelete = ${"userfile" . ($j+1) . "_name"};
					unlink($saveDir_mail . $fileNameToDelete);
				}
				PutMessageBack("등록하시려는 파일명과 같은 파일이 이미 존재합니다.\\n파일명을 바꾸신 후 등록하시기 바랍니다.");
			}

			$destinationPath = $saveDir_mail . $uploadedFile->getUploadedFileName($formname);
			if(!copy($tmpfile,$destinationPath)) {
				PutMessageBack("예기치 않은 오류로 인해 파일업로드에 실패하였습니다.\\n\\n잠시후 다시 업로드하여 주십시오.");
			}// copy
		}
		$FILE_R[$i] = $userfile_name;
		$FILE_O[$i] = $original_name;

		$file_query .= ", file_name".($i+1)."='${FILE_O[${i}]}',read_name".($i+1)."='${FILE_R[${i}]}'";


	}//if size
}//end for
//exit;

for($i=1;$i<=10;$i++){
	if($_POST["file_del${i}"] == 'Y'){
		$file_query .= ", file_name${i}='', read_name${i}=''";
	}
}

##회원발송
if($to_name_group == '1'){
	if($member_gubun[0] == 'all'){
		$member_gubun_text = "all";
	}else{
		$j=0;
		foreach($member_gubun as $tkey=>$tval){
			if($j > 0){
				$member_gubun_text .= ",";
			}
			$member_gubun_text .= "${tval}";
			$j++;
		}
	}
	##위원회/연구회발송
}else if($to_name_group == '2'){
		if($member_gubun[0] == 'all'){
			$member_gubun_text = "all";
		}else{
			$j=0;
			foreach($member_gubun as $tkey=>$tval){
				if($j > 0){
					$member_gubun_text .= ",";
				}
				$member_gubun_text .= "${tval}";
				$j++;
			}
		}
		##주소록발송
	}else if($to_name_group == '3'){
		if($member_gubun[0] == 'all'){
			$member_gubun_text = "all";
		}else{
			$j=0;

			foreach($member_gubun as $tkey=>$tval){
				if($j > 0){
					$member_gubun_text .= ",";
				}

				$member_gubun_text .= "${tval}";
				$j++;
			}
		}
		##테스트발송
	}

$query = "update $mail_tbl set subject='${subject}', send_name='${from_name}', send_email='${from_email}'";
$query .= ",member_gubun='${member_gubun_text}', more_reciper='${to_value2_text}' ${file_query}";
$query .= ", template='${mail_template}', content='${_POST['b_body']}'";
$query .= ", to_name_group='${to_name_group}', btn_type='${btn_type}', btn_link='${btn_url}'";
$query .= " where sid='${_GET['sid']}'";

//die($query);

$result = $conn->query($query);
if(DB::isError($result)) die($result->getMessage());

PutMessageCloseOpenerReload("수정이 완료 되었습니다.","/admin/mail/list.php?search_query=".urlencode($search_query));

?>