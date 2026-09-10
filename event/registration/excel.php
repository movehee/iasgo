<?php
	if ($_SERVER['REMOTE_ADDR'] != '218.235.94.219') {
		header('Content-Type: text/html; charset=utf-8');
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=Registration_'.date('YmdHis').'.xls');
		header('Content-Description: PHP4 Generated Data');
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();

	$search_type = $search_type ? $search_type : 'and';

	$search_fields = array(
		'title' => 'eq',
		'classification' => 'eq',
		'pay_status' => 'eq',
		'etc_field7' => 'eq',
		'etc_field8' => 'eq',
		'id' => 'like',
		'name_kr' => 'like',
		'name_eng' => 'like',
		'license_number' => 'like',
		'aff_kor' => 'like',
		'cell' => 'like',
		'etc_field2' => 'like'
	);

	$search_query = array();
	foreach ($search_fields as $field => $op) {
		$value = isset($_REQUEST[$field]) ? $_REQUEST[$field] : '';
		if ($value == '') {
			continue;
		}
		if ($field == 'aff_kor') {
			$search_query[] = " (aff_kor like '%".$value."%' OR aff_eng like '%".$value."%') ";
		} else if ($op == 'eq') {
			$search_query[] = " ".$field." = '".$value."' ";
		} else {
			$search_query[] = " ".$field." like '%".$value."%' ";
		}
	}

	$fsql = " WHERE del='N'";
	if ($search_query) {
		$fsql = ' WHERE '.implode($search_type, $search_query)." AND del='N'";
	}

	$query = 'SELECT * FROM registration_tbl'.$fsql.' ORDER BY sid DESC';
	$result = $conn->query($query);
	if (DB::isError($result)) {
		die($result->getMessage());
	}
?>
<style>
	td{mso-number-format:\@;}
</style>
<table border="1">
	<tr>
		<th>No</th>
		<th>등록구분</th>
		<th>등록경로</th>
		<th>국내/외</th>
		<th>국가</th>
		<th>ID</th>
		<th>E-mail</th>
		<th>성명</th>
		<th>성명(영문)</th>
		<th>면허번호</th>
		<th>구분</th>
		<th>소속/Specialty</th>
		<th>카테고리</th>
		<th>무료</th>
		<th>등록비 금액</th>
		<th>결제상태</th>
		<th>결제일자</th>
		<th>결제수단</th>
		<th>소속(국문)</th>
		<th>소속(영문)</th>
		<th>부서(국문)</th>
		<th>부서(영문)</th>
		<th>연락처</th>
		<th>VIP</th>
		<th>DESK</th>
		<th>Ribbon</th>
		<th>QR</th>
		<th>등록번호</th>
		<th>Memo</th>
	</tr>
	<?php
		$n = 1;
		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)):
			$isDomestic = ($d['country'] == 'K');
			$isOverseas = ($d['country'] == 'F');

			$feeLabel = $d['title'];
			if ($isDomestic && isset($_ONSITE['fee_kor'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_kor'][$d['title']]['title'];
			} else if ($isOverseas && isset($_ONSITE['fee_eng'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_eng'][$d['title']]['title'];
			} else if (isset($_ONSITE['fee_kor'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_kor'][$d['title']]['title'];
			} else if (isset($_ONSITE['fee_eng'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_eng'][$d['title']]['title'];
			}

			$classLabel = isset($_REG['class_kind'][$d['classification']]) ? $_REG['class_kind'][$d['classification']] : '';
			$sourceLabel = isset($_REG['reg_source'][$d['etc_field9']]) ? $_REG['reg_source'][$d['etc_field9']] : $d['etc_field9'];
			$countryLabel = isset($_REG['reg_country'][$d['country']]) ? $_REG['reg_country'][$d['country']] : '';
			$payStatusLabel = isset($_REG['pay_status_txt'][$d['pay_status']]) ? $_REG['pay_status_txt'][$d['pay_status']] : '';
			$vipLabel = ($d['etc_field8'] == 'Y') ? $_REG['vip']['Y'] : '';
			$deskLabel = isset($_REG['desk'][$d['etc_field7']]) ? $_REG['desk'][$d['etc_field7']] : '';

			$payMethodLabel = $d['etc_field5'];
			if ($isOverseas && isset($_ONSITE['pay_method_eng'][$d['etc_field5']])) {
				$payMethodLabel = $_ONSITE['pay_method_eng'][$d['etc_field5']];
			} else if (isset($_ONSITE['pay_method_kor'][$d['etc_field5']])) {
				$payMethodLabel = $_ONSITE['pay_method_kor'][$d['etc_field5']];
			}

			$gubun1Label = '';
			if (isset($_ONSITE['gubun1'][$d['gubun1']])) {
				$gubun1Label = $_ONSITE['gubun1'][$d['gubun1']];
				if ($d['gubun1'] == '99' && $d['etc_field3'] != '') {
					$gubun1Label .= ' ('.$d['etc_field3'].')';
				}
			}

			$gubun2Label = '';
			if ($isOverseas && isset($_ONSITE['gubun2_eng'][$d['gubun2']])) {
				$gubun2Label = $_ONSITE['gubun2_eng'][$d['gubun2']];
			} else if (isset($_ONSITE['gubun2_kor'][$d['gubun2']])) {
				$gubun2Label = $_ONSITE['gubun2_kor'][$d['gubun2']];
			}
			if ($d['gubun2'] == '99' && $d['title_sub'] != '') {
				$gubun2Label .= ' ('.$d['title_sub'].')';
			}
	?>
		<tr>
			<td><?=$n?></td>
			<td><?=$classLabel?></td>
			<td><?=$sourceLabel?></td>
			<td><?=$countryLabel?></td>
			<td><?=$d['etc_field1']?></td>
			<td><?=$d['id']?></td>
			<td><?=$d['email']?></td>
			<td><?=$d['name_kr']?></td>
			<td><?=$d['name_eng']?></td>
			<td><?=$d['license_number']?></td>
			<td><?=$gubun1Label?></td>
			<td><?=$gubun2Label?></td>
			<td><?=$feeLabel?></td>
			<td><?=$d['free_yn']=='Y'?'Y':''?></td>
			<td><?=$d['reg_fee']?></td>
			<td><?=$payStatusLabel?></td>
			<td><?=$d['pay_date']?></td>
			<td><?=$payMethodLabel?></td>
			<td><?=$d['aff_kor']?></td>
			<td><?=$d['aff_eng']?></td>
			<td><?=$d['depart_kor']?></td>
			<td><?=$d['depart_eng']?></td>
			<td><?=$d['cell']?></td>
			<td><?=$vipLabel?></td>
			<td><?=$deskLabel?></td>
			<td><?=$d['etc_field6']?></td>
			<td><?=$d['qr_number']?></td>
			<td><?=$d['etc_field2']?></td>
			<td><?=$d['memo']?></td>
		</tr>
	<?php
			$n++;
		endwhile;
	?>
</table>
