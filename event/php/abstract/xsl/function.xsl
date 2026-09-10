<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xlink="http://www.w3.org/1999/xlink"
	xmlns:mml="http://www.w3.org/1998/Math/MathML" exclude-result-prefixes="xlink">
	
	<xsl:variable name="date-type" select="//date-type" />

	<xsl:template name="assign-ref-object-id">
		<xsl:attribute name="class">fig-table-link <xsl:apply-templates
			select="@ref-type" /> figpopup</xsl:attribute>
		<xsl:attribute name="href">#<xsl:apply-templates
			select="@rid" /></xsl:attribute>
		<xsl:attribute name="target"><xsl:value-of select="@ref-type" /></xsl:attribute>
		<xsl:attribute name="rid-figpopup"><xsl:apply-templates
			select="@rid" /></xsl:attribute>
		<xsl:attribute name="rid-ob">ob-<xsl:apply-templates
			select="@rid" /></xsl:attribute>
		<xsl:attribute name="co-legend-rid">lgnd_<xsl:apply-templates
			select="@rid" /></xsl:attribute>
	</xsl:template>

	<xsl:template name="assign-img-attr">
		<xsl:attribute name="alt"><xsl:apply-templates
			select="../label" /></xsl:attribute>
		<xsl:attribute name="title"><xsl:apply-templates
			select="../title" /></xsl:attribute>
		<xsl:attribute name="style">max-width:80%</xsl:attribute>
		<xsl:call-template name="assign-img-src"></xsl:call-template>
		<xsl:call-template name="assign-src-large"></xsl:call-template>
	</xsl:template>

	<xsl:template name="assign-src-url">
		<xsl:apply-templates select="//thumb-path" />
		<xsl:choose>
			<xsl:when test="contains(@xlink:href, '.tif' )">
				<xsl:value-of select="concat(substring-before(@xlink:href, '.tif'), '.gif')" />
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="@xlink:href" />
				<xsl:if test="not(contains(@xlink:href,'.gif')) and not(contains(@xlink:href,'.jpg')) and not(contains(@xlink:href,'.png'))">				
					<xsl:text>.jpg</xsl:text>
				</xsl:if>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template name="assign-src-large">
		<xsl:attribute name="src-large">
  		<xsl:call-template name="assign-src-url" />	
    </xsl:attribute>
	</xsl:template>


	<xsl:template name="assign-src">
		<xsl:attribute name="src">
       <xsl:call-template name="assign-src-url" />	
     </xsl:attribute>
	</xsl:template>

	<xsl:template name="assign-img-src">
		<xsl:attribute name="src">
  		<xsl:call-template name="assign-src-url" />	
    </xsl:attribute>
	</xsl:template>


	<xsl:template name="link_list">

		<!-- SC에 등재된 저널 링크 -->
		<xsl:if test="/journal-list-url">
			<xsl:element name="a">
				<xsl:attribute name="class"><xsl:text>navlink</xsl:text></xsl:attribute>
				<xsl:attribute name="href"><xsl:apply-templates
					select="/journal-list-url" /></xsl:attribute>
				<xsl:attribute name="target">_blank</xsl:attribute>
				<xsl:text>Journal List</xsl:text>
			</xsl:element>
		</xsl:if>

		<!-- 논문의 저널의 아카이브나 SC된 issue 링크 -->
		<xsl:element name="a">
			<xsl:attribute name="class"><xsl:text>navlink</xsl:text></xsl:attribute>
			<xsl:attribute name="href"><xsl:apply-templates
				select="/journal-issues-url" /></xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<xsl:apply-templates select="/custom-abbr" />
		</xsl:element>

		<xsl:element name="a">
			<xsl:attribute name="class"><xsl:text>navlink</xsl:text></xsl:attribute>
			<xsl:attribute name="href"><xsl:apply-templates
				select="/journal-articles-url" /></xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<xsl:apply-templates select="article/front/article-meta"
				mode="article-no" />
		</xsl:element>

	</xsl:template>

	<xsl:template name="alternative-link">
		<xsl:element name="a">
			<xsl:attribute name="href"><xsl:apply-templates
				select="/article-url" /></xsl:attribute>
			<xsl:attribute name="target"><xsl:text>_blank</xsl:text></xsl:attribute>
			<xsl:text>Classic View</xsl:text>
		</xsl:element>
		<xsl:element name="a">
			<xsl:attribute name="href"><xsl:apply-templates
				select="/pdf-file" /></xsl:attribute>
			<xsl:attribute name="target"><xsl:text>_blank</xsl:text></xsl:attribute>
			<xsl:text>Article PDF</xsl:text>
		</xsl:element>
		<xsl:if test="//article-id[@pub-id-type='doi']">
			<xsl:element name="a">
				<xsl:attribute name="href"><xsl:apply-templates
					select="(//article-id[@pub-id-type='doi'])[1]" mode="href-link" /></xsl:attribute>
				<xsl:attribute name="target"><xsl:text>_blank</xsl:text></xsl:attribute>
				<xsl:text>Full Text Via Doi</xsl:text>
			</xsl:element>
		</xsl:if>
	</xsl:template>

	<xsl:template name="append-pub-type">
		<!-- adds a value mapped for @pub-type, enclosed in parenthesis, to a string -->
		<xsl:for-each select="@pub-type">
			<xsl:text> (</xsl:text>
			<span class="data">
				<xsl:choose>
					<xsl:when test=".='epub'">
						electronic
					</xsl:when>
					<xsl:when test=".='ppub'">
						print
					</xsl:when>
					<xsl:when test=".='epub-ppub'">
						print and electronic
					</xsl:when>
					<xsl:when test=".='epreprint'">
						electronic preprint
					</xsl:when>
					<xsl:when test=".='ppreprint'">
						print preprint
					</xsl:when>
					<xsl:when test=".='ecorrected'">
						corrected, electronic
					</xsl:when>
					<xsl:when test=".='pcorrected'">
						corrected, print
					</xsl:when>
					<xsl:when test=".='eretracted'">
						retracted, electronic
					</xsl:when>
					<xsl:when test=".='pretracted'">
						retracted, print
					</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="." />
					</xsl:otherwise>
				</xsl:choose>
			</span>
			<xsl:text>)</xsl:text>
		</xsl:for-each>
	</xsl:template>


	<xsl:template name="metadata-labeled-entry">
		<xsl:param name="label" />
		<xsl:param name="contents">
			<xsl:apply-templates />
		</xsl:param>
		<xsl:call-template name="metadata-entry">
			<xsl:with-param name="contents">
				<xsl:if test="normalize-space(string($label))">
					<span class="generated">
						<xsl:copy-of select="$label" />
						<xsl:text> : </xsl:text>
					</span>
				</xsl:if>
				<xsl:copy-of select="$contents" />
			</xsl:with-param>
		</xsl:call-template>
	</xsl:template>


	<xsl:template name="metadata-entry">
		<xsl:param name="contents">
			<xsl:apply-templates />
		</xsl:param>
		<div id="{@id}">
			<xsl:copy-of select="$contents" />
		</div>
	</xsl:template>


	<xsl:template name="metadata-area">
		<xsl:param name="label" />
		<xsl:param name="contents">
			<xsl:apply-templates />
		</xsl:param>
		<div class="metadata-area">
			<xsl:if test="normalize-space(string($label))">
				<xsl:call-template name="metadata-labeled-entry">
					<xsl:with-param name="label">
						<xsl:copy-of select="$label" />
					</xsl:with-param>
					<xsl:with-param name="contents" />
				</xsl:call-template>
			</xsl:if>
			<div class="metadata-chunk">
				<xsl:copy-of select="$contents" />
			</div>
		</div>
	</xsl:template>


	<xsl:template name="make-label-text">
		<xsl:param name="auto" select="false()" />
		<xsl:param name="warning" select="false()" />
		<xsl:param name="auto-text" />
		<xsl:choose>
			<xsl:when test="$auto">
				<span class="generated">
					<xsl:copy-of select="$auto-text" />
				</span>
			</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates mode="label-text" select="label | @symbol" />
				<xsl:if test="$warning and not(label|@symbol)">
					<span class="warning">
						<xsl:text>{ label</xsl:text>
						<xsl:if test="self::fn">
							(or @symbol)
						</xsl:if>
						<xsl:text> needed for </xsl:text>
						<xsl:value-of select="local-name()" />
						<xsl:for-each select="@id">
							<xsl:text>[@id='</xsl:text>
							<xsl:value-of select="." />
							<xsl:text>']</xsl:text>
						</xsl:for-each>
						<xsl:text> }</xsl:text>
					</span>
				</xsl:if>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>


	<xsl:template name="assign-id">
		<xsl:variable name="id">
			<xsl:apply-templates select="." mode="id" />
		</xsl:variable>
		<xsl:attribute name="id">
      <xsl:value-of select="$id" />
    </xsl:attribute>
	</xsl:template>





	<xsl:template name="assign-href">
		<xsl:for-each select="@xlink:href">
			<xsl:attribute name="href">
        <xsl:value-of select="." />
      </xsl:attribute>
		</xsl:for-each>
	</xsl:template>





	<xsl:template name="format-date">
		<!-- formats date in DD Month YYYY format -->
		<!-- context must be 'date', with content model: (((day?, month?) | season)?, 
			year) -->
		
			
		
		<xsl:choose>
			<xsl:when test="$date-type='2'"><xsl:call-template name="format-kor-date" /></xsl:when>
			<xsl:otherwise><xsl:call-template name="format-eng-date" /></xsl:otherwise>
		</xsl:choose>	

		<xsl:if test="day">
			<xsl:text> </xsl:text>
			<xsl:apply-templates select="day" mode="map" />
		</xsl:if>

		<xsl:if test="season">
			<xsl:text> </xsl:text>
			<xsl:apply-templates select="season" mode="map" />
		</xsl:if>
	</xsl:template>
	
	<xsl:template name="format-eng-date">
		<xsl:apply-templates select="year" mode="map" />

		<xsl:if test="month">
			<xsl:text> </xsl:text>
			<xsl:apply-templates select="month" mode="map" />
		</xsl:if>
	</xsl:template>
	
	<xsl:template name="format-kor-date">		
		<xsl:apply-templates select="year" mode="map" />
		<xsl:text>. </xsl:text>
		<xsl:if test="month">			
			<xsl:apply-templates select="month" />
			<xsl:text>. </xsl:text>
		</xsl:if>
	</xsl:template>


	<xsl:template match="season | day | year" mode="map">
		<xsl:apply-templates />
	</xsl:template>


	<xsl:template match="month" mode="map">
		<!-- maps numeric values to English months -->
		<xsl:choose>
			<xsl:when test="number() = 1">January</xsl:when> 
			<xsl:when test="number() = 2">February</xsl:when> 
			<xsl:when test="number() = 3">March</xsl:when> 
			<xsl:when test="number() = 4">April</xsl:when> 
			<xsl:when test="number() = 5">May</xsl:when> 
			<xsl:when test="number() = 6">June</xsl:when> 
			<xsl:when test="number() = 7">July</xsl:when> 
			<xsl:when test="number() = 8">August</xsl:when> 
			<xsl:when test="number() = 9">September</xsl:when> 
			<xsl:when test="number() = 10">October</xsl:when> 
			<xsl:when test="number() = 11">November</xsl:when> 
			<xsl:when test="number() = 12">December</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates />
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template name="print-period">
		<xsl:param name="sentense" />
		<xsl:choose>
			<xsl:when test="substring($sentense, string-length($sentense)) = '.'">
				<xsl:text> </xsl:text>
			</xsl:when>
			<xsl:when test="substring($sentense, string-length($sentense)) = '!'">
				<xsl:text> </xsl:text>
			</xsl:when>
			<xsl:when test="substring($sentense, string-length($sentense)) = '?'">
				<xsl:text> </xsl:text>
			</xsl:when>
			<xsl:when test="substring($sentense, string-length($sentense)) = ';'">
				<xsl:text> </xsl:text>
			</xsl:when>
			<xsl:when test="substring($sentense, string-length($sentense)) = ':'">
				<xsl:text> </xsl:text>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text>. </xsl:text>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>


	<xsl:template name="backmatter-section">
		<xsl:param name="generated-title" />
		<xsl:param name="contents">
			<xsl:apply-templates />
		</xsl:param>
		<div class="sec {name()}">

			<xsl:if test="not(title) and $generated-title">
				<xsl:choose>
					<!-- The level of title depends on whether the back matter itself has 
						a title -->
					<xsl:when test="ancestor::back/title">
						<xsl:call-template name="section-title">
							<xsl:with-param name="contents" select="$generated-title" />
						</xsl:call-template>
					</xsl:when>
					<xsl:otherwise>
						<xsl:call-template name="main-title">
							<xsl:with-param name="contents" select="$generated-title" />
						</xsl:call-template>
					</xsl:otherwise>
				</xsl:choose>
			</xsl:if>
			<xsl:copy-of select="$contents" />
		</div>
	</xsl:template>


	<xsl:template name="name-link-href">
		<!--<xsl:attribute name="href"><xsl:apply-templates
			select="/search-url" />?<xsl:call-template name="name-link-query" />
  	</xsl:attribute>-->
	</xsl:template>

	<xsl:template name="name-link-query">
		<xsl:choose>
			<xsl:when test="/search-url-type = '1'">
				<xsl:text>term=author&amp;given_name=</xsl:text>
				<xsl:apply-templates select="given-names" />
				<xsl:text>&amp;surname=</xsl:text>
				<xsl:apply-templates select="surname" />
			</xsl:when>
			<xsl:otherwise>
				<xsl:text>term=author&amp;f_name=</xsl:text>
				<xsl:apply-templates select="given-names" />
				<xsl:text>&amp;l_name=</xsl:text>
				<xsl:apply-templates select="surname" />
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>


	<xsl:template name="keyword-link-href">
		<xsl:attribute name="href"><xsl:apply-templates
			select="/search-url" />?<xsl:call-template name="keyword-link-query" /></xsl:attribute>
	</xsl:template>

	<xsl:template name="keyword-link-query">
		<xsl:choose>
			<xsl:when test="/search-url-type = '1'">
				<xsl:text>term=keywords like &apos;%</xsl:text>
				<xsl:apply-templates select="." />
				<xsl:text>%&apos;</xsl:text>
			</xsl:when>
			<xsl:when test="/search-url-type = '2'">
				<xsl:text>term=4&amp;key=</xsl:text>
				<xsl:apply-templates select="." />
			</xsl:when>
			<xsl:when test="/search-url-type = '3'">
				<xsl:text>term=keywords&amp;key=</xsl:text>
				<xsl:apply-templates select="." />
			</xsl:when>
		</xsl:choose>
	</xsl:template>

	<xsl:template name="print-comma-and">
		<xsl:choose>
			<xsl:when test="position()=1">
				<xsl:text></xsl:text>
			</xsl:when>
			<xsl:when test="position()=last()">
				<xsl:text> , </xsl:text>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text>, </xsl:text>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>


	<xsl:template name="print-author">
		<xsl:call-template name="print-comma-and" />
		<xsl:apply-templates select="." mode="metadata-inline" />
		<xsl:apply-templates select="ancestor::contrib/contrib-id" />
		<xsl:apply-templates select="ancestor::contrib/xref" />
		<xsl:apply-templates
			select="ancestor::contrib/*[not(self::xref or self::contrib-id or self::name or self::name-alternatives or self::degrees)]" />
	</xsl:template>

	<xsl:template name="author-string">
		<xsl:apply-templates select="prefix" mode="metadata-inline" />

		<xsl:choose>
			<xsl:when test="@name-style='eastern'">
				<xsl:apply-templates select="surname" mode="metadata-inline" />
				<xsl:apply-templates select="given-names" mode="metadata-inline" />
			</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates select="given-names" mode="metadata-inline" />
				<xsl:apply-templates select="surname" mode="metadata-inline" />
			</xsl:otherwise>
		</xsl:choose>
		<xsl:apply-templates select="surfix" mode="metadata-inline" />
	</xsl:template>

	<xsl:template name="print-lngd-in-content">
		<xsl:for-each
			select="xref[generate-id()=generate-id(key('sup-in-p',@rid)[1])]">
			<xsl:variable name="xref-rid">
				<xsl:value-of select="@rid" />
			</xsl:variable>
			<xsl:apply-templates
				select="(//fig)[@id=$xref-rid] | (//fig-group)[@id=$xref-rid] | (//table-wrap)[@id=$xref-rid] | (//table-wrap-group)[@id=$xref-rid]"
				mode="para-mode" />
		</xsl:for-each>
	</xsl:template>

	<xsl:template name="print-lngd-in-descendant">
		<xsl:for-each
			select="descendant::xref[generate-id()=generate-id(key('sup-in-p',@rid)[1])]">
			<xsl:variable name="xref-rid">
				<xsl:value-of select="@rid" />
			</xsl:variable>
			<xsl:apply-templates
				select="(//fig)[@id=$xref-rid] | (//fig-group)[@id=$xref-rid] | (//table-wrap)[@id=$xref-rid] | (//table-wrap-group)[@id=$xref-rid]"
				mode="para-mode" />
		</xsl:for-each>
	</xsl:template>



</xsl:stylesheet>
