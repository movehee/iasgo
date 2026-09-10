<h3 class="subTit">Exhibition Overview</h3>
<table class="tblDef sponsor">
    <colgroup>
        <col style="width: 20%;">
        <col style="width: *;">
    </colgroup>
    <tbody>
        <tr>
            <th>Period</th>
            <td class="al">September 20 (Wed) – 23 (Sat)</td>
        </tr>
        <tr>
            <th>Operating Hours</th>
            <td class="al">
                September 20 (Wed), 12:30 – 17:30<br>
				September 21 (Thu) – 22 (Fri), 09:00 – 17:30<br>
				September 23 (Sat), 09:00 – 16:00The operating hours can be changed.
            </td>
        </tr>
        <tr>
            <th>Venue</th>
            <td class="al">Hall B (8,010㎡), Coex/td>
        </tr>
        <tr>
            <th>Items</th>
            <td class="al">
				<ul class="listDot">
					<li>Radiology Related Products (CT, MRI, US, etc.)</li>
					<li>IT (PACS, Medical Informatics, AI, etc.)</li>
					<li>Contrast Agents, Drugs and Pharmaceuticals</li>
					<li>Molecular Imaging</li>
					<li>Interventional Radiology and Special Procedures</li>
					<li>Publications</li>
					<li>Radiology Related Societies</li>
					<li>Other</li>
				</ul>
            </td>
        </tr>
    </tbody>
</table>


<h3 class="subTit">Exhibition Layout</h3>
<div class="map"><img src="/asset/layout/exhibition_map.png" alt=""></div>

<!-- <h3 class="subTit">Space AI</h3>
<div class="note">
    Please visit Space AI (Hall D, 3F) during the congress. Space AI brings together 24 AI companies so that participants can witness stage-of-the-art technologies in radiology AI products and softwares.
</div>
 -->
<table class="tblDef sponsor">
    <colgroup>
        <col style="width: 15%;">
        <col style="width: *;">
        <col style="width: 30%;">
    </colgroup>
    <tbody>
    <?
    $query = "select * from booth where del='N' and top='Y' order by booth_sid asc, sort_num asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
    ?>
        <tr>
            <th><?=$d['id']?></th>
            <td><?=$d['title']?></td>
            <td>
                <a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1302'  Hsize='822' Tsize='3%' key="1">
                <img src="<?=$_Azure['link']?>upload/booth/<?=$d['logo_file']?>" alt=""></a>
            </td>
        </tr>
    <?}?>
    </tbody>
</table>