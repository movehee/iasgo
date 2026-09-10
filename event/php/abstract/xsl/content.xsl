<xsl:stylesheet version="1.0"
	xmlns:xs="http://www.w3.org/2001/XMLSchema"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  xmlns:mml="http://www.w3.org/1998/Math/MathML"
  exclude-result-prefixes="xlink" default-space="strip"> 
  
  <xsl:template match="article | response | sub-article | book-part">
  	<xsl:element name="article">
		<xsl:attribute name="data-type">main</xsl:attribute>
		
		<xsl:apply-templates select="front | book-part-meta" mode="metadata" />
  		<xsl:apply-templates select="front-stub" mode="information" />
  		<xsl:apply-templates select="back/glossary | back/gloss-group" />  		
  		<xsl:apply-templates select="body" />		
  		<xsl:apply-templates select="back" /> 		
  		<xsl:apply-templates select="front" />
	</xsl:element>
  		
  	
  	
  	<xsl:apply-templates select="//table-wrap | //table-wrap-group | //fig | //fig-group" mode="popup-root" />
  </xsl:template>
  
<!--    <xsl:template match="*" mode="body-xref-link"> -->
<!--    <xsl:apply-templates select="." /> -->
<!--    <xsl:call-template name="print-lend-in-content" /> -->
<!--   </xsl:template> -->
  

</xsl:stylesheet>
