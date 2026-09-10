<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xlink="http://www.w3.org/1999/xlink"
	xmlns:mml="http://www.w3.org/1998/Math/MathML" exclude-result-prefixes="xlink">

<!-- ============================================================= -->
  <!--  INLINE MISCELLANEOUS                                         -->
  <!-- ============================================================= -->
  <!--  Templates strictly for formatting follow; these are templates
        to handle various inline structures -->


  <xsl:template match="abbrev">
    <xsl:apply-templates/>
  </xsl:template>
  
  <xsl:template match="abbrev[normalize-space(string(@xlink:href))]">
    <a>
      <xsl:call-template name="assign-href"/>
      <xsl:apply-templates/>
    </a>
  </xsl:template>
    
  <xsl:template match="abbrev/def">
    <xsl:text>[</xsl:text>
    <xsl:apply-templates/>
    <xsl:text>]</xsl:text>
  </xsl:template>
  
  <xsl:template match="p/address | license-p/address |
    named-content/p | styled-content/p">
    <xsl:apply-templates mode="inline"/>
  </xsl:template>
  
  
  <xsl:template match="address/*" mode="inline">
    <xsl:if test="preceding-sibling::*">
      <span class="generated">, </span>
    </xsl:if>
    <xsl:apply-templates/>
  </xsl:template>
  
        
  <xsl:template match="award-id">
    <xsl:apply-templates/>
  </xsl:template>
  
    
  <xsl:template match="award-id[normalize-space(string(@rid))]">
    <a href="#{@rid}">
      <xsl:apply-templates/>
    </a>
  </xsl:template>
  
    
  <xsl:template match="break">
    <br class="br"/>
  </xsl:template>


  <xsl:template match="email">
    <a href="mailto:{.}">
      <xsl:apply-templates/>
    </a>
  </xsl:template>

  
  <xsl:template match="ext-link | uri | inline-supplementary-material">
    <a target="new">
      <xsl:attribute name="href">
        <xsl:value-of select="."/>
      </xsl:attribute>
      <!-- if an @href is present, it overrides the href
           just attached -->
      <xsl:call-template name="assign-href"/>
      <xsl:call-template name="assign-id"/>
      <xsl:apply-templates/>
      <xsl:if test="not(normalize-space(string(.)))">
        <xsl:value-of select="@xlink:href"/>
      </xsl:if>
    </a>
  </xsl:template>


  <xsl:template match="funding-source">
    <span class="funding-source">
      <xsl:apply-templates/>
    </span>
  </xsl:template>
  

  <xsl:template match="hr">
    <hr class="hr"/>
  </xsl:template>
  

  <!-- inline-graphic is handled above, with graphic -->
  
  
  <xsl:template match="inline-formula | chem-struct">
    <span class="{local-name()}">
      <xsl:apply-templates/>
    </span>
  </xsl:template>


  <xsl:template match="chem-struct-wrap/chem-struct | chem-struct-wrapper/chem-struct">
    <div class="{local-name()}">
      <xsl:apply-templates/>
    </div>
  </xsl:template>

  
  <xsl:template match="milestone-start | milestone-end">
    <span class="{substring-after(local-name(),'milestone-')}">
      <xsl:comment>
        <xsl:value-of select="@rationale"/>
      </xsl:comment>
    </span>
  </xsl:template>
  

  <xsl:template match="object-id">
    <span class="{local-name()}">
      <xsl:apply-templates/>
    </span>
  </xsl:template>
  

  <!-- preformat is handled above -->
  
  <xsl:template match="sig">
    <xsl:apply-templates/>
  </xsl:template>
  
  
  
  <xsl:template match="styled-content">
    <span>
      <xsl:copy-of select="@style"/>
      <xsl:for-each select="@style-type">
        <xsl:attribute name="class">
          <xsl:value-of select="."/>
        </xsl:attribute>
      </xsl:for-each>
      <xsl:apply-templates/>
    </span>
  </xsl:template>
  
  
  <xsl:template match="named-content">
    <span>
      <xsl:for-each select="@content-type">
        <xsl:attribute name="class">
          <xsl:value-of select="translate(.,' ','-')"/>
        </xsl:attribute>
      </xsl:for-each>
      <xsl:apply-templates/>
    </span>
  </xsl:template>
  
  
  <xsl:template match="private-char">
    <span>
      <xsl:for-each select="@description">
        <xsl:attribute name="title">
          <xsl:value-of select="."/>
        </xsl:attribute>
      </xsl:for-each>
      <span class="generated">[Private character </span>
      <xsl:for-each select="@name">
        <xsl:text> </xsl:text>
        <xsl:value-of select="."/>
      </xsl:for-each>
      <span class="generated">]</span>
    </span>
  </xsl:template>
  
  
  <xsl:template match="glyph-data | glyph-ref">
    <span class="generated">(Glyph not rendered)</span>
  </xsl:template>
    
  
  <xsl:template match="related-article">
    <span class="generated">[Related article:] </span>
    <xsl:apply-templates/>
  </xsl:template>
  
  
  <xsl:template match="related-object">
    <span class="generated">[Related object:] </span>
    <xsl:apply-templates/>
  </xsl:template>
  
  
  </xsl:stylesheet>