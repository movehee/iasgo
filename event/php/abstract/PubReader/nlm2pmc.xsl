<?xml version="1.0" encoding="UTF-8"?>
<!-- Version 1.0 - February 18, 2013 XML (NLM DTD) to PMC Website Format 
	(non DTD) for use with PubReader transformation see https://github.com/NCBITools/PubReader 
	1. java -jar saxon9he.jar -xsl:nlm2pmc.xsl -s:nlm_xml_file.xml > pmc_format_file.xml 
	2. java -jar saxon9he.jar -xsl:test-page.xsl -s:pmc_format_file.xml > pubreader_file.html 
	-or- you can jsut set-up a transfomration scenario in a XML editor (e.g. 
	OxygenXML) Mike Lotz - you can email me if you have any questions - mikelotz@gmail.com -->


<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="http://www.w3.org/1999/xhtml"
	version="1.0">


  <xsl:output method="html" indent="yes" />

  <xsl:strip-space elements="*" />

  <xsl:variable name="journal"> <xsl:text>Prostate Int</xsl:text> </xsl:variable> 
  <xsl:variable name="pub_id"> <xsl:value-of select="/article/front/article-meta/article-id[@pub-id-type='publisher-id']"/> </xsl:variable> 
  <xsl:variable name="journal_title"> <xsl:value-of select="/article/front/journal-meta/journal-title-group/journal-title"/> </xsl:variable> 
  <xsl:variable name="publisher"> <xsl:value-of select="/article/front/journal-meta/publisher/publisher-name"/> </xsl:variable> 
  <xsl:variable name="title"> <xsl:copy-of select="/article/front/article-meta/title-group/article-title"/> </xsl:variable> 
  <xsl:variable name="doi"> <xsl:value-of select="/article/front/article-meta/article-id[@pub-id-type='doi']"/> </xsl:variable> 
  
  <xsl:variable name="year"> <xsl:value-of select="/article/front/article-meta/pub-date[@pub-type='epub']/year"/> </xsl:variable> 
  <xsl:variable name="month"> <xsl:value-of select="/article/front/article-meta/pub-date[@pub-type='epub']/month"/> </xsl:variable> 
  <xsl:variable name="day"> <xsl:value-of select="/article/front/article-meta/pub-date[@pub-type='epub']/day"/> </xsl:variable> 

  <xsl:variable name="volume"> <xsl:value-of select="/article/front/article-meta/volume"/> </xsl:variable> 

  <xsl:variable name="issue"> <xsl:value-of select="/article/front/article-meta/issue"/> </xsl:variable>  
  

  <xsl:variable name="fpage"> <xsl:value-of select="/article/front/article-meta/fpage"/> </xsl:variable> 
  <xsl:variable name="lpage"> <xsl:value-of select="/article/front/article-meta/lpage"/> </xsl:variable> 

  <xsl:variable name="competing"> <xsl:value-of select="/article/back/fn-group/fn[@fn-type='conflict']"/> </xsl:variable> 
  <xsl:variable name="ack"> <xsl:value-of select="/article/back/ack/p"/> </xsl:variable> 
  <xsl:variable name="footnote"> <xsl:value-of select="/article/back/fn-group/fn[@fn-type='financial-disclosure']/p"/> </xsl:variable> 
  <xsl:variable name="conflict"> <xsl:value-of select="/article/back/fn-group/fn[@fn-type='conflict']/p"/> </xsl:variable> 
  <xsl:variable name="received_year"> <xsl:value-of select="/article/front/article-meta/history/date[@date-type='received']/year" /> </xsl:variable> 
  <xsl:variable name="received_month"> <xsl:value-of select="/article/front/article-meta/history/date[@date-type='received']/month" /> </xsl:variable> 
  <xsl:variable name="received_day"> <xsl:value-of select="/article/front/article-meta/history/date[@date-type='received']/day"/> </xsl:variable> 
  <xsl:variable name="accept_year"> <xsl:value-of select="/article/front/article-meta/history/date[@date-type='accepted']/year" /> </xsl:variable> 
  <xsl:variable name="accept_month"> <xsl:value-of select="/article/front/article-meta/history/date[@date-type='accepted']/month" /> </xsl:variable> 
  <xsl:variable name="accept_day"> <xsl:value-of select="/article/front/article-meta/history/date[@date-type='accepted']/day"/> </xsl:variable> 
  <xsl:variable name="copyright"> <xsl:value-of select="/article/front/article-meta/permissions/copyright-year"/> </xsl:variable>
  <xsl:variable name="copyright_statement"> <xsl:value-of select="/article/front/article-meta/permissions/copyright-statement"/> </xsl:variable>




	<xsl:template name="authors">
		<xsl:for-each select="/article/front/article-meta/contrib-group/contrib/name">
			<xsl:variable name="author_name"><xsl:value-of select="given-names" /><xsl:text> </xsl:text><xsl:value-of select="surname" /></xsl:variable>
			<xsl:value-of select="$author_name" />
			<xsl:choose>
				<xsl:when test="position()=last()"><xsl:text /></xsl:when>
				<xsl:otherwise><xsl:text>, </xsl:text></xsl:otherwise>
			</xsl:choose>
		</xsl:for-each>
	</xsl:template>

	<xsl:template name="search_author">
		<xsl:for-each select="/article/front/article-meta/contrib-group/contrib[@contrib-type='author']">
			<xsl:element name="a">
				<xsl:attribute name="href">/articles/search_result.php?term=author&amp;f_name=<xsl:value-of select="name/given-names" />&amp;l_name=<xsl:value-of select="name/surname" /></xsl:attribute>
				<xsl:value-of select="name/given-names" /> <xsl:text> </xsl:text><xsl:value-of select="name/surname" />
			</xsl:element>
			<xsl:if test="xref/sup">
				<xsl:for-each select="xref/sup">
					<sup><xsl:copy-of select="." /></sup>
				</xsl:for-each>				
			</xsl:if>
			<xsl:choose>
				<xsl:when test="position()=last()">
					<xsl:text/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:text>, </xsl:text>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:for-each>
	</xsl:template>

	<xsl:template name="aff">
		<xsl:for-each select="/article/front/article-meta/contrib-group/aff">
			<div class="fm-affl">				
				<xsl:value-of select="text()" /><xsl:value-of select="country" />
			</div>
		</xsl:for-each>
		
		<xsl:for-each select="/article/front/article-meta/aff">
			<div class="fm-affl">
				<sup>
					<xsl:value-of select="label" />
				</sup>
				<xsl:value-of select="text()" /><xsl:value-of select="country" />
			</div>
		</xsl:for-each>

	</xsl:template>

	<xsl:template name="abstract">
		<xsl:for-each select="/article/front/article-meta/abstract/p">
			<xsl:element name="div">
				<xsl:choose>
					<xsl:when test="position() = 1">
						<xsl:attribute name="class">sec sec-first</xsl:attribute>
					</xsl:when>
					<xsl:when test="position() =last()">
						<xsl:attribute name="class">sec sec-lat</xsl:attribute>
					</xsl:when>
					<xsl:otherwise>
						<xsl:attribute name="class">sec</xsl:attribute>
					</xsl:otherwise>
				</xsl:choose>
				<xsl:copy-of select="." />
			</xsl:element>
		</xsl:for-each>
		<xsl:for-each select="/article/front/article-meta/abstract/sec">
			<xsl:element name="div">
				<xsl:choose>
					<xsl:when test="position() = 1">
						<xsl:attribute name="class">sec sec-first</xsl:attribute>
					</xsl:when>
					<xsl:when test="position() =last()">
						<xsl:attribute name="class">sec sec-lat</xsl:attribute>
					</xsl:when>
					<xsl:otherwise>
						<xsl:attribute name="class">sec</xsl:attribute>
					</xsl:otherwise>
				</xsl:choose>
				<div>
					<b><xsl:value-of select="title" /></b>
					<xsl:copy-of select="p" />
				</div>				
			</xsl:element>
		</xsl:for-each>
	</xsl:template>


	<xsl:template name="keywords">
		<xsl:for-each select="/article/front/article-meta/kwd-group/kwd">
			<xsl:value-of select="." />

			<xsl:choose>
				<xsl:when test="position() =last()">
					<xsl:text />
				</xsl:when>
				<xsl:otherwise>
					<xsl:text>, </xsl:text>
				</xsl:otherwise>
			</xsl:choose>

		</xsl:for-each>

	</xsl:template>

	<xsl:template name="body">
		<div class="sec sec-first">
			<xsl:for-each select="/article/body/p">
				<xsl:copy-of select="." />
			</xsl:for-each>
		</div>



		<xsl:element name="div">
			<xsl:attribute name="class">sec</xsl:attribute>
			<xsl:attribute name="id"><xsl:text>__sec</xsl:text></xsl:attribute>

			<xsl:for-each select="/article/body/sec">
				<xsl:variable name="position">
					<xsl:value-of select="position()" />
				</xsl:variable>

				<xsl:for-each select="title">
					<xsl:element name="h2">
						<xsl:attribute name="class">head no_bottom_margin</xsl:attribute>
						<xsl:attribute name="id"><xsl:text>__sec</xsl:text><xsl:value-of select="$position" /><xsl:text>title</xsl:text></xsl:attribute>
						<xsl:value-of select="." />
					</xsl:element>
				</xsl:for-each>


				<xsl:for-each select="p">
					<xsl:copy-of select="." />
					<xsl:call-template name="aMaterial">
						<xsl:with-param name="value" select="xref/@rid" />
					</xsl:call-template>
				</xsl:for-each>

				<xsl:for-each select="sec">

					<xsl:for-each select="title">
						<xsl:element name="h3">
							<xsl:attribute name="id">
							<xsl:text>__sec</xsl:text>
							<xsl:value-of select="$position" />
							<xsl:text>title</xsl:text>
						</xsl:attribute>
							<xsl:value-of select="." />
						</xsl:element>
					</xsl:for-each>

					<xsl:for-each select="p">
						<xsl:copy-of select="." />


						<xsl:call-template name="aMaterial">
							<xsl:with-param name="value" select="xref/@rid" />
						</xsl:call-template>
					</xsl:for-each>					
				</xsl:for-each>	
			</xsl:for-each>			

		</xsl:element>
	</xsl:template>

	
	<xsl:template name="aMaterial">
		<xsl:param name="value" />		
		<xsl:call-template name="figure_in_content">
			<xsl:with-param name="value" select="$value" />
		</xsl:call-template>

		<xsl:call-template name="table_in_content">
			<xsl:with-param name="value" select="$value" />
		</xsl:call-template>

	</xsl:template>

	<xsl:template name="figure_in_content">
		<xsl:param name="value" />
		<xsl:for-each select="/article/back/sec/fig[@id=$value]">
			<xsl:element name="div">
				<xsl:attribute name="class">fig iconblock ten_col whole_rhythm clearfix</xsl:attribute>
				<xsl:attribute name="id"><xsl:value-of select="concat('F',@id)" /></xsl:attribute>
				<xsl:attribute name="co-legend-rid"><xsl:value-of select="concat('lgnd_F',@id)" /></xsl:attribute>

				<xsl:element name="a">
					<xsl:attribute name="class">icnblk_img figpopup</xsl:attribute>					
					<xsl:attribute name="href">/upload/thumbnails/<xsl:value-of select="graphic/@*[namespace-uri()='http://www.w3.org/1999/xlink' and local-name()='href']" /></xsl:attribute>
					<xsl:attribute name="target">figure</xsl:attribute>
					<xsl:attribute name="rid-figpopup"><xsl:value-of select="concat('F',@id)" /></xsl:attribute>
					<xsl:attribute name="rid-ob"><xsl:value-of select="concat('ob-F',@id)" /></xsl:attribute>
					<xsl:attribute name="onclick">return startTarget(this, 'figure',1024,800)</xsl:attribute>
					<xsl:element name="img">
						<xsl:attribute name="src">/upload/thumbnails/<xsl:value-of select="graphic/@*[namespace-uri()='http://www.w3.org/1999/xlink' and local-name()='href']" /></xsl:attribute>
						
						<xsl:attribute name="class">small-thumb</xsl:attribute>
						<xsl:attribute name="alt"><xsl:value-of select="label" /></xsl:attribute>
						<xsl:attribute name="title"><xsl:value-of select="label" /></xsl:attribute>
						<xsl:attribute name="src-large">/upload/thumbnails/<xsl:value-of select="graphic/@*[namespace-uri()='http://www.w3.org/1999/xlink' and local-name()='href']" /></xsl:attribute>
					</xsl:element>
				</xsl:element>

				<xsl:element name="div">
					<xsl:attribute name="class">icnblk_cntnt</xsl:attribute>
					<xsl:attribute name="id">
					<xsl:value-of select="concat('lgnd_F',@id)" />
				</xsl:attribute>
					<div>
						<xsl:element name="a">
							<xsl:attribute name="class">figpopup</xsl:attribute>
							<xsl:attribute name="href">/upload/thumbnails/<xsl:value-of select="graphic/@*[namespace-uri()='http://www.w3.org/1999/xlink' and local-name()='href']" /></xsl:attribute>
							<xsl:attribute name="target">figure</xsl:attribute>
							<xsl:attribute name="rid-figpopup"><xsl:value-of select="concat('F',@id)" /></xsl:attribute>
							<xsl:attribute name="rid-ob"><xsl:value-of select="concat('ob-F',@id)" /></xsl:attribute>
							<xsl:attribute name="onclick">return startTarget(this, 'figure',1024,800)</xsl:attribute>
							<xsl:value-of select="label" />
						</xsl:element>
					</div>
					<div>
						<span>
							<xsl:value-of select="caption/p" />
						</span>
					</div>
				</xsl:element>
			</xsl:element>
		</xsl:for-each>
	</xsl:template>

	<xsl:template name="table_in_content">
		<xsl:param name="value" />
		<xsl:for-each select="/article/back/sec/table-wrap[@id=$value]">
			<xsl:element name="div">
				<xsl:attribute name="class">table-wrap iconblock ten_col whole_rhythmclearfix</xsl:attribute>
				<xsl:attribute name="id">
				<xsl:value-of select="concat('T',@id)" /></xsl:attribute>
				<xsl:element name="a">
					<xsl:attribute name="class">table img_link icnblk_img figpopup</xsl:attribute>
					<xsl:attribute name="href">/upload/thumbnails/<xsl:value-of select="@id" /><xsl:text>.gif</xsl:text></xsl:attribute>
					<xsl:attribute name="target">table</xsl:attribute>
					<xsl:attribute name="rid-figpopup">
					<xsl:value-of select="concat('T',@id)" />
				</xsl:attribute>
					<xsl:attribute name="rid-ob">
					<xsl:value-of select="concat('ob-T',@id)" />
				</xsl:attribute>
					<xsl:attribute name="onclick">return startTarget(this, 'table',1024,800)</xsl:attribute>
					<xsl:element name="img">
						<xsl:attribute name="src">/upload/thumbnails/<xsl:value-of select="@id" /><xsl:text>.gif</xsl:text></xsl:attribute>
						<xsl:attribute name="border">0</xsl:attribute>
						<xsl:attribute name="class">small-thumb</xsl:attribute>
						<xsl:attribute name="alt">
						<xsl:value-of select="label" />
					</xsl:attribute>
						<xsl:attribute name="title">
						<xsl:value-of select="label" />
					</xsl:attribute>
						<xsl:attribute name="src-large">/upload/thumbnails/<xsl:value-of select="@id" /><xsl:text>.gif</xsl:text></xsl:attribute>
					</xsl:element>
				</xsl:element>
				<xsl:element name="div">
					<xsl:attribute name="class">icnblk_cntnt</xsl:attribute>
					<div>
						<xsl:element name="a">
							<xsl:attribute name="class">figpopup</xsl:attribute>
							<xsl:attribute name="href">/upload/thumbnails/<xsl:value-of select="@id" /><xsl:text>.gif</xsl:text></xsl:attribute>
							<xsl:attribute name="target">table</xsl:attribute>
							<xsl:attribute name="rid-figpopup">
							<xsl:value-of select="concat('F',@id)" />
						</xsl:attribute>
							<xsl:attribute name="rid-ob">
							<xsl:value-of select="concat('ob-F',@id)" />
						</xsl:attribute>
							<xsl:attribute name="onclick">return startTarget(this, 'table',1024,800)</xsl:attribute>
							<xsl:value-of select="label" />
						</xsl:element>

					</div>
					<div>
						<span>
							<xsl:copy-of select="caption/p" />
						</span>
					</div>
				</xsl:element>
			</xsl:element>
		</xsl:for-each>
	</xsl:template>

	<xsl:template name="figures_and_tables">

		<xsl:for-each select="/article/back/sec/fig">
			<xsl:element name="article">
				<xsl:attribute name="data-type">fig</xsl:attribute>
				<xsl:attribute name="id"><xsl:value-of select="concat('ob-F',@id)" /></xsl:attribute>
				<xsl:element name="div">
					<xsl:attribute name="class">fig anchored whole_rhythm</xsl:attribute>
					<xsl:attribute name="id"><xsl:value-of select="concat('F',@id)" /></xsl:attribute>
					<h3>
						<xsl:value-of select="label" />
					</h3>
					<div class="figure">
						<xsl:element name="a">
							<xsl:attribute name="class">inline_block ts_canvas</xsl:attribute>							
							<xsl:attribute name="href">/upload/thumbnails/<xsl:value-of select="graphic/@*[namespace-uri()='http://www.w3.org/1999/xlink' and local-name()='href']" /></xsl:attribute>
							<xsl:attribute name="target">tileshopwindow</xsl:attribute>
							<xsl:attribute name="onclick">return startTarget(this, 'tileshopwindow', 1024, 800)</xsl:attribute>
							<div class="ts_bar small" title="Click on image to zoom"></div>
							<xsl:element name="img">
								<xsl:attribute name="alt"><xsl:value-of select="label" /></xsl:attribute>
								
								<xsl:attribute name="title">Click on image to zoom</xsl:attribute>
								<xsl:attribute name="class">tileshop</xsl:attribute>
								<xsl:attribute name="src">/upload/thumbnails/<xsl:value-of select="graphic/@*[namespace-uri()='http://www.w3.org/1999/xlink' and local-name()='href']" /></xsl:attribute>
							</xsl:element>
						</xsl:element>
					</div>
					<div class="caption">
						<p>
							<xsl:value-of select="caption" />
						</p>
					</div>
				</xsl:element>
			</xsl:element>
		</xsl:for-each>


		<xsl:for-each select="/article/back/sec/table-wrap">
			<xsl:element name="article">
				<xsl:attribute name="data-type">table</xsl:attribute>
				<xsl:attribute name="id"><xsl:value-of select="concat('ob-T',@id)" /></xsl:attribute>
				<xsl:element name="div">
					<xsl:attribute name="class">fig anchored whole_rhythm</xsl:attribute>
					<xsl:attribute name="id"><xsl:value-of select="concat('T',@id)" /></xsl:attribute>
					<xsl:attribute name="style"><xsl:text>text-align:center;</xsl:text></xsl:attribute>

					<h3><xsl:value-of select="label" /></h3>
					<h1><xsl:value-of select="caption/p" /></h1>

					<div class="figure" style="text-align:center;margin:auto;width:90%;"><xsl:copy-of select="table" /></div>
					<div class="caption" style="width:80%;margin:auto;text-align:justify;">
						<p>
							<xsl:value-of select="table-wrap-foot/fn/p" />
						</p>
					</div>
				</xsl:element>
			</xsl:element>
		</xsl:for-each>		

	</xsl:template>



	<xsl:template name="ref">
		<xsl:for-each select="/article/back/ref-list/ref/element-citation">

				<xsl:element name="div">
					<xsl:attribute name="id"><xsl:value-of select="../@id" /></xsl:attribute>
					<xsl:attribute name="name"><xsl:text>jeehp-ref-pub</xsl:text></xsl:attribute>
					<xsl:value-of select="../label" />
					<xsl:choose>
						<xsl:when test="contains(../label,'.')">
							<xsl:text> </xsl:text>
						</xsl:when>
						<xsl:otherwise>
							<xsl:text>. </xsl:text>
						</xsl:otherwise>
					</xsl:choose>				

					<xsl:for-each select="*">		
						
						<!-- 값을 출력하기 위한 접두사 코드-->
						<xsl:choose>
							<xsl:when test="name()='conf-name' and not(../person-group[@person-group-type='editor'])">
								<xsl:choose>
									<xsl:when test="contains(.,'at:')">
										<xsl:text> </xsl:text>
									</xsl:when>
									<xsl:otherwise>
										<xsl:text>In : </xsl:text>
									</xsl:otherwise>
								</xsl:choose>						
							</xsl:when>

							<xsl:when test="name()='fpage'">
								<xsl:choose>
									<!-- @publication-type 이 confproc 경우 -->
									<xsl:when test="../@publication-type='confproc'">    
										<xsl:text>p. </xsl:text>
									</xsl:when>
									<xsl:when test="../@publication-type='book'">    
										<xsl:text>p. </xsl:text>
									</xsl:when>
									<!-- 그외 일 경우 -->
									<xsl:otherwise>
										<xsl:text></xsl:text>
									</xsl:otherwise>
								</xsl:choose>							
							</xsl:when>

							<xsl:when test="name()='lpage'">
								<xsl:text>–</xsl:text>														
							</xsl:when>
							<xsl:otherwise>
								<xsl:text></xsl:text>
							</xsl:otherwise>
						</xsl:choose>	
						<!-- 접두사 코드 종료-->
					
						<!-- 저자 목록외에 값을 출력하는 코드 -->
						<xsl:choose>

							<xsl:when test="@person-group-type='author'">							
								<xsl:for-each select="name">							
									<xsl:value-of select="surname" />
									<xsl:text> </xsl:text>
									<xsl:value-of select="given-names" />
									<xsl:choose>
										<xsl:when test="position()=last() and ../collab">
											<xsl:text>; </xsl:text>
										</xsl:when>
										<xsl:when test="position()=last()">
											<xsl:text></xsl:text>
										</xsl:when>
										<xsl:otherwise>
											<xsl:text>, </xsl:text>
										</xsl:otherwise>
									</xsl:choose>		
								</xsl:for-each>
							</xsl:when>

							<xsl:when test="@person-group-type='editor'">		
								<xsl:if test="../conf-name">
								<xsl:choose>
										<xsl:when test="contains(.,'at:')">
											<xsl:text> </xsl:text>
										</xsl:when>
										<xsl:otherwise>
											<xsl:text>In : </xsl:text>
										</xsl:otherwise>
									</xsl:choose>						
								</xsl:if>
								<xsl:for-each select="name">	
									<xsl:value-of select="surname" />
									<xsl:text> </xsl:text>
									<xsl:value-of select="given-names" />
									<xsl:choose>
										<xsl:when test="position()=last()">
											<xsl:text>, editor</xsl:text>
											<xsl:if test="position()>1">
												<xsl:text>s</xsl:text>
											</xsl:if>
											<xsl:text></xsl:text>
										</xsl:when>
										<xsl:otherwise>
											<xsl:text>, </xsl:text>
										</xsl:otherwise>
									</xsl:choose>
								</xsl:for-each>
							</xsl:when>

							<xsl:otherwise>
								<xsl:value-of select="." />
							</xsl:otherwise>
						</xsl:choose>	
						<!-- 값 출력 종료 -->

						<!-- 접미사 출력하는 코드 -->
						<xsl:choose>	
							<xsl:when test="name()='fpage'">							
								<xsl:text></xsl:text>
							</xsl:when>
							<xsl:when test="name()='lpage'">							
								<xsl:text>. </xsl:text>
							</xsl:when>



							<xsl:when test="name()='collab'">
								<xsl:text>. </xsl:text>
							</xsl:when>											
							

							



							<xsl:when test="collab">
								<xsl:value-of select="collab" />
								<xsl:text>. </xsl:text>
							</xsl:when>
							
							<xsl:when test="name()='article-title'">
								<xsl:choose>
									<xsl:when test="substring(., string-length(.)) = '?'">
										<xsl:text> </xsl:text>
									</xsl:when>
									<xsl:when test="substring(., string-length(.)) = '!'">
										<xsl:text> </xsl:text>
									</xsl:when>
									<xsl:when test="substring(., string-length(.)) = '.'">
										<xsl:text> </xsl:text>
									</xsl:when>
									<xsl:otherwise>
										<xsl:text>. </xsl:text>
									</xsl:otherwise>
								</xsl:choose>	
							</xsl:when>								

							<xsl:when test="name()='conf-name'">								
								<xsl:choose>
									<xsl:when test="contains(.,'at:')">
										<xsl:text>. </xsl:text>
									</xsl:when>
									<xsl:otherwise>
										<xsl:text>; </xsl:text>
									</xsl:otherwise>
								</xsl:choose>
							</xsl:when>

							<xsl:when test="name()='conf-date'">
								<xsl:text>; </xsl:text>	
							</xsl:when>

							<xsl:when test="name()='conf-loc'">
								<xsl:text>. </xsl:text>	
							</xsl:when>
							

							<xsl:when test="name()='source'">
								<xsl:choose>
									<xsl:when test="substring(., string-length(.)) = '.'">
										<xsl:text> </xsl:text>
									</xsl:when>
									<xsl:when test="substring(., string-length(.)) = '!'">
										<xsl:text> </xsl:text>
									</xsl:when>
									<xsl:when test="substring(., string-length(.)) = '?'">
										<xsl:text> </xsl:text>
									</xsl:when>
									<xsl:otherwise>
										<xsl:text>. </xsl:text>
									</xsl:otherwise>
								</xsl:choose>
							</xsl:when>


							<!-- publisher-loc 변수 추가 LEE -->
							<xsl:when test="name()='publisher-loc'">							
								<xsl:text>: </xsl:text>
							</xsl:when>

							<!-- publisher-name 변수 추가 LEE -->
							<xsl:when test="name()='publisher-name'">
								<xsl:text>; </xsl:text>
							</xsl:when>
								
							<xsl:when test="name()='year'">
								<xsl:choose>
									<!-- @publication-type 이 journal일 경우 -->
									<xsl:when test="../@publication-type='journal'">    
										<xsl:text>;</xsl:text>
									</xsl:when> 
									<!-- 그외 일 경우 -->
									<xsl:otherwise>
										<xsl:text>. </xsl:text>
									</xsl:otherwise>
								</xsl:choose>
							</xsl:when>

							<xsl:when test="name()='volume'">							
								<xsl:text>:</xsl:text>						
							</xsl:when>

							<xsl:when test="name()='comment'">							
								<xsl:text></xsl:text>						
							</xsl:when>
							
							<xsl:otherwise>
								<xsl:text>. </xsl:text>
							</xsl:otherwise>
						</xsl:choose>	
						<!-- 접미사 출력 종료 -->

					</xsl:for-each>

							
			</xsl:element>

		</xsl:for-each>
	</xsl:template>

	<xsl:template name="supplemental">

		<xsl:element name="a">
			<xsl:variable name="objURI"><xsl:value-of select="/article/body/sec/supplementary-material/@*[namespace-uri()='http://www.w3.org/1999/xlink' and local-name()='href']" /></xsl:variable>
			<xsl:attribute name="href"><xsl:value-of select="concat('/upload/thumbnails/', substring($objURI, 18),'.pdf')" /></xsl:attribute>
			<xsl:text>Supplemental Material </xsl:text>
			<xsl:apply-templates select="/article/body/sec/supplementary-material/label" />
		</xsl:element>

	</xsl:template>

	<xsl:template match="italic">
		<em><xsl:apply-templates /></em>
	</xsl:template>

	<xsl:template match="bold">
		<strong><xsl:apply-templates /></strong>
	</xsl:template>





	<xsl:template match="/">
		<t:test xmlns:t="http://www.ncbi.nlm.nih.gov/ns/test" xmlns="http://www.w3.org/1999/xhtml">
			<t:title>
				<xsl:value-of select="$title" />
			</t:title>
			<t:citation>
				<xsl:value-of select="$journal" />.<xsl:value-of select="$year" />;<xsl:value-of select="$volume" /><xsl:text>(</xsl:text><xsl:value-of select="$issue" /><xsl:text>)</xsl:text>
				
				
				
			</t:citation>
			<t:links>
				<a href="/articles/archive.php" class="navlink">Journal List</a>
				<a class="navlink" href="/"><xsl:value-of select="$journal" /></a>
				<xsl:element name="a">
				  <xsl:attribute name="href"><xsl:text>/current?vol=</xsl:text><xsl:value-of select="$volume" /><xsl:text>&amp;no=</xsl:text><xsl:value-of select="$issue" /></xsl:attribute>
				  <xsl:value-of select="$journal" />.<xsl:value-of select="$year" />;<xsl:value-of select="$volume" /><xsl:text>(</xsl:text><xsl:value-of select="$issue" /><xsl:text>)</xsl:text>
				</xsl:element>
				<!--<a class="navlink" href="http://www.ncbi.nlm.nih.gov/pmc/issues/204821/">v.<xsl:value-of 
					select="$volume"/>; <xsl:value-of select="$year"/></a> -->
			</t:links>
			<t:alt-formats>
				<!--<a href="http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3479416/" class="">Article</a> -->
				<!--<a href="http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3479416/epub/" 
					class="">ePub (beta)</a> -->
				<xsl:element name="a">
				  <xsl:attribute name="href"><xsl:value-of select="concat('/upload/',string($pub_id),'.pdf')" /></xsl:attribute>
				  <xsl:text>Article PDF</xsl:text>
				</xsl:element>
			</t:alt-formats>

			<t:content>

				<article data-type="main">
					<!-- 저널 이미지 제거 -->
					<!--<div class="jrb">
						<div class="t"><xsl:value-of select="$journal" /></div>
						<div class="p"><xsl:value-of select="$publisher" /></div>
					</div>-->
					<header class="fm-sec">
						<h1 class="content-title"><xsl:copy-of select="$title" /></h1>
						<!-- 저자명과 저자 정보 제거 -->
						<!--<p class="contribs"><xsl:call-template name="authors" /></p>
						<p><a href="#__ffn_sectitle">Additional article information</a></p>-->
					</header>
					<div class="sec">
						<h2 class="head no_bottom_margin" id="__ffn_sectitle">Article Information</h2>
						<div class="fm-sec">
							<div class="fm-citation half_rhythm no_top_margin clearfix">
								<div class="small">
									<div class="inline_block nine_col va_top">
										<div>
											<div>
												<span class="citation-version" />
												<span class="citation-abbreviation"><xsl:value-of select="$journal" /><xsl:text>.</xsl:text></span><span class="citation-publication-date"><xsl:value-of select="$year" />;</span><span class="citation-volume"><xsl:value-of select="$volume" /></span><span class="citation-flpages">(</span><span class="citation-issue"><xsl:value-of select="$issue" /></span><span class="citation-flpages">)</span>:<span class="citation-flpages"><xsl:value-of select="$fpage" /></span>-<span class="citation-flpages"><xsl:value-of select="$lpage" /></span>
											</div>
											<div>
												<span class="fm-vol-iss-date">
													Published online
													<xsl:value-of select="$year" />
													<xsl:text> </xsl:text>
													<xsl:choose>
														<xsl:when test="$month='01' or $month='1' ">
															January
														</xsl:when>
														<xsl:when test="$month='02' or $month='2' ">
															February
														</xsl:when>
														<xsl:when test="$month='03' or $month='3' ">
															March
														</xsl:when>
														<xsl:when test="$month='04' or $month='4' ">
															April
														</xsl:when>
														<xsl:when test="$month='05' or $month='5' ">
															May
														</xsl:when>
														<xsl:when test="$month='06' or $month='6'">
															June
														</xsl:when>
														<xsl:when test="$month='07' or $month='7'">
															July
														</xsl:when>
														<xsl:when test="$month='08' or $month='8' ">
															August
														</xsl:when>
														<xsl:when test="$month='09' or $month='9' ">
															September
														</xsl:when>
														<xsl:when test="$month='10' ">
															October
														</xsl:when>
														<xsl:when test="$month='11' ">
															November
														</xsl:when>
														<xsl:when test="$month='12' ">
															December
														</xsl:when>
														<xsl:otherwise>
															<xsl:value-of select="$month" />
														</xsl:otherwise>
													</xsl:choose>

													<xsl:text> </xsl:text>

													<xsl:value-of select="$day" />
													.
												</span>
												<span class="doi">
													doi:
													<xsl:text> </xsl:text>
													<xsl:element name="a">
														<xsl:attribute name="href">http://dx.doi.org/<xsl:value-of select="$doi" /></xsl:attribute>
														<xsl:attribute name="target">pmc_ext</xsl:attribute>
														<xsl:attribute name="onclick">focuswin('pmc_ext')</xsl:attribute>
														<xsl:text>http://dx.doi.org/</xsl:text>
														<xsl:value-of select="$doi" />
													</xsl:element>
												</span>
											</div>
										</div>
									</div>

								</div>
							</div>
							<div class="half_rhythm">
								<div class="contrib-group fm-author">
									<xsl:call-template name="search_author" />
								</div>
							</div>
							<div class="fm-panel small half_rhythm">
								<div class="fm-authors-info fm-panel half_rhythm">
									<xsl:call-template name="aff" />
								</div>
								<div class="fm-article-notes fm-panel half_rhythm">
									<xsl:if test="/article/front/article-meta/history">
										<div class="fm-pubdate half_rhythm">
											Received
											<xsl:text> </xsl:text>
											<xsl:choose>
												<xsl:when test="$received_month='01' or $received_month='1' ">
													January
												</xsl:when>
												<xsl:when test="$received_month='02' or $received_month='2' ">
													February
												</xsl:when>
												<xsl:when test="$received_month='03' or $received_month='3' ">
													March
												</xsl:when>
												<xsl:when test="$received_month='04' or $received_month='4' ">
													April
												</xsl:when>
												<xsl:when test="$received_month='05' or $received_month='5' ">
													May
												</xsl:when>
												<xsl:when test="$received_month='06' or $received_month='6' ">
													June
												</xsl:when>
												<xsl:when test="$received_month='07' or $received_month='7' ">
													July
												</xsl:when>
												<xsl:when test="$received_month='08' or $received_month='8' ">
													August
												</xsl:when>
												<xsl:when test="$received_month='09' or $received_month='9' ">
													September
												</xsl:when>
												<xsl:when test="$received_month='10' ">
													October
												</xsl:when>
												<xsl:when test="$received_month='11' ">
													November
												</xsl:when>
												<xsl:when test="$received_month='12' ">
													December
												</xsl:when>
												<xsl:otherwise>
													<xsl:value-of select="$received_month" />
												</xsl:otherwise>
											</xsl:choose>
											<xsl:text> </xsl:text>
											<xsl:value-of select="$received_day" />
											<xsl:text>, </xsl:text>
											<xsl:value-of select="$received_year" />
											; Accepted
											<xsl:text> </xsl:text>
											<xsl:choose>
												<xsl:when test="$accept_month='01' or $accept_month='1' ">January</xsl:when>
												<xsl:when test="$accept_month='02' or $accept_month='2' ">February</xsl:when>
												<xsl:when test="$accept_month='03' or $accept_month='3' ">March</xsl:when>
												<xsl:when test="$accept_month='04' or $accept_month='4' ">April</xsl:when>
												<xsl:when test="$accept_month='05' or $accept_month='5' ">May</xsl:when>
												<xsl:when test="$accept_month='06' or $accept_month='6'">June</xsl:when>
												<xsl:when test="$accept_month='07' or $accept_month='7'">July</xsl:when>
												<xsl:when test="$accept_month='08' or $accept_month='8' ">August</xsl:when>
												<xsl:when test="$accept_month='09' or $accept_month='9' ">September</xsl:when>
												<xsl:when test="$accept_month='10' ">October</xsl:when>
												<xsl:when test="$accept_month='11' ">November</xsl:when>
												<xsl:when test="$accept_month='12' ">December</xsl:when>
												<xsl:otherwise>
													<xsl:value-of select="$received_month" />
												</xsl:otherwise>
											</xsl:choose>
											<xsl:text> </xsl:text>
											<xsl:value-of select="$accept_day" />
											<xsl:text>, </xsl:text>
											<xsl:value-of select="$accept_year" />
											.
										</div>
									</xsl:if>
								</div>

								<div class="fm-cpl-info fm-panel half_rhythm">									
									<div class="fm-copyright half_rhythm">
										Copyright <xsl:value-of select="$copyright_statement" /><br/> This is an Open Access article distributed under the terms of
										the Creative Commons Attribution License (
										<a href="http://creativecommons.org/licenses/by/2.0" target="pmc_ext"
											onclick="focuswin('pmc_ext')">http://creativecommons.org/licenses/by/2.0</a>
										), which permits unrestricted use, distribution, and
										reproduction in any medium, provided the original work is
										properly cited.
									</div>
								</div>
							</div>							
						</div>
					</div>
					<xsl:if test="/article/front/article-meta/abstract">
						<div id="__abstractid453541" class="sec">
							<h2 class="head no_bottom_margin" id="__abstractid453541title">Abstract</h2>
							<!--article-meta -->
							<div>
								<xsl:call-template name="abstract" />
							</div>
							<xsl:if test="/article/front/article-meta/kwd-group">
								<div class="sec">
									<strong class="kwd-title">Keywords: </strong>
									<span class="kwd-text">
										<xsl:call-template name="keywords" />
									</span>
								</div>
							</xsl:if>
						</div>
					</xsl:if>
					<div>
						<xsl:call-template name="body" />

						<xsl:if test="/article/body/sec/supplementary-material">
							<xsl:call-template name="supplemental" />
						</xsl:if>

					</div>

					<xsl:if test="/article/back/ack">
						<div class="sec">
							<h2 class="head no_bottom_margin">Acknowledgement</h2>
							<p>
								<xsl:value-of select="$ack" />
							</p>
						</div>
					</xsl:if>
					<xsl:if test="/article/back/fn-group">
						<div class="fm-sec half_rhythm small">
							<h2 class="head no_bottom_margin">Footnotes</h2>
							<xsl:for-each select="/article/back/fn-group/fn">
								<xsl:copy-of select="." />								
							</xsl:for-each>						
						</div>
					</xsl:if>					
					<div class="sec">
						<h2 class="head no_bottom_margin">References</h2>
						<div class="ref-list-sec sec" id="reference-list">
							<ul class="first-line-outdent">
								<xsl:call-template name="ref" />
							</ul>
						</div>
					</div>
				</article>

				<xsl:call-template name="figures_and_tables" />

			</t:content>

		</t:test>


	</xsl:template>


</xsl:stylesheet>
