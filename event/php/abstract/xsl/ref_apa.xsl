<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  xmlns:mml="http://www.w3.org/1998/Math/MathML"
  exclude-result-prefixes="xlink"> 

<xsl:template match="article-meta" mode="article-no">  
	<xsl:apply-templates select="/custom-abbr" />
	<xsl:text> </xsl:text>
	<xsl:if test="volume">
		<xsl:text>Vol. </xsl:text>
		<xsl:apply-templates select="volume" />
	</xsl:if>
	
	<xsl:if test="issue">
		<xsl:text>, No. </xsl:text>
		<xsl:apply-templates select="issue" />
	</xsl:if>
	
	
</xsl:template>



<xsl:template match="article-meta" mode="article-citation">
	<xsl:apply-templates select="." mode="article-no" />	
	<xsl:if test="fpage">
		<xsl:text>, </xsl:text><xsl:apply-templates select="fpage" />
	</xsl:if>
	<xsl:if test="lpage">
		<xsl:text>-</xsl:text><xsl:apply-templates select="lpage" />
	</xsl:if>	 
	<xsl:if test="(//pub-date)[1]/month">
		<xsl:text>, </xsl:text>
		<xsl:apply-templates select="(//pub-date)[1]/month" mode="map" />
	</xsl:if>	
	<xsl:if test="(//pub-date)[1]/year">
		<xsl:text>, </xsl:text>
		<xsl:apply-templates select="(//pub-date)[1]/year" />
	</xsl:if>	
</xsl:template>

<xsl:template match="ref-list" mode="back-ref-list">
	<div class="ref-list-sec sec">
		<h2 class="head no_bottom_margin" id="__secReferences">References</h2>
		<xsl:for-each select="ref">
			<xsl:element name="div">
				<xsl:attribute name="class">ref-cit-blk half_rhythm</xsl:attribute>
				<xsl:attribute name="id"><xsl:value-of select="@id" /></xsl:attribute>								
				<xsl:apply-templates />
			</xsl:element>			
		</xsl:for-each>		
		
		<!-- 참고문헌의 AJAX를 위한 폼 만들기 action, method, onsubmit은 큰 의미가 없음 jQuery로 직렬화 해서 전송  -->
		<form id="ref_value_list" name="ref_value_list" method="post" action="pubreader_ref.php" onsubmit="return false;">
			<xsl:if test="/db-number">
				<xsl:element name="input">								
				<!-- 논문의 번호 -->
					<xsl:attribute name="id">article_id_number</xsl:attribute>
					<xsl:attribute name="name">number</xsl:attribute>
					<xsl:attribute name="type">hidden</xsl:attribute>					
					<xsl:attribute name="value"><xsl:value-of select="/db-number" /></xsl:attribute>
				</xsl:element>
			</xsl:if>						
			<!-- 참고 문헌의 태그를 순환 -->
			<xsl:for-each select="ref">
				<!-- 히든 타입의 참고 문헌의 아이디를 갖고 있는 태그를 만든다. -->
				<xsl:element name="input">
					<xsl:attribute name="type">hidden</xsl:attribute>
					<xsl:attribute name="value"><xsl:value-of select="@id" /></xsl:attribute>													
					<xsl:attribute name="name">id[]</xsl:attribute>
				</xsl:element>			
			</xsl:for-each>		
		</form>
	</div>
