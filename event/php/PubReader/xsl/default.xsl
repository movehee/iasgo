<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xlink="http://www.w3.org/1999/xlink"
	xmlns:mml="http://www.w3.org/1998/Math/MathML" exclude-result-prefixes="xlink">
	
  
  <xsl:template name="main-title"
    match="abstract/title | body/*/title |
           back/title | back[not(title)]/*/title">
    <xsl:param name="contents">
      <xsl:apply-templates/>
    </xsl:param>
    <xsl:if test="normalize-space(string($contents))">
      <!-- coding defensively since empty titles make glitchy HTML -->
      <h2 class="head no_bottom_margin" id="__fn_header_{generate-id()}">
        <xsl:apply-templates select="../*[name()='label']" mode="with-title" /> <xsl:copy-of select="$contents"/>
      </h2>
    </xsl:if>
    <xsl:apply-templates select="." mode="xref-link" />
  </xsl:template>


  <xsl:template name="section-title"
    match="abstract/*/title | body/*/*/title |
		       back[title]/*/title | back[not(title)]/*/*/title">
    <xsl:param name="contents">
      <xsl:apply-templates/>
    </xsl:param>   
    <xsl:if test="normalize-space(string($contents))">
      <!-- coding defensively since empty titles make glitchy HTML -->
      <h3 class="section-title">
        <xsl:apply-templates select="../*[name()='label']" mode="with-title" /> <xsl:copy-of select="$contents"/>
      </h3>
    </xsl:if>
    <xsl:apply-templates select="." mode="xref-link" />
  </xsl:template>


  <xsl:template name="subsection-title"
    match="abstract/*/*/title | body/*/*/*/title |
		       back[title]/*/*/title | back[not(title)]/*/*/*/title">
    <xsl:param name="contents">
      <xsl:apply-templates/>
    </xsl:param>   
    <xsl:if test="normalize-space(string($contents))">
      <!-- coding defensively since empty titles make glitchy HTML -->
      <h4 class="subsection-title">
        <xsl:apply-templates select="../*[name()='label']" mode="with-title" /> <xsl:copy-of select="$contents"/>
      </h4>
    </xsl:if>
    <xsl:apply-templates select="." mode="xref-link" />
  </xsl:template>


  <xsl:template name="block-title" priority="2"
    match="list/title | def-list/title | boxed-text/title |
           verse-group/title | glossary/title | gloss-group/title | kwd-group/title">
    <xsl:param name="contents">
      <xsl:apply-templates/>
    </xsl:param>   
    <xsl:if test="normalize-space(string($contents))">
      <!-- coding defensively since empty titles make glitchy HTML -->
      <h4 class="block-title">
        <xsl:apply-templates select="../*[name()='label']" mode="with-title" /> <xsl:copy-of select="$contents"/>
      </h4>
    </xsl:if>
    <xsl:apply-templates select="." mode="xref-link" />
  </xsl:template>


  <!-- default: any other titles found -->
  <xsl:template match="title">
    <xsl:if test="normalize-space(string(.))">
      <h3 class="title">
        <xsl:apply-templates select="../*[name()='label']" mode="with-title" /> <xsl:apply-templates/>
      </h3>
    </xsl:if>
    <xsl:apply-templates select="." mode="xref-link" />
  </xsl:template>


  <xsl:template match="subtitle">
    <xsl:if test="normalize-space(string(.))">
      <h5 class="subtitle">
        <xsl:apply-templates select="../*[name()='label']" mode="with-title" /> <xsl:apply-templates/>
      </h5>
    </xsl:if>
    <xsl:apply-templates select="." mode="xref-link" />
  </xsl:template>
	
	<xsl:template match="sec">
    <div class="sec">      
      <xsl:apply-templates select="title"/>
      <xsl:apply-templates select="sec-meta"/>
      <xsl:apply-templates mode="drop-title"/>
    </div>
  </xsl:template>


  <xsl:template match="*" mode="drop-title">
    <xsl:apply-templates select="."/>
    <xsl:apply-templates select="." mode="xref-link" />
  </xsl:template>
  
  <xsl:template match="*" mode="xref-link">
    <xsl:for-each select= "xref[generate-id()=generate-id(key('sup-in-p',@rid)[1])]">		
		<xsl:variable name="xref-rid"><xsl:value-of select="@rid" /></xsl:variable>				
		<xsl:apply-templates select="(//fig)[@id=$xref-rid] | (//fig-group)[@id=$xref-rid] | (//table-wrap)[@id=$xref-rid] | (//table-wrap-group)[@id=$xref-rid]" mode="para-mode" />
	</xsl:for-each>	
  </xsl:template>


  <xsl:template match="title | sec-meta" mode="drop-title"/>


  <xsl:template match="app">
    <div class="sec app">
      <xsl:apply-templates/>
    </div>
  </xsl:template>

