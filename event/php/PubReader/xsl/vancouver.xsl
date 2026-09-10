<!--
<?xml version="1.0" encoding="UTF-8"?>

  This work is in the public domain and may be reproduced, published or
  otherwise used without the permission of the National Library of Medicine (NLM).

  We request only that the NLM is cited as the source of the work.

  Although all reasonable efforts have been taken to ensure the accuracy and
  reliability of the software and data, the NLM and the U.S. Government  do
  not and cannot warrant the performance or results that may be obtained  by
  using this software or data. The NLM and the U.S. Government disclaim all
  warranties, express or implied, including warranties of performance,
  merchantability or fitness for any particular purpose.
-->

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  xmlns:mml="http://www.w3.org/1998/Math/MathML"
  exclude-result-prefixes="xlink"> 
	
	<xsl:import href="format.xsl" />
	<xsl:import href="function.xsl" />
	<xsl:import href="fn_label.xsl" />
	<xsl:import href="default.xsl" />
	<xsl:import href="misc.xsl" />
	<xsl:import href="ref_ven.xsl" />
	<xsl:import href="metadata.xsl" />
	<xsl:import href="article-meta.xsl" />
	<xsl:import href="front.xsl" />
	<xsl:import href="back.xsl" />
	<xsl:import href="legend.xsl" />	
	<xsl:import href="content.xsl" />
	<xsl:import href="html.xsl" />
	
   

   <xsl:strip-space elements="*"/>

  <!-- Space is preserved in all elements allowing #PCDATA -->
  <xsl:preserve-space
    elements="abbrev abbrev-journal-title access-date addr-line
              aff alt-text alt-title article-id article-title
              attrib award-id bold chapter-title chem-struct
              collab comment compound-kwd-part compound-subject-part
              conf-acronym conf-date conf-loc conf-name conf-num
              conf-sponsor conf-theme contrib-id copyright-holder
              copyright-statement copyright-year corresp country
              date-in-citation day def-head degrees disp-formula
              edition elocation-id email etal ext-link fax fpage
              funding-source funding-statement given-names glyph-data
              gov inline-formula inline-supplementary-material
              institution isbn issn-l issn issue issue-id issue-part
              issue-sponsor issue-title italic journal-id
              journal-subtitle journal-title kwd label license-p
              long-desc lpage meta-name meta-value mixed-citation
              monospace month named-content object-id on-behalf-of
              overline p page-range part-title patent person-group
              phone prefix preformat price principal-award-recipient
              principal-investigator product pub-id publisher-loc
              publisher-name related-article related-object role
              roman sans-serif sc season self-uri series series-text
              series-title sig sig-block size source speaker std
              strike string-name styled-content std-organization
              sub subject subtitle suffix sup supplement surname
              target td term term-head tex-math textual-form th
              time-stamp title trans-source trans-subtitle trans-title
              underline uri verse-line volume volume-id volume-series
              xref year

              mml:annotation mml:ci mml:cn mml:csymbol mml:mi mml:mn 
              mml:mo mml:ms mml:mtext"/>

<!-- To reduce dependency on a DTD for processing, we declare
       a key to use instead of the id() function. -->
  <xsl:key name="element-by-id" match="*[@id]" use="@id"/>

  <!-- Enabling retrieval of cross-references to objects -->
  <xsl:key name="xref-by-rid" match="xref" use="@rid"/>
  <xsl:key name="fig-by-id" match="fig | fig-group" use="@id"/> 
  <xsl:key name="table-by-id" match="table-wrap | table-wrap-group" use="@id"/>
  <xsl:key name="sup-in-p" match="xref" use="@rid"/>   
  <xsl:output  method="html"/>   
  

</xsl:stylesheet>
