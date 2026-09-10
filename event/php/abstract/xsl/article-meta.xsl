<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xlink="http://www.w3.org/1999/xlink"
	xmlns:mml="http://www.w3.org/1998/Math/MathML" exclude-result-prefixes="xlink">		
	
	<xsl:template match="history" mode="metadata">
		<div class="fm-article-notes fm-panel half_rhythm">
			<div class="fm-pubdate half_rhythm">				
				<xsl:apply-templates select="date" mode="metadata" />
			</div>
		</div>		
	</xsl:template>  
	
	<xsl:template match="abstract | trans-abstract">
		<xsl:element name="div">						
			<xsl:attribute name="class">sec</xsl:attribute>
			<xsl:if test="name()='abstract'">
				<xsl:element name="h2">
					<xsl:attribute name="class">head no_bottom_margin</xsl:attribute>
					<xsl:attribute name="id">__fn__abstract</xsl:attribute>
					<xsl:text>Abstract</xsl:text>
				</xsl:element>	
			</xsl:if>			
			<xsl:element name="div">
				<xsl:attribute name="class">fm-<xsl:value-of select="name()"/> fm-panel half_rhythm</xsl:attribute>
				<xsl:apply-templates />
			</xsl:element>
		</xsl:element>
	</xsl:template>
	
	<!--DOI 링크 출력-->
	<xsl:template match="article-id[@pub-id-type='doi']" mode="img">		
		<div>
			<xsl:element name="a">
				<xsl:attribute name="href">http://dx.doi.org/<xsl:apply-templates /></xsl:attribute>				
				<xsl:element name="img">
					<xsl:attribute name="src"><xsl:apply-templates select="//banner-file"/></xsl:attribute>
				</xsl:element>
			</xsl:element>
		</div>
	</xsl:template>



	<xsl:template match="article-meta | front-stub" mode="information">
		<header class="fm-sec">
			<xsl:if test="//banner-file">
				<xsl:apply-templates select="article-id[@pub-id-type='doi']" mode="img" />
			</xsl:if>
			<xsl:apply-templates select="title-group" mode="metadata" />
		</header>
		
		<div id="__ffn_sec" class="sec">
			<h2 class="head no_bottom_margin" id="__ffn_sectitle">Article information</h2>
			<div class="fm-sec">
				<div class="fm-citation half_rhythm no_top_margin clearfix">
					<div class="small">
						<div class="inline_block nine_col va_top">
							<div>
								<!-- DOI 및 저널의 정보 출력 부분 -->
								<xsl:apply-templates select="." mode="article-citation" />
							</div>
							<div>
								<!-- 출판일 출력부분 -->
								<xsl:apply-templates select="pub-date[@pub-type='epub']" mode="metadata" />
								<xsl:text> </xsl:text>
								<!-- DOI 출력 부분 -->
								<xsl:apply-templates select="article-id[@pub-id-type='doi']" mode="metadata" />
							</div>
						</div>
					</div>
				</div>
												
				<xsl:apply-templates select="contrib-group" mode="metadata" />
				
				<div class="fm-panel small half_rhythm">
					<div class="fm-authors-info fm-panel half_rhythm">						
						<xsl:if test="aff">								
							<xsl:apply-templates select="aff" mode="metadata" />									
						</xsl:if>
						
						<xsl:apply-templates select="author-notes" mode="metadata"/>
					</div>
				</div>				
				<xsl:apply-templates select="history" mode="metadata" />			
			</div>
		</div>
		<div id="before_abstract"></div>
		<xsl:apply-templates select="abstract | trans-abstract" />
		<xsl:apply-templates select="kwd-group" mode="metadata" />	


	</xsl:template>
	
	
	<xsl:template match="article-meta | front-stub" mode="metadata">

		<div class="sec">
	  		
	  		<div class="fm-sec">
			  	<xsl:apply-templates select="copyright-statement | license | permissions | issue-id | issue-title | issue-sponsor | issue-part | isbn | supplement | self-uri | related-article | funding-group | conference | counts | custom-meta-group" mode="metadata" />
		  	</div>  	
	  	</div>
		
	</xsl:template>
</xsl:stylesheet>
