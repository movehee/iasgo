<?
include "config.php";

require_once "./conf/reader.php";
$data = new Spreadsheet_Excel_Reader();


if($_FILES["excel_file"]["name"]){
	if($_FILES["excel_file"]["error"] > 0){
		PutMessageBack("파일전송에 실패했습니다. 잠시 후 다시 시도해주세요");
	}else{
		$userfile1 = $_FILES["excel_file"]["name"];

		$userfile_arr = explode('.', $userfile1);
		$ext = $userfile_arr[count($userfile_arr)-1];

		$realfile1 = time().rand().".${ext}";

		copy($_FILES["excel_file"]["tmp_name"], "${DOCUMENT_ROOT}upload/excel/".$realfile1);
		@unlink($_file['temp'].$realfile1);

		$file_path = "${DOCUMENT_ROOT}upload/excel/" . $realfile1;
	}
}

$data->setOutputEncoding("UTF-8");
$data->read($file_path);


echo "<center><br/>등록중 ... <br/><img src='/image/icon/icon_wait.gif'/></center>";

$_date_arr = array();

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
		$_date_arr[$j] = $data->sheets[0]['cells'][$i][$j];
	}

	//if (($j-1) < 2) PutMessageBack("입력하신 엑셀파일의 필드가 필요한 필드 갯수보다 적습니다.");
	if(trim($_date_arr[2])){
		$query = "insert into tp_addgrinfo set c_code='${c_index}', c_name='".$_date_arr[1]."', c_office='".$_date_arr[4]."'";
		$query .= ", c_email='".$_date_arr[2]."',c_pcs='".$_date_arr[3]."', reg_dt=now()";

		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
	}

}

PutMessageCloseOpenerReload("주소록 엑셀등록이 완료되었습니다.");


?>