
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  xmlns:mml="http://www.w3.org/1998/Math/MathML"
  exclude-result-prefixes="xlink">   
  
  

<!-- ============================================================= -->
<!--  METADATA PROCESSING                                          -->
<!-- ============================================================= -->

<!--  Includes mode "metadata" for front matter, along with 
      "metadata-inline" for metadata elements collapsed into 
      inline sequences, plus associated named templates            -->

  <!-- WAS journal-meta content:
       journal-id+, journal-title-group*, issn+, isbn*, publisher?,
       notes? -->
  <!-- (journal-id+, journal-title-group*, (contrib-group | aff | aff-alternatives)*,
       issn+, issn-l?, isbn*, publisher?, notes*, self-uri*) -->
  <xsl:template match="journal-id" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Journal ID</xsl:text>
        <xsl:for-each select="@journal-id-type">
          <xsl:text> (</xsl:text>
          <span class="data">
            <xsl:value-of select="."/>
          </span>
          <xsl:text>)</xsl:text>
        </xsl:for-each>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="journal-title-group" mode="metadata">
    <xsl:apply-templates mode="metadata"/>
  </xsl:template>


  <xsl:template match="issn" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>ISSN</xsl:text>
        <xsl:call-template name="append-pub-type"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="issn-l" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>ISSN-L</xsl:text>
        <xsl:call-template name="append-pub-type"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="isbn" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>ISBN</xsl:text>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="publisher" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Publisher</xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates select="publisher-name" mode="metadata-inline"/>
        <xsl:apply-templates select="publisher-loc" mode="metadata-inline"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="publisher-name" mode="metadata-inline">
    <xsl:apply-templates/>
  </xsl:template>


  <xsl:template match="publisher-loc" mode="metadata-inline">
    <span class="generated"> (</span>
    <xsl:apply-templates/>
    <span class="generated">)</span>
  </xsl:template>


  <xsl:template match="notes" mode="metadata">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Notes</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <!-- journal-title-group content:
       (journal-title*, journal-subtitle*, trans-title-group*,
       abbrev-journal-title*) -->

  <xsl:template match="journal-title" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Title</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="journal-subtitle" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Subtitle</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="trans-title-group" mode="metadata">
    <xsl:apply-templates mode="metadata"/>
  </xsl:template>


  <xsl:template match="abbrev-journal-title" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Abbreviated Title</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <!-- trans-title-group content: (trans-title, trans-subtitle*) -->

  <xsl:template match="trans-title" mode="metadata">
    <h1 class="content-title"><xsl:apply-templates /></h1>
  </xsl:template>


  <xsl:template match="trans-subtitle" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Translated Subtitle</xsl:text>
        <xsl:for-each select="(../@xml:lang|@xml:lang)[last()]">
          <xsl:text> (</xsl:text>
          <span class="data">
            <xsl:value-of select="."/>
          </span>
          <xsl:text>)</xsl:text>
        </xsl:for-each>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <!-- article-meta content:
    (article-id*, article-categories?, title-group,
     (contrib-group | aff)*, author-notes?, pub-date+, volume?,
     volume-id*, volume-series?, issue?, issue-id*, 
     issue-title*, issue-sponsor*, issue-part?, isbn*, 
     supplement?, ((fpage, lpage?, page-range?) | elocation-id)?, 
     (email | ext-link | uri | product | supplementary-material)*, 
     history?, permissions?, self-uri*, related-article*,
     abstract*, trans-abstract*, 
     kwd-group*, funding-group*, conference*, counts?, 
     custom-meta-group?) -->

  <!-- In order of appearance... -->

  <xsl:template match="ext-link" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>External link</xsl:text>
        <xsl:for-each select="ext-link-type">
          <xsl:text> (</xsl:text>
          <span class="data">
            <xsl:value-of select="."/>
          </span>
          <xsl:text>)</xsl:text>
        </xsl:for-each>
      </xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates select="."/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="email" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Email</xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates select="."/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="uri" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">URI</xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates select="."/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="self-uri" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Self URI</xsl:text>
      </xsl:with-param>
      <xsl:with-param name="contents">
        <a href="{@xlink:href}">
          <xsl:choose>
            <xsl:when test="normalize-space(string(.))">
              <xsl:apply-templates/>
            </xsl:when>
            <xsl:otherwise>
              <xsl:value-of select="@xlink:href"/>
            </xsl:otherwise>
          </xsl:choose>
        </a>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="product" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Product Information</xsl:text>
      </xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:choose>
          <xsl:when test="normalize-space(string(@xlink:href))">
            <a>
              <xsl:call-template name="assign-href"/>
              <xsl:apply-templates/>
            </a>
          </xsl:when>
          <xsl:otherwise>
            <xsl:apply-templates/>
          </xsl:otherwise>
        </xsl:choose>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="permissions" mode="metadata">
    <div class="fm-cpl-info fm-panel half_rhythm">
		<div class="fm-copyright half_rhythm">
			<xsl:apply-templates select="copyright-statement | copyright-holder | license" mode="metadata" />
		</div>
	</div>
  </xsl:template>


  <xsl:template match="copyright-statement" mode="metadata">
    <div class="fm-copyright half_rhythm"><xsl:apply-templates /></div>
  </xsl:template>
  
  
  <xsl:template match="copyright-year" mode="metadata">
   <div class="fm-copyright half_rhythm"><xsl:apply-templates /></div>
  </xsl:template>
  
  
  <xsl:template match="license" mode="metadata">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">
        <xsl:if test="@license-type | @xlink:href">
          <xsl:text> (</xsl:text>
          <span class="data">
            <xsl:value-of select="@license-type"/>
            <xsl:if test="@xlink:href">
              <xsl:if test="@license-type">, </xsl:if>
              <a>
                <xsl:call-template name="assign-href"/>
                <xsl:value-of select="@xlink:href"/>
              </a>
            </xsl:if>
          </span>
          <xsl:text>)</xsl:text>
        </xsl:if>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="history/date" mode="metadata">
    <xsl:if test="@date-type">
			<xsl:apply-templates select="@date-type" /><xsl:text> : </xsl:text>
		</xsl:if>
		<xsl:call-template name="format-date" />
		<xsl:choose>			
			<xsl:when test="position()=last()"><xsl:text>.</xsl:text></xsl:when>			
			<xsl:otherwise><xsl:text>, </xsl:text></xsl:otherwise>
		</xsl:choose>
  </xsl:template>


  <xsl:template match="pub-date" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Publication date</xsl:text>
        <xsl:call-template name="append-pub-type"/>
      </xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:call-template name="format-date"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template name="volume-info">
    <!-- handles volume?, volume-id*, volume-series? -->
    <xsl:if test="volume | volume-id | volume-series">
      <xsl:choose>
        <xsl:when test="not(volume-id[2]) or not(volume)">
          <!-- if there are no multiple volume-id, or no volume, we make one line only -->
          <xsl:call-template name="metadata-labeled-entry">
            <xsl:with-param name="label">Volume</xsl:with-param>
            <xsl:with-param name="contents">
              <xsl:apply-templates select="volume | volume-series"
                mode="metadata-inline"/>
              <xsl:apply-templates select="volume-id" mode="metadata-inline"/>
            </xsl:with-param>
          </xsl:call-template>
        </xsl:when>
        <xsl:otherwise>
          <xsl:apply-templates select="volume | volume-id | volume-series"
            mode="metadata"/>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:if>
  </xsl:template>


  <xsl:template match="volume | issue" mode="metadata-inline">
    <xsl:apply-templates/>
  </xsl:template>


  <xsl:template match="volume-series" mode="metadata-inline">
    <xsl:if test="preceding-sibling::volume">
      <span class="generated">,</span>
    </xsl:if>
    <xsl:text> </xsl:text>
    <xsl:apply-templates />
  </xsl:template><xsl:template match="volume-id | issue-id" mode="metadata-inline">
    <span class="generated">
      <xsl:text> (</xsl:text>
      <xsl:for-each select="@pub-id-type">
        <span class="data">
          <xsl:value-of select="."/>
        </span>
        <xsl:text> </xsl:text>
      </xsl:for-each>
      <xsl:text>ID: </xsl:text>
    </span>
    <xsl:apply-templates/>
    <span class="generated">)</span>
  </xsl:template>


  


  <xsl:template match="volume" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Volume</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="volume-id" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Volume ID</xsl:text>
        <xsl:for-each select="@pub-id-type">
          <xsl:text> (</xsl:text>
          <span class="data">
            <xsl:value-of select="."/>
          </span>
          <xsl:text>)</xsl:text>
        </xsl:for-each>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="volume-series" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Series</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template name="issue-info">
    <!-- handles issue?, issue-id*, issue-title*, issue-sponsor*, issue-part?, supplement? -->
    <xsl:variable name="issue-info"
      select="issue | issue-id | issue-title |
      issue-sponsor | issue-part"/>
    <xsl:choose>
      <xsl:when
        test="$issue-info and not(issue-id[2] | issue-title[2] | issue-sponsor | issue-part)">
        <!-- if there are only one issue, issue-id and issue-title and nothing else, we make one line only -->
        <xsl:call-template name="metadata-labeled-entry">
          <xsl:with-param name="label">Issue</xsl:with-param>
          <xsl:with-param name="contents">
            <xsl:apply-templates select="issue | issue-title"
              mode="metadata-inline"/>
            <xsl:apply-templates select="issue-id" mode="metadata-inline"/>
          </xsl:with-param>
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="$issue-info" mode="metadata"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="issue-title" mode="metadata-inline">
    <span class="generated">
      <xsl:if test="preceding-sibling::issue">,</xsl:if>
    </span>
    <xsl:text> </xsl:text>
    <xsl:apply-templates/>
  </xsl:template>


  <xsl:template match="issue" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Issue</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="issue-id" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Issue ID</xsl:text>
        <xsl:for-each select="@pub-id-type">
          <xsl:text> (</xsl:text>
          <span class="data">
            <xsl:value-of select="."/>
          </span>
          <xsl:text>)</xsl:text>
        </xsl:for-each>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="issue-title" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Issue title</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="issue-sponsor" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Issue sponsor</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="issue-part" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Issue part</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template name="page-info">
    <!-- handles (fpage, lpage?, page-range?) -->
    <xsl:if test="fpage | lpage | page-range">
      <xsl:call-template name="metadata-labeled-entry">
        <xsl:with-param name="label">
          <xsl:text>Page</xsl:text>
          <xsl:if
            test="normalize-space(string(lpage[not(.=../fpage)]))
                   or normalize-space(string(page-range))">
            <!-- we have multiple pages if lpage exists and is not equal fpage,
               or if we have a page-range -->
            <xsl:text>s</xsl:text>
          </xsl:if>
        </xsl:with-param>
        <xsl:with-param name="contents">
          <xsl:value-of select="fpage"/>
          <xsl:if test="normalize-space(string(lpage[not(.=../fpage)]))">
            <xsl:text>-</xsl:text>
            <xsl:value-of select="lpage"/>
          </xsl:if>
          <xsl:for-each select="page-range">
            <xsl:text> (pp. </xsl:text>
            <xsl:value-of select="."/>
            <xsl:text>)</xsl:text>
          </xsl:for-each>
        </xsl:with-param>
      </xsl:call-template>
    </xsl:if>
  </xsl:template>


  <xsl:template match="elocation-id" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Electronic Location
      Identifier</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <!-- isbn is already matched in mode 'metadata' above -->

  <xsl:template match="supplement" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Supplement Info</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="related-article | related-object" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Related </xsl:text>
          <xsl:choose>
            <xsl:when test="self::related-object">object</xsl:when>
            <xsl:otherwise>article</xsl:otherwise>
          </xsl:choose>
        <xsl:for-each select="@related-article-type | @object-type">
          <xsl:text> (</xsl:text>
          <span class="data">
            <xsl:value-of select="translate(.,'-',' ')"/>
          </span>
          <xsl:text>)</xsl:text>
        </xsl:for-each>
      </xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:choose>
          <xsl:when test="normalize-space(string(@xlink:href))">
            <a>
              <xsl:call-template name="assign-href"/>
              <xsl:apply-templates/>
            </a>
          </xsl:when>
          <xsl:otherwise>
            <xsl:apply-templates/>
          </xsl:otherwise>
        </xsl:choose>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="conference" mode="metadata">
    <!-- content model:
      (conf-date, 
       (conf-name | conf-acronym)+, 
       conf-num?, conf-loc?, conf-sponsor*, conf-theme?) -->
    <xsl:choose>
      <xsl:when
        test="not(conf-name[2] | conf-acronym[2] | conf-sponsor |
                  conf-theme)">
        <!-- if there is no second name or acronym, and no sponsor
             or theme, we make one line only -->
        <xsl:call-template name="metadata-labeled-entry">
          <xsl:with-param name="label">Conference</xsl:with-param>
          <xsl:with-param name="contents">
            <xsl:apply-templates select="conf-acronym | conf-name"
              mode="metadata-inline"/>
            <xsl:apply-templates select="conf-num" mode="metadata-inline"/>
            <xsl:if test="conf-date | conf-loc">
              <span class="generated"> (</span>
              <xsl:for-each select="conf-date | conf-loc">
                <xsl:if test="position() = 2">, </xsl:if>
                <xsl:apply-templates select="." mode="metadata-inline"/>
              </xsl:for-each>
              <span class="generated">)</span>
            </xsl:if>
          </xsl:with-param>
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates mode="metadata"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="conf-date" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Conference date</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="conf-name" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Conference</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="conf-acronym" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Conference</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="conf-num" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Conference number</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="conf-loc" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Conference location</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="conf-sponsor" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Conference sponsor</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="conf-theme" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Conference theme</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="conf-name | conf-acronym" mode="metadata-inline">
    <!-- we only hit this template if there is at most one of each -->
    <xsl:variable name="following"
      select="preceding-sibling::conf-name | preceding-sibling::conf-acronym"/>
    <!-- if we come after the other, we go in parentheses -->
    <xsl:if test="$following">
      <span class="generated"> (</span>
    </xsl:if>
    <xsl:apply-templates/>
    <xsl:if test="$following">
      <span class="generated">)</span>
    </xsl:if>
  </xsl:template>


  <xsl:template match="conf-num" mode="metadata-inline">
    <xsl:text> </xsl:text>
    <xsl:apply-templates/>
  </xsl:template>


  <xsl:template match="conf-date | conf-loc" mode="metadata-inline">
    <xsl:apply-templates/>
  </xsl:template>
  
  <xsl:template match="article-id[@pub-id-type='doi']" mode="href-link">
  		http://dx.doi.org/<xsl:apply-templates />
  </xsl:template>
  
  <xsl:template match="article-id[@pub-id-type='doi']" mode="metadata">
  	<xsl:text>doi : </xsl:text>
    <xsl:element name="a">
    	<xsl:attribute name="href"><xsl:apply-templates select="." mode="href-link" /></xsl:attribute>
    	<xsl:attribute name="target">_blank</xsl:attribute>
    	<xsl:apply-templates select="." mode="href-link" />
    </xsl:element>
  </xsl:template>


  <xsl:template match="article-id" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:choose>
          <xsl:when test="@pub-id-type='art-access-id'">Accession ID</xsl:when>
          <xsl:when test="@pub-id-type='coden'">Coden</xsl:when>
          <xsl:when test="@pub-id-type='doi'">doi</xsl:when>
          <xsl:when test="@pub-id-type='manuscript'">Manuscript ID</xsl:when>
          <xsl:when test="@pub-id-type='medline'">Medline ID</xsl:when>
          <xsl:when test="@pub-id-type='pii'">Publisher Item ID</xsl:when>
          <xsl:when test="@pub-id-type='pmid'">PubMed ID</xsl:when>
          <xsl:when test="@pub-id-type='publisher-id'">Publisher ID</xsl:when>
          <xsl:when test="@pub-id-type='sici'">Serial Item and Contribution ID</xsl:when>
          <xsl:when test="@pub-id-type='doaj'">DOAJ ID</xsl:when>
          <xsl:when test="@pub-id-type='arXiv'">arXiv.org ID</xsl:when>
          <xsl:otherwise>
            <xsl:text>Article Id</xsl:text>
            <xsl:for-each select="@pub-id-type">
              <xsl:text> (</xsl:text>
              <span class="data">
                <xsl:value-of select="."/>
              </span>
              <xsl:text>)</xsl:text>
            </xsl:for-each>
          </xsl:otherwise>
        </xsl:choose>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="contract-num" mode="metadata">
    <!-- only in 2.3 -->
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Contract</xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  
  <xsl:template match="contract-sponsor" mode="metadata">
    <!-- only in 2.3 -->
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Contract Sponsor</xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  
  <xsl:template match="grant-num" mode="metadata">
    <!-- only in 2.3 -->
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Grant Number</xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  
  <xsl:template match="grant-sponsor" mode="metadata">
    <!-- only in 2.3 -->
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Grant Sponsor</xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  
  
  <xsl:template match="award-group" mode="metadata">
    <!-- includes (funding-source*, award-id*, principal-award-recipient*, principal-investigator*) -->
    <xsl:apply-templates mode="metadata"/>
  </xsl:template>


  <xsl:template match="funding-source" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Funded by</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="award-id" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Award ID</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="principal-award-recipient" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Award Recipient</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="principal-investigator" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Principal Investigator</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="funding-statement" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Funding</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="open-access" mode="metadata">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Open Access</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="title-group" mode="metadata">
    <!-- content model:
    article-title, subtitle*, trans-title-group*, alt-title*, fn-group? -->
    <!-- trans-title and trans-subtitle included for 2.3 -->
    <xsl:apply-templates select="article-title | subtitle | trans-title-group |
      trans-title | trans-subtitle"
      mode="metadata"/>
    <xsl:if test="alt-title | fn-group">
      <div class="content-title-notes metadata-group">
        <xsl:apply-templates select="alt-title | fn-group" mode="metadata"/>
      </div>
    </xsl:if>
  </xsl:template>


  <xsl:template match="title-group/article-title" mode="metadata">
    <h1 class="content-title">
      <xsl:apply-templates/>
      <xsl:if test="../subtitle">:</xsl:if>
    </h1>
  </xsl:template>


  <xsl:template match="title-group/subtitle | trans-title-group/subtitle"
    mode="metadata">
    <h2 class="content-title">
      <xsl:apply-templates/>
    </h2>
  </xsl:template>


  <xsl:template match="title-group/trans-title-group" mode="metadata">
    <!-- content model: (trans-title, trans-subtitle*) -->
    <xsl:apply-templates mode="metadata"/>
  </xsl:template>



  <xsl:template match="title-group/alt-title" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="title-group/fn-group" mode="metadata">
    <xsl:apply-templates/>
  </xsl:template>


  <xsl:template mode="metadata" match="journal-meta/contrib-group">
    <xsl:for-each select="contrib">
      <xsl:variable name="contrib-identification">
        <xsl:call-template name="contrib-identify"/>
      </xsl:variable>
      <!-- placing the div only if it has content -->
      <!-- the extra call to string() makes it type-safe in a type-aware
           XSLT 2.0 engine -->
      <xsl:if test="normalize-space(string($contrib-identification))">
        <xsl:copy-of select="$contrib-identification"/>
      </xsl:if>
      <xsl:variable name="contrib-info">
        <xsl:call-template name="contrib-info"/>
      </xsl:variable>
      <!-- placing the div only if it has content -->
      <xsl:if test="normalize-space(string($contrib-info))">
        <xsl:copy-of select="$contrib-info"/>
      </xsl:if>
    </xsl:for-each>
    
    <xsl:if test="*[not(self::contrib | self::xref)]">
      
        <xsl:apply-templates mode="metadata"
          select="*[not(self::contrib | self::xref)]"/>
      
    </xsl:if>
  </xsl:template>
	
	<xsl:template match="contrib-id[@contrib-id-type='orcid']">	
		<xsl:element name="a">
			<xsl:attribute name="href"><xsl:apply-templates /></xsl:attribute>
			<xsl:element name="img">
				<xsl:attribute name="src"><xsl:text>/PubReader/img/orcid_16x16.gif</xsl:text></xsl:attribute>
				<xsl:attribute name="alt">orcid_icon</xsl:attribute>
			</xsl:element>			
		</xsl:element>			
	</xsl:template>
	
	 <xsl:template match="contrib-id">
	    [<xsl:apply-templates />]
	  </xsl:template>


  <xsl:template name="contrib-identify">
    <!-- Placed in a left-hand pane  -->
    <!--handles
    (anonymous | collab | collab-alternatives |
    name | name-alternatives | degrees | xref)
    and @equal-contrib -->
    <div class="metadata-group">
      <xsl:for-each select="anonymous |
        collab | collab-alternatives/* | name | name-alternatives/*">
        <xsl:call-template name="metadata-entry">
          <xsl:with-param name="contents">
            <xsl:if test="position() = 1">
              <!-- a named anchor for the contrib goes with its
              first member -->
              
              <!-- so do any contrib-ids -->
              <xsl:apply-templates mode="metadata-inline"
                select="../contrib-id"/>
            </xsl:if>
            <xsl:apply-templates select="." mode="metadata-inline"/>
            <xsl:if test="position() = last()">
              <xsl:apply-templates mode="metadata-inline" select="degrees | xref"/>
              <!-- xrefs in the parent contrib-group go with the last member
              of *each* contrib in the group -->
              <xsl:apply-templates mode="metadata-inline"
                select="following-sibling::xref"/>
            </xsl:if>
            
          </xsl:with-param>
        </xsl:call-template>
      </xsl:for-each>
      
      <xsl:if test="@equal-contrib='yes'">
        <xsl:call-template name="metadata-entry">
          <xsl:with-param name="contents">
          <span class="generated">(Equal contributor)</span>
          </xsl:with-param>
        </xsl:call-template>
      </xsl:if>
    </div>
  </xsl:template>


  <xsl:template match="anonymous" mode="metadata-inline">
    <xsl:text>Anonymous</xsl:text>        
  </xsl:template>


  <xsl:template match="collab | collab-alternatives/*" mode="metadata-inline">
    <xsl:apply-templates/>
  </xsl:template>
  
  
  <xsl:template mode="metadata" match="article-meta/contrib-group">
    <div class="half_rhythm">
		<div class="contrib-group fm-author">
			<xsl:for-each select="contrib/name">
				<xsl:call-template name="print-author" />
			</xsl:for-each>
		</div>	
		
		<div class="contrib-group fm-author">
			<xsl:for-each select="contrib/name-alternatives/name[@name-style='western']">
				<xsl:call-template name="print-author" />
			</xsl:for-each>	
		</div>
		
		<xsl:if test="aff-alternatives">
			<div class="fm-authors-info fm-panel half_rhythm">
				<xsl:for-each select="aff-alternatives/aff[1]">
					<xsl:apply-templates select="." mode="metadata" />
				</xsl:for-each>				
			</div>
		</xsl:if>
		
		<div class="contrib-group fm-author">
			<xsl:for-each select="contrib/name-alternatives/name[@name-style='eastern']">
				<xsl:call-template name="print-author" />
			</xsl:for-each>	
		</div>
		
		<xsl:if test="aff-alternatives">
			<div class="fm-authors-info fm-panel half_rhythm">
				<xsl:for-each select="aff-alternatives/aff[2]">
					<xsl:apply-templates select="." mode="metadata" />
				</xsl:for-each>				
			</div>
		</xsl:if>
	</div>	
	
	<xsl:if test="aff">
		<div class="fm-panel small half_rhythm">
			<div class="fm-authors-info fm-panel half_rhythm">		
				<xsl:apply-templates select="aff" mode="metadata" />
			</div>	
		</div>
	</xsl:if>	
		
	<xsl:apply-templates select="*[not(self::contrib or self::aff or self::aff-alternatives)]" mode="metadata"  />
  </xsl:template>


  <xsl:template match="contrib/name | name-alternatives/*" mode="metadata-inline">		
	<xsl:choose>
		<xsl:when test="@name-style='eastern'"><xsl:call-template name="author-string" /></xsl:when>
		<xsl:otherwise>
			<xsl:element name="a">
				<xsl:call-template name="name-link-href" />
				<xsl:call-template name="author-string" />
			</xsl:element>
		</xsl:otherwise>
	</xsl:choose>
  </xsl:template>
  
   <xsl:template match="prefix" mode="metadata-inline">				
		<xsl:apply-templates />
		<xsl:text> </xsl:text>
	</xsl:template>
	
	 <xsl:template match="given-names" mode="metadata-inline">			
	 	<xsl:choose>
			<xsl:when test="../@xml:lang='ko'"></xsl:when>
			<xsl:otherwise><xsl:text> </xsl:text></xsl:otherwise>
		</xsl:choose>
		<xsl:apply-templates />		
	</xsl:template>
	
	<xsl:template match="surname" mode="metadata-inline">
		<xsl:choose>
			<xsl:when test="../@xml:lang='ko'"></xsl:when>
			<xsl:otherwise><xsl:text> </xsl:text></xsl:otherwise>
		</xsl:choose>
		<xsl:apply-templates />		
	</xsl:template>			
	
	<xsl:template match="surfix" mode="metadata-inline">
		<xsl:text> </xsl:text>
		<xsl:apply-templates />
	</xsl:template>

  <xsl:template match="degrees" mode="metadata-inline">
    <xsl:text>, </xsl:text>
    <xsl:apply-templates/>
  </xsl:template>


  <xsl:template match="xref" mode="metadata-inline">
    <!-- These are not expected to appear in mixed content, so
      brackets are provided -->
    
    <xsl:apply-templates />
    
  </xsl:template>  
  
  
  <xsl:template name="contrib-info">
    <!-- Placed in a right-hand pane -->
    <div class="metadata-group">
      <xsl:apply-templates mode="metadata"
        select="address | aff | author-comment | bio | email |
                ext-link | on-behalf-of | role | uri"/>
    </div>
  </xsl:template>


  <xsl:template mode="metadata"
    match="address[not(addr-line) or not(*[2])]">
    <!-- when we have no addr-line or a single child, we generate
         a single unlabelled line -->
        <xsl:call-template name="metadata-entry">
          <xsl:with-param name="contents">
            <xsl:call-template name="address-line"/>
          </xsl:with-param>
        </xsl:call-template>
  </xsl:template>


  <xsl:template match="address" mode="metadata">
    <!-- when we have an addr-line we generate an unlabelled block -->
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="contents">
        <xsl:apply-templates mode="metadata"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template mode="metadata" priority="2" match="address/*">
    <!-- being sure to override other templates for these
         element types -->
    <xsl:call-template name="metadata-entry"/>
  </xsl:template>


  <xsl:template match="aff" mode="metadata">
    <xsl:call-template name="metadata-entry">
      <xsl:with-param name="contents">        
        <xsl:apply-templates/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="author-comment" mode="metadata">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Comment</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="bio" mode="metadata">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Bio</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="on-behalf-of" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">On behalf of</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="role" mode="metadata">
    <xsl:call-template name="metadata-entry"/>
  </xsl:template>

	<xsl:template match="corresp" mode="metadata">
		<xsl:element name="div">
			<xsl:attribute name="id"><xsl:apply-templates select="@id" /></xsl:attribute>
			<xsl:apply-templates />
		</xsl:element>				
	</xsl:template>




  <xsl:template match="author-notes/fn | author-notes/p" mode="metadata">
    <div id="{@id}"><xsl:apply-templates /></div>
  </xsl:template>

  
  <xsl:template match="supplementary-material" mode="metadata">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Supplementary material</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="article-categories" mode="metadata">
    <xsl:apply-templates mode="metadata"/>
  </xsl:template>


  <xsl:template match="article-categories/subj-group" mode="metadata">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Categories</xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates mode="metadata"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="subj-group" mode="metadata">
    <xsl:apply-templates mode="metadata"/>
  </xsl:template>


  <xsl:template match="subj-group/subj-group" mode="metadata">
    <div class="metadata-area" id="{@id}">
      <xsl:apply-templates mode="metadata"/>
    </div>
  </xsl:template>


  <xsl:template match="subj-group/subject" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Subject</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="series-title" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Series title</xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="series-text" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">Series description</xsl:with-param>
    </xsl:call-template>
  </xsl:template>
    
  <xsl:template match="kwd-group" mode="metadata">
		<div class="sec">
			<strong class="kwd-title">Keywords: </strong>
			<span class="kwd-text"><xsl:apply-templates select="kwd" mode="metadata" /></span>
		</div>		
	</xsl:template>


  <xsl:template match="title" mode="metadata">
    <xsl:apply-templates select="."/>
  </xsl:template>
  


  <xsl:template match="kwd" mode="metadata">
    <xsl:element name="a">
    	<xsl:call-template name="keyword-link-href" />
    	<xsl:apply-templates />
    </xsl:element>
    <xsl:choose>
			<xsl:when test="position()=last()"><xsl:text></xsl:text></xsl:when>
			<xsl:otherwise><xsl:text>, </xsl:text></xsl:otherwise>
		</xsl:choose>
  </xsl:template>

  <xsl:template match="nested-kwd" mode="metadata">
    <ul class="nested-kwd">
      <xsl:apply-templates mode="metadata"/>
    </ul>
  </xsl:template>
  
  <xsl:template match="nested-kwd/kwd" mode="metadata">
    <li class="kwd">
      <xsl:apply-templates/>
    </li>
  </xsl:template>
  
  
  <xsl:template match="compound-kwd" mode="metadata">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Compound keyword</xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates mode="metadata"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="compound-kwd-part" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:text>Keyword part</xsl:text>
        <xsl:for-each select="@content-type">
          <xsl:text> (</xsl:text>
          <span class="data">
            <xsl:value-of select="."/>
          </span>
          <xsl:text>)</xsl:text>
        </xsl:for-each>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="counts" mode="metadata">
    <!-- fig-count?, table-count?, equation-count?, ref-count?,
         page-count?, word-count? -->
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Counts</xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates mode="metadata"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template mode="metadata"
    match="count | fig-count | table-count | equation-count |
           ref-count | page-count | word-count">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <xsl:apply-templates select="." mode="metadata-label"/>
      </xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:value-of select="@count"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="count"
    mode="metadata-label">
    <xsl:text>Count</xsl:text>
    <xsl:for-each select="@count-type">
      <xsl:text> (</xsl:text>
      <span class="data">
        <xsl:value-of select="."/>
      </span>
      <xsl:text>)</xsl:text>
    </xsl:for-each>
  </xsl:template>
  
  
  <xsl:template match="fig-count"
    mode="metadata-label">Figures</xsl:template>
  
  
  <xsl:template match="table-count"
    mode="metadata-label">Tables</xsl:template>


  <xsl:template match="equation-count"
    mode="metadata-label">Equations</xsl:template>


  <xsl:template match="ref-count"
    mode="metadata-label">References</xsl:template>


  <xsl:template match="page-count"
    mode="metadata-label">Pages</xsl:template>


  <xsl:template match="word-count"
    mode="metadata-label">Words</xsl:template>


  <xsl:template mode="metadata"
    match="custom-meta-group | custom-meta-wrap">
    <xsl:call-template name="metadata-area">
      <xsl:with-param name="label">Custom metadata</xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates mode="metadata"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="custom-meta" mode="metadata">
    <xsl:call-template name="metadata-labeled-entry">
      <xsl:with-param name="label">
        <span class="data">
          <xsl:apply-templates select="meta-name" mode="metadata-inline"/>
        </span>
      </xsl:with-param>
      <xsl:with-param name="contents">
        <xsl:apply-templates select="meta-value" mode="metadata-inline"/>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>


  <xsl:template match="meta-name | meta-value" mode="metadata-inline">
    <xsl:apply-templates/>
  </xsl:template>
  </xsl:stylesheet>