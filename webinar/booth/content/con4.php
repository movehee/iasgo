<div class="movie">
    <div class="note">
        Taking place in Exhibition Hall D 15-minute presentations on the AI Stage will offer participants the chance to learn about the latest radiology AI innovations. Presentations also are available the day after each of the onsite presentations.<br>
      <a href="https://virtual.aocr2022.org/booth/AOCR 2022_KCR 2022_Onsite Presentatin Time Table.pdf" target="_blank">Onsite Presentation Time Table</a>
    </div>

    <?
    $query = "select * from booth where del='N' and ai_stage!='' order by booth_sid asc, sort_num asc";
    $result=$conn->query($query);
    if(DB::isError($result)) die($result->getMessage());
    while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {
    ?>
    <?php if($d['ai_stage'] && $d['ai_stage_open'] == 'Y'):?>
    <dl class="vod">
        <dt class="view"><a href="#" class="trigger"><?=$d['ai_stage_title']?></a></dt>
        <dd class="toggleCon" style="display: block;">
            <div class="vodArea">
                <iframe src="<?=$d['ai_stage']?>" width="100%" height="100%" allow="autoplay" frameborder="0"  fullscreen allowfullscreen></iframe>
            </div>
        </dd>
    </dl>
    <?php endif;?>

    <?php if($d['ai_stage2'] && $d['ai_stage_open2'] == 'Y') :?>
    <dl class="vod">
        <dt class="view"><a href="#" class="trigger"><?=$d['ai_stage_title2']?></a></dt>
        <dd class="toggleCon" style="display: block;">
            <div class="vodArea">
                <iframe src="<?=$d['ai_stage2']?>" width="100%" height="100%" allow="autoplay" frameborder="0"  fullscreen allowfullscreen></iframe>
            </div>
        </dd>
    </dl>
    <?php endif;?>



    <?}?>
</div>
<!-- //movie -->