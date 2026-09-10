<?php
	/**
	 * 엑셀 사전등록 마이그레이션
	 */
	function regImportNormalize($val) {
		$val = trim($val);
		$val = str_replace(array("\r", "\n", "\t"), '', $val);
		return $val;
	}

	function regImportCompact($val) {
		return preg_replace('/\s+/', '', regImportNormalize($val));
	}

	function regImportYn($val) {
		$raw = regImportNormalize($val);
		if ($raw == '') {
			return '';
		}
		$upper = strtoupper($raw);
		if ($upper == 'Y' || $upper == 'YES' || $upper == 'VIP' || $raw == '무료' || $raw == '만찬' || $raw == '사교행사') {
			return 'Y';
		}
		if ($upper == 'N' || $upper == 'NO') {
			return '';
		}
		return '';
	}

	function regImportLunch($val) {
		$raw = regImportNormalize($val);
		if ($raw == '') {
			return '';
		}
		$upper = strtoupper($raw);
		if ($raw == '공동연수' || $raw == '워크샵' || $raw == '워크샵행사' || $upper == 'Y' || $upper == 'S' || $upper == 'F') {
			return 'F';
		}
		return $raw;
	}

	function regImportBanquet($val) {
		$raw = regImportNormalize($val);
		if ($raw == '') {
			return '';
		}
		$upper = strtoupper($raw);
		if ($upper == 'Y' || $raw == '만찬' || $raw == '사교행사') {
			return 'Y';
		}
		return '';
	}

	function regImportFeeNumber($val) {
		$raw = preg_replace('/[^0-9.\-]/', '', regImportNormalize($val));
		if ($raw == '' || $raw == '-') {
			return '';
		}
		return $raw;
	}

	function regImportCountry($countryName, &$isoOut) {
		global $_Flag;
		$isoOut = '';
		$name = regImportNormalize($countryName);
		if ($name == '') {
			return array('country' => '', 'name' => '');
		}
		$compact = strtolower(regImportCompact($name));
		if ($compact == 'korea' || $compact == '대한민국' || $compact == '한국' || $compact == 'korearepublicof' || $compact == 'republicofkorea') {
			$isoOut = 'KR';
			return array('country' => 'K', 'name' => 'Korea');
		}
		if (isset($_Flag['country']) && is_array($_Flag['country'])) {
			foreach ($_Flag['country'] as $iso => $cinfo) {
				if ($iso == 'KR') {
					continue;
				}
				$cn = isset($cinfo['cn']) ? $cinfo['cn'] : '';
				if ($cn == '') {
					continue;
				}
				if (strtolower(regImportCompact($cn)) == $compact) {
					$isoOut = $iso;
					return array('country' => 'F', 'name' => $cn);
				}
			}
		}
		return array('country' => 'F', 'name' => $name);
	}

	function regImportFeeCode($rawTitle, $isDomestic) {
		global $_ONSITE;
		$raw = regImportNormalize($rawTitle);
		if ($raw == '') {
			return '';
		}
		if (isset($_ONSITE['fee_kor'][$raw]) || isset($_ONSITE['fee_eng'][$raw])) {
			return $raw;
		}

		$compactRaw = regImportCompact($raw);
		$maps = array();
		if ($isDomestic) {
			if (isset($_ONSITE['fee_kor'])) {
				$maps[] = $_ONSITE['fee_kor'];
			}
			if (isset($_ONSITE['fee_eng'])) {
				$maps[] = $_ONSITE['fee_eng'];
			}
		} else {
			if (isset($_ONSITE['fee_eng'])) {
				$maps[] = $_ONSITE['fee_eng'];
			}
			if (isset($_ONSITE['fee_kor'])) {
				$maps[] = $_ONSITE['fee_kor'];
			}
		}

		$bestKey = '';
		$bestLen = 0;
		foreach ($maps as $feeMap) {
			foreach ($feeMap as $feeKey => $feeRow) {
				if (!isset($feeRow['title'])) {
					continue;
				}
				$titleCompact = regImportCompact($feeRow['title']);
				$titleLen = strlen($titleCompact);
				if ($titleLen == 0) {
					continue;
				}
				if ($titleCompact == $compactRaw || strpos($compactRaw, $titleCompact) !== false) {
					if ($titleLen > $bestLen) {
						$bestLen = $titleLen;
						$bestKey = $feeKey;
					}
				}
			}
			if ($bestKey != '') {
				return $bestKey;
			}
		}
		return $bestKey;
	}

	function regImportClassification($raw) {
		$val = regImportNormalize($raw);
		if ($val == '') {
			return '';
		}
		if (strpos($val, '조기') !== false) {
			return 'A';
		}
		if (strpos($val, '사전') !== false) {
			return 'B';
		}
		if (strpos($val, '현장') !== false || strpos($val, '당일') !== false) {
			return 'C';
		}
		global $_REG;
		if (isset($_REG['class_kind']) && is_array($_REG['class_kind'])) {
			$key = array_search($val, $_REG['class_kind']);
			if ($key !== false) {
				return $key;
			}
		}
		return '';
	}

	/**
	 * @return array(code, etcText)
	 */
	function regImportGubun($raw, $map) {
		$val = regImportNormalize($raw);
		if ($val == '') {
			return array('', '');
		}
		if (isset($map[$val])) {
			return array($val, '');
		}
		$key = array_search($val, $map);
		if ($key !== false) {
			return array($key, '');
		}
		$compact = regImportCompact($val);
		foreach ($map as $mKey => $mVal) {
			if (regImportCompact($mVal) == $compact) {
				return array($mKey, '');
			}
		}
		return array('99', $val);
	}

	function regImportPayMethod($raw) {
		global $_ONSITE;
		$val = regImportNormalize($raw);
		if ($val == '') {
			return '';
		}
		$upper = strtoupper($val);
		if (isset($_ONSITE['pay_method_kor'][$upper]) || isset($_ONSITE['pay_method_eng'][$upper])) {
			return $upper;
		}
		if (isset($_ONSITE['pay_method_kor'])) {
			$key = array_search($val, $_ONSITE['pay_method_kor']);
			if ($key !== false) {
				return $key;
			}
		}
		if (isset($_ONSITE['pay_method_eng'])) {
			$key = array_search($val, $_ONSITE['pay_method_eng']);
			if ($key !== false) {
				return $key;
			}
		}
		if (strpos($val, '카드') !== false || stripos($val, 'card') !== false) {
			return 'CARD';
		}
		if (strpos($val, '송금') !== false || strpos($val, '이체') !== false || stripos($val, 'bank') !== false) {
			return 'BANK';
		}
		if (strpos($val, '현금') !== false || stripos($val, 'cash') !== false) {
			return 'CASH';
		}
		return $val;
	}

	function regImportPayStatus($raw) {
		$val = regImportNormalize($raw);
		if ($val == '') {
			return '';
		}
		global $_REG;
		if (isset($_REG['pay_status_txt']) && is_array($_REG['pay_status_txt'])) {
			if (isset($_REG['pay_status_txt'][$val])) {
				return $val;
			}
			$key = array_search($val, $_REG['pay_status_txt']);
			if ($key !== false) {
				return $key;
			}
		}
		if (strpos($val, '완료') !== false || strtoupper($val) == 'Y' || stripos($val, 'paid') !== false) {
			return 'Y';
		}
		if (strpos($val, '취소') !== false || strtoupper($val) == 'C') {
			return 'C';
		}
		if (strpos($val, '현장') !== false || strtoupper($val) == 'N') {
			return 'N';
		}
		return '';
	}

	/**
	 * @return array(login1, login2, login3)
	 */
	function regImportAttendDays($raw) {
		$val = regImportNormalize($raw);
		$login1 = '';
		$login2 = '';
		$login3 = '';
		if ($val == '') {
			return array($login1, $login2, $login3);
		}
		if (stripos($val, 'full') !== false) {
			return array('Y', 'Y', 'Y');
		}
		$num = (int)preg_replace('/[^0-9]/', '', $val);
		if ($num >= 1) {
			$login1 = 'Y';
		}
		if ($num >= 2) {
			$login2 = 'Y';
		}
		if ($num >= 3) {
			$login3 = 'Y';
		}
		return array($login1, $login2, $login3);
	}

	function regImportDesk($raw) {
		global $_REG;
		$val = regImportNormalize($raw);
		if ($val == '') {
			return '';
		}
		if (isset($_REG['desk'][$val])) {
			return $val;
		}
		if (isset($_REG['desk']) && is_array($_REG['desk'])) {
			$key = array_search($val, $_REG['desk']);
			if ($key !== false) {
				return $key;
			}
		}
		if (preg_match('/([0-9]+)/', $val, $m)) {
			return $m[1];
		}
		return $val;
	}
?>
