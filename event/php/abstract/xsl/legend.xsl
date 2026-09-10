<xsl:stylesheet version="1.0"
xmlns:xs="http://www.w3.org/2001/XMLSchema"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  xmlns:mml="http://www.w3.org/1998/Math/MathML"
  exclude-result-prefixes="xlink">
  
  	<xsl:template name="assgin-object-div-id">
		<xsl:attribute name="id"><xsl:apply-templates select="@id" /></xsl:attribute>
		<xsl:attribute name="co-legend-rid">lgnd_<xsl:value-of select="@id" /></xsl:attribute>		
  	</xsl:template>
  	
  	<xsl:template name="set-table-thum-ext">
		<xsl:choose>
			<xsl:when test="/table-ext"><xsl:value-of select="/table-ext" /></xsl:when>
			<xsl:otherwise><xsl:text>.gif</xsl:text></xsl:otherwise>
		</xsl:choose>
	</xsl:template>
  	
  	<xsl:template name="load-img-by-id">
		<xsl:element name="img">
			<xsl:attribute name="class">small-thumb</xsl:attribute>
			<xsl:attribute name="alt"><xsl:apply-templates select="../label" /></xsl:attribute>
			<xsl:attribute name="title"><xsl:apply-templates select="../label" /></xsl:attribute>
			<xsl:attribute name="src">
				<xsl:apply-templates select="//thumb-path" />
				<xsl:value-of select="@id" />
				<xsl:call-template name="set-table-thum-ext" />
			</xsl:attribute>
			<xsl:attribute name="src-large">
				<xsl:apply-templates select="//thumb-path" />
				<xsl:value-of select="@id" />
				<xsl:call-template name="set-table-thum-ext" />
			</xsl:attribute>
		</xsl:element>
  	</xsl:template>
  	
  	<xsl:template name="assign-lngd-name">
  		<xsl:choose>
  			<xsl:when test="self::fig | self::fig-group"><xsl:text>fig</xsl:text></xsl:when>  				
  			<xsl:when test="self::table-wrap | self::table-wrap-group"><xsl:text>table</xsl:text></xsl:when>
  		</xsl:choose>  		
  	</xsl:template>
  	
  	
  	<xsl:template name="assign-para-class">
  		<xsl:choose>
  			<xsl:when test="self::fig | self::fig-group"><xsl:text>fig</xsl:text></xsl:when>  				
  			<xsl:when test="self::table-wrap | self::table-wrap-group"><xsl:text>table-wrap</xsl:text></xsl:when>
  		</xsl:choose>  		
  	</xsl:template>
  	
  	<xsl:template name="assign-object-id" > 
		<xsl:attribute name="href">#<xsl:apply-templates select="@id" /></xsl:attribute>
		<xsl:attribute name="target"><xsl:call-template name="assign-lngd-name"/></xsl:attribute>
		<xsl:attribute name="rid-figpopup"><xsl:apply-templates select="@id" /></xsl:attribute>
		<xsl:attribute name="rid-ob">ob-<xsl:apply-templates select="@id" /></xsl:attribute>		
		<xsl:attribute name="co-legend-rid">lgnd_<xsl:apply-templates select="@id" /></xsl:attribute>
  </xsl:template>
  	
  	
  
	<xsl:template match="fig | fig-group | table-wrap | table-wrap-group" mode="para-mode">
		
		<xsl:element name="div">
			<xsl:attribute name="class"><xsl:call-template name="assign-para-class" /> iconblock ten_col whole_rhythm clearfix</xsl:attribute>
			<xsl:call-template name="assgin-object-div-id" />			
			<xsl:element name="a">
				<xsl:attribute name="class"><xsl:call-template name="assign-lngd-name"/> img_link icnblk_img figpopup</xsl:attribute>
				<xsl:call-template name="assign-object-id" />	
				
				<xsl:choose>
					<xsl:when test="graphic"><xsl:apply-templates select="graphic" mode="para" /></xsl:when>
					<xsl:otherwise><xsl:call-template name="load-img-by-id" /></xsl:otherwise>
				</xsl:choose>				
									
			</xsl:element>

			<xsl:element name="div">
				<xsl:attribute name="class">icnblk_cntnt</xsl:attribute>			
				<xsl:attribute name="id">lgnd_<xsl:value-of select="@id" /></xsl:attribute>	
				<div>		
					<xsl:element name="a">
						<xsl:attribute name="class">figpopup</xsl:attribute>
						<xsl:call-template name="assign-object-id" />					
						<xsl:apply-templates select="label" />
					</xsl:element>						
				</div>					
				<div><xsl:apply-templates select="caption" /></div>														
			</xsl:element>				
		</xsl:element>
		
	</xsl:template>
	
	<xsl:template match="graphic | inline-graphic" mode="popup">
		
		<div class="figure">
			<xsl:element name="a">
				<xsl:attribute name="class">inline_block ts_canvas</xsl:attribute>
				<xsl:attribute name="href"><xsl:call-template name="assign-src-url" /></xsl:attribute>
				<xsl:attribute name="target">tileshopwindow</xsl:attribute>
				<div class="ts_bar small" title="Click on image to zoom"></div>
				<xsl:apply-templates select="." mode="popup-img" />
			</xsl:element>
		</div>
	</xsl:template>
	
	<xsl:template match="fig-group" mode="popup">
		<xsl:element name="div">
			<xsl:attribute name="class">fig anchored whole_rhythm</xsl:attribute>
			<xsl:call-template name="assign-id" />
			<xsl:call-template name="show-label-title" />
			<xsl:apply-templates select="fig" mode="popup"/>
			<xsl:apply-templates select="*[not(self::title | self::label | self::fig)]"/>
		</xsl:element>
	</xsl:template>
	
	<xsl:template match="fig" mode="popup">
		<xsl:element name="div">
			<xsl:attribute name="class"><xsl:call-template name="assign-lngd-name"/> anchored whole_rhythm</xsl:attribute>
			<xsl:call-template name="assign-id" />
			<xsl:call-template name="show-label-title" />
			<xsl:apply-templates select="graphic | inline-graphic" mode="popup"/>
			<xsl:apply-templates select="*[not(self::title | self::label | self::graphic | self::inline-graphic)]"/>
		</xsl:element>
			
	</xsl:template>
	
	<xsl:template match="table-wrap-group" mode="popup">
		<xsl:element name="div">
			<xsl:attribute name="class"><xsl:call-template name="assign-lngd-name"/> anchored whole_rhythm</xsl:attribute>
			<xsl:call-template name="assign-id" />
			<xsl:call-template name="show-label-title" />
			<xsl:apply-templates select="table-wrap" mode="popup"/>
			<xsl:apply-templates select="*[not(self::title | self::label | self::table-wrap)]"/>
		</xsl:element>
	</xsl:template>
	
	<xsl:template match="table-wrap" mode="popup">
		<xsl:element name="div">
			<xsl:attribute name="class">table anchored whole_rhythm</xsl:attribute>
			<xsl:call-template name="assign-id" />
			<xsl:call-template name="show-label-title" />
			<xsl:apply-templates select="caption"/>
			<div class="large_tbl">
				<xsl:apply-templates select="table"/>
			</div>
			<xsl:apply-templates select="*[not(self::caption | self::title | self::label | self::table)]"/>
		</xsl:element>
	</xsl:template>
	
	<xsl:template match="fig | fig-group | table-wrap | table-wrap-group" mode="popup-root">
		<xsl:element name="article">
			<xsl:call-template name="assign-popup-attr" />			
			<xsl:apply-templates select="." mode="popup" />			
		</xsl:element>
	</xsl:template>
	
	<xsl:template name="show-label-title">
		<xsl:if test="label | title">
			<h3><xsl:apply-templates select="label | title" /></h3>
		</xsl:if>
	</xsl:template>
	
	<xsl:template name="assign-popup-attr">
			<xsl:attribute name="data-type"><xsl:call-template name="assign-para-class"/></xsl:attribute>
			<xsl:attribute name="id">ob-<xsl:value-of select="@id" /></xsl:attribute>
	</xsl:template>
	
	
	
</xsl:stylesheet>