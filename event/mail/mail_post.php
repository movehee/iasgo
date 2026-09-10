<?
set_time_limit(0);

##### 환경파일 include
include "config.php";

include "./conf/class.FileUpload.php";
require_once "./conf/class.Template.php";
require_once "./conf/class.mailsend.php";

if("112.76.194.34" == $_SERVER['REMOTE_ADDR'])
{
	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	die;
	
}

//member_gubun 값이 초기화되서 재정의 해준다.
if($to_name_group == "1"){
	$_POST['member_gubun'] = $_POST['member_gubun1'];
}else if($to_name_group == "3"){
	$_POST['member_gubun'] = $_POST['member_gubun3'];
}	


if($page_type != 'processing'){

	$subject = change_replace($subject,"•=>ㆍ,｢=>「,｣=>」");
	$place = $place;
	$from_name = $from_name;
	$from_email = $from_email;
	$to_name = $to_name;
	$to_value2 = str_replace("\r\n", "", $to_value2);
	$to_value2 = str_replace("\\","",$to_value2);

	$to_add_name = $to_add_name;

	$body=stripslashes($_POST['b_body']);
	$body=eregi_replace('src="(../)+http', "src=\"http", stripslashes($body));
	$body=eregi_replace('src="(../)+', "src=\"http://${_SERVER[HTTP_HOST]}/", $body);
	$body=addslashes($body);
	$body=trim($body);
	$body = change_replace($body,"․=>.,｢=>「,｣=>」");

	$send_id = str_replace("\r\n","",$send_id);
	$send_id = str_replace("\\","",$send_id);


	$mail_template = $mail_template;
	$to_name_group = $to_name_group;

	$now_year = date('Y');
	$senddate=time();
	$d = array();


	$name_arr = array();
	$email_arr = array();

	######### 업로드 시키기#########
	$isUploaded = "false";

	$saveDir_mail = $DOCUMENT_ROOT . 'upload/group_mail/';

	$loop_num = $file_total_count;

	if(!$loop_num) $loop_num = 0;
	$file_query = '';

	$query = "select max(sid) as new_sid from $mail_tbl";
	$mail_sid = $conn->getone($query);
	$mail_sid++;

	if(DB::isError($mail_sid)) die($mail_sid->getMessage());

	if($sid) $mail_sid = $sid;

	for($i=1;$i<=10;$i++){
		if($_POST["original_name${i}"]){
			$FILE_O[$i-1] = $_POST["original_name${i}"];
			$FILE_R[$i-1] = $_POST["read_name${i}"];
		}
	}

	for($i=1;$i<=10;$i++){
		if($_POST["file_del${i}"] == 'Y'){
			$file_query .= ", file_name${i}='', read_name${i}=''";
			$FILE_O[$i-1] = '';
			$FILE_R[$i-1] = '';
		}
	}

	for($i = 0; $i < 10; $i++){
		$ext = "";
		$formname = "userfile" . ($i+1);
		//   $userfile_name = time().'_'.${$formname . "_name"};
		$ext_arr = explode('.',${$formname . "_name"});


		//echo ;exit;

		$ext = $ext_arr[count($ext_arr)-1];

		// echo count($ext_arr)-1;exit;
		$userfile_name = time().'_'.rand(1,1000).".".$ext;
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
					if(!@mkdir($saveDir_mail,0707)) {
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
		}
	}




	$attach_text = "<br/><div style='text-align:left;margin-top:10px;line-height:150%;'>";

	if($FILE_O){
		foreach($FILE_O as $tkey=>$tval){
			if($tval){
				$attach_text .= "<span style='color:red;'>첨부파일</span> : <a href='http://".$HTTP_HOST."/upload/group_mail/".$FILE_R[$tkey]."' target='_blank'>".$tval."</a><br/>";
			}
		}
	}

	$attach_text .= "</div>";

	$tpl = new Template("./templates/");
	$tpl->set_file("mail","template.mail0${mail_template}.html");

	if($btn_type == '1'){
		$link_btn = "<a href='http://".$btn_url."' target='_blank'><img src='http://".$HTTP_HOST."/image/pop/btn_detail.gif' alt=''/></a>";
	}else if($btn_type == '2'){
			$link_btn = "<a href='http://".$btn_url."' target='_blank'><img src='http://".$HTTP_HOST."/image/pop/btn_detail.gif' alt=''/></a>";
		}else{
		$link_btn = "";
	}
	
	$tpl->set_var(array(
			'url'=>'http://' . $HTTP_HOST,
			'subject_value'=>stripslashes($subject),
			'body_value'=> stripslashes($body),
			'link_btn'=>$link_btn,
			'site_name'=>$site_name,
			'site_addr'=>$site_addr,
			'site_tel'=>$site_tel,
			'site_fax'=>$site_fax,
			'site_email'=>$site_email,
			'footer2'=>$footer2,
			'date'=>date('Y-m-d'),
			'attach_file'=>$attach_text
		));


	$tpl->parse("mailcontents","mail");
	$html = $tpl->get_var("mailcontents");
	$member_gubun_text = "";


	if($mode == 'test'){
		$d['from_name'] = $from_name;//$adminName;
		$d['from_email'] = $from_email;//$adminEmail;
		$d['mail_body'] = $html;
		$d['subject'] = $subject;
		$d['ecare_no'] = $_ECARE_NO;


		$M2mail = new M2mail('wiseU');

		$total_send_count = 0;


		$d['to_email'] = "${_COOKIE['member_email']}";
		$d['to_name'] = "${_COOKIE['member_name']}";
		$M2mail->send($d, 'EUC-KR');

		PutMessageBack("테스트 메일이 발송 되었습니다.");

		exit;
	}

	##회원발송
	if($to_name_group == '1'){
		if($_POST['member_gubun'][0] == 'all'){
			$query = "select sid,name_kr,email from user_binfo where email_yn='Y' and out_request!='Y' and email  REGEXP '^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,10}$' order by name_kr asc";
			$member_gubun_text = "all";
		}else{
			$query = "select sid,name_kr,email from user_binfo where email_yn='Y' and out_request!='Y' and email  REGEXP '^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,10}$'  ";
			if($_SERVER['REMOTE_ADDR']=="112.76.194.32"){
				$query .= " and name_kr>'김철수'";
			}
			$query .= " and (";
			$j=0;

			foreach($_POST['member_gubun'] as $tkey=>$tval){
				if($j > 0){
					$query .= " or ";
					$member_gubun_text .= ",";
				}

				$query .= " member_level like '%${tval}%' ";
				$member_gubun_text .= "${tval}";
				$j++;
			}
			$query .= ") order by name_kr asc";
		}
		
		if($_SERVER['REMOTE_ADDR']=="112.76.194.32"){
			//echo $query;
			//exit;
		}

		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());

		$i=0;
		while(is_array($m=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$name_arr[$i] = $m['name_kr'];
			if($m['reception_email']=="2"){
				$email_arr[$i] = $m['office_email'];
			}else{
				$email_arr[$i] = $m['email'];
			}
			$i++;
		}
		##주소록발송
	}else if($to_name_group == '3'){
			if($_POST['member_gubun'][0] == 'all'){
				$query = "select t2.c_name,t2.c_email from tp_addgrcode as t1 left join tp_addgrinfo as t2 on t1.c_index=t2.c_code and t2.c_email REGEXP '^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,10}$'";
				$member_gubun_text = "all";
			}else{
				$query = "select * from tp_addgrinfo where c_email > '!' and c_email  REGEXP '^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,10}$' ";
				$query .= " and (";
				$j=0;

				foreach($_POST['member_gubun'] as $tkey=>$tval){
					if($j > 0){
						$query .= " or ";
						$member_gubun_text .= ",";
					}

					$query .= " c_code='${tval}' ";
					$member_gubun_text .= "${tval}";
					$j++;
				}
				$query .= ")";
			}
			
			if("112.76.194.13" == $_SERVER['REMOTE_ADDR']){
				echo $query."<br/>";
			}

			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			//echo $query;
			$i=0;
			while(is_array($m=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				$name_arr[$i] = $m['c_name'];
				$email_arr[$i] = $m['c_email'];

				$i++;
			}
			##선택 회원 발송
		}else if($to_name_group == '5'){
			$query = "select * from user_binfo where id in($send_id)";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());

			$i=0;
			while(is_array($m=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				$id_arr[$i] = $m['id'];
				$name_arr[$i] = $m['name_kr'];
				if($m['reception_email']=="2"){
					$email_arr[$i] = $m['office_email'];
				}else{
					$email_arr[$i] = $m['email'];
				}

				$i++;
			}
		}else if($to_name_group == '6'){
			$query = "select * from event_eregist_list where sid in($send_id)";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());

			$i=0;
			while(is_array($m=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				$id_arr[$i] = $m['sid'];
				$name_arr[$i] = $m['name_kr'];
				$email_arr[$i] = $m['email'];

				$i++;
			}
		}else if($to_name_group == '9'){
			$ex_email = explode(",",$self_mail);
			
			for($s=0;$s<count($ex_email);$s++){
				$name_arr[$s] = $ex_email[$s];
				$email_arr[$s] = $ex_email[$s];
			}
		}else{
			$name_arr[0] = $testing_mail;
			$email_arr[0] = $testing_mail;
		}


	## 메일 DB 저장
	$total_send_count = count($email_arr);


	if($send_type == 'resend'){
		$query = "select max(`order`) from $mail_list_tbl where mail_sid='${_GET['sid']}'";

		$max_order = $conn->getOne($query);
		$max_order++;
	}else{
		$max_order = "1";
	}


	if("112.76.194.13" == $_SERVER['REMOTE_ADDR'])
	{
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		echo $query."<br/>";
		var_dump($email_arr);
		exit;	
	}



	

	foreach($email_arr as $tkey=>$tval){

		$query="SELECT max(sid) FROM $mail_list_tbl";

		$new_sid=$conn->getOne($query);
		if(DB::isError($new_sid)) die($new_sid->getMessage());
		$new_sid=!$new_sid?1:$new_sid+1;

		$mail_sid=$_GET['send_type']=="repost"?$conn->getOne("SELECT MAX(sid)+1 FROM send_email"):$mail_sid;

		$temp_html = $html;
		$temp_html .= "<img src=\"http://${_SERVER[HTTP_HOST]}/admin/mail/read.php?number=${new_sid}\" width=\"1\" height=\"1\" alt=\"\"/>";

		$query="INSERT INTO $mail_list_tbl SET sid='$new_sid', mail_sid='$mail_sid',  id='". $id_arr[$tkey] ."',name='".$name_arr[$tkey]."', email='".$email_arr[$tkey]."',subject='".addslashes($subject)."',mail_body='".addslashes($temp_html)."', senddate='$senddate'";
		$query.=", ecare_no='$_ECARE_NO', send_status='N', from_name='".$from_name."', from_email='".$from_email."',`order`='$max_order'";

		$rst=$conn->query($query);
		if(DB::isError($rst)) die($rst->getMessage());
	}

	if($send_type == 'resend'){
		$query = "update $mail_tbl set subject='${subject}', send_name='${from_name}', send_email='${from_email}'";
		$query .= ",member_gubun='${member_gubun_text}', more_reciper='${to_value2_text}' ${file_query}";
		$query .= ", template='${mail_template}', content='${body}', send_count = send_count+1";
		$query .= ", to_name_group='${to_name_group}', total_send=total_send+${total_send_count}";
		$query .= ", btn_type='${btn_type}', btn_link='${btn_url}', self_mail='$self_mail', senddate='".time()."'";
		$query .= " where sid='${_GET['sid']}'";
	}else{
		$query = "insert into $mail_tbl set sid='${mail_sid}', subject='${subject}', send_name='${from_name}', send_email='${from_email}'";
		$query .= ",member_gubun='${member_gubun_text}', file_name1='${FILE_O[0]}', read_name1='${FILE_R[0]}'";
		$query .= ", file_name2='${FILE_O[1]}', read_name2='${FILE_R[1]}', file_name3='${FILE_O[2]}', read_name3='${FILE_R[2]}'";
		$query .= ", file_name4='${FILE_O[3]}', read_name4='${FILE_R[3]}', file_name5='${FILE_O[4]}', read_name5='${FILE_R[4]}'";
		$query .= ", file_name6='${FILE_O[5]}', read_name6='${FILE_R[5]}', file_name7='${FILE_O[6]}', read_name7='${FILE_R[6]}'";
		$query .= ", file_name8='${FILE_O[7]}', read_name8='${FILE_R[7]}', file_name9='${FILE_O[8]}', read_name9='${FILE_R[8]}'";
		$query .= ", file_name10='${FILE_O[9]}', read_name10='${FILE_R[9]}', template='${mail_template}', content='${body}'";
		$query .= ", to_name_group='${to_name_group}', btn_type='${btn_type}', btn_link='${btn_url}'";
		$query .= ", signdate='".time()."', senddate='".time()."', send_count='1', total_send='${total_send_count}', total_read='0', self_mail='$self_mail'";
	}

	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

}

$M2mail = new M2mail('wiseU');

$sending_cnt = 0;
$per_page = '200';

$query = "select count(sid) from $mail_list_tbl where mail_sid='${mail_sid}' and send_status = 'Y' and `order`='$max_order'";

$sending_cnt = $conn->getOne($query);


echo "<center><br/>발송중 ... (".$sending_cnt."/".$total_send_count.")<br/><img src='/image/icon/icon_wait.gif'/></center>";

$query = "select * from $mail_list_tbl where mail_sid='${mail_sid}' and send_status = 'N' and `order`='$max_order' limit $per_page";
//echo $query;exit;
$result=$conn->query($query);
if(DB::isError($result)) die($result->getMessage());

while(is_array($m=$result->fetchRow(DB_FETCHMODE_ASSOC))){

	$id_chk = $conn->getOne("select id from user_binfo where email='$m[email]'");
	if(!$id_chk){
		$id_chk = $m['email'];
	}
	$mail_content = str_replace("{id}",$id_chk,$m['mail_body']);

	$d['from_name'] = $m['from_name'];
	$d['from_email'] = $m['from_email'];

	//$d['mail_body'] = $m['mail_body'];
	$d['mail_body'] = $mail_content;
	$d['subject'] = $m['subject'];
	$d['ecare_no'] = $_ECARE_NO;

	$d['to_email'] = $m['email'];
	$d['to_name'] = $m['name'];

	$M2mail->send($d, 'EUC-KR');

	unset($d);

	$query = "update $mail_list_tbl set send_status='Y', seq='".$M2mail->tseq."' where sid='${m['sid']}'";
	$result2=$conn->query($query);
	if(DB::isError($result2)) die($result2->getMessage());
}

if($sending_cnt < $total_send_count){
	PutLocation("${PHP_SELF}?page_type=processing&mail_sid=$mail_sid&total_send_count=$total_send_count&send_type=$send_type&max_order=$max_order");
}

$M2mail->disconnect();  //대용량 솔루션 db 끊기




PutMessageCloseOpenerReload("메일발송이 완료되었습니다.\\n\\n총 발송 건수 : ${total_send_count}건");
?>