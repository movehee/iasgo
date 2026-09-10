<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xlink="http://www.w3.org/1999/xlink"
	xmlns:mml="http://www.w3.org/1998/Math/MathML" exclude-result-prefixes="xlink">

<xsl:template match="fn">
  <!-- Footnotes appearing outside fn-group
       generate cross-references to the footnote,
       which is displayed elsewhere -->
  <!-- Note the rules for displayed content: if any fn elements
       not inside an fn-group (the matched fn or any other) includes
       a label child, all footnotes are expected to have a label
       child. -->
    <xsl:variable name="id">
      <xsl:apply-templates select="." mode="id"/>
    </xsl:variable>
    <div id="#{$id}">
      <xsl:apply-templates select="." mode="label-text">
        <xsl:with-param name="warning" select="true()"/>
      </xsl:apply-templates>
    </div>
  </xsl:template>
  
  <xsl:template match="fn-group/fn | table-wrap-foot/fn |
                       table-wrap-foot/fn-group/fn">
    <xsl:apply-templates select="." mode="footnote"/>
  </xsl:template>
  
  
  <xsl:template match="fn" mode="footnote">
    <div class="footnote" id="{@id}">      
      <xsl:apply-templates/>
    </div>
  </xsl:template>
  
  
  <xsl:template match="fn/p">
      <xsl:if test="not(preceding-sibling::p)">
        <!-- drop an inline label text into the first p -->
        <xsl:apply-templates select="parent::fn" mode="label-text"/>
        <xsl:text> </xsl:text>
      </xsl:if>
      <xsl:apply-templates/>
  </xsl:template>


<xsl:template match="label" name="label">
	<xsl:choose>		
		<xsl:when test="ancestor::article-meta | ancestor::fn"><sup><xsl:apply-templates /></sup></xsl:when>		
		<xsl:when test="../*[name()='title']"></xsl:when>
		<xsl:otherwise><xsl:apply-templates /></xsl:otherwise>
	</xsl:choose>
	
	<xsl:if test="ancestor::ref-list">
		<xsl:text>. </xsl:text>
	</xsl:if>
	
</xsl:template>

<xsl:template match="label" mode="with-title">
	<xsl:apply-templates /><xsl:text> </xsl:text>
</xsl:template>
</xsl:stylesheet>