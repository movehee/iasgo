<?php
class Pubreader 
{
	private $ref_style_arr = array (
			"1" => "vancouver",
			"2" => "apa",
			"3" => "ieee",
			"4" => "harvard"
	);
	
	public function transform(array $data) 
	{
		$xml = new DomDocument ();
		$xml->load ( $data['xml_file']); 
		
		if ($data['db-number']) { // 논문 번호
			$tag = null;
			$tag = $xml->createElement ( "db-number", $data['db-number'] );
			$xml->appendChild ( $tag );
		}
		
		if ($data['banner-file']) { // 베너 이미지 경로
			$tag = null;
			$tag = $xml->createElement ( "banner-file", $data['banner-file'] );
			$xml->appendChild ( $tag );
		}
		
		if ($data['pdf-file']) { //pdf 파일 경로
			$tag = null;
			$tag = $xml->createElement ( "pdf-file", $data['pdf-file'] );
			$xml->appendChild ( $tag );
		}
		
		if ($data['thumb-path']) { //섬네일 이미지 디렉토리			
			$tag = null;
			$tag = $xml->createElement ( "thumb-path", $data['thumb-path'] );
			$xml->appendChild ($tag);
		}
		
		if ($data['custom-abbr']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement ( "custom-abbr", $data['custom-abbr'] );
			$xml->appendChild($tag);
		}
		
		if ($data['journal-list-url']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement ( "journal-list-url", htmlspecialchars($data['journal-list-url']) );
			$xml->appendChild($tag);
		}
		
		if ($data['journal-issues-url']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement ( "journal-issues-url", htmlspecialchars($data['journal-issues-url']) );
			$xml->appendChild($tag);
		}
		
		if ($data['journal-articles-url']) { //섬네일 이미지 디렉토리			
			$tag = null;
			$tag = $xml->createElement( "journal-articles-url", htmlspecialchars($data['journal-articles-url']) );
			$xml->appendChild($tag);
		}		
		
		if ($data['article-url']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement( "article-url", htmlspecialchars($data['article-url']) );
			$xml->appendChild($tag);
		}
		
		if ($data['search-url']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement( "search-url", htmlspecialchars($data['search-url']) );
			$xml->appendChild($tag);
		}
		
		if ($data['search-url-type']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement( "search-url-type", htmlspecialchars($data['search-url-type']) );
			$xml->appendChild($tag);
		}

		if ($data['table-ext']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement( "table-ext", htmlspecialchars($data['table-ext']) );
			$xml->appendChild($tag);
		}
		
		if ($data['date-type']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement( "date-type", htmlspecialchars($data['date-type']) );
			$xml->appendChild($tag);
		}
		
		if ($data['article-type']) { //섬네일 이미지 디렉토리
			$tag = null;
			$tag = $xml->createElement( "article-type", htmlspecialchars($data['article-type']) );
			$xml->appendChild($tag);
		}
		
		
		$ref_style = $data['ref-style'] ? $this->ref_style_arr[$data['ref-style']] : $this->ref_style_arr["1"];		
		
		if ($ref_style != "vancouver") {
			$given_names = $xml->getElementsByTagName ( "given-names" );
			foreach ( $given_names as $idx => $given_name ) {
				if (strpos ( $given_name->nodeValue, "." ) !== false)
					continue;
				if (ctype_upper ( $given_name->nodeValue ) !== true)
					continue;
				$temp = str_split ( $given_name->nodeValue );
				$given_names->item ( $idx )->nodeValue = implode ( ".", $temp ) . ".";
			}
		}
		
		$xsl_file = "xsl/{$ref_style}.xsl";
		//echo $xsl_file;
		/**
		 * * XSL파일 읽기
		 */		
		
		
		
		$xsl = new DomDocument ();
		$xsl->load ( $xsl_file );
		$processor = new xsltprocessor();
		$processor->importStyleSheet( $xsl );
		
		return $processor->transformToXML($xml);
	}
}


?>

