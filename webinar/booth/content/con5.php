<div class="movie">
    <div class="note">
        Through the Industry Theater, you can check the contents of lectures from partnering companies.
    </div>

    <?
    $query = "select * from booth where del='N' and in_theater!='' order by booth_sid asc, sort_num asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
    ?>
    <?php if($d['in_theater'] && $d['in_theater_open'] == 'Y'):?>
    <dl class="vod">
        <dt class="view"><a href="#" class="trigger"><?=$d['in_theater_title']?></a></dt>
        <dd class="toggleCon" style="display: block;">
            <div class="vodArea">
                <iframe src="<?=$d['in_theater']?>" width="100%" height="100%" allow="autoplay" frameborder="0"  fullscreen allowfullscreen></iframe>
            </div>
        </dd>
    </dl>
    <?php endif;?>

    <?}?>

</div>
<!-- //movie -->