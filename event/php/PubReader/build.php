<?

	function getNodeValue(DOMElement $element)
	{
		return trim($element->nodeValue);
	}
	
	function getNodeValueTagName($xml, $name)
	{
		$element = $xml->getElementsByTagName($name);
		foreach ($element as $row)
		{
			return getNodeValue($row);
		}
	}

	function getNodeValueXpath($xml, $query)
	{
		$xpath = new DOMXPath($xml);
		$element = $xpath->query($query);
		
		foreach ($element as $row)
		{
			return getNodeValue($row);
		}
	}


	require_once './class.pubreader.php';

	$pub = new Pubreader();

	$dir = "../../xml/kjp/xml/";

	$files = scandir($dir);

	foreach($files as $filename)
	{
		if($filename == "." or $filename == ".." or !is_file($dir.$filename)) continue;		

		$pub_xml = '../../xml/kjp/xml/'.$filename;	

		$xml = new DOMDocument();
		$xml->load($pub_xml);

		$vol = getNodeValueXpath($xml, "//volume");
		$no = getNodeValueXpath($xml, "//issue");
		$year = getNodeValueXpath($xml, "//pub-date[@pub-type='ppub']/year");
		$month = getNodeValueXpath($xml, "//pub-date[@pub-type='ppub']/month");
		$start_page = getNodeValueXpath($xml, "//fpage");

		$pub_data['xml_file'] = $pub_xml;
		
		$pub_data['db-number'] = str_replace(".xml", "",$filename); //  논문의 번호
		$pub_data['pdf-file'] = '/upload/journal/'.str_replace(".xml", "",$filename) .".pdf";
		
		$pub_data['thumb-path'] = '/upload/journal/thum/'; //섬네일 경로
		$pub_data['custom-abbr'] = "Korean J Pathol"; //저널 약어명		
		$pub_data['journal-articles-url'] = "/archive/list.php?code=arc&year=".$year."&vol=".$vol."&no=".$no;
		$pub_data['article-url'] = "/archive/view.php?code=arc&year=".$year."&vol=".$vol."&no=".$no."&startpage=".$start_page;
		$pub_data['table-ext'] = ".png";//기본 테이블 이미지 확장명
		$pub_data['article-type'] = "journal";//기본 테이블 이미지 확장명
		
		
		$pub_data['date-type'] = '1';	
		
		$pub_data['ref-style'] = "1"; //science-central 용
		
		$pub_data['search-url-type'] = "1"; //science-central 용
		$pub_data['search-url'] = ""; //science-central 용
		
		// echo "test";
		$html = $pub->transform($pub_data);
		

		file_put_contents('../../xml/kjp/pubreader/'.str_replace(".xml", ".html",$filename), $html);
	}

	

?>