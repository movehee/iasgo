<?
	$xml = new DomDocument();
	$xml->load($pub_reader_xml);

	if($number) // 참고문헌 불러오기 위한 논문번호
	{
		$db_number = $xml->createElement("db_number" , $number);
		$xml->appendChild($db_number);
	}	

	if($journal_init_title) // 로고 옆에 있는 링크에 넣을 데이터
	{
		$journal_init_title_tag = $xml->createElement("journal_init_title" , $journal_init_title);
		$xml->appendChild($journal_init_title_tag);
	}

	if($preaderfile) // 
	{
		$preader_file_tag = $xml->createElement("preader-file" , $preaderfile);
		$xml->appendChild($preader_file_tag);
	}
	
	if($journal_code) // 피겨 및 테이블 이미지 로드를 위함
	{
		$journal_code_tag = $xml->createElement("journal-code" , $journal_code);
		$xml->appendChild($journal_code_tag);
	}

	if($issue) // 피겨 및 테이블 이미지 로드를 위함
	{
		$issue_code_tag = $xml->createElement("issue-code" , $issue);
		$xml->appendChild($issue_code_tag);
	}

	if(!$ref_style) $ref_style = "vancouver";
	else{
		$ref_style_arr = array("1"=>"vancouver","2"=>"apa","3"=>"ieee");
		$ref_style = $ref_style_arr[$ref_style];
	}
	if($ref_style != "vancouver")
	{
		$given_names = $xml->getElementsByTagName("given-names");
		foreach($given_names as $idx=> $given_name)
		{
			if(strpos($given_name->nodeValue, ".") !== false) continue;
			if(ctype_upper($given_name->nodeValue) !== true) continue;
			$temp = str_split ($given_name->nodeValue);
			$given_names->item($idx)->nodeValue = implode(".", $temp).".";
		}
	}	

	$xsl_file = "../../xsl/{$ref_style}.xsl";
	/**    * XSL파일 읽기    */
	$xsl = new DomDocument();
	$xsl->load($xsl_file);
	$processor = new xsltprocessor();
	$processor->importStyleSheet($xsl);

	/**    * 변환    */
	$html = $processor->transformToXML($xml);

	echo $html;
?>