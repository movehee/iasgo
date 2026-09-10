<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  xmlns:mml="http://www.w3.org/1998/Math/MathML"
  exclude-result-prefixes="xlink" default-space="strip"> 

 <xsl:template match="front" mode="metadata">
  	<xsl:apply-templates select="article-meta" mode="information" />  	
  </xsl:template>
  
  <xsl:template match="front">
  		<xsl:apply-templates select="article-meta" mode="metadata" />
  		<xsl:apply-templates select="journal-meta" mode="metadata" />		  	
		 <xsl:apply-templates select="notes" mode="metadata" />
  	
  </xsl:template>
  
  <xsl:template match="journal-meta" mode="metadata" >
  	<div class="sec">
  		<h2 class="head" style="margin-bottom:10px" id="__ffn_journal_info">Journal Information</h2>
  		<div class="fm-sec">
		  	<xsl:apply-templates mode="metadata" />		  	
	  	</div>  	
  	</div>
  </xsl:template>
  
   <xsl:template match="notes" mode="metadata" >
  	<div class="sec">
  		<h2 class="head" style="margin-bottom:10px" id="__ffn_notes">Notes</h2>
  		<div class="fm-sec">
		  	<xsl:apply-templates mode="metadata" />		  	
	  	</div>  	
  	</div>
  </xsl:template>

</xsl:stylesheet>
