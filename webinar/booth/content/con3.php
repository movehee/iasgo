<table class="tblDef sponsor">
    <colgroup>
        <col style="width: 15%;">
        <col style="width: *;">
        <col style="width: 30%;">
    </colgroup>
    <tbody>
        <?
        $query = "select * from booth where del='N' order by booth_sid asc, id asc";
        $result=$conn->query($query);
        if(DB::isError($result)) die($result->getMessage());
        while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
        ?>
            <tr>
                <th><?=$d['id']?></th>
                <td><?=$d['title']?></td>
                <td>
                    <a href="/load/booth/index.php?booth_sid=<?=$d['sid']?>" class="Load_Base Booth_cnt" Wsize='1302'  Hsize='822' Tsize='3%' key="1">
                        <img src="<?=$_Azure['link']?>upload/booth/<?=$d['logo_file']?>" alt="">
                    </a>
                </td>
            </tr>
        <?}?>
    </tbody>
</table>