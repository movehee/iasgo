<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  xmlns:mml="http://www.w3.org/1998/Math/MathML"
  exclude-result-prefixes="xlink" default-space="strip">
  
  <xsl:template match="sec[@sec-type='display-objects']">
	<div class="sec">
		<xsl:apply-templates />
	</div>
</xsl:template>

 <xsl:template match="sec[@sec-type='supplementary-material']">
	<div class="sec">
		<h2><xsl:apply-templates select="title" /></h2>
		<div class="sec suppmat"><xsl:apply-templates select="*[not(self::title)]" /></div>
	</div>
</xsl:template>

  <xsl:template match="sec[@sec-type='display-objects']/title">
</xsl:template>


  
  <xsl:template match="fig | fig-group | table-wrap | table-wrap-group">
		<xsl:variable name="id"><xsl:value-of select="@id"/></xsl:variable> 
		<xsl:if test="not(//*/xref[@rid=$id])">
			<xsl:apply-templates select="." mode="para-mode"/>
		</xsl:if>		
	</xsl:template>
	
	
	
	<xsl:template match="back">	
		<xsl:apply-templates select="sec[@sec-type='display-objects']" />
		<xsl:apply-templates select="*[not(self::bio or self::sec[@sec-type='display-objects'] or self::glossary | self::gloss-group)]" />		
		<xsl:if test="bio">			
			<div class="bio-list-sec sec">
				<h2 class="head" id="__secBio_list">Biography</h2>
				<xsl:apply-templates select="bio" />
			</div> 				
		</xsl:if>	
	</xsl:template>
	
	
	
	  <xsl:template name="footnotes">
    <xsl:call-template name="backmatter-section">
      <xsl:with-param name="generated-title">Notes</xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates select="$loose-footnotes" mode="footnote"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  
  
  <xsl:template match="ack">
    <xsl:call-template name="backmatter-section">
      <xsl:with-param name="generated-title">Acknowledgements</xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  
  <xsl:template match="back/ref-list">
    <xsl:apply-templates select="." mode="back-ref-list" />
  </xsl:template>

  

  <xsl:template match="back/bio">  	
	<div class="sec">		
		<p>			
			<xsl:apply-templates select="descendant-or-self::fig" />
			<xsl:apply-templates select="*[not(descendant-or-self::fig)]" />			
		</p>
	</div>	  	    
	</xsl:template>
  
  <xsl:template match="bio/p/fig" >	
		<xsl:apply-templates />		
	</xsl:template>
  
  
  <xsl:template match="bio/p/fig/graphic" >		
		<xsl:element name="img">
			<xsl:call-template name="assign-src" />
			<xsl:attribute name="alt">bio<xsl:value-of select="name()" /></xsl:attribute>
			<xsl:attribute name="style">width:30%;margin-right:5%;margin-bottom:3%;float:left</xsl:attribute>
		</xsl:element>		
		
	</xsl:template>
  

  <xsl:template match="back/fn-group">
    <xsl:call-template name="backmatter-section">
      <xsl:with-param name="generated-title">Notes</xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  
  
  <xsl:template match="back/glossary | back/gloss-group">
    <xsl:call-template name="backmatter-section">
      <xsl:with-param name="generated-title">Glossary</xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  

  
  
  <xsl:template match="back/notes">
    <xsl:call-template name="backmatter-section">
      <xsl:with-param name="generated-title">Notes</xsl:with-param>
    </xsl:call-template>
  </xsl:template>

</xsl:stylesheet>
