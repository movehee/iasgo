<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  xmlns:mml="http://www.w3.org/1998/Math/MathML"
  exclude-result-prefixes="xlink" default-space="strip"> 
  
  <xsl:template match="article | response | sub-article">
  	<xsl:element name="article">
		<xsl:attribute name="xmlns:xs">http://www.w3.org/2001/XMLSchema</xsl:attribute>
		<xsl:attribute name="data-type">main</xsl:attribute>
		
		<xsl:apply-templates select="front" mode="metadata" />
  		<xsl:apply-templates select="front-stub" mode="information" />  		
  		<xsl:apply-templates select="body" />		
  		<xsl:apply-templates select="back" /> 		
  		<xsl:apply-templates select="front" />
	</xsl:element>
  		
  	
  	
  	<xsl:apply-templates select="//table-wrap | //table-wrap-group | //fig | //fig-group" mode="popup-root" />
  </xsl:template>

</xsl:stylesheet>