<xsl:template match="sec-meta">
   <div class="sec">
     <!-- includes contrib-group | permissions | kwd-group -->
     <xsl:apply-templates/>
   </div>
  </xsl:template>


  <xsl:template match="sec-meta/contrib-group">
    <xsl:apply-templates mode="metadata"/>
  </xsl:template>


  <xsl:template match="sec-meta/kwd-group">
    <!-- matches only if contrib-group has only contrib children -->
    <xsl:apply-templates  select="." mode="metadata"/>
  </xsl:template>

  <xsl:template match="address">
    <xsl:choose>
      <!-- address appears as a sequence of inline elements if
           it has no addr-line and the parent may contain text -->
      <xsl:when test="not(addr-line) and
        (parent::collab | parent::p | parent::license-p |
         parent::named-content | parent::styled-content)">
        <xsl:call-template name="address-line"/>
      </xsl:when>
      <xsl:otherwise>
        <div class="address">
          <xsl:apply-templates/>
        </div>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template name="address-line">
    <!-- emits element children in a simple comma-delimited sequence -->
    <xsl:for-each select="*">
      <xsl:if test="position() &gt; 1">, </xsl:if>
      <xsl:apply-templates/>
    </xsl:for-each>
  </xsl:template>


  <xsl:template match="address/*">
    <div class="address-line">
      <xsl:apply-templates/>
    </div>
  </xsl:template>
  
  <xsl:template match="array | disp-formula-group | fig-group |
    fn-group | license | long-desc | open-access | sig-block | 
    table-wrap-foot | table-wrap-group">
    <div class="sec">
      <xsl:apply-templates/>
    </div>
  </xsl:template>
  
  <xsl:template match="attrib">
    <p class="attrib">
      <xsl:apply-templates/>
    </p>
  </xsl:template>


  <xsl:template match="boxed-text | chem-struct-wrap | fig |
                       table-wrap | chem-struct-wrapper">
    <!-- chem-struct-wrapper is from NLM 2.3 -->
    <xsl:variable name="gi">
      <xsl:choose>
        <xsl:when test="self::chem-struct-wrapper">chem-struct-wrap</xsl:when>
        <xsl:otherwise>
          <xsl:value-of select="local-name(.)"/>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <div class="{$gi} panel">
      <xsl:if test="not(@position != 'float')">
        <!-- the test respects @position='float' as the default -->
        <xsl:attribute name="style">display: float; clear: both</xsl:attribute>
      </xsl:if>
      
      <xsl:apply-templates/>
      <xsl:apply-templates mode="footnote"
        select="self::table-wrap//fn[not(ancestor::table-wrap-foot)]"/>
    </div>
  </xsl:template>
  

  <xsl:template match="caption">
    <div class="caption">
      <xsl:apply-templates/>
    </div>
  </xsl:template>
  

  <xsl:template match="disp-formula | statement">
    <div class="{local-name()} panel">   		
                      
      <xsl:apply-templates/>
    </div>
  </xsl:template>
  

  <xsl:template match="glossary | gloss-group">
    <!-- gloss-group is from 2.3 -->
    <div class="sec">
      
      <xsl:apply-templates select="label | title"/>
      <xsl:if test="not(normalize-space(string(title)))">
        <xsl:call-template name="block-title">
          <xsl:with-param name="contents">
            <span class="generated">Glossary</span>
          </xsl:with-param>
        </xsl:call-template>
      </xsl:if>
      <xsl:apply-templates select="*[not(self::label|self::title)]"/>
    </div>
  </xsl:template>
  

  <xsl:template match="textual-form">
    <p class="textual-form">
      <span class="generated">[Textual form] </span>
      <xsl:apply-templates/>
    </p>
  </xsl:template>
  


  <xsl:template match="glossary/glossary | gloss-group/gloss-group">
    <!-- the same document shouldn't have both types -->
    <div class="sec">
      
      <xsl:apply-templates/>
    </div>
  </xsl:template>
  


  <xsl:template match="graphic | inline-graphic">
    <xsl:apply-templates/>
    <img>
          <xsl:call-template name="assign-img-attr" />
    </img>
  </xsl:template>
  
  
   <xsl:template match="graphic | inline-graphic" mode="popup-img">
    <xsl:apply-templates/>
    <img>
         <xsl:call-template name="assign-img-attr" />  
      	<xsl:if test="ancestor::fig | ancestor::fig-group | ancestor::table-wrap | ancestor::table-wrap-group">
      		<xsl:attribute name="class">tileshop</xsl:attribute>
      	</xsl:if>      	
    </img>
  </xsl:template>
  
   <xsl:template match="graphic | inline-graphic" mode="para">
    <xsl:apply-templates/>
    <img>
        <xsl:call-template name="assign-img-attr" />     
      
      	<xsl:if test="ancestor::fig | ancestor::fig-group | ancestor::table-wrap | ancestor::table-wrap-group">
      		<xsl:attribute name="class">small-thumb</xsl:attribute>
      	</xsl:if>      		
		
		<xsl:call-template name="assign-src-large"/>     
    </img>
  </xsl:template>
  
  
  <xsl:template match="alt-text">
    <!-- handled with graphic or inline-graphic -->
  </xsl:template>



  <xsl:template match="xref">
    <a href="#{@rid}">
      <xsl:apply-templates/>
    </a>
  </xsl:template>
  
    
  <xsl:template match="xref[@ref-type='bibr']">
		<xsl:element name="a">
			<xsl:attribute name="href">#<xsl:value-of select="@rid"/></xsl:attribute>			
			<xsl:attribute name="rid"><xsl:value-of select="@rid"/></xsl:attribute>			
			<xsl:attribute name="class">bibr popnode</xsl:attribute>			
			<xsl:attribute name="id">ref-id-<xsl:value-of select="@rid"/></xsl:attribute>			
			<xsl:apply-templates/>
		</xsl:element>
	</xsl:template>


	
	<xsl:template match="xref[@ref-type='table'] | xref[@ref-type='fig']">		 	
		<xsl:element name="a">
			<xsl:attribute name="class">fig-table-link <xsl:value-of select="name()" /> figpopup</xsl:attribute>
			<xsl:call-template name="assign-ref-object-id" />						
			<xsl:apply-templates />
		</xsl:element>
	</xsl:template>
  

  <xsl:template match="list">
    <div class="list">
      
      <xsl:apply-templates select="label | title"/>
      <xsl:apply-templates select="." mode="list"/>
    </div>
  </xsl:template>
  

  <xsl:template priority="2" mode="list"
    match="list[@list-type='simple' or list-item/label]">
    <ul style="list-style-type: none">
      <xsl:apply-templates select="list-item"/>
    </ul>
  </xsl:template>


  <xsl:template match="list[@list-type='bullet' or not(@list-type)]" mode="list">
    <ul>
      <xsl:apply-templates select="list-item"/>
    </ul>
  </xsl:template>


  <xsl:template match="list" mode="list">
    <xsl:variable name="style">
      <xsl:choose>
        <xsl:when test="@list-type='alpha-lower'">lower-alpha</xsl:when>
        <xsl:when test="@list-type='alpha-upper'">upper-alpha</xsl:when>
        <xsl:when test="@list-type='roman-lower'">lower-roman</xsl:when>
        <xsl:when test="@list-type='roman-upper'">upper-roman</xsl:when>
        <xsl:otherwise>decimal</xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <ol style="list-style-type: {$style}">
      <xsl:apply-templates select="list-item"/>
    </ol>
  </xsl:template>
  

	<xsl:template match="list-item">
		<li>
			<xsl:apply-templates/>
		</li>
	</xsl:template>


	<xsl:template match="list-item/label">
	  <!-- if the next sibling is a p, the label will be called as
	       a run-in -->
	  <xsl:if test="following-sibling::*[1][not(self::p)]">
	    <xsl:call-template name="label"/>
	  </xsl:if>
	</xsl:template>
  
  
	<xsl:template match="media">
		<a>
			<xsl:call-template name="assign-id"/>
			<xsl:call-template name="assign-href"/>
			<xsl:apply-templates/>
		</a>
	</xsl:template>

 
  
  <xsl:template match="@content-type">
    <!-- <span class="generated">[</span>
    <xsl:value-of select="."/>
    <span class="generated">] </span> -->
  </xsl:template>


  <xsl:template match="list-item/p[not(preceding-sibling::*[not(self::label)])]">
    <p>
      <xsl:call-template name="assign-id"/>
      <xsl:for-each select="preceding-sibling::label">
        <span class="label">
          <xsl:apply-templates/>
        </span>
      <xsl:text> </xsl:text>
      </xsl:for-each>
      <xsl:apply-templates select="@content-type"/>
      <xsl:apply-templates/>
    </p>
  </xsl:template>


  <xsl:template match="product">
    <p class="product">
      <xsl:call-template name="assign-id"/>
      <xsl:apply-templates/>
    </p>
  </xsl:template>


  <xsl:template match="permissions">
    <div class="permissions">
    <xsl:apply-templates select="copyright-statement"/>
    <xsl:if test="copyright-year | copyright-holder">
      <p class="copyright">
        <span class="generated">Copyright</span>
        <xsl:for-each select="copyright-year | copyright-holder">
            <xsl:apply-templates/>
            <xsl:if test="not(position()=last())">
              <span class="generated">, </span>
            </xsl:if>
        </xsl:for-each>
      </p>
    </xsl:if>
    <xsl:apply-templates select="license"/>
    </div>
  </xsl:template>
  
  
  <xsl:template match="copyright-statement">
    <p class="copyright">
      <xsl:apply-templates></xsl:apply-templates>
    </p>
  </xsl:template>


  <xsl:template match="def-list">
    <div class="def-list">
      
      <xsl:apply-templates select="label | title"/>
      <div class="def-list table">
        <xsl:if test="term-head|def-head">
          <div class="row">
            <div class="cell def-list-head">
              <xsl:apply-templates select="term-head"/>
            </div>
            <div class="cell def-list-head">
              <xsl:apply-templates select="def-head"/>
            </div>
          </div>
        </xsl:if>
        <xsl:apply-templates select="def-item"/>
      </div>
      <xsl:apply-templates select="def-list"/>
    </div>
  </xsl:template>


	<xsl:template match="def-item">
		<div class="def-item row">
			<xsl:call-template name="assign-id"/>
			<xsl:apply-templates/>
		</div>
	</xsl:template>


	<xsl:template match="term">
		<div class="def-term cell">
			<xsl:call-template name="assign-id"/>
		  <p>
				<xsl:apply-templates/>
		  </p>
		</div>
	</xsl:template>


	<xsl:template match="def">
		<div class="def-def cell">
			<xsl:call-template name="assign-id"/>
			<xsl:apply-templates/>
		</div>
	</xsl:template>


  <xsl:template match="disp-quote">
    <div class="blockquote">
      
      <xsl:apply-templates/>
    </div>
  </xsl:template>


  <xsl:template match="preformat">
    <pre class="preformat">
      <xsl:apply-templates/>
    </pre>
  </xsl:template>


