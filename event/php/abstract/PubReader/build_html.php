<?
exit;
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


	$dir = "../../xml/kjp/xml/";

	$files = scandir($dir);


	$xsl_file =	$DOCUMENT_ROOT . "../xml/JATS/xsl/jats-dltmdwo-html-whdbstkd2.xsl";

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
		$start_page = getNodeValueXpath($xml, "//start_page");




		$xml = new DomDocument();
		@$xml->load($pub_xml);

		/**    * XML 레퍼런스 스타일 정의 **/
		$xml_ref_style = $xml->createElement("ref-style", $ref_style);
		$xml->appendChild($xml_ref_style);

		/**    * XML 저널 디렉토리 정의 **/
		$xml_dir_path= $xml->createElement("dir-path", '/upload/journal/thum/' );
		$xml->appendChild($xml_dir_path);

		/**    * XSL파일 읽기    */
		$xsl = new DomDocument();
		$xsl->load($xsl_file);
		$processor = new xsltprocessor();
		$processor->importStyleSheet($xsl);

		/**    * 변환    */
		$html = $processor->transformToXML($xml);			
		

		file_put_contents('../../xml/kjp/html/'.str_replace(".xml", ".html",$filename), $html);
	}

	

?>