</xsl:template>
<xsl:template match="conf-name" mode="ref">
		<xsl:if test="not(../person-group[@person-group-type='editor'])">
			<xsl:choose>
				<xsl:when test="contains(.,'at:')">
					<xsl:text> </xsl:text>
				</xsl:when>
				<xsl:otherwise>
					<xsl:text>In : </xsl:text>
				</xsl:otherwise>
			</xsl:choose>						
		</xsl:if>

		<xsl:apply-templates/>

		<xsl:choose>			
			<xsl:when test="following-sibling::*[1][name()='year'] | following-sibling::*[1][name()='conf-date']">    
				<xsl:text>; </xsl:text>
			</xsl:when>			
			<!-- 그외 일 경우 -->
			<xsl:otherwise>
				<xsl:text>. </xsl:text>	
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="conf-date" mode="ref">
		<xsl:apply-templates/>
		<xsl:text>; </xsl:text>	
	</xsl:template>

	<xsl:template match="conf-loc" mode="ref">
		<xsl:apply-templates/>
		<xsl:choose>			
			<xsl:when test="following-sibling::*[1][name()='year'] | following-sibling::*[1][name()='conf-date']">    
				<xsl:text>; </xsl:text>
			</xsl:when>			
			<!-- 그외 일 경우 -->
			<xsl:otherwise>
				<xsl:text>. </xsl:text>	
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<!-- 시작 페이지일 경우 -->
	<xsl:template match="fpage" mode="ref">		
		<xsl:choose>
			<!-- @publication-type 이 confproc 경우 -->
			<xsl:when test="../@publication-type='confproc'">    
				<xsl:text>pp. </xsl:text>
			</xsl:when>
			<xsl:when test="../@publication-type='journal'">    
				<xsl:text>:</xsl:text>
			</xsl:when>
			<xsl:when test="../@publication-type='book'">    
				<xsl:text>pp. </xsl:text>
			</xsl:when>			
			<!-- 그외 일 경우 -->
			<xsl:otherwise>
				<xsl:text></xsl:text>
			</xsl:otherwise>
		</xsl:choose><xsl:apply-templates/>
		<xsl:choose>			
			<xsl:when test="not(following-sibling::*[1])">    
				<xsl:text>.</xsl:text>
			</xsl:when>
			<!-- 그외 일 경우 -->
			<xsl:otherwise>
				<xsl:text></xsl:text>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="lpage" mode="ref">
		<xsl:text>–</xsl:text>																
		<xsl:apply-templates/>.
	</xsl:template>

	<xsl:template match="volume" mode="ref">	
		<xsl:apply-templates/>
		<xsl:text></xsl:text>						
	</xsl:template>

	<!-- 저널의 호 표시 -->
	<xsl:template match="issue" mode="ref">	
		<xsl:text>(</xsl:text>						
		<xsl:apply-templates/>		
		<xsl:text>)</xsl:text>
	</xsl:template>

	<xsl:template match="year" mode="ref">	
		<xsl:apply-templates/>
		<xsl:text>. </xsl:text>
											
	</xsl:template>


	<!-- publisher-loc 변수 추가 LEE -->
	<xsl:template match="publisher-loc" mode="ref">			
		<xsl:apply-templates/>
		<xsl:text>. </xsl:text>
	</xsl:template>

	<!-- publisher-name 변수 추가 LEE -->
	<xsl:template match="publisher-name" mode="ref">
		<xsl:apply-templates/>		
		<xsl:choose>			
			<xsl:when test="../@publication-type='book' and not(following-sibling::*[1][name()='year'])">    
				<xsl:text>. </xsl:text>
			</xsl:when>			
			<!-- 그외 일 경우 -->
			<xsl:otherwise>
				<xsl:text>; </xsl:text>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<!-- publisher-name 변수 추가 LEE -->
	<xsl:template match="source" mode="ref">
		<xsl:apply-templates/>		
		<xsl:text>. </xsl:text>		
	</xsl:template>

	<!-- 참고 문헌의 기재된 저자 출력 -->
	<xsl:template match="person-group" mode="ref">		
		<!-- 사람이름의 갯수를 계산 마지막 사람의 판단에 필요 -->
		<xsl:variable name="name-count"><xsl:value-of select="count(name)"/></xsl:variable>
		
		<!-- 컨퍼런스 명이 기재되어 있는 경우 사람 그룹이 에디터일 경우 -->
		<xsl:if test="../conf-name and @person-group-type='editor'">
			<xsl:choose>
				
				<xsl:when test="contains(.,'at:')">
					<xsl:text> </xsl:text>
				</xsl:when>
				<xsl:otherwise>
					<xsl:text>In : </xsl:text>
				</xsl:otherwise>
			</xsl:choose>						
		</xsl:if>

		<!-- name 과 etal( ,et al) 그리고 collab(연구소) -->
		<xsl:for-each select="name | etal | collab">
			<xsl:if test="position()!=1 and name()='collab'">; </xsl:if>	


			<xsl:if test="position()=1">				
				<xsl:if test="parent::node()[@person-group-type='editor']" >
					(Ed<xsl:text>. </xsl:text>					
				</xsl:if>								
			</xsl:if>

			<xsl:if test="position()=1"><xsl:apply-templates select="surname"/>, <xsl:apply-templates select="given-names" /></xsl:if>
			<xsl:if test="count(name) > 0">.</xsl:if>

			<xsl:if test="position()=last() and count(../name | ../etal | ../collab) > 1">and </xsl:if>
			
			<xsl:if test="position()>1"><xsl:apply-templates select="given-names" /><xsl:text> </xsl:text><xsl:apply-templates select="surname"/></xsl:if>
			
			<xsl:if test="name()='name' and position()!=$name-count"><xsl:text>, </xsl:text></xsl:if>
			<xsl:if test="position()=1 and name()='collab' and count(name | etal | collab) > 0">, </xsl:if>

			<xsl:if test="position()=last()">
				<xsl:if test="parent::node()[@person-group-type='editor']" >
					<xsl:text>)</xsl:text>					
				</xsl:if>	
				<xsl:text>. </xsl:text>
			</xsl:if>			

		</xsl:for-each>		
	</xsl:template>



	<!-- 인용문의 하위 정보만 해당 -->
	<xsl:template match="*" mode="ref">		
		<xsl:apply-templates select="." />
		<xsl:call-template name="ref-end">
			<xsl:with-param name="value" select="." />			
		</xsl:call-template>
	</xsl:template>

						

	<xsl:template match="mixed-citation | element-citation | nlm-citation | citation">
		<xsl:apply-templates mode="ref"/>		
	</xsl:template>

	 <!-- 레퍼런스 전용 태그 처리 -->
	<xsl:template match="collab" >			
		<xsl:apply-templates />
	</xsl:template>

	<xsl:template match="etal" >, et al</xsl:template>

	<!-- 참고문헌의 이름의 표시 템플릿 -->
	<xsl:template match="person-group/name">				
		<xsl:if test="prefix"><xsl:value-of select="prefix"/><xsl:text> </xsl:text></xsl:if><!-- Mr 나 Ms 표시 -->
		<xsl:value-of select="surname"/><!-- 성 -->
		<xsl:if test="surname"><xsl:text> </xsl:text><xsl:value-of select="given-names"/></xsl:if><!-- 이름 -->
		<xsl:if test="surfix"><xsl:text> </xsl:text><xsl:value-of select="surfix"/></xsl:if><!-- Jr 나 2세표시 -->			
	</xsl:template>
	
	<!-- 참고 문헌에 마침표 확인-->
  <xsl:template name="ref-end">
    <xsl:param name="value" />    
	<xsl:choose>
		<xsl:when test="substring($value, string-length($value)) = '.'">
			<xsl:text> </xsl:text>
		</xsl:when>
		<xsl:when test="substring($value, string-length($value)) = '!'">
			<xsl:text> </xsl:text>
		</xsl:when>
		<xsl:when test="substring($value, string-length($value)) = '?'">
			<xsl:text> </xsl:text>
		</xsl:when>
		<xsl:when test="substring($value, string-length($value)) = ';'">
			<xsl:text> </xsl:text>
		</xsl:when>
		<xsl:when test="substring($value, string-length($value)) = ':'">
			<xsl:text> </xsl:text>
		</xsl:when>
		<xsl:otherwise>
			<xsl:text>. </xsl:text>
		</xsl:otherwise>
	</xsl:choose>
  </xsl:template>
	

</xsl:stylesheet>