<xsl:template match="app/related-article |
    app-group/related-article | bio/related-article | 
    body/related-article | boxed-text/related-article | 
    disp-quote/related-article | glossary/related-article |
    gloss-group/related-article |
    ref-list/related-article | sec/related-article">
    <xsl:apply-templates select="." mode="metadata"/>
  </xsl:template>
  
  
  <xsl:template match="app/related-object |
    app-group/related-object | bio/related-object |
    body/related-object | boxed-text/related-object | 
    disp-quote/related-object | glossary/related-object |
    gloss-group/related-article |
    ref-list/related-object | sec/related-object">
    <xsl:apply-templates select="." mode="metadata"/>
  </xsl:template>
  
  
  <xsl:template match="speech">
    <div class="speech">
      
      <xsl:apply-templates mode="speech"/>
    </div>
  </xsl:template>
  
  
  <xsl:template match="speech/speaker" mode="speech"/>
    
    
  <xsl:template match="speech/p" mode="speech">
    <p>
      <xsl:apply-templates select="self::p[not(preceding-sibling::p)]/../speaker"/>
      <xsl:apply-templates/>
    </p>
  </xsl:template>
  
  
  <xsl:template match="speech/speaker">
    <b>
      <xsl:apply-templates/>
    </b>
    <span class="generated">: </span>
  </xsl:template>
  
  
  <xsl:template match="supplementary-material">
    <div class="sec">
      <xsl:apply-templates/>
    </div>
  </xsl:template>
  

	<xsl:template match="tex-math">
		<span class="tex-math">
			<span class="generated">[TeX:] </span>
			<xsl:apply-templates/>
		</span>
	</xsl:template>

  
  <xsl:template match="mml:*">
    <!-- this stylesheet simply copies MathML through. If your browser
         supports it, you will get it -->
    <xsl:copy>
      <xsl:copy-of select="@*"/>
      <xsl:apply-templates/>
    </xsl:copy>
  </xsl:template>
  
  
  <xsl:template match="verse-group">
    <div class="verse">
      
      <xsl:apply-templates/>
    </div>
  </xsl:template>
  
  
  <xsl:template match="verse-line">
    <p class="verse-line">
      <xsl:apply-templates/>
    </p>
  </xsl:template>
  
  
  
 
 
 <!-- ============================================================= -->
  <!--  TABLES                                                       -->
  <!-- ============================================================= -->
  <!--  Tables are already in XHTML, and can simply be copied
        through                                                      -->
        
	<xsl:template match="table">
    <xsl:copy>
      <xsl:apply-templates select="@*" mode="table-copy"/>
      <xsl:attribute name="class">rendered</xsl:attribute>
      <xsl:apply-templates/>
    </xsl:copy>
  </xsl:template>
  
  
  <xsl:template match="thead | tbody | tfoot |
      col | colgroup | tr | th | td">
    <xsl:copy>
      <xsl:apply-templates select="@*" mode="table-copy"/>
      <xsl:apply-templates/>
    </xsl:copy>
  </xsl:template>
  
  
  
  <xsl:template match="array/tbody">
    <table class="rendered">
      <xsl:copy>
      <xsl:apply-templates select="@*" mode="table-copy"/>
      
      <xsl:apply-templates/>
    </xsl:copy>
    </table>
  </xsl:template>
  
  
  <xsl:template match="@*" mode="table-copy">
    <xsl:copy-of select="."/>
  </xsl:template>
  
  
  <xsl:template match="@content-type" mode="table-copy">
  	<xsl:attribute name="style"><xsl:value-of select="." /></xsl:attribute>
  </xsl:template>
	
	<!-- ============================================================= -->
