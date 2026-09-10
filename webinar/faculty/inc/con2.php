<?
    $query = "select b.* from faculty_matching a join faculty_tbl b on a.faculty_sid=b.sid where a.faculty_kind='4' ";
	if($search_keyword){
		$query .= " and (faculty_name like '%$search_keyword%' or faculty_aff like '%$search_keyword%' )";
	}
	$query .= " group by b.sid order by SUBSTRING_INDEX(b.faculty_name,' ',-1) asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
?>
<script>
    function view(faculty_sid) {
        // alert("/load/faculty_session_list.php?type=chair&faculty_sid="+faculty_sid)
        $.colorbox({href:"/load/faculty_session_list.php?type=chair&faculty_sid="+faculty_sid,iframe:true, transition:"fade", width:800, maxWidth:"100%", height:600, maxHeight:"100%", top:200,speed:150,fixed:false,closeButton:false,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true});
    }    
</script>

<div class="tm30">
    * Total : <span class="fcRed"><?=$result->numRows()?></span>
    <span class="fr">* Last name alphabetical order</span>
</div>

<div class="speaker">
    <table class="tblDef">
        <colgroup>
            <col style="width: 15%;">
            <col style="width: *;">
            <col style="width: 15%;">
        </colgroup>
        <tbody>
            <?
            while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
            ?>
            <tr onclick="view(<?=$d['sid']?>); return false;">
                <td><?=str_ireplace($search_keyword,"<span style='background:#FFEB3B;color:#001dff;'>".$search_keyword."</span>",stripslashes($d['faculty_name']))?></td>
                <td><?=str_ireplace($search_keyword,"<span style='background:#FFEB3B;color:#001dff;'>".$search_keyword."</span>",stripslashes($d['faculty_aff']))?></td>
                <td><?=$d['faculty_country']?></td>
            </tr>
            <?}?>
        </tbody>
    </table>
</div>
<!-- //speaker -->