<!--  id mode                                                      -->
<!-- ============================================================= -->
<!-- An id can be derived for any element. If an @id is given,
     it is presumed unique and copied. If not, one is generated.   -->

  <xsl:template match="*" mode="id">
    <xsl:value-of select="@id"/>
    <xsl:if test="not(@id)">
      <xsl:value-of select="generate-id(.)"/>
    </xsl:if>
  </xsl:template>


  <xsl:template match="article | sub-article | response" mode="id">
    <xsl:value-of select="@id"/>
    <xsl:if test="not(@id)">
      <xsl:value-of select="local-name()"/>
      <xsl:number from="article" level="multiple"
        count="article | sub-article | response" format="1-1"/>
    </xsl:if>
  </xsl:template>
  
  
  <xsl:template match="p | license-p">
		<xsl:choose>
			<xsl:when test="ancestor::abstract"><p><xsl:apply-templates /></p></xsl:when>
			<xsl:when test="ancestor::body"><p><xsl:apply-templates /></p></xsl:when>
			<xsl:when test="ancestor::back and ancestor::fn-group and descendant::bold"><p><xsl:apply-templates /></p></xsl:when>
			<xsl:when test="ancestor::back and ancestor::bio"><xsl:apply-templates /></xsl:when>
			<xsl:when test="ancestor::article-meta | ancestor::fn	"><xsl:apply-templates /></xsl:when>
			<xsl:otherwise>
				<p><xsl:apply-templates /></p>				
			</xsl:otherwise>	
			
			
		</xsl:choose>
		
		
	</xsl:template>	
	
	
	
	
	<xsl:template match="table-wrap | table-wrap-group | fig | fig-group">		
		<xsl:apply-templates select="." mode="para-mode" />	 
	</xsl:template>
	
	
		
 
</xsl:stylesheet>


